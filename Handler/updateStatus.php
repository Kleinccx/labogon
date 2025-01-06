<?php
session_start();
$conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'if0_38046482_barangay_labogon');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized action.']);
        exit;
    }

    $productId = $_POST['product_id'];
    $newStatus = $_POST['status'];

    $userId = $_SESSION['user_id'];

    // Verify that the product belongs to the logged-in user
    $stmt = $conn->prepare("SELECT id, product_category FROM buy_and_sell WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $productId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'You can only update your own products.']);
        exit;
    }

    // Update the product status
    $stmt = $conn->prepare("UPDATE buy_and_sell SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $productId);

    if ($stmt->execute()) {
        // Fetch updated sold counts
        $soldCountQuery = $conn->prepare("SELECT product_category, COUNT(*) as sold_count FROM buy_and_sell WHERE status = 'Sold' GROUP BY product_category");
        $soldCountQuery->execute();
        $soldCountsResult = $soldCountQuery->get_result();

        $soldCounts = [];
        while ($row = $soldCountsResult->fetch_assoc()) {
            $soldCounts[$row['product_category']] = $row['sold_count'];
        }

        echo json_encode(['success' => true, 'message' => "Product status updated to $newStatus.", 'soldCounts' => $soldCounts]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update product status.']);
    }

    $stmt->close();
}

$conn->close();
?>
