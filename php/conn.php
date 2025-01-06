<?php 
$host = 'localhost';
$dbname = 'freddie_repairshop';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}


?>