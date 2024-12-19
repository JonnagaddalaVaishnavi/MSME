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


<body style="background-color: white;">
<div class="container">

    <div class="products">


        <div class="box-container">

            <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products`") or die(mysqli_error($conn));
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
                    <div class="box">
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <img src="<?php echo $fetch_product['image']; ?>" alt="">
                            <div class="name"><?php echo $fetch_product['name']; ?></div>
                            <div class="price">₹<?php echo $fetch_product['price']; ?>/-</div>
                            <input type="number" min="1" name="product_quantity" value="1">
                            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                            <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                        </form>
                    </div>
            <?php
                }
            }
            ?>

        </div>

    </div>
</div>

<?php
include 'includes/footer.php';
?>
