<?php
include "../config/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    // Fetch user from database
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ? AND user_type = ?");
    $stmt->bind_param("ss", $email, $user_type);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) { // Verify password
            $_SESSION['user_id'] = $id;
            $_SESSION['user_type'] = $user_type;

            // Redirect based on user type
            if ($user_type == "farmer") {
                header("Location: ../farmer/dashboard.php");
            } else {
                header("Location: ../consumer/dashboard.php");
            }
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }
    $stmt->close();
    $conn->close();
}
?>
