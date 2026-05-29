<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Livewire\Admin\ProductList;
use App\Livewire\Admin\ProductForm;
use App\Livewire\Admin\OrderList;
use App\Livewire\Admin\QuoteList;

Route::get('/', function () {
    if (auth()->check() && auth()->user()->isSuperAdmin()) {
        return redirect()->route('admin.products.index');
    }
    return redirect()->route('login');
});

// Admin Dashboard - Protected for admins only
Route::prefix('admin')
    ->middleware(['auth', 'is.super.admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/products', ProductList::class)->name('products.index');
        Route::get('/products/create', ProductForm::class)->name('products.create');
        Route::get('/products/{product}/edit', ProductForm::class)->name('products.edit');
        
        Route::get('/orders', OrderList::class)->name('orders.index');
        
        Route::get('/deliveries', function () {
            return view('dashboard.deliveries');
        })->name('deliveries.index');

        Route::get('/quotes', QuoteList::class)->name('quotes.index');

        Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
        
        Route::post('/admins/{user}/role', [AdminController::class, 'updateRole'])->name('admins.update.role');
    });

require __DIR__.'/auth.php';

