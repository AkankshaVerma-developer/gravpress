<?php
require_once __DIR__ . '/inc/db.php';
include __DIR__ . '/inc/header.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();
?>

<main class="container single-post">
  <?php if ($post): ?>
    <article>
      <header class="single-header">
        <h1><?= htmlspecialchars($post['title']) ?></h1>
        <p class="meta"><?= date('F j, Y', strtotime($post['created_at'])) ?></p>
      </header>
      <figure class="hero-image">
        <img src="<?= $post['image'] ?>" alt="<?= htmlspecialchars($post['title']) ?>">
      </figure>
      <div class="content">
        <?= $post['content'] ?>
      </div>
    </article>
  <?php else: ?>
    <h2>Post not found</h2>
  <?php endif; ?>
</main>

<?php include __DIR__ . '/inc/footer.php'; ?>
