<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: checkout.php");
    exit;
}

// You can save order to DB here (optional)

// Clear cart
unset($_SESSION['cart']);

header("Location: order-success.php?success=1");
exit;
