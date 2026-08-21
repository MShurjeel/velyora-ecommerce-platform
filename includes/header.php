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
                            <a href="#">
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
                <a href="cart.php" class="header-action cart-action">
                    <i class="bi bi-bag"></i>
                    <span>Cart</span>
                    <span class="cart-count">0</span>
                </a>
            </div>

            <!-- Mobile Menu -->
            <button class="mobile-menu-button" type="button">
                <i class="bi bi-list"></i>
            </button>
        </nav>
    </div>
</header>

<?php include("includes/navbar.php"); ?>