<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Component;

class AddToCart extends Component
{
    public $productId;
    public $quantity = 1;
    public $stockQuantity;

    protected $cartService;

    public function boot()
    {
        $this->cartService = app(CartService::class);
    }

    public function addToCart()
    {
        $result = $this->cartService->addProduct($this->productId, $this->quantity);
        
        if ($result['success']) {
            $this->dispatch('cartUpdated');
            $this->dispatch('showToast', message: $result['message']);
        } else {
            $this->dispatch('showToast', message: $result['message'], type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}
