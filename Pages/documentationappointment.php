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
    $query = "INSERT INTO documentation_appointments (user_id, name, address, contact_number, email, birthday, age, gender, years_of_residency)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($query)) {
        // Bind parameters and execute statement
        $stmt->bind_param("issssssii", $userId, $name, $address, $contactNum, $email, $birthday, $age, $gender, $yearsOfResidency);

        if ($stmt->execute()) {
            // On successful insertion, set session status and redirect
            $_SESSION['status'] = 'success';
            header("Location: appointments.php");
            exit;
        } else {
            // On failed insertion, set session status and redirect
            $_SESSION['status'] = 'error';
            header("Location: appointments.php");
            exit;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Database query failed, set session status and redirect
        $_SESSION['status'] = 'error';
        header("Location: appointments.php");
        exit;
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Appointment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/labogon/style.css">
    <style>
        /* Adjust input fields size */
.form-control {
    height: 45px; /* Increase height */
    width: 100%; /* Ensure full width */
    max-width: 400px; /* Set max width for smaller input size */
    margin: 10px auto; /* Center input fields */
    font-size: 1.25rem; /* Make text bigger */
}

/* Adjust Submit button size and appearance */
.btn-primary {
    width: 50%; /* Make button narrower */
    padding: 15px; /* Increase padding */
    font-size: 18px; /* Increase font size */
    margin: 20px auto; /* Center the button */
}

/* Style the form container */
.form-container {
    max-width: 600px; /* Set max width for the form */
    margin: 0 auto;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Adjust header and labels */
.form-label {
    font-size: 1.1rem; /* Increase label text size */
}

/* For placeholder text */
input::placeholder {
    font-size: 1.25rem; /* Increase placeholder text size */
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

    <div class="container mt-5">
        <div class="form-container">
            <h1 class="text-center mb-4">Appointment</h1>
            <form action="documentationappointment.php" method="POST" class="needs-validation" novalidate>
                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                    <div class="invalid-feedback">Please enter your name.</div>
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" id="address" name="address" class="form-control" required>
                    <div class="invalid-feedback">Please enter your address.</div>
                </div>

                <!-- Contact Number -->
                <div class="mb-4">
                    <label for="contactNum" class="form-label">Contact Number</label>
                    <input type="tel" id="contactNum" name="contactNum" class="form-control" pattern="[0-9]{10}" required>
                    <div class="invalid-feedback">Please enter a valid 10-digit contact number.</div>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>

                <!-- Birthday -->
                <div class="mb-4">
                    <label for="birthday" class="form-label">Birthday</label>
                    <input type="date" id="birthday" name="birthday" class="form-control" required>
                    <div class="invalid-feedback">Please select your birthday.</div>
                </div>

                <!-- Age -->
                <div class="mb-4">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" id="age" name="age" class="form-control" min="1" required>
                    <div class="invalid-feedback">Please enter your age.</div>
                </div>

                <!-- Gender -->
                <div class="mb-4">
                    <label for="gender" class="form-label">Gender</label>
                    <input type="text" id="gender" name="gender" class="form-control" required>
                    <div class="invalid-feedback">Please enter your gender.</div>
                </div>

                <!-- Years of Residency -->
                <div class="mb-4">
                    <label for="yearsOfResidency" class="form-label">Years of Residency</label>
                    <input type="number" id="yearsOfResidency" name="yearsOfResidency" class="form-control" min="0" required>
                    <div class="invalid-feedback">Please enter years of residency.</div>
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit Appointment</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Bootstrap form validation
        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();

        // SweetAlert for success and error notifications
        <?php if (isset($_SESSION['status'])): ?>
            let status = "<?php echo $_SESSION['status']; ?>";
            if (status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Appointment Created!',
                    text: 'Your appointment was successfully created.',
                    confirmButtonText: 'Ok'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'There was an error creating your appointment. Please try again.',
                    confirmButtonText: 'Ok'
                });
            }
            <?php unset($_SESSION['status']); ?>
        <?php endif; ?>
    </script>
</body>
</html>
