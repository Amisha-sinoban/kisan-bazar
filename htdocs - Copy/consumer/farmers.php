<?php
session_start(); // Start session

// Redirect the user if they're not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get the logged-in user's ID
$loggedInUserId = $_SESSION['user_id'];

// Include database connection
include "../config/db.php";

// Check the connection
if (!$conn) {
    die("<div class='alert alert-danger'>Database connection failed: " . mysqli_connect_error() . "</div>");
}

// Get the category from URL
if (isset($_GET['category'])) {
    $category = $_GET['category'];

    // Query farmers and their inventory by category
    $query = "SELECT users.id AS farmer_id, users.name, users.email, 
                     inventory.id AS inventory_id, inventory.item_name, 
                     inventory.quantity, inventory.price
              FROM users 
              JOIN inventory ON users.id = inventory.farmer_id 
              WHERE users.user_type = 'farmer' AND inventory.category = ?";

    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("<div class='alert alert-danger'>Query preparation failed: " . $conn->error . "</div>");
    }

    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    die("<div class='alert alert-warning'>No category selected.</div>");
}

// Predefined locations (mock data)
$locations = ["Delhi", "Mumbai", "Chennai", "Kolkata", "Bangalore", "Hyderabad", "Pune", "Ahmedabad"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmers Offering <?php echo htmlspecialchars($category); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Inject PHP-Session User ID into JavaScript -->
    <script>
        const loggedInUserId = <?php echo json_encode($loggedInUserId); ?>;
    </script>

    <style>
        .farmer-card {
            width: calc(30% - 1.5rem);
            margin: 0.75rem;
            border: 1px solid #e0e0e0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .farmer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 992px) {
            .farmer-card {
                width: calc(45% - 1.5rem);
            }
        }

        @media (max-width: 576px) {
            .farmer-card {
                width: 100%;
            }
        }
    </style>
</head>

<body class="bg-light">

    <div class="container mt-5">
        <h2 class="text-center text-primary mb-4">
            Farmers Offering <?php echo htmlspecialchars($category); ?>
        </h2>

        <?php if ($result->num_rows > 0) { ?>
            <ul id="farmer-list" class="list-unstyled d-flex flex-wrap justify-content-center">
                <?php while ($row = $result->fetch_assoc()) {
                    $rating = rand(3, 5); // Random rating for farmers
                    $location = $locations[array_rand($locations)]; // Random location for mock-up
                ?>
                    <li class="farmer-card p-4 bg-white rounded">
                        <div class="farmer-info d-flex align-items-center mb-3">
                            <span class="farmer-name fw-bold"><?php echo htmlspecialchars($row['name']); ?></span>
                            <span class="ms-3 badge bg-success">⭐ <?php echo $rating; ?>/5</span>
                        </div>
                        <div class="farmer-details text-muted mb-3">
                            <span>📍 <?php echo htmlspecialchars($location); ?></span><br />
                            <span>📦 Quantity: <?php echo htmlspecialchars($row['quantity']); ?></span><br />
                            <span>💰 Price: ₹<?php echo htmlspecialchars($row['price']); ?></span>
                        </div>
                        <button class="btn btn-primary w-100" onclick="openPopup(
                            '<?php echo $row['item_name']; ?>',
                            '<?php echo $row['quantity']; ?>',
                            '<?php echo $row['price']; ?>',
                            'placeholder.jpg', // Replace with real image URL if applicable
                            '<?php echo $row['inventory_id']; ?>'
                        )">View Details</button>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <div class="alert alert-info text-center mt-4">
                No farmers found for this category.
            </div>
        <?php } ?>

        <div class="text-center mt-4">
            <a href="consumer_categories.php" class="btn btn-primary">Go Back</a>
        </div>
    </div>

    <!-- Modal Structure -->
    <div class="modal fade" id="popupModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Item Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="popupImage" src="" alt="Item Image" style="max-height: 300px; width: 100%;"><br>
                    <h3 id="popupItemName" class="mt-3"></h3>
                    <p><strong>Price per unit:</strong> ₹<span id="popupPrice"></span></p>

                    <label for="popupQuantityInput"><strong>Quantity:</strong></label>
                    <input type="number" id="popupQuantityInput" value="1" min="1" class="form-control w-50 mx-auto my-2"
                        oninput="updateTotal()">

                    <h5>Total: ₹<span id="popupTotal"></span></h5>

                    <button class="btn btn-success w-50" onclick="placeOrder()">Place Order</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentItemId = null;

        function openPopup(itemName, quantity, price, imageUrl, inventoryId) {
            currentItemId = inventoryId;

            document.getElementById("popupItemName").innerText = itemName;
            document.getElementById("popupPrice").innerText = price;
            document.getElementById("popupQuantityInput").value = 1;

            const popupModal = new bootstrap.Modal(document.getElementById('popupModal'));
            popupModal.show();
            updateTotal();
        }

        function updateTotal() {
            const quantity = parseInt(document.getElementById("popupQuantityInput").value) || 1;
            const price = parseFloat(document.getElementById("popupPrice").innerText);
            document.getElementById("popupTotal").innerText = (quantity * price).toFixed(2);
        }

        function placeOrder() {
            const quantity = parseInt(document.getElementById("popupQuantityInput").value);
            const price = parseFloat(document.getElementById("popupPrice").innerText);
            if (!quantity || quantity <= 0) return alert("Quantity must be greater than 0");

            fetch('add_to_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    user_id: loggedInUserId,
                    inventory_id: currentItemId,
                    quantity: quantity,
                    total_price: quantity * price
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) alert("Item added to cart!");
                else alert(data.error);
            })
            .catch(console.error);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>