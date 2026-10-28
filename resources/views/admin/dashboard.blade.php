@extends('admin.layouts.admin')

@section('title', 'Velyora Admin — Dashboard')

@section('content')
<!-- HERO BANNER -->
<div class="hero-banner-card">
    <div class="hero-left">
        <span class="hero-badge">DASHBOARD</span>
        <h1>Welcome, {{ auth()->check() ? auth()->user()->name : 'Shurjeel' }} 👋</h1>
        <p>Here's what's happening with your Velyora store today.</p>
        <a href="{{ route('admin.orders.index') }}" class="btn-hero-white" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
            View orders <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="hero-right">
        <div class="hero-translucent-box">
            <div class="box-text">
                <strong>Rs. {{ number_format($totalSales) }}</strong>
                <span>Total Revenue</span>
            </div>
            <span class="box-pill positive"><i class="bi bi-arrow-up-short"></i> Active</span>
        </div>
        <div class="hero-translucent-box">
            <div class="box-text">
                <strong>{{ $totalOrders }}</strong>
                <span>Total Orders</span>
            </div>
            <span class="box-pill positive"><i class="bi bi-arrow-up-short"></i> Live</span>
        </div>
        <div class="hero-translucent-box">
            <div class="box-text">
                <strong>{{ $totalProducts }}</strong>
                <span>Active Products</span>
            </div>
            <span class="box-pill positive"><i class="bi bi-arrow-up-short"></i> In Stock</span>
        </div>
    </div>
</div>

<!-- 4 STAT CARDS -->
<div class="stats-four-grid">
    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-icon" style="background: #EFF6FF; color: #2563EB;"><i class="bi bi-cart"></i></div>
            <span class="stat-pill positive"><i class="bi bi-arrow-up-short"></i> Active</span>
        </div>
        <div class="stat-middle">
            <h2>Rs. {{ number_format($totalSales) }}</h2>
            <p>Total Revenue</p>
        </div>
        <div class="stat-sparkline primary-spark"></div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-icon" style="background: #FEF3C7; color: #D97706;"><i class="bi bi-box"></i></div>
            <span class="stat-pill positive"><i class="bi bi-arrow-up-short"></i> Orders</span>
        </div>
        <div class="stat-middle">
            <h2>{{ $totalOrders }}</h2>
            <p>Orders Placed</p>
        </div>
        <div class="stat-sparkline warning-spark"></div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-icon" style="background: #DCFCE7; color: #16A34A;"><i class="bi bi-boxes"></i></div>
            <span class="stat-pill positive"><i class="bi bi-arrow-up-short"></i> Catalog</span>
        </div>
        <div class="stat-middle">
            <h2>{{ $totalProducts }}</h2>
            <p>Products in Catalog</p>
        </div>
        <div class="stat-sparkline success-spark"></div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-icon" style="background: #E0F2FE; color: #0284C7;"><i class="bi bi-people"></i></div>
            <span class="stat-pill positive"><i class="bi bi-arrow-up-short"></i> Users</span>
        </div>
        <div class="stat-middle">
            <h2>{{ $totalCustomers }}</h2>
            <p>Registered Customers</p>
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
                <p>Store performance and activity</p>
            </div>
            <div class="chart-toggles">
                <button class="active">Week</button>
                <button>Month</button>
                <button>Year</button>
            </div>
        </div>
        <div class="chart-legend">
            <span><i class="bi bi-circle-fill" style="color:#2563EB"></i> Revenue</span>
            <span><i class="bi bi-circle-fill" style="color:#38BDF8"></i> Conversions</span>
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
                <h2>84%</h2>
                <p>of monthly goal</p>
            </div>
        </div>
        <div class="goal-stats">
            <div>
                <p>Target</p>
                <strong>Rs. 250,000</strong>
            </div>
            <div>
                <p>Achieved</p>
                <strong>Rs. {{ number_format($totalSales) }}</strong>
            </div>
        </div>
        <div class="goal-alert">
            <i class="bi bi-lightning-charge"></i> Keep pushing to surpass your targets!
        </div>
    </div>
</div>

<!-- BOTTOM ROW (Tables & Lists) -->
<div class="bottom-row">
    <!-- Recent Orders Table -->
    <div class="card table-card" style="grid-column: 1 / -1;">
        <div class="card-header">
            <div>
                <h3>Recent Orders</h3>
                <p>Latest transactions from your store</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="view-all">View all <i class="bi bi-chevron-right"></i></a>
        </div>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ORDER</th>
                        <th>CUSTOMER</th>
                        <th>AMOUNT</th>
                        <th>STATUS</th>
                        <th>DATE</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentOrders as $order)
                        <tr>
                            <td class="font-bold text-primary">{{ $order->order_number }}</td>
                            <td>
                                <div class="user-cell">
                                    <img src="{{ asset('assets/images/users/default-avatar.png') }}" alt="User">
                                    <div>
                                        <strong>{{ $order->customer_name }}</strong>
                                        <span>{{ $order->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="font-bold">Rs. {{ number_format($order->total_amount) }}</td>
                            <td>
                                <span class="status-badge {{ strtolower($order->order_status) === 'delivered' ? 'success' : (strtolower($order->order_status) === 'processing' ? 'warning' : 'info') }}">
                                    {{ $order->order_status }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding: 24px; color: var(--color-text-muted);">
                                No orders placed yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

