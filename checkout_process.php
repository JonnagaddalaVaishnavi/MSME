<?php
session_start();
include('includes/config.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Get cart items for the user
$cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die(mysqli_error($conn));

if (mysqli_num_rows($cart_query) > 0) {
    while ($cart_item = mysqli_fetch_assoc($cart_query)) {
        $product_name = $cart_item['name'];
        $quantity = $cart_item['quantity'];
        $price = $cart_item['price'];
        $order_date = date('Y-m-d H:i:s');

        // Insert each cart item into the orders table
        $insert_order_query = "INSERT INTO `orders` (user_id, product_name, quantity, price, order_date) VALUES ('$user_id', '$product_name', '$quantity', '$price', '$order_date')";
        mysqli_query($conn, $insert_order_query) or die(mysqli_error($conn));
    }

    // Clear the cart after inserting into orders
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die(mysqli_error($conn));

    // Redirect to address page
    header('Location: address.php');
    exit();
} else {
    echo "No items in cart to checkout.";
}
?>
