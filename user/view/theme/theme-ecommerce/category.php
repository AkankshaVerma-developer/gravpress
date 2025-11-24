<?php
// Dummy product data (use same data everywhere)
$products = [
    [
        "id" => 1,
        "name" => "Modern Chair",
        "price" => 599,
        "category" => "furniture",
        "image" => "https://images.unsplash.com/photo-1574180045827-681f8a1a9622?w=500"
    ],
    [
        "id" => 2,
        "name" => "Sneaker Shoes",
        "price" => 1290,
        "category" => "shoes",
        "image" => "https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500"
    ],
    [
        "id" => 3,
        "name" => "Stylish Backpack",
        "price" => 799,
        "category" => "bags",
        "image" => "https://www.trawoc.com/cdn/shop/files/1_614bf24e-1b6e-4173-90cd-793180184fd3.jpg?v=1742193796"
    ]
];

$category = $_GET['cat'] ?? 'all';

$filtered = ($category === 'all')
    ? $products
    : array_filter($products, function($p) use ($category) {
        return $p['category'] === $category;
    });
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shop Category</title>
  <link rel="stylesheet" href="../../../css/theme-ecommerce/category.css">
</head>
<body>

<!-- HEADER SAME AS HOME -->
<header class="head">
  <div class="box">
    <h1 class="logo">Shop</h1>
    <nav class="menu">
      <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="category.php?cat=all" class="active">Category</a></li>
        <li><a href="search.php">Search</a></li>
        <li><a href="order-success.php">My Order</a></li>
        <li><a class="cart" href="cart.php">Cart</a></li>
      </ul>
    </nav>
  </div>
</header>

<section class="category-banner">
  <h2><?= ucfirst($category) ?> Collection</h2>
</section>

<section class="product-grid">
  <?php foreach($filtered as $item): ?>
    <div class="card">
      <img src="<?= $item['image'] ?>" alt="">
      <h3><?= $item['name'] ?></h3>
      <p class="price">Rs <?= $item['price'] ?></p>
      <a href="product-detail.php?id=<?= $item['id'] ?>" class="btn-detail">View Details</a>
    </div>
  <?php endforeach; ?>
</section>

</body>
</html>
