<?php
require '../conn.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $username = $user ? htmlspecialchars($user['username']) : 'Guest';
} catch (PDOException $e) {
    $username = 'Guest';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <style>
        #calendar {
            max-width: 400px;
            margin: 20px auto;
        }
        .datepicker-inline {
            width: 100%;
        }
        .datepicker table {
            width: 100%;
        }
        .datepicker td, .datepicker th {
            text-align: center;
            width: 40px;
            height: 40px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Schedule an Appointment</h2>
        
        <!-- Calendar Display -->
        <div id="calendar"></div>

        <!-- Service Modal -->
        <div class="modal fade" id="serviceModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Select Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="process_appointment.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="appointment_date" id="selectedDate">
                            <select class="form-select" name="service" required>
                                <option value="">Choose a service...</option>
                                <option value="1">Shoe Repair - $50.00</option>
                                <option value="2">Shoe Cleaning - $30.00</option>
                                <option value="3">Leather Conditioning - $40.00</option>
                                <option value="4">Shoe Polishing - $25.00</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Book Appointment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#calendar').datepicker({
                inline: true,
                format: 'yyyy-mm-dd',
                startDate: new Date(),
                daysOfWeekDisabled: [0],
                todayHighlight: true
            }).on('changeDate', function(e) {
                $('#selectedDate').val(e.format());
                $('#serviceModal').modal('show');
            });
        });
    </script>
</body>
</html>