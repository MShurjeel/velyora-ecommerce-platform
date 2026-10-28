@extends('layouts.app')

@section('title', 'My Profile — Velyora')

@section('content')
<div class="account-page-wrapper">
    <div class="container">

        <!-- Unified Breadcrumb -->
        <div class="account-breadcrumb">
            <h2>Account</h2>
            <span><a href="{{ route('home') }}" style="color: inherit; text-decoration: none;">Home</a> / <strong>My Profile</strong></span>
        </div>

        <div class="account-layout">

            <!-- LEFT SIDEBAR: Bootstrap Pills Navigation -->
            <aside class="account-sidebar">
                <div class="sidebar-profile">
                    <img src="{{ asset('assets/images/users/default-avatar.png') }}" alt="User Profile" class="profile-img">
                    <h4 class="profile-name">{{ $user->name }}</h4>
                    <span class="profile-badge"><i class="bi bi-star-fill"></i> Premium Member</span>
                </div>

                <nav class="sidebar-nav nav flex-column" role="tablist">
                    <a href="#v-pills-orders" class="nav-link active" id="v-pills-orders-tab" data-bs-toggle="pill" data-bs-target="#v-pills-orders" role="tab">
                        <i class="bi bi-box"></i>
                        <span>My Orders</span>
                        <span class="badge-count">{{ $userOrders->count() }}</span>
                    </a>
                    <a href="#v-pills-wishlist" class="nav-link" id="v-pills-wishlist-tab" data-bs-toggle="pill" data-bs-target="#v-pills-wishlist" role="tab">
                        <i class="bi bi-heart"></i>
                        <span>Wishlist</span>
                        <span class="badge-count dark profile-wishlist-badge">{{ count($wishlistItems) }}</span>
                    </a>
                    <a href="#v-pills-payments" class="nav-link" id="v-pills-payments-tab" data-bs-toggle="pill" data-bs-target="#v-pills-payments" role="tab">
                        <i class="bi bi-credit-card"></i>
                        <span>Payment Methods</span>
                        <span class="badge-count">{{ $paymentMethods->count() }}</span>
                    </a>
                    <a href="#v-pills-reviews" class="nav-link" id="v-pills-reviews-tab" data-bs-toggle="pill" data-bs-target="#v-pills-reviews" role="tab">
                        <i class="bi bi-star"></i>
                        <span>My Reviews</span>
                        <span class="badge-count">{{ $reviews->count() }}</span>
                    </a>
                    <a href="#v-pills-addresses" class="nav-link" id="v-pills-addresses-tab" data-bs-toggle="pill" data-bs-target="#v-pills-addresses" role="tab">
                        <i class="bi bi-geo-alt"></i>
                        <span>Addresses</span>
                        <span class="badge-count">{{ $addresses->count() }}</span>
                    </a>
                    <a href="#v-pills-settings" class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" role="tab">
                        <i class="bi bi-gear"></i>
                        <span>Account Settings</span>
                    </a>
                </nav>

                <div class="sidebar-footer-links">
                    <a href="{{ route('contact') }}" class="nav-link"><i class="bi bi-question-circle"></i> Help Center</a>
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="nav-link text-danger" style="background: none; border: none; width: 100%; text-align: left; padding: 10px 14px; cursor: pointer; display: flex; align-items: center; gap: 10px;">
                            <i class="bi bi-box-arrow-right"></i> Log Out
                        </button>
                    </form>
                </div>
            </aside>

            <!-- RIGHT MAIN CONTENT: Tab Panes -->
            <div class="tab-content" id="v-pills-tabContent">

                <!-- Alert Messages -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px; font-size: 14px; margin-bottom: 20px;">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px; font-size: 14px; margin-bottom: 20px;">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (isset($errors) && $errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px; font-size: 14px; margin-bottom: 20px;">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Please check the following errors:</strong>
                        <ul class="mb-0 mt-1 ps-3" style="font-size: 13px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- TAB 1: MY ORDERS -->
                <div class="tab-pane fade show active" id="v-pills-orders" role="tabpanel">
                    <main class="account-content orders-tab">
                        <div class="content-header">
                            <div class="content-header-left">
                                <h3>My Orders</h3>
                                @if ($userOrders->isNotEmpty())
                                    <span class="orders-total-badge">{{ $userOrders->count() }} Order{{ $userOrders->count() !== 1 ? 's' : '' }}</span>
                                @endif
                            </div>
                            <div class="header-actions">
                                <div class="search-box">
                                    <i class="bi bi-search"></i>
                                    <input type="text" id="orderSearch" placeholder="Search orders..." autocomplete="off">
                                </div>
                                <button class="btn-filter" id="filterToggle" type="button">
                                    <i class="bi bi-funnel"></i> Filter
                                </button>
                            </div>
                        </div>

                        <!-- Filter Bar -->
                        <div class="filter-bar" id="filterBar" style="display:none;">
                            <span class="filter-label">Status:</span>
                            <button class="filter-chip active" data-status="all">All</button>
                            <button class="filter-chip" data-status="Processing">Processing</button>
                            <button class="filter-chip" data-status="Shipped">Shipped</button>
                            <button class="filter-chip" data-status="Delivered">Delivered</button>
                            <button class="filter-chip" data-status="Cancelled">Cancelled</button>
                        </div>

                        <!-- Orders List -->
                        <div class="orders-list" id="ordersList">
                            @if ($userOrders->isEmpty())
                                <div class="orders-empty-state">
                                    <div class="orders-empty-icon">
                                        <i class="bi bi-bag-x"></i>
                                    </div>
                                    <h4>No orders yet</h4>
                                    <p>Looks like you haven't placed any orders. Start shopping and your orders will appear here!</p>
                                    <a href="{{ route('products.index') }}" class="btn-shop-now">
                                        <i class="bi bi-bag"></i> Start Shopping
                                    </a>
                                </div>
                            @else
                                @foreach ($userOrders as $order)
                                    @php
                                        $status = $order->order_status ?? 'Pending';
                                        $cfg = $statusConfig[$status] ?? $defaultStatus;
                                        $items = $order->items ?? collect();
                                        $itemCount = $items->count();
                                        $maxThumbs = 3;
                                        $extraCount = max(0, $itemCount - $maxThumbs);
                                        $shownItems = $items->take($maxThumbs);
                                        $firstProduct = $items->first() && $items->first()->product ? $items->first()->product : null;
                                    @endphp

                                    <div class="order-card" data-status="{{ $status }}" data-search="{{ strtolower($order->order_number . ' ' . $status) }}">
                                        <div class="order-card-header">
                                            <div class="order-meta">
                                                <span class="order-label">Order ID:</span>
                                                <strong class="order-number">{{ $order->order_number }}</strong>
                                            </div>
                                            <div class="order-date">
                                                <i class="bi bi-calendar3"></i>
                                                {{ $order->created_at->format('M d, Y') }}
                                            </div>
                                        </div>

                                        <div class="order-card-body">
                                            <div class="order-thumbs">
                                                @foreach ($shownItems as $item)
                                                    <div class="order-thumb">
                                                        <img src="{{ $item->product ? $item->product->primary_image_url : asset('assets/images/products/product-f-1.webp') }}"
                                                             alt="{{ $item->product ? $item->product->name : 'Product' }}"
                                                             title="{{ $item->product ? $item->product->name : 'Product' }}"
                                                             loading="lazy">
                                                    </div>
                                                @endforeach
                                                @if ($extraCount > 0)
                                                    <div class="order-thumb order-thumb-more">+{{ $extraCount }}</div>
                                                @endif
                                            </div>

                                            <div class="order-summary">
                                                <div class="order-summary-row">
                                                    <span>Status</span>
                                                    <span class="order-status-badge" style="background:{{ $cfg['bg'] }}; color:{{ $cfg['color'] }};">
                                                        <i class="bi {{ $cfg['icon'] }}"></i>
                                                        {{ $status }}
                                                    </span>
                                                </div>
                                                <div class="order-summary-row">
                                                    <span>Items</span>
                                                    <span>{{ $itemCount }} item{{ $itemCount !== 1 ? 's' : '' }}</span>
                                                </div>
                                                <div class="order-summary-row total-row">
                                                    <span>Total</span>
                                                    <strong>Rs. {{ number_format($order->total_amount) }}</strong>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="order-card-actions">
                                            @if ($status === 'Delivered')
                                                <button type="button" class="order-btn order-btn-outline-success btn-order-write-review" data-product-id="{{ $firstProduct ? $firstProduct->id : '' }}">
                                                    <i class="bi bi-pencil-square"></i> Write Review
                                                </button>
                                            @elseif ($status === 'Cancelled')
                                                <a href="{{ route('products.index') }}" class="order-btn order-btn-outline-primary" style="text-decoration:none;">
                                                    <i class="bi bi-arrow-repeat"></i> Reorder
                                                </a>
                                            @else
                                                <a href="{{ route('contact') }}" class="order-btn order-btn-dark" style="text-decoration:none;">
                                                    <i class="bi bi-geo-alt"></i> Track Order
                                                </a>
                                            @endif
                                            <span class="order-btn order-btn-secondary" style="cursor: default;">
                                                <i class="bi bi-receipt"></i> #{{ $order->order_number }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </main>
                </div>

                <!-- TAB 2: WISHLIST -->
                <div class="tab-pane fade" id="v-pills-wishlist" role="tabpanel">
                    <main class="account-content">
                        <div class="content-header">
                            <h3>My Wishlist (<span class="wishlist-total-count">{{ count($wishlistItems) }}</span>)</h3>
                            <div class="header-actions">
                                @if (!empty($wishlistItems))
                                    <button type="button" class="btn-secondary btn-add-all-wishlist">
                                        <i class="bi bi-cart-plus"></i> Add All to Cart
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div class="wishlist-grid">
                            @if (empty($wishlistItems))
                                <div class="empty-wishlist-state text-center py-5" style="grid-column: 1 / -1; padding: 50px 20px;">
                                    <div style="font-size: 54px; color: var(--color-border); margin-bottom: 15px;">
                                        <i class="bi bi-heart"></i>
                                    </div>
                                    <h4 style="font-weight: 700; color: var(--color-heading); margin-bottom: 10px;">Your wishlist is empty</h4>
                                    <p style="color: var(--color-text-light); max-width: 420px; margin: 0 auto 24px;">
                                        Explore our collection and add your favorite items to your wishlist for easy access anytime.
                                    </p>
                                    <a href="{{ route('products.index') }}" class="btn btn-primary" style="padding: 10px 26px; border-radius: 999px; text-decoration: none; font-weight: 600;">
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
                                            <div class="wishlist-stock">
                                                <i class="bi {{ $wItem['in_stock'] ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger' }}"></i>
                                                <span>{{ $wItem['in_stock'] ? 'In Stock' : 'Out of Stock' }}</span>
                                            </div>
                                            <button type="button" class="btn-add-cart-wishlist add-cart-button" data-product-id="{{ $wItem['product_id'] }}" {{ $wItem['in_stock'] ? '' : 'disabled' }}>
                                                <i class="bi bi-cart-plus"></i> Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </main>
                </div>

                <!-- TAB 3: PAYMENT METHODS -->
                <div class="tab-pane fade" id="v-pills-payments" role="tabpanel">
                    <main class="account-content">
                        <div class="content-header">
                            <div class="content-header-left">
                                <h3>Payment Methods</h3>
                                @if ($paymentMethods->isNotEmpty())
                                    <span class="orders-total-badge">{{ $paymentMethods->count() }} Saved</span>
                                @endif
                            </div>
                            <button type="button" class="btn-primary-profile" data-bs-toggle="modal" data-bs-target="#addCardModal">
                                <i class="bi bi-plus-lg"></i> Add New Card
                            </button>
                        </div>

                        @if ($paymentMethods->isEmpty())
                            <div class="profile-empty-state">
                                <div class="profile-empty-icon">
                                    <i class="bi bi-credit-card-2-front"></i>
                                </div>
                                <h4>No payment methods saved</h4>
                                <p>Add your debit or credit card to enable smooth, one-click checkout for your future purchases.</p>
                                <button type="button" class="btn-primary-profile" data-bs-toggle="modal" data-bs-target="#addCardModal">
                                    <i class="bi bi-plus-lg"></i> Add Your First Card
                                </button>
                            </div>
                        @else
                            <div class="payment-grid">
                                @foreach ($paymentMethods as $card)
                                    <div class="payment-card {{ $card->is_default ? 'payment-card-default' : '' }}">
                                        <div class="payment-card-header">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi {{ $card->card_type === 'Mastercard' ? 'bi-credit-card' : 'bi-credit-card-2-front' }} payment-icon"></i>
                                                <span class="payment-brand">{{ $card->card_type }}</span>
                                            </div>
                                            @if ($card->is_default)
                                                <span class="status-badge delivered"><i class="bi bi-check-circle-fill"></i> Default</span>
                                            @endif
                                        </div>
                                        <div class="payment-card-number">•••• •••• •••• {{ $card->card_last_four }}</div>
                                        <div class="payment-card-meta">
                                            <div>
                                                <span class="meta-label">Cardholder</span>
                                                <span class="meta-value">{{ $card->cardholder_name }}</span>
                                            </div>
                                            <div>
                                                <span class="meta-label">Expires</span>
                                                <span class="meta-value">{{ $card->expiry_month }}/{{ substr($card->expiry_year, -2) }}</span>
                                            </div>
                                        </div>
                                        <div class="card-actions">
                                            @if (!$card->is_default)
                                                <form action="{{ route('profile.payments.default', $card->id) }}" method="POST" style="margin: 0;">
                                                    @csrf
                                                    <button type="submit" class="btn-action">
                                                        <i class="bi bi-star"></i> Set as Default
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('profile.payments.destroy', $card->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Are you sure you want to remove this payment card?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action text-danger">
                                                    <i class="bi bi-trash"></i> Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </main>
                </div>

                <!-- TAB 4: MY REVIEWS -->
                <div class="tab-pane fade" id="v-pills-reviews" role="tabpanel">
                    <main class="account-content">
                        <div class="content-header">
                            <div class="content-header-left">
                                <h3>My Reviews</h3>
                                @if ($reviews->isNotEmpty())
                                    <span class="orders-total-badge">{{ $reviews->count() }} Review{{ $reviews->count() !== 1 ? 's' : '' }}</span>
                                @endif
                            </div>
                            <button type="button" class="btn-primary-profile" data-bs-toggle="modal" data-bs-target="#addReviewModal">
                                <i class="bi bi-pencil-square"></i> Write a Review
                            </button>
                        </div>

                        @if ($reviews->isEmpty())
                            <div class="profile-empty-state">
                                <div class="profile-empty-icon">
                                    <i class="bi bi-star"></i>
                                </div>
                                <h4>No reviews written yet</h4>
                                <p>Have you purchased items from our store? Share your honest feedback to help fellow customers make confident decisions.</p>
                                <button type="button" class="btn-primary-profile" data-bs-toggle="modal" data-bs-target="#addReviewModal">
                                    <i class="bi bi-pencil-square"></i> Write a Review
                                </button>
                            </div>
                        @else
                            <div class="reviews-list">
                                @foreach ($reviews as $rev)
                                    <div class="review-card">
                                        <a href="{{ $rev->product ? route('products.show', $rev->product->id) : '#' }}" class="review-product-link">
                                            <img src="{{ $rev->product ? $rev->product->primary_image_url : asset('assets/images/products/product-f-1.webp') }}"
                                                 alt="{{ $rev->product ? $rev->product->name : 'Product' }}"
                                                 class="review-product-img">
                                        </a>
                                        <div class="review-content">
                                            <div class="review-header-row">
                                                <div>
                                                    <h4 class="review-product-name">
                                                        @if ($rev->product)
                                                            <a href="{{ route('products.show', $rev->product->id) }}" style="text-decoration:none; color:inherit;">
                                                                {{ $rev->product->name }}
                                                            </a>
                                                        @else
                                                            Product Review
                                                        @endif
                                                    </h4>
                                                    <div class="review-stars">
                                                        @for ($s = 1; $s <= 5; $s++)
                                                            <i class="bi {{ $s <= $rev->rating ? 'bi-star-fill text-warning' : 'bi-star text-muted' }}"></i>
                                                        @endfor
                                                        <span class="review-date">
                                                            Reviewed on {{ $rev->created_at->format('M d, Y') }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <form action="{{ route('profile.reviews.destroy', $rev->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-action text-danger" title="Delete Review">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <p class="review-text">{{ $rev->comment }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </main>
                </div>

                <!-- TAB 5: ADDRESSES -->
                <div class="tab-pane fade" id="v-pills-addresses" role="tabpanel">
                    <main class="account-content">
                        <div class="content-header">
                            <div class="content-header-left">
                                <h3>My Addresses</h3>
                                @if ($addresses->isNotEmpty())
                                    <span class="orders-total-badge">{{ $addresses->count() }} Saved</span>
                                @endif
                            </div>
                            <button type="button" class="btn-primary-profile" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                <i class="bi bi-plus-lg"></i> Add New Address
                            </button>
                        </div>

                        @if ($addresses->isEmpty())
                            <div class="profile-empty-state">
                                <div class="profile-empty-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <h4>No saved addresses</h4>
                                <p>Save your home and office shipping addresses for faster and smoother order checkouts.</p>
                                <button type="button" class="btn-primary-profile" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                    <i class="bi bi-plus-lg"></i> Add Your First Address
                                </button>
                            </div>
                        @else
                            <div class="address-grid">
                                @foreach ($addresses as $addr)
                                    <div class="address-card {{ $addr->is_default ? 'address-card-default' : '' }}">
                                        <div class="address-header">
                                            <h4 class="address-title">
                                                <i class="bi {{ strtolower($addr->title) === 'office' ? 'bi-briefcase' : (strtolower($addr->title) === 'home' ? 'bi-house' : 'bi-geo-alt') }} me-1"></i>
                                                {{ $addr->title }}
                                            </h4>
                                            @if ($addr->is_default)
                                                <span class="status-badge delivered"><i class="bi bi-check-circle-fill"></i> Default</span>
                                            @endif
                                        </div>
                                        <div class="address-body">
                                            <div class="address-lines">
                                                <div>{{ $addr->address_line1 }}</div>
                                                @if ($addr->address_line2)
                                                    <div>{{ $addr->address_line2 }}</div>
                                                @endif
                                                <div>{{ $addr->city }}{{ $addr->state ? ', ' . $addr->state : '' }} {{ $addr->postal_code }}</div>
                                                <div>{{ $addr->country }}</div>
                                            </div>

                                            <div class="address-contact">
                                                <div class="contact-line">
                                                    <i class="bi bi-person"></i> <span>{{ $addr->recipient_name }}</span>
                                                </div>
                                                <div class="contact-line">
                                                    <i class="bi bi-telephone"></i> <span>{{ $addr->phone }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="address-actions">
                                            <button type="button" class="btn-action btn-edit-address"
                                                data-id="{{ $addr->id }}"
                                                data-title="{{ $addr->title }}"
                                                data-recipient-name="{{ $addr->recipient_name }}"
                                                data-phone="{{ $addr->phone }}"
                                                data-line1="{{ $addr->address_line1 }}"
                                                data-line2="{{ $addr->address_line2 }}"
                                                data-city="{{ $addr->city }}"
                                                data-state="{{ $addr->state }}"
                                                data-postal-code="{{ $addr->postal_code }}"
                                                data-country="{{ $addr->country }}"
                                                data-is-default="{{ $addr->is_default ? 1 : 0 }}">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            @if (!$addr->is_default)
                                                <form action="{{ route('profile.addresses.default', $addr->id) }}" method="POST" style="margin: 0;">
                                                    @csrf
                                                    <button type="submit" class="btn-action">
                                                        <i class="bi bi-star"></i> Set Default
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('profile.addresses.destroy', $addr->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Are you sure you want to remove this address?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action text-danger">
                                                    <i class="bi bi-trash"></i> Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </main>
                </div>

                <!-- TAB 6: ACCOUNT SETTINGS -->
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel">
                    <main class="account-content">
                        <div class="content-header">
                            <h3>Account Settings</h3>
                        </div>

                        <!-- Personal Information & Email Preferences Form -->
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="settings-block">
                                <div class="settings-block-header">
                                    <div>
                                        <h4><i class="bi bi-person-circle me-2 text-primary"></i>Personal Information</h4>
                                        <p class="settings-block-desc">Manage your profile details and primary contact information.</p>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="profile_name">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" id="profile_name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required placeholder="e.g. John Doe">
                                    </div>
                                    <div class="form-group">
                                        <label for="profile_email">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" id="profile_email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required placeholder="e.g. user@example.com">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="profile_phone">Phone Number</label>
                                        <input type="text" id="profile_phone" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="e.g. +92 300 1234567">
                                    </div>
                                    <div class="form-group">
                                        <label for="profile_country">Country / Region</label>
                                        <input type="text" id="profile_country" name="country" class="form-control" value="{{ old('country', $user->country ?? 'Pakistan') }}" placeholder="e.g. Pakistan">
                                    </div>
                                </div>

                                <div class="settings-subheading mt-4 mb-3">
                                    <h5 style="font-size: 14px; font-weight: 700; color: var(--color-heading); margin-bottom: 4px;">
                                        <i class="bi bi-bell me-2 text-primary"></i>Email & Notification Preferences
                                    </h5>
                                    <p style="font-size: 12px; color: var(--color-text-light); margin: 0;">Control which updates and newsletters you receive via email.</p>
                                </div>

                                <div class="toggle-row">
                                    <div class="toggle-info">
                                        <h5>Order Status Updates</h5>
                                        <p>Receive live email notifications whenever your order status changes</p>
                                    </div>
                                    <label class="switch-container">
                                        <input type="checkbox" name="order_updates" value="1" class="toggle-switch-input" {{ old('order_updates', $user->order_updates) ? 'checked' : '' }}>
                                        <span class="switch-slider"></span>
                                    </label>
                                </div>

                                <div class="toggle-row">
                                    <div class="toggle-info">
                                        <h5>Promotions & Exclusive Deals</h5>
                                        <p>Get early bird access to sales, seasonal discounts and new product arrivals</p>
                                    </div>
                                    <label class="switch-container">
                                        <input type="checkbox" name="promotions" value="1" class="toggle-switch-input" {{ old('promotions', $user->promotions) ? 'checked' : '' }}>
                                        <span class="switch-slider"></span>
                                    </label>
                                </div>

                                <div class="settings-actions mt-4">
                                    <button type="submit" class="btn-primary-profile">
                                        <i class="bi bi-check2"></i> Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Change Password Block -->
                        <div class="settings-block">
                            <div class="settings-block-header">
                                <div>
                                    <h4><i class="bi bi-shield-lock me-2 text-primary"></i>Change Password</h4>
                                    <p class="settings-block-desc">Ensure your account uses a strong and unique password.</p>
                                </div>
                            </div>

                            <form action="{{ route('profile.password') }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-row">
                                    <div class="form-group" style="grid-column: 1 / -1;">
                                        <label for="current_password">Current Password <span class="text-danger">*</span></label>
                                        <div class="input-password-wrapper">
                                            <input type="password" id="current_password" name="current_password" class="form-control" required placeholder="Enter current password">
                                            <button type="button" class="btn-toggle-password" data-target="current_password" tabindex="-1">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="new_password">New Password <span class="text-danger">*</span></label>
                                        <div class="input-password-wrapper">
                                            <input type="password" id="new_password" name="password" class="form-control" required minlength="8" placeholder="Minimum 8 characters">
                                            <button type="button" class="btn-toggle-password" data-target="new_password" tabindex="-1">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="new_password_confirmation">Confirm New Password <span class="text-danger">*</span></label>
                                        <div class="input-password-wrapper">
                                            <input type="password" id="new_password_confirmation" name="password_confirmation" class="form-control" required minlength="8" placeholder="Re-type new password">
                                            <button type="button" class="btn-toggle-password" data-target="new_password_confirmation" tabindex="-1">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="settings-actions mt-4">
                                    <button type="submit" class="btn-primary-profile">
                                        <i class="bi bi-shield-check"></i> Update Password
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Danger Zone Block -->
                        <div class="settings-block danger-zone">
                            <div class="settings-block-header">
                                <div>
                                    <h4 class="text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Delete Account</h4>
                                    <p class="settings-block-desc">Permanently remove your account and all associated data.</p>
                                </div>
                            </div>
                            <p class="danger-text">
                                Once your account is deleted, all past order history, saved addresses, payment methods, and reviews will be permanently removed. This action cannot be undone.
                            </p>
                            <button type="button" class="btn-danger-profile" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                <i class="bi bi-trash"></i> Delete Account
                            </button>
                        </div>
                    </main>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- ==========================================
     MODALS
=========================================== -->

<!-- 1. Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content profile-modal-content">
            <form action="{{ route('profile.addresses.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addAddressModalLabel"><i class="bi bi-geo-alt me-2 text-primary"></i> Add New Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Address Label / Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Home, Office, Studio" required>
                        </div>
                        <div class="form-group">
                            <label>Recipient Name <span class="text-danger">*</span></label>
                            <input type="text" name="recipient_name" class="form-control" value="{{ $user->name }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" placeholder="e.g. +92 300 1234567" required>
                        </div>
                        <div class="form-group">
                            <label>Country <span class="text-danger">*</span></label>
                            <input type="text" name="country" class="form-control" value="{{ $user->country ?? 'Pakistan' }}" required>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Street Address (Line 1) <span class="text-danger">*</span></label>
                        <input type="text" name="address_line1" class="form-control" placeholder="House/Flat number, Street name, Sector" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Apartment, suite, unit (Line 2) <span class="text-muted">(Optional)</span></label>
                        <input type="text" name="address_line2" class="form-control" placeholder="Floor, building, nearest landmark">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>City <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control" placeholder="e.g. Lahore, Karachi, Islamabad" required>
                        </div>
                        <div class="form-group">
                            <label>State / Province</label>
                            <input type="text" name="state" class="form-control" placeholder="e.g. Punjab, Sindh">
                        </div>
                        <div class="form-group">
                            <label>Postal Code</label>
                            <input type="text" name="postal_code" class="form-control" placeholder="e.g. 54000">
                        </div>
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" name="is_default" value="1" id="add_is_default" {{ $addresses->isEmpty() ? 'checked' : '' }}>
                        <label class="form-check-label" for="add_is_default" style="font-size: 13px; font-weight: 500;">
                            Set as default shipping address
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary-profile" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-profile"><i class="bi bi-check-lg"></i> Save Address</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 2. Edit Address Modal -->
<div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content profile-modal-content">
            <form id="editAddressForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editAddressModalLabel"><i class="bi bi-pencil-square me-2 text-primary"></i> Edit Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Address Label / Title <span class="text-danger">*</span></label>
                            <input type="text" id="edit_address_title" name="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Recipient Name <span class="text-danger">*</span></label>
                            <input type="text" id="edit_recipient_name" name="recipient_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Phone Number <span class="text-danger">*</span></label>
                            <input type="text" id="edit_phone" name="phone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Country <span class="text-danger">*</span></label>
                            <input type="text" id="edit_country" name="country" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Street Address (Line 1) <span class="text-danger">*</span></label>
                        <input type="text" id="edit_address_line1" name="address_line1" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Apartment, suite, unit (Line 2) <span class="text-muted">(Optional)</span></label>
                        <input type="text" id="edit_address_line2" name="address_line2" class="form-control">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>City <span class="text-danger">*</span></label>
                            <input type="text" id="edit_city" name="city" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>State / Province</label>
                            <input type="text" id="edit_state" name="state" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Postal Code</label>
                            <input type="text" id="edit_postal_code" name="postal_code" class="form-control">
                        </div>
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" name="is_default" value="1" id="edit_is_default">
                        <label class="form-check-label" for="edit_is_default" style="font-size: 13px; font-weight: 500;">
                            Set as default shipping address
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary-profile" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-profile"><i class="bi bi-check-lg"></i> Update Address</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 3. Add Card Modal -->
<div class="modal fade" id="addCardModal" tabindex="-1" aria-labelledby="addCardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content profile-modal-content">
            <form action="{{ route('profile.payments.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addCardModalLabel"><i class="bi bi-credit-card-2-front me-2 text-primary"></i> Add Payment Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Cardholder Name <span class="text-danger">*</span></label>
                        <input type="text" name="cardholder_name" class="form-control" value="{{ $user->name }}" required placeholder="Name on card">
                    </div>
                    <div class="form-group mb-3">
                        <label>Card Number <span class="text-danger">*</span></label>
                        <div class="input-card-wrapper">
                            <input type="text" id="add_card_number" name="card_number" class="form-control" maxlength="19" placeholder="4242 •••• •••• 4242" required autocomplete="cc-number">
                            <span class="card-type-icon"><i class="bi bi-credit-card"></i></span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Expiry Month <span class="text-danger">*</span></label>
                            <select name="expiry_month" class="form-control form-select" required>
                                <option value="" disabled selected>MM</option>
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ sprintf('%02d', $m) }}">{{ sprintf('%02d', $m) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Expiry Year <span class="text-danger">*</span></label>
                            <select name="expiry_year" class="form-control form-select" required>
                                <option value="" disabled selected>YYYY</option>
                                @for ($y = date('Y'); $y <= date('Y') + 12; $y++)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label>CVV / CVC <span class="text-muted">(Optional)</span></label>
                            <input type="password" maxlength="4" class="form-control" placeholder="123" autocomplete="cc-csc">
                        </div>
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" name="is_default" value="1" id="add_card_is_default" {{ $paymentMethods->isEmpty() ? 'checked' : '' }}>
                        <label class="form-check-label" for="add_card_is_default" style="font-size: 13px; font-weight: 500;">
                            Set as default payment card
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary-profile" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-profile"><i class="bi bi-check-lg"></i> Save Card</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 4. Write Review Modal -->
<div class="modal fade" id="addReviewModal" tabindex="-1" aria-labelledby="addReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content profile-modal-content">
            <form action="{{ route('profile.reviews.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addReviewModalLabel"><i class="bi bi-pencil-square me-2 text-primary"></i> Write a Product Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Select Product <span class="text-danger">*</span></label>
                        <select name="product_id" id="review_product_id" class="form-control form-select" required>
                            <option value="" disabled selected>Choose a product to review</option>
                            @foreach ($products as $prod)
                                <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Your Rating <span class="text-danger">*</span></label>
                        <input type="hidden" name="rating" id="review_rating_input" value="5">
                        <div class="star-rating-select" id="starRatingSelector">
                            <i class="bi bi-star-fill active" data-rating="1"></i>
                            <i class="bi bi-star-fill active" data-rating="2"></i>
                            <i class="bi bi-star-fill active" data-rating="3"></i>
                            <i class="bi bi-star-fill active" data-rating="4"></i>
                            <i class="bi bi-star-fill active" data-rating="5"></i>
                            <span class="rating-label ms-2" id="starRatingLabel">5 / 5 Stars</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Your Review <span class="text-danger">*</span></label>
                        <textarea name="comment" rows="4" class="form-control" minlength="5" maxlength="1000" placeholder="Share your experience with this product... (e.g. quality, material, durability)" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary-profile" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-primary-profile"><i class="bi bi-send"></i> Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 5. Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content profile-modal-content">
            <form action="{{ route('profile.deleteAccount') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title text-danger" id="deleteAccountModalLabel">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Delete Account Confirmation
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="color: var(--color-heading); font-size: 14px; margin-bottom: 12px; font-weight: 600;">
                        Are you sure you want to permanently delete your Velyora account?
                    </p>
                    <p style="color: var(--color-text-light); font-size: 13px; line-height: 1.6; margin: 0;">
                        This action cannot be undone. All your past orders, shipping addresses, payment methods, and reviews will be completely wiped from our database.
                    </p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn-secondary-profile" data-bs-dismiss="modal">Keep Account</button>
                    <button type="submit" class="btn-danger-profile">Yes, Delete My Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    /* Tab activation from URL hash */
    function activateTabFromHash() {
        const hash = window.location.hash;
        if (hash) {
            const trigger = document.querySelector(`[data-bs-target="${hash}"]`);
            if (trigger && typeof bootstrap !== 'undefined') {
                const tab = bootstrap.Tab.getOrCreateInstance(trigger);
                tab.show();
            }
        }
    }
    activateTabFromHash();
    window.addEventListener('hashchange', activateTabFromHash);

    /* Update URL hash when a sidebar tab is shown */
    const tabTriggers = document.querySelectorAll('.sidebar-nav [data-bs-toggle="pill"]');
    tabTriggers.forEach(t => {
        t.addEventListener('shown.bs.tab', function (e) {
            const target = e.target.getAttribute('data-bs-target');
            if (target && history.replaceState) {
                history.replaceState(null, null, target);
            }
        });
    });

    /* Orders Filter and Search */
    const searchInput = document.getElementById('orderSearch');
    const filterToggle = document.getElementById('filterToggle');
    const filterBar = document.getElementById('filterBar');
    const filterChips = document.querySelectorAll('.filter-chip');
    const cards = document.querySelectorAll('.order-card');

    let activeStatus = 'all';

    function applyFilters() {
        const q = (searchInput?.value || '').toLowerCase();
        cards.forEach(card => {
            const status = (card.dataset.status || '').toLowerCase();
            const search = (card.dataset.search || '').toLowerCase();
            const statusMatch = activeStatus === 'all' || status === activeStatus.toLowerCase();
            const searchMatch = !q || search.includes(q);
            card.style.display = (statusMatch && searchMatch) ? '' : 'none';
        });
    }

    filterToggle?.addEventListener('click', () => {
        if (filterBar) {
            filterBar.style.display = filterBar.style.display === 'none' ? 'flex' : 'none';
        }
    });

    filterChips.forEach(chip => {
        chip.addEventListener('click', () => {
            filterChips.forEach(c => c.classList.remove('active'));
            chip.classList.add('active');
            activeStatus = chip.dataset.status;
            applyFilters();
        });
    });

    searchInput?.addEventListener('input', applyFilters);

    /* Edit Address Modal Pre-fill */
    const editAddressBtns = document.querySelectorAll('.btn-edit-address');
    editAddressBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const form = document.getElementById('editAddressForm');
            form.action = "{{ url('my-profile/addresses') }}/" + id;

            document.getElementById('edit_address_title').value = this.dataset.title || '';
            document.getElementById('edit_recipient_name').value = this.dataset.recipientName || '';
            document.getElementById('edit_phone').value = this.dataset.phone || '';
            document.getElementById('edit_address_line1').value = this.dataset.line1 || '';
            document.getElementById('edit_address_line2').value = this.dataset.line2 || '';
            document.getElementById('edit_city').value = this.dataset.city || '';
            document.getElementById('edit_state').value = this.dataset.state || '';
            document.getElementById('edit_postal_code').value = this.dataset.postalCode || '';
            document.getElementById('edit_country').value = this.dataset.country || 'Pakistan';
            document.getElementById('edit_is_default').checked = this.dataset.isDefault === '1';

            const modal = new bootstrap.Modal(document.getElementById('editAddressModal'));
            modal.show();
        });
    });

    /* Write Review Trigger from Delivered Orders */
    const orderReviewBtns = document.querySelectorAll('.btn-order-write-review');
    orderReviewBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const productId = this.dataset.productId;
            if (productId) {
                const select = document.getElementById('review_product_id');
                if (select) select.value = productId;
            }
            const modal = new bootstrap.Modal(document.getElementById('addReviewModal'));
            modal.show();
        });
    });

    /* Interactive Star Rating Selector in Review Modal */
    const starContainer = document.getElementById('starRatingSelector');
    if (starContainer) {
        const stars = starContainer.querySelectorAll('i');
        const hiddenInput = document.getElementById('review_rating_input');
        const label = document.getElementById('starRatingLabel');

        function setStars(rating) {
            stars.forEach(star => {
                const r = parseInt(star.dataset.rating, 10);
                if (r <= rating) {
                    star.className = 'bi bi-star-fill active';
                } else {
                    star.className = 'bi bi-star';
                }
            });
            if (hiddenInput) hiddenInput.value = rating;
            if (label) label.textContent = `${rating} / 5 Stars`;
        }

        stars.forEach(star => {
            star.addEventListener('mouseenter', function () {
                const hoverRating = parseInt(this.dataset.rating, 10);
                stars.forEach(s => {
                    const r = parseInt(s.dataset.rating, 10);
                    if (r <= hoverRating) {
                        s.classList.add('hover');
                    } else {
                        s.classList.remove('hover');
                    }
                });
            });

            star.addEventListener('click', function () {
                const chosen = parseInt(this.dataset.rating, 10);
                setStars(chosen);
            });
        });

        starContainer.addEventListener('mouseleave', function () {
            stars.forEach(s => s.classList.remove('hover'));
            const current = parseInt(hiddenInput?.value || 5, 10);
            setStars(current);
        });
    }

    /* Auto-format Card Number with spaces */
    const cardInput = document.getElementById('add_card_number');
    if (cardInput) {
        cardInput.addEventListener('input', function (e) {
            let val = e.target.value.replace(/\D/g, '').substring(0, 16);
            let parts = [];
            for (let i = 0; i < val.length; i += 4) {
                parts.push(val.substring(i, i + 4));
            }
            e.target.value = parts.join(' ');
        });
    }

    /* Password Visibility Toggle */
    document.querySelectorAll('.btn-toggle-password').forEach(btn => {
        btn.addEventListener('click', function () {
            const targetId = this.dataset.target;
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            if (input) {
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'bi bi-eye-slash';
                } else {
                    input.type = 'password';
                    icon.className = 'bi bi-eye';
                }
            }
        });
    });
});
</script>
@endpush
