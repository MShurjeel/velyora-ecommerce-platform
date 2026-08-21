<?php
$pageTitle = "My Orders — Velyora";
?>
<?php include 'includes/header.php'; ?>

<!-- Account Page Wrapper -->
<div class="account-page-wrapper">
    <div class="container">
        
        <!-- Breadcrumb -->
        <div class="account-breadcrumb">
            <h2>Account</h2>
            <span>Home / Account / <strong>My Orders</strong></span>
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
                    <!-- Active Link -->
                    <a href="my-orders.php" class="nav-link active">
                        <i class="bi bi-box"></i> 
                        <span>My Orders</span>
                        <span class="badge-count">3</span>
                    </a>
                    <a href="wishlist.php" class="nav-link">
                        <i class="bi bi-heart"></i> 
                        <span>Wishlist</span>
                        <span class="badge-count dark">12</span>
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
                    <h3>My Orders</h3>
                    <div class="header-actions">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" placeholder="Search orders...">
                        </div>
                        <button class="btn-filter"><i class="bi bi-funnel"></i> Filter</button>
                    </div>
                </div>

                <!-- Order List -->
                <div class="orders-list">
                    
                    <!-- Order Card 1: Processing -->
                    <div class="order-card">
                        <div class="order-header">
                            <div class="order-id">Order ID: <strong>#ORD-2026-1278</strong></div>
                            <div class="order-date">Feb 20, 2026</div>
                        </div>
                        <div class="order-body">
                            <div class="order-images">
                                <img src="assets/images/product-1.jpg" alt="Item">
                                <img src="assets/images/product-2.jpg" alt="Item">
                                <img src="assets/images/product-3.jpg" alt="Item">
                            </div>
                            <div class="order-summary">
                                <div class="summary-row">
                                    <span>Status</span>
                                    <span class="status-badge processing">Processing</span>
                                </div>
                                <div class="summary-row">
                                    <span>Items</span>
                                    <span>3 Items</span>
                                </div>
                                <div class="summary-row total">
                                    <span>Total</span>
                                    <strong>$789.99</strong>
                                </div>
                            </div>
                        </div>
                        <div class="order-actions">
                            <button class="btn-primary">Track Order</button>
                            <button class="btn-secondary">View Details</button>
                        </div>
                    </div>

                    <!-- Order Card 2: Delivered -->
                    <div class="order-card">
                        <div class="order-header">
                            <div class="order-id">Order ID: <strong>#ORD-2026-1252</strong></div>
                            <div class="order-date">Feb 10, 2026</div>
                        </div>
                        <div class="order-body">
                            <div class="order-images">
                                <img src="assets/images/product-4.jpg" alt="Item">
                            </div>
                            <div class="order-summary">
                                <div class="summary-row">
                                    <span>Status</span>
                                    <span class="status-badge delivered">Delivered</span>
                                </div>
                                <div class="summary-row">
                                    <span>Items</span>
                                    <span>1 Item</span>
                                </div>
                                <div class="summary-row total">
                                    <span>Total</span>
                                    <strong>$129.99</strong>
                                </div>
                            </div>
                        </div>
                        <div class="order-actions">
                            <button class="btn-outline-success">Write Review</button>
                            <button class="btn-secondary">View Details</button>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>