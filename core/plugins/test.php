<?php
/*
Plugin Name: Sample Notification
Description: Show a notification on admin dashboard.
Version: 2.0
Author: Test Dev
*/

add_action("admin_header", function(){
    echo "<div style='background:red;color:#fff;padding:10px;'>Plugin Loaded</div>";
});
