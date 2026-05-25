<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\ProductList;
use App\Livewire\Admin\ProductForm;
use App\Livewire\ShoppingCart;
use App\Livewire\Checkout;
use App\Http\Controllers\PaymentController;

Route::view('/', 'welcome');

Route::get('/cart', ShoppingCart::class)->name('cart');

Route::get('/checkout', Checkout::class)
    ->middleware(['auth'])
    ->name('checkout');

Route::get('/order/confirmation/{order}', function ($order) {
    return view('order-confirmation', ['orderNumber' => $order]);
})->name('order.confirmation');

// Payment routes
Route::get('/payment/initiate/{orderId}', [PaymentController::class, 'initiatePayment'])
    ->middleware(['auth'])
    ->name('payment.initiate');

Route::get('/payment/callback', [PaymentController::class, 'handleCallback'])
    ->name('payment.callback');

Route::post('/payment/notify', [PaymentController::class, 'handleNotification'])
    ->name('payment.notify');

Route::get('/payment/status/{orderId}', [PaymentController::class, 'checkPaymentStatus'])
    ->name('payment.status');

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
