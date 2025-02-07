<?php
session_start();
include "../config/db.php"; // Database Connection

// Redirect user if they are not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch Farmer Details
$queryUser = "SELECT name FROM users WHERE id = ?";
$stmtUser = $conn->prepare($queryUser);
$stmtUser->bind_param("i", $user_id);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$user = $resultUser->fetch_assoc();
$username = $user['name'] ?? "Farmer";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

    <div class="container">
        <aside class="sidebar">
            <h2><?= htmlspecialchars($username); ?></h2>
            <ul>
                <li onclick="window.location.href='../auth/logout.php'"><i class="fas fa-sign-out-alt"></i> Logout</li>
                <li onclick="window.location.href='change_password.php'"><i class="fas fa-key"></i> Change Password</li>
                <li onclick="loadPage('reviews')"><i class="fas fa-star"></i> Reviews</li>
                <li class="active"><i class="fas fa-history"></i> Transaction History</li>
                <li onclick="loadPage('income')"><i class="fas fa-chart-line"></i> Monthly Income</li>
            </ul>
        </aside>

        <main class="content">
            <h2>Transaction History</h2>

            <!-- Retained Transaction History -->
            <div class="transaction-card">
                <i class="fas fa-info-circle info-icon"></i>
                <div class="transaction-details">
                    <h3>Wheat</h3>
                    <p><strong>Price:</strong> ₹500</p>
                    <p><strong>Quantity:</strong> 1kg</p>
                    <p><strong>Delivery Date:</strong> 3 February, 2025</p>
                    <p><strong>Retailer:</strong> Amisha Singh</p>
                </div>
                <i class="fas fa-phone call-icon"></i>
            </div>

            <div class="transaction-card">
                <i class="fas fa-info-circle info-icon"></i>
                <div class="transaction-details">
                    <h3>Spinach</h3>
                    <p><strong>Price:</strong> ₹250</p>
                    <p><strong>Quantity:</strong> 1kg</p>
                    <p><strong>Delivery Date:</strong> 1 February, 2025</p>
                    <p><strong>Retailer:</strong> Deepanshi Goyal</p>
                </div>
                <i class="fas fa-phone call-icon"></i>
            </div>
        </main>
    </div>

</body>
</html>