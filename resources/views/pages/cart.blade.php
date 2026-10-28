@extends('layouts.app')

@section('title', 'Your Cart — Velyora')

@section('content')
<main>
    <section class="cart-page">
        <div class="container">

            <div class="cart-heading">
                <div>
                    <span class="cart-eyebrow">YOUR SHOPPING BAG</span>
                    <h1>Your Cart</h1>
                    <p>Review your selected products before completing your order.</p>
                </div>

                <div class="cart-item-count">
                    <i class="bi bi-bag"></i>
                    <span class="cart-heading-count">{{ $totals['item_count'] }} item{{ $totals['item_count'] === 1 ? '' : 's' }}</span>
                </div>
            </div>

            @if (empty($cartItems))
                <!-- EMPTY CART STATE -->
                <div class="cart-empty-container text-center py-5" style="background: var(--color-white); border: 1px solid var(--color-border); border-radius: var(--radius-lg); padding: 60px 20px; box-shadow: var(--shadow-sm); margin-bottom: 40px;">
                    <div style="font-size: 64px; color: var(--color-border); margin-bottom: 18px;">
                        <i class="bi bi-bag-x"></i>
                    </div>
                    <h2 style="font-size: 26px; font-weight: 700; color: var(--color-heading); margin-bottom: 12px;">Your shopping bag is empty</h2>
                    <p style="color: var(--color-text-light); max-width: 480px; margin: 0 auto 30px; font-size: 15px; line-height: 1.6;">
                        Looks like you haven't added anything to your cart yet. Explore our latest arrivals and timeless essentials.
                    </p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary" style="padding: 13px 32px; border-radius: 999px; background: var(--color-primary); color: #fff; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="bi bi-arrow-left"></i> Continue Shopping
                    </a>
                </div>
            @else
                <!-- ACTIVE CART LAYOUT -->
                <div class="cart-layout">
                    <section class="cart-products">
                        <div class="cart-section-header">
                            <div>
                                <span class="cart-section-label">SELECTED PRODUCTS</span>
                                <h2>Your Items</h2>
                            </div>

                            <a href="{{ route('products.index') }}" class="cart-continue-link">
                                Continue Shopping
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>

                        <div class="cart-items">
                            @foreach ($cartItems as $item)
                                <article class="cart-item" data-cart-id="{{ $item['cart_id'] }}" data-product-id="{{ $item['product_id'] }}">
                                    <div class="cart-item-image">
                                        <a href="{{ route('products.show', $item['product_id']) }}">
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                        </a>
                                    </div>

                                    <div class="cart-item-details">
                                        <span class="cart-item-category">
                                            {{ $item['category'] }}
                                        </span>

                                        <h3>
                                            <a href="{{ route('products.show', $item['product_id']) }}">
                                                {{ $item['name'] }}
                                            </a>
                                        </h3>

                                        <p class="cart-item-variant">
                                            <i class="bi bi-check2-circle"></i>
                                            {{ $item['variant'] }}
                                        </p>

                                        <div class="cart-item-actions">
                                            <button type="button" class="cart-save-button" data-product-id="{{ $item['product_id'] }}" data-cart-id="{{ $item['cart_id'] }}">
                                                <i class="bi bi-heart"></i>
                                                Save for later
                                            </button>

                                            <button type="button" class="cart-remove-button" data-cart-id="{{ $item['cart_id'] }}">
                                                <i class="bi bi-trash3"></i>
                                                Remove
                                            </button>
                                        </div>
                                    </div>

                                    <div class="cart-item-price">
                                        <strong>
                                            Rs. {{ number_format($item['price']) }}
                                        </strong>

                                        @if ($item['old_price'])
                                            <del>
                                                Rs. {{ number_format($item['old_price']) }}
                                            </del>
                                        @endif
                                    </div>

                                    <div class="cart-quantity">
                                        <button type="button" class="cart-qty-btn cart-qty-minus" data-cart-id="{{ $item['cart_id'] }}" aria-label="Decrease quantity">
                                            <i class="bi bi-dash"></i>
                                        </button>

                                        <span class="cart-qty-val">{{ $item['quantity'] }}</span>

                                        <button type="button" class="cart-qty-btn cart-qty-plus" data-cart-id="{{ $item['cart_id'] }}" aria-label="Increase quantity">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                    </div>

                                    <div class="cart-item-total">
                                        <span>Total</span>
                                        <strong class="item-total-val">
                                            Rs. {{ number_format($item['item_total']) }}
                                        </strong>
                                    </div>

                                    <button type="button" class="cart-mobile-remove cart-remove-button" data-cart-id="{{ $item['cart_id'] }}" aria-label="Remove product">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </article>
                            @endforeach
                        </div>

                        <div class="cart-bottom-actions">
                            <a href="{{ route('products.index') }}" class="cart-back-link">
                                <i class="bi bi-arrow-left"></i>
                                Continue Shopping
                            </a>

                            <button type="button" class="cart-clear-button">
                                <i class="bi bi-trash3"></i>
                                Clear Cart
                            </button>
                        </div>
                    </section>

                    <aside class="cart-summary">
                        <div class="summary-header">
                            <div class="summary-icon">
                                <i class="bi bi-receipt"></i>
                            </div>

                            <div>
                                <span>ORDER DETAILS</span>
                                <h2>Order Summary</h2>
                            </div>
                        </div>

                        <div class="shipping-progress">
                            <div class="shipping-progress-top">
                                <span>
                                    <i class="bi bi-truck"></i>
                                    @if ($totals['free_shipping_unlocked'])
                                        Free delivery unlocked
                                    @else
                                        Add Rs. {{ number_format($totals['amount_for_free_shipping']) }} for FREE delivery
                                    @endif
                                </span>

                                <strong>
                                    @if ($totals['free_shipping_unlocked'])
                                        <i class="bi bi-check-circle-fill text-success"></i>
                                    @else
                                        <span>{{ $totals['progress_percent'] }}%</span>
                                    @endif
                                </strong>
                            </div>

                            <div class="shipping-progress-bar">
                                <span style="width: {{ $totals['progress_percent'] }}%;"></span>
                            </div>

                            <p>
                                @if ($totals['free_shipping_unlocked'])
                                    Your order qualifies for free delivery.
                                @else
                                    Free delivery applies on orders of Rs. 3,000 or more.
                                @endif
                            </p>
                        </div>

                        <div class="promo-box">
                            <div class="promo-heading">
                                <i class="bi bi-tag"></i>
                                <div>
                                    <strong>Have a promo code?</strong>
                                    <span>Apply your discount at checkout.</span>
                                </div>
                            </div>

                            <form class="promo-form" onsubmit="event.preventDefault(); const code = this.querySelector('input').value.trim(); if (code) { alert('Promo code \'' + code + '\' is invalid or expired.'); } else { alert('Please enter a promo code.'); }">
                                <input type="text" placeholder="Enter promo code">
                                <button type="submit">Apply</button>
                            </form>
                        </div>

                        <div class="summary-lines">
                            <div>
                                <span>Subtotal</span>
                                <strong class="summary-subtotal-val">{{ $totals['subtotal_formatted'] }}</strong>
                            </div>

                            <div>
                                <span>Delivery</span>
                                <strong class="summary-delivery-val {{ $totals['shipping'] === 0 ? 'summary-free' : '' }}">
                                    {{ $totals['shipping_formatted'] }}
                                </strong>
                            </div>

                            <div>
                                <span>Estimated tax</span>
                                <strong class="summary-tax-val">{{ $totals['tax_formatted'] }}</strong>
                            </div>

                            <div>
                                <span>Discount</span>
                                <strong class="summary-discount">
                                    - {{ $totals['discount_formatted'] }}
                                </strong>
                            </div>
                        </div>

                        <div class="summary-total">
                            <div>
                                <span>Total</span>
                                <small>Including estimated tax</small>
                            </div>

                            <strong class="summary-total-val">
                                {{ $totals['total_formatted'] }}
                            </strong>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="checkout-button">
                            Proceed to Checkout
                            <i class="bi bi-arrow-right"></i>
                        </a>

                        <div class="secure-checkout">
                            <i class="bi bi-shield-check"></i>
                            <div>
                                <strong>Secure checkout</strong>
                                <span>Your information is protected.</span>
                            </div>
                        </div>

                        <div class="payment-methods">
                            <span>WE ACCEPT</span>
                            <div>
                                <i class="bi bi-credit-card"></i>
                                <i class="bi bi-paypal"></i>
                                <i class="bi bi-wallet2"></i>
                                <i class="bi bi-bank"></i>
                            </div>
                        </div>
                    </aside>
                </div>
            @endif

            <section class="cart-benefits">
                <div class="cart-benefit">
                    <span class="cart-benefit-icon"><i class="bi bi-truck"></i></span>
                    <div>
                        <strong>Free Delivery</strong>
                        <span>On orders over Rs. 3,000</span>
                    </div>
                </div>

                <div class="cart-benefit">
                    <span class="cart-benefit-icon"><i class="bi bi-arrow-repeat"></i></span>
                    <div>
                        <strong>Hassle-Free Returns</strong>
                        <span>Easy 7-day return policy</span>
                    </div>
                </div>

                <div class="cart-benefit">
                    <span class="cart-benefit-icon"><i class="bi bi-shield-check"></i></span>
                    <div>
                        <strong>Secure Payments</strong>
                        <span>Encrypted checkout</span>
                    </div>
                </div>

                <div class="cart-benefit">
                    <span class="cart-benefit-icon"><i class="bi bi-headset"></i></span>
                    <div>
                        <strong>24/7 Support</strong>
                        <span>Always here to help you</span>
                    </div>
                </div>
            </section>
        </div>
    </section>
</main>
@endsection

