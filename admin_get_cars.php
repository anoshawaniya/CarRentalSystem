<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'xplore';

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Modify the SQL query to include a condition for availability
$sql = "SELECT vehicleName, rentCost, carImage, make, fuelType, color, capacity FROM vehicle_details WHERE availability = 'available'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $vehicleName = $row["vehicleName"];
        $rentCost = $row["rentCost"];
        $carImagePath = $row["carImage"];
        $make = $row["make"];
        $fuelType = $row["fuelType"];
        $color = $row["color"];
        $capacity = $row["capacity"];

        // Construct the complete image URL based on your website's base URL
        $baseUrl = "http://localhost/Project - Copy1/";
        $carImageURL = $baseUrl . $carImagePath;

        // Debugging statements
        echo "<p>Vehicle Name: $vehicleName, Rent Cost: $rentCost , Make: $make, Fuel Type: $fuelType, Color: $color, Capacity: $capacity</p>";

        // Display the image
        if (file_exists($carImagePath)) {
            echo "<img src='$carImageURL' alt='Car Image' style='max-width: 200px; max-height: 200px;'><br>";
        } else {
            echo "Image does not exist at path: $carImagePath<br>";
        }
    }
} else {
    echo "0 results";
}

// Close the database connection
$conn->close();
?>
