<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\ProductList;
use App\Livewire\Admin\ProductForm;
use App\Livewire\ShoppingCart;

Route::view('/', 'welcome');

Route::get('/cart', ShoppingCart::class)->name('cart');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Admin routes
Route::prefix('admin')
    ->middleware(['auth'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        
        Route::get('/products', ProductList::class)->name('products.index');
        Route::get('/products/create', ProductForm::class)->name('products.create');
        Route::get('/products/{product}/edit', ProductForm::class)->name('products.edit');
    });

require __DIR__.'/auth.php';
