<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceRequest;
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
        $profile = $request->get('profile', 'citizen'); // citizen | enterprise
        
        return view('dashboard.index', [
            'profile' => $profile,
            'services' => Service::where('profile', $profile)->get(),
            'recentRequests' => auth()->user()->serviceRequests()->latest()->limit(5)->get(),
            'stats' => $this->getDashboardStats($profile),
        ]);
    }

    /**
     * Catalogue de services
     */
    public function services(Request $request)
    {
        $category = $request->get('category');
        $profile = $request->get('profile', 'citizen');
        
        $services = Service::where('profile', $profile)
            ->when($category, fn($q) => $q->where('category', $category))
            ->get();
        
        return view('dashboard.services', [
            'services' => $services,
            'categories' => Service::where('profile', $profile)->distinct('category')->pluck('category'),
            'profile' => $profile,
        ]);
    }

    /**
     * Suivi des demandes de l'utilisateur
     */
    public function myRequests()
    {
        $requests = auth()->user()->serviceRequests()->latest()->get();
        
        return view('dashboard.my-requests', [
            'requests' => $requests,
            'stats' => [
                'pending' => auth()->user()->serviceRequests()->where('status', 'pending')->count(),
                'in_progress' => auth()->user()->serviceRequests()->where('status', 'in_progress')->count(),
                'completed' => auth()->user()->serviceRequests()->where('status', 'completed')->count(),
                'rejected' => auth()->user()->serviceRequests()->where('status', 'rejected')->count(),
            ],
        ]);
    }

    /**
     * Espace documents de l'utilisateur
     */
    public function myDocuments()
    {
        return view('dashboard.my-documents', [
            'documents' => auth()->user()->documents()->latest()->get(),
        ]);
    }

    /**
     * Recherche globale
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $services = Service::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get();
        
        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get();
        
        return view('dashboard.search', [
            'services' => $services,
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
            'services' => Service::where('profile', $profile)->count(),
            'requests' => auth()->user()->serviceRequests()->count(),
            'pending' => auth()->user()->serviceRequests()->where('status', 'pending')->count(),
        ];
    }
}
