@extends('admin.layouts.admin')

@section('title', 'Edit Category — Velyora Admin')

@section('content')
<div class="page-header" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h2>Edit Category: {{ $category->name }}</h2>
        <p style="color: var(--color-text-muted);">Update details for this category.</p>
    </div>
    <a href="{{ route('admin.categories.index') }}" class="icon-btn-flat" style="text-decoration: none; padding: 8px 16px; border: 1px solid var(--color-border); border-radius: 8px;">
        <i class="bi bi-arrow-left"></i> Back to Categories
    </a>
</div>

<div class="card" style="max-width: 600px; background: var(--color-surface); padding: 28px; border-radius: 12px; border: 1px solid var(--color-border);">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 18px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Category Name</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required style="width: 100%; padding: 10px 14px; border: 1px solid var(--color-border); border-radius: 8px;">
        </div>

        <div style="margin-bottom: 18px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" required style="width: 100%; padding: 10px 14px; border: 1px solid var(--color-border); border-radius: 8px;">
        </div>

        <div style="margin-bottom: 18px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Bootstrap Icon Class</label>
            <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" style="width: 100%; padding: 10px 14px; border: 1px solid var(--color-border); border-radius: 8px;">
        </div>

        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Status</label>
            <select name="status" style="width: 100%; padding: 10px 14px; border: 1px solid var(--color-border); border-radius: 8px;">
                <option value="active" {{ $category->status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $category->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn-create-pill" style="padding: 10px 24px;">
            <i class="bi bi-check-lg"></i> Update Category
        </button>
    </form>
</div>
@endsection

