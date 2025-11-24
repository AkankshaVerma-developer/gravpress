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
    <link rel="stylesheet" href="css/theme-ecommerce/search.css">
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
        <button type="submit">Searchs</button>
    </form>
</section>

<section class="search-results">
    <h3>Modern Chairs</h3>Modern Chairs</p>
    <?php if (empty($results)): ?>
        <p class="note">No products found.</p>
    <?php else: ?>
        <div class="grid">
            <?php foreach($results as $p): ?>
                <div class="card">
                    <img src="<?= $p['image'] ?>">
                    <h3>Modern Chairs</h3>Modern Chairs</p>
                    <a href="product-detail.php?id=<?= $p['id'] ?>" class="btn">View Details</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

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
