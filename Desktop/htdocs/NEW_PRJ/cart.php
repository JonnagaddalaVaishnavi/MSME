<?php

$pageTitle = 'Cart';

include 'includes/config.php';
include 'includes/header.php';

// Check if the form is submitted for updating cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_cart'])) {
    // Get the cart id and updated quantity
    $cart_id = $_POST['cart_id'];
    $updated_quantity = $_POST['cart_quantity'];

    // Update the quantity in the cart table
    $update_query = mysqli_query($conn, "UPDATE `cart` SET `quantity` = '$updated_quantity' WHERE `id` = '$cart_id'") or die(mysqli_error($conn));

    if ($update_query) {
        // Redirect to refresh the page
        header("Location: cart.php");
        exit();
    } else {
        echo "Error updating cart.";
    }
}

// Check if the item needs to be removed from the cart
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];

    // Delete the item from the cart table
    $delete_query = mysqli_query($conn, "DELETE FROM `cart` WHERE `id` = '$remove_id'") or die(mysqli_error($conn));

    if ($delete_query) {
        // Redirect to refresh the page
        header("Location: cart.php");
        exit();
    } else {
        echo "Error removing item from cart.";
    }
}

?>

<div class="shopping-cart" style="background-color:white;">

    <h1 class="heading">Shopping Cart</h1>

    <table>
        <thead>
            <th>image</th>
            <th>name</th>
            <th>price</th>
            <th>quantity</th>
            <th>total price</th>
            <th>action</th>
        </thead>
        <tbody>
            <?php
            $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die(mysqli_error($conn));
            $grand_total = 0;
            if (mysqli_num_rows($cart_query) > 0) {
                while ($fetch_cart = mysqli_fetch_assoc($cart_query)) {
            ?>
                    <tr>
                        <td>
                            <img src="<?php echo $fetch_cart['image']; ?>" alt="">
                        </td>
                        <td><?php echo $fetch_cart['name']; ?></td>
                        <td>₹<?php echo $fetch_cart['price']; ?>/-</td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="cart_id" value="<?php echo $fetch_cart['id']; ?>">
                                <input type="number" min="1" name="cart_quantity" value="<?php echo $fetch_cart['quantity']; ?>">
                                <input type="submit"  name="update_cart" value="update" class="option-btn">
                            </form>
                        </td>
                        <td>₹<?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</td>
                        <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" class="option-btn" onclick="return confirm('Remove item from Cart?');">remove</a></td>
                    </tr>
            <?php
                    $grand_total += $sub_total;
                }
            } else {
                echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">no item added</td></tr>';
            }
            ?>
            <tr class="table-bottom">
                <td colspan="4">Total Price :</td>
                <td>₹<?php echo $grand_total; ?>/-</td>
                <td><a href="cart.php?delete_all" onclick="return confirm('Delete all from Cart?');" class="option-btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">delete all</a></td>
            </tr>
        </tbody>
    </table>

    <div class="cart-btn">
        <a href="address.php" class="option-btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">Proceed To Checkout</a>
    </div>

</div>

<?php
include 'includes/footer.php';
?>
