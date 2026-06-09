<?php
require_once '../partials/db.php';
include 'inc/header.php';
include 'inc/sidebar.php';

$message = '';

// 1. Get post ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid post ID";
    exit;
}
$post_id = (int)$_GET['id'];

// 2. Fetch the post data
$post_res = $conn->query("SELECT * FROM posts WHERE id=$post_id");
if ($post_res->num_rows == 0) {
    echo "Post not found";
    exit;
}
$post = $post_res->fetch_assoc();

// 3. Fetch categories
$cat_res = $conn->query("SELECT * FROM categories");

// 4. Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $category_id = (int)$_POST['category_id'];

    if (!empty($title) && !empty($content) && $category_id > 0) {
        $sql = "UPDATE posts SET title='$title', content='$content', category_id=$category_id WHERE id=$post_id";
       
   if ($conn->query($sql)) {
    // Redirect instead of just showing message
    header("Location: posts.php?message=Post updated successfully");
    exit;
}

        } else {
            $message = "Error updating post: " . $conn->error;
        }
    } else {
        $message = "All fields are required";
    }

?>


<main class="main-content">
  <h2>Edit Post</h2>
  <?php if($message) echo "<p>$message</p>"; ?>
  <form method="post">
    <div>
      <label>Title</label>
      <input type="text" name="title" value="<?=htmlspecialchars($post['title'])?>" required>
    </div>
    <div>
      <label>Content</label>
      <textarea name="content" required><?=htmlspecialchars($post['content'])?></textarea>
    </div>
    <div>
      <label>Category</label>
      <select name="category_id" required>
        <option value="">Select Category</option>
        <?php
        // Reset pointer if needed
        $cat_res->data_seek(0);
        while($c = $cat_res->fetch_assoc()): ?>
          <option value="<?=$c['id']?>" <?=($c['id']==$post['category_id'])?'selected':''?>><?=htmlspecialchars($c['name'])?></option>
        <?php endwhile; ?>
      </select>
    </div>
    
   <!-- submit button -->
   <button type="submit" class="buttons">Update</button>
  </form>

</main>

