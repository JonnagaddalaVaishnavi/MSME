<?php 

include('header.php');
if(isset($_SESSION['ROLE']) && $_SESSION['ROLE']!='1'){
    header('location:login.php');
    die();
}
?>
<div class="container-fluid">
<ol class="breadcrumb">
  <li class="breadcrumb-item">
  </li>
</ol>
<?php
include('db.php');

// Query for total products
$sql = "SELECT COUNT(*) as total FROM mobiles"; // Adjust the table name as necessary
$result = $con->query($sql);
$total_products = 0;

if ($result->num_rows > 0) {
    // Fetch the result
    $row = $result->fetch_assoc();
    $total_products = $row['total'];
}

// Query for total logins
$sql = "SELECT COUNT(*) as total FROM user_info"; // Adjust the table name and column as necessary
$result = $con->query($sql);
$total_logins = 0;

if ($result->num_rows > 0) {
    // Fetch the result
    $row = $result->fetch_assoc();
    $total_logins = $row['total'];
}

// Query for total categories
$sql = "SELECT COUNT(*) as total FROM categories"; // Adjust the table name as necessary
$result = $con->query($sql);
$total_categories = 0;

if ($result->num_rows > 0) {
    // Fetch the result
    $row = $result->fetch_assoc();
    $total_categories = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        .dashboard-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center; /* Center the boxes */
        }
        .dashboard-box {
            width: 200px;
            padding: 20px;
            color: #fff; /* Text color */
            border: 1px solid #ddd;
            text-align: center;
            font-size: 20px;
            font-family: Arial, sans-serif;
            border-radius: 10px; /* Optional: add rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: add shadow */
        }
        .products {
            background-color: #4CAF50; /* Green */
        }
        .logins {
            background-color: #2196F3; /* Blue */
        }
        .categories {
            background-color: #FFC107; /* Yellow */
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <div class="dashboard-box products">
        <p>Total Products:</p>
        <h3><?php echo $total_products; ?></h3>
    </div>
    <div class="dashboard-box logins">
        <p>Total Logins:</p>
        <h3><?php echo $total_logins; ?></h3>
    </div>
    <div class="dashboard-box categories">
        <p>Total Categories:</p>
        <h3><?php echo $total_categories; ?></h3>
    </div>
</div>

</body>
</html>
</div>
<?php include('footer.php')?>
