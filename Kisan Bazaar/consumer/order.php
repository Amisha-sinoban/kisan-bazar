<?php
session_start();
include "../config/db.php";

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $consumer_id = $_SESSION['user_id'];
    $farmer_id = $_POST['farmer_id'];
    $inventory_id = $_POST['inventory_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'] * $quantity;

    // ✅ Fetch the item name from the inventory table
    $item_query = "SELECT item_name FROM inventory WHERE id = ?";
    $stmt = $conn->prepare($item_query);
    
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $inventory_id);
    $stmt->execute();
    $stmt->bind_result($item_name);
    $stmt->fetch();
    $stmt->close();

    // ✅ Insert order into database, ensuring `orders` table has an `item_name` column
    $query = "INSERT INTO orders (consumer_id, farmer_id, inventory_id, quantity, price, status, item_name) 
              VALUES (?, ?, ?, ?, ?, 'Pending', ?)";
    
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("iiiids", $consumer_id, $farmer_id, $inventory_id, $quantity, $price, $item_name);

    if ($stmt->execute()) {
        echo "Order placed successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
