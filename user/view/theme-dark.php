<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GravPress Dark Theme</title>
  <link rel="stylesheet" href="../css/theme-dark.css">
</head>
<body>

  <!-- ===============================
       HEADER (Same as main GravPress)
  ================================== -->
  <header class="gp-header">
  <div class="gp-container">
    <div class="gp-logo">GravPress</div>
    <nav class="gp-nav">
      <a href="home.php">Home</a>
      <a href="gravtheme.php" class="active">Themes</a>
    <a href="activate.php?theme=theme-dark" class="btn">Activate Theme</a>
      <a href="#">Support</a>
    </nav>
  </div>
</header>

  <!-- ===============================
       SUB HEADER
  ================================== -->
  <header class="sub-header">
    <nav class="sub-nav">
      <a href="#">Home</a>
      <a href="#" class="active">Resource</a>
      <a href="#">About</a>
      <a href="#">Blog</a>
       <a href="#">Login</a>

    </nav>
</header>

  <!-- ===============================
       MAIN CONTENT
  ================================== -->
  <main class="main-content">
    <section class="hero">
      <h1>Welcome to the <span>Dark Side</span> of Demo Website</h1>
      <p>Experience the smooth glow and flow of the dark theme universe</p>
      <button class="cta-btn">Explore Now</button>
    </section>
    <section class="info-section">
  <div class="info-content">
    <div class="info-text">
      <h2>Empowering Communities Through GravPress</h2>
      <h3 class="highlight">GravNavigator</h3>
      <p>
        GravPress refreshed GravNavigator’s platform to better connect developers,
        designers, and creators through smart CMS design.
      </p>
      <a href="#" class="learn-btn">Learn more about  →</a>
    </div>

    <div class="info-image">
      <div class="border-frame"></div>
      <img src="../images/community.png" alt="Community image">
    </div>
  </div>
</section>
<section class="intro-section">
  <div class="intro-content">
    <h2>Photograph Section</h2>
    <p>Experience the power of creativity and photography — where imagination meets innovation</p>
  </div>
  <div class="portrait-wrapper">
    <img src="../images/photographer.jpg" alt="3D Portrait" class="portrait-img">
  </div>
</section>

  </main>
<script>
  window.addEventListener('scroll', () => {
    const intro = document.querySelector('.intro-section');
    const rect = intro.getBoundingClientRect();
    const windowHeight = window.innerHeight;

    if (rect.top < windowHeight - 100) {
      intro.classList.add('active');
    } else {
      intro.classList.remove('active');
    }
  });
</script>

  <script>
  // Floating Stars Effect
  const starCount = 40;
  for (let i = 0; i < starCount; i++) {
    const star = document.createElement('div');
    star.className = 'star';
    star.style.left = Math.random() * 100 + '%';
    star.style.top = Math.random() * 100 + '%';
    star.style.animationDelay = Math.random() * 10 + 's';
    document.body.appendChild(star);
  }
  </script>

</body>
</html>
