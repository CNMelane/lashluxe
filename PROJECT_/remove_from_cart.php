<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    //checks if the product exists in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
        header('Location: cart.php');
        exit;
    } else {
        //Product not found in cart
        echo "Product not found in cart.";
        exit;
    }
} else {
    //Invalid request
    header('Location: index.php');
    exit;
}
?>
