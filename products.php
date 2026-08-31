<?php
$pageTitle = "Shop All Products — Velyora";
require_once 'config/db.php';
$selectedCategory = $_GET['category'] ?? '';
$searchQuery = trim($_GET['search'] ?? '');
$sort = $_GET['sort'] ?? 'featured';
$catStmt = $pdo->query("
    SELECT categories.*, COUNT(products.id) AS product_count 
    FROM categories 
    LEFT JOIN products ON categories.id = products.category_id AND products.status = 'active'
    GROUP BY categories.id
");
$categories = $catStmt->fetchAll();
$totalStmt = $pdo->query("SELECT COUNT(*) FROM products WHERE status = 'active'");
$totalProducts = $totalStmt->fetchColumn();
$sql = "SELECT products.*, categories.name AS category_name, categories.slug AS category_slug 
        FROM products 
        JOIN categories ON products.category_id = categories.id 
        WHERE products.status = 'active'";
$params = [];
if ($selectedCategory !== '') {
    $sql .= " AND categories.slug = :category";
    $params[':category'] = $selectedCategory;
}
if ($searchQuery !== '') {
    $sql .= " AND (products.name LIKE :search OR categories.name LIKE :search)";
    $params[':search'] = '%' . $searchQuery . '%';
}
if ($sort === 'price-low') {
    $sql .= " ORDER BY COALESCE(products.sale_price, products.price) ASC";
} elseif ($sort === 'price-high') {
    $sql .= " ORDER BY COALESCE(products.sale_price, products.price) DESC";
} else {
    $sql .= " ORDER BY products.is_featured DESC, products.created_at DESC";
}
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$filteredProducts = $stmt->fetchAll();
?>
<?php include 'includes/header.php'; ?>
<main>
    <section class="catalog-hero">
        <div class="container">
            <div class="catalog-hero-inner">
                <div>
                    <span class="catalog-eyebrow">VELYORA COLLECTION</span>
                    <h1>Find Something <span>Worth Bringing Home.</span></h1>
                    <p>Explore thoughtfully selected products across electronics, fashion, lifestyle and more.</p>
                </div>
                <nav class="catalog-breadcrumb">
                    <a href="index.php">Home</a>
                    <i class="bi bi-chevron-right"></i>
                    <span>Shop</span>
                </nav>
            </div>
        </div>
    </section>
    <section class="catalog-categories">
        <div class="container">
            <div class="catalog-category-list">
                <a href="products.php" class="catalog-category <?php echo $selectedCategory === '' ? 'active' : ''; ?>">
                    <span class="catalog-category-icon"><i class="bi bi-grid"></i></span>
                    <span>All Products</span>
                </a>
                <?php foreach ($categories as $cat): ?>
                    <a href="products.php?category=<?php echo htmlspecialchars($cat['slug']); ?>" class="catalog-category <?php echo $selectedCategory === $cat['slug'] ? 'active' : ''; ?>">
                        <span class="catalog-category-icon"><i class="bi <?php echo htmlspecialchars($cat['icon']); ?>"></i></span>
                        <span><?php echo htmlspecialchars($cat['name']); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <section class="catalog-section">
        <div class="container">
            <div class="catalog-layout">
                <aside class="catalog-sidebar">
                    <div class="filter-panel">
                        <div class="filter-panel-header">
                            <div>
                                <span class="filter-eyebrow">REFINE</span>
                                <h2>Filters</h2>
                            </div>
                            <a href="products.php">Clear All</a>
                        </div>
                        <div class="filter-group">
                            <div class="filter-group-title">
                                <span>Categories</span>
                                <i class="bi bi-chevron-up"></i>
                            </div>
                            <label class="filter-option">
                                <input type="radio" name="category" <?php echo $selectedCategory === '' ? 'checked' : ''; ?> onclick="window.location.href='products.php'">
                                <span>All Products</span>
                                <small><?php echo $totalProducts; ?></small>
                            </label>
                            <?php foreach ($categories as $cat): ?>
                                <label class="filter-option">
                                    <input type="radio" name="category" <?php echo $selectedCategory === $cat['slug'] ? 'checked' : ''; ?> onclick="window.location.href='products.php?category=<?php echo htmlspecialchars($cat['slug']); ?>'">
                                    <span><?php echo htmlspecialchars($cat['name']); ?></span>
                                    <small><?php echo $cat['product_count']; ?></small>
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <div class="filter-group">
                            <div class="filter-group-title">
                                <span>Price Range</span>
                                <i class="bi bi-chevron-up"></i>
                            </div>
                            <div class="price-range-labels">
                                <span>Rs. 0</span>
                                <span>Rs. 25,000+</span>
                            </div>
                            <input type="range" min="0" max="25000" value="25000" class="price-range">
                            <div class="price-inputs">
                                <div>
                                    <span>Rs.</span>
                                    <input type="text" value="0">
                                </div>
                                <div>
                                    <span>Rs.</span>
                                    <input type="text" value="25000">
                                </div>
                            </div>
                        </div>
                        <div class="filter-group">
                            <div class="filter-group-title">
                                <span>Brands</span>
                                <i class="bi bi-chevron-up"></i>
                            </div>
                            <div class="filter-search">
                                <input type="text" placeholder="Search brands...">
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
                        <div class="filter-group">
                            <div class="filter-group-title">
                                <span>Customer Rating</span>
                                <i class="bi bi-chevron-up"></i>
                            </div>
                            <label class="rating-filter">
                                <input type="checkbox">
                                <span class="rating-stars">★★★★★</span>
                                <span>& up</span>
                            </label>
                            <label class="rating-filter">
                                <input type="checkbox">
                                <span class="rating-stars">★★★★</span>
                                <span>& up</span>
                            </label>
                            <label class="rating-filter">
                                <input type="checkbox">
                                <span class="rating-stars">★★★</span>
                                <span>& up</span>
                            </label>
                        </div>
                        <div class="filter-group filter-group-last">
                            <div class="filter-group-title">
                                <span>Availability</span>
                                <i class="bi bi-chevron-up"></i>
                            </div>
                            <label class="filter-option">
                                <input type="checkbox" checked>
                                <span>In Stock</span>
                            </label>
                            <label class="filter-option">
                                <input type="checkbox">
                                <span>On Sale</span>
                            </label>
                        </div>
                    </div>
                </aside>
                <div class="catalog-content">
                    <div class="catalog-toolbar">
                        <div class="catalog-toolbar-top">
                            <div>
                                <span class="catalog-results-label">Showing</span>
                                <strong><?php echo count($filteredProducts); ?></strong>
                                <span class="catalog-results-label">products</span>
                            </div>
                            <button class="mobile-filter-button" type="button">
                                <i class="bi bi-sliders"></i> Filters
                            </button>
                            <div class="catalog-sort">
                                <label for="sort">Sort by</label>
                                <select id="sort" onchange="window.location.href=this.value;">
                                    <option value="products.php">Featured</option>
                                    <option value="products.php?sort=price-low">Price: Low to High</option>
                                    <option value="products.php?sort=price-high">Price: High to Low</option>
                                    <option value="products.php?sort=rating">Top Rated</option>
                                </select>
                            </div>
                        </div>
                        <div class="active-filters">
                            <span class="active-filter-label">Active filters:</span>
                            <?php if ($selectedCategory !== ''): ?>
                                <a href="products.php" class="active-filter">
                                    <?php echo htmlspecialchars(ucwords(str_replace('-', ' ', $selectedCategory))); ?>
                                    <i class="bi bi-x"></i>
                                </a>
                            <?php endif; ?>
                            <?php if ($searchQuery !== ''): ?>
                                <a href="products.php" class="active-filter">
                                    Search: <?php echo htmlspecialchars($searchQuery); ?>
                                    <i class="bi bi-x"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if (!empty($filteredProducts)): ?>
                        <div class="catalog-product-grid">
                            <?php foreach ($filteredProducts as $product): ?>
                                <article class="catalog-product-card">
                                    <div class="catalog-product-image">
                                        <?php if (!empty($product['sale_price'])): ?>
                                            <?php $discount = round((($product['price'] - $product['sale_price']) / $product['price']) * 100); ?>
                                            <span class="catalog-product-badge sale"><?php echo $discount; ?>% OFF</span>
                                        <?php elseif ($product['is_featured'] == 1): ?>
                                            <span class="catalog-product-badge">BEST SELLER</span>
                                        <?php endif; ?>
                                        <button class="catalog-wishlist" type="button" aria-label="Add to wishlist">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                        <a href="product.php?id=<?php echo $product['id']; ?>" style="display: contents;">
                                            <img src="uploads/products/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                        </a>
                                    </div>
                                    <div class="catalog-product-info">
                                        <span class="catalog-product-category">
                                            <?php echo htmlspecialchars($product['category_name']); ?>
                                        </span>
                                        <h3>
                                            <a href="product.php?id=<?php echo $product['id']; ?>" style="text-decoration: none; color: inherit;">
                                                <?php echo htmlspecialchars($product['name']); ?>
                                            </a>
                                        </h3>
                                        <div class="catalog-rating">
                                            <span>★★★★★</span>
                                            <small>(124)</small>
                                        </div>
                                        <div class="catalog-price">
                                            <?php if (!empty($product['sale_price'])): ?>
                                                <strong>Rs. <?php echo number_format($product['sale_price']); ?></strong>
                                                <del>Rs. <?php echo number_format($product['price']); ?></del>
                                            <?php else: ?>
                                                <strong>Rs. <?php echo number_format($product['price']); ?></strong>
                                            <?php endif; ?>
                                        </div>
                                        <button class="catalog-add-cart" type="button" data-product-id="<?php echo $product['id']; ?>">
                                            <i class="bi bi-bag-plus"></i> Add to Cart
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
                            <h2>No products found</h2>
                            <p>Try changing your search or removing some filters.</p>
                            <a href="products.php" class="btn btn-primary-custom">View All Products</a>
                        </div>
                    <?php endif; ?>
                    <div class="catalog-pagination">
                        <a href="#" class="pagination-arrow disabled"><i class="bi bi-chevron-left"></i></a>
                        <a href="#" class="active">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <span>...</span>
                        <a href="#">8</a>
                        <a href="#">9</a>
                        <a href="#">10</a>
                        <a href="#" class="pagination-arrow"><i class="bi bi-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-content">
                <div>
                    <span class="section-eyebrow">STAY IN THE LOOP</span>
                    <h2>Get the latest from Velyora.</h2>
                    <p>New arrivals, exclusive offers and products worth knowing about.</p>
                </div>
                <form class="newsletter-form">
                    <input type="email" placeholder="Enter your email address">
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