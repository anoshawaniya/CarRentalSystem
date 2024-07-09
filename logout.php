<?php
session_start();

if(isset($_SESSION['email'])) {
    // Unset the specific session variables
    unset($_SESSION['token']);
    unset($_SESSION['email']);

    // Destroy the session
    session_destroy();

    // Clear session cookies
    setcookie(session_name(), '', time() - 3600, '/');

    // Regenerate session ID
    session_regenerate_id(true);

    // Redirect to the index.html page
    header("Location: index.html");
    exit();
} else {
    // Redirect to an error page or handle the situation accordingly
    echo "You are not logged in.";
}
?>
