<?php
session_start();
header("Location: " . (isset($_SESSION['admin_logged_in']) ? "dashboard.php" : "login.php"));
exit();
?>
