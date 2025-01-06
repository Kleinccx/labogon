<?php
session_start();
$conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'if0_38046482_barangay_labogon');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $productName = $_POST['product_name'];
    $productCategory = $_POST['product_category'];
    $description = $_POST['description'];
    $sellerName = $_POST['seller_name'];
    $contactNumber = $_POST['contact_number'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../Pages/ProductImage/";
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $originalFileName = basename($_FILES['image']['name']);
        $fileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        // Validate file type
        if (in_array($fileType, $allowedTypes)) {
            $uniqueFileName = uniqid('product_', true) . '.' . $fileType;
            $targetFile = $targetDir . $uniqueFileName;

            // Ensure directory exists
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Move file to target directory
            if (move_uploaded_file($fileTmpPath, $targetFile)) {
                // Insert product into the database
                $stmt = $conn->prepare("INSERT INTO buy_and_sell (user_id, product_name, product_category, description, seller_name, contact_number, email, address, image_name, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
                if ($stmt) {
                    $stmt->bind_param("issssssss", $userId, $productName, $productCategory, $description, $sellerName, $contactNumber, $email, $address, $uniqueFileName);

                    if ($stmt->execute()) {
                        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                        echo "<script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Product Submitted!',
                                    text: 'Your product has been successfully submitted and is pending approval.',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '../Pages/buyandsell.php';
                                    }
                                });
                              </script>";
                        exit();
                    } else {
                        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                        echo "<script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Submission Failed',
                                    text: 'An error occurred: " . $stmt->error . "',
                                    confirmButtonText: 'Try Again'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = '../Pages/buyandsell.php';
                                    }
                                });
                              </script>";
                    }
                } else {
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                    echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'SQL Error',
                                text: 'Error preparing SQL: " . $conn->error . "',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '../Pages/buyandsell.php';
                                }
                            });
                          </script>";
                }
            } else {
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Image Upload Failed',
                            text: 'Unable to upload the image. Please try again.',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '../Pages/buyandsell.php';
                            }
                        });
                      </script>";
            }
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid File Type',
                        text: 'Only JPG, JPEG, PNG, and GIF files are allowed.',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '../Pages/buyandsell.php';
                        }
                    });
                  </script>";
        }
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Image Upload Error',
                    text: 'Please upload a valid image.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '../Pages/buyandsell.php';
                    }
                });
              </script>";
    }
}
$conn->close();
?>
