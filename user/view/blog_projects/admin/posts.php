<?php
require_once '../partials/db.php';
include 'inc/header.php';
include 'inc/sidebar.php';

$res = $conn->query("SELECT p.*, c.name AS category FROM posts p LEFT JOIN categories c ON p.category_id=c.id ORDER BY p.created_at DESC");
?>
<main class="main-content post-page">
  <div id="wave-container"></div>

  <section class="post-header">
    <h2>All Blog Posts</h2>
    <a class="btn-add" href="add_post.php">Add New Post</a>
  </section>

  <section class="post-list">
    <?php while($p = $res->fetch_assoc()): ?>
      <div class="post-card">
        <div class="post-info">
          <h3><?=htmlspecialchars($p['title'])?></h3>
          <p class="category"><span>Category:</span> <?=htmlspecialchars($p['category'])?></p>
          <p class="date">📅 <?=date("Y-m-d", strtotime($p['created_at']))?></p>
          <p class="likes">💚 <?=intval($p['likes'])?> Likes</p>
        </div>
        <div class="post-actions">
          <a class="btn btn-edit" href="edit_post.php?id=<?=$p['id']?>">Edit</a>
          <a class="btn btn-delete" href="delete.php?id=<?=$p['id']?>" onclick="return confirm('Delete?')">Delete</a>
          <a class="btn btn-view" href="../single_post.php?id=<?=$p['id']?>" target="_blank">View</a>
        </div>
      </div>
    <?php endwhile; ?>
  </section>
</main>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const canvas = document.createElement("canvas");
  canvas.id = "wave";
  document.getElementById("wave-container").appendChild(canvas);

  const ctx = canvas.getContext("2d");
  let width, height, dots = [], waveHeight = 25, dotCountX = 60, dotCountY = 10;

  function resize() {
    width = canvas.width = document.getElementById("wave-container").offsetWidth;
    height = canvas.height = document.getElementById("wave-container").offsetHeight;
    dots = [];

    for (let y = 0; y < dotCountY; y++) {
      for (let x = 0; x < dotCountX; x++) {
        dots.push({
          x: (x / (dotCountX - 1)) * width,
          y: height / 2 + (y - dotCountY / 2) * 20,
          offset: Math.random() * 1000
        });
      }
    }
  }

  function animate(time) {
    ctx.clearRect(0, 0, width, height);
    ctx.fillStyle = "#0022ffff"; 

    dots.forEach((dot) => {
      const wave = Math.sin((dot.x / 80) + (time / 700) + dot.offset) * waveHeight;
      const y = dot.y + wave;
      ctx.beginPath();
      ctx.arc(dot.x, y, 2.2, 0, Math.PI * 2);
      ctx.fill();
    });

    requestAnimationFrame(animate);
  }

  window.addEventListener("resize", resize);
  resize();
  animate(0);
});
</script>

