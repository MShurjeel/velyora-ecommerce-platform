<?php require_once __DIR__ . '/../config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Velyora — Modern Everyday Essentials'; ?></title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/product.css">
    <link rel="stylesheet" href="assets/css/products.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>
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
            <a href="index.php" class="brand-logo">
                <img src="assets/images/logo/logo-light-bg.png" alt="Velyora">
            </a>

            <!-- Search -->
            <div class="header-search">
                <form>
                    <input type="search" placeholder="Search products, categories or brands...">
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
                        <div class="account-dropdown-header">
                            <h3>Welcome!</h3>
                            <p>Sign in for the best experience</p>
                        </div>

                        <div class="account-dropdown-actions">
                            <a href="login.php" class="account-signin">Sign In</a>
                            <a href="register.php" class="account-register">Create Account</a>
                        </div>

                        <div class="account-dropdown-links">
                            <a href="my-profile.php">
                                <i class="bi bi-person-circle"></i>
                                <span>My Profile</span>
                            </a>
                            <a href="help-center.php">
                                <i class="bi bi-question-circle"></i>
                                <span>Help Center</span>
                            </a>
                        </div>
                    </div>
                </div>

                <?php
                $headerCartItems = getCartItems();
                $headerCartTotals = getCartTotals();
                $headerCartCount = $headerCartTotals['item_count'];
                $headerWishlistCount = getWishlistCount();
                ?>
                <!-- Wishlist -->
                <a href="my-profile.php#v-pills-wishlist" class="header-action" aria-label="View Wishlist">
                    <i class="bi bi-heart"></i>
                    <span>Wishlist</span>
                    <span class="cart-count wishlist-badge-count" style="<?php echo $headerWishlistCount > 0 ? '' : 'display:none;'; ?>"><?php echo $headerWishlistCount; ?></span>
                </a>

                <!-- Cart -->
                <div class="cart-dropdown">
                    <!-- The Cart Toggle Button -->
                    <button type="button" class="header-action cart-dropdown-toggle" aria-label="View Cart">
                        <i class="bi bi-bag"></i>
                        <span>Cart</span>
                        <span class="cart-count cart-badge-count" style="<?php echo $headerCartCount > 0 ? '' : 'display:none;'; ?>"><?php echo $headerCartCount; ?></span>
                    </button>

                    <!-- The Mini-Cart Menu -->
                    <div class="cart-dropdown-menu">

                        <!-- Cart Header -->
                        <div class="cart-header">
                            <span class="cart-title">Shopping Cart</span>
                            <span class="cart-item-count mini-cart-count"><?php echo $headerCartCount; ?> item<?php echo $headerCartCount === 1 ? '' : 's'; ?></span>
                        </div>

                        <!-- Cart Items List -->
                        <div class="cart-items-wrapper">
                            <?php if (empty($headerCartItems)): ?>
                                <div class="mini-cart-empty text-center py-4" style="padding: 24px 15px; color: var(--color-text-light); text-align: center;">
                                    <i class="bi bi-bag" style="font-size: 28px; color: var(--color-border); display: block; margin-bottom: 8px;"></i>
                                    <span style="font-size: 13px;">Your cart is empty</span>
                                </div>
                            <?php else: ?>
                                <?php foreach ($headerCartItems as $hItem): ?>
                                    <div class="cart-item" data-cart-id="<?php echo $hItem['cart_id']; ?>">
                                        <a href="product.php?id=<?php echo $hItem['product_id']; ?>">
                                            <img src="<?php echo htmlspecialchars($hItem['image']); ?>" alt="<?php echo htmlspecialchars($hItem['name']); ?>" class="cart-item-img">
                                        </a>
                                        <div class="cart-item-details">
                                            <h6 class="cart-item-name">
                                                <a href="product.php?id=<?php echo $hItem['product_id']; ?>" style="text-decoration:none; color:inherit;">
                                                    <?php echo htmlspecialchars($hItem['name']); ?>
                                                </a>
                                            </h6>
                                            <span class="cart-item-variant"><?php echo htmlspecialchars($hItem['variant']); ?></span>
                                            <div class="cart-item-price-row">
                                                <span class="cart-item-price">Rs. <?php echo number_format($hItem['price']); ?></span>
                                                <span class="cart-item-qty">Qty: <?php echo $hItem['quantity']; ?></span>
                                            </div>
                                        </div>
                                        <button type="button" class="cart-item-remove mini-cart-remove" data-cart-id="<?php echo $hItem['cart_id']; ?>" title="Remove item"><i class="bi bi-x"></i></button>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Cart Footer / Summary -->
                        <div class="cart-footer">
                            <div class="cart-subtotal">
                                <span class="subtotal-label">Subtotal</span>
                                <span class="subtotal-amount mini-cart-subtotal"><?php echo $headerCartTotals['subtotal_formatted']; ?></span>
                            </div>
                            <a href="checkout.php" class="btn-checkout">Checkout</a>
                            <a href="cart.php" class="btn-view-cart">View full cart &rarr;</a>
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


<?php include("includes/navbar.php"); ?>

<!-- Wrap your JavaScript in script tags -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cartToggle = document.querySelector('.cart-dropdown-toggle');
    const cartDropdown = document.querySelector('.cart-dropdown');

    if (cartToggle && cartDropdown) {
        // Toggle the menu when clicking the cart button
        cartToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Prevents the click from instantly closing it
            cartDropdown.classList.toggle('active');
        });

        // Close the menu if you click outside of it
        document.addEventListener('click', function(e) {
            if (!cartDropdown.contains(e.target)) {
                cartDropdown.classList.remove('active');
            }
        });
        
        // Prevent clicking inside the menu from closing it
        cartDropdown.querySelector('.cart-dropdown-menu').addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});
</script>