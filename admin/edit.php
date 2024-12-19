<?php
include 'db.php'; // Added missing semicolon

// Initialize an empty array to store messages
$messages = array();

// Check if the form is submitted for deleting a product
if (isset($_GET['delete_product'])) {
    $product_id = $_GET['delete_product'];
    $delete_product = mysqli_query($con, "DELETE FROM `mobiles` WHERE id = '$product_id'") or die(mysqli_error($con));
    if ($delete_product) {
        // Product deleted successfully
        $messages[] = 'Product deleted successfully!';
    } else {
        // Error deleting product
        $messages[] = 'Error deleting product!';
    }
}

// Check if the form is submitted for updating a product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_product'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    $update_product = mysqli_query($con, "UPDATE `mobiles` SET name = '$product_name', price = '$product_price', image = '$product_image' WHERE id = '$product_id'") or die(mysqli_error($con));
    if ($update_product) {
        // Product updated successfully
        $messages[] = 'Product updated successfully!';
    } else {
        // Error updating product
        $messages[] = 'Error updating product!';
    }
}

// Retrieve product details for editing
if (isset($_GET['edit_product'])) {
    $product_id = $_GET['edit_product'];
    $product_result = mysqli_query($con, "SELECT * FROM `mobiles` WHERE id = '$product_id'") or die(mysqli_error($con));
    $product_data = mysqli_fetch_assoc($product_result);
}

// Retrieve unique products from the "mobiles" table
$products = mysqli_query($con, "SELECT * FROM `mobiles` GROUP BY `name`") or die(mysqli_error($con));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            background-color: #dff0d8;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            color: #155724;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .edit-btn, .delete-btn {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        .delete-btn {
            background-color: #dc3545;
        }
        .edit-btn:hover {
            background-color: #218838;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <?php
    // Display messages
    if (!empty($messages)) {
        echo '<div class="message">';
        foreach ($messages as $msg) {
            echo htmlspecialchars($msg) . '<br>';
        }
        echo '</div>';
    }
    ?>

    <div class="container">
        <h1>Product List</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($products)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                echo "<td><img src='" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['name']) . "' style='width: 50px; height: 50px;'></td>";
                echo "<td>
                        <a href='?edit_product=" . htmlspecialchars($row['id']) . "' class='edit-btn'>Edit</a>
                        <a href='?delete_product=" . htmlspecialchars($row['id']) . "' class='delete-btn'>Delete</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <?php if (isset($_GET['edit_product'])): ?>
    <div class="container">
        <h1>Edit Product</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_data['id']); ?>">

            <label for="product_name">Product Name:</label><br>
            <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product_data['name']); ?>" required><br>

            <label for="product_price">Product Price:</label><br>
            <input type="text" id="product_price" name="product_price" value="<?php echo htmlspecialchars($product_data['price']); ?>" required><br>

            <label for="product_image">Product Image URL:</label><br>
            <input type="text" id="product_image" name="product_image" value="<?php echo htmlspecialchars($product_data['image']); ?>" required><br>

            <input type="submit" value="Update Product" name="update_product">
        </form>
    </div>
    <?php endif; ?>
</body>
</html>
