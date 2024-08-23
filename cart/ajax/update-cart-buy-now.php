<?php
session_start();
require '../../config.php';

if (isset($_GET['action']) && isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $action = $_GET['action'];
    
    if (isset($_SESSION['buyNow'])) {
        if ($action == 'increase') {
            $_SESSION['buyNow']['quantity'] += 1;
            header("Location: ".$web_baseurl."payment/payment-process");
        } elseif ($action == 'decrease') {
            if ($_SESSION['buyNow']['quantity'] > 1) {
                $_SESSION['buyNow']['quantity'] -= 1;
                header("Location: ".$web_baseurl."payment/payment-process");
            } else {
                unset($_SESSION['buyNow']);
                header("Location: ".$web_baseurl."shop");
            }
        }
    }
    
} else {
    header("Location: ".$web_baseurl."payment/payment-process");
}