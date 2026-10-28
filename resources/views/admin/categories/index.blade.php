@extends('admin.layouts.admin')

@section('title', 'Velyora Admin — Categories')

@section('content')
<div class="page-header" style="margin-bottom: 24px;">
    <h2>Categories Management</h2>
    <p style="color: var(--color-text-muted);">Organize and structure your store's catalog categories.</p>
</div>

<div class="row" style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px;">
    <!-- ADD CATEGORY FORM -->
    <div class="card" style="background: var(--color-surface); padding: 24px; border-radius: 12px; border: 1px solid var(--color-border);">
        <h3 style="font-size: 1.1rem; margin-bottom: 16px;">Add New Category</h3>
        
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Category Name</label>
                <input type="text" name="name" placeholder="e.g. Watches" required style="width: 100%; padding: 10px 14px; border: 1px solid var(--color-border); border-radius: 8px;">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Slug (optional)</label>
                <input type="text" name="slug" placeholder="e.g. watches" style="width: 100%; padding: 10px 14px; border: 1px solid var(--color-border); border-radius: 8px;">
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Bootstrap Icon Class</label>
                <input type="text" name="icon" placeholder="e.g. bi-watch" value="bi-folder" style="width: 100%; padding: 10px 14px; border: 1px solid var(--color-border); border-radius: 8px;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px;">Status</label>
                <select name="status" style="width: 100%; padding: 10px 14px; border: 1px solid var(--color-border); border-radius: 8px;">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn-create-pill" style="width: 100%; justify-content: center;">
                <i class="bi bi-plus-lg"></i> Add Category
            </button>
        </form>
    </div>

    <!-- CATEGORIES TABLE -->
    <div class="card table-card" style="background: var(--color-surface); border-radius: 12px; border: 1px solid var(--color-border); overflow: hidden;">
        <div class="card-header" style="padding: 18px 24px; border-bottom: 1px solid var(--color-border);">
            <h3>All Categories ({{ $categories->count() }})</h3>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ICON</th>
                        <th>NAME</th>
                        <th>SLUG</th>
                        <th>PRODUCTS</th>
                        <th>STATUS</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                <i class="bi {{ $category->icon }}" style="font-size: 1.3rem; color: #2563EB;"></i>
                            </td>
                            <td class="font-bold">{{ $category->name }}</td>
                            <td><code>{{ $category->slug }}</code></td>
                            <td>
                                <span class="badge-pill" style="background: #EFF6FF; color: #2563EB; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                                    {{ $category->products_count }} products
                                </span>
                            </td>
                            <td>
                                <span class="status-badge {{ $category->status === 'active' ? 'success' : 'warning' }}">
                                    {{ ucfirst($category->status) }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 8px;">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="icon-btn-flat" style="text-decoration:none;" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');" style="margin:0;">
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
                            <td colspan="6" style="text-align: center; padding: 24px;">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

