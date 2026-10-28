@extends('admin.layouts.admin')

@section('title', 'Velyora Admin — Orders & Fulfillment')

@section('content')
<div class="page-header" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h2>Orders & Shipments</h2>
        <p style="color: var(--color-text-muted);">Manage customer purchases, shipment tracking, and order fulfillment statuses.</p>
    </div>
    <div style="display: flex; gap: 12px;">
        <span class="badge-pill" style="background: #EFF6FF; color: #2563EB; padding: 8px 16px; border-radius: 20px; font-weight: 600; font-size: 13px;">
            Total Orders: {{ $orders->total() }}
        </span>
    </div>
</div>

<div class="card table-card" style="background: var(--color-surface); border-radius: 12px; border: 1px solid var(--color-border); overflow: hidden;">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ORDER NO.</th>
                    <th>CUSTOMER</th>
                    <th>ITEMS ORDERED</th>
                    <th>TOTAL</th>
                    <th>PAYMENT</th>
                    <th>ORDER STATUS</th>
                    <th>ACTION / UPDATE</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <strong style="color: var(--color-primary); font-size: 14px;">#{{ $order->order_number }}</strong>
                            <small style="display: block; color: var(--color-text-muted); font-size: 12px;">
                                {{ $order->created_at->format('M d, Y h:i A') }}
                            </small>
                        </td>
                        <td>
                            <div style="font-weight: 600;">{{ $order->customer_name }}</div>
                            <small style="display: block; color: var(--color-text-muted); font-size: 12px;">
                                <i class="bi bi-telephone"></i> {{ $order->phone }}
                            </small>
                            <small style="display: block; color: var(--color-text-muted); font-size: 12px;">
                                <i class="bi bi-geo-alt"></i> {{ $order->city }}
                            </small>
                        </td>
                        <td>
                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                @foreach($order->items as $item)
                                    <div style="font-size: 13px; display: flex; align-items: center; gap: 6px;">
                                        <span style="font-weight: 600; color: var(--color-primary);">{{ $item->quantity }}x</span>
                                        <span style="max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                            {{ $item->product->name ?? 'Product' }}
                                        </span>
                                        <small style="color: var(--color-text-muted);">(Rs. {{ number_format($item->unit_price) }})</small>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <strong style="font-size: 14px;">Rs. {{ number_format($order->total_amount) }}</strong>
                            <small style="display: block; color: var(--color-text-muted); font-size: 11px;">
                                (Shipping: Rs. {{ number_format($order->shipping) }})
                            </small>
                        </td>
                        <td>
                            <span class="badge-pill" style="font-size: 11px; font-weight: 600; background: #F1F5F9; color: #475569; padding: 4px 8px; border-radius: 6px; display: inline-block; margin-bottom: 4px;">
                                {{ $order->payment_method }}
                            </span>
                            <div>
                                <span class="status-badge {{ strtolower($order->payment_status) === 'paid' ? 'success' : 'warning' }}" style="font-size: 11px;">
                                    {{ $order->payment_status }}
                                </span>
                            </div>
                        </td>
                        <td>
                            @php
                                $statusClass = match(strtolower($order->order_status)) {
                                    'delivered' => 'success',
                                    'shipped' => 'primary',
                                    'processing' => 'warning',
                                    'cancelled' => 'danger',
                                    default => 'warning'
                                };
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                {{ $order->order_status }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" style="display: flex; gap: 6px; align-items: center; margin: 0;">
                                @csrf
                                @method('PUT')
                                <select name="order_status" style="padding: 6px 10px; border-radius: 6px; border: 1px solid var(--color-border); font-size: 12px; background: var(--color-surface); cursor: pointer;">
                                    <option value="Processing" {{ $order->order_status === 'Processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="Shipped" {{ $order->order_status === 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="Delivered" {{ $order->order_status === 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="Cancelled" {{ $order->order_status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="On Hold" {{ $order->order_status === 'On Hold' ? 'selected' : '' }}>On Hold</option>
                                </select>
                                <button type="submit" class="icon-btn-flat" style="padding: 6px 10px; background: var(--color-primary); color: #fff; border-radius: 6px; font-size: 12px;" title="Update Status">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 36px; color: var(--color-text-muted);">
                            <i class="bi bi-cart-x" style="font-size: 2rem; display: block; margin-bottom: 8px;"></i>
                            No customer orders placed yet. Orders will appear here in real-time as customers complete checkout.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div style="padding: 16px 24px; border-top: 1px solid var(--color-border);">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection

