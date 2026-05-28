<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items.product')->where('user_id', auth()->id());

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Pagination
        $perPage = $request->has('per_page') ? (int) $request->per_page : 15;
        $orders = $query->paginate($perPage);

        return OrderResource::collection($orders);
    }

    public function show($id)
    {
        $order = Order::with('items.product')->where('user_id', auth()->id())->findOrFail($id);

        return new OrderResource($order);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'delivery_address' => 'required|array',
            'delivery_address.address' => 'required|string',
            'delivery_address.city' => 'required|string',
            'delivery_address.country' => 'required|string',
            'delivery_address.phone' => 'required|string',
        ]);

        $totalAmount = 0;
        foreach ($validated['items'] as $item) {
            $product = Product::findOrFail($item['product_id']);
            $totalAmount += $product->price * $item['quantity'];
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'reference' => 'ORD-' . date('Y') . '-' . str_pad(Order::count() + 1, 3, '0', STR_PAD_LEFT),
            'total_amount' => $totalAmount,
            'delivery_address' => $validated['delivery_address']['address'],
            'city' => $validated['delivery_address']['city'],
            'country' => $validated['delivery_address']['country'],
            'phone' => $validated['delivery_address']['phone'],
            'delivery_fee' => 15000,
            'status' => 'pending',
        ]);

        foreach ($validated['items'] as $item) {
            $product = Product::findOrFail($item['product_id']);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $product->price,
                'subtotal' => $product->price * $item['quantity'],
            ]);

            // Update stock
            $product->stock_quantity -= $item['quantity'];
            $product->save();
        }

        return new OrderResource($order->load('items.product'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,paid,shipped,delivered',
        ]);

        $order = Order::where('user_id', auth()->id())->findOrFail($id);
        $order->status = $validated['status'];
        $order->save();

        return new OrderResource($order);
    }
}
