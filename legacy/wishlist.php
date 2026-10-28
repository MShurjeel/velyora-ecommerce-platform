<?php
require_once __DIR__ . '/config/db.php';

// If accessed standalone, redirect smoothly to profile wishlist tab
if (basename($_SERVER['PHP_SELF']) === 'wishlist.php') {
    header('Location: my-profile.php#v-pills-wishlist');
    exit;
}

$wishlistItems = getWishlistItems();
?>

<main class="account-content">
    <!-- Content Header -->
    <div class="content-header">
        <h3>My Wishlist (<span class="wishlist-total-count"><?php echo count($wishlistItems); ?></span>)</h3>
        <div class="header-actions">
            <?php if (!empty($wishlistItems)): ?>
                <button type="button" class="btn-secondary btn-add-all-wishlist">
                    <i class="bi bi-cart-plus"></i> Add All to Cart
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Wishlist Grid -->
    <div class="wishlist-grid">
        <?php if (empty($wishlistItems)): ?>
            <div class="empty-wishlist-state text-center py-5" style="grid-column: 1 / -1; padding: 50px 20px;">
                <div style="font-size: 54px; color: var(--color-border); margin-bottom: 15px;">
                    <i class="bi bi-heart"></i>
                </div>
                <h4 style="font-weight: 700; color: var(--color-heading); margin-bottom: 10px;">Your wishlist is empty</h4>
                <p style="color: var(--color-text-light); max-width: 420px; margin: 0 auto 24px;">
                    Explore our collection and add your favorite items to your wishlist for easy access anytime.
                </p>
                <a href="products.php" class="btn btn-primary" style="padding: 10px 26px; border-radius: 999px; text-decoration: none; font-weight: 600;">
                    Explore Products
                </a>
            </div>
        <?php else: ?>
            <?php foreach ($wishlistItems as $wItem): ?>
                <div class="wishlist-card" data-product-id="<?php echo $wItem['product_id']; ?>" data-wishlist-id="<?php echo $wItem['wishlist_id']; ?>">
                    <button type="button" class="btn-remove-wishlist" data-product-id="<?php echo $wItem['product_id']; ?>" title="Remove from wishlist">
                        <i class="bi bi-trash"></i>
                    </button>
                    <div class="wishlist-img-wrapper">
                        <a href="product.php?id=<?php echo $wItem['product_id']; ?>">
                            <img src="<?php echo htmlspecialchars($wItem['image']); ?>" alt="<?php echo htmlspecialchars($wItem['name']); ?>">
                        </a>
                    </div>
                    <div class="wishlist-details">
                        <span class="wishlist-category"><?php echo htmlspecialchars($wItem['category_name']); ?></span>
                        <h4 class="wishlist-title">
                            <a href="product.php?id=<?php echo $wItem['product_id']; ?>" style="text-decoration:none; color:inherit;">
                                <?php echo htmlspecialchars($wItem['name']); ?>
                            </a>
                        </h4>
                        <div class="wishlist-price">
                            <strong>Rs. <?php echo number_format($wItem['price']); ?></strong>
                            <?php if ($wItem['in_stock']): ?>
                                <span class="stock-status in-stock">In Stock</span>
                            <?php else: ?>
                                <span class="stock-status out-of-stock">Out of Stock</span>
                            <?php endif; ?>
                        </div>
                        <?php if ($wItem['in_stock']): ?>
                            <button type="button" class="btn-primary add-to-cart-btn" data-product-id="<?php echo $wItem['product_id']; ?>">
                                <i class="bi bi-bag-plus"></i> Add to Cart
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn-secondary add-to-cart-btn" disabled>
                                Out of Stock
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>