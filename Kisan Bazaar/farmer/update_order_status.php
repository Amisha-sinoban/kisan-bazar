<?php
session_start();
include "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['order_id']) || !isset($_POST['status'])) {
        die("Missing data");
    }

    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // Ensure only the farmer can update their order
    $farmer_id = $_SESSION['user_id'];
    $check_query = "SELECT * FROM orders WHERE id = ? AND farmer_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ii", $order_id, $farmer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        die("Unauthorized or invalid order");
    }

    // Update the order status
    $query = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("si", $status, $order_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error updating order: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>