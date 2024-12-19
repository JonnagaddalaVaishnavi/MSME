<?php
$pageTitle = 'About';

include 'includes/config.php';
include 'includes/header.php';
?>
<head><style>body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    color: #333;
}

.about {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: white;
}

h2 {
    color: #333;
}

.contact-form {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.contact-form h2 {
    margin-bottom: 20px;
}

.contact-form label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.contact-form input[type="text"],
.contact-form input[type="email"],
.contact-form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.contact-form textarea {
    height: 150px;
    resize: vertical;
}

.contact-form button[type="submit"] {
    background-color: #333;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
}

.contact-form button[type="submit"]:hover {
    background-color: #555;
}
</style>
</head>

<main class="about" style="background-color:white;"><br><b>
    <h2>About Us</h2>
    <p>
        Welcome to Mobile Store, the ultimate destination for all your mobile technology needs. Nestled in the heart of the city, our mobile store is a bustling hub where cutting-edge technology meets personalized service. Step into a world where innovation and convenience coalesce to redefine your mobile experience.
    </p>
    <p>
        Our store boasts a diverse array of the latest smartphones, tablets, and accessories from renowned brands. Whether you're a tech enthusiast seeking the newest releases or a budget-conscious consumer in search of reliable options, Mobile Store caters to every preference and pocket. Our knowledgeable and friendly staff are always on hand to guide you through the features and specifications, ensuring you make an informed decision tailored to your needs.
    </p>
    <p>
        The sleek and modern layout of the store creates an inviting atmosphere, encouraging customers to explore and interact with the latest gadgets. From vibrant displays showcasing vivid displays to interactive demo areas, we've curated an immersive environment that allows you to experience the full potential of each device before making a purchase.
    </p>
    <p>
        At Mobile Store, customer satisfaction is our top priority. Our service doesn't end with the sale – we offer prompt and efficient after-sales support, including expert assistance with device setup, troubleshooting, and upgrades. We believe in building lasting relationships with our customers, providing a one-stop solution for all their mobile needs.
    </p>
    <p>
        Visit Mobile Store today and embark on a journey into the world of mobile technology, where innovation meets service, and your satisfaction is our commitment.
    </p>

    <section class="contact-form">
        <h2>Contact Us</h2>
        <form action="https://api.web3forms.com/submit" method="POST">
            <!-- Replace with your Access Key -->
            <input type="hidden" name="access_key" value="9aabb81d-181d-4586-8558-17ffd173e3f3">
            <!-- Form Inputs. Each input must have a name="" attribute -->
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <label for="message">Message</label>
            <textarea id="message" name="message" required></textarea>
            <!-- Honeypot Spam Protection -->
            <input type="checkbox" name="botcheck" class="hidden" style="display: none;">
            <button type="submit">Submit Form</button>
        </form>
    </section>
</main>

<?php
include 'includes/footer.php';
?>
