@extends('layouts.app')

@section('title', 'My Wishlist — Velyora')

@section('content')
<main class="account-page-wrapper py-5">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="account-breadcrumb" style="margin-bottom: 25px;">
            <h2>Wishlist</h2>
            <span><a href="{{ route('home') }}" style="color: inherit; text-decoration: none;">Home</a> / <strong>Wishlist</strong></span>
        </div>

        @guest
            <div class="alert alert-info d-flex align-items-center justify-content-between p-3 mb-4" style="border-radius: 10px; background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af;">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle-fill" style="font-size: 18px;"></i>
                    <span style="font-size: 13.5px;">You are currently viewing a <strong>guest wishlist</strong>. Sign in to sync and save your favorites across all your devices.</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-sm btn-primary-profile" style="padding: 6px 14px; font-size: 12px;">Sign In</a>
                    <a href="{{ route('register') }}" class="btn btn-sm btn-secondary-profile" style="padding: 6px 14px; font-size: 12px;">Register</a>
                </div>
            </div>
        @endguest

        <div class="account-content" style="background: var(--color-white); border-radius: var(--radius-md); border: 1px solid var(--color-border); padding: 30px; box-shadow: var(--shadow-sm);">
            <div class="content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid var(--color-border);">
                <h3 style="margin: 0; font-size: 20px; font-weight: 700; color: var(--color-heading);">
                    Saved Items (<span class="wishlist-total-count">{{ count($wishlistItems) }}</span>)
                </h3>
                <div class="header-actions">
                    @if (!empty($wishlistItems))
                        <button type="button" class="btn-secondary btn-add-all-wishlist" style="padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
                            <i class="bi bi-cart-plus"></i> Add All to Cart
                        </button>
                    @endif
                </div>
            </div>

            <div class="wishlist-grid">
                @if (empty($wishlistItems))
                    <div class="empty-wishlist-state text-center py-5" style="grid-column: 1 / -1; padding: 60px 20px; text-align: center;">
                        <div style="font-size: 54px; color: var(--color-border); margin-bottom: 15px;">
                            <i class="bi bi-heart"></i>
                        </div>
                        <h4 style="font-weight: 700; color: var(--color-heading); margin-bottom: 10px;">Your wishlist is empty</h4>
                        <p style="color: var(--color-text-light); max-width: 420px; margin: 0 auto 24px; font-size: 14px;">
                            Explore our curated collection and add your favorite items to your wishlist for easy access anytime.
                        </p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary-profile" style="padding: 10px 26px; border-radius: 999px;">
                            Explore Products
                        </a>
                    </div>
                @else
                    @foreach ($wishlistItems as $wItem)
                        <div class="wishlist-card" data-product-id="{{ $wItem['product_id'] }}" data-wishlist-id="{{ $wItem['wishlist_id'] }}">
                            <button type="button" class="btn-remove-wishlist" data-product-id="{{ $wItem['product_id'] }}" title="Remove from wishlist">
                                <i class="bi bi-trash"></i>
                            </button>
                            <div class="wishlist-img-wrapper">
                                <a href="{{ route('products.show', $wItem['product_id']) }}">
                                    <img src="{{ $wItem['image'] }}" alt="{{ $wItem['name'] }}">
                                </a>
                            </div>
                            <div class="wishlist-details">
                                <span class="wishlist-category">{{ $wItem['category_name'] }}</span>
                                <h4 class="wishlist-title">
                                    <a href="{{ route('products.show', $wItem['product_id']) }}" style="text-decoration:none; color:inherit;">
                                        {{ $wItem['name'] }}
                                    </a>
                                </h4>
                                <div class="wishlist-price">
                                    <strong>Rs. {{ number_format($wItem['price']) }}</strong>
                                    @if ($wItem['old_price'])
                                        <del>Rs. {{ number_format($wItem['old_price']) }}</del>
                                    @endif
                                </div>
                                <div class="wishlist-stock" style="margin-bottom: 14px; font-size: 12px; font-weight: 600;">
                                    <i class="bi {{ $wItem['in_stock'] ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger' }}"></i>
                                    <span>{{ $wItem['in_stock'] ? 'In Stock' : 'Out of Stock' }}</span>
                                </div>
                                <button type="button" class="btn-primary-profile add-cart-button" style="width: 100%; justify-content: center;" data-product-id="{{ $wItem['product_id'] }}" {{ $wItem['in_stock'] ? '' : 'disabled' }}>
                                    <i class="bi bi-cart-plus"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</main>
@endsection

