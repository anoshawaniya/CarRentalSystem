<?php
// Database configuration for XAMPP localhost
$hostname = 'localhost';
$username = 'root'; // Default XAMPP username
$password = ''; // Default XAMPP password (empty by default)
$database = 'xplore';

// Create a database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data for adding drivers
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addDriver'])) {
    $driverName = $_POST['DriverName'];
    $address = $_POST['Address'];
    $driverPhone = $_POST['driverphone'];
    $availability = $_POST['availability'];

    // SQL query to insert new driver details into the "driver" table
    $insertSql = "INSERT INTO driver (DriverName, Address, driverphone, availability) VALUES ('$driverName', '$address', '$driverPhone', '$availability')";
    
    if ($conn->query($insertSql) === TRUE) {
        echo "Driver added successfully!";
    } else {
        echo "Error adding driver: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
