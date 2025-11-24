<?php
session_start();

/* -----------------------------
   DUMMY PRODUCT DATA (USE SAME)
------------------------------- */
$products = [
    [
        "id" => 1,
        "name" => "Modern Chair",
        "price"=> 599,
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

/* -----------------------------
   FUNCTIONS
------------------------------- */

function getProduct($products, $id) {
    foreach ($products as $p) {
        if ($p['id'] == $id) return $p;
    }
    return null;
}

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

/* -----------------------------
   UPDATE QUANTITY
------------------------------- */
if (isset($_POST['update_qty'])) {
    $pid = $_POST['pid'];
    $qty = max(1, (int)$_POST['qty']);

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $pid) {
            $item['qty'] = $qty;
            break;
        }
    }
    unset($item);
    header("Location: cart.php?updated=1");
    exit;
}

/* -----------------------------
   REMOVE ITEM
------------------------------- */
if (isset($_GET['remove'])) {
    $pid = $_GET['remove'];
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function($i) use ($pid) {
        return $i['id'] != $pid;
    });
    header("Location: cart.php?deleted=1");
    exit;
}

/* -----------------------------
   CALCULATE TOTALS
------------------------------- */
$cart_count = 0;
$total = 0;

foreach ($_SESSION['cart'] as $c) {
    $cart_count += $c['qty'];
    $product = getProduct($products, $c['id']);
    if ($product) {
        $total += $product['price'] * $c['qty'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Your Cart</title>
<link rel="stylesheet" href="css/theme-ecommerce/cart.css">
</head>
<body>

<!-- HEADER -->
<header class="head">
  <div class="box">
    <h1 class="logo">Shop</h1>
    <nav class="menu">
      <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="category.php?cat=all">Category</a></li>
        <li><a href="search.php">Search</a></li>
        <li><a href="order-success.php">My Order</a></li>
        <li><a class="cart active" href="cart.php">Cart (<?= $cart_count ?>)</a></li>
      </ul>
    </nav>
  </div>
</header>

<div class="cart-container">

<?php if (isset($_GET['updated'])): ?>
<div class="alert">Quantity Updated ✔</div>
<?php endif; ?>

<?php if (isset($_GET['deleted'])): ?>
<div class="alert alert-del">Item Removed ❌</div>
<?php endif; ?>

<h2>Your Shopping Cart</h2>

<?php if (empty($_SESSION['cart'])): ?>
  <p class="empty">Your cart is empty 😔</p>
  <a href="category.php?cat=all" class="btn-shop">Go Shopping</a>

<?php else: ?>

<table class="cart-table">
  <tr>
    <th>Product</th>
    <th>Name</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Total</th>
    <th>Action</th>
  </tr>

  <?php foreach ($_SESSION['cart'] as $item): 
      $p = getProduct($products, $item['id']);
      if (!$p) continue;
  ?>
  <tr>
    <td><img src="<?= $p['image'] ?>" alt=""></td>
    <td><?= $p['name'] ?></td>
    <td>Rs <?= $p['price'] ?></td>
    <td>
      <form method="post">
        <input type="hidden" name="pid" value="<?= $p['id'] ?>">
        <input type="number" name="qty" min="1" value="<?= $item['qty'] ?>">
        <button name="update_qty">Update</button>
      </form>
    </td>
    <td>Rs <?= $p['price'] * $item['qty'] ?></td>
    <td><a class="remove" href="cart.php?remove=<?= $p['id'] ?>">Remove</a></td>
  </tr>
  <?php endforeach; ?>

</table>

<div class="cart-summary">
  <h3>Modern Chairs</h3>Modern Chairs</strong></p>
  <p>Total Price: <strong>Rs <?= $total ?></strong></p>
  <a href="checkout.php?checkout=1" class="btn-checkout">Checkout</a>
</div>

<?php endif; ?>

</div>


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
