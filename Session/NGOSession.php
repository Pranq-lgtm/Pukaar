<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Kicks out anyone who isn't an NGO or Admin
function require_ngo_login() {
    // Check if they are logged in AND their role is correct
    if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['ngo', 'admin'])) {
        // Send them to the dedicated Responder login page
        header("Location: login.php");
        exit();
    }
}

// 2. Skips the login page if they are already an active NGO
function redirect_if_ngo_logged_in() {
    if (isset($_SESSION['user_id']) && in_array($_SESSION['role'], ['ngo', 'admin'])) {
        header("Location: index.php");
        exit();
    }
}
?>