<?php
$pageTitle = "My Wishlist — Velyora";
?>
<?php include 'includes/header.php'; ?>

<!-- Account Page Wrapper -->
<div class="account-page-wrapper">
    <div class="container">
        
        <!-- Breadcrumb -->
        <div class="account-breadcrumb">
            <h2>Account</h2>
            <span>Home / Account / <strong>Wishlist</strong></span>
        </div>

        <div class="account-layout">
            
            <!-- LEFT SIDEBAR -->
            <aside class="account-sidebar">
                <div class="sidebar-profile">
                    <img src="assets/images/users/default-avatar.png" alt="User Profile" class="profile-img">
                    <h4 class="profile-name">Sarah Anderson</h4>
                    <span class="profile-badge"><i class="bi bi-star-fill"></i> Premium Member</span>
                </div>
                
                <nav class="sidebar-nav">
                    <a href="my-orders.php" class="nav-link">
                        <i class="bi bi-box"></i> 
                        <span>My Orders</span>
                        <span class="badge-count">3</span>
                    </a>
                    <!-- THIS IS NOW THE ACTIVE LINK -->
                    <a href="wishlist.php" class="nav-link active">
                        <i class="bi bi-heart"></i> 
                        <span>Wishlist</span>
                        <span class="badge-count dark">4</span>
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-credit-card"></i> 
                        <span>Payment Methods</span>
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-star"></i> 
                        <span>My Reviews</span>
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-geo-alt"></i> 
                        <span>Addresses</span>
                    </a>
                    <a href="#" class="nav-link">
                        <i class="bi bi-gear"></i> 
                        <span>Account Settings</span>
                    </a>
                </nav>

                <div class="sidebar-footer-links">
                    <a href="#" class="nav-link"><i class="bi bi-question-circle"></i> Help Center</a>
                    <a href="#" class="nav-link text-danger"><i class="bi bi-box-arrow-right"></i> Log Out</a>
                </div>
            </aside>

            <!-- RIGHT MAIN CONTENT -->
            <main class="account-content">
                
                <!-- Content Header -->
                <div class="content-header">
                    <h3>My Wishlist</h3>
                    <div class="header-actions">
                        <button class="btn-secondary"><i class="bi bi-cart-plus"></i> Add All to Cart</button>
                    </div>
                </div>

                <!-- Wishlist Grid -->
                <div class="wishlist-grid">
                    
                    <!-- Wishlist Item 1 -->
                    <div class="wishlist-card">
                        <button class="btn-remove-wishlist" title="Remove from wishlist"><i class="bi bi-trash"></i></button>
                        <div class="wishlist-img-wrapper">
                            <img src="assets/images/product-1.jpg" alt="Product">
                        </div>
                        <div class="wishlist-details">
                            <span class="wishlist-category">Electronics</span>
                            <h4 class="wishlist-title">Premium Wireless Headphones</h4>
                            <div class="wishlist-price">
                                <strong>$129.99</strong>
                                <span class="stock-status in-stock">In Stock</span>
                            </div>
                            <button class="btn-primary add-to-cart-btn">Add to Cart</button>
                        </div>
                    </div>

                    <!-- Wishlist Item 2 -->
                    <div class="wishlist-card">
                        <button class="btn-remove-wishlist" title="Remove from wishlist"><i class="bi bi-trash"></i></button>
                        <div class="wishlist-img-wrapper">
                            <img src="assets/images/product-2.jpg" alt="Product">
                        </div>
                        <div class="wishlist-details">
                            <span class="wishlist-category">Fashion</span>
                            <h4 class="wishlist-title">Cotton Blend T-Shirt</h4>
                            <div class="wishlist-price">
                                <strong>$29.00</strong>
                                <span class="stock-status out-of-stock">Out of Stock</span>
                            </div>
                            <button class="btn-secondary add-to-cart-btn" disabled>Out of Stock</button>
                        </div>
                    </div>

                     <!-- Wishlist Item 3 -->
                     <div class="wishlist-card">
                        <button class="btn-remove-wishlist" title="Remove from wishlist"><i class="bi bi-trash"></i></button>
                        <div class="wishlist-img-wrapper">
                            <img src="assets/images/product-3.jpg" alt="Product">
                        </div>
                        <div class="wishlist-details">
                            <span class="wishlist-category">Accessories</span>
                            <h4 class="wishlist-title">Leather Crossbody Bag</h4>
                            <div class="wishlist-price">
                                <strong>$124.00</strong>
                                <span class="stock-status in-stock">In Stock</span>
                            </div>
                            <button class="btn-primary add-to-cart-btn">Add to Cart</button>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>