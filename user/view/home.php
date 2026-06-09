<?php

include "header.php";
// require hooks first
// require_once __DIR__ . '/core/plugins/hooks.php';

// require loader (which uses hooks)
// require_once __DIR__ . '/core/plugins/loader.php';

// optional: require manager if you have functions there (step 3)
// require_once __DIR__ . '/core/plugins/manager.php';

// Run loader to include active plugins (adjust paths if needed)
// gp_load_active_plugins(
//     __DIR__ . '/plugins',            // plugins dir
//     __DIR__ . '/data/active_plugins.json'  // active JSON
// );

// Now call init action so plugins get their init hooks called
// do_action('init');

// rest of bootstrap...
// e.g. $app = new App(); route, render, etc.
?>
<html>
    <head>
        <link rel="stylesheet" href="../css/home.css">
</head>
<body>
<main class="site-main">
  <section class="hero">
    <div class="hero-inner">
      <h1 class="site-title">
        Welcome to <span class="brand">GravPress</span>
      </h1>
      <p class="lead">Lightweight custom CMS — modular, plugin-ready, and easy to extend</p>
      <div class="hero-cta">
        <a href="#features" class="btn btn-primary">Explore features</a>
      </div>
      <div class="headline-scroller" aria-hidden="true">
        <div class="scroll-track">
          <span>Modular • Themes • Plugins  • Media Library • SEO-friendly</span>
          <span>Modular • Themes • Plugins  • Media Library • SEO-friendly</span>
        </div>
      </div>
    </div>
  </section>

  <section id="features" class="cards-section">
    <div class="container">
      <h2 class="section-heading">Featured Modules</h2><br>
      <p class="section-sub">Core features and sample modules (click to read)</p><br>

      <div class="cards-grid">
        <!-- Card 1 -->
        <article class="card">
          <figure class="card-media">
            <img src="../images/theme_logo.png" alt="Themes">
          </figure>
          <div class="card-body">
            <h3 class="card-title">Themes</h3>
            <p class="card-desc">Switchable theme system with simple template loader — create a theme in the themes folder.</p>
           <a class="card-link" href="gravtheme.php">View themes →</a>

          </div>
        </article>
  <!-- Card 2 -->
        <article class="card">
          <figure class="card-media">
            <img src="../images/media_logo.jpg" alt="Media Library">
          </figure>
          <div class="card-body">
            <h3 class="card-title">Media Library</h3>
            <p class="card-desc">Upload images and attachments; serve optimized thumbnails to pages and cards.</p>
            <a class="card-link" href="../../admin/media.php">Media →</a>
          </div>
        </article>
        <!-- Card 3 -->
        <article class="card">
          <figure class="card-media">
            <img src="../images/plugin_logo.png" alt="Plugins">
          </figure>
          <div class="card-body">
            <h3 class="card-title">Plugin System</h3>
            <p class="card-desc">Drop plugins into plugin-loader will include their files</p>
            <a class="card-link" href="gravplugin.php">Plugin API →</a>
          </div>
        </article>


      </div>
    </div>
  </section>

  <section class="callout">
    <div class="container">
      <h3>Want this CMS for your company ?</h3>
      <p>We can connect a custom admin, plugin manager and theme builder based on the design </p>
      <a href="../../admin/login.php" class="btn btn-primary">Open Admin</a>
    </div>
  </section>
</main>
</body>
</html>
<?php
require_once 'footer.php';
