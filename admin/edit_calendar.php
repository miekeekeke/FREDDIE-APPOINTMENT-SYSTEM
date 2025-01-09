<?php
require_once '../includes/dashboard_header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $date = $_POST['date'];
  $is_available = $_POST['is_available'];

  $stmt = $pdo->prepare("INSERT INTO calendar (date, is_available) VALUES (?, ?) ON DUPLICATE KEY UPDATE is_available = ?");
  $stmt->execute([$date, $is_available, $is_available]);
  
  // Return JSON response for AJAX request
  echo json_encode(['success' => true]);
  exit;
}

$stmt = $pdo->query("SELECT date, is_available FROM calendar WHERE date >= CURDATE() ORDER BY date ASC LIMIT 90");
$calendar_data = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
?>

<div class="container-fluid">
  <div class="row">
    <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
      <!-- Sidebar content -->
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Calendar</h1>
      </div>

      <div id="calendar"></div>
    </main>
  </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel">Confirm Date Change</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to change the availability of this date?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="confirmChange">Confirm</button>
      </div>
    </div>
  </div>
</div>

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
        color: <?php echo $is_available ? "'#90EE90'" : "'#D3D3D3'"; ?>,
        extendedProps: {
          is_available: <?php echo $is_available ? 'true' : 'false'; ?>
        }
      },
      <?php endforeach; ?>
    ],
    dateClick: function(info) {
      var date = info.dateStr;
      var isCurrentlyAvailable = info.dayEl.querySelector('.fc-bg-event').style.backgroundColor === 'rgb(144, 238, 144)';
      
      $('#confirmModalLabel').text(isCurrentlyAvailable ? 'Make Date Unavailable' : 'Make Date Available');
      $('#confirmModal').modal('show');
      
      $('#confirmChange').off('click').on('click', function() {
        fetch('edit_calendar.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: 'date=' + date + '&is_available=' + (isCurrentlyAvailable ? 0 : 1)
        }).then(function(response) {
          return response.json();
        }).then(function(data) {
          if (data.success) {
            calendar.getEventById(date)?.remove();
            calendar.addEvent({
              id: date,
              start: date,
              display: 'background',
              color: isCurrentlyAvailable ? '#D3D3D3' : '#90EE90',
              extendedProps: {
                is_available: !isCurrentlyAvailable
              }
            });
          }
          $('#confirmModal').modal('hide');
        });
      });
    }
  });
  calendar.render();
});
</script>

<?php require_once '../includes/footer.php'; ?>

