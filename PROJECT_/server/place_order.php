<?php

session_start();
include('connection.php');

//Check if the place_order POST request is made and session cart is set
if (isset($_POST['place_order']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    //user inputs
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $city = htmlspecialchars($_POST['city']);
    $address = htmlspecialchars($_POST['address']);
    $order_cost = $_SESSION['total'];
    $order_status = "on_hold";
    $user_id = $_SESSION['user_id']; 
    $order_date = date('Y-m-d H:i:s');

    //Prepare the SQL statement for inserting the order
    $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_phone, user_city, user_address, order_date) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die('Prepare failed: ' . $conn->error);
    }
    $stmt->bind_param('isiisss', $order_cost, $order_status, $user_id, $phone, $city, $address, $order_date);


    if ($stmt->execute()) {
        //Get the last inserted order ID
        $order_id = $stmt->insert_id;

        //Insert each product in the cart into the order_items table
        foreach ($_SESSION['cart'] as $product) {
            $product_id = $product['product_id'];
            $product_name = $product['product_name'];
            $product_image = $product['product_image'];
            $product_price = $product['product_price'];
            $product_quantity = $product['product_quantity'];


            $stmt1 = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, product_price, product_quantity, user_id, order_date) 
                                     VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            if (!$stmt1) {
                die('Prepare failed: ' . $conn->error);
            }
            $stmt1->bind_param('iissiiis', $order_id, $product_id, $product_name, $product_image, $product_price, $product_quantity, $user_id, $order_date);
            
            if (!$stmt1->execute()) {
                die('Execute failed: ' . $stmt1->error);
            }
        }

        // Redirect the user to the payment page with a success status
        header('Location: ../payment.php?order_status=order_placed_successfully');
        exit();
    } else {
        die('Execute failed: ' . $stmt->error);
    }
} else {
    // Redirect the user back to the cart or order page if the cart is empty or the order was not placed properly
    header('Location: ../cart.php?error=empty_cart_or_order_failed');
    exit();
}
