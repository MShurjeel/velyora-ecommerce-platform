@extends('admin.layouts.admin')

@section('title', 'Velyora Admin — Products')

@section('content')
<div class="page-header" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h2>Products Management</h2>
        <p style="color: var(--color-text-muted);">View, create, and manage your store's active inventory.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn-create-pill" style="text-decoration:none;">
        <i class="bi bi-plus-lg"></i> Add New Product
    </a>
</div>

<div class="card table-card" style="background: var(--color-surface); border-radius: 12px; border: 1px solid var(--color-border); overflow: hidden;">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>IMAGE</th>
                    <th>PRODUCT NAME</th>
                    <th>CATEGORY</th>
                    <th>PRICE</th>
                    <th>STOCK</th>
                    <th>FEATURED</th>
                    <th>STATUS</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover; border: 1px solid var(--color-border);">
                        </td>
                        <td>
                            <strong>{{ $product->name }}</strong>
                            <small style="display: block; color: var(--color-text-muted);">ID: #{{ $product->id }}</small>
                        </td>
                        <td>{{ $product->category->name ?? 'None' }}</td>
                        <td>
                            <strong>Rs. {{ number_format($product->price) }}</strong>
                            @if($product->sale_price)
                                <small style="display: block; color: #16A34A;">Sale: Rs. {{ number_format($product->sale_price) }}</small>
                            @endif
                        </td>
                        <td>
                            <span style="font-weight: 600; {{ $product->stock_qty <= 5 ? 'color: #DC2626;' : 'color: #16A34A;' }}">
                                {{ $product->stock_qty }} in stock
                            </span>
                        </td>
                        <td>
                            @if($product->is_featured)
                                <span class="badge-pill" style="background: #FEF3C7; color: #D97706; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 700;">★ FEATURED</span>
                            @else
                                <span style="color: var(--color-text-muted);">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge {{ $product->status === 'active' ? 'success' : ($product->status === 'draft' ? 'warning' : 'danger') }}">
                                {{ ucfirst(str_replace('_', ' ', $product->status)) }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="icon-btn-flat" style="text-decoration:none;" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" style="margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="icon-btn-flat" style="color: #DC2626;" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 32px; color: var(--color-text-muted);">
                            No products found in the catalog.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div style="padding: 16px 24px; border-top: 1px solid var(--color-border);">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection

