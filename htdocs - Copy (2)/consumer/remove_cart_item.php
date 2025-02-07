<?php
session_start();
include "../config/db.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get the cart item to remove
if (isset($_POST['cart_id'])) {
    $cart_id = intval($_POST['cart_id']);

    // Make sure this cart item belongs to the logged-in user
    $query = "DELETE FROM cart WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $cart_id, $_SESSION['user_id']);

    if ($stmt->execute()) {
        // Redirect to cart after removal
        header("Location: cart.php");
    } else {
        echo "Error removing item: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>