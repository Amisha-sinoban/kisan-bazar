<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'consumer') {
    header("Location: ../login.php");
    exit();
}
include "../config/db.php";

$result = $conn->query("SELECT users.name AS farmer_name, inventory.* FROM inventory JOIN users ON inventory.farmer_id = users.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consumer Home Page</title>
    <link rel="stylesheet" href="styles.css"> <!-- External CSS -->
    <script src="scripts.js" defer></script> <!-- External JavaScript -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="Untitled (2).png" alt="Logo" style="height: 130px;">
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
                    <li class="nav-item"><a class="nav-link" href="cart.php">🛒</a></li>
                    <li class="nav-item"><a class="nav-link" href="profile.php">👤</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Display Section -->
    <section id="about" class="container text-center mt-5 pt-5 section">
        <h1>Welcome to our Kisan Bazaar</h1>
        <div class="row align-items-center">
            <div class="col-md-6">
                <p>Your go-to marketplace for fresh farm produce directly from farmers!</p>
                <p>Welcome to our platform, a revolutionary solution connecting farmers directly with consumers. Our goal is to create a transparent and efficient supply chain, allowing farmers to showcase their inventory and sell their products without middlemen. Consumers can explore fresh produce, avail exciting deals, and place orders seamlessly.</p>
                <p>With user-friendly navigation, real-time offers, customer reviews, and tutorial videos, we ensure a smooth shopping experience. Additionally, we provide latest government schemes for farmers, keeping them informed about new opportunities.</p>
                <p>Join us in building a smarter, fairer, and more sustainable agricultural marketplace! 🚜🌿
                </p>
            </div>
            <div class="col-md-6 position-relative">
                <img src="th.jpeg" class="img-fluid" alt="Vegetables">
                <a href="order.php" class="btn btn-success mt-3">SHOP</a>
            </div>
        </div>
    </section>

    <!-- Offers Section -->
    <section id="offers" class="container text-center section">
        <h2>Offers and Deals</h2>
        <div class="offer-box">Buy 10 Kg Get 1 Kg Free</div>
        <div class="offer-box">Offer 2</div>
        <div class="offer-box">Offer 3</div>
    </section>
    
    <!-- Testimonials Section -->
    <section id="testimonials" class="container text-center mt-5 section">
        <h2>Testimonials</h2>
        <div class="testimonial-container">
            <div class="review active">“Great service and fresh produce!”</div>
            <div class="review">“Affordable and best quality!”</div>
            <div class="review">“Fast delivery, highly recommended!”</div>
            <div class="review">“Farm-fresh vegetables, great experience!”</div>
            <div class="review">“Best online farmers’ market ever!”</div>
        </div>
    </section>

    <!-- Tutorial Section -->
    <section id="tutorial" class="container text-center mt-5 section">
        <h2>Tutorial</h2>
        <iframe width="600" height="400" src="https://www.youtube.com/embed/dQw4w9WgXcQ" allowfullscreen></iframe>
    </section>

    <!-- Footer Section -->
    <div id="contact" class="mt-4 p-3 bg-light rounded text-center section contactus">
        <p>📞 Phone: +91 9876543210</p>
        <p>📧 Email: support@kisanbazaar.com</p>
        <p>📍 Address: 123 Greenfield, Agri Nagar, India</p>
        <button class="btn btn-custom text-white" onclick="alert('Thank you for reaching out! We will get back to you soon.')">Get in Touch</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//code.tidio.co/620t1rxpqz5xjxrzhji9czytijbzftcu.js" async></script>
</body>
</html>