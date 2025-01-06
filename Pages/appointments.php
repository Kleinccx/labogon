<?php

session_start();


// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$userId = $isLoggedIn ? $_SESSION['user_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Appointment</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="/labogon/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
}

form {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
}

form h1 {
    margin-bottom: 20px;
    font-size: 1.5em;
    text-align: center;
}

form label {
    display: block;
    margin: 10px 0 5px;
    font-weight: bold;
}

form input, form select, form button {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

form button {
    background: #007bff;
    color: white;
    border: none;
    cursor: pointer;
    font-weight: bold;
    transition: background 0.3s ease;
}

form button:hover {
    background: #0056b3;
}

#availabilityMessage {
    font-size: 0.9em;
    color: red;
    margin-top: -10px;
}

</style>
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
                <li><a class="main-nav-link" href="appointmentandapplication.php">Appointment</a></li>
                <li><a class="main-nav-link" href="wastemanagement.php">Waste Management</a></li>

                <li><a class="main-nav-link nav-cta" href="/labogon/login.php">Sign In</a></li>
            </ul>
        <?php endif; ?>
    </nav>

         <button class="btn-mobile-nav">
            <ion-icon class="icon-mobile-nav" name="menu-outline"></ion-icon>
            <ion-icon class="icon-mobile-nav" name="close-outline"></ion-icon>
         </button>
     </header>
     <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Cards</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- FontAwesome CDN -->
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
</head>
<body>
<div class="main-container">
    <!-- Documentation Schedule -->
    <div class="category-container">
        <h1>Documentation Appointment</h1>
        <div class="card-container">
            <div class="card">
                <div class="header">
                    <div class="logo">
                        <img src="/labogon/doculogo.jpg" alt="Document Logo" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;">
                    </div>
                    <h2 style="margin-left: 10px;">Documentation Appointment</h2> <!-- Adjusted title -->
                </div>
                <div class="footer">
                    <a href="documentationappointment.php"><button>Schedule Appointment</button></a>
                </div>
            </div>
        </div>
    </div>


    <div class="category-container">
        <h1>Application Appointment</h1>
        <div class="card-container">
            <div class="card">
                <div class="header">
                    <div class="logo">
                        <img src="/labogon/appointmentlogo.png" alt="Appointment Logo" style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;"> <!-- Updated logo -->
                    </div>
                    <h2 style="margin-top: 10px;">Appointment Application</h2> <!-- Added margin-top -->
                </div>
                <div class="footer">
                    <a href="appointmentandapplication.php"><button>Schedule Appointment</button></a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
