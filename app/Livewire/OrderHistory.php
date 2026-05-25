<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderHistory extends Component
{
    public $selectedOrder = null;

    public function viewOrder($orderId)
    {
        $this->selectedOrder = Order::with('orderItems.product')->find($orderId);
    }

    public function closeOrder()
    {
        $this->selectedOrder = null;
    }

    public function render()
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.order-history', [
            'orders' => $orders,
        ]);
    }
}
