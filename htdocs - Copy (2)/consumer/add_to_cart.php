<?php
include "../config/db.php";
session_start(); // Start the session

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'You are not logged in.']);
    exit;
}

$user_id = $_SESSION['user_id'];

if (!$conn) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed.']);
    exit;
}

$orderData = json_decode(file_get_contents("php://input"), true);

if (!isset($orderData['inventory_id'], $orderData['quantity'], $orderData['total_price'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid order data.']);
    exit;
}

$inventory_id = intval($orderData['inventory_id']);
$quantity = intval($orderData['quantity']);
$total_price = floatval($orderData['total_price']);

if ($quantity <= 0) {
    echo json_encode(['success' => false, 'error' => 'Quantity must be greater than zero.']);
    exit;
}

$query = "INSERT INTO cart (user_id, inventory_id, quantity, total_price) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("iiid", $user_id, $inventory_id, $quantity, $total_price);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Item added to cart.']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to insert item into cart.']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>