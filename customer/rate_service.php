<?php
require_once '../includes/dashboard_header.php';

// Ensure the user is a customer
if ($_SESSION['user_role'] !== 'customer') {
    header('Location: ../login.php');
    exit;
}

$appointment_id = $_GET['id'] ?? null;

if (!$appointment_id) {
    header('Location: appointments.php');
    exit;
}

// Fetch appointment details
$stmt = $pdo->prepare("
    SELECT a.*, s.name as service_name
    FROM appointments a
    JOIN services s ON a.service_id = s.id
    WHERE a.id = ? AND a.customer_id = ? AND a.status = 'completed'
");
$stmt->execute([$appointment_id, $_SESSION['user_id']]);
$appointment = $stmt->fetch();

if (!$appointment) {
    header('Location: appointments.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $stmt = $pdo->prepare("INSERT INTO feedback (appointment_id, rating, comment) VALUES (?, ?, ?)");
    if ($stmt->execute([$appointment_id, $rating, $comment])) {
        $success_message = "Thank you for your feedback!";
    } else {
        $error_message = "Error submitting feedback. Please try again.";
    }
}
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
                        <a class="nav-link" href="appointments.php">
                            <i class="bi bi-calendar-check"></i> My Appointments
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Rate Service</h1>
            </div>

            <?php if (isset($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php elseif (isset($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php else: ?>
                <form method="post" action="">
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating (1-5 stars)</label>
                        <select class="form-select" id="rating" name="rating" required>
                            <option value="">Choose a rating...</option>
                            <option value="1">1 Star</option>
                            <option value="2">2 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="5">5 Stars</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="comment" class="form-label">Comment (optional)</label>
                        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Feedback</button>
                </form>
            <?php endif; ?>

            <div class="mt-3">
                <a href="appointments.php" class="btn btn-secondary">Back to Appointments</a>
            </div>
        </main>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>

