<?php
// Fetch real orders for the logged-in user
$userOrders = function_exists('getUserOrders') ? getUserOrders() : [];
$orderCount = count($userOrders);

// Status badge config: [bg-color, text-color, icon]
$statusConfig = [
    'Processing' => ['bg' => '#FEF3C7', 'color' => '#D97706', 'icon' => 'bi-clock-history'],
    'Shipped'    => ['bg' => '#DBEAFE', 'color' => '#2563EB', 'icon' => 'bi-truck'],
    'Delivered'  => ['bg' => '#DCFCE7', 'color' => '#16A34A', 'icon' => 'bi-check-circle'],
    'Cancelled'  => ['bg' => '#FEE2E2', 'color' => '#DC2626', 'icon' => 'bi-x-circle'],
    'Pending'    => ['bg' => '#F3F4F6', 'color' => '#6B7280', 'icon' => 'bi-hourglass-split'],
];
?>

<main class="account-content orders-tab">

    <!-- ── Header ── -->
    <div class="content-header">
        <div class="content-header-left">
            <h3>My Orders</h3>
            <?php if ($orderCount > 0): ?>
                <span class="orders-total-badge"><?php echo $orderCount; ?> Order<?php echo $orderCount !== 1 ? 's' : ''; ?></span>
            <?php endif; ?>
        </div>
        <div class="header-actions">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" id="orderSearch" placeholder="Search orders..." autocomplete="off">
            </div>
            <button class="btn-filter" id="filterToggle">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </div>
    </div>

    <!-- ── Filter Bar (hidden by default) ── -->
    <div class="filter-bar" id="filterBar" style="display:none;">
        <span class="filter-label">Status:</span>
        <button class="filter-chip active" data-status="all">All</button>
        <button class="filter-chip" data-status="Processing">Processing</button>
        <button class="filter-chip" data-status="Shipped">Shipped</button>
        <button class="filter-chip" data-status="Delivered">Delivered</button>
        <button class="filter-chip" data-status="Cancelled">Cancelled</button>
    </div>

    <!-- ── Order List ── -->
    <div class="orders-list" id="ordersList">

        <?php if (empty($userOrders)): ?>

            <!-- Empty State -->
            <div class="orders-empty-state">
                <div class="orders-empty-icon">
                    <i class="bi bi-bag-x"></i>
                </div>
                <h4>No orders yet</h4>
                <p>Looks like you haven't placed any orders. Start shopping and your orders will appear here!</p>
                <a href="products.php" class="btn-shop-now">
                    <i class="bi bi-bag"></i> Start Shopping
                </a>
            </div>

        <?php else: ?>

            <?php foreach ($userOrders as $order):
                $status = $order['order_status'] ?? 'Pending';
                $cfg    = $statusConfig[$status] ?? $statusConfig['Pending'];
                $items  = $order['items'] ?? [];
                $itemCount = count($items);
                // Show max 3 thumbnails, then a "+N" overflow chip
                $maxThumbs = 3;
                $extraCount = max(0, $itemCount - $maxThumbs);
                $shownItems = array_slice($items, 0, $maxThumbs);
            ?>

            <div class="order-card" data-status="<?php echo htmlspecialchars($status); ?>" data-search="<?php echo strtolower(htmlspecialchars($order['order_number'] . ' ' . $status)); ?>">

                <!-- Order Card Header -->
                <div class="order-card-header">
                    <div class="order-meta">
                        <span class="order-label">Order ID:</span>
                        <strong class="order-number"><?php echo htmlspecialchars($order['order_number']); ?></strong>
                    </div>
                    <div class="order-date">
                        <i class="bi bi-calendar3"></i>
                        <?php echo date('M d, Y', strtotime($order['created_at'])); ?>
                    </div>
                </div>

                <!-- Order Card Body -->
                <div class="order-card-body">
                    <!-- Product Thumbnails -->
                    <div class="order-thumbs">
                        <?php foreach ($shownItems as $item): ?>
                            <div class="order-thumb">
                                <img src="<?php echo htmlspecialchars($item['image']); ?>"
                                     alt="<?php echo htmlspecialchars($item['name']); ?>"
                                     title="<?php echo htmlspecialchars($item['name']); ?>"
                                     loading="lazy">
                            </div>
                        <?php endforeach; ?>
                        <?php if ($extraCount > 0): ?>
                            <div class="order-thumb order-thumb-more">+<?php echo $extraCount; ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Order Summary -->
                    <div class="order-summary">
                        <div class="order-summary-row">
                            <span>Status</span>
                            <span class="order-status-badge" style="background:<?php echo $cfg['bg']; ?>; color:<?php echo $cfg['color']; ?>;">
                                <i class="bi <?php echo $cfg['icon']; ?>"></i>
                                <?php echo htmlspecialchars($status); ?>
                            </span>
                        </div>
                        <div class="order-summary-row">
                            <span>Items</span>
                            <span><?php echo $itemCount; ?> item<?php echo $itemCount !== 1 ? 's' : ''; ?></span>
                        </div>
                        <div class="order-summary-row total-row">
                            <span>Total</span>
                            <strong>Rs. <?php echo number_format($order['total_amount']); ?></strong>
                        </div>
                    </div>
                </div>

                <!-- Order Card Actions -->
                <div class="order-card-actions">
                    <?php if ($status === 'Delivered'): ?>
                        <button class="order-btn order-btn-outline-success">
                            <i class="bi bi-pencil-square"></i> Write Review
                        </button>
                    <?php elseif ($status === 'Cancelled'): ?>
                        <button class="order-btn order-btn-outline-primary">
                            <i class="bi bi-arrow-repeat"></i> Reorder
                        </button>
                    <?php else: ?>
                        <button class="order-btn order-btn-dark">
                            <i class="bi bi-geo-alt"></i> Track Order
                        </button>
                    <?php endif; ?>
                    <button class="order-btn order-btn-secondary">
                        <i class="bi bi-eye"></i> View Details
                    </button>
                </div>

            </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div><!-- /.orders-list -->

</main>

<style>
/* ── My Orders Tab Styles ─────────────────────────────── */
.orders-tab .content-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.content-header-left {
    display: flex;
    align-items: center;
    gap: 12px;
}
.orders-tab .content-header h3 {
    font-size: 1.35rem;
    font-weight: 700;
    color: var(--color-heading);
    margin: 0;
}
.orders-total-badge {
    background: var(--color-primary-soft);
    color: var(--color-primary);
    font-size: 0.75rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
}
.header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}
.search-box {
    display: flex;
    align-items: center;
    gap: 8px;
    background: var(--color-background-soft);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-sm);
    padding: 8px 14px;
    min-width: 220px;
}
.search-box i { color: var(--color-text-muted); font-size: 0.9rem; }
.search-box input {
    border: none; background: transparent; outline: none;
    font-size: 0.875rem; color: var(--color-text); width: 100%;
}
.btn-filter {
    display: flex; align-items: center; gap: 6px;
    background: var(--color-background-soft);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-sm);
    padding: 8px 16px;
    font-size: 0.875rem; font-weight: 500;
    color: var(--color-text); cursor: pointer;
    transition: var(--transition);
}
.btn-filter:hover { background: var(--color-border-light); border-color: var(--color-primary); color: var(--color-primary); }

/* ── Filter Bar ── */
.filter-bar {
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 18px; flex-wrap: wrap;
}
.filter-label { font-size: 0.8rem; color: var(--color-text-muted); font-weight: 500; }
.filter-chip {
    background: var(--color-background-soft);
    border: 1px solid var(--color-border);
    border-radius: 20px; padding: 4px 14px;
    font-size: 0.8rem; font-weight: 500; color: var(--color-text);
    cursor: pointer; transition: var(--transition);
}
.filter-chip:hover, .filter-chip.active {
    background: var(--color-primary); border-color: var(--color-primary); color: #fff;
}

/* ── Order Cards ── */
.orders-list { display: flex; flex-direction: column; gap: 16px; }

.order-card {
    background: var(--color-background);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-md);
    overflow: hidden;
    transition: box-shadow var(--transition), border-color var(--transition);
}
.order-card:hover {
    box-shadow: var(--shadow-md);
    border-color: var(--color-border-blue);
}

/* Card Header */
.order-card-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 20px;
    background: var(--color-background-soft);
    border-bottom: 1px solid var(--color-border-light);
    gap: 12px; flex-wrap: wrap;
}
.order-meta { display: flex; align-items: center; gap: 8px; }
.order-label { font-size: 0.8rem; color: var(--color-text-muted); }
.order-number { font-size: 0.9rem; color: var(--color-heading); font-weight: 700; }
.order-date {
    font-size: 0.8rem; color: var(--color-text-light);
    display: flex; align-items: center; gap: 5px;
}

/* Card Body */
.order-card-body {
    display: flex; align-items: flex-start;
    gap: 20px; padding: 18px 20px;
    flex-wrap: wrap;
}

/* Thumbnails */
.order-thumbs {
    display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
    flex: 0 0 auto;
}
.order-thumb {
    width: 68px; height: 68px;
    border-radius: var(--radius-sm);
    border: 1px solid var(--color-border);
    overflow: hidden; background: var(--color-background-soft);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.order-thumb img { width: 100%; height: 100%; object-fit: cover; }
.order-thumb-more {
    font-size: 0.85rem; font-weight: 700;
    color: var(--color-text-light);
    background: var(--color-background-soft);
    border: 1px dashed var(--color-border);
    letter-spacing: -0.5px;
}

/* Summary */
.order-summary {
    flex: 1; min-width: 200px;
    display: flex; flex-direction: column; gap: 6px;
    margin-left: auto;
}
.order-summary-row {
    display: flex; justify-content: space-between; align-items: center;
    font-size: 0.875rem; color: var(--color-text);
}
.order-summary-row span:first-child { color: var(--color-text-muted); }
.total-row { padding-top: 6px; border-top: 1px solid var(--color-border-light); margin-top: 4px; }
.total-row strong { font-size: 1rem; color: var(--color-heading); font-weight: 700; }

/* Status Badge */
.order-status-badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 0.78rem; font-weight: 600;
    padding: 3px 10px; border-radius: 20px; line-height: 1.5;
}
.order-status-badge i { font-size: 0.8rem; }

/* Card Actions */
.order-card-actions {
    display: flex; gap: 10px;
    padding: 14px 20px;
    border-top: 1px solid var(--color-border-light);
    background: var(--color-background-ultrasoft);
    flex-wrap: wrap;
}
.order-btn {
    flex: 1; padding: 10px 16px;
    border-radius: var(--radius-sm);
    font-size: 0.875rem; font-weight: 600;
    display: flex; align-items: center; justify-content: center; gap: 7px;
    cursor: pointer; border: 1px solid transparent;
    transition: var(--transition); min-width: 130px;
}
.order-btn-dark { background: var(--color-heading); color: #fff; border-color: var(--color-heading); }
.order-btn-dark:hover { background: var(--color-navy); border-color: var(--color-navy); }
.order-btn-secondary { background: var(--color-background); color: var(--color-text); border-color: var(--color-border); }
.order-btn-secondary:hover { background: var(--color-background-soft); border-color: var(--color-primary); color: var(--color-primary); }
.order-btn-outline-success { background: var(--color-success-soft); color: var(--color-success); border-color: var(--color-success); }
.order-btn-outline-success:hover { background: var(--color-success); color: #fff; }
.order-btn-outline-primary { background: var(--color-primary-soft); color: var(--color-primary); border-color: var(--color-primary); }
.order-btn-outline-primary:hover { background: var(--color-primary); color: #fff; }

/* ── Empty State ── */
.orders-empty-state {
    text-align: center; padding: 60px 20px;
    background: var(--color-background-soft);
    border: 1.5px dashed var(--color-border);
    border-radius: var(--radius-md);
}
.orders-empty-icon {
    width: 80px; height: 80px;
    background: var(--color-border-light); border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
}
.orders-empty-icon i { font-size: 2rem; color: var(--color-text-muted); }
.orders-empty-state h4 { font-size: 1.1rem; font-weight: 700; color: var(--color-heading); margin-bottom: 8px; }
.orders-empty-state p { font-size: 0.9rem; color: var(--color-text-light); margin-bottom: 24px; }
.btn-shop-now {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--color-primary); color: #fff;
    padding: 10px 24px; border-radius: var(--radius-sm);
    font-size: 0.9rem; font-weight: 600; text-decoration: none;
    transition: var(--transition);
}
.btn-shop-now:hover { background: var(--color-primary-hover); color: #fff; }

/* ── Responsive ── */
@media (max-width: 600px) {
    .order-card-body { flex-direction: column; }
    .order-summary { margin-left: 0; }
    .order-btn { min-width: 100%; }
}
</style>

<script>
// ── Search + Filter Logic ────────────────────────────────
(function () {
    const searchInput = document.getElementById('orderSearch');
    const filterToggle = document.getElementById('filterToggle');
    const filterBar = document.getElementById('filterBar');
    const filterChips = document.querySelectorAll('.filter-chip');
    const cards = document.querySelectorAll('.order-card');

    let activeStatus = 'all';

    function applyFilters() {
        const q = (searchInput?.value || '').toLowerCase();
        cards.forEach(card => {
            const status = (card.dataset.status || '').toLowerCase();
            const search = (card.dataset.search || '').toLowerCase();
            const statusMatch = activeStatus === 'all' || status === activeStatus.toLowerCase();
            const searchMatch = !q || search.includes(q);
            card.style.display = (statusMatch && searchMatch) ? '' : 'none';
        });
    }

    filterToggle?.addEventListener('click', () => {
        filterBar.style.display = filterBar.style.display === 'none' ? 'flex' : 'none';
    });

    filterChips.forEach(chip => {
        chip.addEventListener('click', () => {
            filterChips.forEach(c => c.classList.remove('active'));
            chip.classList.add('active');
            activeStatus = chip.dataset.status;
            applyFilters();
        });
    });

    searchInput?.addEventListener('input', applyFilters);
})();
</script>

