<?php 
require 'conn.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style/index.css">
    <title>MR.FREDDIE - Shoe Repair & Cleaning</title>
</head>
<body>
    <nav class="navbar navbar-expand-sm">
        <div class="nav-head container-fluid">
            <a href="#" class="navbar-brand">
                <img class="logo" src="../imgs/MR.FREDDIE.png" alt="Logo"> MR.FREDDIE
            </a>
            <a href="registration/register_customer.php" class="btn btn-register">Register</a>
        </div>
    </nav>
    <div class="container">
        <h2 class="text-center mt-4">Welcome to MR.FREDDIE!</h2>
        <p class="text-center text-muted">Your one-stop solution for professional shoe repair and cleaning.</p>
        <div class="grid-container">
            <div class="grid-item">
                <i class="bi bi-tools"></i>
                <h3>Shoe Repair</h3>
                <p>We fix your favorite pair of shoes with precision and care. No need to toss them out!</p>
            </div>
            <div class="grid-item">
                <i class="bi bi-droplet-half"></i>
                <h3>Professional Cleaning</h3>
                <p>Make your shoes look brand new with our premium cleaning services.</p>
            </div>
            <div class="grid-item">
                <i class="bi bi-brush"></i>
                <h3>Customization</h3>
                <p>Add a personal touch to your shoes with our creative customization options.</p>
            </div>
        </div>
    </div>
</body>
</html>
