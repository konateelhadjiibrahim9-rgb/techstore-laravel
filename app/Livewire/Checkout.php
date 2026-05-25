<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Livewire\Component;

class Checkout extends Component
{
    public $shipping_address;
    public $shipping_city;
    public $shipping_phone;
    public $notes;

    protected $cartService;

    protected $rules = [
        'shipping_address' => 'required|string|max:255',
        'shipping_city' => 'required|string|max:255',
        'shipping_phone' => 'required|string|max:20',
        'notes' => 'nullable|string',
    ];

    public function boot()
    {
        $this->cartService = app(CartService::class);
    }

    public function mount()
    {
        $cartItems = $this->cartService->getCartItems();
        
        if (empty($cartItems)) {
            return redirect()->route('cart');
        }
    }

    public function placeOrder()
    {
        $this->validate();

        $cartItems = $this->cartService->getCartItems();
        
        if (empty($cartItems)) {
            session()->flash('error', 'Votre panier est vide.');
            return redirect()->route('cart');
        }

        $total = $this->cartService->getTotal();

        // Create order
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => auth()->id(),
            'total_amount' => $total,
            'status' => 'pending',
            'shipping_address' => $this->shipping_address,
            'shipping_city' => $this->shipping_city,
            'shipping_phone' => $this->shipping_phone,
            'notes' => $this->notes,
        ]);

        // Create order items and update stock
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'quantity' => $item['quantity'],
                'price' => $item['product']->price,
                'subtotal' => $item['subtotal'],
            ]);

            // Reduce stock
            $product = Product::find($item['product']->id);
            if ($product) {
                $product->stock_quantity -= $item['quantity'];
                $product->save();
            }
        }

        // Clear cart
        $this->cartService->clearCart();

        // Redirect to payment initiation
        return redirect()->route('payment.initiate', ['orderId' => $order->order_number]);
    }

    public function render()
    {
        $cartItems = $this->cartService->getCartItems();
        $total = $this->cartService->getTotal();
        $totalItems = $this->cartService->getTotalItems();

        return view('livewire.checkout', [
            'cartItems' => $cartItems,
            'total' => $total,
            'totalItems' => $totalItems,
        ]);
    }
}
