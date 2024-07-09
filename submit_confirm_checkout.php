<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "xplore";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Retrieve data from session
    $days = $_SESSION['days'];
    $bid = $_SESSION['bid'];
    $totalRent = $_SESSION['totalRent'];
    $driverNames = $_SESSION['driverNames'];
    $noOfRentedCars = $_SESSION['noOfRentedCars'];

    // Calculate the total bill, including the cost of drivers
    $totalBill = $days * ($totalRent + (count($driverNames) * 6000));

    // Retrieve the customer's email from the session
    if (isset($_SESSION['email'])) {
        $customerEmail = $_SESSION['email'];

        // Query to get the cid based on the customer's email
        $cidQuery = "SELECT ID FROM customer WHERE email = '$customerEmail'";
        $result = $conn->query($cidQuery);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $cid = $row['ID'];

            // Insert into booking_vehicle table
            $sql = "INSERT INTO booking_vehicle (cid, bid, noOfDays, totalBill) VALUES ('$cid', '$bid', '$days', '$totalBill')";

            if ($conn->query($sql) === TRUE) {
                echo "Booking details inserted successfully into booking_vehicle table.";
            } else {
                echo "Error inserting booking details into booking_vehicle table: " . $conn->error;
            }

            foreach ($driverNames as $driverName) {
                // Use 'driver_name' instead of 'driverName'
                $sqlDriver = "INSERT INTO driver_assignment (bid, driverNames) VALUES ('$bid', '$driverName')";
                $conn->query($sqlDriver);
            }

            // Update the total bill in the booking_vehicle table
            $sqlUpdate = "UPDATE booking_vehicle SET totalBill = '$totalBill' WHERE bid = '$bid'";
            $conn->query($sqlUpdate);
        } else {
            echo "Error: Customer not found with email: $customerEmail";
        }
    } else {
        echo "Error: Customer email not set in the session.";
    }

    // Clear the session data
    unset($_SESSION['days']);
    unset($_SESSION['totalRent']);
    unset($_SESSION['noOfRentedCars']);
    unset($_SESSION['driverNames']);

    // Redirect to a page to display the success message
    header("Location: success.php");
    exit();
} else {
    echo "Invalid request.";
}
?>