<?php 
$pageTitle = 'Add Product';
include 'db.php';
// Initialize an empty array to store messages
$messages = array();

// Check if the form is submitted for adding a product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    // Retrieve product details from the form
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    // Insert product into the "mobiles" table
    $insert_product = mysqli_query($con, "INSERT INTO `mobiles` (name, price, image) VALUES ('$product_name', '$product_price', '$product_image')") or die(mysqli_error($conn));
    if ($insert_product) {
        // Product added successfully
        $messages[] = 'Product added successfully!';
    } else {
        // Error adding product
        $messages[] = 'Error adding product!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Product</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="product_name">Product Name:</label><br>
            <input type="text" id="product_name" name="product_name" required><br>

            <label for="product_price">Product Price:</label><br>
            <input type="text" id="product_price" name="product_price" required><br>

            <label for="product_image">Product Image URL:</label><br>
            <input type="text" id="product_image" name="product_image" required><br>

            <input type="submit" value="Add Product" name="add_product">
        </form>
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
    ?>
</body>
</html>


