<?php
$orderId = rand(100000, 999999); // dummy order ID
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Successful</title>
    <link rel="stylesheet" href="../../../css/theme-ecommerce/order-success.css">
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

</body>
</html>
