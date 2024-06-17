<?php
session_start();

if (isset($_POST['product_id']) && isset($_POST['product_quantity'])) {
    $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_quantity'];

    //Ensure quantity is positive and valid
    if ($product_quantity > 0 && isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['product_quantity'] = $product_quantity;
    } else {
        //Remove the product if the quantity is 0 or less
        unset($_SESSION['cart'][$product_id]);
    }

    header('Location: cart.php');
    exit();
} else {
    header('Location: cart.php');
    exit();
}
?>
