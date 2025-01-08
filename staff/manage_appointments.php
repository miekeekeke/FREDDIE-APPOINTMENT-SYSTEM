<?php
require_once '../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'staff') {
    header('Location: ../login.php');
    exit;
}

$staff_id = $_SESSION['user_id'];

// Handle appointment status updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['appointment_id']) && isset($_POST['new_status'])) {
    $appointment_id = $_POST['appointment_id'];
    $new_status = $_POST['new_status'];
    $stmt = $pdo->prepare("UPDATE appointments SET status = ?, staff_id = ? WHERE id = ?");
    $stmt->execute([$new_status, $staff_id, $appointment_id]);
}

// Fetch appointments
$stmt = $pdo->prepare("
    SELECT a.id, a.appointment_date, a.status, s.name as service, u.first_name, u.last_name
    FROM appointments a
    JOIN services s ON a.service_id = s.id
    JOIN users u ON a.customer_id = u.id
    WHERE a.status IN ('scheduled', 'on-going')
    ORDER BY a.appointment_date ASC
");
$stmt->execute();
$appointments = $stmt->fetchAll();
?>

<h2 class="text-center mb-4">Manage Appointments</h2>

<table class="table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Customer</th>
            <th>Service</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($appointments as $appointment): ?>
            <tr>
                <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                <td><?php echo htmlspecialchars($appointment['first_name'] . ' ' . $appointment['last_name']); ?></td>
                <td><?php echo htmlspecialchars($appointment['service']); ?></td>
                <td><?php echo htmlspecialchars($appointment['status']); ?></td>
                <td>
                    <form method="post" action="" class="d-inline">
                        <input type="hidden" name="appointment_id" value="<?php echo $appointment['id']; ?>">
                        <select name="new_status" onchange="this.form.submit()">
                            <option value="">Update Status</option>
                            <option value="on-going">On-going</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>

