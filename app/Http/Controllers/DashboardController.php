<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Quote;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
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
