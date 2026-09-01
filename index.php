<?php
$pageTitle = "Velyora — Everything You Love. One Place.";

// 1. Include the database connection
require_once 'config/db.php';

// 2. Write the SQL Query
// We use a JOIN to get the category name from the categories table
$query = "
    SELECT products.*, categories.name AS category_name 
    FROM products 
    JOIN categories ON products.category_id = categories.id 
    WHERE products.is_featured = 1 
    AND products.status = 'active'
    ORDER BY products.id DESC
    LIMIT 4
";

// 3. Execute the query and fetch the data
$stmt = $pdo->query($query);
$featuredProducts = $stmt->fetchAll();
?>

<?php include 'includes/header.php'; ?>
<!-- =========================================================
     HERO
========================================================= -->
<main>
    <section class="hero-section">
        <div class="container">
            <div class="hero-grid">
                <!-- Hero Content -->
                <div class="hero-content">
                    <span class="hero-badge">
                        <i class="bi bi-stars"></i>
                        CURATED FOR YOU
                    </span>
                    <h1>
                        Everything You Love.
                        <span>One Place.</span>
                    </h1>
                    <p>
                        Discover thoughtfully selected products across
                        electronics, fashion, lifestyle and more —
                        all brought together in one seamless shopping
                        experience.
                    </p>
                    <div class="hero-buttons">
                        <a
                            href="products.php"
                            class="btn btn-primary-custom">
                            Shop Now
                            <i class="bi bi-arrow-right"></i>
                        </a>
                        <a
                            href="#categories"
                            class="btn btn-outline-custom">
                            Explore Categories
                        </a>
                    </div>
                    <!-- Hero Mini Benefits -->
                    <div class="hero-benefits">
                        <div>
                            <i class="bi bi-shield-check"></i>
                            <span>Secure Payment</span>
                        </div>
                        <div>
                            <i class="bi bi-truck"></i>
                            <span>Fast Delivery</span>
                        </div>
                        <div>
                            <i class="bi bi-arrow-repeat"></i>
                            <span>Easy Returns</span>
                        </div>
                    </div>
                </div>
                <!-- Hero Product -->
                <div class="hero-product">
                    <div class="hero-product-glow"></div>
                    <div class="hero-product-card">
                        <span class="product-label">
                            TRENDING NOW
                        </span>
                        <img
                            src="assets/images/products/hero-product.png"
                            alt="Featured Velyora product">
                        <div class="hero-product-info">
                            <span>
                                Velyora Featured
                            </span>
                            <h3>
                                Premium Everyday Essentials
                            </h3>
                            <strong>
                                Rs. 4,999
                            </strong>
                        </div>
                    </div>
                    <!-- Floating Cards -->
                    <div class="floating-product floating-product-one">
                        <i class="bi bi-lightning-charge-fill"></i>
                        <div>
                            <small>Popular</small>
                            <strong>Best Seller</strong>
                        </div>
                    </div>
                    <div class="floating-product floating-product-two">
                        <i class="bi bi-star-fill"></i>
                        <div>
                            <small>Rated</small>
                            <strong>4.9 / 5</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =========================================================
     TRUST FEATURES
========================================================= -->
    <section class="trust-section">
        <div class="container">
            <div class="trust-grid">
                <div class="trust-item">
                    <div class="trust-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <h4>Secure Shopping</h4>
                        <p>Your information stays protected.</p>
                    </div>
                </div>
                <div class="trust-item">
                    <div class="trust-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div>
                        <h4>Fast Delivery</h4>
                        <p>Reliable delivery across Pakistan.</p>
                    </div>
                </div>
                <div class="trust-item">
                    <div class="trust-icon">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>
                    <div>
                        <h4>Easy Returns</h4>
                        <p>Simple and hassle-free returns.</p>
                    </div>
                </div>
                <div class="trust-item">
                    <div class="trust-icon">
                        <i class="bi bi-award"></i>
                    </div>
                    <div>
                        <h4>Quality Products</h4>
                        <p>Products selected with care.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- =========================================================
     CATEGORIES
========================================================= -->
    <section
        class="categories-section section-padding"
        id="categories">
        <div class="container">
            <div class="section-heading">
                <div>
                    <span class="section-eyebrow">
                        SHOP BY CATEGORY
                    </span>
                    <h2>
                        Find What Fits Your World
                    </h2>
                    <p>
                        Explore products across the categories
                        you shop most.
                    </p>
                </div>
                <a
                    href="products.php"
                    class="view-all-link">
                    View All
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="category-grid">
                <a href="products.php?category=electronics" class="category-card category-electronics">
                    <div class="category-content">
                        <span>01</span>
                        <h3>Electronics</h3>
                        <p>Smart devices & technology</p>
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>
                <a href="products.php?category=fashion" class="category-card category-fashion">
                    <div class="category-content">
                        <span>02</span>
                        <h3>Fashion</h3>
                        <p>Style for every occasion</p>
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>
                <a href="products.php?category=beauty" class="category-card category-beauty">
                    <div class="category-content">
                        <span>03</span>
                        <h3>Beauty</h3>
                        <p>Care & personal essentials</p>
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>
                <a href="products.php?category=home" class="category-card category-home">
                    <div class="category-content">
                        <span>04</span>
                        <h3>Home & Living</h3>
                        <p>Make your space yours</p>
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>
                <a href="products.php?category=accessories" class="category-card category-accessories">
                    <div class="category-content">
                        <span>05</span>
                        <h3>Accessories</h3>
                        <p>Complete your everyday look</p>
                        <i class="bi bi-arrow-up-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </section>
<!-- =========================================================
FEATURED PRODUCTS
========================================================= -->
<section class="products-section section-padding">
<div class="container">
   <div class="section-heading">
       <div>
           <span class="section-eyebrow">
               CURATED SELECTION
           </span>
           <h2>
               Best Sellers
           </h2>
           <p>
               Products our customers are loving right now.
           </p>
       </div>
       <a href="products.php" class="view-all-link">
           View All Products
           <i class="bi bi-arrow-right"></i>
       </a>
   </div>
   
   <div class="product-grid">
       <?php foreach ($featuredProducts as $product): ?>
           <article class="product-card">
               <div class="product-image">
                   
                   <!-- Dynamic Badges -->
                   <?php if (!empty($product['sale_price'])): ?>
                       <?php 
                           $discount = round((($product['price'] - $product['sale_price']) / $product['price']) * 100); 
                       ?>
                       <span class="product-badge product-badge-sale"><?php echo $discount; ?>% OFF</span>
                   <?php elseif ($product['is_featured'] == 1 && empty($product['sale_price'])): ?>
                       <span class="product-badge">BEST SELLER</span>
                   <?php endif; ?>

                   <button class="wishlist-button">
                       <i class="bi bi-heart"></i>
                   </button>
                   
                   <!-- Exactly matching the original static HTML structure -->
                   <img src="assets/images/products/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
               </div>
               
               <div class="product-info">
                   <span class="product-category">
                       <?php echo htmlspecialchars($product['category_name']); ?>
                   </span>
                   
                   <h3>
                       <a href="product.php?id=<?php echo $product['id']; ?>" style="text-decoration: none; color: inherit;">
                           <?php echo htmlspecialchars($product['name']); ?>
                       </a>
                   </h3>
                   
                   <div class="product-rating">
                       <span>★★★★★</span>
                       <small>(124)</small>
                   </div>
                   
                   <div class="product-price">
                       <?php if (!empty($product['sale_price'])): ?>
                           Rs. <?php echo number_format($product['sale_price']); ?>
                           <del>Rs. <?php echo number_format($product['price']); ?></del>
                       <?php else: ?>
                           Rs. <?php echo number_format($product['price']); ?>
                       <?php endif; ?>
                   </div>
                   
                   <button class="add-cart-button">
                       <i class="bi bi-bag-plus"></i> Add to Cart
                   </button>
               </div>
           </article>
       <?php endforeach; ?>
   </div>
</div>
</section>
<!-- =========================================================
     PROMOTIONAL BANNER
========================================================= -->
    <section class="promotion-section">
        <div class="container">
            <div class="promotion-banner">
                <div class="promotion-content">
                    <span class="section-eyebrow">
                        VELYORA EXCLUSIVE
                    </span>
                    <h2>
                        Better Products.
                        Better Prices.
                    </h2>
                    <p>
                        Discover hand-picked products and
                        exclusive deals available for a limited time.
                    </p>
                    <a
                        href="products.php"
                        class="btn btn-white-custom">
                        Explore Deals
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="promotion-decoration">
                    <i class="bi bi-bag-heart"></i>
                </div>
            </div>
        </div>
    </section>
    <!-- =========================================================
     TRENDING PRODUCTS
========================================================= -->
    <section class="products-section section-padding">
        <div class="container">
            <div class="section-heading">
                <div>
                    <span class="section-eyebrow">
                        WHAT'S TRENDING
                    </span>
                    <h2>
                        Trending Right Now
                    </h2>
                </div>
            </div>
            <div class="mini-product-grid">
                <article class="mini-product-card">
                    <img
                        src="assets/images/products/product-5.png"
                        alt="Trending product">
                    <div>
                        <span>Accessories</span>
                        <h3>
                            Everyday Essentials
                        </h3>
                        <strong>
                            Rs. 2,499
                        </strong>
                    </div>
                </article>
                <article class="mini-product-card">
                    <img
                        src="assets/images/products/product-6.png"
                        alt="Trending product">
                    <div>
                        <span>Fashion</span>
                        <h3>
                            Modern Street Style
                        </h3>
                        <strong>
                            Rs. 3,999
                        </strong>
                    </div>
                </article>
                <article class="mini-product-card">
                    <img
                        src="assets/images/products/product-7.png"
                        alt="Trending product">
                    <div>
                        <span>Electronics</span>
                        <h3>
                            Smart Tech Essential
                        </h3>
                        <strong>
                            Rs. 6,499
                        </strong>
                    </div>
                </article>
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