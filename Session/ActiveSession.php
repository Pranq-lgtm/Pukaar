<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Put this at the top of PROTECTED pages (like Public/index.php)
// If they have no session, it kicks them back to login.
function require_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../login.php");
        exit();
    }
}

// 2. Put this at the top of LOGIN/SIGNUP pages
// If they are already logged in, it forces them into the dashboard.
function redirect_if_logged_in() {
    if (isset($_SESSION['user_id'])) {
        header("Location: Public/index.php");
        exit();
    }
}
?>