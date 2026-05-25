<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Component;

class AddToCart extends Component
{
    public $productId;
    public $quantity = 1;

    protected $cartService;

    public function boot()
    {
        $this->cartService = app(CartService::class);
    }

    public function addToCart()
    {
        $this->cartService->addProduct($this->productId, $this->quantity);
        
        $this->dispatch('cartUpdated');
        $this->dispatch('showToast', message: 'Produit ajouté au panier !');
    }

    public function render()
    {
        return view('livewire.add-to-cart');
    }
}
