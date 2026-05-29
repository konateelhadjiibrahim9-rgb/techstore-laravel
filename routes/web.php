<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminStatsController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Api\OrderController;
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

// Customer Dashboard - Accessible par tous les utilisateurs authentifiés
Route::prefix('customer')
    ->middleware(['auth'])
    ->name('customer.')
    ->group(function () {
        Route::get('/', [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');
        Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
        Route::post('/profile', [CustomerController::class, 'updateProfile'])->name('profile.update');
    });

// API Routes - Pour frontend Django
Route::prefix('api')
    ->middleware(['auth:sanctum'])
    ->name('api.')
    ->group(function () {
        Route::prefix('customer')->group(function () {
            Route::get('/orders', [CustomerController::class, 'orders'])->name('customer.orders');
            Route::get('/profile', [CustomerController::class, 'profile'])->name('customer.profile');
            Route::post('/profile/update', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');
            Route::post('/orders', [OrderController::class, 'store'])->name('customer.orders.store');
        });

        Route::prefix('admin')->middleware(['is.super.admin'])->group(function () {
            Route::get('/stats', [AdminStatsController::class, 'index'])->name('admin.stats');
        });
    });

