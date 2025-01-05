<?php 
$host = 'localhost';
$dbname = 'BUTANG DIRI ANG DB NAME';
$username = 'root';
$password = '';

$conn = new PDO("mysql:host=$host;dbname=$dbname=;charset=utf8", $user, $password);

if(!$conn) {
    die("Connection Failed: Unable to establish database connection.");
}


?>