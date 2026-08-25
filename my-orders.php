<main class="account-content">
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