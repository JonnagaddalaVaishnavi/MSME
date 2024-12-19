<?php
include 'includes/config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit; // Add exit after header redirect
}

if (isset($_GET['logout'])) {
    unset($_SESSION['user_id']); // Unset the session variable
    session_destroy();
    header('location:login.php');
    exit; // Add exit after header redirect
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
    <title><?php echo $pageTitle; ?> | Millar:)</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <style>
        /* Add any necessary CSS styles here */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: floralwhite;
        }

        .navbar-left {
            /* Adjust logo styles */
        }

        .navbar-right {
            /* Adjust other navbar items styles */
        }

        .logo {
            /* Adjust logo styles */
            font-size: 24px;
            color: black;
            /* Make sure the color is visible on the background */
        }

        /* Custom styles for the dropdown */
        #Products {
            font-size: 18px; /* Adjust font size */
            padding: 10px 20px; /* Adjust padding */
            border-radius: 10px; /* Adjust border radius */
            background-color: #f0f0f0; /* Adjust background color */
            border: 1px solid #ccc; /* Adjust border */
            cursor: pointer;
            margin-right: 10px; /* Adjust margin for spacing */
        }
    </style>
</head>

<body>
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '<div class="message" onclick="this.remove();">' . $message . '</div>';
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
                <select id="Products" name="Products" onchange="location = this.value;">
                    <option value="">Products</option>
                    <option value="mobile.php">Mobiles</option>
                    <option value="watches.php">Watches</option>
                    <option value="laptop.php">Laptops</option>
                </select>
                <a href="cart.php">Cart(<?php echo $cart_count; ?>)</a>
                <a href="about.php">About</a>
                <!-- Access $fetch_user['username'] only if $fetch_user is set -->
                <a href="user.php">[<?php echo isset($fetch_user['username']) ? $fetch_user['username'] : ''; ?>]</a>
                <a href="index.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are you sure you want to LogOut?');" class="option-btn">LogOut</a>
            </div>
        </nav>
    </header>
</body>
</html>
