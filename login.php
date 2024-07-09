<?php

$hostname = 'localhost';
$username = 'root'; 
$password = ''; 
$database = 'xplore';

// Create a database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // SQL query to check if the provided email and password match any records in the "admin" table
    $adminSql = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
    $adminResult = $conn->query($adminSql);

    if ($adminResult->num_rows > 0) {
        session_start();
        // Redirect to admin_add_car.html for admin
        header("Location: admin_panel.html");
        exit();
    } else {
        // Check regular customer table if admin credentials are not found
        $customerSql = "SELECT * FROM customer WHERE email = '$email' AND password = '$password'";
        $customerResult = $conn->query($customerSql);

        if ($customerResult->num_rows > 0) {
            session_start();
            // Generate a random session token
            $token = bin2hex(random_bytes(16));

            // Store the session token and email in session variables
            $_SESSION['token'] = $token;
            $_SESSION['email'] = $email;
            // Redirect to addtocart.html upon successful login for non-admin users
            header("Location: addtocart.html");
            exit();
        } else {
            // Display error message in a popup form
            echo "<script>
                    alert('Invalid sign-in. Please check your email and password or register first.');
                    window.location.href = 'login.html'; // Replace with the actual login page URL
                  </script>";
        }
    }
}

$conn->close();
?>
