<?php
session_start();

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$userId = $isLoggedIn ? $_SESSION['user_id'] : null;

// Database connection
$conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'if0_38046482_barangay_labogon');

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Handle form submission for adding a new appointment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($userId)) {
    $scheduleDate = $_POST['schedule_date'];
    $scheduleTime = $_POST['schedule_time'];
    $location = $_POST['location'];
    $status = 'to pick up'; // Default status

    // Insert query without waste_category
    $stmt = $conn->prepare("INSERT INTO garbage_collection (schedule_date, schedule_time, location, status, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $scheduleDate, $scheduleTime, $location, $status, $userId);
    $stmt->execute();

    // Redirect after the insert
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch garbage collection data
$result = $conn->query("SELECT * FROM garbage_collection ORDER BY schedule_date, schedule_time");
$garbageCollections = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garbage Collection</title>
    <link rel="stylesheet" href="/labogon/style.css">
    <style>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        form {
            margin-bottom: 30px;
        }


        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #007bff;
            color: white;
        }

        .status-done {
            color: green;
            font-weight: bold;
        }

        .status-to-pick-up {
            color: orange;
            font-weight: bold;
        }

       

        .header h1 {
            margin: 0;
        }
 
.logo-text {
    font-size: 24px;
    font-weight: bold;
    margin-top: 0px; /* Add space between the image and text */
}

.logo-text span {
    color: #4CAF50;
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
                <li><a class="main-nav-link" href="wastemanagement.php">Waste Management</a></li>

                <li><a class="main-nav-link nav-cta" href="/labogon/login.php">Sign In</a></li>
            </ul>
        <?php endif; ?>
    </nav>
</header>

    <div class="container">
        <h2>Garbage Collection Appointment</h2>
        <form method="POST" action="">
        <form method="POST" action="">
    <label for="schedule_date">Schedule Date:</label>
    <input type="date" id="schedule_date" name="schedule_date" required>

    <label for="schedule_time">Schedule Time:</label>
    <input type="time" id="schedule_time" name="schedule_time" required>

    <label for="location">Location:</label>
    <input type="text" id="location" name="location" placeholder="Enter your location" required>

    <button type="submit">Add Appointment</button>
</form>
</body>
</html>
