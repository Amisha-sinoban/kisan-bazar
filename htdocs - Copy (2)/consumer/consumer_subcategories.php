<?php
include "../config/db.php"; // Ensure database connection is included

if (!isset($_GET['category'])) {
    die("Invalid category selection.");
}

$category = htmlspecialchars($_GET['category']);

// Define subcategories based on category
$subcategories = [
    'grainsList' => ['Wheat', 'Rice', 'Bajra'],
    'pulsesList' => ['Masoor', 'Moong', 'Kidney Beans'],
    'oilseedsList' => ['Sunflower', 'Mustard', 'Groundnut'],
    'fruitsList' => ['Apple', 'Banana', 'Guava'],
    'vegetablesList' => ['Onion', 'Potato', 'Tomato']
];

// Ensure the selected category exists in the array
if (!array_key_exists($category, $subcategories)) {
    die("Invalid category.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Subcategory</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        header {
            background-color: #28a745;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .subcategory {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 15px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .subcategory:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }
        .subcategory img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<header>
    <h1>Select a Subcategory</h1>
</header>

<main class="container my-4">
    <div class="row g-4">
        <?php
        foreach ($subcategories[$category] as $subcategory) {
            echo "
            <div class='col-md-4'>
                <div class='subcategory'>
                    <img src='images/$category.jpg' alt='$subcategory'>
                    <h2>$subcategory</h2>
                    <button class='btn btn-success' onclick='navigateTo(\"$category\", \"$subcategory\")'>Select</button>
                </div>
            </div>";
        }
        ?>
    </div>
</main>

<script>
    function navigateTo(category, subcategory) {
        window.location.href = "farmers.php?category=" + category + "&subcategory=" + subcategory;
    }
</script>

</body>
</html>