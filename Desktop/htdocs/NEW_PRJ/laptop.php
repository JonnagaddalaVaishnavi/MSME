<?php
$pageTitle = 'Home';

include 'includes/config.php';
include 'includes/header.php';



// Check if the form is submitted for adding to cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    // Retrieve product details from the form
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Insert product into the cart
        $insert_cart = mysqli_query($conn, "INSERT INTO `cart` (user_id, name, price, image, quantity) VALUES ('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die(mysqli_error($conn));
        if ($insert_cart) {
            // Product added successfully
            $message = 'Product added to cart!';
        } else {
            // Error adding product to cart
            $message = 'Error adding product to cart!';
        }
    } else {
        // User is not logged in, redirect to login page
        header('Location: login.php');
        exit();
    }
}


?>
<body style="background-color:white;"></body>