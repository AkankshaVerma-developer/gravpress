<?php
require_once '../partials/db.php';
include 'inc/header.php';
include 'inc/sidebar.php';

// Handle Approve, Reject, Delete
if (isset($_GET['action']) && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    $action = $_GET['action'];

    if ($action === 'approve') {
        $stmt = $conn->prepare("UPDATE comments SET status='approved' WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'reject') {
        $stmt = $conn->prepare("UPDATE comments SET status='rejected' WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM comments WHERE id=?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    header('Location: comments.php');
    exit;
}

// Fetch all comments with post title
$res = $conn->query("
    SELECT c.id, c.user_name, c.user_email, c.comment, c.status, p.title AS post_id, c.created_at
    FROM comments c 
    LEFT JOIN posts p ON c.post_id = p.id
    ORDER BY c.created_at DESC
");

// Check if query succeeded
if (!$res) {
    die("Database query failed: " . $conn->error);
}

?>
<main class="main-content">
  <h2>Comments</h2>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Comment</th>
          <th>Post</th>
          <th>Status</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
     <?php if($res && $res->num_rows > 0): ?>
    <?php while($c = $res->fetch_assoc()): ?>
        <tr>
          <td><?=htmlspecialchars($c['user_name'])?></td>
          <td><?=htmlspecialchars($c['user_email'])?></td>
          <td><?=htmlspecialchars($c['comment'])?></td>
          <td><?=htmlspecialchars($c['post_id'])?></td>
          <td>
            <?php if($c['status']=='approved'): ?>
                <span class="badge badge-approved">Approved</span>
            <?php elseif($c['status']=='rejected'): ?>
                <span class="badge badge-rejected">Rejected</span>
            <?php else: ?>
                <span class="badge badge-pending">Pending</span>
            <?php endif; ?>
          </td>
          <td><?=date("Y-m-d H:i", strtotime($c['created_at']))?></td>
         <td>
    <div class="action-buttons">
        <a href="?action=approve&id=<?=$c['id']?>" class="btn btn-sm btn-success">Approve</a>
        <a href="?action=reject&id=<?=$c['id']?>" class="btn btn-sm btn-warning">Reject</a>
        <a href="?action=delete&id=<?=$c['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this comment?')">Delete</a>
    </div>
</td>

        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr><td colspan="7" style="text-align:center;">No comments found</td></tr>
<?php endif; ?>

      </tbody>
    </table>
  </div>
</main>

