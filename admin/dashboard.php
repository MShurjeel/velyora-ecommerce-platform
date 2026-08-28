<?php
$pageTitle = "Velyora Admin — Dashboard";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>

<div class="trendy-layout">
    
    <?php include 'includes/sidebar.php'; ?>

    <!-- =========================================================
         MAIN CONTENT
    ========================================================= -->
    <main class="trendy-main">
        
        <?php include 'includes/header.php'; ?>

        <!-- DASHBOARD SCROLLABLE CONTENT -->
        <div class="trendy-content">
            
            <!-- HERO BANNER -->
            <div class="hero-banner-card">
                <div class="hero-left">
                    <span class="hero-badge">DASHBOARD</span>
                    <h1>Good morning, Shurjeel 👋</h1>
                    <p>Here's what's happening with your Velyora store today.</p>
                    <button class="btn-hero-white">View analytics <i class="bi bi-arrow-right"></i></button>
                </div>
                <div class="hero-right">
                    <div class="hero-translucent-box">
                        <div class="box-text">
                            <strong>Rs. 45,280</strong>
                            <span>Today's Revenue</span>
                        </div>
                        <span class="box-pill positive"><i class="bi bi-arrow-up-short"></i> 12%</span>
                    </div>
                    <div class="hero-translucent-box">
                        <div class="box-text">
                            <strong>46</strong>
                            <span>New Orders</span>
                        </div>
                        <span class="box-pill negative"><i class="bi bi-arrow-down-short"></i> 6%</span>
                    </div>
                    <div class="hero-translucent-box">
                        <div class="box-text">
                            <strong>2,341</strong>
                            <span>Visitors</span>
                        </div>
                        <span class="box-pill positive"><i class="bi bi-arrow-up-short"></i> 21%</span>
                    </div>
                </div>
            </div>

            <!-- 4 STAT CARDS -->
            <div class="stats-four-grid">
                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-icon" style="background: #EFF6FF; color: #2563EB;"><i class="bi bi-cart"></i></div>
                        <span class="stat-pill positive"><i class="bi bi-arrow-up-short"></i> 12.5%</span>
                    </div>
                    <div class="stat-middle">
                        <h2>Rs. 124,426</h2>
                        <p>Total Sales</p>
                    </div>
                    <div class="stat-sparkline primary-spark"></div>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-icon" style="background: #DCFCE7; color: #16A34A;"><i class="bi bi-currency-dollar"></i></div>
                        <span class="stat-pill positive"><i class="bi bi-arrow-up-short"></i> 8.2%</span>
                    </div>
                    <div class="stat-middle">
                        <h2>Rs. 82,234</h2>
                        <p>Net Revenue</p>
                    </div>
                    <div class="stat-sparkline success-spark"></div>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-icon" style="background: #FEF3C7; color: #D97706;"><i class="bi bi-box"></i></div>
                        <span class="stat-pill negative"><i class="bi bi-arrow-down-short"></i> 3.1%</span>
                    </div>
                    <div class="stat-middle">
                        <h2>1,248</h2>
                        <p>Orders Placed</p>
                    </div>
                    <div class="stat-sparkline warning-spark"></div>
                </div>

                <div class="stat-card">
                    <div class="stat-top">
                        <div class="stat-icon" style="background: #E0F2FE; color: #0284C7;"><i class="bi bi-people"></i></div>
                        <span class="stat-pill positive"><i class="bi bi-arrow-up-short"></i> 5.6%</span>
                    </div>
                    <div class="stat-middle">
                        <h2>5,432</h2>
                        <p>Active Customers</p>
                    </div>
                    <div class="stat-sparkline sky-spark"></div>
                </div>
            </div>

            <!-- CHARTS ROW -->
            <div class="charts-row">
                <div class="card chart-large">
                    <div class="card-header">
                        <div>
                            <h3>Revenue Overview</h3>
                            <p>Income vs expenses this year</p>
                        </div>
                        <div class="chart-toggles">
                            <button class="active">Week</button>
                            <button>Month</button>
                            <button>Year</button>
                        </div>
                    </div>
                    <div class="chart-legend">
                        <span><i class="bi bi-circle-fill" style="color:#2563EB"></i> Revenue</span>
                        <span><i class="bi bi-circle-fill" style="color:#38BDF8"></i> Expenses</span>
                    </div>
                    <div class="chart-placeholder line-chart"></div>
                </div>

                <div class="card chart-small">
                    <div class="card-header">
                        <div>
                            <h3>Sales Goal</h3>
                            <p>Monthly target progress</p>
                        </div>
                        <button class="icon-btn-flat"><i class="bi bi-three-dots"></i></button>
                    </div>
                    <div class="chart-placeholder donut-chart">
                        <div class="donut-inner">
                            <h2>78%</h2>
                            <p>of monthly goal</p>
                        </div>
                    </div>
                    <div class="goal-stats">
                        <div>
                            <p>Target</p>
                            <strong>Rs. 500,000</strong>
                        </div>
                        <div>
                            <p>Earned</p>
                            <strong>Rs. 392,000</strong>
                        </div>
                    </div>
                    <div class="goal-alert">
                        <i class="bi bi-lightning-charge"></i> You're Rs. 108,000 away from your goal!
                    </div>
                </div>
            </div>

            <!-- WIDGETS 3-COLUMN ROW -->
            <div class="widgets-row">
                <!-- Traffic Sources -->
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h3>Traffic Sources</h3>
                            <p>Where your visitors come from</p>
                        </div>
                    </div>
                    <div class="traffic-list">
                        <div class="traffic-item">
                            <div class="traffic-icon primary-bg"><i class="bi bi-browser-chrome"></i></div>
                            <div class="traffic-data">
                                <div class="data-text"><span>Direct</span><strong>42%</strong></div>
                                <div class="progress-bar"><div style="width: 42%; background: #2563EB;"></div></div>
                            </div>
                        </div>
                        <div class="traffic-item">
                            <div class="traffic-icon success-bg"><i class="bi bi-search"></i></div>
                            <div class="traffic-data">
                                <div class="data-text"><span>Organic Search</span><strong>28%</strong></div>
                                <div class="progress-bar"><div style="width: 28%; background: #16A34A;"></div></div>
                            </div>
                        </div>
                        <div class="traffic-item">
                            <div class="traffic-icon sky-bg"><i class="bi bi-twitter"></i></div>
                            <div class="traffic-data">
                                <div class="data-text"><span>Social Media</span><strong>16%</strong></div>
                                <div class="progress-bar"><div style="width: 16%; background: #38BDF8;"></div></div>
                            </div>
                        </div>
                        <div class="traffic-item">
                            <div class="traffic-icon warning-bg"><i class="bi bi-link-45deg"></i></div>
                            <div class="traffic-data">
                                <div class="data-text"><span>Referrals</span><strong>9%</strong></div>
                                <div class="progress-bar"><div style="width: 9%; background: #F59E0B;"></div></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h3>Recent Transactions</h3>
                            <p>Latest account movements</p>
                        </div>
                        <a href="#" class="view-all">View all <i class="bi bi-chevron-right"></i></a>
                    </div>
                    <div class="transaction-list">
                        <div class="transaction-item">
                            <div class="trans-icon success-bg"><i class="bi bi-arrow-down-left"></i></div>
                            <div class="trans-info">
                                <strong>Stripe Payout</strong>
                                <span>Today, 09:41</span>
                            </div>
                            <span class="trans-amount positive">+ Rs. 24,800</span>
                        </div>
                        <div class="transaction-item">
                            <div class="trans-icon danger-bg"><i class="bi bi-arrow-up-right"></i></div>
                            <div class="trans-info">
                                <strong>Server Hosting (AWS)</strong>
                                <span>Today, 08:17</span>
                            </div>
                            <span class="trans-amount negative">- Rs. 4,500</span>
                        </div>
                        <div class="transaction-item">
                            <div class="trans-icon success-bg"><i class="bi bi-arrow-down-left"></i></div>
                            <div class="trans-info">
                                <strong>Order #ORD-0099</strong>
                                <span>Yesterday, 14:30</span>
                            </div>
                            <span class="trans-amount positive">+ Rs. 8,900</span>
                        </div>
                        <div class="transaction-item">
                            <div class="trans-icon danger-bg"><i class="bi bi-arrow-up-right"></i></div>
                            <div class="trans-info">
                                <strong>Customer Refund</strong>
                                <span>Yesterday, 11:05</span>
                            </div>
                            <span class="trans-amount negative">- Rs. 2,204</span>
                        </div>
                    </div>
                </div>

                <!-- Admin Tasks -->
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h3>Admin Tasks Today</h3>
                            <p>2 of 6 completed</p>
                        </div>
                    </div>
                    <div class="task-list">
                        <label class="task-item completed">
                            <input type="checkbox" checked>
                            <span class="task-text">Review Q3 sales report</span>
                            <span class="task-time">9:00</span>
                        </label>
                        <label class="task-item completed">
                            <input type="checkbox" checked>
                            <span class="task-text">Approve new vendor profiles</span>
                            <span class="task-time">10:30</span>
                        </label>
                        <label class="task-item">
                            <input type="checkbox">
                            <span class="task-text">Call with design team</span>
                            <span class="task-time">13:00</span>
                        </label>
                        <label class="task-item">
                            <input type="checkbox">
                            <span class="task-text">Update pricing page copy</span>
                            <span class="task-time">15:00</span>
                        </label>
                        <label class="task-item">
                            <input type="checkbox">
                            <span class="task-text">Prepare invoice batch</span>
                            <span class="task-time">16:30</span>
                        </label>
                    </div>
                    <button class="btn-add-task"><i class="bi bi-plus"></i> Add task</button>
                </div>
            </div>

            <!-- BOTTOM ROW (Tables & Lists) -->
            <div class="bottom-row">
                <!-- Recent Orders Table -->
                <div class="card table-card">
                    <div class="card-header">
                        <div>
                            <h3>Recent Orders</h3>
                            <p>Latest transactions from your store</p>
                        </div>
                        <a href="#" class="view-all">View all <i class="bi bi-chevron-right"></i></a>
                    </div>
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ORDER</th>
                                    <th>CUSTOMER</th>
                                    <th>PRODUCT</th>
                                    <th>AMOUNT</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-bold text-primary">#ORD-001</td>
                                    <td>
                                        <div class="user-cell">
                                            <img src="../assets/images/user1.jpg" alt="User">
                                            <div>
                                                <strong>Tariq Ali</strong>
                                                <span>tariq@example.com</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Premium Wireless Headphones</td>
                                    <td class="font-bold">Rs. 8,999</td>
                                    <td><span class="status-badge success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td class="font-bold text-primary">#ORD-002</td>
                                    <td>
                                        <div class="user-cell">
                                            <img src="../assets/images/user2.jpg" alt="User">
                                            <div>
                                                <strong>Aisha Khan</strong>
                                                <span>aisha@example.com</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Modern Everyday Hoodie</td>
                                    <td class="font-bold">Rs. 3,499</td>
                                    <td><span class="status-badge warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td class="font-bold text-primary">#ORD-003</td>
                                    <td>
                                        <div class="user-cell">
                                            <img src="../assets/images/user3.jpg" alt="User">
                                            <div>
                                                <strong>Usman Tariq</strong>
                                                <span>usman@example.com</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Urban Backpack</td>
                                    <td class="font-bold">Rs. 5,999</td>
                                    <td><span class="status-badge success">Completed</span></td>
                                </tr>
                                <tr>
                                    <td class="font-bold text-primary">#ORD-004</td>
                                    <td>
                                        <div class="user-cell">
                                            <img src="../assets/images/user4.jpg" alt="User">
                                            <div>
                                                <strong>Sara Ahmed</strong>
                                                <span>sara@example.com</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Smart Tech Essential</td>
                                    <td class="font-bold">Rs. 6,499</td>
                                    <td><span class="status-badge danger">Cancelled</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Top Products & Live Activity Col -->
                <div class="side-col">
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3>Top Products</h3>
                                <p>Best sellers this month</p>
                            </div>
                            <button class="icon-btn-flat"><i class="bi bi-three-dots"></i></button>
                        </div>
                        <div class="top-products-list">
                            <div class="product-rank-item">
                                <img src="../assets/images/products/product-1.png" alt="Product">
                                <div class="prod-info">
                                    <div class="prod-top"><strong>Wireless Headset</strong> <span>1,248 sold</span></div>
                                    <div class="progress-bar"><div style="width: 85%; background: var(--color-primary);"></div></div>
                                </div>
                            </div>
                            <div class="product-rank-item">
                                <img src="../assets/images/products/product-2.png" alt="Product">
                                <div class="prod-info">
                                    <div class="prod-top"><strong>Everyday Hoodie</strong> <span>986 sold</span></div>
                                    <div class="progress-bar"><div style="width: 70%; background: var(--color-primary);"></div></div>
                                </div>
                            </div>
                            <div class="product-rank-item">
                                <img src="../assets/images/products/product-3.png" alt="Product">
                                <div class="prod-info">
                                    <div class="prod-top"><strong>Urban Backpack</strong> <span>742 sold</span></div>
                                    <div class="progress-bar"><div style="width: 55%; background: var(--color-primary);"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3>Live Activity</h3>
                                <p>What's happening right now</p>
                            </div>
                            <span class="pulse-dot"></span>
                        </div>
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-marker success"></div>
                                <div class="timeline-content">
                                    <p>New order received <a href="#">#ORD-005</a></p>
                                    <span>2 minutes ago</span>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker primary"></div>
                                <div class="timeline-content">
                                    <p>New user registered <strong>Ali Raza</strong></p>
                                    <span>15 minutes ago</span>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker warning"></div>
                                <div class="timeline-content">
                                    <p>Inventory alert: <strong>Wireless Headset</strong> low stock</p>
                                    <span>1 hour ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
</div>

<!-- Scripts for Dropdown & Mobile Menu -->
<script>
    // Submenu Toggle
    document.querySelectorAll('.has-dropdown').forEach(item => {
        item.addEventListener('click', event => {
            event.preventDefault();
            item.classList.toggle('open');
        });
    });

    // Mobile Sidebar Toggle
    const mobileBtn = document.getElementById('mobileMenuBtn');
    const closeBtn = document.getElementById('mobileCloseBtn');
    const sidebar = document.querySelector('.trendy-sidebar');

    if(mobileBtn) {
        mobileBtn.addEventListener('click', () => {
            sidebar.classList.add('show');
        });
    }
    if(closeBtn) {
        closeBtn.addEventListener('click', () => {
            sidebar.classList.remove('show');
        });
    }
</script>

</body>
</html>