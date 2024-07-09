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
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $occupation = $_POST['occupation'];
    $gender = $_POST['gender']; // New field: Gender
    $password = $_POST['password']; // New field: Password

    // SQL query to insert data into the "customer" table
    $sql = "INSERT INTO customer (name, email, address, phone, occupation, gender, password) VALUES ('$name', '$email', '$address', '$phone', '$occupation', '$gender', '$password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: Cars.html");
        exit();
        } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
