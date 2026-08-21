<?php
$pageTitle = "Your Cart — Velyora";

$cartItems = [
    [
        'id' => 1,
        'name' => 'Premium Wireless Headphones',
        'category' => 'Electronics',
        'variant' => 'Midnight Blue',
        'price' => 8999,
        'old_price' => 11999,
        'quantity' => 1,
        'image' => 'assets/images/products/product-1.png'
    ],
    [
        'id' => 2,
        'name' => 'Premium Everyday Hoodie',
        'category' => 'Fashion',
        'variant' => 'Black · Medium',
        'price' => 3499,
        'old_price' => 4399,
        'quantity' => 2,
        'image' => 'assets/images/products/product-2.png'
    ],
    [
        'id' => 3,
        'name' => 'Urban Everyday Backpack',
        'category' => 'Accessories',
        'variant' => 'Charcoal',
        'price' => 5999,
        'old_price' => null,
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
    <link rel="stylesheet" href="assets/css/cart.css">
    <link rel="stylesheet" href="assets/css/responsive.css">

</head>
<body>

<?php include 'includes/header.php'; ?>

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
                    <span><?php echo $itemCount; ?> items</span>
                </div>
            </div>

            <div class="cart-layout">

                <section class="cart-products">

                    <div class="cart-section-header">
                        <div>
                            <span class="cart-section-label">SELECTED PRODUCTS</span>
                            <h2>Your Items</h2>
                        </div>

                        <a href="products.php" class="cart-continue-link">
                            Continue Shopping
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <div class="cart-items">

                        <?php foreach ($cartItems as $item): ?>
                            <?php $itemTotal = $item['price'] * $item['quantity']; ?>

                            <article class="cart-item" data-product-id="<?php echo $item['id']; ?>">

                                <div class="cart-item-image">
                                    <img
                                        src="<?php echo htmlspecialchars($item['image']); ?>"
                                        alt="<?php echo htmlspecialchars($item['name']); ?>">
                                </div>

                                <div class="cart-item-details">

                                    <span class="cart-item-category">
                                        <?php echo htmlspecialchars($item['category']); ?>
                                    </span>

                                    <h3>
                                        <a href="product.php?id=<?php echo $item['id']; ?>">
                                            <?php echo htmlspecialchars($item['name']); ?>
                                        </a>
                                    </h3>

                                    <p class="cart-item-variant">
                                        <i class="bi bi-check2-circle"></i>
                                        <?php echo htmlspecialchars($item['variant']); ?>
                                    </p>

                                    <div class="cart-item-actions">
                                        <button type="button" class="cart-save-button">
                                            <i class="bi bi-heart"></i>
                                            Save for later
                                        </button>

                                        <button type="button" class="cart-remove-button">
                                            <i class="bi bi-trash3"></i>
                                            Remove
                                        </button>
                                    </div>

                                </div>

                                <div class="cart-item-price">
                                    <strong>
                                        Rs. <?php echo number_format($item['price']); ?>
                                    </strong>

                                    <?php if ($item['old_price']): ?>
                                        <del>
                                            Rs. <?php echo number_format($item['old_price']); ?>
                                        </del>
                                    <?php endif; ?>
                                </div>

                                <div class="cart-quantity">
                                    <button type="button" aria-label="Decrease quantity">
                                        <i class="bi bi-dash"></i>
                                    </button>

                                    <span><?php echo $item['quantity']; ?></span>

                                    <button type="button" aria-label="Increase quantity">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>

                                <div class="cart-item-total">
                                    <span>Total</span>
                                    <strong>
                                        Rs. <?php echo number_format($itemTotal); ?>
                                    </strong>
                                </div>

                                <button type="button" class="cart-mobile-remove" aria-label="Remove product">
                                    <i class="bi bi-x-lg"></i>
                                </button>

                            </article>
                        <?php endforeach; ?>

                    </div>

                    <div class="cart-bottom-actions">
                        <a href="products.php" class="cart-back-link">
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
                                Free delivery unlocked
                            </span>

                            <strong>
                                <i class="bi bi-check-circle-fill"></i>
                            </strong>
                        </div>

                        <div class="shipping-progress-bar">
                            <span></span>
                        </div>

                        <p>
                            Your order qualifies for free delivery.
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

                        <form class="promo-form">
                            <input
                                type="text"
                                placeholder="Enter promo code">

                            <button type="submit">
                                Apply
                            </button>
                        </form>

                    </div>

                    <div class="summary-lines">

                        <div>
                            <span>Subtotal</span>
                            <strong>Rs. <?php echo number_format($subtotal); ?></strong>
                        </div>

                        <div>
                            <span>Delivery</span>

                            <strong class="<?php echo $shipping === 0 ? 'summary-free' : ''; ?>">
                                <?php echo $shipping === 0 ? 'FREE' : 'Rs. ' . number_format($shipping); ?>
                            </strong>
                        </div>

                        <div>
                            <span>Estimated tax</span>
                            <strong>Rs. <?php echo number_format($tax); ?></strong>
                        </div>

                        <div>
                            <span>Discount</span>
                            <strong class="summary-discount">
                                - Rs. <?php echo number_format($discount); ?>
                            </strong>
                        </div>

                    </div>

                    <div class="summary-total">

                        <div>
                            <span>Total</span>
                            <small>Including estimated tax</small>
                        </div>

                        <strong>
                            Rs. <?php echo number_format($total); ?>
                        </strong>

                    </div>

                    <a href="checkout.php" class="checkout-button">
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

            <section class="cart-benefits">

                <div class="cart-benefit">
                    <span class="cart-benefit-icon">
                        <i class="bi bi-truck"></i>
                    </span>

                    <div>
                        <strong>Free Delivery</strong>
                        <span>On orders over Rs. 3,000</span>
                    </div>
                </div>

                <div class="cart-benefit">
                    <span class="cart-benefit-icon">
                        <i class="bi bi-arrow-repeat"></i>
                    </span>

                    <div>
                        <strong>Easy Returns</strong>
                        <span>Simple and hassle-free returns</span>
                    </div>
                </div>

                <div class="cart-benefit">
                    <span class="cart-benefit-icon">
                        <i class="bi bi-shield-check"></i>
                    </span>

                    <div>
                        <strong>Secure Payment</strong>
                        <span>Your payment is protected</span>
                    </div>
                </div>

            </section>

        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>