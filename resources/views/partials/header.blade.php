<!-- =========================================================
     ANNOUNCEMENT BAR
========================================================= -->
<div class="announcement-bar">
    <div class="container">
        <div class="announcement-content">
            <span>
                <i class="bi bi-truck"></i>
                Free delivery on orders over Rs. 3,000
            </span>
            <span class="announcement-divider"></span>
            <span>
                <i class="bi bi-shield-check"></i>
                Secure shopping experience
            </span>
        </div>
    </div>
</div>

<!-- =========================================================
     HEADER
========================================================= -->
<header class="site-header">
    <div class="container">
        <nav class="main-navbar">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="brand-logo">
                <img src="{{ asset('assets/images/logo/logo-light-bg.png') }}" alt="Velyora">
            </a>

            <!-- Search -->
            <div class="header-search">
                <form action="{{ route('products.index') }}" method="GET">
                    <input type="search" name="q" placeholder="Search products, categories or brands..." value="{{ request('q', request('search')) }}">
                    <button type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>

            <!-- Header Actions -->
            <div class="header-actions">
                <!-- Account -->
                <div class="account-dropdown">
                    <button type="button" class="header-action account-dropdown-toggle" aria-expanded="false">
                        <i class="bi bi-person"></i>
                        <span>Account</span>
                    </button>

                    <div class="account-dropdown-menu">
                        @auth
                            <div class="account-dropdown-header">
                                <h3>Hello, {{ auth()->user()->name }}!</h3>
                                <p>Manage your account here</p>
                            </div>

                            <div class="account-dropdown-links">
                                <a href="{{ route('profile') }}">
                                    <i class="bi bi-person-circle"></i>
                                    <span>My Profile</span>
                                </a>
                                <a href="{{ route('orders.index') }}">
                                    <i class="bi bi-box-seam"></i>
                                    <span>My Orders</span>
                                </a>
                                <a href="{{ route('contact') }}">
                                    <i class="bi bi-question-circle"></i>
                                    <span>Help Center</span>
                                </a>
                                <div class="account-dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST" class="account-logout-form">
                                    @csrf
                                    <button type="submit" class="account-logout-btn">
                                        <i class="bi bi-box-arrow-right"></i>
                                        <span>Sign Out</span>
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="account-dropdown-header">
                                <h3>Welcome!</h3>
                                <p>Sign in for the best experience</p>
                            </div>

                            <div class="account-dropdown-actions">
                                <a href="{{ route('login') }}" class="account-signin">Sign In</a>
                                <a href="{{ route('register') }}" class="account-register">Create Account</a>
                            </div>

                            <div class="account-dropdown-links">
                                <a href="{{ route('login') }}">
                                    <i class="bi bi-person-circle"></i>
                                    <span>My Profile</span>
                                </a>
                                <a href="{{ route('contact') }}">
                                    <i class="bi bi-question-circle"></i>
                                    <span>Help Center</span>
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>

                @php
                $headerCartItems = \App\Services\CartService::getCartItems();
                $headerCartCount = \App\Services\CartService::getCartCount();
                $headerCartTotals = \App\Services\CartService::getCartTotals();
                $headerWishlistCount = \App\Services\WishlistService::getWishlistCount();
                @endphp
                
                <!-- Wishlist -->
                <a href="{{ route('wishlist.index') }}" class="header-action" aria-label="View Wishlist">
                    <i class="bi bi-heart"></i>
                    <span>Wishlist</span>
                    <span class="cart-count wishlist-badge-count" style="{{ $headerWishlistCount > 0 ? '' : 'display:none;' }}">{{ $headerWishlistCount }}</span>
                </a>

                <!-- Cart -->
                <div class="cart-dropdown">
                    <!-- The Cart Toggle Button -->
                    <button type="button" class="header-action cart-dropdown-toggle" aria-label="View Cart">
                        <i class="bi bi-bag"></i>
                        <span>Cart</span>
                        <span class="cart-count cart-badge-count" style="{{ $headerCartCount > 0 ? '' : 'display:none;' }}">{{ $headerCartCount }}</span>
                    </button>

                    <!-- The Mini-Cart Menu -->
                    <div class="cart-dropdown-menu">

                        <!-- Cart Header -->
                        <div class="cart-header">
                            <span class="cart-title">Shopping Cart</span>
                            <span class="cart-item-count mini-cart-count">{{ $headerCartCount }} item{{ $headerCartCount === 1 ? '' : 's' }}</span>
                        </div>

                        <!-- Cart Items List -->
                        <div class="cart-items-wrapper">
                            @if(empty($headerCartItems))
                                <div class="mini-cart-empty text-center py-4" style="padding: 24px 15px; color: var(--color-text-light); text-align: center;">
                                    <i class="bi bi-bag" style="font-size: 28px; color: var(--color-border); display: block; margin-bottom: 8px;"></i>
                                    <span style="font-size: 13px;">Your cart is empty</span>
                                </div>
                            @else
                                @foreach($headerCartItems as $hItem)
                                    <div class="cart-item mini-cart-item" data-cart-id="{{ $hItem['cart_id'] }}">
                                        <a href="{{ route('products.show', $hItem['product_id']) }}">
                                            <img src="{{ $hItem['image'] }}" alt="{{ $hItem['name'] }}" class="cart-item-img">
                                        </a>
                                        <div class="cart-item-details">
                                            <h6 class="cart-item-name">
                                                <a href="{{ route('products.show', $hItem['product_id']) }}" style="text-decoration:none; color:inherit;">
                                                    {{ $hItem['name'] }}
                                                </a>
                                            </h6>
                                            <span class="cart-item-variant">{{ $hItem['variant'] ?? 'Standard' }}</span>
                                            <div class="cart-item-price-row">
                                                <span class="cart-item-price">Rs. {{ number_format($hItem['price']) }}</span>
                                                <div class="mini-cart-qty-ctrl">
                                                    <button type="button" class="mini-qty-btn cart-qty-minus" data-cart-id="{{ $hItem['cart_id'] }}" title="Decrease quantity" aria-label="Decrease quantity">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                    <span class="mini-qty-val cart-qty-val">{{ $hItem['quantity'] }}</span>
                                                    <button type="button" class="mini-qty-btn cart-qty-plus" data-cart-id="{{ $hItem['cart_id'] }}" title="Increase quantity" aria-label="Increase quantity">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="cart-item-remove mini-cart-remove" data-cart-id="{{ $hItem['cart_id'] }}" title="Remove item" aria-label="Remove item"><i class="bi bi-x"></i></button>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!-- Cart Footer / Summary -->
                        <div class="cart-footer">
                            <div class="cart-subtotal">
                                <span class="subtotal-label">Subtotal</span>
                                <span class="subtotal-amount mini-cart-subtotal">{{ $headerCartTotals['subtotal_formatted'] }}</span>
                            </div>
                            <a href="{{ route('checkout.index') }}" class="btn-checkout">Checkout</a>
                            <a href="{{ route('cart.index') }}" class="btn-view-cart">View full cart &rarr;</a>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <button class="mobile-menu-button" type="button">
                <i class="bi bi-list"></i>
            </button>
        </nav>
    </div>
</header>
