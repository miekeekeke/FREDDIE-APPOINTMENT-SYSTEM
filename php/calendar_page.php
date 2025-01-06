<?php
require_once 'conn.php';
require_once '../classes/AppointmentCalendar.php';

session_start();

// Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header('Location: calendar_page.php');
//     exit();
// }

$calendar = new AppointmentCalendar($conn);
$current_month = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('m');
$current_year = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MR.FREDDIE Shoe Repair - Appointment Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/calendar.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Book an Appointment</h1>
        
        <div class="calendar-navigation mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <button class="btn btn-outline-primary" onclick="previousMonth()">
                        Previous Month
                    </button>
                </div>
                <div class="col text-center">
                    <h2 id="current-month"><?php echo date('F Y', mktime(0,0,0,$current_month,1,$current_year)); ?></h2>
                </div>
                <div class="col text-end">
                    <button class="btn btn-outline-primary" onclick="nextMonth()">
                        Next Month
                    </button>
                </div>
            </div>
        </div>

        <div id="appointment-calendar">
            <?php echo $calendar->generateCalendarMonth($current_month, $current_year); ?>
        </div>
    </div>

    <!-- Service Selection Modal -->
    <div class="modal fade" id="serviceModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="serviceForm">
                        <input type="hidden" name="selected_date" id="selected_date">
                        
                        <div class="mb-3">
                            <label class="form-label">Service Type</label>
                            <select class="form-select" name="service_type" required>
                                <option value="">Select a service...</option>
                                <option value="repair">Shoe Repair</option>
                                <option value="cleaning">Shoe Cleaning</option>
                                <option value="polish">Shoe Polishing</option>
                                <option value="leather">Leather Conditioning</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Additional Notes</label>
                            <textarea class="form-control" name="notes" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="submitAppointment()">Book Appointment</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/calendar.js"></script>
</body>
</html>