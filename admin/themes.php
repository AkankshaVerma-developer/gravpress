<?php
session_start();
require_once "../connection/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];

// fetch all themes
$stmt = $conn->prepare("SELECT id, slug, name, thumbnail FROM themes ORDER BY name");
$stmt->execute();
$res = $stmt->get_result();
$themes = $res->fetch_all(MYSQLI_ASSOC);
$res = $conn->query("SELECT theme_slug FROM active_theme WHERE user_id=$user_id");
$row = $res->fetch_assoc();
$theme = $row ? $row['theme_slug'] : "light";
// get active theme for this user
$stmt2 = $conn->prepare("SELECT theme_slug FROM active_theme WHERE user_id = ?");
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$r2 = $stmt2->get_result()->fetch_assoc();
$active = $r2 ? $r2['theme_slug'] : null;
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Themes - GravPress</title>
  <link rel="stylesheet" href="sidebar.css">
  <link rel="stylesheet" href="themes.css">
</head>
<body>
  <h2>Activated Theme: <?php echo ucfirst($theme); ?></h2>

<a href="preview.php?theme=<?php echo $theme; ?>" class="btn">Preview Theme</a>
<a href="preview_editor.php?theme=<?php echo $theme; ?>" class="btn">Edit Theme</a>

  <div class="main">
    <h1>Themes</h1>
    <div class="grid">
      <?php foreach ($themes as $t): ?>
        <div class="card">
          <img src="<?php echo htmlspecialchars($t['thumbnail']); ?>" alt="" class="thumb">
          <h3><?php echo htmlspecialchars($t['name']); ?></h3>
          <div class="meta"><?php echo htmlspecialchars($t['slug']); ?></div>
          <div class="actions">
            <?php if ($active === $t['slug']): ?>
              <span class="badge">Active</span>
            <?php else: ?>
              <form method="post" action="activate_theme.php" class="form">
                <input type="hidden" name="theme_slug" value="<?php echo htmlspecialchars($t['slug']); ?>">
                <button type="submit" class="btn" name="activate">Activate</button>
              </form>
            <?php endif; ?>

            <a class="btn" href="preview.php?theme=<?php echo urlencode($t['slug']); ?>" target="_blank">Preview</a>
            <a class="btn" href="preview_editor.php?theme=<?php echo urlencode($t['slug']); ?>">Edit</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>
