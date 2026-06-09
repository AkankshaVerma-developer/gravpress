<?php
require_once '../partials/db.php';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) { header('Location: posts.php'); exit; }
$id = (int)$_GET['id'];

// optionally remove image file
$res = $conn->query("SELECT image FROM posts WHERE id = $id");
if ($res && $r = $res->fetch_assoc()) {
    if ($r['image'] && file_exists('../images/'.$r['image'])) unlink('../images/'.$r['image']);
}

$stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->close();
header('Location: posts.php');
