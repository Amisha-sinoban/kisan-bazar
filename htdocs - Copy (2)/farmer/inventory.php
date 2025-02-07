<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'farmer') {
    header("Location: ../login.php");
    exit();
}

include "../config/db.php";

$farmer_id = $_SESSION['user_id'];
$category = isset($_GET['category']) ? $_GET['category'] : '';
$subcategory = isset($_GET['subcategory']) ? $_GET['subcategory'] : '';

// Fetch inventory with the image URL dynamically from the `subcategory_images` table
$query = "
    SELECT inventory.*, subcategory_images.img_url 
    FROM inventory 
    LEFT JOIN subcategory_images ON inventory.subcategory = subcategory_images.subcategory 
    WHERE inventory.farmer_id = ? AND inventory.category = ? AND inventory.subcategory = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("iss", $farmer_id, $category, $subcategory);
$stmt->execute();
$result = $stmt->get_result();

// Handle new item submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_name = $subcategory;  // Auto-set item_name as selected subcategory
    $item_quantity = intval($_POST['item_quantity']);
    $item_price = floatval($_POST['item_price']);

    // Fetch `img_url` dynamically from `subcategory_images`
    $imageQuery = "SELECT img_url FROM subcategory_images WHERE subcategory = ?";
    $imageStmt = $conn->prepare($imageQuery);
    $imageStmt->bind_param("s", $subcategory);
    $imageStmt->execute();
    $imageResult = $imageStmt->get_result();
    $img_url = ($imageResult->num_rows > 0) ? $imageResult->fetch_assoc()['img_url'] : 'images/default.jpg';

    // Insert item into `inventory` (but don't store `img_url`)
    $insertQuery = "INSERT INTO inventory (farmer_id, item_name, quantity, price, category, subcategory) 
                    VALUES (?, ?, ?, ?, ?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("isidss", $farmer_id, $item_name, $item_quantity, $item_price, $category, $subcategory);

    if ($insertStmt->execute()) {
        header("Location: inventory.php?category=$category&subcategory=$subcategory&msg=Item added successfully");
        exit();
    } else {
        $error_message = "Error adding item.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage <?= htmlspecialchars($subcategory); ?> Inventory</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center text-success"><?= htmlspecialchars($subcategory); ?> Inventory</h1>

        <!-- Display Success Message -->
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['msg']); ?></div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?= $error_message; ?></div>
        <?php endif; ?>

        <!-- Add New Item Form -->
        <div class="card p-4 mb-4">
            <h3>Add New Item</h3>
            <form method="POST">
                <input type="hidden" name="subcategory" value="<?= htmlspecialchars($subcategory); ?>">  
                <input type="hidden" name="item_name" value="<?= htmlspecialchars($subcategory); ?>">

                <div class="mb-3">
                    <label class="form-label">Item Name</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($subcategory); ?>" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="item_quantity" class="form-control" required placeholder="Enter quantity">
                </div>
                <div class="mb-3">
                    <label class="form-label">Price per Unit (₹)</label>
                    <input type="number" step="0.01" name="item_price" class="form-control" required placeholder="Enter price">
                </div>
                <button type="submit" class="btn btn-primary w-100">Add to Inventory</button>
            </form>
        </div>

        <!-- Inventory Table -->
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Subcategory</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['item_name']) ?></td>
                        <td><?= htmlspecialchars($row['category']) ?></td>
                        <td><?= htmlspecialchars($row['subcategory']) ?></td>
                        <td><?= intval($row['quantity']) ?></td>
                        <td>₹<?= number_format($row['price'], 2) ?></td>
                        <td>
                            <img src="<?= htmlspecialchars($row['img_url']) ?>" width="80" height="80" 
                            alt="<?= htmlspecialchars($row['item_name']); ?>">
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>