<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$theme = preg_replace('/[^a-zA-Z0-9_-]/', '', $_GET['theme']);
header("Location: create_theme_copy.php?theme=".$theme);
exit;
?>
