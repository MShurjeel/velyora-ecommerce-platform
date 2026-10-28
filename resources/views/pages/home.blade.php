@extends('layouts.app')

@section('title', 'Velyora — Everything You Love. One Place.')

@section('content')
<!-- =========================================================
     HERO SECTION
========================================================= -->
<section class="hero-section">
    <div class="container">
        <div class="hero-grid">
            <!-- Hero Content -->
            <div class="hero-content">
                <span class="hero-badge">
                    <i class="bi bi-stars"></i>
                    CURATED FOR YOU
                </span>
                <h1>
                    Everything You Love.
                    <span>One Place.</span>
                </h1>
                <p>
                    Discover thoughtfully selected products across
                    electronics, fashion, lifestyle and more —
                    all brought together in one seamless shopping
                    experience.
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('products.index') }}" class="btn btn-primary-custom">
                        Shop Now
                        <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="#categories" class="btn btn-outline-custom">
                        Explore Categories
                    </a>
                </div>
                <!-- Hero Mini Benefits -->
                <div class="hero-benefits">
                    <div>
                        <i class="bi bi-shield-check"></i>
                        <span>Secure Payment</span>
                    </div>
                    <div>
                        <i class="bi bi-truck"></i>
                        <span>Fast Delivery</span>
                    </div>
                    <div>
                        <i class="bi bi-arrow-repeat"></i>
                        <span>Easy Returns</span>
                    </div>
                </div>
            </div>

            <!-- Hero Product -->
            <div class="hero-product">
                <div class="hero-product-glow"></div>
                <div class="hero-product-card">
                    <span class="product-label">
                        TRENDING NOW
                    </span>
                    @if($heroProduct)
                        <a href="{{ route('products.show', $heroProduct->id) }}" style="text-decoration: none; color: inherit; display: block;">
                            <img src="{{ $heroProduct->primary_image_url }}" alt="{{ $heroProduct->name }}">
                            <div class="hero-product-info">
                                <span>Velyora Featured</span>
                                <h3>{{ $heroProduct->name }}</h3>
                                <strong>Rs. {{ number_format($heroProduct->effective_price) }}</strong>
                            </div>
                        </a>
                    @else
                        <div class="hero-product-info">
                            <span>Velyora Featured</span>
                            <h3>Premium Wireless Headphones</h3>
                            <strong>Rs. 8,499</strong>
                        </div>
                    @endif
                </div>
                <!-- Floating Cards -->
                <div class="floating-product floating-product-one">
                    <i class="bi bi-lightning-charge-fill"></i>
                    <div>
                        <small>Popular</small>
                        <strong>Best Seller</strong>
                    </div>
                </div>
                <div class="floating-product floating-product-two">
                    <i class="bi bi-star-fill"></i>
                    <div>
                        <small>Rated</small>
                        <strong>4.9 / 5</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================
     TRUST FEATURES
========================================================= -->
<section class="trust-section">
    <div class="container">
        <div class="trust-grid">
            <div class="trust-item">
                <div class="trust-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div>
                    <h4>Secure Shopping</h4>
                    <p>Your information stays protected.</p>
                </div>
            </div>
            <div class="trust-item">
                <div class="trust-icon">
                    <i class="bi bi-truck"></i>
                </div>
                <div>
                    <h4>Fast Delivery</h4>
                    <p>Reliable delivery across Pakistan.</p>
                </div>
            </div>
            <div class="trust-item">
                <div class="trust-icon">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <div>
                    <h4>Easy Returns</h4>
                    <p>Simple and hassle-free returns.</p>
                </div>
            </div>
            <div class="trust-item">
                <div class="trust-icon">
                    <i class="bi bi-award"></i>
                </div>
                <div>
                    <h4>Quality Products</h4>
                    <p>Products selected with care.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================
     CATEGORIES
========================================================= -->
<section class="categories-section section-padding" id="categories">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="section-eyebrow">SHOP BY CATEGORY</span>
                <h2>Find What Fits Your World</h2>
                <p>Explore products across the categories you shop most.</p>
            </div>
            <a href="{{ route('products.index') }}" class="view-all-link">
                View All
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="category-grid">
            @php
                $subtitles = [
                    'electronics' => 'Smart devices & technology',
                    'fashion' => 'Style for every occasion',
                    'beauty' => 'Care & personal essentials',
                    'home-living' => 'Make your space yours',
                    'accessories' => 'Complete your everyday look',
                ];
            @endphp
            @foreach ($categories as $index => $cat)
                @php
                    $num = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                    $sub = $subtitles[$cat->slug] ?? ($cat->description ?: 'Explore curated collection');
                @endphp
                <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="category-card category-{{ $cat->slug }}">
                    <div class="category-content">
                        <span>{{ $num }}</span>
                        <h3>{{ $cat->name }}</h3>
                        <p>{{ $sub }}</p>
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- =========================================================
     FEATURED PRODUCTS
========================================================= -->
<section class="products-section section-padding">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="section-eyebrow">CURATED SELECTION</span>
                <h2>Best Sellers</h2>
                <p>Products our customers are loving right now.</p>
            </div>
            <a href="{{ route('products.index') }}" class="view-all-link">
                View All Products
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="product-grid">
            @foreach ($featuredProducts as $product)
                <article class="product-card">
                    <div class="product-image">
                        <!-- Dynamic Badges -->
                        @if (!empty($product->sale_price))
                            <span class="product-badge product-badge-sale">{{ $product->discount_percent }}% OFF</span>
                        @elseif ($product->is_featured == 1)
                            <span class="product-badge">BEST SELLER</span>
                        @endif

                        <button type="button" class="wishlist-button" data-product-id="{{ $product->id }}" aria-label="Add to wishlist">
                            <i class="bi bi-heart"></i>
                        </button>

                        <!-- Dynamic linked product image -->
                        <a href="{{ route('products.show', $product->id) }}" style="display: block;">
                            <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}">
                        </a>
                    </div>

                    <div class="product-info">
                        <span class="product-category">
                            {{ $product->category->name ?? 'General' }}
                        </span>

                        <h3>
                            <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none; color: inherit;">
                                {{ $product->name }}
                            </a>
                        </h3>

                        <div class="product-rating">
                            <span>★★★★★</span>
                            <small>({{ $product->reviews_count_total }})</small>
                        </div>

                        <div class="product-price">
                            @if (!empty($product->sale_price))
                                Rs. {{ number_format($product->sale_price) }}
                                <del>Rs. {{ number_format($product->price) }}</del>
                            @else
                                Rs. {{ number_format($product->price) }}
                            @endif
                        </div>

                        <button class="add-cart-button" type="button" data-product-id="{{ $product->id }}">
                            <i class="bi bi-bag-plus"></i> Add to Cart
                        </button>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<!-- =========================================================
     PROMOTIONAL BANNER
========================================================= -->
<section class="promotion-section">
    <div class="container">
        <div class="promotion-banner">
            <div class="promotion-content">
                <span class="section-eyebrow">VELYORA EXCLUSIVE</span>
                <h2>Better Products. Better Prices.</h2>
                <p>Discover hand-picked products and exclusive deals available for a limited time.</p>
                <a href="{{ route('products.index') }}" class="btn btn-white-custom">
                    Explore Deals
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="promotion-decoration">
                <i class="bi bi-bag-heart"></i>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================
     TRENDING PRODUCTS
========================================================= -->
<section class="products-section section-padding">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="section-eyebrow">WHAT'S TRENDING</span>
                <h2>Trending Right Now</h2>
            </div>
        </div>
        <div class="mini-product-grid">
            @forelse ($trendingProducts as $tProduct)
                <article class="mini-product-card">
                    <a href="{{ route('products.show', $tProduct->id) }}" style="display: block; flex-shrink: 0;">
                        <img src="{{ $tProduct->primary_image_url }}" alt="{{ $tProduct->name }}">
                    </a>
                    <div>
                        <span>{{ $tProduct->category->name ?? 'General' }}</span>
                        <h3>
                            <a href="{{ route('products.show', $tProduct->id) }}" style="text-decoration: none; color: inherit;">
                                {{ $tProduct->name }}
                            </a>
                        </h3>
                        <strong>
                            Rs. {{ number_format($tProduct->effective_price) }}
                        </strong>
                    </div>
                </article>
            @empty
                <p class="text-muted">No trending items right now.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- =========================================================
     NEWSLETTER
========================================================= -->
<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-content">
            <div>
                <span class="section-eyebrow">STAY IN THE LOOP</span>
                <h2>Get the latest from Velyora.</h2>
                <p>New arrivals, exclusive offers and products worth knowing about.</p>
            </div>
            <form class="newsletter-form" action="#" method="POST" onsubmit="event.preventDefault(); alert('Thank you for subscribing to Velyora!');">
                @csrf
                <input type="email" placeholder="Enter your email address" required>
                <button type="submit">
                    Subscribe
                    <i class="bi bi-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
