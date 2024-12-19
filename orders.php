<?php
$pageTitle = 'My Orders';

include 'includes/config.php';
include 'includes/header.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header('Location: login.php');
    exit();
}

// Get the user ID
$user_id = $_SESSION['user_id'];

// Fetch orders for the current user
$order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id' ORDER BY order_date DESC") or die(mysqli_error($conn));

?>

<div class="orders-container" style="background-color:white; padding: 20px;">
    <h1 class="heading">My Orders</h1>

    <table style="width: 100%;">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($order_query) > 0) {
                while ($fetch_order = mysqli_fetch_assoc($order_query)) {
            ?>
                    <tr>
                        <td><?php echo $fetch_order['id']; ?></td>
                        <td><?php echo $fetch_order['product_name']; ?></td>
                        <td><?php echo $fetch_order['quantity']; ?></td>
                        <td>₹<?php echo $fetch_order['price']; ?>/-</td>
                        <td><?php echo $fetch_order['order_date']; ?></td>
                    </tr>
            <?php
                }
            } else {
                echo '<tr><td colspan="5" style="text-align: center;">No orders placed yet.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php
include 'includes/footer.php';
?>
