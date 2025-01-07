<?php
require 'conn.php';
require 'auth.php';

if (session_status() == PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['user_id'])) {
    echo "Session not set! Redirecting to login.";
    header("Location: index.php");
    exit;
}

require_login('staff');

$stmt = $pdo->query("SELECT appointment.*, customer.FirstName AS customer_name FROM appointment JOIN customer ON appointment.CustomerID = customer.CustomerID WHERE Status = 'Pending'");
$pendingAppointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/staff.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome</h1>
        <h3>Pending Appointments</h3>
        <ul class="list-group">
            <?php foreach ($pendingAppointments as $appointment): ?>
                <li class="list-group-item">
                    <?= $appointment['customer_name'] ?> - <?= $appointment['Date'] ?> - <?= $appointment['ServiceID'] ?>
                    <form action="update_appointment.php" method="POST" class="d-inline">
                        <input type="hidden" name="appointment_id" value="<?= $appointment['AppointmentID'] ?>">
                        <button type="submit" name="action" value="accept" class="btn btn-success btn-sm">Accept</button>
                        <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Reject</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
