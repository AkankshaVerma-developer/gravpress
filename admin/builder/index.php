<?php
session_start();
require_once __DIR__ . '/../../connection/db.php'; 

// simple auth-check 
if (!isset($_SESSION['user_id'])) {
    // for local testing set a default
    $_SESSION['user_id'] = 1;
}
$user_id = intval($_SESSION['user_id']);

$website_id = isset($_GET['website_id']) ? intval($_GET['website_id']) : 0;
if ($website_id <= 0) {
   
}

// load website title 
$website_title = "Building own Website";
if ($website_id) {
    $stmt = $conn->prepare("SELECT title FROM websites WHERE website_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $website_id, $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows) {
        $row = $res->fetch_assoc();
        $website_title = $row['title'];
    }
    $stmt->close();
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8"/>
  <title>Website Builder — <?=htmlspecialchars($website_title)?></title>

  <!-- GrapesJS core CSS -->
  <link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet"/>
  <!-- optional preset stylesheet (we rely on plugin via CDN in JS) -->

  <!-- Our builder styles -->
  <link href="assets/css/builder.css" rel="stylesheet"/>
  <style> /* small page-level fixes */ body, html { height:100%; margin:0; } </style></head>
<body>

<!-- Top toolbar -->
<div class="gp-topbar">
  <!-- <div class="gp-left">
    <button id="addPageBtn" class="gp-btn">+ New Page</button>
    <select id="pagesSelect" class="gp-select">page</select>
    <button id="renamePageBtn" class="gp-btn">Rename</button>
  </div> -->
  

  <div class="gp-center"> 
    <strong><?=htmlspecialchars($website_title)?></strong>
  </div>

  <div class="gp-right">
    <div id="editorPreview" style="transform-origin: top left;">
    <button id="zoomOut" class="gp-btn">-</button>
    <span id="zoomVal">100%</span>
    <button id="zoomIn" class="gp-btn">+</button>
 </div>

    <!-- <button id="previewBtn" class="gp-btn">Preview</button> -->
    <a href="../saved_site.php" id="savePageBtn" class="gp-btn gp-primary">Save</a>
    <button id="publishBtn" class="gp-btn">Publish</button>
    <a href="../dashboard.php" class="gp-btn">Back</a>
  </div>
</div>

<!-- Main layout: left sidebar, canvas area, right inspector -->
<div class="gp-wrap">

  <!-- LEFT: Blocks + Search -->
  <aside class="gp-leftpanel">
    <div class="gp-search">
      <input id="blockSearch" placeholder="Search elements or sections..." />
    </div>

    <div class="gp-tabs">
      <button class="gp-tab active" data-tab="blocks">Elements</button>
      <button class="gp-tab active" data-tab="sections">Sections</button>
      <!-- <button class="gp-tab active" data-tab="assets">Assets</button> -->
    </div>

    <div class="gp-panel" id="blocksPanel">
      <div id="gjs-blocks" class="gjs-blocks-c"></div>
    </div>

    <div class="gp-panel hidden" id="sectionsPanel">
      <div id="gjs-sections"></div>
    </div>

    <div class="gp-panel hidden" id="assetsPanel">
      <div id="gjs-assets"></div>
    </div>
  </aside>

  <!-- CENTER: Canvas with fixed sheet like Canva -->
  <main class="gp-canvas-area">
    <div class="gp-canvas-toolbar">
      <!-- <span>Device:</span>
      <select id="deviceSelect">
        <option value="Desktop">Desktop</option>
        <option value="Tablet">Tablet</option>
        <option value="Mobile">Mobile</option>
      </select> -->
      <!-- <button id="addSectionBtn" class="gp-btn">+ Add section</button> -->
       <button id="addSectionBtn" class="gp-btn">+ Add Page</button>

      <button id="clearCanvasBtn" class="gp-btn">Clear</button>
    </div>

    <div id="gjs" class="gp-canvas"></div>
  </main>

  <!-- RIGHT -->
  <!-- <aside class="gp-rightpanel" id="gpInspector">
    <h4>Inspector</h4>
    <div id="inspectorInner">
      <p class="muted">Select an element to edit properties (style, attributes)</p>
    </div>
  </aside> -->

</div>

<!-- GrapesJS and plugins -->
<script src="https://unpkg.com/grapesjs"></script>
<script src="https://unpkg.com/grapesjs-preset-webpage"></script>

<!-- Our builder JS -->
<script>const WEBSITE_ID = <?=json_encode($website_id)?>;</script>
<script src="assets/js/builder.js"></script>
</body>
</html>
