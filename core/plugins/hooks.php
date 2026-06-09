<?php
if (!isset($GLOBALS['_gp_actions'])) {
    $GLOBALS['_gp_actions'] = [];
}
if (!isset($GLOBALS['_gp_filters'])) {
    $GLOBALS['_gp_filters'] = [];
}

/**
 * Add an action callback.
 */
function add_action($hook, $callback, $priority = 10) {
    $GLOBALS['_gp_actions'][$hook][$priority][] = $callback;
}

/**
 * Run all callbacks for an action.
 */
function do_action($hook, ...$args) {
    if (empty($GLOBALS['_gp_actions'][$hook])) return;
    ksort($GLOBALS['_gp_actions'][$hook]);
    foreach ($GLOBALS['_gp_actions'][$hook] as $priority => $callbacks) {
        foreach ($callbacks as $cb) {
            if (is_callable($cb)) {
                call_user_func_array($cb, $args);
            }
        }
    }
}

/**
 * Add a filter callback.
 */
function add_filter($hook, $callback, $priority = 10) {
    $GLOBALS['_gp_filters'][$hook][$priority][] = $callback;
}

/**
 * Apply filters to a value.
 */
function apply_filters($hook, $value, ...$args) {
    if (empty($GLOBALS['_gp_filters'][$hook])) return $value;
    ksort($GLOBALS['_gp_filters'][$hook]);
    foreach ($GLOBALS['_gp_filters'][$hook] as $priority => $callbacks) {
        foreach ($callbacks as $cb) {
            if (is_callable($cb)) {
                $value = call_user_func_array($cb, array_merge([$value], $args));
            }
        }
    }
    return $value;
}
$GLOBALS['gp_plugin_pages'] = [];

function add_plugin_page($plugin_slug, $title, $callback) {
    $GLOBALS['gp_plugin_pages'][] = [
        "slug" => $plugin_slug,
        "title" => $title,
        "callback" => $callback
    ];
}
$GLOBALS['gp_activation_hooks'] = [];
$GLOBALS['gp_deactivation_hooks'] = [];
$GLOBALS['gp_uninstall_hooks'] = [];

// Register activation hook
function register_activation_hook($plugin, $callback) {
    $GLOBALS['gp_activation_hooks'][$plugin] = $callback;
}

// Register deactivation hook
function register_deactivation_hook($plugin, $callback) {
    $GLOBALS['gp_deactivation_hooks'][$plugin] = $callback;
}

// Register uninstall hook
function register_uninstall_hook($plugin, $callback) {
    $GLOBALS['gp_uninstall_hooks'][$plugin] = $callback;
}
