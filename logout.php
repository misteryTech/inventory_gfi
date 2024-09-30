<?php
session_start(); // Start the session

// Destroy the session
session_destroy();

// Redirect to the login page or homepage
header("Location: login_registration.php"); // Change this to your desired redirect URL
exit(); // Ensure no further code is executed
?>
