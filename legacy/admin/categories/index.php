<?php
require_once '../../config/db.php';

$pageTitle = "Velyora Admin — Categories";
$successMsg = '';
$errorMsg = '';

// Handle Add Category Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $icon = trim($_POST['icon'] ?? 'bi-folder');
    $status = $_POST['status'] ?? 'active';

    // Auto-generate slug if left empty
    if (empty($slug) && !empty($name)) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    }

    if (empty($name) || empty($slug)) {
        $errorMsg = "Category name and slug are required.";
    } else {
        try {
            // Check if slug already exists
            $check = $pdo->prepare("SELECT id FROM categories WHERE slug = ?");
            $check->execute([$slug]);
            if ($check->rowCount() > 0) {
                $errorMsg = "A category with this slug already exists.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO categories (name, slug, icon, status) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $slug, $icon, $status]);
                $successMsg = "Category added successfully!";
            }
        } catch (PDOException $e) {
            $errorMsg = "Database error: " . $e->getMessage();
        }
    }
}

// Handle Delete Category
if (isset($_GET['delete'])) {
    $catId = (int) $_GET['delete'];
    
    // Check if products are still assigned to this category
    $prodCheck = $pdo->prepare("SELECT COUNT(*) FROM products WHERE category_id = ?");
    $prodCheck->execute([$catId]);
    $productCount = $prodCheck->fetchColumn();

    if ($productCount > 0) {
        $errorMsg = "Cannot delete this category because $productCount product(s) are still assigned to it.";
    } else {
        $delStmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
        $delStmt->execute([$catId]);
        $successMsg = "Category deleted successfully!";
    }
}

// Fetch all categories with live product counts
$stmt = $pdo->query("
    SELECT categories.*, COUNT(products.id) AS product_count 
    FROM categories 
    LEFT JOIN products ON categories.id = products.category_id 
    GROUP BY categories.id 
    ORDER BY categories.id DESC
");
$categories = $stmt->fetchAll();
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
            <div class="card-header" style="padding: 0 0 20px 0; margin-bottom: 20px; border-bottom: 1px solid var(--color-border);">
                <div>
                    <h2>Manage Categories</h2>
                    <p>Organize your store structure and view product counts per category.</p>
                </div>
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

            <!-- Main Layout Grid (Form on Left, Table on Right) -->
            <div style="display: grid; grid-template-columns: 350px minmax(0, 1fr); gap: 20px; align-items: start;">
                
                <!-- Add Category Form Card -->
                <div class="card">
                    <div class="card-header" style="margin-bottom: 15px;">
                        <h3>Add New Category</h3>
                    </div>
                    <form action="" method="POST">
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--color-text-main); margin-bottom: 6px;">Category Name</label>
                            <input type="text" name="name" required placeholder="e.g. Electronics" style="width: 100%; height: 40px; padding: 0 12px; border: 1px solid var(--color-border); border-radius: var(--radius-sm); outline: none; font-family: inherit;">
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--color-text-main); margin-bottom: 6px;">Slug (optional)</label>
                            <input type="text" name="slug" placeholder="e.g. electronics" style="width: 100%; height: 40px; padding: 0 12px; border: 1px solid var(--color-border); border-radius: var(--radius-sm); outline: none; font-family: inherit;">
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--color-text-main); margin-bottom: 6px;">Bootstrap Icon Class</label>
                            <input type="text" name="icon" value="bi-folder" placeholder="e.g. bi-cpu" style="width: 100%; height: 40px; padding: 0 12px; border: 1px solid var(--color-border); border-radius: var(--radius-sm); outline: none; font-family: inherit;">
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 12px; font-weight: 700; color: var(--color-text-main); margin-bottom: 6px;">Status</label>
                            <select name="status" style="width: 100%; height: 40px; padding: 0 12px; border: 1px solid var(--color-border); border-radius: var(--radius-sm); outline: none; font-family: inherit; background: var(--color-bg-card);">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <button type="submit" name="add_category" class="btn-create-pill" style="width: 100%; justify-content: center;">
                            <i class="bi bi-plus-lg"></i> Save Category
                        </button>
                    </form>
                </div>

                <!-- Categories Table Card -->
                <div class="card table-card">
                    <div class="card-header" style="padding: 24px 24px 0;">
                        <h3>All Categories</h3>
                        <p>Total categories: <?= count($categories) ?></p>
                    </div>
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Name</th>
                                    <th>Slug</th>
                                    <th>Products</th>
                                    <th>Status</th>
                                    <th style="text-align: right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $cat): ?>
                                        <tr>
                                            <td class="font-bold text-primary">#<?= $cat['id'] ?></td>
                                            <td>
                                                <div style="display: flex; align-items: center; gap: 8px;">
                                                    <i class="bi <?= htmlspecialchars($cat['icon'] ?? 'bi-folder') ?>" style="color: var(--color-primary);"></i>
                                                    <strong><?= htmlspecialchars($cat['name']) ?></strong>
                                                </div>
                                            </td>
                                            <td style="color: var(--color-text-muted); font-size: 12px;"><?= htmlspecialchars($cat['slug']) ?></td>
                                            <td><span class="status-badge sky-soft" style="background: var(--color-primary-soft); color: var(--color-primary);"><?= $cat['product_count'] ?> products</span></td>
                                            <td>
                                                <?php if ($cat['status'] === 'active'): ?>
                                                    <span class="status-badge success">Active</span>
                                                <?php else: ?>
                                                    <span class="status-badge danger">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <a href="edit.php?id=<?= $cat['id'] ?>" class="icon-btn-flat" style="display: inline-flex; text-decoration: none;" title="Edit"><i class="bi bi-pencil" style="font-size: 14px;"></i></a>
                                                <a href="index.php?delete=<?= $cat['id'] ?>" class="icon-btn-flat" style="display: inline-flex; text-decoration: none; color: var(--color-danger);" onclick="return confirm('Are you sure you want to delete this category?');" title="Delete"><i class="bi bi-trash" style="font-size: 14px;"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 30px; color: var(--color-text-muted);">No categories found. Create your first category on the left.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </main>
</div>

<script>
    // Sidebar Submenu Toggle
    document.querySelectorAll('.has-dropdown').forEach(item => {
        item.addEventListener('click', event => {
            event.preventDefault();
            item.classList.toggle('open');
        });
    });
</script>

</body>
</html>