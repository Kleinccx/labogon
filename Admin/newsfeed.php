<?php
ob_start(); // Start output buffering

  session_start();
  $conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'if0_38046482_barangay_labogon');
  
  // Redirect if the user is not logged in or not an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
  header("Location: /labogon/login.php"); // Redirect to the login page
  exit; // Stop further execution
}
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  
  // Fetch all garbage collection appointments
  $sql = "SELECT * FROM garbage_collection ORDER BY schedule_date, schedule_time";
  $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="/labogon/material-dashboard-2/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="/labogon/material-dashboard-2/assets/img/favicon.png">
  <title>
    Barangay Labogon
  </title>
  <!-- Fonts and icons -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="/labogon/material-dashboard-2/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="/labogon/material-dashboard-2/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="/labogon/material-dashboard-2/assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
</head>


<body class="g-sidenav-show bg-gray-200">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="https://demos.creative-tim.com/material-dashboard/pages/dashboard" target="_blank">
      <img src="/labogon/Images/Labogonphotos/logolabogon.jpg" class="navbar-brand-img h-100" alt="main_logo">
      <span class="ms-1 font-weight-bold text-white">Brgy Labogon Admin2</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white active bg-gradient-primary" href="./home.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Home</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="./buyandsell.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Buy & Sell</span>
          </a>
        </li>
      
        <li class="nav-item">
          <a class="nav-link text-white " href="./newsfeed.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">view_in_ar</i>
            </div>
            <span class="nav-link-text ms-1">Newsfeed</span>
          </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link text-white " href="./events.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">notifications</i>
            </div>
            <span class="nav-link-text ms-1">Events</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="./appointments.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">house</i>
            </div>
            <span class="nav-link-text ms-1">Garbage Appointment</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="./documentappointment.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">info</i>
            </div>
            <span class="nav-link-text ms-1">Document Appointment</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="./applicationappointment.php">
            <div class="text-white text-center me-3 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">house</i>
            </div>
            <span class="nav-link-text ms-1">Brgy Appointment</span>
          </a>
        </li>
       
        <li class="nav-item">
          <a class="nav-link text-white " href="./logout.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">logout</i>
            </div>
            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </li>
      
      </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <div class="mx-3">
      </div>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
           
          </ol>
        </nav>
       
          </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <?php
$conn = new mysqli('localhost', 'root', '', 'barangay_labogon');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_event'])) {
    $event_name = $conn->real_escape_string($_POST['event_name']);
    $event_date = $conn->real_escape_string($_POST['event_date']);
    $event_description = $conn->real_escape_string($_POST['event_description']);

    $target_dir = "C:/xampp/htdocs/labogon/Uploads/";
    $target_file = $target_dir . basename($_FILES["event_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["event_image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<script>Swal.fire('Error', 'File is not an image.', 'error');</script>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["event_image"]["size"] > 500000) {
        echo "<script>Swal.fire('Error', 'Sorry, your file is too large.', 'error');</script>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<script>Swal.fire('Error', 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.', 'error');</script>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<script>Swal.fire('Error', 'Sorry, your file was not uploaded.', 'error');</script>";
    } else {
        if (move_uploaded_file($_FILES["event_image"]["tmp_name"], $target_file)) {
            $relative_path = "Uploads/" . basename($_FILES["event_image"]["name"]);
            $sql = "INSERT INTO events (name, date, description, image) VALUES ('$event_name', '$event_date', '$event_description', '$relative_path')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>Swal.fire('Success', 'Event added successfully!', 'success');</script>";
            } else {
                echo "<script>Swal.fire('Error', 'Error: " . $conn->error . "', 'error');</script>";
            }
        } else {
            echo "<script>Swal.fire('Error', 'Sorry, there was an error uploading your file.', 'error');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 300px;
            text-align: center;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card h3 {
            font-size: 20px;
            color: #4CAF50;
            margin: 10px 0;
        }

        .card p {
            font-size: 14px;
            color: #555;
            margin: 0 10px 10px;
        }

        .card .date {
            font-size: 12px;
            color: #999;
            margin-bottom: 10px;
        }

        .add-event-form {
            max-width: 600px;
            margin: 20px auto;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .add-event-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .add-event-form label {
            font-weight: bold;
            display: block;
            margin: 10px 0 5px;
        }

        .add-event-form input, .add-event-form textarea, .add-event-form button {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .add-event-form button {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .add-event-form button:hover {
            background-color: #45a049;
        }

        .nav-item a:hover, .nav-item a.active {
            background-color: #45a049 !important;
            color: white !important;
        }
    </style>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

// Database connection
$host = 'localhost';
$db = 'barangay_labogon';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Redirect if the user is not logged in or not an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: /labogon/login.php"); // Redirect to the login page
    exit; // Stop further execution
}

// Handle post validation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['post_id'];
    $action = $_POST['action'];

    $isApproved = ($action === 'approve') ? 1 : 0;

    // Update post approval status in the database
    $stmt = $pdo->prepare("UPDATE posts SET is_approved = ? WHERE id = ?");
    $stmt->execute([$isApproved, $postId]);

    // Redirect to the admin/newsfeed.php page after post approval or disapproval
    header('Location: admin/newsfeed.php');
    exit;
}


// Fetch all unapproved posts
$stmt = $pdo->query("
    SELECT posts.id AS post_id, posts.content, posts.created_at, 
           user_table.user_name
    FROM posts
    LEFT JOIN user_table ON posts.user_id = user_table.id
    WHERE posts.is_approved = 0
    ORDER BY posts.created_at DESC
");
$posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Validation</title>
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
    <h1>Post Validation</h1>

    <?php foreach ($posts as $post): ?>
        <div class="post">
            <strong>Posted by: <?php echo htmlspecialchars($post['user_name']); ?></strong>
            <p><?php echo htmlspecialchars($post['content']); ?></p>
            <?php if ($post['photo_path']): ?>
    <img src="/labogon/<?php echo $post['photo_path']; ?>" alt="Post Image">
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
