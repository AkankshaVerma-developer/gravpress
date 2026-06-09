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
  <link rel="stylesheet" href="css/theme-ecommerce/category.css">
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
  <h2>All Collection shop</h2>
</section>

<section class="product-grid">
  <?php foreach($filtered as $item): ?>
    <div class="card">
      <img src="<?= $item['image'] ?>" alt="">
      <h3>Chairs</h3>Modern Chairs</p>
      <a href="product-detail.php?id=<?= $item['id'] ?>" class="btn-detail">View Details</a>
    </div>
  <?php endforeach; ?>
</section>


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
