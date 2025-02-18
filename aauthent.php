<?php
session_start();

// Dummy admin credentials
$admin_username = 'admin';
$admin_password = 'p123';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate credentials
    if ($username === $admin_username && $password === $admin_password) {
        // Redirect to admin dashboard
        $_SESSION['admin_logged_in'] = true;
        header('Location: adashbrd.php');
        exit;
    } else {
        // Set error message and redirect back to login page
        $_SESSION['error'] = 'Invalid username or password.';
        header('Location: adminlogin.php');
        exit;
    }
} else {
    // Redirect back to login page if accessed directly
    header('Location: adminlogin.php');
    exit;
}
