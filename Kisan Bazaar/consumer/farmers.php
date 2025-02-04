<?php
include "../config/db.php";

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_GET['category'])) {
    $category = $_GET['category'];

    $query = "SELECT users.id AS farmer_id, users.name, users.email, inventory.id AS inventory_id, inventory.item_name, inventory.quantity, inventory.price
              FROM users 
              JOIN inventory ON users.id = inventory.farmer_id 
              WHERE users.user_type = 'farmer' AND inventory.category = ?";
              
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    die("No category selected.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmers in <?php echo htmlspecialchars($category); ?></title>
</head>
<body>

<h2>Farmers offering <?php echo htmlspecialchars($category); ?></h2>

<?php
if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li><strong>Name:</strong> " . htmlspecialchars($row['name']) . 
             " | <strong>Email:</strong> " . htmlspecialchars($row['email']) . 
             " | <strong>Item:</strong> " . htmlspecialchars($row['item_name']) . 
             " | <strong>Quantity:</strong> " . htmlspecialchars($row['quantity']) . 
             " | <strong>Price:</strong> ₹" . htmlspecialchars($row['price']) . 
             "<form action='order.php' method='POST'>
                <input type='hidden' name='farmer_id' value='" . $row['farmer_id'] . "'>
                <input type='hidden' name='inventory_id' value='" . $row['inventory_id'] . "'>
                <input type='hidden' name='price' value='" . $row['price'] . "'>
                <label>Quantity:</label>
                <input type='number' name='quantity' min='1' max='" . $row['quantity'] . "' required>
                <button type='submit'>Order</button>
              </form>
             </li>";
    }
    echo "</ul>";
} else {
    echo "<p>No farmers found for this category.</p>";
}

$stmt->close();
$conn->close();
?>

<a href="index.php">Go Back</a>

</body>
</html>
