<?php
$pageTitle = 'Wishlist';

include 'includes/config.php';
include 'includes/header.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header('Location: login.php');
    exit();
}

// Get user ID
$user_id = $_SESSION['user_id'];

// Fetch wishlisted items for the current user
$select_wishlist = mysqli_query($conn, "SELECT mobiles.* FROM mobiles JOIN wishlist ON mobiles.id = wishlist.product_id WHERE wishlist.user_id = $user_id") or die(mysqli_error($conn));

?>

<body style="background-color: white;">
<div class="container">
    <div class="products"><br><br>
        <div class="box-container">
            <br>
            <?php
            if (mysqli_num_rows($select_wishlist) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_wishlist)) {
                    ?>
                    <div class="box">
                        <img src="<?php echo $fetch_product['image']; ?>" alt="">
                        <div class="name"><?php echo $fetch_product['name']; ?></div>
                        <div class="price">₹<?php echo $fetch_product['price']; ?>/-</div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No items found in the wishlist.</p>";
            }
            ?>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>
