<?php

function gp_get_setting($plugin, $key, $default = null) {
    global $conn;

    $stmt = $conn->prepare("SELECT setting_value FROM gp_plugin_settings WHERE plugin_slug=? AND setting_key=?");
    $stmt->execute([$plugin, $key]);

    $value = $stmt->fetchColumn();
    return $value !== false ? $value : $default;
}

function gp_save_setting($plugin, $key, $value) {
    global $conn;

    $stmt = $conn->prepare("
        INSERT INTO gp_plugin_settings (plugin_slug, setting_key, setting_value)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)
    ");

    $stmt->execute([$plugin, $key, $value]);
}
