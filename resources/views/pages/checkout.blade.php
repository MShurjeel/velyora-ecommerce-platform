@extends('layouts.app')

@section('title', 'Checkout — Velyora')

@section('content')
<main>
    <section class="checkout-page">
        <div class="container">
            <div class="checkout-top">
                <div>
                    <span class="checkout-eyebrow">SECURE CHECKOUT</span>
                    <h1>Complete Your Order</h1>
                    <p>You're just a few steps away from receiving your Velyora order.</p>
                </div>
                <nav class="checkout-breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <i class="bi bi-chevron-right"></i>
                    <a href="{{ route('cart.index') }}">Cart</a>
                    <i class="bi bi-chevron-right"></i>
                    <span>Checkout</span>
                </nav>
            </div>

            <!-- Progress Indicator -->
            <div class="checkout-progress">
                <div class="checkout-step active">
                    <span class="checkout-step-number"><i class="bi bi-person"></i></span>
                    <div>
                        <strong>Information</strong>
                        <small>Your details</small>
                    </div>
                </div>
                <div class="checkout-progress-line"></div>
                <div class="checkout-step">
                    <span class="checkout-step-number"><i class="bi bi-truck"></i></span>
                    <div>
                        <strong>Delivery</strong>
                        <small>Shipping address</small>
                    </div>
                </div>
                <div class="checkout-progress-line"></div>
                <div class="checkout-step">
                    <span class="checkout-step-number"><i class="bi bi-credit-card"></i></span>
                    <div>
                        <strong>Payment</strong>
                        <small>Secure payment</small>
                    </div>
                </div>
                <div class="checkout-progress-line"></div>
                <div class="checkout-step">
                    <span class="checkout-step-number"><i class="bi bi-check-circle"></i></span>
                    <div>
                        <strong>Review</strong>
                        <small>Place order</small>
                    </div>
                </div>
            </div>

            <div class="checkout-layout">
                <div class="checkout-main">
                    <!-- Step 1: Customer Information -->
                    <section class="checkout-card">
                        <div class="checkout-card-header">
                            <div class="checkout-card-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            <div>
                                <span>STEP 01</span>
                                <h2>Customer Information</h2>
                            </div>
                        </div>
                        <div class="checkout-card-body">
                            <div class="checkout-form-grid">
                                <div class="checkout-field">
                                    <label for="first-name">First Name</label>
                                    <input id="first-name" type="text" placeholder="Enter your first name" value="{{ $defaultAddress ? explode(' ', $defaultAddress->recipient_name)[0] : (auth()->check() ? explode(' ', auth()->user()->name)[0] : '') }}" required>
                                </div>
                                <div class="checkout-field">
                                    <label for="last-name">Last Name</label>
                                    <input id="last-name" type="text" placeholder="Enter your last name" value="{{ $defaultAddress && count(explode(' ', $defaultAddress->recipient_name)) > 1 ? explode(' ', $defaultAddress->recipient_name, 2)[1] : (auth()->check() && count(explode(' ', auth()->user()->name)) > 1 ? explode(' ', auth()->user()->name, 2)[1] : '') }}" required>
                                </div>
                                <div class="checkout-field checkout-field-full">
                                    <label for="email">Email Address</label>
                                    <div class="checkout-input-icon">
                                        <i class="bi bi-envelope"></i>
                                        <input id="email" type="email" placeholder="you@example.com" value="{{ auth()->check() ? auth()->user()->email : '' }}" required>
                                    </div>
                                </div>
                                <div class="checkout-field checkout-field-full">
                                    <label for="phone">Phone Number</label>
                                    <div class="checkout-input-icon">
                                        <i class="bi bi-telephone"></i>
                                        <input id="phone" type="tel" placeholder="+92 300 0000000" value="{{ $defaultAddress ? $defaultAddress->phone : (auth()->check() ? auth()->user()->phone : '') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Step 2: Delivery Address -->
                    <section class="checkout-card">
                        <div class="checkout-card-header">
                            <div class="checkout-card-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div>
                                <span>STEP 02</span>
                                <h2>Delivery Address</h2>
                                @if ($defaultAddress)
                                    <small style="color: var(--color-success); font-size: 11px;"><i class="bi bi-check-circle-fill"></i> Pre-filled from your default address ({{ $defaultAddress->title }})</small>
                                @endif
                            </div>
                        </div>
                        <div class="checkout-card-body">
                            <div class="checkout-form-grid">
                                <div class="checkout-field checkout-field-full">
                                    <label for="address">Street Address</label>
                                    <input id="address" type="text" placeholder="House number, street name" value="{{ $defaultAddress ? $defaultAddress->address_line1 : '' }}" required>
                                </div>
                                <div class="checkout-field checkout-field-full">
                                    <label for="address-2">Apartment, Suite, etc. <small>Optional</small></label>
                                    <input id="address-2" type="text" placeholder="Apartment, suite, unit, etc." value="{{ $defaultAddress ? $defaultAddress->address_line2 : '' }}">
                                </div>
                                <div class="checkout-field">
                                    <label for="city">City</label>
                                    <input id="city" type="text" placeholder="Your city" value="{{ $defaultAddress ? $defaultAddress->city : '' }}" required>
                                </div>
                                <div class="checkout-field">
                                    <label for="province">Province</label>
                                    <select id="province" required>
                                        <option value="">Select province</option>
                                        <option value="Punjab" {{ ($defaultAddress && $defaultAddress->state === 'Punjab') ? 'selected' : '' }}>Punjab</option>
                                        <option value="Sindh" {{ ($defaultAddress && $defaultAddress->state === 'Sindh') ? 'selected' : '' }}>Sindh</option>
                                        <option value="Khyber Pakhtunkhwa" {{ ($defaultAddress && $defaultAddress->state === 'Khyber Pakhtunkhwa') ? 'selected' : '' }}>Khyber Pakhtunkhwa</option>
                                        <option value="Balochistan" {{ ($defaultAddress && $defaultAddress->state === 'Balochistan') ? 'selected' : '' }}>Balochistan</option>
                                        <option value="Islamabad" {{ ($defaultAddress && $defaultAddress->state === 'Islamabad') ? 'selected' : '' }}>Islamabad Capital Territory</option>
                                    </select>
                                </div>
                                <div class="checkout-field">
                                    <label for="postal-code">Postal Code</label>
                                    <input id="postal-code" type="text" placeholder="Postal code" value="{{ $defaultAddress ? $defaultAddress->postal_code : '' }}" required>
                                </div>
                                <div class="checkout-field">
                                    <label for="country">Country</label>
                                    <select id="country" required>
                                        <option value="Pakistan" {{ (!$defaultAddress || $defaultAddress->country === 'Pakistan') ? 'selected' : '' }}>Pakistan</option>
                                        <option value="United States" {{ ($defaultAddress && $defaultAddress->country === 'United States') ? 'selected' : '' }}>United States</option>
                                        <option value="United Kingdom" {{ ($defaultAddress && $defaultAddress->country === 'United Kingdom') ? 'selected' : '' }}>United Kingdom</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Step 3: Payment Method -->
                    <section class="checkout-card">
                        <div class="checkout-card-header">
                            <div class="checkout-card-icon">
                                <i class="bi bi-credit-card"></i>
                            </div>
                            <div>
                                <span>STEP 03</span>
                                <h2>Payment Method</h2>
                            </div>
                        </div>
                        <div class="checkout-card-body">
                            <div class="payment-options">
                                <label class="payment-option active">
                                    <input type="radio" name="payment" value="card" checked>
                                    <span class="payment-option-icon">
                                        <i class="bi bi-credit-card"></i>
                                    </span>
                                    <span>
                                        <strong>Card Payment</strong>
                                        <small>Visa, Mastercard & more</small>
                                    </span>
                                </label>
                                <label class="payment-option">
                                    <input type="radio" name="payment" value="cod">
                                    <span class="payment-option-icon">
                                        <i class="bi bi-cash-stack"></i>
                                    </span>
                                    <span>
                                        <strong>Cash on Delivery</strong>
                                        <small>Pay when your order arrives</small>
                                    </span>
                                </label>
                                <label class="payment-option">
                                    <input type="radio" name="payment" value="wallet">
                                    <span class="payment-option-icon">
                                        <i class="bi bi-wallet2"></i>
                                    </span>
                                    <span>
                                        <strong>Digital Wallet</strong>
                                        <small>Pay with your wallet</small>
                                    </span>
                                </label>
                            </div>

                            <div class="card-payment-fields">
                                <div class="checkout-form-grid">
                                    <div class="checkout-field checkout-field-full">
                                        <label for="card-number">Card Number</label>
                                        <div class="checkout-input-icon">
                                            <i class="bi bi-credit-card-2-front"></i>
                                            <input id="card-number" type="text" placeholder="1234 5678 9012 3456">
                                        </div>
                                    </div>
                                    <div class="checkout-field">
                                        <label for="expiry">Expiry Date</label>
                                        <input id="expiry" type="text" placeholder="MM / YY">
                                    </div>
                                    <div class="checkout-field">
                                        <label for="cvv">Security Code</label>
                                        <div class="checkout-input-icon">
                                            <input id="cvv" type="text" placeholder="CVV">
                                            <i class="bi bi-question-circle"></i>
                                        </div>
                                    </div>
                                    <div class="checkout-field checkout-field-full">
                                        <label for="card-name">Name on Card</label>
                                        <input id="card-name" type="text" placeholder="Name exactly as shown on card">
                                    </div>
                                </div>
                            </div>

                            <div class="payment-security">
                                <i class="bi bi-shield-check"></i>
                                <div>
                                    <strong>Your payment is secure</strong>
                                    <span>Velyora uses secure encrypted payment technology.</span>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Step 4: Review & Place Order -->
                    <section class="checkout-card checkout-review-card">
                        <div class="checkout-card-header">
                            <div class="checkout-card-icon">
                                <i class="bi bi-check2-circle"></i>
                            </div>
                            <div>
                                <span>STEP 04</span>
                                <h2>Review & Place Order</h2>
                            </div>
                        </div>
                        <div class="checkout-card-body">
                            <label class="terms-checkbox">
                                <input type="checkbox" id="terms-agree" checked>
                                <span>I agree to the <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a>.</span>
                            </label>
                            <button type="button" class="place-order-button">
                                <span>
                                    <i class="bi bi-lock"></i>
                                    Place Order Securely
                                </span>
                                <strong>{{ $totals['total_formatted'] }}</strong>
                            </button>
                        </div>
                    </section>
                </div>

                <!-- Order Summary Sidebar -->
                <aside class="checkout-summary">
                    <div class="checkout-summary-header">
                        <div>
                            <span>YOUR ORDER</span>
                            <h2>Order Summary</h2>
                        </div>
                        <span class="checkout-summary-count">{{ $totals['item_count'] }} items</span>
                    </div>

                    <div class="checkout-products">
                        @foreach ($cartItems as $item)
                            <div class="checkout-product">
                                <div class="checkout-product-image">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                                    <span>{{ $item['quantity'] }}</span>
                                </div>
                                <div class="checkout-product-info">
                                    <h3>{{ $item['name'] }}</h3>
                                    <p>{{ $item['variant'] }}</p>
                                    <strong>Rs. {{ number_format($item['price'] * $item['quantity']) }}</strong>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="checkout-promo">
                        <label for="promo-code">Have a promo code?</label>
                        <div>
                            <input id="promo-code" type="text" placeholder="Enter promo code">
                            <button type="button">Apply</button>
                        </div>
                    </div>

                    <div class="checkout-summary-lines">
                        <div>
                            <span>Subtotal</span>
                            <strong>{{ $totals['subtotal_formatted'] }}</strong>
                        </div>
                        <div>
                            <span>Delivery</span>
                            <strong>{{ $totals['shipping_formatted'] }}</strong>
                        </div>
                        <div>
                            <span>Estimated Tax</span>
                            <strong>{{ $totals['tax_formatted'] }}</strong>
                        </div>
                        @if ($totals['discount'] > 0)
                            <div class="checkout-discount">
                                <span>Discount</span>
                                <strong>- {{ $totals['discount_formatted'] }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="checkout-total">
                        <div>
                            <span>Grand Total</span>
                            <small>Including estimated tax</small>
                        </div>
                        <strong>{{ $totals['total_formatted'] }}</strong>
                    </div>

                    <div class="checkout-summary-trust">
                        <div>
                            <i class="bi bi-shield-check"></i>
                            <span>Secure checkout</span>
                        </div>
                        <div>
                            <i class="bi bi-truck"></i>
                            <span>Reliable delivery</span>
                        </div>
                        <div>
                            <i class="bi bi-arrow-repeat"></i>
                            <span>Easy returns</span>
                        </div>
                    </div>

                    <a href="{{ route('cart.index') }}" class="back-to-cart">
                        <i class="bi bi-arrow-left"></i>
                        Back to Cart
                    </a>
                </aside>
            </div>
        </div>
    </section>
</main>
@endsection

