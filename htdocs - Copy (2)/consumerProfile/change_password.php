<?php
session_start();
include "../config/db.php"; // Database Connection

// Redirect user if they are not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container mt-5">
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
    </div>

</body>
</html>