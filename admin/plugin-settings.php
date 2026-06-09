<?php
include "../connection/db.php";
include "../core/hooks.php";

if (!isset($_GET['plugin'])) {
    die("Plugin not specified");
}

$pluginSlug = $_GET['plugin'];

foreach ($GLOBALS['gp_plugin_pages'] as $page) {
    if ($page['slug'] === $pluginSlug) {
        echo "<h2>{$page['title']} Settings</h2>";
        call_user_func($page['callback']);
        exit;
    }
}

echo "No settings found.";
