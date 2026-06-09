<?php
require_once 'partials/db.php';
header('Content-Type: application/json');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid post id']);
    exit;
}

$post_id = (int) $_POST['id'];
$user_ip = $_SERVER['REMOTE_ADDR'];

// Check if user already liked this post
$check = $conn->prepare("SELECT id FROM post_likes WHERE post_id = ? AND user_ip = ?");
$check->bind_param('is', $post_id, $user_ip);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    // User already liked → UNLIKE
    $delete = $conn->prepare("DELETE FROM post_likes WHERE post_id = ? AND user_ip = ?");
    $delete->bind_param('is', $post_id, $user_ip);
    $delete->execute();
    $delete->close();

    // Decrease like count in posts
    $conn->query("UPDATE posts SET likes = GREATEST(likes - 1, 0) WHERE id = $post_id");

    $status = 'unliked';
} else {
    // LIKE the post
    $insert = $conn->prepare("INSERT INTO post_likes (post_id, user_ip) VALUES (?, ?)");
    $insert->bind_param('is', $post_id, $user_ip);
    $insert->execute();
    $insert->close();

    $conn->query("UPDATE posts SET likes = likes + 1 WHERE id = $post_id");

    $status = 'liked';
}
$check->close();

// Fetch updated like count
$result = $conn->query("SELECT likes FROM posts WHERE id = $post_id");
$row = $result->fetch_assoc();

echo json_encode([
    'success' => true,
    'status' => $status,
    'likes' => (int)$row['likes']
]);
