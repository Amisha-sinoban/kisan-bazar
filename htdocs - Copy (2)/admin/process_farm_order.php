<?php
session_start();
include "../config/db.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['admin_id'])) {
    die("Unauthorized access. Please log in as admin.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inventory_id = intval($_POST["inventory_id"]);
    $farmer_id = intval($_POST["farmer_id"]);
    $order_quantity = intval($_POST["order_quantity"]);

    // Fetch inventory details
    $query = "SELECT * FROM inventory WHERE id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("i", $inventory_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows == 0) {
        die("Error: Inventory item not found.");
    }

    $inventory = $result->fetch_assoc();
    $total_price = $inventory["price"] * $order_quantity;

    // INSERT ORDER FROM ADMIN TO FARMER
    $insertQuery = "
        INSERT INTO orders (admin_id, farmer_id, inventory_id, item_name, quantity, price, status, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())
    ";
    
    $insertStmt = $conn->prepare($insertQuery);
    
    if (!$insertStmt) {
        die("SQL Error: " . $conn->error);
    }

    $insertStmt->bind_param(
        "iiisid",
        $_SESSION["admin_id"],
        $farmer_id,
        $inventory_id,
        $inventory["item_name"],
        $order_quantity,
        $total_price
    );

    if ($insertStmt->execute()) {
        header("Location: admin_inventory.php?msg=Order placed to farmer successfully.");
    } else {
        die("Insert Statement Failed: " . $conn->error);
    }
}
?>