<?php
/**
 * AJAX Cart Handler for Velyora
 */
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json; charset=utf-8');

// Parse request payload (supports POST form-data, JSON body, or GET)
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
    case 'add':
        $productId = isset($request['product_id']) ? (int)$request['product_id'] : 0;
        $quantity = isset($request['quantity']) ? (int)$request['quantity'] : 1;
        $response = addToCart($productId, $quantity);
        if ($response['success']) $response['items'] = getCartItems();
        break;

    case 'update':
        $cartId = isset($request['cart_id']) ? (int)$request['cart_id'] : 0;
        $quantity = isset($request['quantity']) ? (int)$request['quantity'] : 1;
        $response = updateCartQuantity($cartId, $quantity);
        if ($response['success']) $response['items'] = getCartItems();
        break;

    case 'remove':
        $cartId = isset($request['cart_id']) ? (int)$request['cart_id'] : 0;
        $response = removeFromCart($cartId);
        if ($response['success']) $response['items'] = getCartItems();
        break;

    case 'clear':
        $response = clearCart();
        if ($response['success']) $response['items'] = getCartItems();
        break;

    case 'get':
        $items = getCartItems();
        $totals = getCartTotals();
        $response = [
            'success' => true,
            'items' => $items,
            'totals' => $totals,
            'cart_count' => $totals['item_count']
        ];
        break;

    default:
        $response = ['success' => false, 'message' => 'Unknown action: ' . htmlspecialchars($action)];
        break;
}

echo json_encode($response);
exit;

