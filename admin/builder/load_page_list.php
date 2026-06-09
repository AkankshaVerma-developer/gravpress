<?php
// admin/builder/load_pages_list.php
session_start();
require_once __DIR__ . '/../../connection/db.php';
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id'])) { echo json_encode(['status'=>'error']); exit; }
$user_id = intval($_SESSION['user_id']);
$website_id = isset($_GET['website_id']) ? intval($_GET['website_id']) : 0;
if (!$website_id) { echo json_encode(['status'=>'error','message'=>'Missing website_id']); exit; }

$stmt = $conn->prepare("SELECT page_name, page_id FROM pages WHERE website_id = ? ORDER BY page_id ASC");
$stmt->bind_param("i", $website_id);
$stmt->execute();
$res = $stmt->get_result();
$pages = [];
while ($row = $res->fetch_assoc()) $pages[] = $row;
echo json_encode(['status'=>'ok','pages'=>$pages]);
$stmt->close();
