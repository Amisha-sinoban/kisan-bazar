<?php
session_start();
require '../config/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'farmer') {
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$farmer_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $order_id = $_POST['order_id'];

    // Ensure the order belongs to the logged-in farmer
    $sql = "UPDATE orders SET status = 'done' WHERE id = ? AND farmer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $order_id, $farmer_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
}
?>
