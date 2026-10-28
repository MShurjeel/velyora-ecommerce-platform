<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartService::getCartItems();
        $totals = CartService::getCartTotals();

        return view('pages.cart', compact('cartItems', 'totals'));
    }

    public function handleAjax(Request $request)
    {
        $action = $request->input('action', 'add');

        switch ($action) {
            case 'add':
                $productId = (int) $request->input('product_id');
                $quantity = (int) $request->input('quantity', 1);
                $res = CartService::addToCart($productId, $quantity);
                return response()->json($res);

            case 'update':
                $cartId = (int) $request->input('cart_id');
                $quantity = (int) $request->input('quantity', 1);
                $res = CartService::updateQuantity($cartId, $quantity);
                return response()->json($res);

            case 'remove':
                $cartId = (int) $request->input('cart_id');
                $res = CartService::removeFromCart($cartId);
                return response()->json($res);

            case 'clear':
                $res = CartService::clearCart();
                return response()->json($res);

            default:
                return response()->json(['success' => false, 'message' => 'Unknown action.']);
        }
    }
}

