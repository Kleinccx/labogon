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
       
          </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <?php
$conn = new mysqli('localhost', 'root', '', 'barangay_labogon');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize SweetAlert response
$sweetalert_message = "";

if (isset($_POST['approve'])) {
    $id = $_POST['id'];
    $update_sql = "UPDATE garbage_collection SET status = 'done' WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        $_SESSION['notification'] = "Your garbage collection appointment has been approved.";
    } else {
        $_SESSION['notification'] = "Failed to update appointment status.";
    }
    $stmt->close();
    // Redirect to prevent resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit; // Make sure the script doesn't continue executing
}

if (isset($_POST['decline'])) {
    $id = $_POST['id'];
    $update_sql = "UPDATE garbage_collection SET status = 'declined' WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        $_SESSION['notification'] = "Your garbage collection appointment has been declined.";
    } else {
        $_SESSION['notification'] = "Failed to decline the appointment.";
    }
    $stmt->close();
    // Redirect to prevent resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit; // Make sure the script doesn't continue executing
}


ob_end_flush();
?>
<script>
    const approveButtons = document.querySelectorAll('button[name="approve"]');
    const declineButtons = document.querySelectorAll('button[name="decline"]');

    approveButtons.forEach(button => {
        button.addEventListener('click', function() {
            this.disabled = true;
            this.innerHTML = "Processing...";
        });
    });

    declineButtons.forEach(button => {
        button.addEventListener('click', function() {
            this.disabled = true;
            this.innerHTML = "Processing...";
        });
    });
</script>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Garbage Collection Appointments</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-200">
<div class="container mt-5">
  <h1 class="mb-4">Garbage Collection Appointments</h1>
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Schedule Date</th>
        <th>Schedule Time</th>
        <th>Location</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['schedule_date']) ?></td>
            <td><?= htmlspecialchars($row['schedule_time']) ?></td>
            <td><?= htmlspecialchars($row['location']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td>
              <?php if ($row['status'] == 'approved'): ?>
                <form method="POST" class="d-inline">
                  <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                  <button type="submit" name="notify" class="btn btn-warning btn-sm">Notify</button>
                </form>
              <?php elseif ($row['status'] != 'approved' && $row['status'] != 'on the way' && $row['status'] != 'done' && $row['status'] != 'declined'): ?>
                <form method="POST" class="d-inline">
                  <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                  <button type="submit" name="approve" class="btn btn-success btn-sm">Approve</button>
                </form>
                <form method="POST" class="d-inline">
                  <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                  <button type="submit" name="decline" class="btn btn-danger btn-sm">Decline</button>
                </form>
              <?php else: ?>
                <span class="text-success"><?= htmlspecialchars($row['status']) ?></span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="7" class="text-center">No appointments found</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php if (!empty($_SESSION['sweetalert_message'])): ?>
<script>
    <?= $_SESSION['sweetalert_message'] ?>;
</script>
<?php unset($_SESSION['sweetalert_message']); // Clear the message ?>
<?php endif; ?>


</body>
</html>
