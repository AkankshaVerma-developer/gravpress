<?php
include "../core/hooks.php";

if ($action === "activate") {

    // Run activation hook if exists
    if (isset($GLOBALS['gp_activation_hooks'][$plugin])) {
        call_user_func($GLOBALS['gp_activation_hooks'][$plugin]);
    }

    $stmt = $conn->prepare("UPDATE gp_plugins SET plugin_status='active' WHERE plugin_slug=?");
    $stmt->execute([$plugin]);
}

if ($action === "deactivate") {

    // Run deactivate hook if exists
    if (isset($GLOBALS['gp_deactivation_hooks'][$plugin])) {
        call_user_func($GLOBALS['gp_deactivation_hooks'][$plugin]);
    }

    $stmt = $conn->prepare("UPDATE gp_plugins SET plugin_status='inactive' WHERE plugin_slug=?");
    $stmt->execute([$plugin]);
}

if ($action === "uninstall") {

    // Run uninstall hook if exists
    if (isset($GLOBALS['gp_uninstall_hooks'][$plugin])) {
        call_user_func($GLOBALS['gp_uninstall_hooks'][$plugin]);
    }

    $stmt = $conn->prepare("DELETE FROM gp_plugins WHERE plugin_slug=?");
    $stmt->execute([$plugin]);

    $stmt = $conn->prepare("DELETE FROM gp_plugin_settings WHERE plugin_slug=?");
    $stmt->execute([$plugin]);
}

header("Location: plugins.php?status=updated");
exit;
?>