<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartService
{
    protected static function getSessionIdentifier(): array
    {
        if (Auth::check()) {
            return ['user_id' => Auth::id()];
        }
        return ['session_id' => session()->getId()];
    }

    public static function getCartItems(): array
    {
        $idArray = self::getSessionIdentifier();
        
        $query = Cart::with(['product.category', 'product.images']);
        if (isset($idArray['user_id'])) {
            $query->where('user_id', $idArray['user_id']);
        } else {
            $query->where('session_id', $idArray['session_id']);
        }

        $cartRows = $query->orderBy('id', 'desc')->get();
        $items = [];

        foreach ($cartRows as $row) {
            $product = $row->product;
            if (!$product) continue;

            $hasSale = !empty($product->sale_price) && $product->sale_price < $product->price;
            $price = $hasSale ? (float)$product->sale_price : (float)$product->price;
            $oldPrice = $hasSale ? (float)$product->price : null;

            $items[] = [
                'id' => (int)$row->id,
                'cart_id' => (int)$row->id,
                'product_id' => (int)$product->id,
                'name' => $product->name,
                'category' => $product->category->name ?? 'General',
                'category_name' => $product->category->name ?? 'General',
                'variant' => 'Standard',
                'price' => $price,
                'old_price' => $oldPrice,
                'quantity' => (int)$row->quantity,
                'stock_qty' => (int)$product->stock_qty,
                'image' => $product->primary_image_url,
                'item_total' => $price * (int)$row->quantity
            ];
        }

        return $items;
    }

    public static function getCartTotals(): array
    {
        $items = self::getCartItems();
        $subtotal = 0;
        $itemCount = 0;

        foreach ($items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $itemCount += $item['quantity'];
        }

        $freeShippingThreshold = 3000;
        $shipping = ($subtotal >= $freeShippingThreshold || $subtotal == 0) ? 0 : 250;
        $discount = 0;
        $tax = round(($subtotal - $discount) * 0.02);
        $total = $subtotal + $shipping + $tax - $discount;

        $progressPercent = $subtotal >= $freeShippingThreshold ? 100 : round(($subtotal / $freeShippingThreshold) * 100);
        $amountForFreeShipping = max(0, $freeShippingThreshold - $subtotal);

        return [
            'subtotal' => $subtotal,
            'subtotal_formatted' => 'Rs. ' . number_format($subtotal),
            'shipping' => $shipping,
            'shipping_formatted' => $shipping === 0 ? 'FREE' : 'Rs. ' . number_format($shipping),
            'free_shipping_threshold' => $freeShippingThreshold,
            'free_shipping_unlocked' => $subtotal >= $freeShippingThreshold,
            'progress_percent' => $progressPercent,
            'amount_for_free_shipping' => $amountForFreeShipping,
            'tax' => $tax,
            'tax_formatted' => 'Rs. ' . number_format($tax),
            'discount' => $discount,
            'discount_formatted' => 'Rs. ' . number_format($discount),
            'total' => $total,
            'total_formatted' => 'Rs. ' . number_format($total),
            'item_count' => $itemCount
        ];
    }

    public static function getCartCount(): int
    {
        $idArray = self::getSessionIdentifier();
        $query = Cart::query();
        if (isset($idArray['user_id'])) {
            $query->where('user_id', $idArray['user_id']);
        } else {
            $query->where('session_id', $idArray['session_id']);
        }
        return (int) $query->sum('quantity');
    }

    public static function addToCart(int $productId, int $quantity = 1): array
    {
        $product = Product::find($productId);
        if (!$product) {
            return ['success' => false, 'message' => 'Product not found.'];
        }

        if ($product->stock_qty <= 0) {
            return ['success' => false, 'message' => 'Sorry, this product is out of stock.'];
        }

        $idArray = self::getSessionIdentifier();
        $existing = Cart::where($idArray)->where('product_id', $productId)->first();

        if ($existing) {
            $newQty = min($existing->quantity + $quantity, $product->stock_qty);
            $existing->update(['quantity' => $newQty]);
        } else {
            Cart::create(array_merge([
                'session_id' => session()->getId() ?: ('sess_' . uniqid()),
            ], $idArray, [
                'product_id' => $productId,
                'quantity' => min($quantity, $product->stock_qty)
            ]));
        }

        $totals = self::getCartTotals();
        return [
            'success' => true,
            'message' => '“' . $product->name . '” added to your cart!',
            'cart_count' => $totals['item_count'],
            'totals' => $totals,
            'items' => self::getCartItems()
        ];
    }

    public static function updateQuantity(int $cartId, int $quantity): array
    {
        $idArray = self::getSessionIdentifier();
        $cart = Cart::where($idArray)->where('id', $cartId)->first();

        if (!$cart) {
            return ['success' => false, 'message' => 'Cart item not found.'];
        }

        if ($quantity <= 0) {
            return self::removeFromCart($cartId);
        }

        $product = $cart->product;
        $finalQty = min($quantity, $product ? $product->stock_qty : $quantity);
        $cart->update(['quantity' => $finalQty]);

        $totals = self::getCartTotals();
        return [
            'success' => true,
            'message' => 'Cart updated successfully.',
            'quantity' => $finalQty,
            'cart_count' => $totals['item_count'],
            'totals' => $totals,
            'items' => self::getCartItems()
        ];
    }

    public static function removeFromCart(int $cartId): array
    {
        $idArray = self::getSessionIdentifier();
        Cart::where($idArray)->where('id', $cartId)->delete();

        $totals = self::getCartTotals();
        return [
            'success' => true,
            'message' => 'Item removed from cart.',
            'cart_count' => $totals['item_count'],
            'totals' => $totals,
            'items' => self::getCartItems()
        ];
    }

    public static function clearCart(): array
    {
        $idArray = self::getSessionIdentifier();
        Cart::where($idArray)->delete();

        $totals = self::getCartTotals();
        return [
            'success' => true,
            'message' => 'Cart cleared.',
            'cart_count' => 0,
            'totals' => $totals,
            'items' => []
        ];
    }
}

