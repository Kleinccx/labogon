<?php
session_start();

$conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'if0_38046482_barangay_labogon');

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

$isLoggedIn = isLoggedIn();
$userId = $isLoggedIn ? $_SESSION['user_id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_post'])) {
    $content = $_POST['content'];
    $is_anonymous = isset($_POST['is_anonymous']) ? 1 : 0;
    $user_id = $userId;

    $photoPath = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadsDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadsDir)) mkdir($uploadsDir, 0777, true);
    
        $photoName = uniqid() . '_' . basename($_FILES['photo']['name']);
        $photoFullPath = $uploadsDir . $photoName;
    
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $photoFullPath)) {
            $photoPath = 'uploads/' . $photoName;  // Save the relative path
        } else {
            die('Failed to upload image.');
        }
    }
    
    // In the part where the image is displayed in the HTML:

    $stmt = $pdo->prepare("INSERT INTO posts (user_id, content, photo_path, is_anonymous, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$user_id, $content, $photoPath, $is_anonymous]);

    header('Location: /labogon/Pages/newsfeed.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_comment'])) {
    $post_id = $_POST['post_id'];
    $comment = $_POST['comment'];
    $is_anonymous = isset($_POST['comment_is_anonymous']) ? 1 : 0;

    $stmt = $pdo->prepare("INSERT INTO comments (post_id, user_id, username, comment, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$post_id, $userId, $is_anonymous ? 'Anonymous' : $_SESSION['username'], $comment]);

    header('Location: /labogon/Pages/newsfeed.php');
    exit;
}

$stmt = $pdo->query("SELECT posts.id AS post_id, posts.content, posts.photo_path, posts.is_anonymous, posts.created_at, user_table.user_name FROM posts LEFT JOIN user_table ON posts.user_id = user_table.id WHERE posts.is_approved = 1 ORDER BY posts.created_at DESC");
$posts = $stmt->fetchAll();

$commentsStmt = $pdo->prepare("SELECT comments.post_id, comments.comment, comments.created_at, comments.username FROM comments WHERE comments.post_id = :post_id ORDER BY comments.created_at ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waste Marketplace</title>
    <link rel="stylesheet" href="/labogon/style.css">

    <header class="header">
    <div class="logo-img">
    <img class="logopic" src="/labogon/logo.png" alt="" />

    </div>
    <nav class="main-nav">
        <?php if ($isLoggedIn): ?>
            <ul class="main-nav-list">
                <li><a class="main-nav-link" href="../index.php">Dashboard</a></li>
                <li><a class="main-nav-link" href="buyandsell.php">Buy & Sell</a></li>
                <li><a class="main-nav-link" href="events.php">Events</a></li>
                <li><a class="main-nav-link" href="newsfeed.php">NewsFeed</a></li>
                <li><a class="main-nav-link" href="appointments.php">Appointment</a></li>
                <li><a class="main-nav-link" href="wastemanagement.php">Waste Management</a></li>

                <li>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</li>
                <li><a class="main-nav-link nav-cta" href="logout.php">Logout</a></li>
            </ul>
        <?php else: ?>
            <ul class="main-nav-list">
                <li><a class="main-nav-link" href="../index.php">Dashboard</a></li>
                <li><a class="main-nav-link" href="buyandsell.php">Buy & Sell</a></li>
                <li><a class="main-nav-link" href="events.php">Events</a></li>
                <li><a class="main-nav-link" href="newsfeed.php">NewsFeed</a></li>
                <li><a class="main-nav-link" href="appointments.php">Appointment</a></li>
                <li><a class="main-nav-link" href="wastemanagement.php">Waste Management</a></li>

                <li><a class="main-nav-link nav-cta" href="/labogon/login.php">Sign In</a></li>
            </ul>
        <?php endif; ?>
    </nav>
</header>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsfeed</title>
    <style>
  /* Style for images in posts and comments */
.comment img,
.post img {
    max-width: 80%; /* Limit the maximum size of images */
    height: auto; /* Maintain aspect ratio */
    margin-top: 15px;
    border-radius: 8px;
    display: block;
    margin-left: auto;
    margin-right: auto;
}

/* Increase text size for better readability */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #ffffff;
    margin: 0;
    padding: 0;
}

main {
    max-width: 800px;
    margin: 40px auto;
    padding: 30px;
    background-color: #f9f9f9;
    border-radius: 15px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #4a63e7;
    font-size: 2em; /* Increase size of headings */
}

.post, .comment {
    background-color: #ffffff;
    border: 1px solid #e1e4f0;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 30px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    font-size: 1.2em; /* Increase text size for posts and comments */
}

.post:hover, .comment:hover {
    transform: translateY(-8px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
}

.post-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}

.post-header strong {
    color: #4a63e7;
    font-size: 1.5em; /* Increase font size for post author */
}

.post-header small {
    color: #6c757d;
    font-size: 1.1em; /* Slightly larger date/time */
}

textarea {
    width: 100%;
    border: 1px solid #d3d9de;
    border-radius: 8px;
    padding: 15px;
    resize: none;
    height: 120px; /* Increase height for better readability */
    font-size: 1.2em; /* Increase font size in textareas */
    margin-top: 15px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

textarea:focus {
    border-color: #4a63e7;
    outline: none;
    box-shadow: 0 0 8px rgba(74, 99, 231, 0.5);
}

input[type="file"] {
    margin-top: 15px;
    font-size: 1.1em; /* Slightly increase font size for file input */
}

button {
    background-color: #4a63e7;
    color: white;
    border: none;
    padding: 14px 28px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1.2em; /* Increase font size of buttons */
    margin-top: 12px;
    width: 100%;
    transition: background-color 0.3s, transform 0.2s;
}

button:hover {
    background-color: #374bd8;
    transform: translateY(-3px);
}

.comment img,
.post img {
    max-width: 80%; /* Limit image size */
    height: auto;
    border-radius: 8px;
    display: block;
    margin-top: 15px;
    margin-left: auto;
    margin-right: auto;
}

@media (max-width: 768px) {
    main {
        padding: 20px;
    }

    .post, .comment {
        padding: 20px;
    }

    textarea {
        height: 100px; /* Adjust textarea height for mobile */
    }
}


    </style>
</head>
<body>
<main>
    <h2>Create a Post</h2>
    <?php if ($isLoggedIn): ?>
        <form method="POST" enctype="multipart/form-data">
            <textarea name="content" placeholder="What's on your mind?" required></textarea>
            <label><input type="checkbox" name="is_anonymous"> Post Anonymously</label>
            <input type="file" name="photo" accept="image/*">
            <button type="submit" name="new_post">Post</button>
        </form>
    <?php else: ?>
        <p>Please <a href="/labogon/login.php">log in</a> to post.</p>
    <?php endif; ?>

    <h2>Newsfeed</h2>
    <?php foreach ($posts as $post): ?>
        <div class="post">
            <div class="post-header">
                <strong><?php echo $post['is_anonymous'] ? 'Anonymous' : htmlspecialchars($post['user_name']); ?></strong>
                <small><?php echo $post['created_at']; ?></small>
            </div>
            <p><?php echo htmlspecialchars($post['content']); ?></p>
            <?php if ($post['photo_path']): ?>
                <img src="<?php echo $post['photo_path']; ?>" alt="Post Image">

<?php endif; ?>

            <h4>Comments</h4>
            <?php
            $commentsStmt->execute(['post_id' => $post['post_id']]);
            foreach ($commentsStmt->fetchAll() as $comment): ?>
                <div class="comment">
                    <strong><?php echo htmlspecialchars($comment['username']); ?>:</strong>
                    <p><?php echo htmlspecialchars($comment['comment']); ?></p>
                    <small><?php echo $comment['created_at']; ?></small>
                </div>
            <?php endforeach; ?>

            <?php if ($isLoggedIn): ?>
                <form method="POST">
                    <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                    <textarea name="comment" placeholder="Write a comment..." required></textarea>
                    <label><input type="checkbox" name="comment_is_anonymous"> Comment Anonymously</label>
                    <button type="submit" name="new_comment">Comment</button>
                </form>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</main>
</body>
</html>
