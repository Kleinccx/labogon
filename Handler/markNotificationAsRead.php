<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$notification_id = $_GET['notificationId'];

if (empty($notification_id)) {
    echo json_encode(['success' => false, 'message' => 'Invalid notification ID.']);
    exit;
}

// Update notification status to "read"
$conn = new mysqli('localhost', 'root', '', 'barangay_labogon');
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

$stmt = $conn->prepare("UPDATE notifications SET status = 'read' WHERE id = ? AND user_id = ?");
$stmt->bind_param('ii', $notification_id, $user_id);
$result = $stmt->execute();

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to mark as read.']);
}
?>
