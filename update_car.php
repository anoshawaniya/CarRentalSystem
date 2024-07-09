<?php
// Database configuration for XAMPP localhost
$hostname = 'localhost';
$username = 'root'; // Default XAMPP username
$password = ''; // Default XAMPP password (empty by default)
$database = 'xplore';

// Create a database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve values from the form
$existingVehicleName = $_POST['existingVehicleName'];

// Check if the existingVehicleName matches the current vehicleName in the database
$checkExistingNameQuery = "SELECT * FROM vehicle_details WHERE vehicleName='$existingVehicleName'";
$result = $conn->query($checkExistingNameQuery);

if ($result->num_rows > 0) {
    // Build the update query based on the filled fields in the form
    $updateQuery = "UPDATE vehicle_details SET ";
    $updateData = array();

    // Function to add non-empty field to the update query
    function addFieldToUpdate($fieldName, $value) {
        global $updateQuery, $updateData;
        if (!empty($value)) {
            $updateQuery .= "$fieldName=?, ";
            $updateData[] = $value;
        }
    }

    // Check each field and add to the update query if not empty
    addFieldToUpdate('vehicleName', $_POST['newVehicleName']);
    addFieldToUpdate('make', $_POST['make']);
    addFieldToUpdate('model', $_POST['model']);
    addFieldToUpdate('color', $_POST['color']);
    addFieldToUpdate('bodyType', $_POST['bodyType']);
    addFieldToUpdate('fuelType', $_POST['fuelType']);
    addFieldToUpdate('carCondition', $_POST['carCondition']);
    addFieldToUpdate('capacity', $_POST['capacity']);
    addFieldToUpdate('carImage', $_POST['carImage']);
    addFieldToUpdate('rentCost', $_POST['rentCost']);
    addFieldToUpdate('availability', $_POST['availability']);


    // Remove the trailing comma and space from the update query
    $updateQuery = rtrim($updateQuery, ', ');

    // Finalize the update query
    $updateQuery .= " WHERE vehicleName='$existingVehicleName'";

    // Prepare and execute the update query
    $stmt = $conn->prepare($updateQuery);

    if ($stmt) {
        // Bind parameters and execute the update
        $stmt->bind_param(str_repeat('s', count($updateData)), ...$updateData);

        if ($stmt->execute()) {
            echo "Car details updated successfully";
        } else {
            echo "Error updating car details: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "Error: The existing vehicle name does not match any record in the database.";
}

// Close the database connection
$conn->close();
?>
