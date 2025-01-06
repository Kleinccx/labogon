<?php
session_start();
ob_start(); // Start output buffering

$conn = new mysqli('sql108.infinityfree.com', 'if0_38046482', 'kmMN1faknH', 'if0_38046482_barangay_labogon');

// Redirect if the user is not logged in or not an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: /labogon/login.php"); // Redirect to the login page
    exit; // Stop further execution
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all garbage collection schedules
$sql = "SELECT * FROM garbage_collection ORDER BY schedule_date, schedule_time";
$result = $conn->query($sql);

// Initialize SweetAlert response
$sweetalert_message = "";

if (isset($_POST['mark_done'])) {
    $id = $_POST['id'];
    $update_sql = "UPDATE garbage_collection SET status = 'done' WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        // Get user_id from garbage collection record to insert notification
        $get_user_sql = "SELECT user_id FROM garbage_collection WHERE id = ?";
        $get_user_stmt = $conn->prepare($get_user_sql);
        $get_user_stmt->bind_param('i', $id);
        $get_user_stmt->execute();
        $get_user_result = $get_user_stmt->get_result();
        $user = $get_user_result->fetch_assoc();

        if ($user) {
            // Insert notification into the notifications table
            $message = "Your garbage collection schedule has been marked as 'done'.";
            $insert_notif_sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
            $insert_notif_stmt = $conn->prepare($insert_notif_sql);
            $insert_notif_stmt->bind_param('is', $user['user_id'], $message);
            
            if ($insert_notif_stmt->execute()) {
                $_SESSION['notification'] = "The garbage collection schedule has been marked as 'done'.";
                $sweetalert_message = "Swal.fire('Success', 'Garbage collection marked as done!', 'success')";
            } else {
                $sweetalert_message = "Swal.fire('Error', 'Failed to insert the notification.', 'error')";
            }
        } else {
            $sweetalert_message = "Swal.fire('Error', 'User not found for the given garbage collection.', 'error')";
        }
    } else {
        $sweetalert_message = "Swal.fire('Error', 'Failed to update the garbage collection status.', 'error')";
    }
    $stmt->close();

    // Redirect to prevent resubmission
    header("Location: garbagecollection.php");
    exit;
}

if (isset($_POST['decline'])) {
    $id = $_POST['id'];
    $update_sql = "UPDATE garbage_collection SET status = 'declined' WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        // Get user_id from garbage collection record to insert notification
        $get_user_sql = "SELECT user_id FROM garbage_collection WHERE id = ?";
        $get_user_stmt = $conn->prepare($get_user_sql);
        $get_user_stmt->bind_param('i', $id);
        $get_user_stmt->execute();
        $get_user_result = $get_user_stmt->get_result();
        $user = $get_user_result->fetch_assoc();

        if ($user) {
            // Insert notification into the notifications table
            $message = "Your garbage collection schedule has been declined.";
            $insert_notif_sql = "INSERT INTO notifications (user_id, message) VALUES (?, ?)";
            $insert_notif_stmt = $conn->prepare($insert_notif_sql);
            $insert_notif_stmt->bind_param('is', $user['user_id'], $message);
            
            if ($insert_notif_stmt->execute()) {
                $_SESSION['notification'] = "The garbage collection schedule has been declined.";
                $sweetalert_message = "Swal.fire('Declined', 'The garbage collection schedule has been declined.', 'info')";
            } else {
                $sweetalert_message = "Swal.fire('Error', 'Failed to insert the notification.', 'error')";
            }
        } else {
            $sweetalert_message = "Swal.fire('Error', 'User not found for the given garbage collection.', 'error')";
        }
    } else {
        $sweetalert_message = "Swal.fire('Error', 'Failed to decline the garbage collection.', 'error')";
    }
    $stmt->close();

    // Redirect to prevent resubmission
    header("Location: garbagecollection.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Garbage Collection Schedules</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-200">
<div class="container mt-5">
  <h1 class="mb-4">Garbage Collection Schedules</h1>
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>User ID</th>
        <th>Schedule Date</th>
        <th>Schedule Time</th>
        <th>Location</th>
        <th>Waste Category</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['user_id']) ?></td>
            <td><?= htmlspecialchars($row['schedule_date']) ?></td>
            <td><?= htmlspecialchars($row['schedule_time']) ?></td>
            <td><?= htmlspecialchars($row['location']) ?></td>
            <td><?= htmlspecialchars($row['waste_category']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td>
              <?php if ($row['status'] == 'pending'): ?>
                <form method="POST" class="d-inline">
                  <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                  <button type="submit" name="mark_done" class="btn btn-success btn-sm">Mark as Done</button>
                </form>
                <form method="POST" class="d-inline">
                  <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                  <button type="submit" name="decline" class="btn btn-danger btn-sm">Decline</button>
                </form>
              <?php else: ?>
                <span class="<?= $row['status'] == 'done' ? 'text-success' : 'text-danger' ?>">
                  <?= htmlspecialchars($row['status']) ?>
                </span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="8" class="text-center">No garbage collection schedules found</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php if (!empty($sweetalert_message)): ?>
<script>
    <?= $sweetalert_message ?>;
</script>
<?php endif; ?>

</body>
</html>
