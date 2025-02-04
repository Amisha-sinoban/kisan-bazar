<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'farmer') {
    echo json_encode(["status" => "error", "message" => "Unauthorized access"]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $farmer_id = $_SESSION['user_id'];
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $stmt = $conn->prepare("INSERT INTO inventory (farmer_id, item_name, quantity, price, category) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isdis", $farmer_id, $item_name, $quantity, $price, $category);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Item added successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add item!"]);
    }
    $stmt->close();
}
$conn->close();
?>
