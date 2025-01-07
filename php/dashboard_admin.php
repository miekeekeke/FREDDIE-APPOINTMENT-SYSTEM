<?php
require 'conn.php';
require 'auth.php';


if (session_status() == PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['user_id'])) {
    echo "Session not set! Redirecting to login.";
    header("Location: index.php");
    exit;
}


require_login('admin');

$stmtAppointments = $pdo->query("SELECT * FROM appointment");
$appointments = $stmtAppointments->fetchAll(PDO::FETCH_ASSOC);

$stmtAvailability = $pdo->query("SELECT * FROM availability");
$availability = $stmtAvailability->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome</h1>
        <h3>Appointments Overview</h3>
        <ul class="list-group">
            <?php foreach ($appointments as $appointment): ?>
                <li class="list-group-item"><?= $appointment['Date'] ?> - <?= $appointment['ServiceID'] ?> - <?= $appointment['Status'] ?></li>
            <?php endforeach; ?>
        </ul>
        <h3 class="mt-5">Manage Availability</h3>
        <form action="update_availability.php" method="POST">
            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="Available">Available</option>
                    <option value="Not Available">Not Available</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Availability</button>
        </form>
        <ul class="list-group mt-3">
            <?php foreach ($availability as $day): ?>
                <li class="list-group-item"><?= $day['Date'] ?> - <?= $day['Status'] ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
