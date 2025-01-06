<?php
session_start();
session_destroy();
header('Location: /labogon/login.php');
exit();
?>
