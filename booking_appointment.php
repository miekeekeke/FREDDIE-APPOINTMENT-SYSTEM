<?php
require_once 'includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'customer') {
    header('Location: login.php');
    exit;
}

// Fetch available dates
$stmt = $pdo->query("SELECT date FROM calendar WHERE is_available = 1");
$available_dates = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Fetch services
$stmt = $pdo->query("SELECT * FROM services");
$services = $stmt->fetchAll();
?>

<h2 class="text-center mb-4">Book an Appointment</h2>

<div id="calendar" class="mb-4"></div>

<div id="serviceSelection" style="display: none;">
    <h3>Select a Service</h3>
    <form method="post" action="submit_appointment.php">
        <input type="hidden" id="selectedDate" name="selectedDate">
        <div class="mb-3">
            <select class="form-select" name="service" required>
                <option value="">Choose a service...</option>
                <?php foreach ($services as $service): ?>
                    <option value="<?php echo $service['id']; ?>"><?php echo $service['name']; ?> - $<?php echo $service['price']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit Appointment</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css" rel="stylesheet">
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
                color: '#00ff00'
            },
            <?php endforeach; ?>
        ],
        select: function(info) {
            if (info.start < new Date()) {
                calendar.unselect();
                return;
            }
            document.getElementById('selectedDate').value = info.startStr;
            document.getElementById('serviceSelection').style.display = 'block';
        }
    });
    calendar.render();
});
</script>

<?php include 'includes/footer.php'; ?>

