<?php
session_start(); // Start the session

// Destroy all session variables
session_unset();
session_destroy();

// Redirect to the login page or homepage after logging out
header("Location: login.php"); 
exit(); 
?>
