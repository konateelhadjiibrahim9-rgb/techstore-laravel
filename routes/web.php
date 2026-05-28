<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Livewire\Admin\ProductList;
use App\Livewire\Admin\ProductForm;
use App\Livewire\Admin\OrderList;
use App\Livewire\Admin\QuoteList;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard.index');
    }
    return redirect()->route('login');
});

// Portail de Produits - Dashboard principal
Route::prefix('dashboard')
    ->middleware(['auth'])
    ->name('dashboard.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/products', [DashboardController::class, 'products'])->name('products');
        Route::get('/my-orders', [DashboardController::class, 'myOrders'])->name('my-orders');
        Route::get('/my-invoices', [DashboardController::class, 'myInvoices'])->name('my-invoices');
        Route::get('/quote/create', [DashboardController::class, 'createQuote'])->name('quote.create');
        Route::post('/quote', [DashboardController::class, 'storeQuote'])->name('quote.store');
        Route::get('/search', [DashboardController::class, 'search'])->name('search');
    });

// Admin Dashboard - Protected for admins only
Route::prefix('dashboard')
    ->middleware(['auth', 'is.super.admin'])
    ->name('dashboard.')
    ->group(function () {
        Route::get('/products', ProductList::class)->name('products.index');
        Route::get('/products/create', ProductForm::class)->name('products.create');
        Route::get('/products/{product}/edit', ProductForm::class)->name('products.edit');
        
        Route::get('/orders', OrderList::class)->name('orders.index');
        
        Route::get('/deliveries', function () {
            return view('dashboard.deliveries');
        })->name('deliveries.index');

        Route::get('/quotes', QuoteList::class)->name('quotes.index');

        Route::get('/admins', function () {
            $users = \App\Models\User::where('role', '!=', 'user')->get();
            return view('dashboard.admins', ['users' => $users]);
        })->name('admins.index');
        
        Route::post('/admins/{user}/role', function (\Illuminate\Http\Request $request, $userId) {
            $user = \App\Models\User::find($userId);
            if ($user && $user->id !== auth()->id()) {
                $user->role = $request->role;
                $user->save();
            }
            return redirect()->route('dashboard.admins.index');
        })->name('admins.update.role');
    });

require __DIR__.'/auth.php';
