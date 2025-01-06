<?php 

$conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'if0_38046482_barangay_labogon');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT product_name, product_category, description, seller_name, contact_name, email, address, image_path, image_name, created_at FROM buy_and_sell WHERE status='Pending'");

$sales = [];

while ($row = $result->fetch_assoc()) {
    $sale = $row;

    // Ensure the image path is correct, assuming 'uploads' directory exists and contains images
    if (!empty($incident['image_name'])) {
        $sale['image_path'] = '/Pages/ProductImage' . $sale['image_name']; // Adjust path as needed
    } else {
        $sale['image_path'] = ''; // If there's no image, leave this empty
    }

    $sales[] = $sale;
}

echo json_encode($sales);

$conn->close();

?>
