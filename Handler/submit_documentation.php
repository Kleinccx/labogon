<?php
session_start();

// Database connection
$conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'if0_38046482_barangay_labogon');

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$userId = $isLoggedIn ? $_SESSION['user_id'] : null;

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $address = $_POST['address'];
    $contactNum = $_POST['contactNum'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $yearsOfResidency = $_POST['yearsOfResidency'];

    // Prepare SQL query to insert the data into the documentation_appointments table
    $query = "INSERT INTO documentation_appointments (user_id, name, address, contact_num, email, birthday, age, gender, years_of_residency)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($query)) {
        // Bind parameters and execute statement
        $stmt->bind_param("issssssii", $userId, $name, $address, $contactNum, $email, $birthday, $age, $gender, $yearsOfResidency);

        if ($stmt->execute()) {
            echo "<script>alert('Appointment successfully submitted!'); window.location.href='appointments.php';</script>";
        } else {
            echo "<script>alert('Error submitting appointment. Please try again.');</script>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<script>alert('Database query failed. Please try again.');</script>";
    }
}

// Close the database connection
$conn->close();
?>
