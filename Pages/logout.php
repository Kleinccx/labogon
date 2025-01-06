<?php
session_start();

// Check if the logged-in user is not an admin
if ($_SESSION['role'] != 'admin') {
    session_destroy();  // Only destroy the session for non-admin users
}

header('Location: /labogon/index.php');
exit();
?>
