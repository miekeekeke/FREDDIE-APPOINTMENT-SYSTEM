<?php

require '../conn.php';
require '../login/auth.php';

if (session_status() == PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['user_id'])) {
    echo "Session not set! Redirecting to login.";
    header("Location: index.php");
    exit;
}

require_login('customer');

try {
    $stmt = $pdo->query("SELECT Date FROM availability WHERE status = 'Available'");
    $availableDates = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->query("SELECT LeatherConditioningID AS ServiceID, ServiceName FROM leather_conditioning");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $customerId = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT a.Date, lc.ServiceName, a.Status FROM appointment a JOIN leather_conditioning lc ON a.ServiceID = lc.LeatherConditioningID WHERE a.CustomerID = ?");
    $stmt->execute([$customerId]);
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    if ($e->getCode() == 2006) {
        // Reconnect and retry the query
        $pdo = new PDO($dsn, $username, $password, $options);
        $stmt = $pdo->query("SELECT Date FROM availability WHERE status = 'Available'");
        $availableDates = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $pdo->query("SELECT LeatherConditioningID AS ServiceID, ServiceName FROM leather_conditioning");
        $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $customerId = $_SESSION['user_id'];
        $stmt = $pdo->prepare("SELECT a.Date, lc.ServiceName, a.Status FROM appointment a JOIN leather_conditioning lc ON a.ServiceID = lc.LeatherConditioningID WHERE a.CustomerID = ?");
        $stmt->execute([$customerId]);
        $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        throw $e;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="css/customer.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome</h1>
        <h3>Book an Appointment</h3>
        <form action="book_appointment.php" method="POST">
            <div class="mb-3">
                <label for="date" class="form-label">Select a Date</label>
                <input type="text" class="form-control" id="date" name="date" required>
            </div>
            <div class="mb-3">
                <label for="service" class="form-label">Select a Service</label>
                <select class="form-select" id="service" name="service" required>
                    <?php foreach ($services as $service): ?>
                        <option value="<?= $service['ServiceID'] ?>"><?= $service['ServiceName'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Book Appointment</button>
        </form>
        <h3 class="mt-5">Your Appointments</h3>
        <ul class="list-group">
            <?php foreach ($appointments as $appointment): ?>
                <li class="list-group-item">
                    <?= $appointment['Date'] ?> - <?= $appointment['ServiceName'] ?> (<?= $appointment['Status'] ?>)
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#date').datepicker({
                format: 'yyyy-mm-dd',
                startDate: '0d',
                autoclose: true
            });
        });
    </script>
</body>
</html>
