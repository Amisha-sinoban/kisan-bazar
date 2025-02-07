<?php
include "../config/db.php"; // Ensure database connection is included

// Fetch distinct categories and select only one image per category
$query = "SELECT category, MAX(img_url) as img_url FROM inventory GROUP BY category";
$result = $conn->query($query);

// Check if the query failed
if (!$result) {
    die("SQL Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        header {
            background-color: #28a745;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .category {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 15px;
        }

        .category img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<header>
    <h1>Product Categories</h1>
</header>

<main class="container my-4">
    <div class="row g-4">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $category = htmlspecialchars($row['category']);
                $imgUrl = !empty($row['img_url']) ? htmlspecialchars($row['img_url']) : 'default.jpg'; // Use default image if empty

                echo "
                <div class='col-md-4'>
                    <div class='category'>
                        <img src='$imgUrl' alt='$category'>
                        <h2>$category</h2>
                        <button class='btn btn-success' onclick='navigateTo(\"$category\")'>Select</button>
                    </div>
                </div>";
            }
        } else {
            echo "<p>No categories found.</p>";
        }
        ?>
    </div>
</main>

<script>
    function navigateTo(category) {
        window.location.href = "consumer_subcategories.php?category=" + category;
    }
</script>

</body>
</html>