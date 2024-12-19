<?php
session_start();

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'project';

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming $user_id is stored in session
$user_id = $_SESSION['user_id'];

// Get the order ID from the URL
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the order from the address table
$sql = "SELECT * FROM address WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

// Fetch product details from the cart table
$sqlCart = "SELECT * FROM cart WHERE user_id = ?";
$stmtCart = $conn->prepare($sqlCart);
$stmtCart->bind_param("i", $user_id);
$stmtCart->execute();
$resultCart = $stmtCart->get_result();
$cartItems = $resultCart->fetch_all(MYSQLI_ASSOC);

$grand_total = 0;
foreach ($cartItems as $item) {
    $grand_total += $item['price'] * $item['quantity'];
}

$stmt->close();
$stmtCart->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7fafc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 600px;
            width: 100%;
            height: auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            color: #000;
            font-size: 24px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .info div {
            font-size: 14px;
            color: #4a5568;
        }
        .info .value {
            font-weight: bold;
        }
        .info .status {
            color: rgb(63, 112, 202);
        }
        .products {
            margin-top: 20px;
        }
        .products table {
            width: 100%;
            border-collapse: collapse;
        }
        .products th, .products td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .products th {
            background-color: #f2f2f2;
        }
        .products tr:hover {
            background-color: #f5f5f5;
        }
        .total {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
            font-size: 16px;
            font-weight: bold;
        }
        .button {
            display: flex;
            justify-content: flex-end;
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
            <h2>Your Payment Receipt!</h2>
        </div>
        <?php if ($order !== null) { ?>
            <div class="section">
                <h3>Payment Information</h3>
                <div class="info">
                    <div>Order ID:</div>
                    <div class="value"><?php echo htmlspecialchars($order['id']); ?></div>
                </div>
                <div class="info">
                    <div>Paid Amount:</div>
                    <div class="value"><?php echo htmlspecialchars($grand_total); ?> ₹</div>
                </div>
                <div class="info">
                    <div>Payment Status:</div>
                    <div class="value status">Pending</div>
                </div>
            </div>
            <div class="section">
                <h3>Customer Information</h3>
                <div class="info">
                    <div>Email:</div>
                    <div class="value"><?php echo htmlspecialchars($order['email']); ?></div>
                </div>
                <div class="info">
                    <div>Phone:</div>
                    <div class="value"><?php echo htmlspecialchars($order['phone']); ?></div>
                </div>
                <div class="info">
                    <div>Address:</div>
                    <div class="value">
                        <?php echo htmlspecialchars($order['houseNo']) . ", " . htmlspecialchars($order['area']) . ", " . htmlspecialchars($order['city']) . ", " . htmlspecialchars($order['state']) . ", " . htmlspecialchars($order['landmark']); ?>
                    </div>
                </div>
            </div>
            <div class="section products">
                <h3>Product Details</h3>
                <table>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                    <?php 
                    foreach ($cartItems as $item) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($item['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($item['quantity']) . "</td>";
                        echo "<td>" . htmlspecialchars($item['price']) . " ₹</td>";
                        echo "</tr>";
                    } 
                    ?>
                </table>
                <div class="total">Total Amount: <?php echo $grand_total; ?> ₹</div>
            </div>
        <?php } else { ?>
            <p>No orders found.</p>
        <?php } ?>
        <div class="button">
            <a href="index.php">Continue Shopping</a>
        </div>
    </div>
</body>
</html>
