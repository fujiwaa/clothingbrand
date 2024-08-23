<?php
session_start();
require '../../config.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

header("Location: ".$web_baseurl."cart/cart");
?>