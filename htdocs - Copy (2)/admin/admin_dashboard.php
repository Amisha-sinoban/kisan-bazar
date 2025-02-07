<?php
session_start();
include "../config/db.php";

// Ensure admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Count Total Consumer Orders (Pending)
$consumer_orders_query = "SELECT COUNT(*) AS total FROM orders WHERE consumer_id IS NOT NULL AND status = 'pending'";
$consumer_orders_result = $conn->query($consumer_orders_query);
$consumer_orders_count = $consumer_orders_result->fetch_assoc()['total'];

// Count Total Orders Admin Placed to Farmers (Pending)
$farm_orders_query = "SELECT COUNT(*) AS total FROM orders WHERE admin_id IS NOT NULL AND status = 'pending'";
$farm_orders_result = $conn->query($farm_orders_query);
$farm_orders_count = $farm_orders_result->fetch_assoc()['total'];

// Count Total Completed Orders
$completed_orders_query = "SELECT COUNT(*) AS total FROM orders WHERE status = 'done'";
$completed_orders_result = $conn->query($completed_orders_query);
$completed_orders_count = $completed_orders_result->fetch_assoc()['total'];

// Count Total Items in Inventory
$inventory_query = "SELECT COUNT(*) AS total FROM inventory";
$inventory_result = $conn->query($inventory_query);
$inventory_count = $inventory_result->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Admin Dashboard</h1>
        <h5 class="text-center">Manage Consumer Orders & Supplier Transactions</h5>
        
        <div class="row mt-4">
            <!-- Consumer Orders Pending -->
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <h4><?= $consumer_orders_count; ?></h4>
                    <p>Pending Consumer Orders</p>
                    <a href="admin_orders.php" class="btn btn-primary">View Orders</a>
                </div>
            </div>

            <!-- Warehouse Orders to Farmers -->
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <h4><?= $farm_orders_count; ?></h4>
                    <p>Pending Warehouse Orders to Farmers</p>
                    <a href="place_farm_order.php" class="btn btn-primary">Order from Farmers</a>
                </div>
            </div>

            <!-- Inventory Management -->
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <h4><?= $inventory_count; ?></h4>
                    <p>Items in Inventory</p>
                    <a href="admin_inventory.php" class="btn btn-secondary">Manage Inventory</a>
                </div>
            </div>

            <!-- Fulfilled Orders -->
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <h4><?= $completed_orders_count; ?></h4>
                    <p>Completed Orders</p>
                    <a href="fulfill_order.php" class="btn btn-success">View History</a>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="admin_login.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>