<?php
require 'conn.php';
session_start();
require_login('staff');

$appointmentId = $_POST['appointment_id'];
$action = $_POST['action'];

$status = ($action === 'accept') ? 'Accepted' : 'Rejected';

$stmt = $pdo->prepare("UPDATE appointments SET Status = ? WHERE AppointmentID = ?");
$stmt->execute([$status, $appointmentId]);

header("Location: dashboard_staff.php");
exit;
?>
