<?php
session_start();
include "../config/db.php";

if (!isset($_SESSION['admin_id'])) {
    echo "Unauthorized access. Please log in as admin.";
    exit;
}

// 🔍 **VALIDATE URL PARAMETERS**
if (!isset($_GET['inventory_id']) || !isset($_GET['farmer_id'])) {
    echo "<script>alert('Invalid request. No inventory or farmer selected.'); window.location.href='admin_inventory.php';</script>";
    exit;
}

$inventory_id = intval($_GET['inventory_id']);
$farmer_id = intval($_GET['farmer_id']);

// Fetch inventory details
$query = "SELECT * FROM inventory WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $inventory_id);
$stmt->execute();
$inventory = $stmt->get_result()->fetch_assoc();

if (!$inventory) {
    echo "<script>alert('Inventory item not found.'); window.location.href='admin_inventory.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Place Order to Farmer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Order From Farmer - <?= htmlspecialchars($inventory['item_name']); ?></h2>
        <form action="process_farm_order.php" method="POST">
            <input type="hidden" name="inventory_id" value="<?= htmlspecialchars($inventory_id); ?>">
            <input type="hidden" name="farmer_id" value="<?= htmlspecialchars($farmer_id); ?>">
            
            <div class="mb-3">
                <label>Item Name:</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($inventory['item_name']); ?>" disabled>
            </div>
            
            <div class="mb-3">
                <label>Available Quantity:</label>
                <input type="text" class="form-control" value="<?= $inventory['quantity']; ?>" disabled>
            </div>
            
            <div class="mb-3">
                <label>Price per Unit:</label>
                <input type="text" class="form-control" value="₹<?= number_format($inventory['price'], 2); ?>" disabled>
            </div>

            <div class="mb-3">
                <label>Order Quantity:</label>
                <input type="number" name="order_quantity" class="form-control" required min="1" max="<?= $inventory['quantity']; ?>">
            </div>

            <button type="submit" class="btn btn-success">Place Order</button>
        </form>
    </div>
</body>
</html>