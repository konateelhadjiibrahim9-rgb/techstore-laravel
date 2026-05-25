<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Component;

class ShoppingCart extends Component
{
    protected $cartService;

    public function boot()
    {
        $this->cartService = app(CartService::class);
    }

    public function updateQuantity($productId, $quantity)
    {
        $this->cartService->updateQuantity($productId, $quantity);
        $this->dispatch('cartUpdated');
    }

    public function removeProduct($productId)
    {
        $this->cartService->removeProduct($productId);
        $this->dispatch('cartUpdated');
    }

    public function clearCart()
    {
        $this->cartService->clearCart();
        $this->dispatch('cartUpdated');
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
        ]);
    }
}
