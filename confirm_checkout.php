<?php
session_start();

if (isset($_SESSION['days']) && isset($_SESSION['totalRent']) && isset($_SESSION['driverNames'])) {
    $days = $_SESSION['days'];
    $totalRent = $_SESSION['totalRent'];
    $driverNames = $_SESSION['driverNames'];

    // Calculate the total bill, including the cost of drivers
    $totalBill = $days * ($totalRent +  (count($driverNames) * 6000));
} else {
    // Redirect to the checkout page if session data is not available
    header("Location: checkout.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation | Xplore</title>
      <!-- Favicon -->
  <link rel="shortcut icon" type="image/png" href="favicon_io\favicon-16x16.png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

  <!-- Title -->
  <title> Confirm Checkout | Xplore</title>

  <!-- CSS Stylesheet -->
  <link rel="stylesheet" href="CSS\submitconfirmcheckout.css">


  <!-- Icons -->
  <script src="https://kit.fontawesome.com/d0bb61bd0b.js" crossorigin="anonymous"></script>
</head>

<body>
    <br><br><br><br><br>
    <h1>Confirmation</h1>
    <br><br>
    <p>Number of Days: <?php echo $days; ?></p>
    <br>
    <p>Driver Names:</p>
    <br>
    <ul>
        <?php foreach ($driverNames as $driverName) : ?>
            <li><?php echo $driverName; ?></li>
        <?php endforeach; ?>
    </ul>
    <br>
    <p>Total Bill: Rs <?php echo $totalBill; ?>.00 /-</p>
    <br>
    <p>Do you want to confirm the submission?</p>
    <br><br>
    <a target='_blank' href="submit_confirm_checkout.php">Confirm</a>
    <a href="checkout.php">Cancel</a>
</body>

</html>
