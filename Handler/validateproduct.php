<?php
$conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'if0_38046482_barangay_labogon');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the necessary data is sent
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'] ?? null;
    $action = $_POST['action'] ?? null;

    if ($productId && $action) {
        // Validate action
        if ($action === 'approved' || $action === 'rejected') {
            $stmt = $conn->prepare("UPDATE buy_and_sell SET status = ? WHERE id = ?");  
            $stmt->bind_param("si", $action, $productId);

            if ($stmt->execute()) {
                echo "Product successfully " . ($action === 'approved' ? "approved!" : "rejected.");
            } else {
                echo "Failed to update product status: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Invalid action.";
        }
    } else {
        echo "Missing product ID or action.";
    }
} else { 
    echo "Invalid request method.";
}

$conn->close();
?>
