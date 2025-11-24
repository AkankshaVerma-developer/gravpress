<?php
session_start();

/* -----------------------------
   LOAD CART FROM SESSION
------------------------------- */

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php?empty=1");
    exit;
}

/* Dummy product data (same everywhere) */
$products = [
    1 => [
        "id" => 1,
        "name" => "Modern Chair",
        "price" => 599,
        "image" => "https://images.unsplash.com/photo-1574180045827-681f8a1a9622?w=500"
    ],
    2 => [
        "id" => 2,
        "name" => "Sneaker Shoes",
        "price" => 1290,
        "image" => "https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500"
    ],
    3 => [
        "id" => 3,
        "name" => "Stylish Backpack",
        "price" => 799,
        "image" => "https://www.trawoc.com/cdn/shop/files/1_614bf24e-1b6e-4173-90cd-793180184fd3.jpg?v=1742193796"
    ]
];

/* -----------------------------
   PREPARE CART ITEMS
------------------------------- */

$cartItems = [];
$total = 0;

foreach ($_SESSION['cart'] as $c) {
    $pid = $c['id'];
    $qty = $c['qty'];
    $p = $products[$pid];

    $p['qty'] = $qty;
    $p['total'] = $p['price'] * $qty;

    $total += $p['total'];

    $cartItems[] = $p;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Checkout</title>
<link rel="stylesheet" href="../../../css/theme-ecommerce/checkout.css">
</head>
<body>

<header class="head">
  <div class="box">
    <h1 class="logo">Shop</h1>
    <nav class="menu">
      <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="category.php?cat=all">Category</a></li>
        <li><a href="search.php">Search</a></li>
        <li><a href="my-orders.php">My Orders</a></li>
        <li><a class="cart" href="cart.php">Cart (<?= count($_SESSION['cart']) ?>)</a></li>
      </ul>
    </nav>
  </div>
</header>

<section class="checkout-container">

  <!-- LEFT FORM -->
  <div class="checkout-left">
    <h2>Billing Details</h2>

    <form action="place-order.php" method="post">

      <label>Full Name</label>
      <input type="text" name="fullname" required placeholder="Enter your name">

      <label>Email Address</label>
      <input type="email" name="email" required placeholder="Enter your email">

      <label>Mobile Number</label>
      <input type="text" name="phone" required placeholder="Enter phone number">

      <label>Full Address</label>
      <textarea name="address" required placeholder="House, Street, City, Pincode"></textarea>

      <label>Payment Method</label>
      <select name="payment" required>
        <option>Cash on Delivery</option>
        <option>UPI</option>
        <option>Debit / Credit Card</option>
      </select>

      <button class="place-order" type="submit">Place Order</button>
    </form>
  </div>

  <!-- RIGHT ORDER SUMMARY -->
  <div class="checkout-right">
    <h2>Order Summary</h2>

    <?php foreach($cartItems as $item): ?>
      <div class="summary-item">
        <img src="<?= $item['image'] ?>">
        <div>
          <h4><?= $item['name'] ?></h4>
          <p>Qty: <?= $item['qty'] ?></p>
          <p class="price">Rs <?= $item['total'] ?></p>
        </div>
      </div>
    <?php endforeach; ?>

    <hr>
    <div class="total-box">
      <h3>Total: <span>Rs <?= $total ?></span></h3>
    </div>
  </div>

</section>

</body>
</html>
