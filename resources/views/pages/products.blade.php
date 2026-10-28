@extends('layouts.app')

@section('title', 'Shop All Products — Velyora')

@section('content')
<main>
    <!-- =========================================================
         CATALOG HERO
    ========================================================= -->
    <section class="catalog-hero">
        <div class="container">
            <div class="catalog-hero-inner">
                <div>
                    <span class="catalog-eyebrow">VELYORA COLLECTION</span>
                    <h1>Find Something <span>Worth Bringing Home.</span></h1>
                    <p>Explore thoughtfully selected products across electronics, fashion, lifestyle and more.</p>
                </div>
                <nav class="catalog-breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <i class="bi bi-chevron-right"></i>
                    <span>Shop</span>
                </nav>
            </div>
        </div>
    </section>

    <!-- =========================================================
         CATALOG CATEGORIES CAROUSEL / BAR
    ========================================================= -->
    <section class="catalog-categories">
        <div class="container">
            <div class="catalog-category-list">
                <a href="{{ route('products.index') }}" class="catalog-category {{ $selectedCategory === '' ? 'active' : '' }}">
                    <span class="catalog-category-icon"><i class="bi bi-grid"></i></span>
                    <span>All Products</span>
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="catalog-category {{ $selectedCategory === $cat->slug ? 'active' : '' }}">
                        <span class="catalog-category-icon"><i class="bi {{ $cat->icon }}"></i></span>
                        <span>{{ $cat->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- =========================================================
         CATALOG MAIN SECTION
    ========================================================= -->
    <section class="catalog-section">
        <div class="container">
            <div class="catalog-layout">
                <!-- Sidebar Filters -->
                <aside class="catalog-sidebar">
                    <div class="filter-panel">
                        <div class="filter-panel-header">
                            <div>
                                <span class="filter-eyebrow">REFINE</span>
                                <h2>Filters</h2>
                            </div>
                            <a href="{{ route('products.index') }}">Clear All</a>
                        </div>

                        <!-- Categories Filter Group -->
                        <div class="filter-group">
                            <div class="filter-group-title">
                                <span>Categories</span>
                                <i class="bi bi-chevron-up"></i>
                            </div>
                            <label class="filter-option">
                                <input type="radio" name="category" {{ $selectedCategory === '' ? 'checked' : '' }} onclick="window.location.href='{{ route('products.index') }}'">
                                <span>All Products</span>
                                <small>{{ $totalProducts }}</small>
                            </label>
                            @foreach ($categories as $cat)
                                <label class="filter-option">
                                    <input type="radio" name="category" {{ $selectedCategory === $cat->slug ? 'checked' : '' }} onclick="window.location.href='{{ route('products.index', ['category' => $cat->slug]) }}'">
                                    <span>{{ $cat->name }}</span>
                                    <small>{{ $cat->products_count }}</small>
                                </label>
                            @endforeach
                        </div>

                        <!-- Price Range Filter Group -->
                        <form id="priceFilterForm" action="{{ route('products.index') }}" method="GET">
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if(request('q'))
                                <input type="hidden" name="q" value="{{ request('q') }}">
                            @endif
                            @if(request('sort'))
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                            @endif

                            <div class="filter-group">
                                <div class="filter-group-title">
                                    <span>Price Range</span>
                                    <i class="bi bi-chevron-up"></i>
                                </div>
                                <div class="price-range-labels">
                                    <span>Rs. 0</span>
                                    <span>Rs. 25,000+</span>
                                </div>
                                <input type="range" min="0" max="25000" step="500" value="{{ $maxPrice ?? 25000 }}" class="price-range" id="priceRangeInput" name="max_price" oninput="document.getElementById('maxPriceDisplay').value = this.value">
                                <div class="price-inputs">
                                    <div>
                                        <span>Rs.</span>
                                        <input type="text" name="min_price" value="{{ $minPrice ?? 0 }}" placeholder="0">
                                    </div>
                                    <div>
                                        <span>Rs.</span>
                                        <input type="text" id="maxPriceDisplay" value="{{ $maxPrice ?? 25000 }}" placeholder="25000">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary-profile w-100 mt-2" style="padding: 6px 12px; font-size: 12px; width: 100%; justify-content: center; margin-top: 10px;">
                                    Apply Price
                                </button>
                            </div>

                            <!-- Availability Filter Group -->
                            <div class="filter-group filter-group-last">
                                <div class="filter-group-title">
                                    <span>Availability & Offers</span>
                                    <i class="bi bi-chevron-up"></i>
                                </div>
                                <label class="filter-option">
                                    <input type="checkbox" name="in_stock" value="1" {{ $inStock === '1' ? 'checked' : '' }} onchange="this.form.submit()">
                                    <span>In Stock Only</span>
                                </label>
                                <label class="filter-option">
                                    <input type="checkbox" name="on_sale" value="1" {{ ($filter === 'sale' || request('on_sale') === '1') ? 'checked' : '' }} onchange="this.form.submit()">
                                    <span>On Sale / Deals</span>
                                </label>
                            </div>
                        </form>
                    </div>
                </aside>

                <!-- Products Grid / Results -->
                <div class="catalog-content">
                    <div class="catalog-toolbar">
                        <div class="catalog-toolbar-top">
                            <div>
                                <span class="catalog-results-label">Showing</span>
                                <strong>{{ count($filteredProducts) }}</strong>
                                <span class="catalog-results-label">products</span>
                            </div>
                            <button class="mobile-filter-button" type="button">
                                <i class="bi bi-sliders"></i> Filters
                            </button>
                            <div class="catalog-sort">
                                <label for="sort">Sort by</label>
                                <select id="sort" onchange="window.location.href=this.value;">
                                    <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'featured'])) }}" {{ $sort === 'featured' ? 'selected' : '' }}>Featured</option>
                                    <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'newest'])) }}" {{ $sort === 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
                                    <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price-low'])) }}" {{ $sort === 'price-low' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price-high'])) }}" {{ $sort === 'price-high' ? 'selected' : '' }}>Price: High to Low</option>
                                </select>
                            </div>
                        </div>

                        <!-- Active Filters Badges -->
                        <div class="active-filters">
                            <span class="active-filter-label">Active filters:</span>
                            @if ($selectedCategory !== '')
                                <a href="{{ route('products.index', array_filter(request()->query(), fn($k) => $k !== 'category', ARRAY_FILTER_USE_KEY)) }}" class="active-filter">
                                    Category: {{ ucwords(str_replace('-', ' ', $selectedCategory)) }}
                                    <i class="bi bi-x"></i>
                                </a>
                            @endif
                            @if ($searchQuery !== '')
                                <a href="{{ route('products.index', array_filter(request()->query(), fn($k) => !in_array($k, ['search', 'q']), ARRAY_FILTER_USE_KEY)) }}" class="active-filter">
                                    Search: {{ $searchQuery }}
                                    <i class="bi bi-x"></i>
                                </a>
                            @endif
                            @if ($maxPrice && $maxPrice < 25000)
                                <a href="{{ route('products.index', array_filter(request()->query(), fn($k) => $k !== 'max_price', ARRAY_FILTER_USE_KEY)) }}" class="active-filter">
                                    Max: Rs. {{ number_format($maxPrice) }}
                                    <i class="bi bi-x"></i>
                                </a>
                            @endif
                            @if ($inStock === '1')
                                <a href="{{ route('products.index', array_filter(request()->query(), fn($k) => $k !== 'in_stock', ARRAY_FILTER_USE_KEY)) }}" class="active-filter">
                                    In Stock Only
                                    <i class="bi bi-x"></i>
                                </a>
                            @endif
                            @if ($filter === 'sale' || request('on_sale') === '1')
                                <a href="{{ route('products.index', array_filter(request()->query(), fn($k) => !in_array($k, ['filter', 'on_sale']), ARRAY_FILTER_USE_KEY)) }}" class="active-filter">
                                    On Sale
                                    <i class="bi bi-x"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    @if ($filteredProducts->isNotEmpty())
                        <div class="catalog-product-grid">
                            @foreach ($filteredProducts as $product)
                                <article class="catalog-product-card">
                                    <div class="catalog-product-image">
                                        @if (!empty($product->sale_price))
                                            <span class="catalog-product-badge sale">{{ $product->discount_percent }}% OFF</span>
                                        @elseif ($product->is_featured == 1)
                                            <span class="catalog-product-badge">BEST SELLER</span>
                                        @endif

                                        @php
                                            $prodInWishlist = \App\Services\WishlistService::isInWishlist($product->id);
                                        @endphp
                                        <button class="catalog-wishlist {{ $prodInWishlist ? 'active' : '' }}" type="button" aria-label="Add to wishlist" data-product-id="{{ $product->id }}">
                                            <i class="bi {{ $prodInWishlist ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                                        </button>

                                        <a href="{{ route('products.show', $product->id) }}" style="display: contents;">
                                            <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}">
                                        </a>
                                    </div>
                                    <div class="catalog-product-info">
                                        <span class="catalog-product-category">
                                            {{ $product->category->name ?? 'General' }}
                                        </span>
                                        <h3>
                                            <a href="{{ route('products.show', $product->id) }}" style="text-decoration: none; color: inherit;">
                                                {{ $product->name }}
                                            </a>
                                        </h3>
                                        <div class="catalog-rating">
                                            <span style="color: #f59e0b;">★★★★★</span>
                                            <small>({{ $product->reviews_count_total }})</small>
                                        </div>
                                        <div class="catalog-price">
                                            @if (!empty($product->sale_price))
                                                <strong>Rs. {{ number_format($product->sale_price) }}</strong>
                                                <del>Rs. {{ number_format($product->price) }}</del>
                                            @else
                                                <strong>Rs. {{ number_format($product->price) }}</strong>
                                            @endif
                                        </div>
                                        <button class="catalog-add-cart" type="button" data-product-id="{{ $product->id }}">
                                            <i class="bi bi-bag-plus"></i> Add to Cart
                                        </button>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="catalog-empty">
                            <div class="catalog-empty-icon">
                                <i class="bi bi-search"></i>
                            </div>
                            <h2>No products found</h2>
                            <p>Try changing your search or removing some filters.</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary-custom">View All Products</a>
                        </div>
                    @endif
                </div>
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
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterBtn = document.querySelector('.mobile-filter-button');
    const sidebar = document.querySelector('.catalog-sidebar');
    if (filterBtn && sidebar) {
        filterBtn.addEventListener('click', function () {
            sidebar.classList.toggle('mobile-visible');
            const isVisible = sidebar.classList.contains('mobile-visible');
            filterBtn.innerHTML = isVisible 
                ? '<i class="bi bi-x-lg"></i> Close' 
                : '<i class="bi bi-sliders"></i> Filters';
        });
    }
});
</script>
@endpush

