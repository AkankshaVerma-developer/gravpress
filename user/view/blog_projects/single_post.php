<?php include 'partials/db.php'; 
include 'partials/header.php';

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    echo "<p class='text-center mt-5'>Invalid Post ID.</p>";
    exit;
}

$post_id = (int)$_GET['id'];

// Fetch post
$sql = "SELECT p.id, p.title, p.content, p.image, p.meta_description, p.created_at, p.author, p.category_id, c.name AS category_name, p.likes
        FROM posts p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.id = ?";

$stmt = $conn->prepare($sql);
if(!$stmt){ die("Prepare failed: (" . $conn->errno . ") " . $conn->error); }
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

$post = $result->fetch_assoc();
//HANDle comments
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])){
    $user_name = htmlspecialchars($_POST['user_name']);
    $user_email = htmlspecialchars($_POST['user_email']);
    $comment = htmlspecialchars($_POST['comment']);

    $sql_comment = "INSERT INTO comments (post_id, user_name, user_email, comment, created_at) VALUES (?, ?, ?, ?, NOW())";
    $stmt_c = $conn->prepare($sql_comment);

    if(!$stmt_c) { die("Prepare failed: (" . $conn->errno . ") " . $conn->error); }

    $stmt_c->bind_param("isss", $post_id, $user_name, $user_email, $comment);
    $stmt_c->execute();
    $stmt_c->close();

    // Redirect back to the same post
    header("Location: single_post.php?id=$post_id#comments");
    exit;
}
// Fetch comments (latest 5 for preview)
$comments = $conn->query("SELECT * FROM comments WHERE post_id = $post_id ORDER BY created_at DESC");
//fetch related post
$related = $conn->query("SELECT id, title, image FROM posts WHERE category_id = ".$post['category_id']." AND id != $post_id ORDER BY created_at DESC LIMIT 5");
if(!$related) { $related = []; } // prevent fatal error


// Handle Likes
if(isset($_GET['like'])){
    $conn->query("UPDATE posts SET likes = likes + 1 WHERE id = $post_id");
    $post['likes']++;
}
?>
<!-- Floating Bubbles Background -->

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
    <!-- Main Content -->
    <div class="col-lg-8 col-md-12">
      <div class="single-post card mb-4 shadow-sm">
        <img src="images/<?php echo $post['image']; ?>" class="card-img-top post-img" alt="<?php echo htmlspecialchars($post['title']); ?>">
        <div class="card-body">
          <h1 class="post-title mb-3"><?php echo htmlspecialchars($post['title']); ?></h1>
          <p class="text-muted"><?php echo htmlspecialchars($post['meta_description']); ?></p>
          <div class="post-meta mb-3">
            📅 <?php echo date("F j, Y", strtotime($post['created_at'])); ?> |
            ✍ <?php echo htmlspecialchars($post['author']); ?> |
            💬 <?php echo $comments->num_rows; ?> Comments
          </div>
      
 <div class="post-content">
 <?php echo strip_tags(html_entity_decode(stripslashes($post['content'])), '<a><p><b><i><br><strong><em><ul><ol><li><h1><h2><h3>');?>
</div>

         </div>

<!-- Like Button (AJAX, no page reload) -->
<button type="button" class="btn btn-like mb-3" id="likeBtn" data-id="<?php echo $post_id; ?>">
  <i class="fa fa-heart"></i> Like (<span id="likeCount"><?php echo $post['likes']; ?></span>)
</button>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const likeBtn = document.getElementById('likeBtn');
  if (!likeBtn) return;

  likeBtn.addEventListener('click', function() {
    const postId = this.getAttribute('data-id');
    const likeCountSpan = document.getElementById('likeCount');

    fetch('update_likes.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'id=' + encodeURIComponent(postId)
    })
    .then(res => res.json())
    .then(data => {
      if (data && data.success) {
        likeCountSpan.textContent = data.likes;
        likeBtn.classList.add('liked');
      } else {
        console.error('Like update failed', data);
      }
    })
    .catch(err => console.error('Error:', err));
  });
});
</script>

          <!-- Social Share -->
          <div class="social-share mb-4">
            <span class="share">Share:</span>
            <a href="http://www.facebook.com/sharer.php?" target=" _blank" class="btn btn-sm btn-facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="http://twitter.com/share?text=<TITLE>&url=<URL>" target=" _blank" class="btn btn-sm btn-twitter"><i class="fab fa-twitter"></i></a>
            <a href="https://www.linkedin.com/shareArticle?" target=" _blank" class="btn btn-sm btn-linkedin"><i class="fab fa-linkedin-in"></i></a>
            <a href="https://api.whatsapp.com/send?" target="_blank" class="btn-share whatsapp"> <i class="fab fa-whatsapp"></i></a>
          </div>

          <!-- Comments Preview -->
          <h4 class="mt-5 mb-3" id="comments">Comments (<?php echo $comments->num_rows; ?>)</h4>
          <div class="comments mb-4">
            <?php
            $comment_preview = $comments->fetch_all(MYSQLI_ASSOC);
            foreach($comment_preview as $c):
            ?>
              <div class="comment p-3 mb-2 shadow-sm rounded">
                <strong>Name : <?php echo htmlspecialchars($c['user_name']); ?></strong> 
                <strong>Email : <?php echo htmlspecialchars($c['user_email']); ?></strong>
                <span class="text-muted">- <?php echo date("F j, Y", strtotime($c['created_at'])); ?></span>
                <p><?php echo htmlspecialchars($c['comment']); ?></p>
              </div>
            <?php endforeach; ?>
          </div>

          <!-- Add Comment Form -->
          <div class="comment-form-card mb-5 shadow-sm">
    <h5>Add a Comment</h5>
    <form method="POST" action="">
        <div class="mb-3">
            <input type="text" class="form-control" name="user_name" placeholder="Your Name" required>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" name="user_email" placeholder="Your Email" required>
        </div>
        <div class="mb-3">
            <textarea class="form-control" name="comment" rows="3" placeholder="Your Comment" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Comment</button>
    </form>
</div>

        </div>
      </div>
    </div>

   
          
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'partials/footer.php'; ?>
