<?php
    session_start(); // Start the session

    // Check if the user is logged in
    if (isset($_SESSION['admin_name'])) {
        // If an admin is logged in, unset the session variables and destroy the session
        unset($_SESSION['admin_name']);
    } else if (isset($_SESSION['user_name'])) {
        // If a regular user is logged in, unset the session variables and destroy the session
        unset($_SESSION['user_name']);
    }

    // Destroy the session
    session_destroy();

    // Redirect the user to the login page
    header("Location: login.php");
    exit();
?>
