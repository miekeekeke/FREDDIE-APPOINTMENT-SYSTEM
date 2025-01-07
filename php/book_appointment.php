<?php
require 'conn.php';
session_start();
require_login('customer');

$customerId = $_SESSION['customer_id'];
$date = $_POST['date'];
$serviceId = $_POST['service'];

$stmt = $pdo->prepare("SELECT * FROM availability WHERE Date = ? AND Status = 'Available'");
$stmt->execute([$date]);
if ($stmt->rowCount() === 0) {
    die("Selected date is no longer available.");
}

$stmt = $pdo->prepare("INSERT INTO appointment (CustomerID, ServiceID, Date, Status) VALUES (?, ?, ?, 'Pending')");
$stmt->execute([$customerId, $serviceId, $date]);

header("Location: dashboard_customer.php");
exit;
?>
