<?php 
function gp_activate_plugin($slug, $plugins_dir = __DIR__ . '/../../plugins', $active_json = __DIR__ . '/../../data/active_plugins.json') {
    $all = gp_get_all_plugins($plugins_dir);
    if (!isset($all[$slug])) return ['success'=>false,'msg'=>'Plugin not found'];
    $meta = $all[$slug];
    if (file_exists($meta['main_file'])) {
        include_once $meta['main_file'];
        // call activate function if exists
        $activate_fn = $slug . '_activate';
        if (function_exists($activate_fn)) call_user_func($activate_fn);
        // update active json
        $current = gp_get_active_plugins($active_json);
        if (!in_array($slug, $current)) {
            $current[] = $slug;
            @file_put_contents($active_json, json_encode(array_values($current), JSON_PRETTY_PRINT));
        }
        return ['success'=>true];
    }
    return ['success'=>false,'msg'=>'Main file missing'];
}
?>