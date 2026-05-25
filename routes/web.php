<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\ProductList;
use App\Livewire\Admin\ProductForm;
use App\Livewire\Admin\OrderList;
use App\Livewire\ShoppingCart;
use App\Livewire\Checkout;
use App\Livewire\OrderHistory;
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

Route::get('/my-orders', OrderHistory::class)
    ->middleware(['auth'])
    ->name('my-orders');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Admin redirect
Route::redirect('/admin', '/admin/dashboard');

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
        
        Route::get('/orders', OrderList::class)->name('orders.index');
        
        // Admin management (super admin only)
        Route::get('/admins', function () {
            $users = \App\Models\User::where('role', '!=', 'user')->get();
            return view('admin.admins', ['users' => $users]);
        })->middleware('is.super.admin')->name('admins.index');
        
        Route::post('/admins/{user}/role', function (\Illuminate\Http\Request $request, $userId) {
            $user = \App\Models\User::find($userId);
            if ($user && $user->id !== auth()->id()) {
                $user->role = $request->role;
                $user->save();
            }
            return redirect()->route('admin.admins.index');
        })->middleware('is.super.admin')->name('admins.update.role');
    });

require __DIR__.'/auth.php';
