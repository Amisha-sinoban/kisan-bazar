<?php
include "../config/db.php"; // Ensure database connection is included

// Fetch distinct categories with one image per category
$query = "SELECT category, MAX(img_url) as img_url FROM inventory GROUP BY category";
$result = $conn->query($query);

// Handle query failure
if (!$result) {
    die("SQL Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Categories</title>
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
            padding: 25px 10px;
            margin-bottom: 20px;
        }

        .category {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
            text-align: center;
            padding: 20px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .category:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .category img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .category h2 {
            font-size: 20px;
            margin-top: 15px;
        }

        .category .btn {
            margin-top: 10px;
            width: 80%;
            font-size: 16px;
        }
    </style>
</head>
<body>

<header>
    <h1>Choose a Product Category</h1>
</header>

<main class="container my-4">
    <div class="row g-4">
        <?php
        // Check if there are any results before loop
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $category = htmlspecialchars($row['category']);
                $imgUrl = !empty($row['img_url']) ? htmlspecialchars($row['img_url']) : 'images/default.jpg'; // Default image if none exists

                echo "
                <div class='col-md-4'>
                    <div class='category'>
                        <img src='$imgUrl' alt='$category'>
                        <h2>" . ucfirst(str_replace("List", "", $category)) . "</h2>
                        <button class='btn btn-success' onclick='navigateTo(\"$category\")'>Select</button>
                    </div>
                </div>";
            }
        } else {
            echo "<p class='text-center'>No categories found.</p>";
        }
        ?>
    </div>
</main>

<script>
    function navigateTo(category) {
        window.location.href = "subcategories.php?category=" + category;
    }
</script>

</body>
</html>