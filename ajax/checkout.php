<?php
/**
 * ajax/checkout.php
 * Receives the checkout form data, validates it, saves the order to the
 * database inside a transaction, then clears the user's cart.
 */

require_once __DIR__ . '/../config/db.php';
// functions.php is already included by config/db.php

// Ensure session is active (db.php starts it, but guard here too)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

// ── 1. Auth check ──────────────────────────────────────────
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'requires_login' => true, 'message' => 'Please sign in to place an order.']);
    exit;
}

// ── 2. Cart check ──────────────────────────────────────────
$cartItems = getCartItems();
if (empty($cartItems)) {
    echo json_encode(['success' => false, 'message' => 'Your cart is empty.']);
    exit;
}

// ── 3. Collect & sanitise form fields ──────────────────────
$userId      = (int) $_SESSION['user_id'];
$firstName   = trim($_POST['first_name']    ?? '');
$lastName    = trim($_POST['last_name']     ?? '');
$email       = trim($_POST['email']         ?? '');
$phone       = trim($_POST['phone']         ?? '');
$address     = trim($_POST['address']       ?? '');
$address2    = trim($_POST['address_2']     ?? '');
$city        = trim($_POST['city']          ?? '');
$province    = trim($_POST['province']      ?? '');
$postalCode  = trim($_POST['postal_code']   ?? '');
$paymentMethod = trim($_POST['payment_method'] ?? 'cod');

if (!$firstName || !$address || !$city || !$phone) {
    echo json_encode(['success' => false, 'message' => 'Please fill out all required shipping fields.']);
    exit;
}

// Full address string
$fullAddress = $address . ($address2 ? ', ' . $address2 : '');
$customerName = trim($firstName . ' ' . $lastName);

// ── 4. Recalculate totals server-side (never trust the frontend) ──
$totals      = getCartTotals();
$subtotal    = $totals['subtotal'];
$shipping    = $totals['shipping'];
$tax         = $totals['tax'];
$discount    = $totals['discount'] ?? 0;
$totalAmount = $totals['total'];

// ── 5. Generate a unique order number ──────────────────────
$orderNumber = '#ORD-' . date('Y') . '-' . strtoupper(substr(uniqid(), -6));

$paymentStatus = ($paymentMethod === 'cod') ? 'Pending' : 'Paid';

// ── 6. Database Transaction ────────────────────────────────
try {
    $pdo->beginTransaction();

    // Insert the order header
    $orderStmt = $pdo->prepare("
        INSERT INTO orders
            (user_id, order_number, customer_name, email, phone, address, city,
             province, postal_code, subtotal, shipping, tax, total_amount,
             payment_method, payment_status, order_status)
        VALUES
            (:user_id, :order_number, :customer_name, :email, :phone, :address, :city,
             :province, :postal_code, :subtotal, :shipping, :tax, :total_amount,
             :payment_method, :payment_status, 'Processing')
    ");

    $orderStmt->execute([
        ':user_id'        => $userId,
        ':order_number'   => $orderNumber,
        ':customer_name'  => $customerName,
        ':email'          => $email,
        ':phone'          => $phone,
        ':address'        => $fullAddress,
        ':city'           => $city,
        ':province'       => $province,
        ':postal_code'    => $postalCode,
        ':subtotal'       => $subtotal,
        ':shipping'       => $shipping,
        ':tax'            => $tax,
        ':total_amount'   => $totalAmount,
        ':payment_method' => $paymentMethod,
        ':payment_status' => $paymentStatus,
    ]);

    $orderId = $pdo->lastInsertId();

    // Insert each order item
    $itemStmt = $pdo->prepare("
        INSERT INTO order_items (order_id, product_id, quantity, unit_price, total_price)
        VALUES (:order_id, :product_id, :quantity, :unit_price, :total_price)
    ");

    foreach ($cartItems as $item) {
        $itemStmt->execute([
            ':order_id'    => $orderId,
            ':product_id'  => $item['product_id'],
            ':quantity'    => $item['quantity'],
            ':unit_price'  => $item['price'],
            ':total_price' => $item['price'] * $item['quantity'],
        ]);
    }

    // Clear the cart for this user
    $sessionId = getUserSessionId();
    if ($sessionId) {
        $clearStmt = $pdo->prepare("DELETE FROM cart WHERE session_id = :session_id");
        $clearStmt->execute([':session_id' => $sessionId]);
    }

    $pdo->commit();

    echo json_encode([
        'success'      => true,
        'message'      => 'Order placed successfully!',
        'order_number' => $orderNumber,
    ]);

} catch (Exception $e) {
    $pdo->rollBack();
    error_log('Checkout error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Failed to place order. Please try again.']);
}

