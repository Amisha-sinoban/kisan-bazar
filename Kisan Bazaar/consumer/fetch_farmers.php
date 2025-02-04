<?php
include "../config/db.php"; // Ensure this file properly connects to the database

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category'])) {
    $category = $_POST['category'];

    // Adjusting the SQL query based on your schema
    $query = "SELECT DISTINCT users.name, users.email, inventory.item_name 
              FROM users 
              JOIN inventory ON users.id = inventory.farmer_id 
              WHERE users.user_type = 'farmer' AND inventory.category = ?";

    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }

    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li><strong>Farmer:</strong> " . htmlspecialchars($row['name']) . 
                 " | <strong>Contact:</strong> " . htmlspecialchars($row['email']) . 
                 " | <strong>Item:</strong> " . htmlspecialchars($row['item_name']) . 
                 "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No farmers found for this category.</p>";
    }

    $stmt->close();
}
$conn->close();
?>
