<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MR.FREDDIE Repair Shop & Leather Craft</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #1a1a1a 0%, #363636 100%);
            position: relative;
            overflow: hidden;
        }
        
        .navbar {
            background-color: rgba(255, 255, 255, 0.95) !important;
            min-height: 70px;  /* Reduced from 80px */
            padding: 0.5rem 1rem;
        }

        .navbar-brand img {
            height: 150px;  /* Increased from 100px */
            width: 150px;   /* Increased from 100px */
            object-fit: contain;
            margin-top: -40px;  /* Adjusted to compensate for larger size */
            margin-bottom: -40px;
        }

        .navbar-brand span {
            display: none;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            line-height: 40px;
        }

        .btn-primary {
            background-color: #ff6b6b;
            border-color: #ff6b6b;
        }

        .btn-primary:hover {
            background-color: #ff5252;
            border-color: #ff5252;
        }

        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .btn-outline-primary {
            color: #000;
            border-color: #000;
            background-color: transparent;
        }

        .btn-outline-primary:hover {
            color: #fff;
            background-color: #000;
            border-color: #000;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="assets/images/mr-freddie.png" alt="MR.FREDDIE Logo" class="me-2">
                <span>MR.FREDDIE</span>
            </a>
            <div class="ms-auto">
                <a href="login.php" class="btn btn-outline-primary me-2">Log In</a>
                <a href="register.php" class="btn btn-primary">Sign Up</a>
            </div>
        </div>
    </nav>
    <div class="content-wrapper" style="margin-top: 76px;">
