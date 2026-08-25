<?php
$pageTitle = "My Profile — Velyora";
include 'includes/header.php';
?>

<div class="account-page-wrapper">
    <div class="container">

        <!-- Unified Breadcrumb -->
        <div class="account-breadcrumb">
            <h2>Account</h2>
            <span>Home / <strong>My Profile</strong></span>
        </div>

        <div class="account-layout">

            <!-- LEFT SIDEBAR: Converted to Bootstrap Pills -->
            <aside class="account-sidebar">
                <div class="sidebar-profile">
                    <img src="assets/images/users/default-avatar.png" alt="User Profile" class="profile-img">
                    <h4 class="profile-name">Sarah Anderson</h4>
                    <span class="profile-badge"><i class="bi bi-star-fill"></i> Premium Member</span>
                </div>

                <!-- Removed 'nav-pills' to prevent Bootstrap's blue override -->
                <nav class="sidebar-nav nav flex-column" role="tablist">
                    <a href="#v-pills-orders" class="nav-link active" id="v-pills-orders-tab" data-bs-toggle="pill" data-bs-target="#v-pills-orders" role="tab">
                        <i class="bi bi-box"></i>
                        <span>My Orders</span>
                        <span class="badge-count">3</span>
                    </a>
                    <a href="#v-pills-wishlist" class="nav-link" id="v-pills-wishlist-tab" data-bs-toggle="pill" data-bs-target="#v-pills-wishlist" role="tab">
                        <i class="bi bi-heart"></i>
                        <span>Wishlist</span>
                        <span class="badge-count dark">4</span>
                    </a>
                    <a href="#v-pills-payments" class="nav-link" id="v-pills-payments-tab" data-bs-toggle="pill" data-bs-target="#v-pills-payments" role="tab">
                        <i class="bi bi-credit-card"></i>
                        <span>Payment Methods</span>
                    </a>
                    <a href="#v-pills-reviews" class="nav-link" id="v-pills-reviews-tab" data-bs-toggle="pill" data-bs-target="#v-pills-reviews" role="tab">
                        <i class="bi bi-star"></i>
                        <span>My Reviews</span>
                    </a>
                    <a href="#v-pills-addresses" class="nav-link" id="v-pills-addresses-tab" data-bs-toggle="pill" data-bs-target="#v-pills-addresses" role="tab">
                        <i class="bi bi-geo-alt"></i>
                        <span>Addresses</span>
                    </a>
                    <a href="#v-pills-settings" class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" role="tab">
                        <i class="bi bi-gear"></i>
                        <span>Account Settings</span>
                    </a>
                </nav>

                <div class="sidebar-footer-links">
                    <a href="#" class="nav-link"><i class="bi bi-question-circle"></i> Help Center</a>
                    <a href="#" class="nav-link text-danger"><i class="bi bi-box-arrow-right"></i> Log Out</a>
                </div>
            </aside>
            <!-- RIGHT MAIN CONTENT: Tab Panes -->
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-orders" role="tabpanel">
                    <?php include 'my-orders.php'; ?>
                </div>
                <div class="tab-pane fade" id="v-pills-wishlist" role="tabpanel">
                    <?php include 'wishlist.php'; ?>
                </div>
                <div class="tab-pane fade" id="v-pills-payments" role="tabpanel">
                    <?php include 'payment-methods.php'; ?>
                </div>
                <div class="tab-pane fade" id="v-pills-reviews" role="tabpanel">
                    <?php include 'my-reviews.php'; ?>
                </div>
                <div class="tab-pane fade" id="v-pills-addresses" role="tabpanel">
                    <?php include 'my-addresses.php'; ?>
                </div>
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel">
                    <?php include 'account-settings.php'; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>