<?php
session_start();
require_once "../connection/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['theme_slug'])) {
    $theme = $_POST['theme_slug'];

    // ensure theme exists
    $stmt = $conn->prepare("SELECT id FROM themes WHERE slug = ?");
    $stmt->bind_param("s", $theme);
    $stmt->execute();
    $r = $stmt->get_result()->fetch_assoc();
    if (!$r) {
        $_SESSION['flash'] = "Theme not found.";
        header("Location: themes.php");
        exit;
    }

    // insert or update active_theme
    $stmt = $conn->prepare("INSERT INTO active_theme (user_id, theme_slug) VALUES (?, ?) ON DUPLICATE KEY UPDATE theme_slug = VALUES(theme_slug)");
    $stmt->bind_param("is", $user_id, $theme);
    $stmt->execute();

    $_SESSION['flash'] = "Activated theme: $theme";
    header("Location: themes.php");
    exit;
}
header("Location: themes.php");
exit;
