<?php
require_once '../../config/db.php';

$pageTitle = "Velyora Admin — Products";
$successMsg = '';
$errorMsg = '';

// Handle Delete Product
if (isset($_GET['delete'])) {
    $prodId = (int) $_GET['delete'];
    
    try {
        // First, fetch the image filename so we can delete the physical file
        $imgCheck = $pdo->prepare("SELECT image FROM products WHERE id = ?");
        $imgCheck->execute([$prodId]);
        $product = $imgCheck->fetch();

        if ($product) {
            // Delete the file from the server if it's not the default image
            $imagePath = '../../uploads/products/' . $product['image'];
            if ($product['image'] !== 'default.jpg' && file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Delete the product from the database
            $delStmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
            $delStmt->execute([$prodId]);
            $successMsg = "Product deleted successfully!";
        }
    } catch (PDOException $e) {
        $errorMsg = "Database error: " . $e->getMessage();
    }
}

// Fetch all products with their category names
$stmt = $pdo->query("
    SELECT products.*, categories.name AS category_name 
    FROM products 
    LEFT JOIN categories ON products.category_id = categories.id 
    ORDER BY products.id DESC
");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
</head>
<body>

<div class="trendy-layout">
    <?php include '../includes/sidebar.php'; ?>

    <main class="trendy-main">
        <?php include '../includes/header.php'; ?>

        <div class="trendy-content">
            
            <!-- Page Header -->
            <div class="card-header" style="padding: 0 0 20px 0; margin-bottom: 20px; border-bottom: 1px solid var(--color-border); display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2>Manage Products</h2>
                    <p>View, edit, and manage your entire product catalog.</p>
                </div>
                <a href="create.php" class="btn-create-pill" style="text-decoration: none;">
                    <i class="bi bi-plus-lg"></i> Add New Product
                </a>
            </div>

            <!-- Alerts -->
            <?php if (!empty($successMsg)): ?>
                <div style="background: var(--color-success-soft); color: var(--color-success); padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px; font-weight: 600;">
                    <i class="bi bi-check-circle"></i> <?= htmlspecialchars($successMsg) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($errorMsg)): ?>
                <div style="background: var(--color-danger-soft); color: var(--color-danger); padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px; font-weight: 600;">
                    <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($errorMsg) ?>
                </div>
            <?php endif; ?>

            <!-- Products Table Card -->
            <div class="card table-card">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th style="text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($products)): ?>
                                <?php foreach ($products as $p): ?>
                                    <tr>
                                        <td>
                                            <div class="user-cell">
                                                <img src="../../uploads/products/<?= htmlspecialchars($p['image']) ?>" alt="Product" style="border-radius: 8px; background: var(--color-bg-main);">
                                                <div>
                                                    <strong style="color: var(--color-text-main);"><?= htmlspecialchars($p['name']) ?></strong>
                                                    <?php if ($p['is_featured'] == 1): ?>
                                                        <span style="display: inline-block; background: var(--color-primary-soft); color: var(--color-primary); font-size: 9px; padding: 2px 6px; border-radius: 4px; font-weight: 700; margin-top: 4px;">FEATURED</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="color: var(--color-text-muted); font-size: 13px;">
                                            <?= htmlspecialchars($p['category_name'] ?? 'Uncategorized') ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($p['sale_price'])): ?>
                                                <div style="display: flex; flex-direction: column;">
                                                    <strong style="color: var(--color-primary);">Rs. <?= number_format($p['sale_price']) ?></strong>
                                                    <del style="color: var(--color-text-muted); font-size: 11px;">Rs. <?= number_format($p['price']) ?></del>
                                                </div>
                                            <?php else: ?>
                                                <strong style="color: var(--color-text-main);">Rs. <?= number_format($p['price']) ?></strong>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($p['stock_qty'] <= 5 && $p['stock_qty'] > 0): ?>
                                                <strong style="color: var(--color-warning);"><?= $p['stock_qty'] ?> left</strong>
                                            <?php elseif ($p['stock_qty'] == 0): ?>
                                                <strong style="color: var(--color-danger);">Out of stock</strong>
                                            <?php else: ?>
                                                <strong style="color: var(--color-success);"><?= $p['stock_qty'] ?></strong>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($p['status'] === 'active'): ?>
                                                <span class="status-badge success">Active</span>
                                            <?php elseif ($p['status'] === 'draft'): ?>
                                                <span class="status-badge warning">Draft</span>
                                            <?php else: ?>
                                                <span class="status-badge danger">Out of Stock</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align: right;">
                                            <a href="edit.php?id=<?= $p['id'] ?>" class="icon-btn-flat" style="display: inline-flex; text-decoration: none;" title="Edit"><i class="bi bi-pencil" style="font-size: 14px;"></i></a>
                                            <a href="index.php?delete=<?= $p['id'] ?>" class="icon-btn-flat" style="display: inline-flex; text-decoration: none; color: var(--color-danger);" onclick="return confirm('Are you sure you want to delete this product?');" title="Delete"><i class="bi bi-trash" style="font-size: 14px;"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 40px; color: var(--color-text-muted);">
                                        <i class="bi bi-box-seam" style="font-size: 32px; display: block; margin-bottom: 10px; color: var(--color-border);"></i>
                                        No products found. Click "Add New Product" to get started.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</div>

<script>
    document.querySelectorAll('.has-dropdown').forEach(item => {
        item.addEventListener('click', event => {
            event.preventDefault();
            item.classList.toggle('open');
        });
    });
</script>

</body>
</html>