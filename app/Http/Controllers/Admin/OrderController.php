<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.product', 'user'])->orderBy('id', 'desc')->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'order_status' => ['required', 'in:Pending,Processing,Shipped,Delivered,Cancelled,Refunded,On Hold'],
        ]);

        $order->update($validated);

        return back()->with('success', "Order {$order->order_number} status updated to {$order->order_status}!");
    }
}

