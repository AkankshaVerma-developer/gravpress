<?php
// admin/builder/publish_site.php
session_start();
require_once __DIR__ . '/../../connection/db.php';
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id'])) { echo json_encode(['status'=>'error','message'=>'Not logged in']); exit; }
$user_id = intval($_SESSION['user_id']);
$website_id = isset($_GET['website_id']) ? intval($_GET['website_id']) : 0;
$page_name = isset($_GET['page_name']) ? $_GET['page_name'] : 'home';
if(!$website_id){ echo json_encode(['status'=>'error','message'=>'Missing website_id']); exit; }

// fetch page
$stmt = $conn->prepare("SELECT p.html, p.css, w.title FROM pages p JOIN websites w ON p.website_id=w.website_id WHERE p.website_id = ? AND p.page_name = ? AND w.user_id = ?");
$stmt->bind_param("isi", $website_id, $page_name, $user_id);
$stmt->execute();
$res = $stmt->get_result();
if($res->num_rows === 0){ echo json_encode(['status'=>'error','message'=>'Page not found']); exit; }
$row = $res->fetch_assoc();
$html = $row['html'];
$css = $row['css'];
$title = htmlspecialchars($row['title'] ?? 'Website', ENT_QUOTES);

// full page
$full = "<!doctype html>\n<html>\n<head>\n<meta charset='utf-8'>\n<meta name='viewport' content='width=device-width,initial-scale=1'>\n<title>{$title}</title>\n<style>\n{$css}\n</style>\n</head>\n<body>\n{$html}\n</body>\n</html>";

$baseDir = __DIR__ . '/../../sites/';
$userDir = $baseDir . 'user_' . $user_id . '/';
$siteDir = $userDir . 'site_' . $website_id . '/';
if(!is_dir($siteDir)){ if(!mkdir($siteDir,0755,true)){ echo json_encode(['status'=>'error','message'=>'Failed create dir']); exit; } }
$path = $siteDir . $page_name . '.html';
if(file_put_contents($path, $full) === false){ echo json_encode(['status'=>'error','message'=>'Write failed']); exit; }
echo json_encode(['status'=>'ok','path'=>$path]);
