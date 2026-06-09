<?php
/*
Plugin Name: Hello Plugin
Description: Adds custom footer message.
Version: 1.0
Author: You
*/

include_once __DIR__ . "../core/plugin_settings.php";

add_plugin_page("hello-plugin", "Hello Plugin", function() {

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        gp_save_setting('hello-plugin', 'footer_message', $_POST['footer_message']);
        echo "<p style='color:green;'>Settings Updated!</p>";
    }

    $value = gp_get_setting('hello-plugin', 'footer_message', 'Default message');

    echo "
        <form method='POST'>
            <label>Footer Message</label><br>
            <input type='text' name='footer_message' value='$value' style='width: 300px;'><br><br>
            <button type='submit'>Save</button>
        </form>
    ";
});

add_action("admin_footer", function() {
    $msg = gp_get_setting("hello-plugin", "footer_message", "Hello from plugin!");
    echo "<p style='text-align:center;color:blue;'>$msg</p>";
});

/*
Plugin Name: Hello Plugin
Description: Adds a custom footer text.
Version: 1.1
Author: You
*/

register_activation_hook("hello-plugin", function(){
    global $conn;
    $conn->query("CREATE TABLE IF NOT EXISTS hello_messages(id INT AUTO_INCREMENT PRIMARY KEY, message VARCHAR(255))");
});

register_deactivation_hook("hello-plugin", function(){
    // Example: stop cron, remove cache etc.
});

register_uninstall_hook("hello-plugin", function(){
    global $conn;
    $conn->query("DROP TABLE IF EXISTS hello_messages");
});

add_action("admin_footer", function(){
    echo "<p style='text-align:center;color:blue;'>Hello from activated plugin!</p>";
});
?>