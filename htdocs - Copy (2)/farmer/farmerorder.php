<?php
session_start();
require '../config/db.php';  // Ensure the correct path

// Check if the user is logged in and is a farmer
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'farmer') {
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$farmer_id = $_SESSION['user_id'];

$sql = "SELECT * FROM orders WHERE farmer_id = ? ORDER BY status DESC, created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $farmer_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode($orders);
?>
