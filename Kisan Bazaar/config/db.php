<?php
$host = "localhost";
$user = "root"; // Change if you use another username
$pass = ""; // Change if you set a password
$db = "farm_system";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
