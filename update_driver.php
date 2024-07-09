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
$existingDriverName = $_POST['existingDriverName'];

// Check if the existingDriverName matches the current driverName in the database
$checkExistingNameQuery = "SELECT * FROM driver WHERE DriverName='$existingDriverName'";
$result = $conn->query($checkExistingNameQuery);

if ($result->num_rows > 0) {
    // Build the update query based on the filled fields in the form
    $updateQuery = "UPDATE driver SET ";
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
    addFieldToUpdate('DriverName', $_POST['newDriverName']);
    addFieldToUpdate('Address', $_POST['driverAddress']);
    addFieldToUpdate('driverphone', $_POST['driverPhone']);
    addFieldToUpdate('availability', $_POST['driverAvailability']);

    // Remove the trailing comma and space from the update query
    $updateQuery = rtrim($updateQuery, ', ');

    // Finalize the update query
    $updateQuery .= " WHERE DriverName='$existingDriverName'";

    // Prepare and execute the update query
    $stmt = $conn->prepare($updateQuery);

    if ($stmt) {
        // Bind parameters and execute the update
        $stmt->bind_param(str_repeat('s', count($updateData)), ...$updateData);

        if ($stmt->execute()) {
            echo "Driver details updated successfully";
        } else {
            echo "Error updating driver details: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    echo "Error: The existing driver name does not match any record in the database.";
}

// Close the database connection
$conn->close();
?>
