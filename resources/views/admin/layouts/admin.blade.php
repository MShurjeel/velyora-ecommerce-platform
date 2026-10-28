<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Velyora Admin — Dashboard')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/responsive.css') }}">
    @stack('styles')
</head>
<body>

<div class="trendy-layout">
    <!-- =========================================================
         SIDEBAR
    ========================================================= -->
    <aside class="trendy-sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="bi bi-lightning-charge-fill logo-icon"></i>
                <span>Velyora</span> Admin
            </div>
            <button class="mobile-close-btn d-none" id="mobileCloseBtn"><i class="bi bi-x-lg"></i></button>
        </div>
        
        <div class="sidebar-scroll">
            <!-- GROUP 1: OVERVIEW -->
            <div class="sidebar-section">
                <span class="section-title">OVERVIEW</span>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
                <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
                    <i class="bi bi-shop"></i> View Storefront
                </a>
            </div>

            <!-- GROUP 2: CATALOG & INVENTORY -->
            <div class="sidebar-section">
                <span class="section-title">CATALOG & INVENTORY</span>
                <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i> Products
                </a>
                <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i> Categories
                </a>
            </div>

            <!-- GROUP 3: SALES & MARKETING -->
            <div class="sidebar-section">
                <span class="section-title">SALES & ORDERS</span>
                <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="bi bi-cart3"></i> Orders
                </a>
            </div>
        </div>

        <div class="sidebar-footer">
            <img src="{{ asset('assets/images/users/default-avatar.png') }}" alt="Admin" class="user-avatar">
            <div class="user-info">
                <strong>{{ auth()->check() ? auth()->user()->name : 'M. Shurjeel' }}</strong>
                <span>Lead Administrator</span>
            </div>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0; display: inline;">
                @csrf
                <button type="submit" style="background:none; border:none; color:inherit; cursor:pointer;" title="Sign Out">
                    <i class="bi bi-box-arrow-right logout-icon"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- =========================================================
         MAIN CONTENT AREA
    ========================================================= -->
    <main class="trendy-main">
        <!-- HEADER -->
        <header class="trendy-header">
            <div class="header-left">
                <button class="icon-btn-flat d-mobile" id="mobileMenuBtn"><i class="bi bi-list"></i></button>
                <button class="icon-btn-flat d-desktop"><i class="bi bi-list"></i></button>
                <div class="search-bar-pill">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Search orders, customers, products...">
                    <span class="shortcut">⌘K</span>
                </div>
            </div>
            
            <div class="header-right">
                <a href="{{ route('admin.products.create') }}" class="btn-create-pill" style="text-decoration: none;">
                    <i class="bi bi-plus-lg"></i> <span>Add Product</span>
                </a>
                <button class="icon-btn-flat"><i class="bi bi-moon"></i></button>
                <button class="icon-btn-flat badge-btn">
                    <i class="bi bi-bell"></i>
                    <span class="badge-dot">2</span>
                </button>
                <div class="header-profile">
                    <img src="{{ asset('assets/images/users/default-avatar.png') }}" alt="Admin">
                    <span>{{ auth()->check() ? auth()->user()->name : 'Admin' }} <i class="bi bi-chevron-down"></i></span>
                </div>
            </div>
        </header>

        <!-- ALERTS -->
        <div style="padding: 10px 24px 0 24px;">
            @if(session('success'))
                <div style="background: #DCFCE7; color: #16A34A; border: 1px solid #BBF7D0; padding: 12px 18px; border-radius: 8px; font-size: 14px; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: #FEE2E2; color: #DC2626; border: 1px solid #FECACA; padding: 12px 18px; border-radius: 8px; font-size: 14px; margin-bottom: 12px; display: flex; align-items: center; gap: 8px;">
                    <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                </div>
            @endif
        </div>

        <!-- SCROLLABLE PAGE CONTENT -->
        <div class="trendy-content">
            @yield('content')
        </div>
    </main>
</div>

@stack('scripts')
</body>
</html>

