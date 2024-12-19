<?php
session_start();
include('db.php');

// Ensure database connection is established
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// SQL query to fetch user order data
$sql = "SELECT orders.id AS order_id, user_info.firstname, user_info.lastname, user_info.email, 
        orders.product_name, orders.quantity, orders.price, orders.order_date 
        FROM orders 
        JOIN user_info ON orders.user_id = user_info.id";

$result = $con->query($sql);

// Check for SQL errors
if ($result === false) {
    die("Error: " . $con->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page - User Orders</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7fafc;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }
        .container {
            max-width: 1000px;
            width: 100%;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            text-align: center;
            background-color: #4a5568;
            color: #fff;
            padding: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .no-orders {
            text-align: center;
            padding: 20px;
            font-size: 18px;
            color: #666;
        }
        .button {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .button a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #4a5568;
            color: #fff;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .button a:hover {
            background-color: #2c5282;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>User Orders</h2>
    </div>
    <div class="content">
        <table>
            <tr>
                <th>Order ID</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Order Date</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    // Calculate total price
                    $total_price = $row["quantity"] * $row["price"];
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["order_id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["firstname"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["lastname"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["product_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["quantity"]) . "</td>";
                    echo "<td>₹" . htmlspecialchars($total_price) . "</td>";
                    echo "<td>" . htmlspecialchars($row["order_date"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8' class='no-orders'>No orders found</td></tr>";
            }
            $con->close();
            ?>
        </table>
    </div>
</div>

</body>
</html>
