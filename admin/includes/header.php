<!-- =========================================================
     HEADER
========================================================= -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="assets/css/responsive.css">

</head>
<body>
<header class="trendy-header">
    <div class="header-left">
        <button class="icon-btn-flat d-mobile" id="mobileMenuBtn"><i class="bi bi-list"></i></button>
        <button class="icon-btn-flat d-desktop"><i class="bi bi-list"></i></button>
        <button class="icon-btn-flat d-desktop"><i class="bi bi-grid-3x3-gap"></i></button>
        <div class="search-bar-pill">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Search orders, customers, products...">
            <span class="shortcut">⌘K</span>
        </div>
    </div>
    
    <div class="header-right">
        <button class="btn-create-pill">
            <i class="bi bi-plus-lg"></i> <span>Create</span>
        </button>
        <button class="icon-btn-flat"><i class="bi bi-moon"></i></button>
        <button class="icon-btn-flat badge-btn">
            <i class="bi bi-bell"></i>
            <span class="badge-dot">2</span>
        </button>
        <div class="header-profile">
            <img src="../assets/images/admin-avatar.jpg" alt="Admin">
            <span>M. Shurjeel <i class="bi bi-chevron-down"></i></span>
        </div>
    </div>
</header>