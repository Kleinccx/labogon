<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'if0_38046482_barangay_labogon');
  if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieving form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Set default user type to 'user'
    $user_type = 'user';

    // Prepare the SQL statement with the correct table name and columns
    $stmt = $conn->prepare("INSERT INTO user_table (user_name, user_email, password, user_type) VALUES (?, ?, ?, ?)");

    if ($stmt === false) {
        die("Error preparing the query: " . $conn->error);
    }

    $bind_result = $stmt->bind_param("ssss", $username, $email, $passwordHash, $user_type);

    if ($bind_result === false) {
        die("Error binding parameters: " . $stmt->error);
    }

    if ($stmt->execute()) {
        // Redirect to login page after successful registration
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="mediaquery.css">
    <style>
        .vh-100 {
            height: 100vh;
        }
        .container-fluid.h-custom {
            height: 100%;
        }
        .row.d-flex.justify-content-center.align-items-center {
            height: 100%;
        }
        .login-form-container {
            max-width: 400px;
            margin: 0 auto;
        }
        .image-container {
            margin-left: 200px;
        }
        /* Hide the user type field */
        .user-type-container {
            display: none;
        }
    </style>
</head>
<body>

<!--NAVIGATION BAR-->
<header class="header">
    <div class="logo-img">
        <img class="logopic" src="/labogon/logo.png" alt="" />
    </div>
    <nav class="main-nav">
        <ul class="main-nav-list">
            <li><a class="main-nav-link" href="Pages/buyandsell.php">Buy & Sell</a></li>
            <li><a class="main-nav-link" href="Pages/events.php">Events</a></li>
            <li><a class="main-nav-link" href="Pages/newsfeed.php">NewsFeed</a></li>
            <li><a class="main-nav-link" href="Pages/appointments.php">Appointment</a></li>
            <li><a class="main-nav-link" href="Pages/schedules.php">Schedules</a></li>

            <?php if (isset($_SESSION['username']) && !empty($_SESSION['username'])): ?>
                <!-- If the user is logged in, show the username and a logout link -->
                <li class="nav-cta">
                    <li>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</li>
                    <li><a class="main-nav-link nav-cta" href="logout.php?role=user">Logout</a></li>
                </li>
            <?php else: ?>
                <!-- If the user is not logged in, show the "Sign In" button -->
                <li><a class="main-nav-link nav-cta" href="/labogon/login.php">Sign In</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <button class="btn-mobile-nav">
        <ion-icon class="icon-mobile-nav" name="menu-outline"></ion-icon>
        <ion-icon class="icon-mobile-nav" name="close-outline"></ion-icon>
    </button>
</header>
<!--END NAVIGATION BAR-->

<section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5 image-container">
        <img src="images/Labogonphotos/login-picture.jpg" class="img-fluid" alt="Login Image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 login-form-container">
        <form action="registration.php" method="POST">
          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
            <p class="lead fw-normal mb-0 me-3">Register</p>
          </div>

          <div class="divider d-flex align-items-center my-4"></div>

          <div class="form-outline mb-4">
            <p class="lead fw-normal mb-0 me-3">Username</p>
            <input type="text" name="username" class="form-control form-control-lg" required />
          </div>

          <div class="form-outline mb-4">
            <p class="lead fw-normal mb-0 me-3">Email Address</p>
            <input type="email" name="email" class="form-control form-control-lg" required />
          </div>

          <div class="form-outline mb-4">
            <p class="lead fw-normal mb-0 me-3">Password</p>
            <input type="password" name="password" class="form-control form-control-lg" required />
          </div>

          <!-- Hide User Type Field -->
          <div class="form-outline mb-4 user-type-container">
            <p class="lead fw-normal mb-0 me-3">User Type</p>
            <select name="user_type" class="form-control form-control-lg" disabled>
                <option value="user" selected>User</option>
            </select>
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Register</button>
            <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a href="login.php" class="link-danger">Login</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
