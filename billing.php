<?php
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

// Function to create tables if they don't exist
function createTablesIfNeeded($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS `payment` (
        `id` int(100) NOT NULL AUTO_INCREMENT,
        `user_id` int(100) NOT NULL,
        `amount` DECIMAL(10,2) NOT NULL,
        `status` ENUM('pending', 'success', 'cancelled') NOT NULL,
        `payment_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        FOREIGN KEY (`user_id`) REFERENCES `user_info`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
    );";

    if (!$conn->query($sql)) {
        die("Error creating table 'payment': " . $conn->error);
    }

    $sql = "CREATE TABLE IF NOT EXISTS `pay_upi` (
        `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `upi_id` VARCHAR(20) NOT NULL,
        `reg_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );";

    if (!$conn->query($sql)) {
        die("Error creating table 'pay_upi': " . $conn->error);
    }
}

// Function to fetch user information and their payment details
function getUserPaymentDetails($conn, $userId) {
    $sql = "SELECT u.id, u.firstname, u.email, p.amount, p.status, p.payment_date
            FROM user_info u
            JOIN payment p ON u.id = p.user_id
            WHERE u.id = $userId";

    $result = $conn->query($sql);

    if ($result === false) {
        die("Error fetching user payment details: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

// Function to fetch order details for the user
function getUserOrders($conn, $userId) {
    $sql = "SELECT o.product_name, o.quantity, o.price
            FROM orders o
            WHERE o.user_id = $userId";

    $result = $conn->query($sql);

    if ($result === false) {
        die("Error fetching user orders: " . $conn->error);
    }

    $orders = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    }
    return $orders;
}

// Check if tables exist, if not create them
createTablesIfNeeded($conn);

// Assuming the user ID is passed as a GET parameter
$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : 1; // Default user ID 1 for testing

$userDetails = getUserPaymentDetails($conn, $userId);
$userOrders = getUserOrders($conn, $userId);

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            color: #333;
        }
        .bill-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .user-details, .order-details {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>
<div class="bill-container">
    <h1>Bill</h1>
    <div class="user-details">
        <h2>User Details</h2>
        <?php if ($userDetails): ?>
            <p><strong>Name:</strong> <?php echo $userDetails['firstname']; ?></p>
            <p><strong>Email:</strong> <?php echo $userDetails['email']; ?></p>
            <p><strong>Amount Paid:</strong> $<?php echo number_format($userDetails['amount'], 2); ?></p>
            <p><strong>Payment Status:</strong> <?php echo ucfirst($userDetails['status']); ?></p>
            <p><strong>Payment Date:</strong> <?php echo $userDetails['payment_date']; ?></p>
        <?php else: ?>
            <p>No user details found.</p>
        <?php endif; ?>
    </div>

    <div class="order-details">
        <h2>Order Details</h2>
        <?php if ($userOrders): ?>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalAmount = 0;
                    foreach ($userOrders as $order):
                        $totalAmount += $order['price'] * $order['quantity'];
                    ?>
                        <tr>
                            <td><?php echo $order['product_name']; ?></td>
                            <td><?php echo $order['quantity']; ?></td>
                            <td>$<?php echo number_format($order['price'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2" class="total">Total</td>
                        <td>$<?php echo number_format($totalAmount, 2); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
