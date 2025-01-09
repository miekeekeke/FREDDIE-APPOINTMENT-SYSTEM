<?php
require_once '../includes/dashboard_header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'staff') {
    header('Location: ../login.php');
    exit;
}

$filter = $_GET['filter'] ?? 'today';
$staff_id = $_SESSION['user_id'];

switch ($filter) {
    case 'today':
        $date_condition = "DATE(a.appointment_date) = CURDATE()";
        break;
    case 'this_week':
        $date_condition = "YEARWEEK(a.appointment_date, 1) = YEARWEEK(CURDATE(), 1)";
        break;
    case 'this_month':
        $date_condition = "YEAR(a.appointment_date) = YEAR(CURDATE()) AND MONTH(a.appointment_date) = MONTH(CURDATE())";
        break;
    case 'this_year':
        $date_condition = "YEAR(a.appointment_date) = YEAR(CURDATE())";
        break;
    default:
        $date_condition = "DATE(a.appointment_date) = CURDATE()";
}

$stmt = $pdo->prepare("
    SELECT a.id, a.appointment_date, a.status, s.name as service, u.first_name, u.last_name
    FROM appointments a
    JOIN services s ON a.service_id = s.id
    JOIN users u ON a.customer_id = u.id
    WHERE $date_condition AND a.staff_id = ?
    ORDER BY a.appointment_date DESC
");
$stmt->execute([$staff_id]);
$bookings = $stmt->fetchAll();
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
                        <a class="nav-link" href="manage_appointments.php">
                            <i class="bi bi-calendar-check"></i> Manage Appointments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="booking_summary.php">
                            <i class="bi bi-file-text"></i> Booking Summary
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Booking Summary</h1>
            </div>

            <div class="mb-3">
                <form method="get" action="" class="d-inline">
                    <select name="filter" onchange="this.form.submit()" class="form-select">
                        <option value="today" <?php echo $filter == 'today' ? 'selected' : ''; ?>>Today</option>
                        <option value="this_week" <?php echo $filter == 'this_week' ? 'selected' : ''; ?>>This Week</option>
                        <option value="this_month" <?php echo $filter == 'this_month' ? 'selected' : ''; ?>>This Month</option>
                        <option value="this_year" <?php echo $filter == 'this_year' ? 'selected' : ''; ?>>This Year</option>
                    </select>
                </form>
            </div>

            <div

