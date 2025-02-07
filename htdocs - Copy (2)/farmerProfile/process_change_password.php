<?php
session_start();
include "../config/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];

    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($new_password !== $confirm_password) {
        header("Location: change_password.php?msg=Passwords do not match!&status=error");
        exit();
    }

    // Fetch current password from DB
    $query = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!password_verify($current_password, $user['password'])) {
        header("Location: change_password.php?msg=Incorrect current password!&status=error");
        exit();
    }

    // Securely hash new password
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    $updateQuery = "UPDATE users SET password = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $hashed_password, $user_id);

    if ($stmt->execute()) {
        header("Location: change_password.php?msg=Password changed successfully!&status=success");
    } else {
        header("Location: change_password.php?msg=Error updating password!&status=error");
    }
}