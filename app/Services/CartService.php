<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected $cartKey = 'cart';

    public function getCart()
    {
        return Session::get($this->cartKey, []);
    }

    public function addProduct($productId, $quantity = 1)
    {
        $cart = $this->getCart();
        $product = Product::find($productId);

        if (!$product) {
            return false;
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'product_id' => $productId,
                'quantity' => $quantity,
                'name' => $product->name,
                'brand' => $product->brand,
                'price' => $product->price,
                'image_path' => $product->image_path,
            ];
        }

        Session::put($this->cartKey, $cart);
        return true;
    }

    public function updateQuantity($productId, $quantity)
    {
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = $quantity;
            }
            Session::put($this->cartKey, $cart);
        }
    }

    public function removeProduct($productId)
    {
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put($this->cartKey, $cart);
        }
    }

    public function clearCart()
    {
        Session::forget($this->cartKey);
    }

    public function getTotal()
    {
        $cart = $this->getCart();
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

    public function getTotalItems()
    {
        $cart = $this->getCart();
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['quantity'];
        }

        return $total;
    }

    public function getCartItems()
    {
        $cart = $this->getCart();
        $items = [];

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $items[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity'],
                ];
            }
        }

        return $items;
    }
}
