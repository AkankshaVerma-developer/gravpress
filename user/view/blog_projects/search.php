<?php
include 'partials/header.php';
require_once 'partials/db.php';

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $query = "SELECT * FROM posts WHERE title LIKE '%$search%' OR content LIKE '%$search%' ORDER BY created_at DESC";
    $result = mysqli_query($conn, $query);
} else {
    header('Location: blog.php');
    exit;
}
?>

<section class="posts">
  <div class="container posts__container">
    <h2>Search Results for "<?= htmlspecialchars($search) ?>"</h2>

    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <?php while ($post = mysqli_fetch_assoc($result)): ?>
        <article class="post">
            <div class="post__thumbnail">
                <img src="./images/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
            </div>
            <div class="post__info">
                <h3><a href="single_post.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a></h3>
                <p><?= substr(strip_tags($post['content']), 0, 120) ?>...</p>
            </div>
        </article>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center; font-weight:600;">No posts found matching your search: "<?= htmlspecialchars($search) ?>"</p>
    <?php endif; ?>
  </div>
</section>

<?php include 'partials/footer.php'; ?>
