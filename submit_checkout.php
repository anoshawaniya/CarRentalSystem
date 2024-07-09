<?php
session_start();

// Unset sessions related to previous user selections if they exist
unset($_SESSION['cid']);
unset($_SESSION['bid']);
unset($_SESSION['totalRent']);
unset($_SESSION['noOfRentedCars']);
unset($_SESSION['days']);
unset($_SESSION['driverNames']);
unset($_SESSION['totalBill']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "xplore";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $bookingDetailsQuery = "SELECT cid, bid, totalRent FROM booking_details ORDER BY bid DESC LIMIT 1";
    $result = $conn->query($bookingDetailsQuery);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $cid = $row['cid'];
        $bid = $row['bid'];
        $totalRent = $row['totalRent'];

        $_SESSION['cid'] = $cid;
        $_SESSION['bid'] = $bid;
        $_SESSION['totalRent'] = $totalRent;

        $days = $_POST['days'];

        // Fetch the number of rented cars for the current user from the booking_details table
        $bookingDetailsCountQuery = "SELECT COUNT(*) as noOfRentedCars FROM booking_details WHERE cid = '$cid'";
        $countResult = $conn->query($bookingDetailsCountQuery);

        if ($countResult->num_rows > 0) {
            $countRow = $countResult->fetch_assoc();
            $noOfRentedCars = $countRow['noOfRentedCars'];

            // Set the number of rented cars in the session
            $_SESSION['noOfRentedCars'] = $noOfRentedCars;

            // Fetch random driver names from the database
            $driverNames = array();

            // Fetch a random driver name for each rented car
            $driverQuery = "SELECT DriverName FROM DRIVER where availability = 'available' ORDER BY RAND() LIMIT $noOfRentedCars";
            $driverResult = $conn->query($driverQuery);

            while ($driverResult && $driverRow = $driverResult->fetch_assoc()) {
                $driverNames[] = $driverRow['DriverName'];
            }

            // If the number of fetched driver names is less than $noOfRentedCars, handle the case
            while (count($driverNames) < $noOfRentedCars) {
                // Handle the case where no driver names are available
                $driverNames[] = "Unknown Driver";
            }

            $_SESSION['days'] = $days;
            $_SESSION['driverNames'] = $driverNames;

            // Calculate the total bill, including the cost of drivers
            $totalBill = $days * ($totalRent +  (count($driverNames) * 6000));
            $_SESSION['totalBill'] = $totalBill;

            header("Location: confirm_checkout.php");
            exit();
        } else {
            // Default to a value if there's an issue fetching from the table
            $_SESSION['noOfRentedCars'] = 0;
        }
    } else {
        echo "Error: Booking details not found in the database.";
    }
}
?>
