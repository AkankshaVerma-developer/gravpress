<?php
// admin/create_website.php
session_start();
require_once __DIR__ . '/../connection/db.php';

if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}
$user_id = intval($_SESSION['user_id']);

// Create a new website record
$title = "Untitled Website";
$stmt = $conn->prepare("INSERT INTO websites (user_id, title) VALUES (?, ?)");
$stmt->bind_param("is", $user_id, $title);
$stmt->execute();
$website_id = $stmt->insert_id;
$stmt->close();

// Create a default 'home' page
$default_html = "<section style='padding:40px;text-align:center'><h1>Welcome</h1><p>Edit this page</p></section>";
$default_css = "";
$default_json = json_encode([
    "components" => [
        ["type"=>"text","content"=>"<h1>Welcome</h1><p>Edit this page using the builder</p>"]
    ]
]);

$ins = $conn->prepare("INSERT INTO pages (website_id, page_name, html, css, grapes_json) VALUES (?, 'home', ?, ?, ?)");
$ins->bind_param("isss", $website_id, $default_html, $default_css, $default_json);
$ins->execute();
$ins->close();

// Redirect to builder
header("Location: builder/index.php?website_id=".$website_id);
exit;
