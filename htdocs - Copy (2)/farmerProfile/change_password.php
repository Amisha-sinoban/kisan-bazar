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
    <title>Change Password</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

    <div class="container">
        <aside class="sidebar">
            <h2><?= htmlspecialchars($username); ?></h2>
            <ul>
                <li onclick="window.location.href='dashboard.php'"><i class="fas fa-arrow-left"></i> Back to Dashboard</li>
            </ul>
        </aside>

        <main class="content">
            <h2>Change Password</h2>

            <?php if (isset($_GET['msg'])): ?>
                <p style="color: <?= $_GET['status'] === 'success' ? 'green' : 'red'; ?>;">
                    <?= htmlspecialchars($_GET['msg']); ?>
                </p>
            <?php endif; ?>

            <form action="process_change_password.php" method="POST">
                <label>Current Password</label>
                <input type="password" name="current_password" class="form-control" required>
                
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" required>
                
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" class="form-control" required>

                <button type="submit" class="btn btn-primary w-100 mt-3">Change Password</button>
            </form>
        </main>
    </div>

</body>
</html>