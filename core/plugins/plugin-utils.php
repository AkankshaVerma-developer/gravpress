<?php
function gp_parse_plugin_header($file)
{
    if (!file_exists($file)) return [];

    $contents = file_get_contents($file);

    $headers = [
        'Name'        => 'Plugin Name',
        'Description' => 'Description',
        'Version'     => 'Version',
        'Author'      => 'Author'
    ];

    $data = [];

    foreach ($headers as $key => $label) {
        preg_match('/' . preg_quote($label, '/') . ':\s*(.+)/i', $contents, $match);
        $data[$key] = isset($match[1]) ? trim($match[1]) : 'N/A';
    }

    return $data;
}
