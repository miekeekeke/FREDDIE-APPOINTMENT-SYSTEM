<?php
require_once '../includes/header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $is_available = $_POST['is_available'];

    $stmt = $pdo->prepare("INSERT INTO calendar (date, is_available) VALUES (?, ?) ON DUPLICATE KEY UPDATE is_available = ?");
    $stmt->execute([$date, $is_available, $is_available]);
}

$stmt = $pdo->query("SELECT date, is_available FROM calendar WHERE date >= CURDATE() ORDER BY date ASC LIMIT 90");
$calendar_data = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
?>

<h2 class="text-center mb-4">Edit Calendar</h2>

<div id="calendar"></div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css" rel="stylesheet">
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        events: [
            <?php foreach ($calendar_data as $date => $is_available): ?>
            {
                start: '<?php echo $date; ?>',
                display: 'background',
                color: <?php echo $is_available ? "'#00ff00'" : "'#ff0000'"; ?>
            },
            <?php endforeach; ?>
        ],
        dateClick: function(info) {
            var date = info.dateStr;
            var isAvailable = confirm('Set this date as available?');
            
            fetch('edit_calendar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'date=' + date + '&is_available=' + (isAvailable ? 1 : 0)
            }).then(function(response) {
                if (response.ok) {
                    calendar.refetchEvents();
                }
            });
        }
    });
    calendar.render();
});
</script>

<?php include '../includes/footer.php'; ?>

