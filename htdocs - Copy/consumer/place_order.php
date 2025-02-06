<?php
session_start();
include "../config/db.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'You are not logged in.']);
    exit;
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch all cart items for the user
$query = "
    SELECT 
        cart.inventory_id, 
        cart.quantity, 
        cart.total_price AS price, 
        inventory.item_name, 
        inventory.farmer_id 
    FROM cart 
    JOIN inventory ON cart.inventory_id = inventory.id 
    WHERE cart.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }
}

if (empty($cartItems)) {
    echo json_encode(['success' => false, 'error' => 'Your cart is empty.']);
    exit;
}

// Begin transaction to ensure atomicity
$conn->begin_transaction();
try {
    // Insert each cart item into the `orders` table
    $insertQuery = "
        INSERT INTO orders 
            (consumer_id, farmer_id, inventory_id, item_name, quantity, price, status, created_at) 
        VALUES 
            (?, ?, ?, ?, ?, ?, 'pending', NOW())
    ";
    $insertStmt = $conn->prepare($insertQuery);

    foreach ($cartItems as $item) {
        $insertStmt->bind_param(
            "iiisid",
            $user_id,                // consumer_id
            $item['farmer_id'],      // farmer_id
            $item['inventory_id'],   // inventory_id
            $item['item_name'],      // item_name
            $item['quantity'],       // quantity
            $item['price']           // price
        );
        $insertStmt->execute();
    }

    // Clear the cart after placing the order
    $deleteQuery = "DELETE FROM cart WHERE user_id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $user_id);
    $deleteStmt->execute();

    // Commit transaction
    $conn->commit();

    echo json_encode(['success' => true, 'message' => 'Order placed successfully.']);
} catch (Exception $e) {
    // Rollback transaction in case of an error
    $conn->rollback();
    echo json_encode(['success' => false, 'error' => 'Failed to place order. Please try again.']);
}
?>