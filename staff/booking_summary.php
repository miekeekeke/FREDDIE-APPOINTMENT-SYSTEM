<?php
require_once '../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'staff') {
    header('Location: ../login.php');
    exit;
}

$filter = $_GET['filter'] ?? 'today';
$staff_id = $_SESSION['user_id'];

switch ($filter) {
    case 'today':
        $date_condition = "DATE(a.appointment_date) = CURDATE()";
        break;
    case 'this_week':
        $date_condition = "YEARWEEK(a.appointment_date, 1) = YEARWEEK(CURDATE(), 1)";
        break;
    case 'this_month':
        $date_condition = "YEAR(a.appointment_date) = YEAR(CURDATE()) AND MONTH(a.appointment_date) = MONTH(CURDATE())";
        break;
    case 'this_year':
        $date_condition = "YEAR(a.appointment_date) = YEAR(CURDATE())";
        break;
    default:
        $date_condition = "DATE(a.appointment_date) = CURDATE()";
}

$stmt = $pdo->prepare("
    SELECT a.id, a.appointment_date, a.status, s.name as service, u.first_name, u.last_name
    FROM appointments a
    JOIN services s ON a.service_id = s.id
    JOIN users u ON a.customer_id = u.id
    WHERE $date_condition AND a.staff_id = ?
    ORDER BY a.appointment_date DESC
");
$stmt->execute([$staff_id]);
$bookings = $stmt->fetchAll();
?>

<h2 class="text-center mb-4">Booking Summary</h2>

<div class="mb-3">
    <form method="get" action="" class="d-inline">
        <select name="filter" onchange="this.form.submit()" class="form-select">
            <option value="today" <?php echo $filter == 'today' ? 'selected' : ''; ?>>Today</option>
            <option value="this_week" <?php echo $filter == 'this_week' ? 'selected' : ''; ?>>This Week</option>
            <option value="this_month" <?php echo $filter == 'this_month' ? 'selected' : ''; ?>>This Month</option>
            <option value="this_year" <?php echo $filter == 'this_year' ? 'selected' : ''; ?>>This Year</option>
        </select>
    </form>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Customer</th>
            <th>Service</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($bookings as $booking): ?>
            <tr>
                <td><?php echo htmlspecialchars($booking['appointment_date']); ?></td>
                <td><?php echo htmlspecialchars($booking['first_name'] . ' ' . $booking['last_name']); ?></td>
                <td><?php echo htmlspecialchars($booking['service']); ?></td>
                <td><?php echo htmlspecialchars($booking['status']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>

