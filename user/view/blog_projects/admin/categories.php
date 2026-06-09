<?php
require_once '../partials/db.php';
include 'inc/header.php';
include 'inc/sidebar.php';

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = trim($_POST['name']);
    if ($name !== '') {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $stmt->close();
        header('Location: categories.php');
        exit;
    } else $err = 'Category name required';
}

// delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param('i', $id); $stmt->execute(); $stmt->close();
    header('Location: categories.php'); exit;
}

$cats = $conn->query("SELECT * FROM categories ORDER BY name ASC");
?>
<main class="main-content">
  <h2>Categories</h2>
  <div class="row">
    <div class="col-md-6">
      <div class="card p-3">
        <h5>Add Category</h5>
        <?php if($err): ?><div class="alert alert-danger"><?=htmlspecialchars($err)?></div><?php endif; ?>
        <form method="POST">
          <input type="text" name="name" class="form-control mb-2" placeholder="Category name">
          <button class="btn btn-primary">Add</button>
        </form>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card p-3">
        <h5>Existing</h5>
        <ul class="list-group">
        <?php while($c = $cats->fetch_assoc()): ?>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <?=htmlspecialchars($c['name'])?>
            <a href="?delete=<?=$c['id']?>" class="btn btn-sm btn-danger">Delete</a>
          </li>
        <?php endwhile; ?>
        </ul>
      </div>
    </div>
  </div>
</main>

