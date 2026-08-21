<?php
$pageTitle = "Shop All Products — Velyora";

/*
|--------------------------------------------------------------------------
| VELYORA PRODUCT CATALOG
|--------------------------------------------------------------------------
| Temporary presentation data.
|
| IMPORTANT:
| This array is intentionally kept separate from the UI so it can later
| be replaced with the real database query without redesigning the page.
|--------------------------------------------------------------------------
*/

$products = [
    [
        'id' => 1,
        'name' => 'Premium Wireless Headphones',
        'category' => 'Electronics',
        'category_slug' => 'electronics',
        'price' => 8999,
        'old_price' => 11999,
        'rating' => 4.9,
        'reviews' => 124,
        'badge' => 'BEST SELLER',
        'badge_type' => 'primary',
        'image' => 'assets/images/products/product-1.png'
    ],
    [
        'id' => 2,
        'name' => 'Premium Everyday Hoodie',
        'category' => 'Fashion',
        'category_slug' => 'fashion',
        'price' => 3499,
        'old_price' => 4399,
        'rating' => 4.8,
        'reviews' => 89,
        'badge' => '20% OFF',
        'badge_type' => 'sale',
        'image' => 'assets/images/products/product-2.png'
    ],
    [
        'id' => 3,
        'name' => 'Urban Everyday Backpack',
        'category' => 'Accessories',
        'category_slug' => 'accessories',
        'price' => 5999,
        'old_price' => null,
        'rating' => 4.7,
        'reviews' => 61,
        'badge' => 'NEW',
        'badge_type' => 'primary',
        'image' => 'assets/images/products/product-3.png'
    ],
    [
        'id' => 4,
        'name' => 'Modern Lifestyle Essential',
        'category' => 'Home & Living',
        'category_slug' => 'home-living',
        'price' => 2799,
        'old_price' => null,
        'rating' => 4.6,
        'reviews' => 47,
        'badge' => 'TRENDING',
        'badge_type' => 'primary',
        'image' => 'assets/images/products/product-4.png'
    ],
    [
        'id' => 5,
        'name' => 'Everyday Essentials',
        'category' => 'Accessories',
        'category_slug' => 'accessories',
        'price' => 2499,
        'old_price' => null,
        'rating' => 4.7,
        'reviews' => 42,
        'badge' => null,
        'badge_type' => null,
        'image' => 'assets/images/products/product-5.png'
    ],
    [
        'id' => 6,
        'name' => 'Modern Street Style',
        'category' => 'Fashion',
        'category_slug' => 'fashion',
        'price' => 3999,
        'old_price' => null,
        'rating' => 4.8,
        'reviews' => 56,
        'badge' => null,
        'badge_type' => null,
        'image' => 'assets/images/products/product-6.png'
    ],
    [
        'id' => 7,
        'name' => 'Smart Tech Essential',
        'category' => 'Electronics',
        'category_slug' => 'electronics',
        'price' => 6499,
        'old_price' => null,
        'rating' => 4.9,
        'reviews' => 73,
        'badge' => 'POPULAR',
        'badge_type' => 'primary',
        'image' => 'assets/images/products/product-7.png'
    ],
    [
        'id' => 8,
        'name' => 'Contemporary Home Essential',
        'category' => 'Home & Living',
        'category_slug' => 'home-living',
        'price' => 4299,
        'old_price' => 4999,
        'rating' => 4.6,
        'reviews' => 38,
        'badge' => '15% OFF',
        'badge_type' => 'sale',
        'image' => 'assets/images/products/product-4.png'
    ]
];

/*
|--------------------------------------------------------------------------
| BASIC FILTER STATE
|--------------------------------------------------------------------------
*/

$selectedCategory = $_GET['category'] ?? '';
$searchQuery = trim($_GET['search'] ?? '');
$sort = $_GET['sort'] ?? 'featured';

/*
|--------------------------------------------------------------------------
| FILTER PRODUCTS
|--------------------------------------------------------------------------
*/

$filteredProducts = array_filter($products, function ($product) use (
    $selectedCategory,
    $searchQuery
) {

    if ($selectedCategory !== '' &&
        $product['category_slug'] !== $selectedCategory) {
        return false;
    }

    if ($searchQuery !== '') {

        $searchable = strtolower(
            $product['name'] . ' ' .
            $product['category']
        );

        if (strpos($searchable, strtolower($searchQuery)) === false) {
            return false;
        }
    }

    return true;
});

/*
|--------------------------------------------------------------------------
| SORT PRODUCTS
|--------------------------------------------------------------------------
*/

if ($sort === 'price-low') {

    usort($filteredProducts, function ($a, $b) {
        return $a['price'] <=> $b['price'];
    });

} elseif ($sort === 'price-high') {

    usort($filteredProducts, function ($a, $b) {
        return $b['price'] <=> $a['price'];
    });

} elseif ($sort === 'rating') {

    usort($filteredProducts, function ($a, $b) {
        return $b['rating'] <=> $a['rating'];
    });
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo htmlspecialchars($pageTitle); ?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/products.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>

<body>
<?php include 'includes/header.php'; ?>

<!-- =========================================================
     CATALOG HERO
========================================================= -->
<main>
<section class="catalog-hero">

    <div class="container">

        <div class="catalog-hero-inner">

            <div>

                <span class="catalog-eyebrow">
                    VELYORA COLLECTION
                </span>

                <h1>
                    Find Something
                    <span>Worth Bringing Home.</span>
                </h1>

                <p>
                    Explore thoughtfully selected products across
                    electronics, fashion, lifestyle and more.
                </p>

            </div>


            <nav class="catalog-breadcrumb">

                <a href="index.php">
                    Home
                </a>

                <i class="bi bi-chevron-right"></i>

                <span>
                    Shop
                </span>

            </nav>

        </div>

    </div>

</section>


<!-- =========================================================
     CATEGORY QUICK LINKS
========================================================= -->

<section class="catalog-categories">

    <div class="container">

        <div class="catalog-category-list">

            <a
                href="products.php"
                class="catalog-category <?php echo $selectedCategory === '' ? 'active' : ''; ?>">

                <span class="catalog-category-icon">
                    <i class="bi bi-grid"></i>
                </span>

                <span>
                    All Products
                </span>

            </a>


            <a
                href="products.php?category=electronics"
                class="catalog-category">

                <span class="catalog-category-icon">
                    <i class="bi bi-cpu"></i>
                </span>

                <span>
                    Electronics
                </span>

            </a>


            <a
                href="products.php?category=fashion"
                class="catalog-category">

                <span class="catalog-category-icon">
                    <i class="bi bi-bag"></i>
                </span>

                <span>
                    Fashion
                </span>

            </a>


            <a
                href="products.php?category=beauty"
                class="catalog-category">

                <span class="catalog-category-icon">
                    <i class="bi bi-stars"></i>
                </span>

                <span>
                    Beauty
                </span>

            </a>


            <a
                href="products.php?category=home-living"
                class="catalog-category">

                <span class="catalog-category-icon">
                    <i class="bi bi-house"></i>
                </span>

                <span>
                    Home & Living
                </span>

            </a>


            <a
                href="products.php?category=accessories"
                class="catalog-category">

                <span class="catalog-category-icon">
                    <i class="bi bi-watch"></i>
                </span>

                <span>
                    Accessories
                </span>

            </a>

        </div>

    </div>

</section>


<!-- =========================================================
     PRODUCT CATALOG
========================================================= -->

<section class="catalog-section">

    <div class="container">

        <div class="catalog-layout">


            <!-- =================================================
                 FILTER SIDEBAR
            ================================================== -->

            <aside class="catalog-sidebar">

                <div class="filter-panel">

                    <div class="filter-panel-header">

                        <div>

                            <span class="filter-eyebrow">
                                REFINE
                            </span>

                            <h2>
                                Filters
                            </h2>

                        </div>

                        <a href="products.php">
                            Clear All
                        </a>

                    </div>


                    <!-- Categories -->

                    <div class="filter-group">

                        <div class="filter-group-title">
                            <span>Categories</span>
                            <i class="bi bi-chevron-up"></i>
                        </div>


                        <label class="filter-option">
                            <input type="radio" name="category">
                            <span>All Products</span>
                            <small><?php echo count($products); ?></small>
                        </label>


                        <label class="filter-option">
                            <input type="radio" name="category">
                            <span>Electronics</span>
                            <small>2</small>
                        </label>


                        <label class="filter-option">
                            <input type="radio" name="category">
                            <span>Fashion</span>
                            <small>2</small>
                        </label>


                        <label class="filter-option">
                            <input type="radio" name="category">
                            <span>Beauty</span>
                            <small>0</small>
                        </label>


                        <label class="filter-option">
                            <input type="radio" name="category">
                            <span>Home & Living</span>
                            <small>2</small>
                        </label>


                        <label class="filter-option">
                            <input type="radio" name="category">
                            <span>Accessories</span>
                            <small>2</small>
                        </label>

                    </div>


                    <!-- Price -->

                    <div class="filter-group">

                        <div class="filter-group-title">
                            <span>Price Range</span>
                            <i class="bi bi-chevron-up"></i>
                        </div>

                        <div class="price-range-labels">

                            <span>Rs. 0</span>

                            <span>Rs. 25,000+</span>

                        </div>

                        <input
                            type="range"
                            min="0"
                            max="25000"
                            value="25000"
                            class="price-range">

                        <div class="price-inputs">

                            <div>
                                <span>Rs.</span>
                                <input
                                    type="text"
                                    value="0">
                            </div>

                            <div>
                                <span>Rs.</span>
                                <input
                                    type="text"
                                    value="25000">
                            </div>

                        </div>

                    </div>


                    <!-- Brands -->

                    <div class="filter-group">

                        <div class="filter-group-title">
                            <span>Brands</span>
                            <i class="bi bi-chevron-up"></i>
                        </div>

                        <div class="filter-search">

                            <input
                                type="text"
                                placeholder="Search brands...">

                            <i class="bi bi-search"></i>

                        </div>


                        <label class="filter-option">
                            <input type="checkbox">
                            <span>Velyora Select</span>
                            <small>18</small>
                        </label>

                        <label class="filter-option">
                            <input type="checkbox">
                            <span>Urban Core</span>
                            <small>14</small>
                        </label>

                        <label class="filter-option">
                            <input type="checkbox">
                            <span>Nova</span>
                            <small>11</small>
                        </label>

                        <label class="filter-option">
                            <input type="checkbox">
                            <span>Everyday</span>
                            <small>9</small>
                        </label>

                    </div>


                    <!-- Rating -->

                    <div class="filter-group">

                        <div class="filter-group-title">
                            <span>Customer Rating</span>
                            <i class="bi bi-chevron-up"></i>
                        </div>


                        <label class="rating-filter">

                            <input type="checkbox">

                            <span class="rating-stars">
                                ★★★★★
                            </span>

                            <span>& up</span>

                        </label>


                        <label class="rating-filter">

                            <input type="checkbox">

                            <span class="rating-stars">
                                ★★★★
                            </span>

                            <span>& up</span>

                        </label>


                        <label class="rating-filter">

                            <input type="checkbox">

                            <span class="rating-stars">
                                ★★★
                            </span>

                            <span>& up</span>

                        </label>

                    </div>


                    <!-- Availability -->

                    <div class="filter-group filter-group-last">

                        <div class="filter-group-title">
                            <span>Availability</span>
                            <i class="bi bi-chevron-up"></i>
                        </div>

                        <label class="filter-option">

                            <input
                                type="checkbox"
                                checked>

                            <span>In Stock</span>

                        </label>

                        <label class="filter-option">

                            <input type="checkbox">

                            <span>On Sale</span>

                        </label>

                    </div>

                </div>

            </aside>


            <!-- =================================================
                 PRODUCT AREA
            ================================================== -->

            <div class="catalog-content">


                <!-- Catalog toolbar -->

                <div class="catalog-toolbar">

                    <div class="catalog-toolbar-top">

                        <div>

                            <span class="catalog-results-label">
                                Showing
                            </span>

                            <strong>
                                <?php echo count($filteredProducts); ?>
                            </strong>

                            <span class="catalog-results-label">
                                products
                            </span>

                        </div>


                        <button
                            class="mobile-filter-button"
                            type="button">

                            <i class="bi bi-sliders"></i>

                            Filters

                        </button>


                        <div class="catalog-sort">

                            <label for="sort">
                                Sort by
                            </label>

                            <select
                                id="sort"
                                onchange="window.location.href=this.value;">

                                <option
                                    value="products.php">
                                    Featured
                                </option>

                                <option
                                    value="products.php?sort=price-low">
                                    Price: Low to High
                                </option>

                                <option
                                    value="products.php?sort=price-high">
                                    Price: High to Low
                                </option>

                                <option
                                    value="products.php?sort=rating">
                                    Top Rated
                                </option>

                            </select>

                        </div>

                    </div>


                    <!-- Active filters -->

                    <div class="active-filters">

                        <span class="active-filter-label">
                            Active filters:
                        </span>

                        <?php if ($selectedCategory !== ''): ?>

                            <a
                                href="products.php"
                                class="active-filter">

                                <?php echo htmlspecialchars(
                                    ucwords(str_replace('-', ' ', $selectedCategory))
                                ); ?>

                                <i class="bi bi-x"></i>

                            </a>

                        <?php endif; ?>


                        <?php if ($searchQuery !== ''): ?>

                            <a
                                href="products.php"
                                class="active-filter">

                                Search:
                                <?php echo htmlspecialchars($searchQuery); ?>

                                <i class="bi bi-x"></i>

                            </a>

                        <?php endif; ?>

                    </div>

                </div>


                <!-- Product grid -->

                <?php if (!empty($filteredProducts)): ?>

                    <div class="catalog-product-grid">

                        <?php foreach ($filteredProducts as $product): ?>

                            <article class="catalog-product-card">


                                <div class="catalog-product-image">

                                    <?php if ($product['badge']): ?>

                                        <span
                                            class="catalog-product-badge <?php echo $product['badge_type'] === 'sale' ? 'sale' : ''; ?>">

                                            <?php echo htmlspecialchars($product['badge']); ?>

                                        </span>

                                    <?php endif; ?>


                                    <button
                                        class="catalog-wishlist"
                                        type="button"
                                        aria-label="Add to wishlist">

                                        <i class="bi bi-heart"></i>

                                    </button>


                                    <a
                                        href="product.php?id=<?php echo $product['id']; ?>">

                                        <img
                                            src="<?php echo htmlspecialchars($product['image']); ?>"
                                            alt="<?php echo htmlspecialchars($product['name']); ?>">

                                    </a>

                                </div>


                                <div class="catalog-product-info">

                                    <span class="catalog-product-category">

                                        <?php echo htmlspecialchars($product['category']); ?>

                                    </span>


                                    <a
                                        href="product.php?id=<?php echo $product['id']; ?>">

                                        <h3>

                                            <?php echo htmlspecialchars($product['name']); ?>

                                        </h3>

                                    </a>


                                    <div class="catalog-rating">

                                        <span>
                                            ★★★★★
                                        </span>

                                        <small>
                                            <?php echo $product['rating']; ?>
                                            (<?php echo $product['reviews']; ?>)
                                        </small>

                                    </div>


                                    <div class="catalog-price">

                                        <strong>
                                            Rs. <?php echo number_format($product['price']); ?>
                                        </strong>

                                        <?php if ($product['old_price']): ?>

                                            <del>
                                                Rs. <?php echo number_format($product['old_price']); ?>
                                            </del>

                                        <?php endif; ?>

                                    </div>


                                    <button
                                        class="catalog-add-cart"
                                        type="button"
                                        data-product-id="<?php echo $product['id']; ?>">

                                        <i class="bi bi-bag-plus"></i>

                                        Add to Cart

                                    </button>

                                </div>

                            </article>

                        <?php endforeach; ?>

                    </div>


                <?php else: ?>

                    <div class="catalog-empty">

                        <div class="catalog-empty-icon">

                            <i class="bi bi-search"></i>

                        </div>

                        <h2>
                            No products found
                        </h2>

                        <p>
                            Try changing your search or removing
                            some filters.
                        </p>

                        <a
                            href="products.php"
                            class="btn btn-primary-custom">

                            View All Products

                        </a>

                    </div>

                <?php endif; ?>


                <!-- Pagination -->

                <div class="catalog-pagination">

                    <a
                        href="#"
                        class="pagination-arrow disabled">

                        <i class="bi bi-chevron-left"></i>

                    </a>


                    <a
                        href="#"
                        class="active">

                        1

                    </a>


                    <a href="#">
                        2
                    </a>


                    <a href="#">
                        3
                    </a>


                    <span>
                        ...
                    </span>


                    <a href="#">
                        8
                    </a>


                    <a href="#">
                        9
                    </a>


                    <a href="#">
                        10
                    </a>


                    <a
                        href="#"
                        class="pagination-arrow">

                        <i class="bi bi-chevron-right"></i>

                    </a>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- =========================================================
     NEWSLETTER
========================================================= -->

<section class="newsletter-section">

    <div class="container">

        <div class="newsletter-content">

            <div>

                <span class="section-eyebrow">
                    STAY IN THE LOOP
                </span>

                <h2>
                    Get the latest from Velyora.
                </h2>

                <p>
                    New arrivals, exclusive offers and
                    products worth knowing about.
                </p>

            </div>


            <form class="newsletter-form">

                <input
                    type="email"
                    placeholder="Enter your email address">

                <button type="submit">

                    Subscribe

                    <i class="bi bi-arrow-right"></i>

                </button>

            </form>

        </div>

    </div>

</section>

</main>

<?php include 'includes/footer.php'; ?>