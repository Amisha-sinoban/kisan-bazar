<?php
session_start();
include "../config/db.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if the user is not logged in
    exit;
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch cart items for the logged-in user, including farmer name
$query = "
    SELECT 
        cart.id AS cart_id,
        inventory.item_name,
        inventory.price AS item_price,
        cart.quantity,
        cart.total_price,
        users.name AS farmer_name 
    FROM cart
    JOIN inventory ON cart.inventory_id = inventory.id
    JOIN users ON inventory.farmer_id = users.id -- Link inventory to farmers
    WHERE cart.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Prepare cart items array
$cartItems = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }
}

// Calculate order totals
$subtotal = array_sum(array_column($cartItems, 'total_price'));
$shipping = $subtotal > 0 ? 50 : 0; // Platform fee (Shipping)
$logistics = $subtotal > 0 ? 30 : 0; // Logistics costs
$total = $subtotal + $shipping + $logistics;

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffffb6; 
            margin-top: 130px; 
        }

        .navbar {
            background: rgb(141, 211, 134);
            padding: 10px 20px;
            height: 100px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
        }

        .navbar-nav .nav-link {
            color: rgb(0, 0, 0);
        }

        .navbar-nav .nav-link:hover {
            color: #150c0c;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="simple_elegant_green_logo_for_Kisan_Bazar-removebg-preview[1].png" alt="Logo" style="height: 80px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#order">Order</a></li>
                <li class="nav-item"><a class="nav-link" href="#testimonials">Testimonials</a></li>
                <li class="nav-item"><a class="nav-link" href="#tutorial">Tutorial</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart" style="color: #000000; font-size: 22px;"></i></a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php">👤</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Cart Section -->
<div class="container mt-5">
    <h1 class="fw-bold">Your Cart</h1>

    <div class="row">
        <!-- Cart Items -->
        <div class="col-md-8">
            <?php if (!empty($cartItems)) { ?>
                <?php foreach ($cartItems as $item): ?>
                    <div class="card mb-3 p-3 d-flex align-items-center">
                        <img src="placeholder.jpg" class="rounded" width="80" alt="Product Image">
                        <div class="ms-3 flex-grow-1">
                            <h5 class="mb-1"><?php echo htmlspecialchars($item['item_name']); ?></h5>
                            <p class="text-muted mb-1">Farmer: <?php echo htmlspecialchars($item['farmer_name']); ?></p>
                            <span class="text-success">₹<?php echo number_format($item['item_price'], 2); ?> / unit</span>
                        </div>
                        <input type="number" class="form-control w-25" value="<?php echo $item['quantity']; ?>" min="1" disabled>
                        <h5 class="ms-3">₹<?php echo number_format($item['total_price'], 2); ?></h5>
                        <form method="POST" action="remove_cart_item.php" class="ms-3">
                            <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php } else { ?>
                <div class="alert alert-info text-center">Your cart is empty. <a href="farmers.php">Go back to shopping</a>.</div>
            <?php } ?>
        </div>

        <!-- Order Summary -->
        <div class="col-md-4">
            <div class="card p-3">
                <h4 class="fw-bold">Order Summary</h4>
                <p>Subtotal: <span class="float-end">₹<?php echo number_format($subtotal, 2); ?></span></p>
                <p>Platform Fee: <span class="float-end">₹<?php echo number_format($shipping, 2); ?></span></p>
                <p>Logistics: <span class="float-end">₹<?php echo number_format($logistics, 2); ?></span></p>
                <hr>
                <h5 class="fw-bold">Total: <span class="float-end">₹<?php echo number_format($total, 2); ?></span></h5>
                <a href="javascript:void(0);" onclick="placeOrder()" class="btn btn-primary w-100 mt-3">Place Order</a>            </div>
        </div>
    </div>
</div>
<script>
    function placeOrder() {
    if (!confirm("Are you sure you want to place your order?")) {
        return; // Exit if user cancels
    }

    fetch('place_order.php', { 
        method: 'POST',
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message); // Display success message
            window.location.href = "orders.php"; // Redirect to orders page
        } else {
            alert(data.error); // Display error message
        }
    })
    .catch(error => console.error("Error placing order:", error));
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>