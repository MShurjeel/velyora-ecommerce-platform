<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/style.css">
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
                <img src="assets/images/logo/velyora-logo.png" alt="Velyora">
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
                            <a href="my-orders.php">
                                <i class="bi bi-box"></i>
                                <span>My Orders</span>
                            </a>
                            <a href="#">
                                <i class="bi bi-arrow-return-left"></i>
                                <span>Returns &amp; Refunds</span>
                            </a>
                            <a href="#">
                                <i class="bi bi-question-circle"></i>
                                <span>Help Center</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Wishlist -->
                <a href="#" class="header-action">
                    <i class="bi bi-heart"></i>
                    <span>Wishlist</span>
                </a>

                <!-- Cart -->
                <div class="cart-dropdown">
                    <!-- The Cart Toggle Button -->
                    <button type="button" class="header-action cart-dropdown-toggle">
                        <i class="bi bi-bag"></i>
                        <span>Cart</span>
                        <span class="cart-count">3</span>
                    </button>

                    <!-- The Mini-Cart Menu (Matches image_67eec9.jpg) -->
                    <div class="cart-dropdown-menu">

                        <!-- Cart Header -->
                        <div class="cart-header">
                            <span class="cart-title">Shopping Cart</span>
                            <span class="cart-item-count">3 items</span>
                        </div>

                        <!-- Cart Items List -->
                        <div class="cart-items-wrapper">

                            <!-- Item 1 -->
                            <div class="cart-item">
                                <img src="assets/images/product-1.jpg" alt="Leather Bag" class="cart-item-img">
                                <div class="cart-item-details">
                                    <h6 class="cart-item-name">Leather Crossbody Bag</h6>
                                    <span class="cart-item-variant">Tan / One Size</span>
                                    <div class="cart-item-price-row">
                                        <span class="cart-item-price">$124.00</span>
                                        <span class="cart-item-qty">Qty: 1</span>
                                    </div>
                                </div>
                                <button type="button" class="cart-item-remove"><i class="bi bi-x"></i></button>
                            </div>

                            <!-- Item 2 -->
                            <div class="cart-item">
                                <img src="assets/images/product-2.jpg" alt="T-Shirt" class="cart-item-img">
                                <div class="cart-item-details">
                                    <h6 class="cart-item-name">Cotton Blend T-Shirt</h6>
                                    <span class="cart-item-variant">White / M</span>
                                    <div class="cart-item-price-row">
                                        <span class="cart-item-price">$29.00</span>
                                        <span class="cart-item-qty">Qty: 2</span>
                                    </div>
                                </div>
                                <button type="button" class="cart-item-remove"><i class="bi bi-x"></i></button>
                            </div>

                        </div>

                        <!-- Cart Footer / Summary -->
                        <div class="cart-footer">
                            <div class="cart-subtotal">
                                <span class="subtotal-label">Subtotal</span>
                                <span class="subtotal-amount">$153.00</span>
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