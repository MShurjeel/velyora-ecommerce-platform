@extends('admin.layouts.admin')

@section('title', 'Add New Product — Velyora Admin')

@section('content')
<div class="page-header" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h2>Add New Product</h2>
        <p style="color: var(--color-text-muted);">Create a new inventory item for your storefront.</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="icon-btn-flat" style="text-decoration: none; padding: 8px 16px; border: 1px solid var(--color-border); border-radius: 8px;">
        <i class="bi bi-arrow-left"></i> Back to Products
    </a>
</div>

<div class="card" style="max-width: 800px; background: var(--color-surface); padding: 28px; border-radius: 12px; border: 1px solid var(--color-border);">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom: 18px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Product Title</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Wireless Noise-Cancelling Headphones" required style="width: 100%; padding: 10px 14px; border: 1px solid var(--color-border); border-radius: 8px;">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Category</label>
                <select name="category_id" required style="width: 100%; padding: 10px 14px; border: 1px solid var(--color-border); border-radius: 8px;">
                    <option value="" disabled selected>Select category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Status</label>
                <select name="status" style="width: 100%; padding: 10px 14px; border: 1px solid var(--color-border); border-radius: 8px;">
                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="out_of_stock" {{ old('status') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 18px; margin-bottom: 18px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Regular Price (Rs.)</label>
                <input type="number" step="0.01" name="price" value="{{ old('price') }}" placeholder="8499" required style="width: 100%; padding: 10px 14px; border: 1px solid var(--color-border); border-radius: 8px;">
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Sale Price (Rs., optional)</label>
                <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}" placeholder="7499" style="width: 100%; padding: 10px 14px; border: 1px solid var(--color-border); border-radius: 8px;">
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Stock Quantity</label>
                <input type="number" name="stock_qty" value="{{ old('stock_qty', 10) }}" required style="width: 100%; padding: 10px 14px; border: 1px solid var(--color-border); border-radius: 8px;">
            </div>
        </div>

        <div style="margin-bottom: 18px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Product Image</label>
            <input type="file" name="image" accept="image/*" style="width: 100%; padding: 10px 14px; border: 1px solid var(--color-border); border-radius: 8px; background: #fff;">
        </div>

        <div style="margin-bottom: 18px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Description</label>
            <textarea name="description" rows="5" placeholder="Enter product overview and features..." style="width: 100%; padding: 10px 14px; border: 1px solid var(--color-border); border-radius: 8px;">{{ old('description') }}</textarea>
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: flex; align-items: center; gap: 8px; font-size: 14px; cursor: pointer;">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                <span>Feature this product on homepage curated selection</span>
            </label>
        </div>

        <button type="submit" class="btn-create-pill" style="padding: 12px 28px;">
            <i class="bi bi-plus-lg"></i> Save Product
        </button>
    </form>
</div>
@endsection

