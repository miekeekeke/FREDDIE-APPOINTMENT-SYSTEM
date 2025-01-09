<?php
require_once '../includes/dashboard_header.php';

// Ensure the user is a customer
if ($_SESSION['user_role'] !== 'customer') {
    header('Location: ../login.php');
    exit;
}

// Fetch available services
$stmt = $pdo->query("SELECT * FROM services");
$services = $stmt->fetchAll();

// Fetch available dates (next 30 days)
$stmt = $pdo->prepare("
    SELECT date FROM calendar 
    WHERE date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
    AND is_available = 1
");
$stmt->execute();
$available_dates = $stmt->fetchAll(PDO::FETCH_COLUMN);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_id = $_POST['service_id'];
    $appointment_date = $_POST['appointment_date'];

    $stmt = $pdo->prepare("INSERT INTO appointments (customer_id, service_id, appointment_date, status) VALUES (?, ?, ?, 'scheduled')");
    if ($stmt->execute([$_SESSION['user_id'], $service_id, $appointment_date])) {
        $success_message = "Appointment booked successfully!";
    } else {
        $error_message = "Error booking appointment. Please try again.";
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js"></script>

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
                        <a class="nav-link active" href="book_appointment.php">
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
                <h1 class="h2">Book Appointment</h1>
            </div>

            <?php if (isset($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>

            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form method="post" action="">
                <div class="mb-3">
                    <label for="service_id" class="form-label">Select Service</label>
                    <select class="form-select" id="service_id" name="service_id" required>
                        <option value="">Choose a service...</option>
                        <?php foreach ($services as $service): ?>
                            <option value="<?php echo $service['id']; ?>">
                                <?php echo htmlspecialchars($service['name']); ?> - $<?php echo number_format($service['price'], 2); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="appointment_date" class="form-label">Select Date</label>
                    <div id="calendar"></div>
                    <input type="hidden" id="appointment_date" name="appointment_date" required>
                </div>

                <button type="submit" class="btn btn-primary">Book Appointment</button>
            </form>
        </main>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        selectConstraint: {
            start: '<?php echo date('Y-m-d'); ?>',
            end: '2030-12-31'
        },
        validRange: {
            start: '<?php echo date('Y-m-d'); ?>'
        },
        events: [
            <?php foreach ($available_dates as $date): ?>
            {
                start: '<?php echo $date; ?>',
                display: 'background',
                color: '#90EE90'
            },
            <?php endforeach; ?>
        ],
        selectAllow: function(selectInfo) {
            return calendar.getEvents().some(function(event) {
                return event.start.getTime() === selectInfo.start.getTime();
            });
        },
        select: function(info) {
            document.getElementById('appointment_date').value = info.startStr;
        }
    });
    calendar.render();
});
</script>

