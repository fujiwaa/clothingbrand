<?php
session_start();
require '../../config.php';

if (isset($_GET['action']) && isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $action = $_GET['action'];
    
    if (isset($_SESSION['cart'][$product_id])) {
        if ($action == 'increase') {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } elseif ($action == 'decrease') {
            if ($_SESSION['cart'][$product_id]['quantity'] > 1) {
                $_SESSION['cart'][$product_id]['quantity'] -= 1;
            } else {
                unset($_SESSION['cart'][$product_id]);
            }
        }
    }
    
    header("Location: ".$web_baseurl."cart/cart");
} else {
    header("Location: ".$web_baseurl."cart/cart");
}