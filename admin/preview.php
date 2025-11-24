<?php
session_start();
require_once "../connection/db.php";

$theme = isset($_GET['theme']) ? preg_replace('/[^a-z0-9_\-]/i','', $_GET['theme']) : null;
if (!$theme) {
    echo "Theme not specified";
    exit;
}

// assume themes are located under ../user/themes/<slug>/home.php
$path = "../user/view/theme/{$theme}/home.php";

if (!file_exists($path)) {
    echo "Theme preview not available.";
    exit;
}

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Preview - <?php echo htmlspecialchars($theme); ?></title>
  <link rel="stylesheet" href="sidebar.css">
  <style>body,html{height:100%;margin:0}.frame{height:100vh;border:0;width:100%}</style>
</head>
<body>
  <div class="main">
   <!-- <h3>Preview —  <php // echo htmlspecialchars($theme); ?> -->
     <iframe class="frame" src="../user/view/theme/<?php echo rawurlencode($theme); ?>/home.php"></iframe>

  </div>
</body>
</html>
