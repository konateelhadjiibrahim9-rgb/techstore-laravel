<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_admins' => User::where('role', '!=', 'user')->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'low_stock_products' => Product::where('stock_quantity', '<', 10)->count(),
        ];

        $recentOrders = Order::latest()->take(5)->get();
        $lowStockProducts = Product::where('stock_quantity', '<', 10)->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStockProducts'));
    }
}
