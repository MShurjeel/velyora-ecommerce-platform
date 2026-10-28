@extends('layouts.app')

@section('title', $product->name . ' — Velyora')

@section('content')
<main>
    <!-- =========================================================
         PRODUCT BREADCRUMB
    ========================================================= -->
    <section class="product-breadcrumb-section">
        <div class="container">
            <nav class="product-breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <i class="bi bi-chevron-right"></i>
                <a href="{{ route('products.index') }}">Shop</a>
                <i class="bi bi-chevron-right"></i>
                @if ($product->category)
                    <a href="{{ route('products.index', ['category' => $product->category->slug]) }}">
                        {{ $product->category->name }}
                    </a>
                    <i class="bi bi-chevron-right"></i>
                @endif
                <span>{{ $product->name }}</span>
            </nav>
        </div>
    </section>

    <!-- =========================================================
         PRODUCT HERO / DETAILS
    ========================================================= -->
    <section class="product-detail-section">
        <div class="container">
            <div class="product-detail-layout">

                <!-- Product Gallery -->
                <div class="product-gallery {{ $product->images->count() <= 1 ? 'no-thumbnails' : '' }}">
                    @if ($product->images->count() > 1)
                        <div class="product-gallery-thumbnails">
                            @foreach ($product->images as $index => $img)
                                <button type="button" class="product-thumbnail {{ $index === 0 ? 'active' : '' }}" data-image="{{ asset($img->image_path) }}">
                                    <img src="{{ asset($img->image_path) }}" alt="{{ $product->name }} thumbnail {{ $index + 1 }}">
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <div class="product-main-image">
                        @if ($product->discount_percent)
                            <span class="product-detail-badge">
                                {{ $product->discount_percent }}% OFF
                            </span>
                        @elseif ($product->is_featured == 1)
                            <span class="product-detail-badge">
                                BEST SELLER
                            </span>
                        @endif

                        @php
                            $inWishlist = \App\Services\WishlistService::isInWishlist($product->id);
                        @endphp
                        <button type="button" class="product-image-wishlist {{ $inWishlist ? 'active' : '' }}" aria-label="Add to wishlist" data-product-id="{{ $product->id }}">
                            <i class="bi {{ $inWishlist ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                        </button>
                        <div class="product-image-glow"></div>
                        <img id="productMainImage" src="{{ $product->primary_image_url }}" alt="{{ $product->name }}">
                    </div>
                </div>

                <!-- Product Information -->
                <div class="product-information">
                    <span class="product-detail-category">
                        {{ $product->category->name ?? 'General' }}
                    </span>
                    <h1>{{ $product->name }}</h1>

                    <div class="product-detail-rating">
                        <span class="rating-stars" style="color: #f59e0b; font-size: 13px;">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= round($avgRating) ? 'bi-star-fill' : 'bi-star' }}"></i>
                            @endfor
                        </span>
                        <strong>{{ $avgRating }}</strong>
                        <a href="#reviews" class="product-reviews-link">({{ $reviewCount }} {{ $reviewCount === 1 ? 'review' : 'reviews' }})</a>
                    </div>

                    <div class="product-detail-price">
                        <strong>
                            Rs. {{ number_format($product->effective_price) }}
                        </strong>
                        @if ($product->sale_price && $product->sale_price < $product->price)
                            <del>
                                Rs. {{ number_format($product->price) }}
                            </del>
                            <span class="product-discount">
                                {{ $product->discount_percent }}% OFF
                            </span>
                        @endif
                    </div>

                    <p class="product-detail-description">
                        {{ $product->description }}
                    </p>

                    <div class="product-stock-row">
                        <span class="stock-status">
                            <i class="bi bi-check-circle-fill"></i>
                            In Stock
                        </span>
                        <span>
                            {{ $product->stock_qty }} units available
                        </span>
                    </div>

                    <div class="product-divider"></div>

                    <!-- COLOR CHOOSER -->
                    @if (!empty($details['colors']))
                        <div class="product-option">
                            <div class="product-option-heading">
                                <strong>Choose Color</strong>
                                <span id="selectedColor">{{ $details['colors'][0]['name'] }}</span>
                            </div>
                            <div class="product-color-options">
                                @foreach ($details['colors'] as $index => $color)
                                    <button type="button" class="product-color {{ $index === 0 ? 'active' : '' }}" data-color="{{ $color['name'] }}" aria-label="{{ $color['name'] }}">
                                        <span style="background-color: {{ $color['value'] }};"></span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- QUANTITY + CART -->
                    <div class="product-purchase-row">
                        <div class="quantity-control">
                            <button type="button" class="quantity-minus">
                                <i class="bi bi-dash"></i>
                            </button>
                            <input type="number" id="productQuantity" value="1" min="1" max="{{ $product->stock_qty }}">
                            <button type="button" class="quantity-plus">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>

                        <button type="button" class="product-add-cart" data-product-id="{{ $product->id }}">
                            <i class="bi bi-bag-plus"></i>
                            Add to Cart
                        </button>

                        <button type="button" class="product-detail-wishlist {{ $inWishlist ? 'active' : '' }}" aria-label="Add to wishlist" data-product-id="{{ $product->id }}">
                            <i class="bi {{ $inWishlist ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                        </button>
                    </div>

                    <button type="button" class="product-buy-now" data-product-id="{{ $product->id }}">
                        <i class="bi bi-lightning-charge-fill"></i>
                        Buy It Now
                    </button>

                    <!-- SERVICE PROMISES -->
                    <div class="product-service-grid">
                        <div class="product-service-item">
                            <span class="product-service-icon"><i class="bi bi-truck"></i></span>
                            <div>
                                <strong>Fast Delivery</strong>
                                <small>Delivered safely to your door</small>
                            </div>
                        </div>
                        <div class="product-service-item">
                            <span class="product-service-icon"><i class="bi bi-arrow-repeat"></i></span>
                            <div>
                                <strong>Easy Returns</strong>
                                <small>Simple return experience</small>
                            </div>
                        </div>
                        <div class="product-service-item">
                            <span class="product-service-icon"><i class="bi bi-shield-check"></i></span>
                            <div>
                                <strong>Velyora Assured</strong>
                                <small>Quality checked products</small>
                            </div>
                        </div>
                        <div class="product-service-item">
                            <span class="product-service-icon"><i class="bi bi-headset"></i></span>
                            <div>
                                <strong>Dedicated Support</strong>
                                <small>We're here when you need us</small>
                            </div>
                        </div>
                    </div>

                    <!-- PRODUCT META -->
                    <div class="product-meta">
                        <div>
                            <span>SKU</span>
                            <strong>VEL-{{ strtoupper(substr($product->category->slug ?? 'GEN', 0, 4)) }}-{{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</strong>
                        </div>
                        <div>
                            <span>Brand</span>
                            <strong>Velyora</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========================================================
         PRODUCT CONTENT TABS
    ========================================================= -->
    <section class="product-content-section">
        <div class="container">
            <div class="product-tabs" role="tablist">
                <button type="button" class="product-tab active" data-tab="description">
                    Description
                </button>
                <button type="button" class="product-tab" data-tab="specifications">
                    Specifications
                </button>
                <button type="button" class="product-tab" data-tab="reviews">
                    Reviews ({{ $reviewCount }})
                </button>
            </div>

            <!-- TAB 1: DESCRIPTION & STORY -->
            <div class="product-tab-content active" id="description">
                <div class="product-story-layout">
                    <div class="product-story-copy">
                        <h2>{{ $details['story_heading'] }}</h2>
                        <p>{{ $details['story_p1'] }}</p>
                        <p>{{ $details['story_p2'] }}</p>

                        @if (!empty($details['features']))
                            <div class="product-feature-grid">
                                @foreach ($details['features'] as $feat)
                                    <div class="product-feature-card">
                                        <i class="bi {{ $feat['icon'] }}"></i>
                                        <div>
                                            <h4>{{ $feat['title'] }}</h4>
                                            <p>{{ $feat['text'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @if (!empty($details['included']))
                        <aside class="product-included-card">
                            <div class="product-included-heading">
                                <span><i class="bi bi-box-seam"></i></span>
                                <h3>What's Included</h3>
                            </div>
                            <ul>
                                @foreach ($details['included'] as $inc)
                                    <li>
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span>{{ $inc }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </aside>
                    @endif
                </div>
            </div>

            <!-- TAB 2: SPECIFICATIONS -->
            <div class="product-tab-content" id="specifications">
                <div class="specification-grid">
                    @if (!empty($details['specifications']))
                        @foreach ($details['specifications'] as $group => $specs)
                            <div class="specification-group">
                                <div class="specification-heading">
                                    <span></span>
                                    <h3>{{ $group }}</h3>
                                </div>
                                <div class="specification-table">
                                    @foreach ($specs as $label => $value)
                                        <div class="specification-row">
                                            <strong>{{ $label }}</strong>
                                            <span>{{ $value }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted">Standard Velyora manufacturing specifications apply.</p>
                    @endif
                </div>
            </div>

            <!-- TAB 3: REVIEWS -->
            <div class="product-tab-content" id="reviews">
                <div class="reviews-summary">
                    <div class="review-score-card">
                        <span class="review-score">{{ $avgRating }}</span>
                        <div class="review-stars" style="color: #f59e0b; font-size: 18px; margin: 6px 0;">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= round($avgRating) ? 'bi-star-fill' : 'bi-star' }}"></i>
                            @endfor
                        </div>
                        <p>Based on {{ $reviewCount }} {{ $reviewCount === 1 ? 'review' : 'reviews' }}</p>
                        @auth
                            <button type="button" class="review-button" data-bs-toggle="modal" data-bs-target="#productReviewModal">
                                <i class="bi bi-pencil-square"></i> Write a Review
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="review-button" style="text-decoration:none; display:inline-block; text-align:center;">
                                <i class="bi bi-box-arrow-in-right"></i> Sign In to Review
                            </a>
                        @endauth
                    </div>

                    <div class="review-bars">
                        @for ($s = 5; $s >= 1; $s--)
                            @php
                                $cnt = $starBreakdown[$s] ?? 0;
                                $pct = $reviewCount > 0 ? round(($cnt / $reviewCount) * 100) : 0;
                            @endphp
                            <div class="review-bar-row">
                                <span>{{ $s }}</span>
                                <i class="bi bi-star-fill" style="color: #f59e0b;"></i>
                                <div><span style="width: {{ $pct }}%;"></span></div>
                                <small>{{ $cnt }}</small>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="review-list">
                    @if ($reviews->isEmpty())
                        <div class="empty-reviews text-center py-4" style="text-align: center; padding: 40px 20px; border: 1px dashed var(--color-border); border-radius: var(--radius-md); background: #fafbfe;">
                            <i class="bi bi-star" style="font-size: 36px; color: #cbd5e1; display: block; margin-bottom: 10px;"></i>
                            <h4 style="font-size: 16px; font-weight: 700; color: var(--color-heading); margin-bottom: 6px;">No reviews yet</h4>
                            <p style="font-size: 13px; color: var(--color-text-light); max-width: 400px; margin: 0 auto 16px;">
                                Be the first customer to share your thoughts and review {{ $product->name }}!
                            </p>
                            @auth
                                <button type="button" class="btn-primary-profile" data-bs-toggle="modal" data-bs-target="#productReviewModal">
                                    <i class="bi bi-pencil-square"></i> Write the First Review
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn-primary-profile">
                                    Sign In to Write a Review
                                </a>
                            @endauth
                        </div>
                    @else
                        @foreach ($reviews as $rev)
                            <article class="review-card">
                                <div class="review-avatar">
                                    {{ strtoupper(substr($rev->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="review-body">
                                    <div class="review-top">
                                        <div>
                                            <strong>{{ $rev->user->name ?? 'Verified Buyer' }}</strong>
                                            <div class="review-stars" style="color: #f59e0b;">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="bi {{ $i <= $rev->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <time>{{ $rev->created_at->format('M d, Y') }}</time>
                                    </div>
                                    <p style="margin-top: 8px;">{{ $rev->comment }}</p>
                                </div>
                            </article>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
    </section>

    <!-- =========================================================
         RELATED PRODUCTS
    ========================================================= -->
    @if ($relatedProducts->isNotEmpty())
        <section class="related-products-section">
            <div class="container">
                <div class="section-heading">
                    <div>
                        <span class="section-eyebrow">COMPLETE YOUR LOOK</span>
                        <h2>You May Also Like</h2>
                    </div>
                    <a href="{{ route('products.index') }}" class="view-all-link">
                        View All
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="product-grid">
                    @foreach ($relatedProducts as $related)
                        <article class="product-card">
                            <div class="product-image">
                                <a href="{{ route('products.show', $related->id) }}" style="display: block;">
                                    <img src="{{ $related->primary_image_url }}" alt="{{ $related->name }}">
                                </a>
                            </div>
                            <div class="product-info">
                                <span class="product-category">
                                    {{ $related->category->name ?? 'General' }}
                                </span>
                                <h3>
                                    <a href="{{ route('products.show', $related->id) }}" style="text-decoration: none; color: inherit;">
                                        {{ $related->name }}
                                    </a>
                                </h3>
                                <div class="product-price">
                                    Rs. {{ number_format($related->effective_price) }}
                                </div>
                                <a href="{{ route('products.show', $related->id) }}" class="add-cart-button related-view-button">
                                    View Product
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</main>

@auth
<!-- Write Review Modal -->
<div class="modal fade" id="productReviewModal" tabindex="-1" aria-labelledby="productReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content profile-modal-content">
            <form action="{{ route('profile.reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="productReviewModalLabel"><i class="bi bi-pencil-square me-2 text-primary"></i> Write a Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label style="font-weight: 600; margin-bottom: 6px; display: block;">Your Rating <span class="text-danger">*</span></label>
                        <input type="hidden" name="rating" id="product_rating_input" value="5">
                        <div class="star-rating-select" id="productStarRatingSelector">
                            <i class="bi bi-star-fill active" data-rating="1"></i>
                            <i class="bi bi-star-fill active" data-rating="2"></i>
                            <i class="bi bi-star-fill active" data-rating="3"></i>
                            <i class="bi bi-star-fill active" data-rating="4"></i>
                            <i class="bi bi-star-fill active" data-rating="5"></i>
                            <span class="rating-label ms-2" id="productStarRatingLabel">5 / 5 Stars</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="font-weight: 600; margin-bottom: 6px; display: block;">Your Review <span class="text-danger">*</span></label>
                        <textarea name="comment" rows="4" class="form-control" minlength="5" maxlength="1000" placeholder="Share details of your experience with this product... (e.g. quality, material, durability)" required></textarea>
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
@endauth
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    /* Gallery Thumbnail Switcher */
    const mainImage = document.getElementById('productMainImage');
    const thumbnails = document.querySelectorAll('.product-thumbnail');

    thumbnails.forEach(function(thumbnail) {
        thumbnail.addEventListener('click', function() {
            const image = this.dataset.image;
            if (mainImage && image) {
                mainImage.src = image;
            }
            thumbnails.forEach(function(item) {
                item.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    /* Color Selector */
    const colorButtons = document.querySelectorAll('.product-color');
    const selectedColor = document.getElementById('selectedColor');

    colorButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            colorButtons.forEach(function(item) {
                item.classList.remove('active');
            });
            this.classList.add('active');
            if (selectedColor) {
                selectedColor.textContent = this.dataset.color;
            }
        });
    });

    /* Quantity Controls */
    const quantityInput = document.getElementById('productQuantity');
    const quantityMinus = document.querySelector('.quantity-minus');
    const quantityPlus = document.querySelector('.quantity-plus');

    if (quantityInput) {
        quantityMinus?.addEventListener('click', function() {
            let value = parseInt(quantityInput.value, 10) || 1;
            if (value > 1) {
                value--;
            }
            quantityInput.value = value;
        });

        quantityPlus?.addEventListener('click', function() {
            let value = parseInt(quantityInput.value, 10) || 1;
            const max = parseInt(quantityInput.max, 10) || 99;
            if (value < max) {
                value++;
            }
            quantityInput.value = value;
        });
    }

    /* Tabs */
    const tabs = document.querySelectorAll('.product-tab');
    const tabContents = document.querySelectorAll('.product-tab-content');

    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            const target = this.dataset.tab;

            tabs.forEach(function(item) {
                item.classList.remove('active');
            });

            tabContents.forEach(function(content) {
                content.classList.remove('active');
            });

            this.classList.add('active');

            const targetContent = document.getElementById(target);
            if (targetContent) {
                targetContent.classList.add('active');
            }
        });
    });

    /* Scroll to Reviews when clicking review link at top */
    const reviewScrollLink = document.querySelector('.product-reviews-link');
    if (reviewScrollLink) {
        reviewScrollLink.addEventListener('click', function(e) {
            e.preventDefault();
            const reviewsTabBtn = document.querySelector('.product-tab[data-tab="reviews"]');
            if (reviewsTabBtn) {
                reviewsTabBtn.click();
                reviewsTabBtn.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    }

    /* Modal Star Rating Picker */
    const starContainer = document.getElementById('productStarRatingSelector');
    if (starContainer) {
        const stars = starContainer.querySelectorAll('i');
        const hiddenInput = document.getElementById('product_rating_input');
        const label = document.getElementById('productStarRatingLabel');

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
});
</script>
@endpush

