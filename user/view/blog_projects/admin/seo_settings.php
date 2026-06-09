<?php
require_once '../partials/db.php';
include 'inc/header.php';
include 'inc/sidebar.php';

$err = $success = '';

// When form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $site_name = trim($_POST['site_name']);
    $site_description = trim($_POST['site_description']);
    $site_keywords = trim($_POST['site_keywords']);

    if ($site_name && $site_description && $site_keywords) {
        $stmt = $conn->prepare("UPDATE seo_settings SET site_name=?, site_description=?, site_keywords=? WHERE id=1");
        $stmt->bind_param('sss', $site_name, $site_description, $site_keywords);
        $stmt->execute();
        $stmt->close();

        $success = "Settings saved successfully!";
    } else {
        $err = "All fields are required!";
    }
}

// Fetch current settings
$settings = $conn->query("SELECT * FROM seo_settings WHERE id=1")->fetch_assoc();
?>
<main class="main-content">
  <h2>SEO & Site Settings</h2>
  <?php if($err): ?><div class="alert alert-danger"><?=$err?></div><?php endif; ?>
  <?php if($success): ?><div class="alert alert-success"><?=$success?></div><?php endif; ?>

  <form method="POST">
      <div class="mb-3">
          <label>Site Name</label>
          <input type="text" name="site_name" class="form-control" 
                 value="<?=htmlspecialchars($settings['site_name'])?>" required>
      </div>
      <div class="mb-3">
          <label>Site Description</label>
          <input type="text" name="site_description" class="form-control"
                 value="<?=htmlspecialchars($settings['site_description'])?>" required>
      </div>
      <div class="mb-3">
          <label>Site Keywords</label>
          <input type="text" name="site_keywords" class="form-control"
                 value="<?=htmlspecialchars($settings['site_keywords'])?>" required>
      </div>

      <button type="submit" class="buttons" onclick="window.location.href='posts.php'"> Update</button>

  </form>
</main>


