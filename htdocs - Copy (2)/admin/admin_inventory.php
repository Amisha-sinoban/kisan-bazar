<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Fetch all inventory items along with farmer info
$query = "
    SELECT inventory.*, users.name AS farmer_name 
    FROM inventory 
    JOIN users ON inventory.farmer_id = users.id
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Farmer Inventory</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Farmers' Inventory</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Farmer</th>
                    <th>Available Quantity</th>
                    <th>Price per Unit</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($inventory = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($inventory['item_name']); ?></td>
                        <td><?= htmlspecialchars($inventory['farmer_name']); ?></td>
                        <td><?= $inventory['quantity']; ?></td>
                        <td>₹<?= number_format($inventory['price'], 2); ?></td>
                        <td>
                            <a href="place_farm_order.php?inventory_id=<?= $inventory['id'] ?>&farmer_id=<?= $inventory['farmer_id'] ?>" class="btn btn-primary">Order from Farmer</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>