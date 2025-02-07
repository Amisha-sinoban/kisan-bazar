<?php
session_start();
include "../config/db.php";

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Fetch all consumer orders with farmer details
$query = "
    SELECT orders.*, users.name AS farmer_name 
    FROM orders 
    JOIN users ON orders.farmer_id = users.id 
    WHERE orders.status = 'pending'
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Order Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Consumer Orders (Pending)</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Item</th>
                    <th>Ordered By</th>
                    <th>Farmer</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= htmlspecialchars($order['item_name']) ?></td>
                        <td><?= $order['consumer_id'] ?></td>
                        <td><?= htmlspecialchars($order['farmer_name']) ?></td>
                        <td><?= $order['quantity'] ?></td>
                        <td>₹<?= number_format($order['price'], 2) ?></td>
                        <td>
                            <a href="fulfill_order.php?id=<?= $order['id'] ?>" class="btn btn-primary">Fulfill Order</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>