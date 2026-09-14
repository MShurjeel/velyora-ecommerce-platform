<?php $userOrders = getUserOrders(); ?>
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
        <?php if (empty($userOrders)): ?>
            <div class="text-center py-5" style="color: var(--color-text-light); text-align:center;">
                <i class="bi bi-box" style="font-size: 48px; color: var(--color-border); display: block; margin-bottom: 15px;"></i>
                <h5>No orders found</h5>
                <p>You haven't placed any orders yet.</p>
                <a href="index.php" class="btn-primary" style="display: inline-block; margin-top: 15px;">Start Shopping</a>
            </div>
        <?php else: ?>
            <?php foreach ($userOrders as $order): ?>
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-id">Order ID: <strong><?php echo htmlspecialchars($order['order_number']); ?></strong></div>
                        <div class="order-date"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></div>
                    </div>
                    <div class="order-body">
                        <div class="order-images">
                            <?php foreach ($order['items'] as $item): ?>
                                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" title="<?php echo htmlspecialchars($item['name']); ?>">
                            <?php endforeach; ?>
                        </div>
                        <div class="order-summary">
                            <div class="summary-row">
                                <span>Status</span>
                                <?php 
                                $statusClass = strtolower($order['order_status']); 
                                if ($statusClass === 'processing') $statusClass = 'processing';
                                elseif ($statusClass === 'delivered') $statusClass = 'delivered';
                                else $statusClass = 'pending';
                                ?>
                                <span class="status-badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($order['order_status']); ?></span>
                            </div>
                            <div class="summary-row">
                                <span>Items</span>
                                <span><?php echo count($order['items']); ?> Items</span>
                            </div>
                            <div class="summary-row total">
                                <span>Total</span>
                                <strong>Rs. <?php echo number_format($order['total_amount']); ?></strong>
                            </div>
                        </div>
                    </div>
                    <div class="order-actions">
                        <button class="btn-primary">Track Order</button>
                        <button class="btn-secondary">View Details</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>
