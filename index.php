<?php

$pageTitle = 'Home';

include 'includes/config.php';
include 'includes/header.php';

// Check if the add to cart form is submitted
if (isset($_POST['add_to_cart'])) {
    // Retrieve product details from the form
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Check if the product is already in the cart
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die(mysqli_error($conn));

        if (mysqli_num_rows($select_cart) > 0) {
            // Product already exists in the cart
            $message[] = 'Product already added to cart!';
        } else {
            // Insert product into the cart
            $insert_cart = mysqli_query($conn, "INSERT INTO `cart` (user_id, name, price, image, quantity) VALUES ('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die(mysqli_error($conn));
            if ($insert_cart) {
                // Product added successfully
                $message[] = 'Product added to cart!';
            } else {
                // Error adding product to cart
                $message[] = 'Error adding product to cart!';
            }
        }
    } else {
        // User is not logged in, redirect to login page
        header('Location: login.php');
        exit();
    }
}
?>

<div class="banner" style="background-image: url('images/Banner_new.jpg');">
    <div class="content">
        <h2 style="color: black;">Millar:)</h2>
        <p style="color: black;">
            Visit Mobile Store today and embark on a journey into the world of mobile technology, where innovation meets service, and your satisfaction is our commitment.
        </p>
        <a href="mobile.php" class="btn">shop now</a>
    </div>
</div>
<?php
include 'includes/footer.php';
?>
