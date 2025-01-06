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
    <style>
      

        form {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        form h1 {
            margin-bottom: 30px;
            font-size: 2em;
            text-align: center;
            color: #333;
        }

        form label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
            font-size: 1.1em;
        }

        form input, form select, form button {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1em;
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
            font-size: 1em;
            color: red;
            margin-top: -10px;
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
                <li><a class="main-nav-link" href="">Buy & Sell</a></li>
                <li><a class="main-nav-link" href="">Events</a></li>
                <li><a class="main-nav-link" href="./newsfeed.php">NewsFeed</a></li>
                <li><a class="main-nav-link" href="">Appointment</a></li>
                <li><a class="main-nav-link" href="wastemanagement.php">Waste Management</a></li>

            
                <li>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</li>
                <li><a class="main-nav-link nav-cta" href="logout.php">Logout</a></li>
            </ul>
            <?php else: ?>
                <ul class="main-nav-list">
                    <li><a class="main-nav-link" href="">Buy & Sell</a></li>
                    <li><a class="main-nav-link" href="">Events</a></li>
                    <li><a class="main-nav-link" href="">NewsFeed</a></li>
                    <li><a class="main-nav-link" href="">Appointment</a></li>
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

    
    <form id="appointmentForm" action="/labogon/Handler/process_appointment.php" method="POST">
        <h1>Set Appointment</h1>
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" 
            placeholder="Enter your full name" required>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" 
            placeholder="Enter your address" required>

        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number" 
            pattern="[0-9]{10,15}" title="Enter a valid contact number (10-15 digits)" 
            required>

        <label for="appointment_with">Appointment With:</label>
        <select id="appointment_with" name="appointment_with" required>
            <option value="">Select</option>
            <option value="Barangay Chairman">Barangay Chairman</option>
            <option value="SK Chairman">SK Chairman</option>
        </select>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>

        <label for="time">Time:</label>
        <input type="time" id="time" name="time" required>

        <div id="availabilityMessage" style="display: none;">
            Selected date and time are unavailable. Please choose another.
        </div>

        <button type="submit">Set Appointment</button>
    </form>

    <script>
        $(document).ready(function () {
            $('#date, #time, #appointment_with').change(function () {
                const appointmentWith = $('#appointment_with').val();
                const date = $('#date').val();
                const time = $('#time').val();

                if (appointmentWith && date && time) {
                    $.ajax({
                        url: 'check_availability.php',
                        method: 'POST',
                        data: { appointment_with: appointmentWith, date: date, time: time },
                        success: function (response) {
                            if (response === 'unavailable') {
                                $('#availabilityMessage').show();
                                $('#time').val('');
                            } else {
                                $('#availabilityMessage').hide();
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
