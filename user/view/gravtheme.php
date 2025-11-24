<?php
include 'header.php';
?>

<link rel="stylesheet" href="../css/gravtheme.css">

<main class="wrap">
  <!-- Decorative rotating bubbles -->
  <div class="bubble b1"></div>
  <div class="bubble b2"></div>
  <div class="bubble b3"></div>

  <!-- Subheader / topic choices -->
  <section class="subhead">
    <h1 class="lead">Choose a Theme</h1>
    <p class="subtxt">Pick a starting point — customize it, or open to preview full page.</p>

    <nav class="choices" aria-label="theme choices">
      <a href="../view/theme/theme-ecommerce/home.php" class="choice">E-Commerce</a>
       <a href="theme-blog.php" class="choice">Blog</a>
       <a href="theme-Portfolio.php" class="choice">Portfolio</a>
       <a href="theme-dark.php" class="choice">Dark</a>
       <a href="theme-light.php" class="choice">Light</a>
       <a href="theme-custom.php" class="choice">custom</a>
      
    </nav>
  </section>

  <!-- Grid of theme cards -->
  <section class="cardwrap">
    <div class="cardgrid">
      <!-- Card: use data-theme to map to full-theme preview page -->
      <article class="card" data-theme="ecommerce" tabindex="0" role="button" aria-pressed="false">
        <div class="cardinner">
          <div class="cardimg"></div>
          <h3 class="title">Ecommerce</h3>
          <p class="meta">Product-focused layout with cart-ready components</p>
          <!-- <a href="../themes/theme-ecommerce/index.php"  class="tag">Shop</a> -->
           <a class="tag">Shop</a>
           
        </div>
      </article>

      <article class="card" data-theme="blog" tabindex="0" role="button" aria-pressed="false">
        <div class="cardinner">
          <div class="cardimg"></div>
          <h3 class="title">Blog</h3>
          <p class="meta">Content-first layout, beautiful typography, writing craze</p>
          <!-- <a href="theme-blog.php" class="tag">Write</a> -->
           <a class="tag">Write</a>
        </div>
      </article>

      <article class="card" data-theme="portfolio" tabindex="0" role="button" aria-pressed="false">
        <div class="cardinner">
          <div class="cardimg"></div>
          <h3 class="title">Portfolio</h3>
          <p class="meta">Visual grid, case-study focus</p>
          <!-- <a href="../themes/theme-portfolio.php" class="tag">Showcase</a> -->
           <a class="tag">Showcase</a>
        </div>
      </article>

      <article class="card" data-theme="dark" tabindex="0" role="button" aria-pressed="false">
        <div class="cardinner">
          <div class="cardimg"></div>
          <h3 class="title">Dark</h3>
          <p class="meta">Moody palette, neon accents</p>
          <!-- <a href="theme-dark.php" class="tag">Night</a> -->
              <a class="tag">Night</a>
        </div>
      </article>

      <article class="card" data-theme="light" tabindex="0" role="button" aria-pressed="false">
        <div class="cardinner">
          <div class="cardimg"></div>
          <h3 class="title">Light</h3>
          <p class="meta">Clean white spaces and soft shadows</p>
          <!-- <a href="theme-light.php" class="tag">Airy</a> -->
               <a class="tag">Airy</a>
        </div>
      </article>

      <article class="card" data-theme="custom" tabindex="0" role="button" aria-pressed="false">
        <div class="cardinner">
          <div class="cardimg"></div>
          <h3 class="title">Custom</h3>
          <p class="meta">Start from scratch — add your own elements</p>
          <!-- <a href="theme-custom.php" class="tag">Make</a> -->
           <a class="tag">Make</a>
        </div>
      </article>
    </div>
  </section>
</main>

<!-- Overlay used during open animation -->
<div class="overlay" id="overlay" aria-hidden="true">
  <div class="overlaycard" id="overlaycard">
    <div class="overlayclose" id="overlayclose" title="Close preview">&times;</div>
    <div class="ovcontent">
      <h2 id="ovtitle"></h2>
      <p id="ovmeta"></p>
      <div class="ovbtns">
        <button id="openfull" class="btn">Open Full</button>
        <button id="goback" class="btn ghost">Back</button>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>

<script>
/* theme.php JS: handles choice click, card open animation and redirect */
(() => {
  const cards = document.querySelectorAll('.card');
  const choices = document.querySelectorAll('.choice');
  const overlay = document.getElementById('overlay');
  const overlayCard = document.getElementById('overlaycard');
  const ovtitle = document.getElementById('ovtitle');
  const ovmeta = document.getElementById('ovmeta');
  const openfull = document.getElementById('openfull');
  const goback = document.getElementById('goback');
  const overlayclose = document.getElementById('overlayclose');

  // helper: build target URL for a theme
  function themeUrl(name) {
    // Map to the actual filenames you have. Example: theme-ecommerce.php
    return `theme-${name}.php`;
  }

  // Card open flow: show overlay with animation, then redirect on "Open Full"
  function showOverlay(card) {
    const theme = card.dataset.theme || 'custom';
    const title = card.querySelector('.title').textContent;
    const meta = card.querySelector('.meta').textContent;

    ovtitle.textContent = title;
    ovmeta.textContent = meta;
    overlay.setAttribute('aria-hidden', 'false');
    document.body.classList.add('no-scroll');

    // animate
    overlay.classList.add('visible');
    overlayCard.classList.add('popin');

    // set open button href in handler
    openfull.onclick = () => {
      // play a final expand animation before redirect
      overlayCard.classList.add('expandout');
      setTimeout(() => {
        window.location.href = themeUrl(theme);
      }, 500); // small delay for animation
    };
  }

  function hideOverlay() {
    overlayCard.classList.remove('popin', 'expandout');
    overlay.classList.remove('visible');
    overlay.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('no-scroll');
  }

  // Card click / key handlers
  cards.forEach(card => {
    card.addEventListener('click', () => showOverlay(card));
    card.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        showOverlay(card);
      }
    });
  });

  // Quick pick from top choices: highlights grid and opens first matching
  choices.forEach(c => {
    c.addEventListener('click', (e) => {
      const t = c.dataset.theme;
      // find first card with that theme
      const match = document.querySelector(`.card[data-theme="${t}"]`);
      if (match) showOverlay(match);
    });
  });

  // overlay controls
  goback.addEventListener('click', hideOverlay);
  overlayclose.addEventListener('click', hideOverlay);
  overlay.addEventListener('click', (e) => {
    if (e.target === overlay) hideOverlay();
  });

  // Escape closes overlay
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && overlay.classList.contains('visible')) hideOverlay();
  });
})();
</script>
