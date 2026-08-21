<?php
$pageTitle = "Checkout — Velyora";

$cartItems = [
    [
        'id' => 1,
        'name' => 'Premium Wireless Headphones',
        'category' => 'Electronics',
        'variant' => 'Midnight Blue',
        'price' => 8999,
        'quantity' => 1,
        'image' => 'assets/images/products/product-1.png'
    ],
    [
        'id' => 2,
        'name' => 'Premium Everyday Hoodie',
        'category' => 'Fashion',
        'variant' => 'Black · Medium',
        'price' => 3499,
        'quantity' => 2,
        'image' => 'assets/images/products/product-2.png'
    ],
    [
        'id' => 3,
        'name' => 'Urban Everyday Backpack',
        'category' => 'Accessories',
        'variant' => 'Charcoal',
        'price' => 5999,
        'quantity' => 1,
        'image' => 'assets/images/products/product-3.png'
    ]
];

$subtotal = 0;

foreach ($cartItems as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}

$shipping = $subtotal >= 3000 ? 0 : 250;
$discount = 0;
$tax = round(($subtotal - $discount) * 0.02);
$total = $subtotal + $shipping + $tax - $discount;
$itemCount = array_sum(array_column($cartItems, 'quantity'));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/checkout.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

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
                    <a href="index.php">Home</a>
                    <i class="bi bi-chevron-right"></i>
                    <a href="cart.php">Cart</a>
                    <i class="bi bi-chevron-right"></i>
                    <span>Checkout</span>
                </nav>
            </div>

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
                                    <input id="first-name" type="text" placeholder="Enter your first name">
                                </div>
                                <div class="checkout-field">
                                    <label for="last-name">Last Name</label>
                                    <input id="last-name" type="text" placeholder="Enter your last name">
                                </div>
                                <div class="checkout-field checkout-field-full">
                                    <label for="email">Email Address</label>
                                    <div class="checkout-input-icon">
                                        <i class="bi bi-envelope"></i>
                                        <input id="email" type="email" placeholder="you@example.com">
                                    </div>
                                </div>
                                <div class="checkout-field checkout-field-full">
                                    <label for="phone">Phone Number</label>
                                    <div class="checkout-input-icon">
                                        <i class="bi bi-telephone"></i>
                                        <input id="phone" type="tel" placeholder="+92 300 0000000">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="checkout-card">
                        <div class="checkout-card-header">
                            <div class="checkout-card-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div>
                                <span>STEP 02</span>
                                <h2>Delivery Address</h2>
                            </div>
                        </div>
                        <div class="checkout-card-body">
                            <div class="checkout-form-grid">
                                <div class="checkout-field checkout-field-full">
                                    <label for="address">Street Address</label>
                                    <input id="address" type="text" placeholder="House number, street name">
                                </div>
                                <div class="checkout-field checkout-field-full">
                                    <label for="address-2">Apartment, Suite, etc. <small>Optional</small></label>
                                    <input id="address-2" type="text" placeholder="Apartment, suite, unit, etc.">
                                </div>
                                <div class="checkout-field">
                                    <label for="city">City</label>
                                    <input id="city" type="text" placeholder="Your city">
                                </div>
                                <div class="checkout-field">
                                    <label for="province">Province</label>
                                    <select id="province">
                                        <option value="">Select province</option>
                                        <option>Punjab</option>
                                        <option>Sindh</option>
                                        <option>Khyber Pakhtunkhwa</option>
                                        <option>Balochistan</option>
                                        <option>Islamabad Capital Territory</option>
                                        <option>Gilgit-Baltistan</option>
                                        <option>Azad Jammu & Kashmir</option>
                                    </select>
                                </div>
                                <div class="checkout-field">
                                    <label for="postal-code">Postal Code</label>
                                    <input id="postal-code" type="text" placeholder="Postal code">
                                </div>
                                <div class="checkout-field">
                                    <label for="country">Country</label>
                                    <select id="country">
                                        <option value="">Select country</option>
                                        <option selected>Pakistan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="checkout-checkboxes">
                                <label>
                                    <input type="checkbox">
                                    <span>Save this address for future orders</span>
                                </label>
                                <label>
                                    <input type="checkbox" checked>
                                    <span>Billing address is the same as delivery address</span>
                                </label>
                            </div>
                        </div>
                    </section>

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
                                <input type="checkbox">
                                <span>I agree to the <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a>.</span>
                            </label>
                            <button type="button" class="place-order-button">
                                <span>
                                    <i class="bi bi-lock"></i>
                                    Place Order Securely
                                </span>
                                <strong>Rs. <?php echo number_format($total); ?></strong>
                            </button>
                        </div>
                    </section>
                </div>

                <aside class="checkout-summary">
                    <div class="checkout-summary-header">
                        <div>
                            <span>YOUR ORDER</span>
                            <h2>Order Summary</h2>
                        </div>
                        <span class="checkout-summary-count"><?php echo $itemCount; ?> items</span>
                    </div>

                    <div class="checkout-products">
                        <?php foreach ($cartItems as $item): ?>
                            <div class="checkout-product">
                                <div class="checkout-product-image">
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                    <span><?php echo $item['quantity']; ?></span>
                                </div>
                                <div class="checkout-product-info">
                                    <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                                    <p><?php echo htmlspecialchars($item['variant']); ?></p>
                                    <strong>Rs. <?php echo number_format($item['price'] * $item['quantity']); ?></strong>
                                </div>
                            </div>
                        <?php endforeach; ?>
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
                            <strong>Rs. <?php echo number_format($subtotal); ?></strong>
                        </div>
                        <div>
                            <span>Delivery</span>
                            <strong><?php echo $shipping > 0 ? 'Rs. ' . number_format($shipping) : 'FREE'; ?></strong>
                        </div>
                        <div>
                            <span>Estimated Tax</span>
                            <strong>Rs. <?php echo number_format($tax); ?></strong>
                        </div>
                        <?php if ($discount > 0): ?>
                            <div class="checkout-discount">
                                <span>Discount</span>
                                <strong>- Rs. <?php echo number_format($discount); ?></strong>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="checkout-total">
                        <div>
                            <span>Grand Total</span>
                            <small>Including estimated tax</small>
                        </div>
                        <strong>Rs. <?php echo number_format($total); ?></strong>
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

                    <a href="cart.php" class="back-to-cart">
                        <i class="bi bi-arrow-left"></i>
                        Back to Cart
                    </a>
                </aside>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>