<?php
require_once "../config/db.php";
require_once "../includes/functions.php";

if (session_status() === PHP_SESSION_NONE) { session_start(); }
header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["success" => false, "message" => "Please sign in to place an order."]);
    exit;
}

$userId = $_SESSION["user_id"];
$cartItems = getCartItems();

if (empty($cartItems)) {
    echo json_encode(["success" => false, "message" => "Your cart is empty."]);
    exit;
}

$firstName = trim($_POST["first_name"] ?? "");
$lastName = trim($_POST["last_name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$address = trim($_POST["address"] ?? "");
$city = trim($_POST["city"] ?? "");
$paymentMethod = $_POST["payment_method"] ?? "cod";

if (empty($firstName) || empty($address) || empty($city)) {
    echo json_encode(["success" => false, "message" => "Please fill out all required fields."]);
    exit;
}

$totals = getCartTotals();
$subtotal = $totals["subtotal"];
$shipping = $totals["shipping"];
$tax = $totals["tax"];
$totalAmount = $totals["total"];

$orderNumber = "#ORD-" . date("Y") . "-" . rand(1000, 9999);
$paymentStatus = ($paymentMethod === "cod") ? "Pending" : "Paid";

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO orders (user_id, order_number, customer_name, email, phone, address, city, subtotal, shipping, tax, total_amount, payment_method, payment_status, order_status) VALUES (:user_id, :order_number, :customer_name, :email, :phone, :address, :city, :subtotal, :shipping, :tax, :total_amount, :payment_method, :payment_status, 'Processing')");
    
    $stmt->execute([
        ":user_id" => $userId,
        ":order_number" => $orderNumber,
        ":customer_name" => $firstName . " " . $lastName,
        ":email" => $email,
        ":phone" => $phone,
        ":address" => $address,
        ":city" => $city,
        ":subtotal" => $subtotal,
        ":shipping" => $shipping,
        ":tax" => $tax,
        ":total_amount" => $totalAmount,
        ":payment_method" => $paymentMethod,
        ":payment_status" => $paymentStatus
    ]);

    $orderId = $pdo->lastInsertId();

    $itemStmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, unit_price, total_price) VALUES (:order_id, :product_id, :quantity, :unit_price, :total_price)");

    foreach ($cartItems as $item) {
        $itemStmt->execute([
            ":order_id" => $orderId,
            ":product_id" => $item["product_id"],
            ":quantity" => $item["quantity"],
            ":unit_price" => $item["price"],
            ":total_price" => $item["price"] * $item["quantity"]
        ]);
    }

    // Clear the cart
    $clearStmt = $pdo->prepare("DELETE FROM cart WHERE session_id = :session_id");
    $clearStmt->execute([":session_id" => getUserSessionId()]);

    $pdo->commit();

    echo json_encode(["success" => true, "message" => "Order placed successfully!"]);

} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(["success" => false, "message" => "Failed to place order: " . $e->getMessage()]);
}
?>
