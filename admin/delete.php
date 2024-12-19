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

// Retrieve all products from the "mobiles" table
$products = mysqli_query($con, "SELECT * FROM `mobiles`") or die(mysqli_error($con));
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
        .delete-btn {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
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
                echo "<td><a href='?delete_product=" . htmlspecialchars($row['id']) . "' class='delete-btn'>Delete</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
