<?php
require_once '../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$stmt = $pdo->query("
    SELECT f.id, f.rating, f.comment, f.created_at, s.name as service, u.first_name, u.last_name
    FROM feedback f
    JOIN appointments a ON f.appointment_id = a.id
    JOIN services s ON a.service_id = s.id
    JOIN users u ON a.customer_id = u.id
    ORDER BY f.created_at DESC
");
$feedbacks = $stmt->fetchAll();
?>

<h2 class="text-center mb-4">Customer Feedback</h2>

<table class="table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Customer</th>
            <th>Service</th>
            <th>Rating</th>
            <th>Comment</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($feedbacks as $feedback): ?>
            <tr>
                <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($feedback['created_at']))); ?></td>
                <td><?php echo htmlspecialchars($feedback['first_name'] . ' ' . $feedback['last_name']); ?></td>
                <td><?php echo htmlspecialchars($feedback['service']); ?></td>
                <td><?php echo htmlspecialchars($feedback['rating']); ?> / 5</td>
                <td><?php echo htmlspecialchars($feedback['comment']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>

