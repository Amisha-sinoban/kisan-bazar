<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'farmer') {
    header("Location: ../signup.php");
    exit();
}
include "../config/db.php";

$farmer_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('https://th.bing.com/th/id/OIP.alsJKnrid9ShCSp4eeITbAEsDG?rs=1&pid=ImgDetMain') no-repeat center center fixed;
            background-size: cover;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Slight dark overlay for better text readability */
        }
        .container {
            max-width: 800px;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            position: relative;
            z-index: 2;
        }
        .order {
            border-radius: 8px;
            padding: 15px;
            background: #fff;
            margin-bottom: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .order-icon {
            font-size: 25px;
            margin-right: 10px;
            color: #28a745;
        }
        .order-info {
            flex-grow: 1;
        }
        .btn-complete {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
        }
        .btn-complete:disabled {
            background-color: gray;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<div class="overlay"></div>

<div class="container">
    <h2 class="text-center mb-4 text-success"><i class="fas fa-tractor"></i> Farmer Orders</h2>

    <h4 class="text-success"><i class="fas fa-spinner"></i> Ongoing Orders</h4>
    <div id="ongoing-orders" class="order-container"></div>

    <h4 class="text-secondary mt-4"><i class="fas fa-check-circle"></i> Completed Orders</h4>
    <div id="completed-orders" class="order-container"></div>
</div>

<script>
    function fetchOrders() {
        $.get("farmerorder.php", function(data) {
            let orders;
            try {
                orders = JSON.parse(data);
            } catch (error) {
                console.error("Invalid JSON:", data);
                return;
            }

            if (orders.error) {
                alert("You need to log in first.");
                window.location.href = "signup.php";
                return;
            }

            let ongoingHTML = "", completedHTML = "";

            orders.forEach(order => {
                let orderHTML = `
                    <div class='order d-flex align-items-center'>
                        <i class="fas fa-box-open order-icon"></i>
                        <div class='order-info'>
                            <strong>${order.item_name} (${order.quantity}) - ₹${order.price}</strong>
                        </div>
                        <button class='btn btn-complete' onclick='completeOrder(${order.id})' ${order.status === "done" ? "disabled" : ""}>
                            <i class="fas fa-check"></i> Complete
                        </button>
                    </div>`;

                if (order.status === "ongoing") {
                    ongoingHTML += orderHTML;
                } else if (order.status === "done") {
                    completedHTML += orderHTML;
                }
            });

            $("#ongoing-orders").html(ongoingHTML);
            $("#completed-orders").html(completedHTML);
        });
    }

    function completeOrder(orderId) {
        $.post("update_order.php", { order_id: orderId }, function(response) {
            let result;
            try {
                result = JSON.parse(response);
            } catch (error) {
                console.error("Invalid JSON:", response);
                return;
            }

            if (result.success) {
                fetchOrders();
            } else {
                alert("Failed to update order.");
            }
        });
    }

    fetchOrders(); // Load orders when page loads
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
