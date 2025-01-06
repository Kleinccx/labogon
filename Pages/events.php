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
    <title>Waste Marketplace</title>
    <link rel="stylesheet" href="/labogon/style.css">
    <style>
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
    <?php if (!empty($_SESSION['notification'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['notification']); ?>
        </div>
        <?php unset($_SESSION['notification']); // Clear the notification ?>
    <?php endif; ?>
</div>

<main>
    <section class="card-container">
        <?php
        $result = $conn->query("SELECT * FROM events ORDER BY date DESC");
        while ($row = $result->fetch_assoc()):
            // Dynamically construct the path for the image
            $imagePath = "/labogon/" . htmlspecialchars($row['image']);
        ?>
            <div class="card">
             
                
                <!-- Display Image -->
                <img src="<?= $imagePath ?>" alt="Event Image" style="width: 100%; height: 200px; object-fit: cover;">
                <h3><?= htmlspecialchars($row['name']) ?></h3>
                <p class="date"><?= htmlspecialchars($row['date']) ?></p>
                <p><?= htmlspecialchars($row['description']) ?></p>
            </div>
        <?php endwhile; ?>
    </section>
</main>


    </section>
</main>

<!-- ICONS -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="/labogon/script.js"></script>
</body>
</html>
