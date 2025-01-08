<?php
require_once '../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'staff') {
    header('Location: ../login.php');
    exit;
}

$staff_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
$stmt->execute([$staff_id]);
$staff = $stmt->fetch();
?>

<h2 class="text-center mb-4">Welcome, <?php echo htmlspecialchars($staff['first_name'] . ' ' . $staff['last_name']); ?></h2>

<div class="row justify-content-center">
    <div class="col-md-4 mb-3">
        <a href="manage_appointments.php" class="btn btn-primary btn-lg btn-block">Manage Appointments</a>
    </div>
    <div class="col-md-4 mb-3">
        <a href="booking_summary.php" class="btn btn-secondary btn-lg btn-block">Booking Summary</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

