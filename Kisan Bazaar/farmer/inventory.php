<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'farmer') {
    header("Location: ../login.php");
    exit();
}
include "../config/db.php";

$farmer_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM inventory WHERE farmer_id = $farmer_id");
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="style.css">
    <!-- <link rel="stylesheet" href="styles.css"> -->
</head>

<body>
<div class="background-image"></div>
    <nav class="top-nav" id="topnavi">
        <div id="logo">
            <img src="logoKisan.png" alt="Kisan Bazar"></div>
        <a href="#about">About</a>
        <a href="#FAQ">FAQ</a>
        <div class="dropdown">
            <a href="#profile" id="profile-icon"><i class="fa-solid fa-user"></i></a>
            <ul class="dropdown-content">
                <li><div class="translate-container">
                  <div id="google_translate_element"></div>
              </div></li>
                <li><a href="#profile">Profile</a></li>
                <li><a href="../auth/logout.php">Logout</a></li>
                <li><a href="#darkMode">Dark Mode</a></li>
            </ul>
        </div>
    </nav>

    <nav class="side-nav" id="sideNav">
    <a href="javascript:void(0)" class="closebtn" onclick="toggleNav()">&times;</a>
        <a href="/farmer/inventory.php">Inventory</a>
        <a href="#Orders">Orders</a>
        <a href="#GovtSc">Govt. Schemes</a>
        <a href="#Buy">Buy</a>
        <a href="#Profile">Profile</a>

    </nav>
    <div>
        <nav class="top-nav" id="topnavi">
            <div id="logo">
                <img src="logoKisan.png" alt="Kisan Bazar">
            </div>
            <a href="#about">About</a>
            <a href="#FAQ">FAQ</a>
            <div class="dropdown">
                <a href="#profile" id="profile-icon"><i class="fa-solid fa-user"></i></a>
                <ul class="dropdown-content">
                    <li><a href="#profile">Profile</a></li>
                    <li><a href="#logout">Logout</a></li>
                    <li><a href="#darkMode">Dark Mode</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <nav class="side-nav">
        <a href="#Inventory">Inventory</a>
        <a href="#Orders">Orders</a>
        <a href="#GovtSc">Govt. Schemes</a>
        <a href="#Buy">Buy</a>
        <a href="#Profile">Profile</a>

    </nav>
    <h1>Farmer Inventory</h1>
    <a href="../auth/logout.php">Logout</a>

    <div class="form-container">
        <input type="text" id="itemName" placeholder="Enter item name">
        <input type="number" id="itemQuantity" placeholder="Enter quantity">
        <input type="number" id="itemPrice" placeholder="Enter price">
        <select id="itemCategory">
            <option value="grainsList">Food Grains/Cereals</option>
            <option value="pulsesList">Pulses/Legumes</option>
            <option value="oilseedsList">Oilseeds</option>
            <option value="fruitsList">Fruits</option>
            <option value="vegetablesList">Vegetables</option>
        </select>
        <button onclick="addItem()">Add Item</button>
    </div>

    <input type="text" id="search" placeholder="Search items..." onkeyup="searchItem()">

    <div class="category-container" id="categories"></div>
    </div>
    <div class="toast" id="toast">Item added successfully!</div>

    <script src="script.js"></script>

    <!-- <h2>Your Inventory</h2> -->

    <table border="1">


        <tr>
            <th>Item</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['item_name'] ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= $row['price'] ?></td>
            </tr>
            <!-- <div class="container"> -->
            <!-- <h1>Inventory Management</h1> -->


        <?php endwhile; ?>
        <h1>Inventory Management</h1>


    </table>
</body>
</html>
