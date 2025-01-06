<?php
// Database connection
$conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'if0_38046482_barangay_labogon');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate the request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
    $allowedStatuses = ['done', 'in progress', 'cancelled'];

    if ($id && in_array($status, $allowedStatuses)) {
        // Update the status in the database
        $stmt = $conn->prepare("UPDATE garbage_collection SET status = ? WHERE id = ?");
        $stmt->bind_param('si', $status, $id);

        if ($stmt->execute()) {
            echo "Status updated to " . htmlspecialchars($status) . ".";
        } else {
            http_response_code(500);
            echo "Failed to update the status. Please try again.";
        }

        $stmt->close();
    } else {
        http_response_code(400);
        echo "Invalid input.";
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}

$conn->close();
?>
