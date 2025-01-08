<?php
require_once 'includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'customer') {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare("
    SELECT a.id, s.name as service, a.appointment_date, a.status 
    FROM appointments a 
    JOIN services s ON a.service_id = s.id 
    WHERE a.customer_id = ? 
    ORDER BY a.appointment_date DESC
");
$stmt->execute([$_SESSION['user_id']]);
$appointments = $stmt->fetchAll();
?>

<h2 class="text-center mb-4">Service Status</h2>

<?php if (empty($appointments)): ?>
    <p class="text-center">You have no appointments yet.</p>
<?php else: ?>
    <table class="table">
        <thead>
            <tr>
                <th>Service</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td><?php echo htmlspecialchars($appointment['service']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                    <td><?php echo htmlspecialchars($appointment['status']); ?></td>
                    <td>
                        <?php if ($appointment['status'] == 'completed'): ?>
                            <a href="rate_service.php?id=<?php echo $appointment['id']; ?>" class="btn btn-sm btn-primary">Rate Service</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>

