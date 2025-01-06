<?php
session_start();

// Connect to the database
$conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'if0_38046482_barangay_labogon');

// Check the connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Redirect if the user is not logged in or not an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: /labogon/login.php"); // Redirect to the login page
    exit;
}

// Handle appointment confirmation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_appointment'])) {
    $appointment_id = filter_input(INPUT_POST, 'appointment_id', FILTER_VALIDATE_INT);
    $admin_name = filter_input(INPUT_POST, 'admin_name', FILTER_SANITIZE_STRING);

    if (!$appointment_id || !$admin_name) {
        die("Invalid data. Please check your input.");
    }

    // Update the appointment status to "Confirmed"
    $stmt = $conn->prepare("UPDATE appointments SET status = 'Confirmed', confirmed_by = ? WHERE id = ?");
    $stmt->bind_param('si', $admin_name, $appointment_id);

    if ($stmt->execute()) {
        // Get the user ID from the appointment to send the notification
        $get_user_sql = "SELECT user_id FROM appointments WHERE id = ?";
        $get_user_stmt = $conn->prepare($get_user_sql);
        $get_user_stmt->bind_param('i', $appointment_id);
        $get_user_stmt->execute();
        $get_user_result = $get_user_stmt->get_result();
        $user = $get_user_result->fetch_assoc();

        if ($user && isset($user['user_id'])) {
            // Insert the notification into the database
            $message = "Your Barangay appointment has been confirmed by " . htmlspecialchars($admin_name) . ".";
            $insert_notif_sql = "INSERT INTO notifications (user_id, message, status, created_at) VALUES (?, ?, 'unread', NOW())";
            $insert_notif_stmt = $conn->prepare($insert_notif_sql);
            $insert_notif_stmt->bind_param('is', $user['user_id'], $message);

            if ($insert_notif_stmt->execute()) {
                // Set a session message after confirmation
                $_SESSION['message'] = 'Appointment confirmed successfully!';
            } else {
                echo "Error inserting notification: " . $insert_notif_stmt->error;
            }
        } else {
            echo "Error: User not found for the appointment.";
        }

        // Redirect to prevent resubmission and display the message
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Handle delete/cancel appointment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_appointment'])) {
    $appointment_id = filter_input(INPUT_POST, 'appointment_id', FILTER_VALIDATE_INT);

    if (!$appointment_id) {
        die("Invalid appointment ID.");
    }

    $stmt = $conn->prepare("DELETE FROM appointments WHERE id = ?");
    $stmt->bind_param('i', $appointment_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Appointment canceled successfully!';
        header('Location: ' . $_SERVER['PHP_SELF']); // Redirect to prevent resubmission
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}


// Handle delete/cancel appointment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_appointment'])) {
    $appointment_id = filter_input(INPUT_POST, 'appointment_id', FILTER_VALIDATE_INT);

    if (!$appointment_id) {
        die("Invalid appointment ID.");
    }

    $stmt = $conn->prepare("DELETE FROM appointments WHERE id = ?");
    $stmt->bind_param('i', $appointment_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Appointment canceled successfully!';
        header('Location: ' . $_SERVER['PHP_SELF']); // Redirect to prevent resubmission
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch appointments based on filter
$filter_status = isset($_GET['filter_status']) ? $_GET['filter_status'] : '';
$filter_query = "SELECT * FROM appointments";
if ($filter_status) {
    $filter_query .= " WHERE status = '" . $conn->real_escape_string($filter_status) . "'";
}

$result = $conn->query($filter_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Manage Appointments</title>
    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f4f4f4;
        }
        .form-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Admin Panel: Manage Appointments</h1>

    <!-- Filter Section -->
    <form method="GET" action="">
        <label for="filter_status">Filter by Status:</label>
        <select id="filter_status" name="filter_status" onchange="this.form.submit()">
            <option value="">All</option>
            <option value="Pending" <?php echo $filter_status == 'Pending' ? 'selected' : ''; ?>>Pending</option>
            <option value="Confirmed" <?php echo $filter_status == 'Confirmed' ? 'selected' : ''; ?>>Confirmed</option>
        </select>
    </form>

    <!-- Confirmation Message -->
    <?php if (isset($_SESSION['message'])): ?>
        <div style="color: green; margin: 20px 0;">
            <?php echo $_SESSION['message']; ?>
        </div>
        <?php unset($_SESSION['message']); // Clear the message after displaying ?>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Address</th>
                <th>Contact Number</th>
                <th>Appointment With</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($appointment = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($appointment['id']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['address']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['contact_number']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['appointment_with']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['date']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['time']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['status']); ?></td>
                    <td>
                        <!-- Confirm Button -->
                        <form method="POST" action="">
                            <input type="hidden" name="appointment_id" value="<?php echo $appointment['id']; ?>">
                            <label for="admin_name">Admin Name:</label>
                            <input type="text" id="admin_name" name="admin_name" required>
                            <button type="submit" name="confirm_appointment">Confirm</button>
                        </form>

                         <!-- Delete Button -->
                         <form method="POST" action="" style="display: inline;">
                            <input type="hidden" name="appointment_id" value="<?php echo $appointment['id']; ?>">
                            <button type="submit" name="delete_appointment" onclick="return confirm('Are you sure you want to cancel this appointment?');">Cancel</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
