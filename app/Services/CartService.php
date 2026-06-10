<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * Get the current cart from session.
     */
    public function getCart(): array
    {
        return Session::get('cart', []);
    }

    /**
     * Get cart with full product details, without modifying the session.
     */
    public function getCartWithDetails(): array
    {
        $cart = $this->getCart();
        
        if (empty($cart)) {
            return [];
        }

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $detailedCart = [];
        foreach ($cart as $id => $item) {
            if (isset($products[$id])) {
                $detailedCart[$id] = [
                    'id' => $id,
                    'name' => $products[$id]->name,
                    'price' => $products[$id]->price,
                    'image' => $products[$id]->image,
                    'slug' => $products[$id]->slug,
                    'quantity' => $item['quantity'],
                    'subtotal' => $products[$id]->price * $item['quantity'],
                ];
            }
        }

        return $detailedCart;
    }

    /**
     * Add a product to the cart.
     */
    public function addToCart(int $productId): array
    {
        $product = Product::findOrFail($productId);
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->image,
                'slug' => $product->slug
            ];
        }

        Session::put('cart', $cart);
        return $cart;
    }

    /**
     * Update item quantity.
     */
    public function updateQuantity(int $productId, int $quantity): void
    {
        $cart = $this->getCart();
        if (isset($cart[$productId]) && $quantity > 0) {
            $cart[$productId]['quantity'] = $quantity;
            Session::put('cart', $cart);
        } elseif (isset($cart[$productId]) && $quantity <= 0) {
            $this->removeFromCart($productId);
        }
    }

    /**
     * Remove item from cart.
     */
    public function removeFromCart(int $productId): void
    {
        $cart = $this->getCart();
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
        }
    }

    /**
     * Calculate total price.
     */
    public function getTotal(): float
    {
        $cart = $this->getCartWithDetails();
        return array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['subtotal'] ?? 0);
        }, 0);
    }

    /**
     * Clear the cart.
     */
    public function clear(): void
    {
        Session::forget('cart');
    }
}
