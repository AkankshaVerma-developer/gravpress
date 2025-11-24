<?php
// Dummy product data
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
    ],
    [
        "id" => 4,
        "name" => "Olive T-Shirt",
        "price" => 450,
        "category" => "fashion",
        "image" => "https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=500"
    ]
];

$query = $_GET['q'] ?? "";

$results = [];

if ($query !== "") {
    $results = array_filter($products, function($p) use ($query) {
        return stripos($p["name"], $query) !== false ||
               stripos($p["category"], $query) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Products</title>
    <link rel="stylesheet" href="../../../css/theme-ecommerce/search.css">
</head>
<body>

<!-- SAME HEADER -->
<header class="head">
  <div class="box">
    <h1 class="logo">Shop</h1>
    <nav class="menu">
      <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="category.php?cat=all">Category</a></li>
        <li><a class="active" href="search.php">Search</a></li>
        <li><a href="order-success.php">My Order</a></li>
        <li><a class="cart" href="cart.php">Cart</a></li>
      </ul>
    </nav>
  </div>
</header>

<section class="search-bar">
    <form>
        <input type="text" name="q" placeholder="Search products..." 
               value="<?= htmlspecialchars($query) ?>" required>
        <button type="submit">Search</button>
    </form>
</section>

<section class="search-results">
    <h3>Search Results for: <?= htmlspecialchars($query) ?></h3>

    <?php if ($query === ""): ?>
        <p class="note">Type something to search for a product.</p>
    <?php elseif (empty($results)): ?>
        <p class="note">No products found.</p>
    <?php else: ?>
        <div class="grid">
            <?php foreach($results as $p): ?>
                <div class="card">
                    <img src="<?= $p['image'] ?>">
                    <h3><?= $p['name'] ?></h3>
                    <p class="price">Rs <?= $p['price'] ?></p>
                    <a href="product-detail.php?id=<?= $p['id'] ?>" class="btn">View Details</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</section>

</body>
</html>
