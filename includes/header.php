<?php
include 'includes/config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit;
}

if (isset($_GET['logout'])) {
    unset($_SESSION['user_id']);
    session_destroy();
    header('location:login.php');
    exit;
}

// Initialize $fetch_user to an empty array
$fetch_user = array();

if (isset($_POST['add_to_cart'])) {
    // Add to cart logic...
}

if (isset($_POST['update_cart'])) {
    // Update cart logic...
}

if (isset($_GET['remove'])) {
    // Remove item from cart logic...
}

if (isset($_GET['delete_all'])) {
    // Delete all items from cart logic...
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Millar'; ?> | Millar:)</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <style>
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: floralwhite;
        }

        .logo {
            font-size: 24px;
            color: black;
        }

        #Products {
            font-size: 18px;
            padding: 10px 20px;
            border-radius: 10px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            cursor: pointer;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '<div class="message" onclick="this.remove();">' . htmlspecialchars($msg) . '</div>';
        }
    }
    ?>

    <?php
    // Fetch user data only if user is logged in
    if (isset($user_id)) {
        $select_user = mysqli_query($conn, "SELECT * FROM `user_info` WHERE id = '$user_id'") or die(mysqli_error($conn));
        if (mysqli_num_rows($select_user) > 0) {
            $fetch_user = mysqli_fetch_assoc($select_user);
        }
    }
    ?>

    <header>
        <nav class="navbar">
            <div class="navbar-left">
                <h1 class="logo">Millar:)</h1>
            </div>

            <?php
            // Fetch the number of items in the cart from the database
            $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die(mysqli_error($conn));
            $cart_count = mysqli_num_rows($cart_query);
            ?>

            <div class="navbar-right">
                <a href="index.php">Home</a>
                <select name="Products" id="Products" required>
                    <option value="">Select Products</option>
                    <?php
                    // Define the products and their corresponding URLs
                    $products = [
                        'Mobiles' => 'mobile.php',
                        'Laptops' => 'laptops.php',
                        'Cables' => 'cabels.php',
                        'Tablets' => 'tablets.php'
                    ];
                    // Loop through the products and create options
                    foreach ($products as $productName => $productUrl) {
                        echo "<option value=\"$productUrl\">$productName</option>";
                    }
                    ?>
                </select>
                <a href="wishlist.php">Wishlist</a>
                <a href="cart.php">Cart(<?php echo $cart_count; ?>)</a>
                <a href="about.php">About</a>
                <a href="user.php">[<?php echo isset($fetch_user['username']) ? htmlspecialchars($fetch_user['username']) : ''; ?>]</a>
                <a href="index.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are you sure you want to LogOut?');" class="option-btn">LogOut</a>
            </div>
        </nav>
    </header>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('Products').addEventListener('change', function() {
            if (this.value) {
                location.href = this.value;
            }
        });
    });
    </script>
</body>
</html>
