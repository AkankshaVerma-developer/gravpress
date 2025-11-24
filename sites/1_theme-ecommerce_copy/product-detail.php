<?php
session_start();

/**
 * Dummy product dataset (same structure as category.php)
 * Keep this array in sync across pages or move to a shared include.
 */
$products = [
    [
        "id" => 1,
        "name" => "Modern Chair",
        "price" => 599,
        "currency" => "Rs",
        "category" => "furniture",
        "image" => "https://images.unsplash.com/photo-1574180045827-681f8a1a9622?w=1000"
    ],
    [
        "id" => 2,
        "name" => "Sneaker Shoes",
        "price" => 1290,
        "currency" => "Rs",
        "category" => "shoes",
        "image" => "https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=1000"
    ],
    [
        "id" => 3,
        "name" => "Stylish Backpack",
        "price" => 799,
        "currency" => "Rs",
        "category" => "bags",
        "image" => "https://www.trawoc.com/cdn/shop/files/1_614bf24e-1b6e-4173-90cd-793180184fd3.jpg?v=1742193796"
    ]
];

// Utility: find product by id
function find_product($products, $id) {
    foreach ($products as $p) {
        if ((int)$p['id'] === (int)$id) return $p;
    }
    return null;
}

// Basic cart operations (session-based)
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

// Add to cart (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $pid = (int)($_POST['product_id'] ?? 0);
    $qty = max(1, (int)($_POST['quantity'] ?? 1));
    // if product exists in cart, increase qty
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] === $pid) {
            $item['qty'] += $qty;
            $found = true;
            break;
        }
    }
    unset($item);
    if (!$found) {
        $_SESSION['cart'][] = ['id' => $pid, 'qty' => $qty];
    }
    // redirect to avoid form resubmission
    header("Location: product-detail.php?id={$pid}&added=1");
    exit;
}

// compute cart count
$cart_count = 0;
foreach ($_SESSION['cart'] as $c) $cart_count += $c['qty'];

// pick product id from query
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$product = find_product($products, $id);
if (!$product) {
    // fallback to first product
    $product = $products[0];
    $id = $product['id'];
}

$added = isset($_GET['added']) ? true : false;
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($product['name']) ?> — Product Detail</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="css/theme-ecommerce/product-detail.css">
</head>
<body>

<!-- Header (same look as home.php) -->
<header class="head">
  <div class="box">
    <h1 class="logo">Shop</h1>
    <nav class="menu">
      <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="category.php?cat=all">Category</a></li>
        <li><a href="search.php">Search</a></li>
        <li><a href="order-success.php">My Order</a></li>
        <li><a class="cart" href="cart.php">Cart (<?= $cart_count ?>)</a></li>
      </ul>
    </nav>
  </div>
</header>

<main class="pd-main">
  <div class="pd-container">

    <?php if ($added): ?>
      <div class="toast">Added to cart ✅</div>
    <?php endif; ?>

    <div class="pd-grid">
      <div class="pd-left">
        <div class="img-wrap">
          <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        </div>
        <div class="thumbs">
          <!-- simple thumbs (repeat image for demo) -->
          <?php for ($i=0;$i<3;$i++): ?>
            <img class="thumb" src="<?= htmlspecialchars($product['image']) ?>" alt="thumb">
          <?php endfor; ?>
        </div>
      </div>

      <div class="pd-right">
        <h2 class="pd-title"><?= htmlspecialchars($product['name']) ?></h2>
        <p class="pd-category">Category: <strong><?= htmlspecialchars(ucfirst($product['category'])) ?></strong></p>
        <p class="pd-price"><?= htmlspecialchars($product['currency']) ?> <?= number_format($product['price']) ?></p>

        <p class="pd-desc">
          Beautifully crafted item combining comfort and modern design. Perfect for everyday use or gifting.
        </p>

        <form method="post" class="addcart-form">
          <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
          <label>
            Quantity
            <input type="number" name="quantity" value="1" min="1" class="qty">
          </label>
          <button type="submit" name="add_to_cart" class="btn-add">Add to Cart</button>
          <a href="cart.php" class="btn-checkout">View Cart</a>
        </form>

        <div class="pd-info">
          <h4>Product Details</h4>
          <ul>
            <li>Material: Premium quality</li>
            <li>Shipping: 2-5 business days</li>
            <li>Return: 7 days return policy</li>
          </ul>
        </div>
      </div>
    </div>

  </div>
</main>


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
