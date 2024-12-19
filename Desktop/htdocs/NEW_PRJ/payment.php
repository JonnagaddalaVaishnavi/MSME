<?php
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

// Function to create tables if they don't exist
function createTablesIfNeeded($conn) {
    $sql = "CREATE TABLE IF NOT EXISTS `payment` (
    `id` int(100) NOT NULL AUTO_INCREMENT,
    `user_id` int(100) NOT NULL,
    `amount` DECIMAL(10,2) NOT NULL,
    `status` ENUM('pending', 'success', 'cancelled') NOT NULL,
    `payment_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `user_info`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
)";


    $conn->query($sql);

    $sql = "CREATE TABLE IF NOT EXISTS pay_upi (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        upi_id VARCHAR(20) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    $conn->query($sql);
}

// Function to insert data into pay_card table
function insertCardData($conn, $cardInfo, $cardExpiry, $cardCVV, $bankName) {
    $sql = "INSERT INTO pay_card (card_info, card_expiry, card_cvv, bank_name) VALUES ('$cardInfo', '$cardExpiry', '$cardCVV', '$bankName')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to otp.php after successful insertion
        header("Location: otp.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Function to insert data into pay_upi table
function insertUpiData($conn, $upiId) {
    $sql = "INSERT INTO pay_upi (upi_id) VALUES ('$upiId')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to otp.php after successful insertion
        header("Location: otp.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Check if tables exist, if not create them
createTablesIfNeeded($conn);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cardInfo']) && isset($_POST['cardExpiry']) && isset($_POST['cardCVV']) && isset($_POST['bankName'])) {
        $cardInfo = $_POST['cardInfo'];
        $cardExpiry = $_POST['cardExpiry'];
        $cardCVV = $_POST['cardCVV'];
        $bankName = $_POST['bankName'];

        insertCardData($conn, $cardInfo, $cardExpiry, $cardCVV, $bankName);
    } elseif (isset($_POST['upiId'])) {
        $upiId = $_POST['upiId'];

        insertUpiData($conn, $upiId);
    }
}

// Close connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Your Account</title>
    <style>
        /* Your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/background.jpg');
            margin: 0;
            padding: 0;
            color: white;
        }

        .container {
            width: 80%;
            margin: auto;
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

        .content {
            display: flex;
            flex-direction: column; /* Changed to column */
            align-items: center; /* Center aligning content */
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Added style for the box */
        .payment-box {
            border: 2px solid #333;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
            width: 60%;
            border-color: white;
        }

        .content__section {
            margin-top: 20px; /* Added margin between sections */
            box-sizing: border-box; /* Include padding and border in element's total width and height */
            border-radius: 15px; /* Rounded edges */
            padding: 20px;
            border: 2px solid #333;
            width: 100%;
            border-color: black;
        }

        .content_section_title {
            font-size: 1.5em;
            color: darkblue;
        }

        .content_section_form {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
        }

        .content_sectionform_input {
            margin: 10px 0;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #efeff0;
        }

        .content_sectionform_button {
            margin: 10px 0;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: darkblue;
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
        }

        .content_sectionform_button:hover {
            background-color: #767979;
            color: darkblue;
        }

        .agree {
            margin: 10px 0;
            display: flex;
            align-items: center;
        }

        .agree__checkbox {
            margin-right: 10px;
            cursor: pointer;
        }

        .agree__text {
            color: darkblue;
            font-size: 0.8em;
            cursor: pointer;

        }

        .agree__text:hover {
            color: darkblue;
        }

        .error-message {
            color: darkblue;
            font-size: 0.8em;
            margin-top: 5px;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    </style>
</head>
<body>
<div class="container">
    <header class="header">
        <div class="header__title">Payment page </div>
    </header>
    <main class="content">
        <div class="payment-box">
            <div class="content__section">
                <div class="content_section_title">Pay with card</div>
                <form class="content_section_form" id="cardForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="text" placeholder="Card Information (12 digits)" class="content_sectionform_input" id="cardInfo" name="cardInfo" pattern="\d{12}" title="Enter 12 digits">
                    <input type="text" placeholder="MM/YY (MM: 1-12, YY: 00-30)" class="content_sectionform_input" id="cardExpiry" name="cardExpiry" pattern="(0[1-9]|1[0-2])\/(0[0-9]|1[0-9]|2[0-9]|30)" title="Enter MM/YY">
                    <input type="text" placeholder="CVV (3 digits)" class="content_sectionform_input" id="cardCVV" name="cardCVV" pattern="\d{3}" title="Enter 3 digits">
                    <select id="bankName" class="content_sectionform_input" name="bankName">
                        <option value="" disabled selected>Select Bank</option>
                        <option value="bandhan">Bandhan Bank</option>
                        <option value="karnataka">Karnataka Bank</option>
                        <option value="sbi">SBI Bank</option>
                        <option value="hdfc">HDFC Bank</option>
                        <option value="canara">Canara Bank</option>
                        <option value="syndicate">Syndicate Bank</option>
                        <option value="icici">ICICI Bank</option>
                        <option value="axis">Axis Bank</option>
                    </select>
                    <button type="submit" class="content_sectionform_button">Pay</button>
                </form>
            </div>
            <div class="content__section">
                <div class="content_section_title">Pay with UPI</div>
                <form class="content_section_form" id="upiForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="text" placeholder="UPI ID (10 digits, @ and axl/ybl)" class="content_sectionform_input" id="upiId" name="upiId" pattern="\d{10}@(axl|ybl)" title="Enter 10 digits followed by @ and axl/ybl">
                    <button type="submit" class="content_sectionform_button">Verify</button>
                </form>
            </div>
            <div class="content__section">
                <div class="content_section_title">Cash on Delivery</div>
                <form class="content_section_form" id="codForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <button type="submit" class="content_sectionform_button">Place Order</button>
                </form>
            </div>
        </div>
        <div class="agree">
            <input type="checkbox" class="agree__checkbox" id="terms" name="terms">
            <label class="agree__text" for="terms">I agree to the Terms and Conditions</label>
        </div>
    </main>
</div>

<script>
    // Form validation and submission for cardForm
    document.getElementById("cardForm").addEventListener("submit", function(event) {
        event.preventDefault();
        var cardInfo = document.getElementById("cardInfo").value;
        var cardExpiry = document.getElementById("cardExpiry").value;
        var cardCVV = document.getElementById("cardCVV").value;
        var bankName = document.getElementById("bankName").value;

        // Your validation logic goes here
        if (cardInfo && cardExpiry && cardCVV && bankName) {
            this.submit();
        } else {
            alert("Please fill in all fields.");
        }
    });

    // Form validation and submission for upiForm
    document.getElementById("upiForm").addEventListener("submit", function(event) {
        event.preventDefault();
        var upiId = document.getElementById("upiId").value;

        if (upiId) {
            this.submit();
        } else {
            alert("Please enter UPI ID.");
        }
    });

    // Form validation and submission for codForm
    document.getElementById("codForm").addEventListener("submit", function(event) {
        event.preventDefault();
        if (document.getElementById("terms").checked) {
            window.location.href = "otp.php"; // Redirect to otp.php
        } else {
            alert("Please agree to the Terms and Conditions.");
        }
    });
</script>
</body>
</html>