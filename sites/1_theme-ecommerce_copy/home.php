<?php
session_start();
?>
<html>
  <head>
  <link rel="stylesheet" href="css/theme-ecommerce/home.css">
</head>
<body>
 <header class="gp-header">
  <div class="gp-container">
    <div class="gp-logo">GravPress</div>
    <nav class="gp-nav">
      <a href="../../home.php">Home</a>
      <a href="../../gravtheme.php" class="active">Themes</a>
    <a href="../../activate.php?theme=theme-ecommerce" class="btn">Activate Theme</a>
      <a href="#">Support</a>
    </nav>
  </div>
</header>
  <!-- HEADER -->
   
  <header class="head">
    <div class="box">
      <h1 class="logo">Shop</h1>
      <nav class="menu">
        <ul>
          <li><a href="home.php">Home</a></li>
          <li><a href="category.php">Category</a></li>
          <li><a href="order-success.php">My Order</a></li>
          <li><a href="search.php">Search</a></li>
          <li><a class="cart" href="cart.php">Cart (0)</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- HERO / INTRO -->
  <section class="hero">
    <div class="hero-box">
      <div class="hero-left">
        <h2 style="font-size: 44px; color: #e71313;">Style meets style</h2>
        <p>Have any questions or feedback? We love to hear from you!</p>
        <a class="btn-main" href="category.php">Shop Collection</a>
      </div>
      <div class="hero-right">
        <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=700" alt="Hero Fashion">
      </div>
    </div>
  </section>

  <!-- FEATURE STRIP -->
  <section class="strip">
    <div class="strip-box">
      <div class="item">
        <img src="https://img.icons8.com/fluency/48/shipped.png" alt="">
        <h4>Fast Delivery</h4>
      </div>
      <div class="item">
        <img src="https://img.icons8.com/fluency/48/return-purchase.png" alt="">
        <h4>Easy Returns</h4>
      </div>
      <div class="item">
        <img src="https://img.icons8.com/fluency/48/lock--v1.png" alt="">
        <h4>Secure Payments</h4>
      </div>
    </div>
  </section>

  <!-- PRODUCTS -->
  <section class="shop">
    <div class="shop-box">
      <h2 style="font-size: 44px; color: #e71313;">New Arrivals</h2>
      <div class="grid">
        <div class="card">
          <img src="https://images.unsplash.com/photo-1574180045827-681f8a1a9622?w=500" alt="Product 1">
          <h3>Modern Chair</h3>
          <button class="btn-add">Add to Cart</button>
        </div>
        <div class="card">
          <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500" alt="Product 2">
          <h3>Sneakers</h3>
          <button class="btn-add">Add to Cart</button>
        </div>
        <div class="card">
          <img src="https://www.trawoc.com/cdn/shop/files/1_614bf24e-1b6e-4173-90cd-793180184fd3.jpg?v=1742193796" alt="Product 3">
          <h3>Bag packs</h3>
          <button class="btn-add">Add to Cart</button>
        </div>
      </div>
    </div>
  </section>

  <!-- CONTACT -->
  <section class="touch">
    <div class="touch-box">
      <div class="touch-left">
        <h2 style="font-size: 44px; color: #e71313;">Get in Touch</h2>
        <p>Have any questions or feedback? We’d love to hear from you!</p>
        <form class="form">
          <input type="text" placeholder="Your Name" required>
          <input type="email" placeholder="Your Email" required>
          <textarea placeholder="Your Message" required></textarea>
          <button type="submit" class="btn-main">Send Message</button>
        </form>
      </div>
      <div class="touch-right">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRyoL4HLKXkGH-7qM8A9OK7PkYugZluILc9Fg&s" alt="Contact Us">
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="foot">
    <div class="foot-box">
      <div class="col">
        <h4>About Shop</h4>
        <p>Shop brings you handpicked designs crafted with love and creativity.</p>
      </div>
      <div class="col">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Terms of Service</a></li>
          <li><a href="#">Support</a></li>
        </ul>
      </div>
      <div class="col">
        <h4>Subscribe</h4>
        <form class="inline">
          <input type="email" placeholder="Enter your email">
          <button>Join</button>
        </form>
      </div>
    </div>
    <div class="foot-bottom">
      <p>© 2025 GravShop. All Rights Reserved.</p>
    </div>
  </footer>


<!-- CLICK-TO-EDIT AUTO-INJECT -->
<script>
document.addEventListener("click", function(e){
    e.preventDefault();
    e.stopPropagation();
    const el = e.target;

    window.parent.postMessage({
        type:"elementClicked",
        tag: el.tagName,
        text: el.innerText || "",
        src: el.src || "",
        selector: el.tagName.toLowerCase() + (el.className ? '.'+el.className.replace(/\s+/g,'.') : ""),
        color: el.style.color,
        font: window.getComputedStyle(el).fontSize
    }, "*");
});
</script>

<!-- AUTO-INJECT : CLICK TO EDIT -->
<script>
document.addEventListener("click", function(e){
    // allow ctrl/cmd+click to behave normally
    if (e.ctrlKey || e.metaKey) return;
    e.preventDefault();
    e.stopPropagation();

    const el = e.target;
    const selector = getUniqueSelector(el);

    window.parent.postMessage({
        type: "elementClicked",
        tag: el.tagName,
        text: el.innerText || "",
        src: el.src || "",
        color: el.style.color || "",
        font: window.getComputedStyle(el).fontSize,
        selector: selector
    }, "*");
});

function getUniqueSelector(el){
    if (!el) return '';
    if (el.id) return "#" + el.id;

    // Build selector with tag + classes + nth-child fallback
    let sel = el.tagName.toLowerCase();
    if (el.className && typeof el.className === 'string') {
        sel += "." + el.className.trim().replace(/\s+/g, ".");
    }

    // If same-level siblings make it ambiguous, append :nth-child
    const parent = el.parentElement;
    if (parent) {
        const siblings = Array.from(parent.children);
        const index = siblings.indexOf(el) + 1; // nth-child is 1-based
        sel += `:nth-child()`;
    }
    return sel;
}
</script>
</body>
</html>
