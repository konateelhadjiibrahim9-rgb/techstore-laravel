<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Component;

class CartCounter extends Component
{
    public $totalItems = 0;

    protected $cartService;

    public function boot()
    {
        $this->cartService = app(CartService::class);
    }

    public function mount()
    {
        $this->totalItems = $this->cartService->getTotalItems();
    }

    public function render()
    {
        $this->totalItems = $this->cartService->getTotalItems();
        
        return view('livewire.cart-counter', [
            'totalItems' => $this->totalItems
        ]);
    }
}
