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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve vehicleName from the form
    $driverName = $_POST["vehicleName"];

    // Prepare and execute the SQL query to delete the entry
    $sql = "DELETE FROM driver WHERE DriverName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $driverName);

    if ($stmt->execute()) {
        echo "Driver deleted successfully.";
    } else {
        echo "Error deleting driver: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
