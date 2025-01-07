<?php
require 'conn.php';
session_start();
require_login('admin');

$date = $_POST['date'];
$status = $_POST['status'];

$stmt = $pdo->prepare("SELECT * FROM availability WHERE Date = ?");
$stmt->execute([$date]);
if ($stmt->rowCount() > 0) {
    $stmt = $pdo->prepare("UPDATE availability SET Status = ? WHERE Date = ?");
    $stmt->execute([$status, $date]);
} else {
    $stmt = $pdo->prepare("INSERT INTO availability (Date, Status) VALUES (?, ?)");
    $stmt->execute([$date, $status]);
}

header("Location: dashboard_admin.php");
exit;
?>
