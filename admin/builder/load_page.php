<?php
// admin/builder/load_page.php
session_start();require_once __DIR__ . '/../../connection/db.php';
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status'=>'error','message'=>'Not logged in']); exit;
}
$user_id = intval($_SESSION['user_id']);
$website_id = isset($_GET['website_id']) ? intval($_GET['website_id']) : 0;
$page_name = isset($_GET['page_name']) ? $_GET['page_name'] : 'home';
if (!$website_id) { echo json_encode(['status'=>'error','message'=>'Missing website_id']); exit; }

$stmt = $conn->prepare("SELECT p.page_id, p.html, p.css, p.grapes_json FROM pages p JOIN websites w ON p.website_id=w.website_id WHERE p.website_id = ? AND p.page_name = ? AND w.user_id = ?");
$stmt->bind_param("isi", $website_id, $page_name, $user_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    echo json_encode(['status'=>'error','message'=>'Page not found']); exit;
}
$row = $res->fetch_assoc();
echo json_encode(['status'=>'ok','page_id'=>$row['page_id'],'html'=>$row['html'],'css'=>$row['css'],'grapes_json'=>$row['grapes_json']]);
$stmt->close();
