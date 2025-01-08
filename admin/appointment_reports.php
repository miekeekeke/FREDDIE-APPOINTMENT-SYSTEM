<?php
require_once '../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$filter = $_GET['filter'] ?? 'today';

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
    SELECT a.id, a.appointment_date, a.status, s.name as service, c.first_name as customer_first_name, 
           c.last_name as customer_last_name, st.first_name as staff_first_name
    FROM appointments a
    JOIN services s ON a.service_id = s.id
    JOIN users c ON a.customer_id = c.id
    LEFT JOIN users st ON a.staff_id = st.id
    WHERE $date_condition
    ORDER BY a.appointment_date DESC
");
$stmt->execute();
$appointments = $stmt->fetchAll();
?>

<h2 class="text-center mb-4">Appointment Reports</h2>

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
            <th>Staff</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($appointments as $appointment): ?>
            <tr>
                <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                <td><?php echo htmlspecialchars($appointment['customer_first_name'] . ' ' . $appointment['customer_last_name']); ?></td>
                <td><?php echo htmlspecialchars($appointment['service']); ?></td>
                <td><?php echo htmlspecialchars($appointment['status']); ?></td>
                <td><?php echo $appointment['staff_first_name'] ? htmlspecialchars($appointment['staff_first_name']) : 'Not assigned'; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>

