<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Component;
use Livewire\WithPagination;

class ShoppingCart extends Component
{
    use WithPagination;

    protected $cartService;
    public $loading = false;

    public function boot()
    {
        $this->cartService = app(CartService::class);
    }

    public function updateQuantity($productId, $quantity)
    {
        $this->loading = true;
        $result = $this->cartService->updateQuantity($productId, $quantity);
        
        if ($result['success']) {
            $this->dispatch('cartUpdated');
        } else {
            $this->dispatch('showToast', message: $result['message'], type: 'error');
        }
        
        $this->loading = false;
    }

    public function removeProduct($productId)
    {
        $this->loading = true;
        $this->cartService->removeProduct($productId);
        $this->dispatch('cartUpdated');
        $this->loading = false;
    }

    public function clearCart()
    {
        $this->loading = true;
        $this->cartService->clearCart();
        $this->dispatch('cartUpdated');
        $this->loading = false;
    }

    public function render()
    {
        $cartItems = $this->cartService->getCartItems();
        $total = $this->cartService->getTotal();
        $totalItems = $this->cartService->getTotalItems();

        return view('livewire.shopping-cart', [
            'cartItems' => $cartItems,
            'total' => $total,
            'totalItems' => $totalItems,
        ])->layout('layouts.app');
    }
}
