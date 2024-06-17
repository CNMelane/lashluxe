<?php
session_start();
include('server/connection.php');

/* get dails */
if (isset($_POST['order_details_btn']) && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $stmt = $conn->prepare('SELECT * FROM order_items where order_id=?');
    
    $stmt->bind_param('i',$order_id);

    $stmt->execute();

    $order_details = $stmt->get_result();
    
}else{
    header('location: account.php');
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
    <link rel=" stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" />
</head>

<body>

    <!--Navbar-->
    <section id="header">
        <a href="index.html"><img src="assets/imgs/transparent2.png" class="logo" alt="Lash Luxe logo" width="250" height="100"></a>

        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a class="active" href="account.php">My Account</a></li>
                <li><a href="cart.html"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                            <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                        </svg></a></li>
            </ul>
        </div>

    </section>



    <!--Orders Details-->
    <section class="orders section-p1">

        <div class="section-p1">
            <h2 class=" center-content bold-text">Orders Details</h2>
            <hr>
        </div>

        <table class="section-m1" >
            <tr>
                <th>Product</th>
                <th>Total Price</th>
                <th>Quantity</th>
                
            </tr>

        <?php while($row = $order_details->fetch_assoc()){?>
                <tr>
                    <td>
                        <div class="product-info">
                            <img src="assets/imgs/products/<?php echo $row['product_image']; ?>"/>
                            <div>
                                <p class="section-m1"><?php echo $row['product_name']; ?></p>
                            </div>
                        </div>
                    </td>

                    <td>
                        <span>R<?php echo $_SESSION['total']; ?></span>
                    </td>

                    <td>
                        <span><?php echo $row['product_quantity']; ?></span>
                    </td>

                    
                </tr>
            <?php } ?>
        </table>
    </section>
