<?php
require_once 'includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'customer') {
    header('Location: login.php');
    exit;
}

$appointment_id = $_GET['id'] ?? null;

if (!$appointment_id) {
    header('Location: service_status.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM appointments WHERE id = ? AND customer_id = ?");
$stmt->execute([$appointment_id, $_SESSION['user_id']]);
$appointment = $stmt->fetch();

if (!$appointment || $appointment['status'] !== 'completed') {
    header('Location: service_status.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $stmt = $pdo->prepare("INSERT INTO feedback (appointment_id, rating, comment) VALUES (?, ?, ?)");
    if ($stmt->execute([$appointment_id, $rating, $comment])) {
        $success = "Thank you for your feedback!";
    } else {
        $error = "An error occurred while submitting your feedback.";
    }
}
?>

<h2 class="text-center mb-4">Rate Service</h2>

<?php if (isset($success)): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php elseif (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
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

<?php include 'includes/footer.php'; ?>

