<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminStatsResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminStatsController extends Controller
{
    public function index()
    {
        // Calculer les statistiques avec agrégats Eloquent optimisés
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_customers' => User::where('role', 'user')->count(),
            'stock_alerts_count' => Product::where('stock_quantity', '<', 10)->count(),
            'recent_orders' => Order::with(['user', 'items'])
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($order) {
                    return [
                        'id' => $order->id,
                        'total' => $order->total,
                        'status' => $order->status,
                        'created_at' => $order->created_at->format('Y-m-d H:i:s'),
                        'customer_name' => $order->user ? $order->user->name : 'N/A',
                    ];
                }),
        ];

        return AdminStatsResource::make($stats);
    }
}
