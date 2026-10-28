<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistService
{
    protected static function getSessionIdentifier(): array
    {
        if (Auth::check()) {
            return ['user_id' => Auth::id()];
        }
        return ['session_id' => session()->getId()];
    }

    public static function getWishlistItems(): array
    {
        $idArray = self::getSessionIdentifier();

        $query = Wishlist::with(['product.category', 'product.images']);
        if (isset($idArray['user_id'])) {
            $query->where('user_id', $idArray['user_id']);
        } else {
            $query->where('session_id', $idArray['session_id']);
        }

        $rows = $query->orderBy('id', 'desc')->get();
        $items = [];

        foreach ($rows as $row) {
            $product = $row->product;
            if (!$product) continue;

            $hasSale = !empty($product->sale_price) && $product->sale_price < $product->price;
            $price = $hasSale ? (float)$product->sale_price : (float)$product->price;
            $oldPrice = $hasSale ? (float)$product->price : null;

            $items[] = [
                'id' => (int)$row->id,
                'wishlist_id' => (int)$row->id,
                'product_id' => (int)$product->id,
                'name' => $product->name,
                'category_name' => $product->category->name ?? 'General',
                'price' => $price,
                'old_price' => $oldPrice,
                'stock_qty' => (int)$product->stock_qty,
                'in_stock' => $product->stock_qty > 0,
                'image' => $product->primary_image_url
            ];
        }

        return $items;
    }

    public static function getWishlistCount(): int
    {
        $idArray = self::getSessionIdentifier();
        $query = Wishlist::query();
        if (isset($idArray['user_id'])) {
            $query->where('user_id', $idArray['user_id']);
        } else {
            $query->where('session_id', $idArray['session_id']);
        }
        return (int) $query->count();
    }

    public static function isInWishlist(int $productId): bool
    {
        $idArray = self::getSessionIdentifier();
        return Wishlist::where($idArray)->where('product_id', $productId)->exists();
    }

    public static function toggle(int $productId): array
    {
        $product = Product::find($productId);
        if (!$product) {
            return ['success' => false, 'message' => 'Product not found.'];
        }

        $idArray = self::getSessionIdentifier();
        $existing = Wishlist::where($idArray)->where('product_id', $productId)->first();

        if ($existing) {
            $existing->delete();
            return [
                'success' => true,
                'action' => 'removed',
                'message' => '“' . $product->name . '” removed from wishlist.',
                'wishlist_count' => self::getWishlistCount()
            ];
        } else {
            Wishlist::create(array_merge([
                'session_id' => session()->getId() ?: ('sess_' . uniqid()),
            ], $idArray, ['product_id' => $productId]));
            return [
                'success' => true,
                'action' => 'added',
                'message' => '“' . $product->name . '” added to wishlist!',
                'wishlist_count' => self::getWishlistCount()
            ];
        }
    }

    public static function remove(int $productId): array
    {
        $idArray = self::getSessionIdentifier();
        Wishlist::where($idArray)->where('product_id', $productId)->delete();

        return [
            'success' => true,
            'message' => 'Item removed from wishlist.',
            'wishlist_count' => self::getWishlistCount()
        ];
    }

    public static function addAllToCart(): array
    {
        $items = self::getWishlistItems();
        $added = 0;

        foreach ($items as $item) {
            if ($item['in_stock']) {
                CartService::addToCart($item['product_id'], 1);
                $added++;
            }
        }

        $totals = CartService::getCartTotals();
        return [
            'success' => true,
            'added_count' => $added,
            'message' => $added > 0 ? "Added {$added} item(s) from wishlist to your cart!" : "No in-stock items to add.",
            'cart_count' => $totals['item_count'],
            'totals' => $totals,
            'items' => CartService::getCartItems()
        ];
    }
}

