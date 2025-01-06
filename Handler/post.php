<?php
$conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'if0_38046482_barangay_labogon');

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

session_start();

// Function to check if the user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

if (!isLoggedIn()) {
    header('Location: /labogon/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = $_POST['content'];
    $is_anonymous = 1;

    // Insert post into the database using mysqli
    $stmt = $conn->prepare('INSERT INTO posts (user_id, content, is_approved, is_anonymous) VALUES (?, ?, 0, ?)');
    $stmt->bind_param('isi', $_SESSION['user_id'], $content, $is_anonymous);
    $stmt->execute();

    header('Location: /labogon/Pages/newsfeed.php');
}

$conn->close();
?>
