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

if (isset($_POST['checkout']) && $_POST['checkout'] == 1) {
    $totalRent = $_POST['totalRent'];
    $noOfRentedCars = $_POST['noOfRentedCars'];

    // Retrieve the customer's email from the session
    if(isset($_SESSION['email'])){
        $customerEmail = $_SESSION['email'];

        // Query to get the cid based on the customer's email
        $cidQuery = "SELECT ID FROM customer WHERE email = '$customerEmail'";
        $result = $conn->query($cidQuery);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $cid = $row['ID'];

            // Insert into booking_details table
            $sql = "INSERT INTO booking_details (cid, totalRent, noOfRentedCars) VALUES ('$cid', '$totalRent', '$noOfRentedCars')";

            if ($conn->query($sql) === TRUE) {
                echo "Booking details inserted successfully";
            } else {
                echo "Error inserting booking details: " . $conn->error;
            }
        } else {
            echo "Error: Customer not found with email: $customerEmail";
        }
    } else {
        echo "Error: Customer email not set in the session.";
    }
}

$conn->close();
?>