<?php
$conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'if0_38046482_barangay_labogon');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $saleId = $_POST['id'];
    $stmt = $conn->prepare("UPDATE buy_and_sell SET status = 'approved' WHERE id = ?");
    $stmt->bind_param("i", $saleId);

    if ($stmt->execute()) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sale Approved',
                    text: 'The sale has been approved successfully.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '/labogon/Pages/admin_pending_sales.php';
                });
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
