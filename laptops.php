<?php 
$pageTitle = 'Home';

include 'includes/config.php';
include 'includes/header.php';

// Initialize an empty array to store messages
$messages = array();

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
            $messages[] = 'Product added to cart!';
        } else {
            // Error adding product to cart
            $messages[] = 'Error adding product to cart!';
        }
    } else {
        // User is not logged in, redirect to login page
        header('Location: login.php');
        exit();
    }
}

// Check if the form is submitted for adding to wishlist
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_wishlist'])) {
    // Retrieve product details from the form
    $product_id = $_POST['product_id'];

    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Check if the product is already in the wishlist
        $check_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = '$user_id' AND product_id = '$product_id'");
        if (mysqli_num_rows($check_wishlist) > 0) {
            // Product already in wishlist, remove it
            $delete_wishlist = mysqli_query($conn, "DELETE FROM `wishlist` WHERE user_id = '$user_id' AND product_id = '$product_id'");
            if ($delete_wishlist) {
                $messages[] = 'Product removed from wishlist!';
            } else {
                $messages[] = 'Error removing product from wishlist!';
            }
        } else {
            // Insert product into the wishlist
            $insert_wishlist = mysqli_query($conn, "INSERT INTO `wishlist` (user_id, product_id) VALUES ('$user_id', '$product_id')") or die(mysqli_error($conn));
            if ($insert_wishlist) {
                // Product added successfully
                $messages[] = 'Product added to wishlist!';
            } else {
                // Error adding product to wishlist
                $messages[] = 'Error adding product to wishlist!';
            }
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
    <div class="products"><br><br>
        <div class="box-container">
            <?php
            $select_product = mysqli_query($conn, "SELECT DISTINCT * FROM `laptops`") or die(mysqli_error($conn));
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
                            <input type="hidden" name="product_id" value="<?php echo $fetch_product['id']; ?>">
                            <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                            <button type="submit" name="add_to_wishlist" class="wishlist-btn" style="background:none;border:none;">
                                <img src="images/wishlist_icon.png" alt="Add to Wishlist" style="width:24px;height:24px;">
                            </button>
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
// Display messages
if (!empty($messages)) {
    echo '<div class="message">';
    foreach ($messages as $msg) {
        echo htmlspecialchars($msg) . '<br>';
    }
    echo '</div>';
}
include 'includes/footer.php';
?>
</body>
</html>
