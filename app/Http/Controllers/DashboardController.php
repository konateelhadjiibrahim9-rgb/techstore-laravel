<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Quote;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Services\DeliveryService;

class DashboardController extends Controller
{
    protected $deliveryService;

    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }

    /**
     * Dashboard principal avec switcher de profil
     */
    public function index(Request $request)
    {
        $profile = $request->get('profile', 'individual'); // individual | enterprise
        
        return view('dashboard.index', [
            'profile' => $profile,
            'productCategories' => ProductCategory::where('profile', $profile)->get(),
            'recentQuotes' => auth()->user()->quotes()->latest()->limit(5)->get(),
            'stats' => $this->getDashboardStats($profile),
        ]);
    }

    /**
     * Catalogue de produits par catégories
     */
    public function products(Request $request)
    {
        $category = $request->get('category');
        $profile = $request->get('profile', 'individual');
        
        $productCategories = ProductCategory::where('profile', $profile)
            ->when($category, fn($q) => $q->where('category', $category))
            ->get();
        
        return view('dashboard.products', [
            'productCategories' => $productCategories,
            'categories' => ProductCategory::where('profile', $profile)->distinct('category')->pluck('category'),
            'profile' => $profile,
        ]);
    }

    /**
     * Suivi des commandes et devis de l'utilisateur
     */
    public function myOrders()
    {
        $quotes = auth()->user()->quotes()->latest()->get();
        $orders = auth()->user()->orders()->latest()->get();
        
        return view('dashboard.my-orders', [
            'quotes' => $quotes,
            'orders' => $orders,
            'stats' => [
                'pending_quotes' => auth()->user()->quotes()->where('status', 'pending')->count(),
                'pending_orders' => auth()->user()->orders()->where('status', 'pending')->count(),
                'completed' => auth()->user()->orders()->where('status', 'completed')->count(),
            ],
        ]);
    }

    /**
     * Espace factures et garanties de l'utilisateur
     */
    public function myInvoices()
    {
        return view('dashboard.my-invoices', [
            'invoices' => auth()->user()->orders()->whereIn('status', ['paid', 'shipped', 'delivered'])->latest()->get(),
        ]);
    }

    /**
     * Formulaire de demande de devis
     */
    public function createQuote()
    {
        return view('dashboard.quote-form');
    }

    /**
     * Stocker une demande de devis
     */
    public function storeQuote(Request $request)
    {
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'nullable|numeric|min:0',
        ]);

        $quote = Quote::create([
            'user_id' => auth()->id(),
            'product_category_id' => null, // À adapter selon la logique métier
            'status' => 'pending',
            'reference' => 'DEV-' . strtoupper(uniqid()),
            'data' => array_merge($validated, [
                'emitter' => [
                    'name' => 'Konate El Hadji Ibrahim',
                    'title' => 'Full-Stack Developer',
                    'company' => 'TechStore',
                    'contact' => '+225 07 00 00 00 00',
                    'email' => 'contact@techstore.ci',
                ],
            ]),
            'documents' => [],
        ]);

        return redirect()->route('dashboard.my-orders')
            ->with('success', 'Votre demande de devis a été envoyée avec succès. Nous vous contacterons sous 24h.');
    }

    /**
     * Recherche globale de produits
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get();
        
        return view('dashboard.search', [
            'products' => $products,
            'query' => $query,
        ]);
    }

    /**
     * Statistiques selon le profil
     */
    private function getDashboardStats($profile)
    {
        return [
            'productCategories' => ProductCategory::where('profile', $profile)->count(),
            'quotes' => auth()->user()->quotes()->count(),
            'pending_quotes' => auth()->user()->quotes()->where('status', 'pending')->count(),
        ];
    }
}
