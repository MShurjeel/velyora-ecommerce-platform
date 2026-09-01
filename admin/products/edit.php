<?php
require_once '../../config/db.php';

$pageTitle = "Edit Product — Velyora Admin";
$successMsg = '';
$errorMsg = '';

// 1. Get the product ID from the URL
$prodId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($prodId === 0) {
    header('Location: index.php');
    exit;
}

// 2. Fetch all active categories for the dropdown menu
$catStmt = $pdo->query("SELECT id, name FROM categories WHERE status = 'active' ORDER BY name ASC");
$categories = $catStmt->fetchAll();

// 3. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $name = trim($_POST['name'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);
    $price = (float)($_POST['price'] ?? 0);
    $sale_price = !empty($_POST['sale_price']) ? (float)$_POST['sale_price'] : null;
    $stock_qty = (int)($_POST['stock_qty'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $status = $_POST['status'] ?? 'active';
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    
    // We need the existing image name in case they don't upload a new one
    $existingImage = $_POST['existing_image'];
    $imageName = $existingImage;

    // Basic Validation
    if (empty($name) || $category_id === 0 || $price <= 0) {
        $errorMsg = "Product name, category, and a valid base price are required.";
    } else {
        // Image Upload Handling (Only if a new file is chosen)
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../../uploads/products/';
            
            $fileTmp = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExts = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($fileExt, $allowedExts)) {
                $newFileName = 'product-' . time() . '-' . rand(1000, 9999) . '.' . $fileExt;
                
                if (move_uploaded_file($fileTmp, $uploadDir . $newFileName)) {
                    $imageName = $newFileName;
                    
                    // Delete the old image to save disk space (if it's not the default)
                    if ($existingImage !== 'default.jpg' && file_exists($uploadDir . $existingImage)) {
                        unlink($uploadDir . $existingImage);
                    }
                } else {
                    $errorMsg = "Failed to move uploaded image to the uploads folder.";
                }
            } else {
                $errorMsg = "Invalid image format. Only JPG, PNG, and WEBP are allowed.";
            }
        }

        // Update Database
        if (empty($errorMsg)) {
            try {
                $stmt = $pdo->prepare("UPDATE products SET category_id = ?, name = ?, description = ?, price = ?, sale_price = ?, stock_qty = ?, image = ?, is_featured = ?, status = ? WHERE id = ?");
                $stmt->execute([$category_id, $name, $description, $price, $sale_price, $stock_qty, $imageName, $is_featured, $status, $prodId]);
                $successMsg = "Product updated successfully!";
            } catch (PDOException $e) {
                $errorMsg = "Database error: " . $e->getMessage();
            }
        }
    }
}

// 4. Fetch current product data to pre-fill the form
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$prodId]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: index.php');
    exit;
}
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
            
            <div class="card-header" style="padding: 0 0 20px 0; margin-bottom: 20px; border-bottom: 1px solid var(--color-border); display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2>Edit Product</h2>
                    <p>Updating: <?= htmlspecialchars($product['name']) ?></p>
                </div>
                <a href="index.php" class="btn-hero-white" style="text-decoration: none; border: 1px solid var(--color-border); color: var(--color-text-main);">
                    <i class="bi bi-arrow-left"></i> Back to Products
                </a>
            </div>

            <?php if (!empty($successMsg)): ?>
                <div style="background: var(--color-success-soft); color: var(--color-success); padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px; font-weight: 600;">
                    <i class="bi bi-check-circle"></i> <?= htmlspecialchars($successMsg) ?>
                </div>
                <?php 
                // Refresh data so the form shows the newly updated info (like the new image)
                $stmt->execute([$prodId]);
                $product = $stmt->fetch();
                ?>
            <?php endif; ?>

            <?php if (!empty($errorMsg)): ?>
                <div style="background: var(--color-danger-soft); color: var(--color-danger); padding: 12px 16px; border-radius: var(--radius-sm); margin-bottom: 20px; font-weight: 600;">
                    <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($errorMsg) ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST" enctype="multipart/form-data">
                <!-- Hidden field to remember the old image filename -->
                <input type="hidden" name="existing_image" value="<?= htmlspecialchars($product['image']) ?>">

                <div style="display: grid; grid-template-columns: minmax(0, 1fr) 350px; gap: 20px; align-items: start;">
                    
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div class="card">
                            <div class="card-header" style="margin-bottom: 15px;">
                                <h3>Basic Information</h3>
                            </div>
                            
                            <div style="margin-bottom: 15px;">
                                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--color-text-main); margin-bottom: 6px;">Product Name *</label>
                                <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required style="width: 100%; height: 40px; padding: 0 12px; border: 1px solid var(--color-border); border-radius: var(--radius-sm); outline: none; font-family: inherit;">
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--color-text-main); margin-bottom: 6px;">Description</label>
                                <textarea name="description" rows="5" style="width: 100%; padding: 12px; border: 1px solid var(--color-border); border-radius: var(--radius-sm); outline: none; font-family: inherit; resize: vertical;"><?= htmlspecialchars($product['description']) ?></textarea>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" style="margin-bottom: 15px;">
                                <h3>Pricing & Inventory</h3>
                            </div>
                            
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                                <div>
                                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--color-text-main); margin-bottom: 6px;">Base Price (Rs.) *</label>
                                    <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($product['price']) ?>" required style="width: 100%; height: 40px; padding: 0 12px; border: 1px solid var(--color-border); border-radius: var(--radius-sm); outline: none; font-family: inherit;">
                                </div>
                                <div>
                                    <label style="display: block; font-size: 12px; font-weight: 700; color: var(--color-text-main); margin-bottom: 6px;">Sale Price (Rs.)</label>
                                    <input type="number" step="0.01" name="sale_price" value="<?= htmlspecialchars($product['sale_price']) ?>" style="width: 100%; height: 40px; padding: 0 12px; border: 1px solid var(--color-border); border-radius: var(--radius-sm); outline: none; font-family: inherit;">
                                </div>
                            </div>

                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--color-text-main); margin-bottom: 6px;">Stock Quantity</label>
                                <input type="number" name="stock_qty" value="<?= htmlspecialchars($product['stock_qty']) ?>" style="width: 100%; height: 40px; padding: 0 12px; border: 1px solid var(--color-border); border-radius: var(--radius-sm); outline: none; font-family: inherit;">
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        
                        <div class="card">
                            <div class="card-header" style="margin-bottom: 15px;">
                                <h3>Organization</h3>
                            </div>
                            
                            <div style="margin-bottom: 15px;">
                                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--color-text-main); margin-bottom: 6px;">Category *</label>
                                <select name="category_id" required style="width: 100%; height: 40px; padding: 0 12px; border: 1px solid var(--color-border); border-radius: var(--radius-sm); outline: none; font-family: inherit; background: var(--color-bg-card);">
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--color-text-main); margin-bottom: 6px;">Status</label>
                                <select name="status" style="width: 100%; height: 40px; padding: 0 12px; border: 1px solid var(--color-border); border-radius: var(--radius-sm); outline: none; font-family: inherit; background: var(--color-bg-card);">
                                    <option value="active" <?= $product['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="draft" <?= $product['status'] === 'draft' ? 'selected' : '' ?>>Draft (Hidden)</option>
                                    <option value="out_of_stock" <?= $product['status'] === 'out_of_stock' ? 'selected' : '' ?>>Out of Stock</option>
                                </select>
                            </div>

                            <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: var(--color-text-main); cursor: pointer;">
                                <input type="checkbox" name="is_featured" value="1" <?= $product['is_featured'] == 1 ? 'checked' : '' ?> style="width: 16px; height: 16px; accent-color: var(--color-primary);">
                                Feature on Homepage
                            </label>
                        </div>

                        <div class="card">
                            <div class="card-header" style="margin-bottom: 15px;">
                                <h3>Product Image</h3>
                            </div>
                            
                            <!-- Display Current Image -->
                            <div style="margin-bottom: 15px; text-align: center;">
                                <img src="../../uploads/products/<?= htmlspecialchars($product['image']) ?>" alt="Current Image" style="max-width: 100%; height: auto; border-radius: var(--radius-sm); border: 1px solid var(--color-border); background: var(--color-bg-main);">
                                <p style="font-size: 11px; color: var(--color-text-muted); margin-top: 8px;">Current Image</p>
                            </div>

                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--color-text-main); margin-bottom: 6px;">Replace Image (Optional)</label>
                                <input type="file" name="image" accept="image/jpeg, image/png, image/webp" style="width: 100%; padding: 10px; border: 1px dashed var(--color-border); border-radius: var(--radius-sm); background: var(--color-bg-hover); font-size: 12px;">
                            </div>
                        </div>

                        <button type="submit" name="update_product" class="btn-create-pill" style="width: 100%; justify-content: center; height: 48px; font-size: 14px;">
                            <i class="bi bi-save"></i> Save Changes
                        </button>

                    </div>
                </div>
            </form>

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