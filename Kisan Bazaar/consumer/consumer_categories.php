<?php
include "../config/db.php"; // Ensure database connection is included

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch distinct categories from inventory
$query = "SELECT DISTINCT category FROM inventory";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Category</title>
</head>
<body>

<h2>Select a Category</h2>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<form action='farmers.php' method='GET' style='display:inline-block; margin: 5px;'>
                <button type='submit' name='category' value='" . htmlspecialchars($row['category']) . "'>
                    " . htmlspecialchars($row['category']) . "
                </button>
              </form>";
    }
} else {
    echo "<p>No categories found.</p>";
}

$conn->close();
?>

</body>
</html>
