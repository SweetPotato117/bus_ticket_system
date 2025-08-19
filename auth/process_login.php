<?php
session_start();
require_once __DIR__ . '/../models/dbconn.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['auth_message'] = 'Invalid request method.';
    header('Location: login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    $_SESSION['auth_message'] = 'Please fill all fields.';
    header('Location: login.php');
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT id, name, password FROM users WHERE email = ? LIMIT 1");
if (!$stmt) {
    $_SESSION['auth_message'] = 'Database error.';
    header('Location: login.php');
    exit;
}

mysqli_stmt_bind_param($stmt, 's', $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $id, $name, $hashed);
if (mysqli_stmt_fetch($stmt)) {
    mysqli_stmt_close($stmt);
    if (password_verify($password, $hashed)) {
        // login success
        session_regenerate_id(true);
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        header('Location: ../index.php');
        exit;
    }
}

mysqli_stmt_close($stmt);
$_SESSION['auth_message'] = 'Invalid credentials.';
header('Location: login.php');
exit;
