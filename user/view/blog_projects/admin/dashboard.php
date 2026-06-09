<?php 
require_once '../partials/db.php';
include 'inc/header.php';
session_start();
// If admin not logged in, redirect to login page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
   header('Location: login.php'); 
  exit();
}
?>

<main class="main-content">
  <h2 class="page-title fade-in">Dashboard Overview</h2>

  <?php
  // Fetch real counts
  $total_posts = $conn->query("SELECT COUNT(*) AS total FROM posts")->fetch_assoc()['total'];
  $total_categories = $conn->query("SELECT COUNT(*) AS total FROM categories")->fetch_assoc()['total'];
  $total_comments = $conn->query("SELECT COUNT(*) AS total FROM comments")->fetch_assoc()['total'];
  ?>

  <div class="widgets">
    <div class="widget fade-in delay-1">
      <h3>Total Posts</h3>
      <p><?php echo $total_posts; ?></p>
    </div>
    <div class="widget fade-in delay-2">
      <h3>Total Categories</h3>
      <p><?php echo $total_categories; ?></p>
    </div>
    <div class="widget fade-in delay-3">
      <h3>Total Comments</h3>
      <p><?php echo $total_comments; ?></p>
    </div>
  </div>
</main>

