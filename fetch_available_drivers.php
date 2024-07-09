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

// Fetch details from the driver table where availability is available
$sql = "SELECT * FROM driver WHERE availability = 'available'";
$result = $conn->query($sql);

// Close the connection
$conn->close();
?>
