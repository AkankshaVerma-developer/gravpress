<?php
$orderId = rand(100000, 999999); // dummy order ID
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Successful</title>
    <link rel="stylesheet" href="css/theme-ecommerce/order-success.css">
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
        <li><a href="search.php">Search</a></li>
        <li><a href="order-success.php">My Orders</a></li>
        <li><a class="cart" href="cart.php">Cart</a></li>
      </ul>
    </nav>
  </div>
</header>


<!-- SUCCESS SECTION -->
<section class="success-box">
    <div class="icon">✔</div>
    <h1>Order Placed Successfully!</h1>
    <p>Your order has been placed and is being processed.</p>

    <div class="order-details">
        <p><strong>Order ID:</strong> <?= $orderId ?></p>
        <p><strong>Estimated Delivery:</strong> 3–6 Days</p>
        <p><strong>Payment:</strong> Cash on Delivery</p>
    </div>

    <a href="product-detail.php" class="btn">View Orders</a>
    <a href="home.php" class="btn-secondary">Continue Shopping</a>
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
