<!-- checkout.php -->
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Favicon -->
  <link rel="shortcut icon" type="image/png" href="favicon_io\favicon-16x16.png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

  <!-- Title -->
  <title>Checkout | Xplore</title>

  <!-- CSS Stylesheet -->
  <link rel="stylesheet" href="CSS\checkoutstyles.css">


  <!-- Icons -->
  <script src="https://kit.fontawesome.com/d0bb61bd0b.js" crossorigin="anonymous"></script>


    
</head>

<body>

<br> <br> <br> <br> <br> <br>
    <h1>Checkout</h1>
    <br> <br> <br> <br>
    <form method="post" action="submit_checkout.php">
        <label for="days">Enter number of days:</label>
        <input type="number" id="days" name="days" required>
        <input type="submit" value="Calculate Bill">
    </form>
</body>

</html>
