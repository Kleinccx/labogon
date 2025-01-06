<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'if0_38046482_barangay_labogon');
  if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Corrected query to use the correct table name 'user_table'
    $stmt = $conn->prepare("SELECT id, user_name, password, user_type FROM user_table WHERE user_email = ?");

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die("Error preparing the query: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['user_name'];
            $_SESSION['user_type'] = $user['user_type'];

            // Redirect based on user type
            if ($user['user_type'] === 'admin') {
                header("Location: /labogon/Admin/home.php");
            } else {
                header("Location: /labogon/index.php");
            }
            exit;
        } else {
            echo "<script>alert('Invalid password.');</script>";
        }
    } else {
        echo "<script>alert('User not found.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>


    
<!DOCTYPE html>
<html lang="en">
<head>
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
                <li><a class="main-nav-link" href="Pages/garbagecollection.php">Appointment</a></li>
                <li><a class="main-nav-link" href="wastemanagement.php">Waste Management</a></li>

            
                <li><a class="main-nav-link nav-cta" href="/labogon/login.php">Sign In</a></li>
            </ul>
         </nav>

         <button class="btn-mobile-nav">
            <ion-icon class="icon-mobile-nav" name="menu-outline"></ion-icon>
            <ion-icon class="icon-mobile-nav" name="close-outline"></ion-icon>
         </button>
     </header>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="mediaquery.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Add Bootstrap and Font Awesome CSS links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Full height and center alignment for the section */
        .vh-100 {
            height: 100vh;
        }
        .container-fluid.h-custom {
            height: 100%;
        }
        .row.d-flex.justify-content-center.align-items-center {
            height: 100%;
        }
        /* Center the login card */
        .login-form-container {
            max-width: 400px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<style>
  .image-container {
    /* Move the image to the right */
    margin-left: 200px; /* Adjust this value to move the image further or closer */
  }
</style>
<section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5 image-container">
        <!-- Updated image source to point to your custom image in the 'images/Labogonphotos' folder -->
        <img src="images/Labogonphotos/login-picture.jpg" class="img-fluid" alt="Login Image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 login-form-container">
        <form action="login.php" method="POST">
          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
            <p class="lead fw-normal mb-0 me-3">Login</p>
           
          </div>

          <div class="divider d-flex align-items-center my-4">
          </div>

          <!-- Email input -->
          <div class="form-outline mb-4">
          <p class="lead fw-normal mb-0 me-3">Email Address</p>

            <input type="email" id="form3Example3" name="email" class="form-control form-control-lg" placeholder="" required />

          </div>

          <!-- Password input -->
          <div class="form-outline mb-3">
          <p class="lead fw-normal mb-0 me-3">Password</p>

            <input type="password" id="form3Example4" name="password" class="form-control form-control-lg" placeholder="" required />
            <label class="form-label" for="form3Example4">Password</label>
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <!-- Checkbox -->
            <div class="form-check mb-0">
            </div>
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="registration.php" class="link-danger">Register</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>
    <!-- Copyright -->
   
   
</section>

<!-- Add Bootstrap JS and Font Awesome JS links -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
