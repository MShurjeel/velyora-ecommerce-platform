<?php
$pageTitle = "Product Details — Velyora";

/*
|--------------------------------------------------------------------------
| VELYORA PRODUCT DETAIL
|--------------------------------------------------------------------------
| Temporary presentation data.
|
| This follows the same temporary product-data approach currently used
| by products.php. It can later be replaced by a database query without
| changing the page structure.
|--------------------------------------------------------------------------
*/

$productId = isset($_GET['id']) ? (int) $_GET['id'] : 1;

/*
|--------------------------------------------------------------------------
| PRODUCT DATA
|--------------------------------------------------------------------------
*/
$products = [
    1 => [
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
        'image' => 'assets/images/products/product-1.png',
        'short_description' => 'Experience rich, immersive sound with a premium wireless design built for everyday listening, work and travel.',
        'stock' => 18,
        'sku' => 'VEL-ELEC-001',
        'brand' => 'Velyora',
        'colors' => [
            [
                'name' => 'Midnight',
                'value' => '#0A1020'
            ],
            [
                'name' => 'Cloud',
                'value' => '#F1F5F9'
            ],
            [
                'name' => 'Royal Blue',
                'value' => '#1E3A8A'
            ],
            [
                'name' => 'Forest',
                'value' => '#276749'
            ]
        ],
        'features' => [
            [
                'icon' => 'bi-soundwave',
                'title' => 'Immersive Sound',
                'text' => 'Balanced audio with detailed highs and rich bass.'
            ],
            [
                'icon' => 'bi-battery-charging',
                'title' => 'Long Battery',
                'text' => 'Designed for extended listening throughout the day.'
            ],
            [
                'icon' => 'bi-bluetooth',
                'title' => 'Seamless Pairing',
                'text' => 'Quick and reliable wireless connectivity.'
            ],
            [
                'icon' => 'bi-headphones',
                'title' => 'Comfort First',
                'text' => 'Soft cushioning designed for longer sessions.'
            ]
        ],
        'included' => [
            'Premium Wireless Headphones',
            'Protective Carrying Case',
            'USB-C Charging Cable',
            '3.5mm Audio Cable',
            'Quick Start Guide',
            'Warranty Documentation'
        ],
        'specifications' => [
            'Audio' => [
                'Driver Size' => '40mm Dynamic',
                'Frequency Range' => '20Hz – 20kHz',
                'Connectivity' => 'Bluetooth 5.3',
                'Audio Format' => 'High Resolution Audio',
                'Noise Control' => 'Active Noise Cancellation'
            ],
            'Battery & Power' => [
                'Battery Type' => 'Lithium-Ion',
                'Battery Life' => 'Up to 35 hours',
                'Charging' => 'USB-C',
                'Fast Charge' => '10 minutes = up to 4 hours',
                'Charge Time' => 'Approximately 2 hours'
            ],
            'Design' => [
                'Weight' => '285g',
                'Material' => 'Premium Composite',
                'Cushion Material' => 'Memory Foam',
                'Foldable' => 'Yes',
                'Water Resistance' => 'IPX4'
            ],
            'Smart Features' => [
                'Microphone' => 'Dual Array',
                'Voice Assistant' => 'Supported',
                'Touch Controls' => 'Yes',
                'Multipoint' => 'Supported',
                'App Support' => 'Velyora Audio'
            ]
        ],
        'reviews_data' => [
            [
                'name' => 'Ayesha Khan',
                'rating' => 5,
                'date' => 'August 10, 2026',
                'title' => 'Excellent sound and comfort',
                'text' => 'The sound quality is excellent and the headphones stay comfortable even after several hours of use.'
            ],
            [
                'name' => 'Hassan Ali',
                'rating' => 5,
                'date' => 'July 28, 2026',
                'title' => 'Great everyday headphones',
                'text' => 'Battery life is impressive and pairing was very easy. The overall build feels much more premium than expected.'
            ],
            [
                'name' => 'Sara Ahmed',
                'rating' => 4,
                'date' => 'July 14, 2026',
                'title' => 'Very good value',
                'text' => 'Comfortable, stylish and reliable. The noise cancellation is especially useful when travelling.'
            ]
        ]
    ]
];

/*
|--------------------------------------------------------------------------
| FALLBACK
|--------------------------------------------------------------------------
*/
if (!isset($products[$productId])) {
    header('Location: products.php');
    exit;
}

$product = $products[$productId];

/*
|--------------------------------------------------------------------------
| RELATED PRODUCTS
|--------------------------------------------------------------------------
| These currently match the products used by products.php.
|--------------------------------------------------------------------------
*/
$relatedProducts = [
    [
        'id' => 2,
        'name' => 'Premium Everyday Hoodie',
        'category' => 'Fashion',
        'price' => 3499,
        'old_price' => 4399,
        'rating' => 4.8,
        'reviews' => 89,
        'badge' => '20% OFF',
        'image' => 'assets/images/products/product-2.png'
    ],
    [
        'id' => 3,
        'name' => 'Urban Everyday Backpack',
        'category' => 'Accessories',
        'price' => 5999,
        'old_price' => null,
        'rating' => 4.7,
        'reviews' => 61,
        'badge' => 'NEW',
        'image' => 'assets/images/products/product-3.png'
    ],
    [
        'id' => 4,
        'name' => 'Modern Lifestyle Essential',
        'category' => 'Home & Living',
        'price' => 2799,
        'old_price' => null,
        'rating' => 4.6,
        'reviews' => 47,
        'badge' => 'TRENDING',
        'image' => 'assets/images/products/product-4.png'
    ],
    [
        'id' => 7,
        'name' => 'Smart Tech Essential',
        'category' => 'Electronics',
        'price' => 6499,
        'old_price' => null,
        'rating' => 4.9,
        'reviews' => 73,
        'badge' => 'POPULAR',
        'image' => 'assets/images/products/product-7.png'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/product.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>

<?php include 'includes/header.php'; ?>

<main>

<!-- =========================================================
     PRODUCT BREADCRUMB
========================================================= -->
<section class="product-breadcrumb-section">
    <div class="container">
        <nav class="product-breadcrumb">
            <a href="index.php">Home</a>
            <i class="bi bi-chevron-right"></i>
            <a href="products.php">Shop</a>
            <i class="bi bi-chevron-right"></i>
            <a href="products.php?category=<?php echo urlencode($product['category_slug']); ?>">
                <?php echo htmlspecialchars($product['category']); ?>
            </a>
            <i class="bi bi-chevron-right"></i>
            <span><?php echo htmlspecialchars($product['name']); ?></span>
        </nav>
    </div>
</section>

<!-- =========================================================
     PRODUCT HERO
========================================================= -->
<section class="product-detail-section">
    <div class="container">
        <div class="product-detail-layout">

            <!-- =================================================
                 PRODUCT GALLERY
            ================================================== -->
            <div class="product-gallery">
                <div class="product-gallery-thumbnails">
                    <button type="button" class="product-thumbnail active" data-image="assets/images/products/product-1.png">
                        <img src="assets/images/products/product-1.png" alt="Product thumbnail">
                    </button>
                    <button type="button" class="product-thumbnail" data-image="assets/images/products/product-1.png">
                        <img src="assets/images/products/product-1.png" alt="Product thumbnail">
                    </button>
                    <button type="button" class="product-thumbnail" data-image="assets/images/products/product-1.png">
                        <img src="assets/images/products/product-1.png" alt="Product thumbnail">
                    </button>
                    <button type="button" class="product-thumbnail" data-image="assets/images/products/product-1.png">
                        <img src="assets/images/products/product-1.png" alt="Product thumbnail">
                    </button>
                </div>

                <div class="product-main-image">
                    <?php if ($product['badge']): ?>
                        <span class="product-detail-badge">
                            <?php echo htmlspecialchars($product['badge']); ?>
                        </span>
                    <?php endif; ?>
                    <button type="button" class="product-image-wishlist" aria-label="Add to wishlist">
                        <i class="bi bi-heart"></i>
                    </button>
                    <div class="product-image-glow"></div>
                    <img id="productMainImage" src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
            </div>

            <!-- =================================================
                 PRODUCT INFORMATION
            ================================================== -->
            <div class="product-information">
                <span class="product-detail-category">
                    <?php echo htmlspecialchars($product['category']); ?>
                </span>
                <h1>
                    <?php echo htmlspecialchars($product['name']); ?>
                </h1>
                <div class="product-detail-rating">
                    <span class="rating-stars">★★★★★</span>
                    <strong><?php echo $product['rating']; ?></strong>
                    <a href="#reviews">
                        <?php echo $product['reviews']; ?> reviews
                    </a>
                </div>

                <div class="product-detail-price">
                    <strong>
                        Rs. <?php echo number_format($product['price']); ?>
                    </strong>
                    <?php if ($product['old_price']): ?>
                        <del>
                            Rs. <?php echo number_format($product['old_price']); ?>
                        </del>
                        <?php
                        $discount = round((($product['old_price'] - $product['price']) / $product['old_price']) * 100);
                        ?>
                        <span class="product-discount">
                            <?php echo $discount; ?>% OFF
                        </span>
                    <?php endif; ?>
                </div>

                <p class="product-detail-description">
                    <?php echo htmlspecialchars($product['short_description']); ?>
                </p>

                <div class="product-stock-row">
                    <span class="stock-status">
                        <i class="bi bi-check-circle-fill"></i>
                        In Stock
                    </span>
                    <span>
                        <?php echo $product['stock']; ?> units available
                    </span>
                </div>

                <div class="product-divider"></div>

                <!-- COLOR -->
                <div class="product-option">
                    <div class="product-option-heading">
                        <strong>Choose Color</strong>
                        <span id="selectedColor">
                            <?php echo htmlspecialchars($product['colors'][0]['name']); ?>
                        </span>
                    </div>
                    <div class="product-color-options">
                        <?php foreach ($product['colors'] as $index => $color): ?>
                            <button type="button" class="product-color <?php echo $index === 0 ? 'active' : ''; ?>" data-color="<?php echo htmlspecialchars($color['name']); ?>" aria-label="<?php echo htmlspecialchars($color['name']); ?>">
                                <span style="background-color: <?php echo htmlspecialchars($color['value']); ?>;"></span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- QUANTITY + CART -->
                <div class="product-purchase-row">
                    <div class="quantity-control">
                        <button type="button" class="quantity-minus">
                            <i class="bi bi-dash"></i>
                        </button>
                        <input type="number" id="productQuantity" value="1" min="1" max="<?php echo $product['stock']; ?>">
                        <button type="button" class="quantity-plus">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>

                    <button type="button" class="product-add-cart" data-product-id="<?php echo $product['id']; ?>">
                        <i class="bi bi-bag-plus"></i>
                        Add to Cart
                    </button>

                    <button type="button" class="product-detail-wishlist" aria-label="Add to wishlist">
                        <i class="bi bi-heart"></i>
                    </button>
                </div>

                <button type="button" class="product-buy-now">
                    <i class="bi bi-lightning-charge-fill"></i>
                    Buy It Now
                </button>

                <!-- SERVICE PROMISES -->
                <div class="product-service-grid">
                    <div class="product-service-item">
                        <span class="product-service-icon">
                            <i class="bi bi-truck"></i>
                        </span>
                        <div>
                            <strong>Fast Delivery</strong>
                            <small>Delivered safely to your door</small>
                        </div>
                    </div>
                    <div class="product-service-item">
                        <span class="product-service-icon">
                            <i class="bi bi-arrow-repeat"></i>
                        </span>
                        <div>
                            <strong>Easy Returns</strong>
                            <small>Simple return experience</small>
                        </div>
                    </div>
                    <div class="product-service-item">
                        <span class="product-service-icon">
                            <i class="bi bi-shield-check"></i>
                        </span>
                        <div>
                            <strong>Velyora Assured</strong>
                            <small>Quality checked products</small>
                        </div>
                    </div>
                    <div class="product-service-item">
                        <span class="product-service-icon">
                            <i class="bi bi-headset"></i>
                        </span>
                        <div>
                            <strong>Dedicated Support</strong>
                            <small>We're here when you need us</small>
                        </div>
                    </div>
                </div>

                <!-- PRODUCT META -->
                <div class="product-meta">
                    <div>
                        <span>SKU</span>
                        <strong><?php echo htmlspecialchars($product['sku']); ?></strong>
                    </div>
                    <div>
                        <span>Brand</span>
                        <strong><?php echo htmlspecialchars($product['brand']); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================
     PRODUCT CONTENT TABS
========================================================= -->
<section class="product-content-section">
    <div class="container">
        <div class="product-tabs" role="tablist">
            <button type="button" class="product-tab active" data-tab="description">
                Description
            </button>
            <button type="button" class="product-tab" data-tab="specifications">
                Specifications
            </button>
            <button type="button" class="product-tab" data-tab="reviews">
                Reviews (<?php echo $product['reviews']; ?>)
            </button>
        </div>

        <!-- =================================================
             DESCRIPTION
        ================================================== -->
        <div class="product-tab-content active" id="description">
            <div class="product-description-layout">
                <div class="product-description-main">
                    <span class="section-eyebrow">PRODUCT STORY</span>
                    <h2>Designed for everyday listening.</h2>
                    <p>
                        The Premium Wireless Headphones combine
                        immersive audio, dependable wireless
                        connectivity and an understated Velyora
                        aesthetic designed to fit naturally into
                        everyday life.
                    </p>
                    <p>
                        Whether you're working, travelling or
                        simply enjoying your favourite playlist,
                        the balanced sound profile and comfortable
                        construction are designed to keep you
                        listening longer.
                    </p>

                    <div class="product-feature-grid">
                        <?php foreach ($product['features'] as $feature): ?>
                            <article class="product-feature-card">
                                <span>
                                    <i class="bi <?php echo htmlspecialchars($feature['icon']); ?>"></i>
                                </span>
                                <div>
                                    <h3><?php echo htmlspecialchars($feature['title']); ?></h3>
                                    <p><?php echo htmlspecialchars($feature['text']); ?></p>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>

                <aside class="product-included-card">
                    <div class="product-included-heading">
                        <span>
                            <i class="bi bi-box-seam"></i>
                        </span>
                        <h3>What's Included</h3>
                    </div>
                    <ul>
                        <?php foreach ($product['included'] as $item): ?>
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span><?php echo htmlspecialchars($item); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </aside>
            </div>
        </div>

        <!-- =================================================
             SPECIFICATIONS
        ================================================== -->
        <div class="product-tab-content" id="specifications">
            <div class="specification-grid">
                <?php foreach ($product['specifications'] as $group => $specs): ?>
                    <div class="specification-group">
                        <div class="specification-heading">
                            <span></span>
                            <h3><?php echo htmlspecialchars($group); ?></h3>
                        </div>
                        <div class="specification-table">
                            <?php foreach ($specs as $label => $value): ?>
                                <div class="specification-row">
                                    <strong><?php echo htmlspecialchars($label); ?></strong>
                                    <span><?php echo htmlspecialchars($value); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- =================================================
             REVIEWS
        ================================================== -->
        <div class="product-tab-content" id="reviews">
            <div class="reviews-summary">
                <div class="review-score-card">
                    <span class="review-score">
                        <?php echo $product['rating']; ?>
                    </span>
                    <div class="review-stars">★★★★★</div>
                    <p>Based on <?php echo $product['reviews']; ?> reviews</p>
                    <button type="button" class="review-button">Write a Review</button>
                </div>

                <div class="review-bars">
                    <div class="review-bar-row">
                        <span>5</span>
                        <i class="bi bi-star-fill"></i>
                        <div><span style="width: 82%;"></span></div>
                        <small>101</small>
                    </div>
                    <div class="review-bar-row">
                        <span>4</span>
                        <i class="bi bi-star-fill"></i>
                        <div><span style="width: 12%;"></span></div>
                        <small>15</small>
                    </div>
                    <div class="review-bar-row">
                        <span>3</span>
                        <i class="bi bi-star-fill"></i>
                        <div><span style="width: 5%;"></span></div>
                        <small>6</small>
                    </div>
                    <div class="review-bar-row">
                        <span>2</span>
                        <i class="bi bi-star-fill"></i>
                        <div><span style="width: 1%;"></span></div>
                        <small>1</small>
                    </div>
                    <div class="review-bar-row">
                        <span>1</span>
                        <i class="bi bi-star-fill"></i>
                        <div><span style="width: 1%;"></span></div>
                        <small>1</small>
                    </div>
                </div>
            </div>

            <div class="review-list">
                <?php foreach ($product['reviews_data'] as $review): ?>
                    <article class="review-card">
                        <div class="review-avatar">
                            <?php echo strtoupper(substr($review['name'], 0, 1)); ?>
                        </div>
                        <div class="review-body">
                            <div class="review-top">
                                <div>
                                    <strong><?php echo htmlspecialchars($review['name']); ?></strong>
                                    <div class="review-stars">
                                        <?php echo str_repeat('★', $review['rating']); ?>
                                    </div>
                                </div>
                                <time><?php echo htmlspecialchars($review['date']); ?></time>
                            </div>
                            <h3><?php echo htmlspecialchars($review['title']); ?></h3>
                            <p><?php echo htmlspecialchars($review['text']); ?></p>
                            <div class="review-actions">
                                <button type="button">
                                    <i class="bi bi-hand-thumbs-up"></i> Helpful
                                </button>
                                <button type="button">
                                    <i class="bi bi-reply"></i> Reply
                                </button>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <button type="button" class="load-reviews-button">
                Load More Reviews
                <i class="bi bi-arrow-down"></i>
            </button>
        </div>
    </div>
</section>

<!-- =========================================================
     RELATED PRODUCTS
========================================================= -->
<section class="related-products-section">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="section-eyebrow">KEEP EXPLORING</span>
                <h2>You May Also Like</h2>
            </div>
            <a href="products.php" class="section-link">
                View All Products
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="product-grid">
            <?php foreach ($relatedProducts as $related): ?>
                <article class="product-card">
                    <div class="product-image">
                        <?php if ($related['badge']): ?>
                            <span class="product-badge">
                                <?php echo htmlspecialchars($related['badge']); ?>
                            </span>
                        <?php endif; ?>
                        <button type="button" class="wishlist-button" aria-label="Add to wishlist">
                            <i class="bi bi-heart"></i>
                        </button>
                        <a href="product.php?id=<?php echo $related['id']; ?>">
                            <img src="<?php echo htmlspecialchars($related['image']); ?>" alt="<?php echo htmlspecialchars($related['name']); ?>">
                        </a>
                    </div>
                    <div class="product-info">
                        <span class="product-category">
                            <?php echo htmlspecialchars($related['category']); ?>
                        </span>
                        <a href="product.php?id=<?php echo $related['id']; ?>">
                            <h3><?php echo htmlspecialchars($related['name']); ?></h3>
                        </a>
                        <div class="product-rating">
                            <span>★★★★★</span>
                            <small>(<?php echo $related['reviews']; ?>)</small>
                        </div>
                        <div class="product-price">
                            Rs. <?php echo number_format($related['price']); ?>
                            <?php if ($related['old_price']): ?>
                                <del>Rs. <?php echo number_format($related['old_price']); ?></del>
                            <?php endif; ?>
                        </div>
                        <a href="product.php?id=<?php echo $related['id']; ?>" class="add-cart-button related-view-button">
                            View Product
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
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

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>

<script>
/*
|--------------------------------------------------------------------------
| VELYORA PRODUCT DETAIL INTERACTIONS
|--------------------------------------------------------------------------
*/
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | GALLERY
    |--------------------------------------------------------------------------
    */
    const mainImage = document.getElementById('productMainImage');
    const thumbnails = document.querySelectorAll('.product-thumbnail');

    thumbnails.forEach(function (thumbnail) {
        thumbnail.addEventListener('click', function () {
            const image = this.dataset.image;
            if (mainImage && image) {
                mainImage.src = image;
            }
            thumbnails.forEach(function (item) {
                item.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | COLOR SELECTOR
    |--------------------------------------------------------------------------
    */
    const colorButtons = document.querySelectorAll('.product-color');
    const selectedColor = document.getElementById('selectedColor');

    colorButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            colorButtons.forEach(function (item) {
                item.classList.remove('active');
            });
            this.classList.add('active');
            if (selectedColor) {
                selectedColor.textContent = this.dataset.color;
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | QUANTITY
    |--------------------------------------------------------------------------
    */
    const quantityInput = document.getElementById('productQuantity');
    const quantityMinus = document.querySelector('.quantity-minus');
    const quantityPlus = document.querySelector('.quantity-plus');

    if (quantityInput) {
        quantityMinus?.addEventListener('click', function () {
            let value = parseInt(quantityInput.value, 10) || 1;
            if (value > 1) {
                value--;
            }
            quantityInput.value = value;
        });

        quantityPlus?.addEventListener('click', function () {
            let value = parseInt(quantityInput.value, 10) || 1;
            const max = parseInt(quantityInput.max, 10) || 99;
            if (value < max) {
                value++;
            }
            quantityInput.value = value;
        });

        quantityInput.addEventListener('change', function () {
            let value = parseInt(this.value, 10) || 1;
            const max = parseInt(this.max, 10) || 99;
            if (value < 1) {
                value = 1;
            }
            if (value > max) {
                value = max;
            }
            this.value = value;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | TABS
    |--------------------------------------------------------------------------
    */
    const tabs = document.querySelectorAll('.product-tab');
    const tabContents = document.querySelectorAll('.product-tab-content');

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            const target = this.dataset.tab;

            tabs.forEach(function (item) {
                item.classList.remove('active');
            });

            tabContents.forEach(function (content) {
                content.classList.remove('active');
            });

            this.classList.add('active');

            const targetContent = document.getElementById(target);
            if (targetContent) {
                targetContent.classList.add('active');
            }

            if (target === 'reviews') {
                history.replaceState(null, '', '#reviews');
            } else {
                history.replaceState(null, '', window.location.pathname + window.location.search);
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | OPEN REVIEWS FROM RATING
    |--------------------------------------------------------------------------
    */
    document.querySelectorAll('.product-detail-rating a').forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();

            const reviewsTab = document.querySelector('.product-tab[data-tab="reviews"]');
            if (reviewsTab) {
                reviewsTab.click();
            }

            const reviewSection = document.getElementById('reviews');
            if (reviewSection) {
                setTimeout(function () {
                    reviewSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 50);
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | WISHLIST VISUAL STATE
    |--------------------------------------------------------------------------
    */
    document.querySelectorAll('.product-image-wishlist, .product-detail-wishlist, .wishlist-button').forEach(function (button) {
        button.addEventListener('click', function () {
            this.classList.toggle('active');
            const icon = this.querySelector('i');
            if (icon) {
                icon.classList.toggle('bi-heart');
                icon.classList.toggle('bi-heart-fill');
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | HASH — OPEN REVIEWS
    |--------------------------------------------------------------------------
    */
    if (window.location.hash === '#reviews') {
        const reviewsTab = document.querySelector('.product-tab[data-tab="reviews"]');
        if (reviewsTab) {
            reviewsTab.click();
        }
    }
});
</script>

</body>
</html>
```[cite: 5]