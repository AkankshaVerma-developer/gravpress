<?php
session_start();
require_once '../../connection/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../admin/login.php");
    exit;
}

if (!isset($_GET['theme'])) {
    die("Invalid theme!");
}

$user_id = intval($_SESSION['user_id']);
$theme = $conn->real_escape_string($_GET['theme']);

// Check if user already has theme
$check = $conn->query("SELECT * FROM active_theme WHERE user_id=$user_id");

if ($check->num_rows > 0) {
    $conn->query("UPDATE active_theme SET theme_slug='$theme' WHERE user_id=$user_id");
} else {
    $conn->query("INSERT INTO active_theme (user_id, theme_slug) VALUES ($user_id, '$theme')");
}

// Redirect to admin dashboard
header("Location: ../../admin/dashboard.php?theme_activated=$theme");
exit;
?>
