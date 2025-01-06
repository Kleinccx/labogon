<?php
// fetch_notification_count.php
session_start();
include('db.php');
$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT COUNT(*) AS count FROM notifications WHERE user_id = '$user_id' AND status = 'unread'");
$data = $result->fetch_assoc();
echo json_encode($data);
