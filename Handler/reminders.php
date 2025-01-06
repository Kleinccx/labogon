<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to set an appointment.");
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Database connection
$conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'if0_38046482_barangay_labogon');

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Get the form data
$full_name = filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_STRING);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
$contact_number = filter_input(INPUT_POST, 'contact_number', FILTER_SANITIZE_STRING);
$appointment_with = filter_input(INPUT_POST, 'appointment_with', FILTER_SANITIZE_STRING);
$date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
$time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_STRING);

// Validate the input
if (empty($full_name) || empty($address) || empty($contact_number) || empty($appointment_with) || empty($date) || empty($time)) {
    echo "<script>
            Swal.fire('Error', 'All fields are required.', 'error');
          </script>";
    exit;
}

// Insert the appointment into the database
$stmt = $conn->prepare("INSERT INTO appointments (user_id, full_name, address, contact_number, appointment_with, date, time, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending', NOW())");
$stmt->bind_param('issssss', $user_id, $full_name, $address, $contact_number, $appointment_with, $date, $time);

if ($stmt->execute()) {
    echo "<script>
            Swal.fire('Success', 'Appointment created successfully.', 'success');
          </script>";
} else {
    echo "<script>
            Swal.fire('Error', 'Error: " . $stmt->error . "', 'error');
          </script>";
}

$stmt->close();
$conn->close();
?>
