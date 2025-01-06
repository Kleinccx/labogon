<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
  header("Location: /labogon/login.php");
  exit;
}
$conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'if0_38046482_barangay_labogon');


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Count total garbage collection appointments
$sql = "SELECT COUNT(*) AS total_appointments FROM garbage_collection";
$result = $conn->query($sql);

$totalAppointments = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalAppointments = $row['total_appointments'];
}

// Count total users with user_type 'user'
$sql = "SELECT COUNT(*) AS total_users FROM user_table WHERE user_type = 'user'";
$result = $conn->query($sql);

$totalUsers = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalUsers = $row['total_users'];
}

// Categories to count
$categories = ['Appliances', 'Bottles', 'Scrap Metals', 'Others'];
$soldCounts = [];

// Fetch counts for each category
foreach ($categories as $category) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM buy_and_sell WHERE product_category = ? AND status = 'sold'");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $soldCounts[$category] = $row['count'] ?? 0;
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
    Labogon
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


<style>
    .nav-link {
    transition: all 0.3s ease;
}

.nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 5px;
}

.nav-link.active {
    background-color: #2196F3; /* Example active background color */
    color: #fff !important; /* Ensures the active text color is white */
    border-radius: 5px;
}

</style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
    const navLinks = document.querySelectorAll('.nav-link');

    // Remove active class from all links and add to the clicked one
    navLinks.forEach(link => {
        link.addEventListener('click', function () {
            navLinks.forEach(link => link.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Set active link based on the current page URL
    const currentPage = window.location.pathname.split("/").pop();
    navLinks.forEach(link => {
        if (link.getAttribute('href') === `./${currentPage}`) {
            link.classList.add('active');
        }
    });
});

</script>

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
            <span class="nav-link-text ms-1">Event</span>
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
    <a class="nav-link text-white" href="./logout.php?role=admin">
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Waste Management Analytics</li>
          </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
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
              <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="./assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New message</span> from Laur
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          13 minutes ago
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="./assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">New album</span> by Travis Scott
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          1 day
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                          <title>credit-card</title>
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                              <g transform="translate(1716.000000, 291.000000)">
                                <g transform="translate(453.000000, 454.000000)">
                                  <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                  <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                </g>
                              </g>
                            </g>
                          </g>
                        </svg>
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          Payment successfully completed
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          2 days
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">calendar_today</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Total Appointments</p>
                        <h4 class="mb-0"><?php echo number_format($totalAppointments); ?></h4>
                    </div>
                </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
        <div class="card-header p-3 pt-2">
            <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">person</i>
            </div>
            <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Barangay Citizens Users</p>
                <h4 class="mb-0"><?php echo number_format($totalUsers); ?></h4>
            </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
        </div>
    </div>
</div>
<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">kitchen</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Bottles Sold Count</p>
                    <h4 class="mb-0"><?php echo $soldCounts['Bottles']; ?></h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-3 pt-2">
                <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                    <i class="material-icons opacity-10">kitchen</i>
                </div>
                <div class="text-end pt-1">
                    <p class="text-sm mb-0 text-capitalize">Appliances Sold Count</p>
                    <h4 class="mb-0"><?php echo $soldCounts['Appliances']; ?></h4>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
            </div>
        </div>
    </div>
    <div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-lg border-0">
            <div class="card-header text-center" style="background-color: #FFFFFF; color: #333; border-bottom: 1px solid #E0E0E0;">
                <h5 class="mb-0 font-weight-bold">TOTAL SOLD PRODUCTS BY CATEGORY</h5>
            </div>
            <div class="card-body">
                <canvas id="soldProductsChart" style="height: 400px;"></canvas>
            </div>
        </div>  
    </div>
</div> 

<div class="container mt-5">
    <!-- Chart Section -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="height: 50vh; background-color: #FFFFFF; color: #333;">
                <div class="card-header text-center" style="background: linear-gradient(135deg, #E3F2FD, #BBDEFB); color: #333;">
                    <h3 class="mb-0 font-weight-bold">TOTAL WASTE MANAGEMENT BY MONTH</h3>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div style="width: 100%; height: 100%; position: relative;">
                        <canvas id="wasteManagementChart" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Input Form -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header text-center" style="background: linear-gradient(135deg, #E3F2FD, #BBDEFB); color: #333;">
                    <h3 class="mb-0 font-weight-bold">Add Monthly Waste Data</h3>
                </div>
                <div class="card-body">
                    <form id="wasteDataForm">
                        <div class="form-group mb-3">
                            <label for="yearInput">Year</label>
                            <input type="number" id="yearInput" class="form-control" placeholder="Enter year (e.g., 2024)" value="2024" min="2000" max="2100" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="monthDropdown">Month</label>
                            <select id="monthDropdown" class="form-control">
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="weightInput">Weight (kg)</label>
                            <input type="number" id="weightInput" class="form-control" placeholder="Enter weight in kg" min="0" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Data Button -->
    <div class="row mt-4">
        <div class="col-12 text-center">
            <button id="resetDataButton" class="btn btn-danger">Reset All Data</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('wasteManagementChart').getContext('2d');

        // Load data from localStorage or initialize with default data
        const savedData = JSON.parse(localStorage.getItem('wasteData')) || {};

        // Default selected year
        let selectedYear = '2024';

        // Ensure the selected year exists in data
        if (!savedData[selectedYear]) {
            savedData[selectedYear] = {
                months: [
                    'January', 'February', 'March', 'April', 
                    'May', 'June', 'July', 'August', 
                    'September', 'October', 'November', 'December'
                ],
                weights: [
                    65520, 0, 12390, 40230, 0, 0, 0, 
                    15210, 0, 4400, 0, 17480
                ]
            };
        }

        // Gradient for the line
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(33, 150, 243, 0.5)');
        gradient.addColorStop(1, 'rgba(33, 150, 243, 0)');

        // Chart instance
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: savedData[selectedYear].months,
                datasets: [{
                    label: `Total Weight (kg) - ${selectedYear}`,
                    data: savedData[selectedYear].weights,
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: '#1E88E5',
                    borderWidth: 3,
                    pointBackgroundColor: '#1E88E5',
                    pointBorderColor: '#ffffff',
                    pointRadius: 4,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: true },
                    tooltip: { enabled: true },
                    title: {
                        display: true,
                        text: `Monthly Waste Management (${selectedYear})`,
                        font: {
                            size: 20,
                            weight: 'bold',
                            family: 'Arial'
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true },
                    x: { grid: { display: false } }
                }
            }
        });

        // Form submission handler
        document.getElementById('wasteDataForm').addEventListener('submit', (e) => {
            e.preventDefault();

            const yearInput = document.getElementById('yearInput').value.trim();
            const monthInput = document.getElementById('monthDropdown').value.trim();
            const weightInput = parseFloat(document.getElementById('weightInput').value.trim());

            if (yearInput && monthInput && !isNaN(weightInput)) {
                if (!savedData[yearInput]) savedData[yearInput] = { months: [], weights: [] };
                const yearData = savedData[yearInput];
                const monthIndex = yearData.months.indexOf(monthInput);

                if (monthIndex !== -1) {
                    yearData.weights[monthIndex] = weightInput;
                } else {
                    yearData.months.push(monthInput);
                    yearData.weights.push(weightInput);
                }

                localStorage.setItem('wasteData', JSON.stringify(savedData));
                if (selectedYear === yearInput) {
                    chart.data.labels = yearData.months;
                    chart.data.datasets[0].data = yearData.weights;
                    chart.update();
                }
                document.getElementById('wasteDataForm').reset();
            }
        });

        document.getElementById('yearInput').addEventListener('input', (e) => {
            selectedYear = e.target.value.trim();
            if (!savedData[selectedYear]) savedData[selectedYear] = { months: [], weights: [] };
            const yearData = savedData[selectedYear];
            chart.data.labels = yearData.months;
            chart.data.datasets[0].data = yearData.weights;
            chart.data.datasets[0].label = `Total Weight (kg) - ${selectedYear}`;
            chart.options.plugins.title.text = `Monthly Waste Management (${selectedYear})`;
            chart.update();
        });

        document.getElementById('resetDataButton').addEventListener('click', () => {
            if (confirm('Are you sure you want to reset all data? This action cannot be undone.')) {
                localStorage.removeItem('wasteData');
                location.reload();
            }
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('soldProductsChart').getContext('2d');

        // Categories and dynamic PHP-based data
        const initialCategories = ['Appliances', 'Bottles', 'Scrap Metals', 'Others'];
        const initialSoldCounts = [<?php echo implode(',', array_values($soldCounts)); ?>];

        // Chart.js configuration
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: initialCategories,
                datasets: [{
                    label: 'Sold Items',
                    data: initialSoldCounts,
                    backgroundColor: ['#FFA726', '#66BB6A', '#42A5F5', '#AB47BC'], // Bright colors for bars
                    borderColor: ['#FB8C00', '#388E3C', '#1976D2', '#8E24AA'], // Darker edges
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }, // No legend
                    tooltip: {
                        enabled: true,
                        backgroundColor: '#333',
                        titleFont: { size: 14, weight: 'bold', color: '#FFF' },
                        bodyFont: { size: 12, color: '#FFF' }
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'top',
                        color: '#FFF',
                        font: { size: 14, weight: 'bold' },
                        formatter: (value, ctx) => ctx.chart.data.datasets[0].data[ctx.dataIndex], // Numbers inside the bars
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#E0E0E0' },
                        ticks: {
                            font: { size: 12, family: 'Arial' },
                            color: '#333'
                        },
                        title: { display: false } // No title on y-axis
                    },
                    x: {
                        grid: { display: false }, // No grid lines
                        ticks: {
                            font: { size: 12, family: 'Arial' },
                            color: '#333'
                        },
                        title: { display: false } // No title on x-axis
                    }
                },
                layout: {
                    padding: {
                        top: 20,
                        left: 10,
                        right: 10,
                        bottom: 10
                    }
                }
            },
            plugins: [
                {
                    id: 'dottedLines', // Plugin to add dotted lines and dots above bars
                    afterDatasetsDraw: (chart) => {
                        const { ctx, chartArea, scales } = chart;
                        const dataset = chart.data.datasets[0].data;

                        dataset.forEach((value, index) => {
                            const x = scales.x.getPixelForValue(index);
                            const y = scales.y.getPixelForValue(value);

                            // Draw dashed line
                            ctx.beginPath();
                            ctx.setLineDash([5, 5]);
                            ctx.moveTo(x, y);
                            ctx.lineTo(x, chartArea.top + 10);
                            ctx.strokeStyle = '#333';
                            ctx.lineWidth = 1;
                            ctx.stroke();

                            // Draw dot
                            ctx.setLineDash([]);
                            ctx.beginPath();
                            ctx.arc(x, chartArea.top + 10, 4, 0, 2 * Math.PI);
                            ctx.fillStyle = chart.data.datasets[0].backgroundColor[index];
                            ctx.fill();
                        });
                    }
                }
            ]
        });
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>




<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chart;

    document.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('soldProductsChart').getContext('2d');
        const initialCategories = ['Appliances', 'Bottles', 'Scrap Metals', 'Others'];
        const initialSoldCounts = [<?php echo implode(',', array_values($soldCounts)); ?>];

        chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: initialCategories,
                datasets: [{
                    label: 'Sold Items',
                    data: initialSoldCounts,
                    backgroundColor: ['#4CAF50', '#2196F3', '#FFC107', '#FF5722'],
                    borderColor: ['#388E3C', '#1976D2', '#FFA000', '#E64A19'],
                    borderWidth: 2,
                    hoverBackgroundColor: ['#66BB6A', '#42A5F5', '#FFD54F', '#FF8A65'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: true },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#eee' },
                        title: { display: true, text: 'Count', font: { size: 14 } },
                    },
                    x: {
                        grid: { display: false },
                        title: { display: true, text: 'Category', font: { size: 14 } },
                    }
                }
            }
        });
    });

    function changeStatus(productId, status) {
        fetch('/labogon/Handler/updateStatus.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `product_id=${productId}&status=${status}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);

                // Update the graph with new sold counts
                if (data.soldCounts) {
                    updateGraph(data.soldCounts);
                }
            } else {
                alert(data.message);
            }
        })
        .catch(() => alert('Failed to update product status.'));
    }

    function updateGraph(soldCounts) {
        const categories = ['Appliances', 'Bottles', 'Scrap Metals', 'Others'];
        const counts = categories.map(category => soldCounts[category] || 0);

        chart.data.datasets[0].data = counts;
        chart.update();
    }
</script>
    
  
      
        
       
 <!-- Core JS Files -->
<script src="/labogon/material-dashboard-2/assets/js/core/popper.min.js"></script>
<script src="/labogon/material-dashboard-2/assets/js/core/bootstrap.min.js"></script>
<script src="/labogon/material-dashboard-2/assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="/labogon/material-dashboard-2/assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="/labogon/material-dashboard-2/assets/js/plugins/chartjs.min.js"></script>

  <script>
    var ctx = document.getElementById("chart-bars").getContext("2d");

    new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["M", "T", "W", "T", "F", "S", "S"],
        datasets: [{
          label: "Sales",
          tension: 0.4,
          borderWidth: 0,
          borderRadius: 4,
          borderSkipped: false,
          backgroundColor: "rgba(255, 255, 255, .8)",
          data: [50, 20, 10, 22, 50, 10, 40],
          maxBarThickness: 6
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5],
              color: 'rgba(255, 255, 255, .2)'
            },
            ticks: {
              suggestedMin: 0,
              suggestedMax: 500,
              beginAtZero: true,
              padding: 10,
              font: {
                size: 14,
                weight: 300,
                family: "Roboto",
                style: 'normal',
                lineHeight: 2
              },
              color: "#fff"
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5],
              color: 'rgba(255, 255, 255, .2)'
            },
            ticks: {
              display: true,
              color: '#f8f9fa',
              padding: 10,
              font: {
                size: 14,
                weight: 300,
                family: "Roboto",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });


    var ctx2 = document.getElementById("chart-line").getContext("2d");

    new Chart(ctx2, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Mobile apps",
          tension: 0,
          borderWidth: 0,
          pointRadius: 5,
          pointBackgroundColor: "rgba(255, 255, 255, .8)",
          pointBorderColor: "transparent",
          borderColor: "rgba(255, 255, 255, .8)",
          borderColor: "rgba(255, 255, 255, .8)",
          borderWidth: 4,
          backgroundColor: "transparent",
          fill: true,
          data: [50, 40, 300, 320, 500, 350, 200, 230, 500],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5],
              color: 'rgba(255, 255, 255, .2)'
            },
            ticks: {
              display: true,
              color: '#f8f9fa',
              padding: 10,
              font: {
                size: 14,
                weight: 300,
                family: "Roboto",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#f8f9fa',
              padding: 10,
              font: {
                size: 14,
                weight: 300,
                family: "Roboto",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });

    var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

    new Chart(ctx3, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Mobile apps",
          tension: 0,
          borderWidth: 0,
          pointRadius: 5,
          pointBackgroundColor: "rgba(255, 255, 255, .8)",
          pointBorderColor: "transparent",
          borderColor: "rgba(255, 255, 255, .8)",
          borderWidth: 4,
          backgroundColor: "transparent",
          fill: true,
          data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5],
              color: 'rgba(255, 255, 255, .2)'
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#f8f9fa',
              font: {
                size: 14,
                weight: 300,
                family: "Roboto",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#f8f9fa',
              padding: 10,
              font: {
                size: 14,
                weight: 300,
                family: "Roboto",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>
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