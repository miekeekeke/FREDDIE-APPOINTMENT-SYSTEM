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
        }

        .navbar-brand img {
            height: 40px;
            width: auto;
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="assets/images/mr-freddie.png" alt="MR.FREDDIE Logo" class="me-2">
                <span>MR.FREDDIE</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-primary me-2" href="login.php">Log In</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary text-white" href="register.php">Sign Up</a>
                        </li>
                    <?php else: ?>
                        <?php if (isset($_SESSION['user_role'])): ?>
                            <?php if ($_SESSION['user_role'] == 'admin'): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="admin/dashboard.php">Admin Dashboard</a>
                                </li>
                            <?php elseif ($_SESSION['user_role'] == 'staff'): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="staff/dashboard.php">Staff Dashboard</a>
                                </li>
                            <?php else: ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="customer/dashboard.php">Customer Dashboard</a>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Log Out</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="content-wrapper" style="margin-top: 76px;">

