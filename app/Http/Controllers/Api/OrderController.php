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
            'items.*.product_variant_id' => 'required|exists:product_variants,id',
            'items.*.quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string',
            'shipping_phone' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        return \DB::transaction(function () use ($validated) {
            $totalAmount = 0;
            $orderItems = [];

            foreach ($validated['items'] as $item) {
                $variant = \App\Models\ProductVariant::with('product')->findOrFail($item['product_variant_id']);
                
                // Check stock availability
                if ($variant->stock_quantity < $item['quantity']) {
                    return response()->json([
                        'error' => 'Stock insuffisant pour la variante: ' . $variant->name,
                        'available' => $variant->stock_quantity,
                        'requested' => $item['quantity'],
                    ], 422);
                }

                $itemTotal = $variant->price * $item['quantity'];
                $totalAmount += $itemTotal;

                $orderItems[] = [
                    'product_id' => $variant->product_id,
                    'product_variant_id' => $variant->id,
                    'quantity' => $item['quantity'],
                    'price' => $variant->price,
                    'subtotal' => $itemTotal,
                ];

                // Decrement stock
                $variant->stock_quantity -= $item['quantity'];
                $variant->save();
            }

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_phone' => $validated['shipping_phone'],
                'payment_method' => $validated['payment_method'],
            ]);

            foreach ($orderItems as $item) {
                $item['order_id'] = $order->id;
                OrderItem::create($item);
            }

            return response()->json([
                'id' => $order->id,
                'order_number' => $order->order_number,
                'user_id' => $order->user_id,
                'total_amount' => (float) $order->total_amount,
                'status' => $order->status,
                'shipping_address' => $order->shipping_address,
                'shipping_city' => $order->shipping_city,
                'shipping_phone' => $order->shipping_phone,
                'payment_method' => $order->payment_method,
                'items' => $order->orderItems,
            ]);
        });
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
