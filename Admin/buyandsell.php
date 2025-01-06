<?php

// Create connection
$conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'if0_38046482_barangay_labogon');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->close();
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
      <span class="ms-1 font-weight-bold text-white">Brgy Labogon Admin</span>
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
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
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
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Type here...</label>
              <input type="text" class="form-control">
            </div>
          </div>
            <ul class="navbar-nav  justify-content-end">
            
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
              </a>
            </li>
            <li class="nav-item dropdown pe-2 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-bell cursor-pointer"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barangay_labogon";

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch pending sales
$pendingSales = $conn->query("SELECT id, product_name, product_category, description, seller_name, contact_number, email, image_name, created_at FROM buy_and_sell WHERE LOWER(status) = 'pending'");
if (!$pendingSales) {
    die("Error in query (Pending Sales): " . $conn->error);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="/labogon/material-dashboard-2/assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }
        .product-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            width: 300px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .product-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .product-card h3 {
            font-size: 18px;
            margin: 0 0 10px;
        }
        .product-card p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .action-buttons button {
            flex: 1;
            padding: 10px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 0 5px;
        }
        .approve-btn {
            background-color: #4CAF50;
            color: white;
        }
        .reject-btn {
            background-color: #f44336;
            color: white;
        }
        .approve-btn:hover {
            background-color: #45a049;
        }
        .reject-btn:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center; margin-top: 20px;">Pending Sales</h1>
    <div class="container">
        <?php if ($pendingSales->num_rows > 0): ?>
            <?php while ($row = $pendingSales->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="/labogon/Pages/ProductImage/<?= htmlspecialchars($row['image_name']) ?>" alt="Product Image">
                    <h3><?= htmlspecialchars($row['product_name']) ?></h3>
                    <p><strong>Category:</strong> <?= htmlspecialchars($row['product_category']) ?></p>
                    <p><strong>Description:</strong> <?= htmlspecialchars($row['description']) ?></p>
                    <p><strong>Seller:</strong> <?= htmlspecialchars($row['seller_name']) ?></p>
                    <p><strong>Contact:</strong> <?= htmlspecialchars($row['contact_number']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($row['email']) ?></p>
                    <p><strong>Posted on:</strong> <?= htmlspecialchars($row['created_at']) ?></p>
                    <div class="action-buttons">
                        <button class="approve-btn" onclick="validateProduct(<?= $row['id'] ?>, 'approved')">Approve</button>
                        <button class="reject-btn" onclick="validateProduct(<?= $row['id'] ?>, 'rejected')">Reject</button>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; font-size: 16px; color: #777;">No pending sales to display.</p>
        <?php endif; ?>
    </div>
    <script>
        function validateProduct(productId, action) {
            fetch('/labogon/Handler/validateProduct.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `product_id=${productId}&action=${action}`
            })
            .then(response => response.text())
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data,
                }).then(() => location.reload());
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing the request.',
                });
            });
        }
    </script>
</body>
</html>


    
        
       
 <!-- Core JS Files -->
<script src="/labogon/material-dashboard-2/assets/js/core/popper.min.js"></script>
<script src="/labogon/material-dashboard-2/assets/js/core/bootstrap.min.js"></script>
<script src="/labogon/material-dashboard-2/assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="/labogon/material-dashboard-2/assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="/labogon/material-dashboard-2/assets/js/plugins/chartjs.min.js"></script>

 
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
    <!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="/labogon/material-dashboard-2/assets/js/material-dashboard.min.js?v=3.0.0"></script>

</body>

</html>