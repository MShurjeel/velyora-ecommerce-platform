<?php
/**
 * AJAX Wishlist Handler for Velyora
 */
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json; charset=utf-8');

// Parse request payload
$input = [];
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
if (stripos($contentType, 'application/json') !== false) {
    $raw = file_get_contents('php://input');
    $input = json_decode($raw, true) ?: [];
}
$request = array_merge($_GET, $_POST, $input);
$action = isset($request['action']) ? trim($request['action']) : 'get';

$response = ['success' => false, 'message' => 'Invalid action.'];

switch ($action) {
    case 'toggle':
        $productId = isset($request['product_id']) ? (int)$request['product_id'] : 0;
        $response = toggleWishlist($productId);
        break;

    case 'remove':
        $productId = isset($request['product_id']) ? (int)$request['product_id'] : 0;
        $response = removeFromWishlist($productId);
        break;

    case 'add_all_to_cart':
        $response = addAllWishlistToCart();
        break;

    case 'get':
        $items = getWishlistItems();
        $count = getWishlistCount();
        $response = [
            'success' => true,
            'items' => $items,
            'wishlist_count' => $count
        ];
        break;

    default:
        $response = ['success' => false, 'message' => 'Unknown action: ' . htmlspecialchars($action)];
        break;
}

echo json_encode($response);
exit;

