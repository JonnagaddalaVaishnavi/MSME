<?php
$pageTitle = 'Admin';

include 'includes/config.php';
include 'includes/header.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    // User is not an admin, redirect to home page
    header('Location: index.php');
    exit();
}

// Handle add product form submission
if (isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $insert_product = mysqli_query($conn, "INSERT INTO `products` (name, price, image, quantity) VALUES ('$product_name', '$product_price', '$product_image', '$product_quantity')") or die(mysqli_error($conn));

    if ($insert_product) {
        $message[] = 'Product added successfully!';
    } else {
        $message[] = 'Error adding product!';
    }
}

// Handle update product form submission
if (isset($_POST['update_product'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $update_product = mysqli_query($conn, "UPDATE `products` SET name='$product_name', price='$product_price', image='$product_image', quantity='$product_quantity' WHERE id='$product_id'") or die(mysqli_error($conn));

    if ($update_product) {
        $message[] = 'Product updated successfully!';
    } else {
        $message[] = 'Error updating product!';
    }
}

// Handle delete product form submission
if (isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];

    $delete_product = mysqli_query($conn, "DELETE FROM `products` WHERE id='$product_id'") or die(mysqli_error($conn));

    if ($delete_product) {
        $message[] = 'Product deleted successfully!';
    } else {
        $message[] = 'Error deleting product!';
    }
}

// Fetch all products from the database
$select_products = mysqli_query($conn, "SELECT * FROM `products`") or die(mysqli_error($conn));
?>

<div class="admin-page">
    <h1>Admin Page</h1>

    <?php if (isset($message)) {
        foreach ($message as $msg) {
            echo '<div class="message">'.$msg.'</div>';
        }
    } ?>

    <h2>Add Product</h2>
    <form action="" method="post">
        <input type="text" name="product_name" placeholder="Product Name" required>
        <input type="text" name="product_price" placeholder="Product Price" required>
        <input type="text" name="product_image" placeholder="Product Image URL" required>
        <input type="number" name="product_quantity" placeholder="Product Quantity" required>
        <input type="submit" name="add_product" value="Add Product">
    </form>

    <h2>Update Product</h2>
    <form action="" method="post">
        <select name="product_id" required>
            <option value="" disabled selected>Select Product to Update</option>
            <?php while ($row = mysqli_fetch_assoc($select_products)) { ?>
                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
            <?php } ?>
        </select>
        <input type="text" name="product_name" placeholder="New Product Name" required>
        <input type="text" name="product_price" placeholder="New Product Price" required>
        <input type="text" name="product_image" placeholder="New Product Image URL" required>
        <input type="number" name="product_quantity" placeholder="New Product Quantity" required>
        <input type="submit" name="update_product" value="Update Product">
    </form>

    <h2>Delete Product</h2>
    <form action="" method="post">
        <select name="product_id" required>
            <option value="" disabled selected>Select Product to Delete</option>
            <?php
            mysqli_data_seek($select_products, 0); // Reset pointer to fetch products again
            while ($row = mysqli_fetch_assoc($select_products)) { ?>
                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
            <?php } ?>
        </select>
        <input type="submit" name="delete_product" value="Delete Product">
    </form>

    <h2>All Products</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            <?php
            mysqli_data_seek($select_products, 0); // Reset pointer to fetch products again
            while ($row = mysqli_fetch_assoc($select_products)) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['price'] ?></td>
                    <td><img src="<?= $row['image'] ?>" alt="<?= $row['name'] ?>" width="50"></td>
                    <td><?= $row['quantity'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
include 'includes/footer.php';
?>
