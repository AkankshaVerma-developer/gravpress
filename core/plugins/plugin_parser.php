<?php

function gp_parse_plugin_header($file) {
    $default = [
        "Plugin Name" => "",
        "Description" => "",
        "Version" => "",
        "Author" => ""
    ];

    $contents = file_get_contents($file);

    foreach ($default as $key => $value) {
        if (preg_match('/' . preg_quote($key, '/') . ':\s*(.+)/', $contents, $match)) {
            $default[$key] = trim($match[1]);
        }
    }

    return $default;
}
