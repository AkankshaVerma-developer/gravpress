<?php require_once __DIR__ . '/partials/db.php';?>

<?php include 'partials/header.php'; ?>
<div class="bubble-bg">
  <span></span>
  <span></span>
  <span></span>
  <span></span>
  <span></span>
  <span></span>
  <span></span>
  <span></span>
  <span></span>
  <span></span>
</div>
<div class="container mt-5">
  <div class="row">

    <!-- Main Blog Section -->
    <div class="col-lg-8 col-md-12 mb-4">
      <h2 class="mb-4 text-primary fw-bold">Latest Blog Posts</h2>
<?php
$sql = "SELECT p.id, p.title, p.content, p.image, p.meta_title, p.likes, p.created_at, c.name AS category 
        FROM posts p 
        LEFT JOIN categories c ON p.category_id = c.id 
        ORDER BY p.created_at DESC";

$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="card mb-4 blog-card shadow-sm">
            <img src="images/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top blog-img" alt="<?php echo htmlspecialchars($row['title']); ?>">

            <div class="card-body">
                <h4 class="card-title text-dark"><?php echo htmlspecialchars($row['title']); ?></h4>
                <p class="card-text text-secondary"><?php echo htmlspecialchars(substr($row['meta_title'], 0, 120)); ?>...</p>
                
                <a href="single_post.php?id=<?php echo $row['id']; ?>" class="btn btn-readmore">Read More</a>
                
                <!-- Like Button -->
                <button class="btn btn-like float-end" data-id="<?php echo $row['id']; ?>">
                    <i class="fa fa-heart"></i> Like (<span class="like-count"><?php echo $row['likes']; ?></span>)
                </button>
                <!-- Short Comments Preview -->
        <div class="post-comments mt-2">
             <?php
          $comments_res = mysqli_query($conn, "SELECT comment FROM comments WHERE post_id = {$row['id']} ORDER BY created_at ");
       if ($comments_res && mysqli_num_rows($comments_res) > 0) {
    while ($c = mysqli_fetch_assoc($comments_res)) {
         echo 'comments:<p class="small text-secondary mb-1">' . htmlspecialchars(substr($c['comment'], 0, 60)) . '</p>';

    }
     } else {
    echo '<p class="small text-muted">No comments yet.</p>';
}
?>
</div>
  </div>
     <div class="card-footer text-muted">📅 <?php echo date("F j, Y", strtotime($row['created_at'])); ?></div> </div>
        <?php
    }
} else {
    echo "<p class='text-center text-muted mt-4'>No posts available.</p>";
}
?>

    </div>

    <!-- Sidebar Section -->
    <div class="col-lg-4 col-md-12">
      <div class="sidebar sticky-top" style="top: 80px;">
    

        <!-- Recent Posts Card -->
        <div class="card mb-4">
          <div class="card-header bg-primary text-white">Recent Posts</div>
          <ul class="list-group list-group-flush">
            <?php
            $recent = mysqli_query($conn, "SELECT id, title FROM posts ORDER BY created_at DESC LIMIT 5");
            while ($r = mysqli_fetch_assoc($recent)) {
                echo '<li class="list-group-item"><a href="single_post.php?id=' . $r['id'] . '">' . htmlspecialchars($r['title']) . '</a></li>';
            }
            ?>
          </ul>
        </div>

        <!-- Categories Card -->
        <div class="card mb-4">
          <div class="card-header bg-success text-white">Categories</div>
          <ul class="list-group list-group-flush">
            <?php
            $cat = mysqli_query($conn, "SELECT id, name FROM categories");
            while ($c = mysqli_fetch_assoc($cat)) {
                echo '<li class="list-group-item"><a href="search.php?id=' . $c['id'] . '">' . htmlspecialchars($c['name']) . '</a></li>';
            }
            ?>
          </ul>
        </div>

        <!-- Comments Card -->
        <div class="cab">
          <div class="card-header bg-info text-white">What you Get Here</div>
          <div class="card-body">
            <p class="text-secondary">"Great post on digital marketing!"</p>
            <p class="text-secondary">"Latest blogs"</p>
            <p class="text-secondary">"Good ideas and content"</p>
             <p class="text-secondary">"Up to date with time"</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.btn-like').forEach(function(btn) {
    btn.addEventListener('click', function() {
      const postId = this.getAttribute('data-id');
      const likeCountSpan = this.querySelector('.like-count');
      const isLiked = this.classList.contains('liked');

      fetch('update_likes.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + encodeURIComponent(postId)
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          likeCountSpan.textContent = data.likes;
          if (data.status === 'liked') {
            btn.classList.add('liked');
            btn.innerHTML = `<i class="fa fa-heart text-danger"></i> Liked (<span class="like-count">${data.likes}</span>)`;
          } else {
            btn.classList.remove('liked');
            btn.innerHTML = `<i class="fa fa-heart"></i> Like (<span class="like-count">${data.likes}</span>)`;
          }
        }
      })
      .catch(err => console.error(err));
    });
  });
});
</script>


<?php include 'partials/footer.php'; ?>
