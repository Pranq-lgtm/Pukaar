<?php
// 1. Turn on error reporting to fix the white screen
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// 2. Wrap the require statement in a check to ensure the path is correct
$db_path = '../config/db.php';
if (!file_exists($db_path)) {
    die("Fatal Error: Cannot find database configuration file at $db_path");
}
require_once $db_path;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: ../signup.php");
        exit();
    }

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $_SESSION['error'] = "Email is already registered.";
            header("Location: ../signup.php");
            exit();
        }

        // Insert new user into Supabase
        $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, 'general') RETURNING id, role");
        $stmt->execute([$full_name, $email, $hashed_password]);
        $new_user = $stmt->fetch();

        // Create Active Session
        $_SESSION['user_id'] = $new_user['id'];
        $_SESSION['full_name'] = $full_name;
        $_SESSION['role'] = $new_user['role'];

        // Redirect to protected public area
        header("Location: ../index.php"); // Or whatever your successful login destination is
        exit();

    } catch (PDOException $e) {
        // Display the actual database error instead of a white screen!
        die("Database Error: " . $e->getMessage());
    }
} else {
    die("Invalid request method.");
}
?>