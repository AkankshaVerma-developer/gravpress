<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GravPress Shop - Ecommerce Preview</title>
  <link rel="stylesheet" href="../css/theme-ecommerce.css">
</head>
<body>
 <header class="gp-header">
  <div class="gp-container">
    <div class="gp-logo">GravPress</div>
    <nav class="gp-nav">
      <a href="home.php">Home</a>
      <a href="gravtheme.php" class="active">Themes</a>
    <a href="activate.php?theme=theme-ecommerce" class="btn">Activate Theme</a>

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
          <li><a href="#">Home</a></li>
          <li><a href="#">Shop</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Contact</a></li>
          <li><a class="cart" href="#">Cart (0)</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- HERO / INTRO -->
  <section class="hero">
    <div class="hero-box">
      <div class="hero-left">
        <h2>Style Meets Comfort</h2>
        <p>Explore our latest collection designed for vibrant lifestyles — fashion that defines you.</p>
        <a class="btn-main" href="#">Shop Collection</a>
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
      <h2>New Arrivals</h2>
      <div class="grid">
        <div class="card">
          <img src="https://images.unsplash.com/photo-1574180045827-681f8a1a9622?w=500" alt="Product 1">
          <h3>Chairs</h3>
          <p class="price">Rs 599</p>
          <button class="btn-add">Add to Cart</button>
        </div>
        <div class="card">
          <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500" alt="Product 2">
          <h3>Sneaker</h3>
          <p class="price">Rs 1290</p>
          <button class="btn-add">Add to Cart</button>
        </div>
        <div class="card">
          <img src="https://www.trawoc.com/cdn/shop/files/1_614bf24e-1b6e-4173-90cd-793180184fd3.jpg?v=1742193796" alt="Product 3">
          <h3>Stylish Backpack</h3>
          <p class="price">$799</p>
          <button class="btn-add">Add to Cart</button>
        </div>
      </div>
    </div>
  </section>

  <!-- CONTACT -->
  <section class="touch">
    <div class="touch-box">
      <div class="touch-left">
        <h2>Get in Touch</h2>
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

</body>
</html>
