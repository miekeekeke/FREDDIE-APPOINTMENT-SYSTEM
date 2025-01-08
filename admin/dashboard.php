<?php
require_once '../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$admin_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch();
?>

<h2 class="text-center mb-4">Welcome, <?php echo htmlspecialchars($admin['first_name'] . ' ' . $admin['last_name']); ?></h2>

<div class="row justify-content-center">
    <div class="col-md-3 mb-3">
        <a href="appointment_reports.php" class="btn btn-primary btn-lg btn-block">Appointment Reports</a>
    </div>
    <div class="col-md-3 mb-3">
        <a href="edit_calendar.php" class="btn btn-secondary btn-lg btn-block">Edit Calendar</a>
    </div>
    <div class="col-md-3 mb-3">
        <a href="customer_feedback.php" class="btn btn-info btn-lg btn-block">Customer Feedback</a>
    </div>
    <div class="col-md-3 mb-3">
        <a href="manage_staff.php" class="btn btn-warning btn-lg btn-block">Manage Staff</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

