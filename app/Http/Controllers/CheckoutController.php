<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = CartService::getCartItems();
        $totals = CartService::getCartTotals();

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('info', 'Your cart is empty. Please add items before checking out.');
        }

        $user = Auth::user();
        $defaultAddress = $user ? $user->default_address : null;
        $defaultPayment = $user ? $user->default_payment_method : null;

        return view('pages.checkout', compact('cartItems', 'totals', 'defaultAddress', 'defaultPayment'));
    }

    public function processCheckout(Request $request)
    {
        $cartItems = CartService::getCartItems();
        $totals = CartService::getCartTotals();

        if (empty($cartItems)) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty.'
            ], 422);
        }

        $fullName = trim($request->input('first_name', '') . ' ' . $request->input('last_name', ''));
        if (empty($fullName)) {
            $fullName = Auth::check() ? Auth::user()->name : 'Valued Customer';
        }

        $orderNumber = 'VEL-' . strtoupper(uniqid());

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => $orderNumber,
            'customer_name' => $fullName,
            'email' => $request->input('email', Auth::check() ? Auth::user()->email : ''),
            'phone' => $request->input('phone', ''),
            'address' => $request->input('address', ''),
            'city' => $request->input('city', ''),
            'province' => $request->input('province', ''),
            'postal_code' => $request->input('postal_code', ''),
            'subtotal' => $totals['subtotal'],
            'shipping' => $totals['shipping'],
            'tax' => $totals['tax'],
            'total_amount' => $totals['total'],
            'payment_method' => $request->input('payment', 'Cash on Delivery'),
            'payment_status' => 'Pending',
            'order_status' => 'Processing',
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'total_price' => $item['item_total'],
            ]);
        }

        // Clear cart after successful placement
        CartService::clearCart();

        return response()->json([
            'success' => true,
            'order_number' => $orderNumber,
            'message' => 'Order placed successfully!'
        ]);
    }
}

