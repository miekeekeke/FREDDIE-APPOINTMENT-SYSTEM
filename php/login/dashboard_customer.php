<?php
require '../conn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Debug session
error_log("User ID from session: " . $_SESSION['user_id']);

// Get username with case-sensitive table name
try {
    $stmt = $pdo->prepare("SELECT username FROM `users` WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Debug query result
    error_log("User data: " . print_r($user, true));
    
    $username = $user ? htmlspecialchars($user['username']) : 'Guest';
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $username = 'Guest';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h1 class="mb-4">Welcome, <?= $username ?></h1>
                
                <div class="d-grid gap-3">
                    <a href="make_appointment.php" class="btn btn-primary btn-lg">
                        Make an Appointment
                    </a>
                    <a href="service_status.php" class="btn btn-secondary btn-lg">
                        See Service Status
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
