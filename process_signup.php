<?php
session_start();
require_once 'config/pdo_db.php';
require_once 'Models/User.php';


$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$csrf_token = $_POST['csrf_token'] ?? '';

if (!hash_equals($_SESSION['csrf_token'] ?? '', $csrf_token)) {
    die('Invalid CSRF token');
}

if ($username && $email && $password) {
    $user = new User($pdo);
    if ($user->findByEmail($email)) {
        die('Email already in use.');
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $user->create([
        'username' => $username,
        'email' => $email,
        'password' => $hashedPassword
    ]);

    echo 'Registration successful. <a href="login.php">Login now</a>';
} else {
    echo 'Please fill in all fields.';
}

