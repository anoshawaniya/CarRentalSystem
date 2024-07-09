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

// Process form data for adding cars
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vRegNo = $_POST['vRegNo'];
    $vehicleName = $_POST['vehicleName'];
    $rentCost = $_POST['rentCost'];
    $color = $_POST['color'];
    $capacity = $_POST['capacity'];
    $model = $_POST['model'];
    $make = $_POST['make'];
    $bodyType = $_POST['bodyType'];
    $fuelType = $_POST['fuelType'];
    $carCondition = $_POST['carCondition'];
    $availability = $_POST['availability'];
    $carImage = $_POST['carImage'];

    // SQL query to insert new car details into the "vehicle_details" table
    $insertSql = "INSERT INTO vehicle_details (vRegNo, vehicleName, rentCost, color, capacity, model, make, bodyType, fuelType, carCondition, availability, carImage) VALUES ('$vRegNo', '$vehicleName', '$rentCost', '$color', '$capacity', '$model', '$make', '$bodyType', '$fuelType', '$carCondition', '$availability' , '$carImage')";
    
    if ($conn->query($insertSql) === TRUE) {
        echo "Car added successfully!";
    } else {
        echo "Error adding car: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
