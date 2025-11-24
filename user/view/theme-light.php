<?php
require_once '../../connection/db.php'; // DB connection file
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Light Theme Preview - GravPress</title>
  <link rel="stylesheet" href="../css/theme-light.css">
</head>
<body>

<!--  MAIN GRAVPRESS HEADER -->
<header class="gp-header">
  <div class="gp-container">
    <div class="gp-logo">GravPress</div>
    <nav class="gp-nav">
      <a href="home.php">Home</a>
      <a href="gravtheme.php" class="active">Themes</a>
    <a href="activate.php?theme=theme-light" class="btn">Activate Theme</a>
      <a href="#">Support</a>
    </nav>
  </div>
</header>

<!--  THEME LIGHT PREVIEW SECTION -->
<section class="theme-wrapper">
  
  <!-- THEME HEADER -->
  <header class="light-header">
    <div class="light-container">
      <h1 class="light-logo">✨ Light Theme</h1>
      <nav class="light-nav">
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Services</a>
        <a href="#">Contact</a>
      </nav>
    </div>
  </header>

  <!-- THEME HERO -->
  <section class="light-hero">
    <div class="hero-inner">
      <h2>Modern. Clean. Bright.</h2>
      <p>Create a visually stunning website with our light & minimal theme.</p>
      <a href="#" class="btn-primary">Get Started</a>
    </div>
  </section>

  <!-- THEME FEATURES -->
  <section class="light-features">
    <h2>Highlights</h2>
    <div class="features-grid">
      <div class="feature">
        <img src="../images/picture.png" alt="">
        <h3>Clean UI</h3>
        <p>Minimal and bright elements with soft shadow depth.</p>
      </div>
      <div class="feature">
        <img src="../images/picture.png" alt="">
        <h3>Fast Load</h3>
        <p>Optimized structure ensures high performance and speed.</p>
      </div>
      <div class="feature">
        <img src="../images/picture.png" alt="">
        <h3>Fully Customizable</h3>
        <p>Adjust layout, colors, and fonts to fit your brand perfectly.</p>
      </div>
    </div>
  </section>

  <!-- THEME PORTFOLIO SECTION -->
  <section class="light-showcase">
    <h2>My Pages</h2>
    <div class="showcase-grid">
      <div class="showcase-card">
        <img class= "masks" src="../images/community.png" alt="img">
        <h4>Project Page</h4>
      </div>
      <div class="showcase-card">
        <img class ="masks"  src="../images/community.png" alt="img">
        <h4>Self Intro Page</h4>
      </div>
      <div class="showcase-card">
        <img class="masks" src="../images/community.png" alt="img">
        <h4>Portfolio Page</h4>
      </div>
    </div>
  </section>

  <!-- THEME FOOTER -->
  <footer class="light-footer">
    <div class="footer-inner">
      <p>© 2025 Light Theme | Built on GravPress</p>
    </div>
  </footer>

</section>

</body>
</html>
