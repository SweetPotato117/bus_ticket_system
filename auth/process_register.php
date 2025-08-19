<?php
session_start();
require_once __DIR__ . '/../models/dbconn.php';

// Simple register handler using prepared statements
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['auth_message'] = 'Invalid request method.';
    header('Location: register.php');
    exit;
}

$name = trim($_POST['name'] ?? '');
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';

if ($password !== $password_confirm) {
    $_SESSION['auth_message'] = 'Passwords do not match.';
    header('Location: register.php');
    exit;
}

if (empty($name) || empty($password)) {
    $_SESSION['auth_message'] = 'Please fill all required fields.';
    header('Location: register.php');
    exit;
}

// Check if username already exists
$stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE name = ? LIMIT 1");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 's', $name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $count = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);
    if ($count > 0) {
        $_SESSION['auth_message'] = 'Username already taken.';
        header('Location: register.php');
        exit;
    }
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
$created_at = date('Y-m-d H:i:s');

// Insert without email (email optional / nullable)
$insert = mysqli_prepare($conn, "INSERT INTO users (name, password, created_at) VALUES (?, ?, ?)");
if (!$insert) {
    $_SESSION['auth_message'] = 'Database error: cannot prepare statement.';
    header('Location: register.php');
    exit;
}

mysqli_stmt_bind_param($insert, 'sss', $name, $hashed, $created_at);
$ok = mysqli_stmt_execute($insert);
mysqli_stmt_close($insert);

if ($ok) {
    $_SESSION['auth_message'] = 'Account created. You can now login.';
    header('Location: login.php');
    exit;
} else {
    $_SESSION['auth_message'] = 'Failed to create account.';
    header('Location: register.php');
    exit;
}
