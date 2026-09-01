<?php
require_once '../../config/db.php';

$pageTitle = "Edit Category — Velyora Admin";
$successMsg = '';
$errorMsg = '';

// 1. Get the category ID from the URL
$catId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($catId === 0) {
    header('Location: index.php');
    exit;
}

// 2. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_category'])) {
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $icon = trim($_POST['icon'] ?? 'bi-folder');
    $status = $_POST['status'] ?? 'active';

    if (empty($slug) && !empty($name)) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    }

    if (empty($name) || empty($slug)) {
        $errorMsg = "Category name and slug are required.";
    } else {
        try {
            // Check if slug exists for a DIFFERENT category
            $check = $pdo->prepare("SELECT id FROM categories WHERE slug = ? AND id != ?");
            $check->execute([$slug, $catId]);
            
            if ($check->rowCount() > 0) {
                $errorMsg = "Another category with this slug already exists.";
            } else {
                $updateStmt = $pdo->prepare("UPDATE categories SET name = ?, slug = ?, icon = ?, status = ? WHERE id = ?");
                $updateStmt->execute([$name, $slug, $icon, $status, $catId]);
                $successMsg = "Category updated successfully!";
            }
        } catch (PDOException $e) {
            $errorMsg = "Database error: " . $e->getMessage();
        }
    }
}

// 3. Fetch current category data to pre-fill the form
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$catId]);
$category = $stmt->fetch();

if (!$category) {
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
                    <h2>Edit Category</h2>
                    <p>Update details for "<?= htmlspecialchars($category['name']) ?>"</p>
                </div>
                <a href="index.php" class="btn-hero-white" style="text-decoration: none; border: 1px solid var(--color-border); color: var(--color-text-main);">
                    <i class="bi bi-arrow-left"></i> Back to Categories
                </a>
            </div>

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

            <div class="card" style="max-width: 600px;">
                <form action="" method="POST">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 12px; font-weight: 700; color: var(--color-text-main); margin-bottom: 6px;">Category Name</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($category['name']) ?>" required style="width: 100%; height: 40px; padding: 0 12px; border: 1px solid var(--color-border); border-radius: var(--radius-sm); outline: none; font-family: inherit;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 12px; font-weight: 700; color: var(--color-text-main); margin-bottom: 6px;">Slug</label>
                        <input type="text" name="slug" value="<?= htmlspecialchars($category['slug']) ?>" required style="width: 100%; height: 40px; padding: 0 12px; border: 1px solid var(--color-border); border-radius: var(--radius-sm); outline: none; font-family: inherit;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 12px; font-weight: 700; color: var(--color-text-main); margin-bottom: 6px;">Bootstrap Icon Class</label>
                        <input type="text" name="icon" value="<?= htmlspecialchars($category['icon']) ?>" style="width: 100%; height: 40px; padding: 0 12px; border: 1px solid var(--color-border); border-radius: var(--radius-sm); outline: none; font-family: inherit;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 12px; font-weight: 700; color: var(--color-text-main); margin-bottom: 6px;">Status</label>
                        <select name="status" style="width: 100%; height: 40px; padding: 0 12px; border: 1px solid var(--color-border); border-radius: var(--radius-sm); outline: none; font-family: inherit; background: var(--color-bg-card);">
                            <option value="active" <?= $category['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $category['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>

                    <button type="submit" name="update_category" class="btn-create-pill" style="width: 100%; justify-content: center;">
                        <i class="bi bi-save"></i> Update Category
                    </button>
                </form>
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