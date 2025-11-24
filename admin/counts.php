<?php
session_start();
require_once "../connection/db.php";
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error'=>'unauth']);
    exit;
}
$uid = $_SESSION['user_id'];

// total sites
$stmt = $conn->prepare("SELECT COUNT(*) AS c FROM sites WHERE user_id = ?");
$stmt->bind_param("i",$uid);
$stmt->execute(); $r = $stmt->get_result()->fetch_assoc(); $total_sites = (int)$r['c'];

// active sites
$stmt = $conn->prepare("SELECT COUNT(*) AS c FROM sites WHERE user_id = ? AND is_active = 1");
$stmt->bind_param("i",$uid);
$stmt->execute(); $r = $stmt->get_result()->fetch_assoc(); $active_sites = (int)$r['c'];

// total pages (if pages table exists) fallback 0
$total_pages = 0;
if ($conn->query("SHOW TABLES LIKE 'pages'")->num_rows) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS c FROM pages WHERE user_id = ?");
    $stmt->bind_param("i",$uid);
    $stmt->execute(); $r = $stmt->get_result()->fetch_assoc(); $total_pages = (int)$r['c'];
}

// visits last 30 days
$stmt = $conn->prepare("SELECT COUNT(v.id) AS c FROM visits v JOIN sites s ON v.site_id = s.id WHERE s.user_id = ?");
$stmt->bind_param("i",$uid);
$stmt->execute(); $r = $stmt->get_result()->fetch_assoc(); $visits = (int)$r['c'];

echo json_encode(['sites'=>$total_sites, 'active'=>$active_sites, 'pages'=>$total_pages, 'visits'=>$visits]);
