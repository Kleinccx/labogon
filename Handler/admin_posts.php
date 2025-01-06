<?php
session_start();

// Database connection
$conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'if0_38046482_barangay_labogon');

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Check if the user is an admin
function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
}

if (!isAdmin()) {
    die('Access denied.');
}

// Handle post validation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['post_id'];
    $action = $_POST['action'];

    $isApproved = ($action === 'approve') ? 1 : 0;

    $stmt = $conn->prepare("UPDATE posts SET is_approved = ? WHERE id = ?");
    $stmt->bind_param("ii", $isApproved, $postId);
    $stmt->execute();
    $stmt->close();

    header('Location: admin_posts.php');
    exit;
}

// Fetch all unapproved posts
$query = "
    SELECT posts.id AS post_id, posts.content, posts.photo_path, posts.created_at, 
           user_table.user_name
    FROM posts
    LEFT JOIN user_table ON posts.user_id = user_table.id
    WHERE posts.is_approved = 0
    ORDER BY posts.created_at DESC
";

$result = $conn->query($query);

$posts = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Validate Posts</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }
        .post {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .post img {
            max-width: 100%;
            margin-top: 10px;
            border-radius: 8px;
        }
        button {
            margin-right: 10px;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .approve {
            background: #4CAF50;
            color: white;
        }
        .disapprove {
            background: #f44336;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard - Validate Posts</h1>

    <?php foreach ($posts as $post): ?>
        <div class="post">
            <strong>Posted by: <?php echo htmlspecialchars($post['user_name']); ?></strong>
            <p><?php echo htmlspecialchars($post['content']); ?></p>
            <?php if ($post['photo_path']): ?>
                <img src="<?php echo $post['photo_path']; ?>" alt="Post Image">
            <?php endif; ?>
            <form method="POST">
                <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                <button type="submit" name="action" value="approve" class="approve">Approve</button>
                <button type="submit" name="action" value="disapprove" class="disapprove">Disapprove</button>
            </form>
        </div>
    <?php endforeach; ?>

    <?php if (empty($posts)): ?>
        <p>No posts awaiting approval.</p>
    <?php endif; ?>
</body>
</html>
