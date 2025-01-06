<?php
session_start();
require_once '../config.php'; // Replace with your PDO config.

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $postId = $_POST['post_id'];
    $comment = $_POST['comment'];
    $isAnonymous = isset($_POST['is_anonymous']) ? 1 : 0;

    // Handle file upload
    $photoPath = null;
    if (!empty($_FILES['photo']['name'])) {
        $uploadDir = '../uploads/comments/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $photoPath = $uploadDir . uniqid() . '_' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath);
    }

    // Insert the comment into the database
    $stmt = $pdo->prepare("
        INSERT INTO comments (user_id, post_id, content, is_anonymous, photo_path, created_at)
        VALUES (:user_id, :post_id, :content, :is_anonymous, :photo_path, NOW())
    ");
    $stmt->execute([
        ':user_id' => $userId,
        ':post_id' => $postId,
        ':content' => $comment,
        ':is_anonymous' => $isAnonymous,
        ':photo_path' => $photoPath
    ]);

    header("Location: /labogon/Pages/newsfeed.php");
    exit;
}
?>
