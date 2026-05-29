<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Livewire\Admin\ProductList;
use App\Livewire\Admin\ProductForm;
use App\Livewire\Admin\OrderList;
use App\Livewire\Admin\QuoteList;

Route::get('/', function () {
    return redirect()->route('login');
});

// Login routes (NOT protected by admin middleware)
require __DIR__.'/auth.php';

// Admin Dashboard - Accessible par tous les admins (Admin et SuperAdmin)
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
    });

// Gestion des Administrateurs - Accessible uniquement par Super Admin
Route::prefix('admin/admins')
    ->middleware(['auth', 'is.super.admin'])
    ->name('admin.admins.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::post('/{user}/role', [AdminController::class, 'updateRole'])->name('update.role');
    });

