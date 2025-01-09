<?php
require_once '../includes/dashboard_header.php';

// Ensure the user is a customer
if ($_SESSION['user_role'] !== 'customer') {
    header('Location: ../login.php');
    exit;
}

// Fetch all appointments for the customer
$stmt = $pdo->prepare("
    SELECT a.id, a.appointment_date, s.name as service_name, a.status
    FROM appointments a
    JOIN services s ON a.service_id = s.id
    WHERE a.customer_id = ?
    ORDER BY a.appointment_date DESC
");
$stmt->execute([$_SESSION['user_id']]);
$appointments = $stmt->fetchAll();
?>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="book_appointment.php">
                            <i class="bi bi-calendar-plus"></i> Book Appointment
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="appointments.php">
                            <i class="bi bi-calendar-check"></i> My Appointments
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">My Appointments</h1>
            </div>

            <?php if (empty($appointments)): ?>
                <p>You have no appointments.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Service</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($appointments as $appointment): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                                    <td><?php echo htmlspecialchars($appointment['service_name']); ?></td>
                                    <td><?php echo htmlspecialchars($appointment['status']); ?></td>
                                    <td>
                                        <a href="view_appointment.php?id=<?php echo $appointment['id']; ?>" class="btn btn-sm btn-primary">View</a>
                                        <?php if ($appointment['status'] == 'completed'): ?>
                                            <a href="rate_service.php?id=<?php echo $appointment['id']; ?>" class="btn btn-sm btn-secondary">Rate</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>

