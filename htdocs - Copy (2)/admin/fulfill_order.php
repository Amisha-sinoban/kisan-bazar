<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
    echo "Unauthorized access. Please log in as admin.";
    exit;
}

if (isset($_GET['id'])) {
    $order_id = intval($_GET['id']);

    // Update order status to "done"
    $query = "UPDATE orders SET status = 'done' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        header("Location: admin_orders.php?msg=Order marked as fulfilled.");
    } else {
        echo "Error updating order.";
    }
} else {
    echo "Invalid request.";
}
?>