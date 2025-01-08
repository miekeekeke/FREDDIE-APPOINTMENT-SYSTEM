<?php
session_start();

function is_logged_in($role) {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

function require_login($role, $redirect = 'index.php') {
    if (!is_logged_in($role)) {
        header("Location: $redirect");
        exit;
    }
}
?>
