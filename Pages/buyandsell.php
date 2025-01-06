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

        form {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        form input, form select, form textarea, form button {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        form button {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #45a049;
        }

        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .product {
            background-color: #f2e8cf;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 16px;
            width: 300px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .product:hover {
            transform: translateY(-5px);
        }

        .product img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .product h3 {
            margin: 0 0 10px;
            font-size: 20px;
            color: #4CAF50;
        }

        .product p {
            margin: 5px 0;
            font-size: 14px;
        }

        .product button {
            background-color: #4CAF50;
            color: white;
            padding: 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }

        .product button:hover {
            background-color: #45a049;
        }

        @media (max-width: 768px) {
            .product {
                width: 90%;
            }
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

         <button class="btn-mobile-nav">
            <ion-icon class="icon-mobile-nav" name="menu-outline"></ion-icon>
            <ion-icon class="icon-mobile-nav" name="close-outline"></ion-icon>
         </button>
     </header>

     <main>
    <!-- Show form and user products if logged in -->
    <?php if ($isLoggedIn): ?>
        <section id="submitform">
            <h2>Post Your Product</h2>
            <form id="buyAndSellForm" action="/labogon/Handler/buyandsellsubmit.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                <label for="product_name">Product Name:</label>
                <input type="text" id="product_name" name="product_name" required>

                <label for="product_category">Category:</label>
                <select id="product_category" name="product_category" required>
                    <option value="Appliances">Appliances</option>
                    <option value="Bottles">Bottles</option>
                    <option value="Scrap Metals">Scrap Metals</option>
                    <option value="Others">Others</option>
                </select>

                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>

                <label for="seller_name">Seller Name:</label>
                <input type="text" id="seller_name" name="seller_name" required>

                <label for="contact_number">Contact Number:</label>
                <input type="text" id="contact_number" name="contact_number" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>

                <label for="image">Upload Image:</label>
                <input type="file" id="image" name="image">

                <button type="submit">Submit</button>
            </form>
        </section>

        <section id="userProducts">
            <h2>Your Products</h2>
            <div class="product-list">
                <?php
                $stmt = $conn->prepare("SELECT * FROM buy_and_sell WHERE user_id = ?");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    $imagePath = !empty($row['image_name']) ? '/labogon/Pages/ProductImage/' . htmlspecialchars($row['image_name']) : '/labogon/Pages/ProductImage/placeholder.png';
                    $fullPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;

                    echo "<div class='product'>";
                    if (file_exists($fullPath)) {
                        echo "<img src='$imagePath' alt='Product Image'>";
                    } else {
                        echo "<img src='/labogon/Pages/ProductImage/placeholder.png' alt='Placeholder Image'>";
                    }
                    echo "<h3>" . htmlspecialchars($row['product_name']) . "</h3>";
                    echo "<p>Status: " . htmlspecialchars($row['status']) . "</p>";
                    if ($row['status'] !== 'Sold') {
                        echo "<button onclick='changeStatus(" . $row['id'] . ", \"Sold\")'>Mark as Sold</button>";
                    }
                    echo "<button onclick='deleteProduct(" . $row['id'] . ")'>Delete</button>";
                    echo "</div>";
                }
                ?>
            </div>
        </section>
    <?php endif; ?>

     <!-- Public view of approved products -->
     <section id="products">
        <h2>Available Products</h2>
        <div class="product-list">
            <?php
            $sql = "SELECT * FROM buy_and_sell WHERE status = 'approved'";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                $imagePath = !empty($row['image_name']) ? '/labogon/Pages/ProductImage/' . htmlspecialchars($row['image_name']) : '/labogon/Pages/ProductImage/placeholder.png';
                $fullPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;

                echo "<div class='product'>";
                if (file_exists($fullPath)) {
                    echo "<img src='$imagePath' alt='Product Image'>";
                } else {
                    echo "<img src='/labogon/Pages/ProductImage/placeholder.png' alt='Placeholder Image'>";
                }
                echo "<h3>" . htmlspecialchars($row['product_name']) . "</h3>";
                echo "<p>Category: " . htmlspecialchars($row['product_category']) . "</p>";
                echo "<p>Description: " . htmlspecialchars($row['description']) . "</p>";
                echo "<p>Seller: " . htmlspecialchars($row['seller_name']) . "</p>";
                echo "<p>Contact: " . htmlspecialchars($row['contact_number']) . "</p>";
                echo "<p>Email: " . htmlspecialchars($row['email']) . "</p>";
                echo "</div>";
            }
            ?>
        </div>
    </section>
</main>

<script>
  function changeStatus(productId, status) {
    fetch('/labogon/Handler/updateStatus.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `product_id=${productId}&status=${status}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);

            // If sold, update the graph
            if (status === 'sold' && data.soldCounts) {
                updateGraph(data.soldCounts);
            }
        } else {
            alert(data.message);
        }
    })
    .catch(() => alert('Failed to update product status.'));
}

function updateGraph(soldCounts) {
    const categories = Object.keys(soldCounts);
    const counts = Object.values(soldCounts);

    // Update Chart.js graph
    chart.data.labels = categories;
    chart.data.datasets[0].data = counts;
    chart.update();
}



    function deleteProduct(productId) {
        if (!confirm("Are you sure you want to delete this product?")) return;

        fetch('/labogon/Handler/deleteProduct.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `product_id=${productId}`
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        })
        .catch(() => alert('Failed to delete product.'));
    }

    function editProduct(productId) {
        const productDetails = prompt("Enter updated details as: Name,Category,Description,Contact,Email,Address");
        if (!productDetails) return;

        const [name, category, description, contact, email, address] = productDetails.split(',');

        fetch('/labogon/Handler/editProduct.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `product_id=${productId}&name=${name}&category=${category}&description=${description}&contact=${contact}&email=${email}&address=${address}`
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        })
        .catch(() => alert('Failed to edit product.'));
    }
</script>


    <!--ICONS-->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script src="/labogon/script.js"></script>
</body>
</html>

<?php $conn->close(); ?>
