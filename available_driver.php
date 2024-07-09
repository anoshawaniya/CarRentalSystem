<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="available_driver.css">
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/png" href="favicon_io\favicon-16x16.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- Title -->
    <title>Drivers | Xplore</title>


    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Montserrat:wght@100;400;500;900&family=Nunito:wght@900&family=Oswald:wght@700&family=Raleway:wght@200;300;400;700;900&family=Ubuntu:wght@300;400;700&display=swap"
        rel="stylesheet">

    <!-- CSS Stylesheet -->
    <link rel="stylesheet" href="delete_car.css">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Bootstrap Jscript -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</head>
<body>
    <!-- NavBar -->

    <nav class="navigationbar">
        <div class="container">
            <a class="logo" href="#"><img src="Xplore-logo\cover-removebg-preview.png" alt="Logo"></a>
            <ul>
                <li><a target="_self" href="index.html" data-text="Home">Home</a></li>
                <li><a target="_blank" href="admin_panel.html" data-text="Admin">Admin</a></li>
                <li><a href="available_driver.php" data-text="Driver">Driver</a></li>
                <li><a target="_blank" href="registration.html" data-text="Signin">Signin</a></li>
            </ul>
        </div>
    </nav>

    <h2> <b> Available Drivers </b></h2>

    <?php
    // Include the PHP file to fetch available drivers
    include('fetch_available_drivers.php');

    // Check if there are available drivers
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Driver Name</th><th>Address</th><th>Driver Phone</th><th>Availability</th></tr>";
        
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["DriverName"] . "</td><td>" . $row["Address"] . "</td><td>" . $row["driverphone"] . "</td><td>" . $row["availability"] . "</td></tr>";
        }

        echo "</table>";
    } else {
        echo "No available drivers.";
    }
    ?>

</body>
</html>
