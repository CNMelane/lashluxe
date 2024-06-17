<?php
session_start();


if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];

    // Cart has products already
    if (isset($_SESSION['cart'])) {
        $product_array_ids = array_column($_SESSION['cart'], "product_id");

        // Checks if product has been added to cart or not
        if (!in_array($product_id, $product_array_ids)) {
            $product_array = array(
                'product_id' => $product_id,
                'product_name' => $_POST['product_name'],
                'product_price' => $_POST['product_price'],
                'product_image' => $_POST['product_image'],
                'product_quantity' => $_POST['product_quantity']
            );

            $_SESSION['cart'][$product_id] = $product_array;
        } else {
            echo '<script>alert("Product already in cart");</script>';
        }
    }
    // New product to cart
    else {
        $product_array = array(
            'product_id' => $product_id,
            'product_name' => $_POST['product_name'],
            'product_price' => $_POST['product_price'],
            'product_image' => $_POST['product_image'],
            'product_quantity' => $_POST['product_quantity']
        );

        $_SESSION['cart'][$product_id] = $product_array;
    }
}

// Redirect only when removing item
if (isset($_GET['product_id'])) {
    header('location: cart.php');
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lash Luxe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" />
</head>
<body>
    <!-- Navbar -->
    <section id="header">
        <a href="index.php"><img src="assets/imgs/transparent2.png" class="logo" alt="Lash Luxe logo" width="250" height="100"></a>
        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a class="active" href="cart.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                    <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                </svg></a></li>
            </ul>
        </div>
    </section>

    <!-- Cart -->
    <section class="cart section-p1">
        <div>
            <h2 class="bold-text center-content">Your Cart</h2>
            <hr>
        </div>

        <table>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            <?php if(isset($_SESSION['cart'])): ?>
                <?php foreach($_SESSION['cart'] as $key => $value): ?>
                    <tr>
                        <td>
                            <div class="product-info">
                                <img src="assets/imgs/products/<?php echo $value['product_image']; ?>" />
                                <div>
                                    <p><?php echo $value['product_name']; ?></p>
                                    <small><span>R</span><?php echo $value['product_price']; ?></small>
                                    <a class="remove-btn" href="remove_from_cart.php?product_id=<?php echo $key; ?>">Remove Item</a>

                                </div>
                            </div>
                        </td>
                        <td>
                            <form method="post" action="update_quantity.php">
                                <input type="number" name="product_quantity" value="<?php echo $value['product_quantity']; ?>">
                                <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                                <button type="submit" class="edit-btn">Edit</button>
                            </form>
                        </td>
                        <td>
                            <span>R</span>
                            <span class="product-price"><?php echo $value['product_price'] * $value['product_quantity']; ?></span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>

        <div class="cart-total">
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td>
                        R
                        <?php
                        $total = 0;
                        if(isset($_SESSION['cart'])) {
                            foreach($_SESSION['cart'] as $key => $value) {
                                $total += $value['product_price'] * $value['product_quantity'];
                            }
                        }
                        echo $total;
                        $_SESSION['total'] =$total;
                        
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>R<?php echo $total; ?></td>
                </tr>
            </table>
        </div>
        <div class="checkout-container section-m1">
            <form method="POST" action="checkout.php">
                <input class="btn checkout-btn" value="Checkout" name="checkout" type="submit">
            </form>
        </div>
    </section>

    <?php include('layout/footer.php'); ?>
