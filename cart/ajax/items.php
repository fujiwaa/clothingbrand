<?php
session_start();
require '../../config.php';

if (isset($_POST['addToCart'])) {
    $product_id = $_POST['addToCart'];
    $quantity = isset($_POST['numberProduct']) ? (int)$_POST['numberProduct'] : 1;
    $size = isset($_POST['sizeChart']) ? $_POST['sizeChart'] : '';
    
    $product_query = $db->query("SELECT * FROM product WHERE id = '$product_id'");
    $product = mysqli_fetch_assoc($product_query);
    
    if ($product) {
        $product_id = $product['id'];
        $product_category = $product['category'];
        $product_name = $product['name'];
        $product_price = $product['price'];
        $product_image = explode(',', $product['image'])[0];
        
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
            $_SESSION['cart'][$product_id]['size'] = $size;
        } else {
            $_SESSION['cart'][$product_id] = array(
                'id' => $product_id,
                'category' => $product_category,
                'name' => $product_name,
                'price' => $product_price,
                'quantity' => $quantity,
                'size' => $size,
                'image' => $product_image
            );
        }
        
        header("Location: ".$web_baseurl."cart/cart");
    } else {
        header("Location: ".$web_baseurl."produk/produk-preview?id=".$product_id);
    }
} else if (isset($_POST['buyNow'])) {
    $product_id = $_POST['buyNow'];
    $quantity = isset($_POST['numberProduct']) ? (int)$_POST['numberProduct'] : 1;
    $size = isset($_POST['sizeChart']) ? $_POST['sizeChart'] : '';
    
    $product_query = $db->query("SELECT * FROM product WHERE id = '$product_id'");
    $product = mysqli_fetch_assoc($product_query);
    
    if ($product) {
        $product_id = $product['id'];
        $product_category = $product['category'];
        $product_name = $product['name'];
        $product_price = $product['price'];
        $product_image = explode(',', $product['image'])[0];
        
        $_SESSION['buyNow'] = array(
            'id' => $product_id,
            'category' => $product_category,
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => $quantity,
            'size' => $size,
            'image' => $product_image
        );
        
        header("Location: ".$web_baseurl."payment/payment-process");
    } else {
        header("Location: ".$web_baseurl."produk/produk-preview?id=".$product_id);
    }
} else {
    header("Location: ".$web_baseurl."produk/produk-preview?id=".$product_id);
}