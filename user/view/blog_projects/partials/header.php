<?php
require_once 'partials/db.php'; 
$seo = $conn->query("SELECT * FROM seo_settings WHERE id=1")->fetch_assoc();
?>


<!DOCTYPE html>
<html>
 <head>
 <title><?= htmlspecialchars($seo['site_name']) ?></title>
<meta name="description" content="<?= htmlspecialchars($seo['site_description']) ?>">
<meta name="keywords" content="<?= htmlspecialchars($seo['site_keywords']) ?>">

 <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome (for icons like heart) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Custom CSS -->
   <link rel="stylesheet" href="assetss/css/style.css">
</head>
<body>
<header class="main-header">
  <div class="container nav-container">
    <div class="logo">
      <a href="blog.php"><span>Blog</span></a>
    </div>
    <nav class="navbar">
      <ul>
        <li><a href="blog.php" class="nav-link">Home</a></li>
        <!-- <li><a href="categories.php" class="nav-link">Categories</a></li> -->
        <li><a href="#" class="nav-link">About</a></li>
        <li><a href="contact.php" class="nav-link">Contact</a></li>
      </ul>
    </nav>
  

<form class="container search__bar-container" action="search.php" method="GET">
  <div class="search-box">
    <input type="search" name="search" placeholder="Search posts..." required>
    <button type="submit" class="search-btn">
      <i class="fa fa-search"></i>
    </button>
  </div>
</form>

  </div>
</header>
<script>
document.querySelector('.search__bar-container').addEventListener('submit', function() {
  const btn = this.querySelector('.search-btn');
  btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
});
</script>

</body>
</html>