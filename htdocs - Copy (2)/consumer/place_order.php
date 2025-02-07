<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "error" => "You are not logged in."]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch cart items and link them to their original farmer
$query = "
    SELECT cart.inventory_id, cart.quantity, cart.total_price AS price, 
           inventory.item_name, inventory.farmer_id 
    FROM cart 
    JOIN inventory ON cart.inventory_id = inventory.id 
    WHERE cart.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = [];
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
}

if (empty($cartItems)) {
    echo json_encode(["success" => false, "error" => "Your cart is empty."]);
    exit;
}

// Insert each cart item into `orders`
$conn->begin_transaction();
try {
    $insertQuery = "
        INSERT INTO orders (consumer_id, farmer_id, inventory_id, item_name, quantity, price, status, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW());
    ";
    $insertStmt = $conn->prepare($insertQuery);

    foreach ($cartItems as $item) {
        $insertStmt->bind_param(
            "iiisid",
            $user_id,             // Consumer ID
            $item['farmer_id'],   // Farmer ID (Tracking original supplier)
            $item['inventory_id'],// Inventory ID
            $item['item_name'],   // Item Name
            $item['quantity'],    // Quantity Ordered
            $item['price']        // Price
        );
        $insertStmt->execute();
    }

    // Clear the cart
    $deleteQuery = "DELETE FROM cart WHERE user_id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $user_id);
    $deleteStmt->execute();

    $conn->commit();
    echo json_encode(["success" => true, "message" => "Your order has been placed and will be fulfilled by our warehouse."]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["success" => false, "error" => "Order failed. Try again."]);
}
?>