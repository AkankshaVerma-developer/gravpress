<?php
// admin/builder/save_page.php
session_start();
require_once __DIR__ . '/../../connection/db.php';
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id'])) { echo json_encode(['status'=>'error','message'=>'Not logged in']); exit; }
$user_id = intval($_SESSION['user_id']);

$website_id = isset($_POST['website_id']) ? intval($_POST['website_id']) : 0;
$page_name = isset($_POST['page_name']) ? $_POST['page_name'] : 'home';
$html = isset($_POST['html']) ? $_POST['html'] : '';
$css = isset($_POST['css']) ? $_POST['css'] : '';
$grapes_json = isset($_POST['grapes_json']) ? $_POST['grapes_json'] : '';

if(!$website_id){ echo json_encode(['status'=>'error','message'=>'Missing website_id']); exit; }

// confirm ownership
$chk = $conn->prepare("SELECT website_id FROM websites WHERE website_id = ? AND user_id = ?");
$chk->bind_param("ii",$website_id,$user_id);
$chk->execute();
$chk->store_result();
if($chk->num_rows === 0){ echo json_encode(['status'=>'error','message'=>'Access denied']); exit; }
$chk->close();

// update or insert
$sel = $conn->prepare("SELECT page_id FROM pages WHERE website_id=? AND page_name=?");
$sel->bind_param("is", $website_id, $page_name);
$sel->execute();
$sel->store_result();
if($sel->num_rows>0){
    $sel->bind_result($page_id); $sel->fetch(); $sel->close();
    $upd = $conn->prepare("UPDATE pages SET html = ?, css = ?, grapes_json = ? WHERE page_id = ?");
    $upd->bind_param("sssi", $html, $css, $grapes_json, $page_id);
    $ok = $upd->execute();
    $upd->close();
    if($ok) echo json_encode(['status'=>'ok','message'=>'Updated']);
    else echo json_encode(['status'=>'error','message'=>'DB update failed']);
    exit;
} else {
    $sel->close();
    $ins = $conn->prepare("INSERT INTO pages (website_id, page_name, html, css, grapes_json) VALUES (?, ?, ?, ?, ?)");
    $ins->bind_param("issss",$website_id, $page_name, $html, $css, $grapes_json);
    $ok = $ins->execute();
    $ins->close();
    if($ok) echo json_encode(['status'=>'ok','message'=>'Inserted']);
    else echo json_encode(['status'=>'error','message'=>'DB insert failed']);
    exit;
}
