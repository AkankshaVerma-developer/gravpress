<?php
include_once __DIR__ . "/plugin_parser.php";

foreach (scandir($pluginDir) as $plugin) {
    if ($plugin === "." || $plugin === "..") continue;

    $pluginFile = "$pluginDir/$plugin/$plugin.php";
    if (!file_exists($pluginFile)) continue;

    $meta = gp_parse_plugin_header($pluginFile);

    // Register if not found
    $stmt = $conn->prepare("SELECT id FROM gp_plugins WHERE plugin_slug=?");
    $stmt->execute([$plugin]);

    if ($stmt->rowCount() == 0) {
        $insert = $conn->prepare("INSERT INTO gp_plugins (plugin_slug, plugin_name, version) VALUES (?,?,?)");
        $insert->execute([$plugin, $meta["Plugin Name"], $meta["Version"]]);
    } else {
        // Update name/version if changed
        $update = $conn->prepare("UPDATE gp_plugins SET plugin_name=?, version=? WHERE plugin_slug=?");
        $update->execute([$meta["Plugin Name"], $meta["Version"], $plugin]);
    }
}
?>