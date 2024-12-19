<?php
// Start the session before any output
session_start();

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'project';

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to create database and table
function createDatabaseAndTable($conn) {
    // SQL to create address table
    $sql = "CREATE TABLE IF NOT EXISTS address (
        id INT AUTO_INCREMENT PRIMARY KEY,
        houseNo VARCHAR(15) NOT NULL,
        area VARCHAR(20) NOT NULL,
        city VARCHAR(20) NOT NULL,
        state VARCHAR(20) NOT NULL,
        landmark VARCHAR(20) NOT NULL,
        phone VARCHAR(10) NOT NULL,
        email VARCHAR(20) NOT NULL
    )";

    if ($conn->query($sql) === TRUE) {
        // No need to echo here
    } else {
        echo "Error creating table: " . $conn->error;
    }
}

// Call the function to create database and table
createDatabaseAndTable($conn);

// Close the connection
$conn->close();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create new connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $houseNo = $_POST['houseNo'];
    $area = $_POST['area'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $landmark = $_POST['landmark'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Insert data into the address table
    $sql = "INSERT INTO address (houseNo, area, city, state, landmark, phone, email) 
            VALUES ('$houseNo', '$area', '$city', '$state', '$landmark', '$phone', '$email')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to another page
        header("Location: payment.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Page</title>
    <style>
        /* CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/background.jpg');
            background-color: #f4f4f4;
            padding: 20px;
        }

        .header {
            text-align: center;
            padding: 50px 0;
        }

        .header__title {
            font-size: 2.5em;
            color: white;
        }

        .header__step {
            font-size: 1em;
            color: darkblue;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="email"], input[type="tel"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #0e0d0f;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0e0d0f;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-top: -10px;
            margin-bottom: 10px;
        }
        label {
            color: darkblue;
        }

    </style>
</head>
<body>
    <header class="header">
        <div class="header__title">Add your Address</div>
        
    </header>
    <form id="addressForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
    <h1 style="color: darkblue;">ADDRESS</h1>
        <label for="houseNo">House No.:</label>
        <input type="text" id="houseNo" name="houseNo" placeholder="house no" required>
        <span id="houseNoError" class="error"></span>

        <label for="area">Street & Area:</label>
        <input type="text" id="area" name="area" placeholder="Enter Your Street" required>
        <span id="areaError" class="error"></span>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" placeholder="Enter Your city" required>
        <span id="cityError" class="error"></span>

        <label for="state">State:</label>
        <select id="state" name="state" required>
            <option value="" disabled selected>Please select</option>
            <option value="Arunachal pradesh">Arunachal Pradesh</option>
            <option value="Andra Pradesh">Andra Pradesh</option>
            <option value="Assam">Assam</option>
            <option value="Bihar">Bihar</option>
            <option value="Chhattisgarh">Chhattisgarh</option>
            <option value="Gujarat">Gujarat</option>
            <option value="Karnataka">Karnataka</option>
            <option value="Kerala">Kerala</option>
            <option value="Tamil Nadu">Tamil Nadu</option>
            <option value="Telangana">Telangana</option>
            <option value="Madhya Pradesh">Madhya Pradesh</option>
            <option value="Maharashtra">Maharashtra</option>

        </select>
        <span id="stateError" class="error"></span>

        <label for="Address">Address</label>
        <textarea id="Address" name="Address" rows="5" cols="50" placeholder="Enter Your Address here" required></textarea>
        <span id="AddressError" class="error"></span>

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" placeholder="mobile number" required>
        <span id="phoneError" class="error"></span>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Email_id@gmail.com" required>
        <span id="emailError" class="error"></span>
        <input type="submit" style="background-color: darkblue;" value="Submit">
    </form>

    <script>
        // JavaScript validation
