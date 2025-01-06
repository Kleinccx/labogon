<?php
session_start();
$conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'if0_38046482_barangay_labogon');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$userId = $isLoggedIn ? $_SESSION['user_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waste management</title>
    <link rel="stylesheet" href="/labogon/style.css">
    <style>
        select, option {
            padding: 10px;
            font-size: 16px;
        }

        label {
            font-size: 18px;
            margin-bottom: 8px;
        }

        .form-container {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .logo-text {
            font-size: 24px;
            font-weight: bold;
        }

        .logo-text span {
            color: #4CAF50;
        }

        main {
            padding: 20px;
        }

        h2 {
            font-size: 3rem;
            font-weight: 700;
            line-height: 1.1;
            color: #c0c0c0;
            text-align: center;
            padding: 4rem;
        }

        .schedule-details {
            margin-top: 20px;
            font-size: 18px;
            color: #555;
        }
    </style>
</head>
<body>

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
                <li><a class="main-nav-link" href="schedules.php">Schedules</a></li>

                <li><a class="main-nav-link nav-cta" href="/labogon/login.php">Sign In</a></li>
            </ul>
        <?php endif; ?>
    </nav>
</header>

<main>
    <div class="form-container">
        <h2>Select Driver to See the Schedule</h2>
        <form action="" method="POST" onsubmit="return false;">
            <label for="driver">Select Driver</label>
            <select name="driver" id="driver" onchange="updateScheduleDetails()">
                <option value="" disabled selected>Select a Driver</option>
                <option value="ETOL">ETOL</option>
                <option value="PERCIVAL">PERCIVAL</option>
                <option value="FERNANDO">FERNANDO MANATAD</option>
                <option value="WILMER">WILMER BARTO CES</option>
            </select>
            
            <div id="schedule-details" class="schedule-details"></div>
        </form>
    </div>
</main>

<script>
    function updateScheduleDetails() {
        var driver = document.getElementById("driver").value;
        var scheduleDetails = document.getElementById("schedule-details");

        scheduleDetails.innerHTML = ''; // Clear any previous schedule details

        if (driver === "ETOL") {
            scheduleDetails.innerHTML = `
                <h3>ETOL Schedule:</h3>
                <ul>
                    <li>DONA ROSARIO - 12TH STREET</li>
                    <li>COMPANY: SHEMBERG, TRIPPLE I, DINO, LPC</li>
                    <li>13TH STREET</li>
                    <li>14TH STREET</li>
                    <li>8TH STREET</li>
                    <li>9TH STREET</li>
                    <li>AREAS: SKENA EPAY, TABAY, UPPER LABOGON, SLIDING HILLS</li>
                    <li>INTERIOR HOUSEHOLD - PICK-UP (MONDAY + FRIDAY)</li>
                    <li>PUNDO (TUESDAY + THURSDAY)</li>
                    <li>EVERY WEDNESDAY PICK-UP</li>
                </ul>
            `;
        } else if (driver === "PERCIVAL") {
            scheduleDetails.innerHTML = `
                <h3>PERCIVAL Schedule:</h3>
                <ul>
                    <li>INTERIOR HOUSEHOLD - PICK-UP (MONDAY + FRIDAY)</li>
                    <li>AREAS: STO NINO, HIGH SCHOOL, JEPOY, Cincos, CAIMITO</li>
                    <li>PUN DD (TUESDAY + THURSDAY)</li>
                    <li>MAHAYAHAY</li>
                    <li>EVERY WEDNESDAY PICK-UP: DONA ROSARIO - 3RD STREET</li>
                    <li>COMPANY: MS, JAY, 4TH STREET, 6TH STREET, ILTH STREET, UY MASOY, SUPREA, TOSING AGBAY</li>
                </ul>
            `;
        } else if (driver === "FERNANDO") {
            scheduleDetails.innerHTML = `
                <h3>FERNANDO MANATAD Schedule:</h3>
                <ul>
                    <li>INTERIOR HOUSEHOLD - PICK-UP (MONDAY + FRIDAY)</li>
                    <li>PUNDO (TUESDAY + THURSDAY)</li>
                    <li>AREAS: STO NINO, HIGH SCHOOL, JEPOY, Cincos, CAIMITO</li>
                    <li>EVERY WEDNESDAY</li>
                    <li>MAHAYAHAY PICK-UP</li>
                    <li>DONA ROSARIO - 3RD STREET, 4TH STREET, 6TH STREET, 11TH STREET</li>
                    <li>COMPANY: UY MASOY, MS, SUPREA, TOSING AGBAY</li>
                </ul>
            `;
        } else if (driver === "WILMER") {
            scheduleDetails.innerHTML = `
                <h3>WILMER BARTO CES Schedule:</h3>
                <ul>
                    <li>INTERIOR HOUSEHOLD - PICK-UP (MONDAY + FRIDAY)</li>
                    <li>PUNDO (TUESDAY + THURSDAY)</li>
                    <li>AREAS: LATASAN, KAMANGGAHAN, LONGGA KIT, STA. CRUZ, KALUBIHAN, SKENA LABOGON</li>
                    <li>EVERY WEDNESDAY: DONA ROSARIO - 5TH STREET, 7TH STREET, 10TH STREET, SAN JOSE 2</li>
                    <li>COMPANY: BEGGY MEN, IDEA, PEDRI COS, SUGECO, LPC, ASTA GLASS, SOCOR, AGUILA GLASS, GELTECH, DINU, LPC</li>
                </ul>
            `;
        } else {
            scheduleDetails.innerHTML = '<p>Please select a driver to view the schedule.</p>';
        }
    }

    window.onload = function() {
        updateScheduleDetails();
    };
</script>
<style>
     body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f5f5f5;
        }

        .main-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 20px;
            margin: 20px;
        }

        .category-container {
            width: 45%;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .category-container h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 350px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px;
        }

        .card .header {
            background: linear-gradient(135deg, #4CAF50, #2196F3);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .card .header .logo {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card .header h2 {
            margin: 10px 0;
            font-size: 1.4rem;
        }

        .card .footer {
            text-align: center;
            padding: 10px;
            background: #f1f1f1;
        }

        .card .footer button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
        }

        .card .footer button:hover {
            background-color: #45a049;
        }

        .logo i {
            font-size: 24px;
        }

        .category-container {
            margin-top: 30px;
        } 
</style>
<div class="main-container">
    <!-- Garbage Collection Appointments -->
    <div class="category-container">
        <h1>Schedule Plastic Bottle Collection</h1>
        <div class="card-container">
            <div class="card">
                <div class="header">
                    <div class="logo">
                        <img src="/labogon/garbagelogo.jpg" alt="Garbage Logo" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;">
                    </div>
                    <h2 style="margin-left: 10px;">Plastic Bottle Collection</h2> <!-- Added margin-top -->
                </div>
                <div class="footer">
                    <a href="garbagecollection.php"><button>Schedule Collection</button></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
