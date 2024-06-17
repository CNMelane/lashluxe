<?php

session_start();

if(!empty($_SESSION['cart'] && isset($_POST['checkout']))){
    //if conditions are meet code will run

}
//send user to home page
else{
    header('location: index.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lash Luxe</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel=" stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" />
</head>

<body>

    <!--Navbar-->
    <section id="header">
        <a href="index.php"><img src="assets/imgs/transparent2.png" class="logo" alt="Lash Luxe logo" width="250"
                height="100"></a>

        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="login.html">My Account</a></li>
                <li><a class="active" href="cart.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                            <path
                                d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                        </svg></a></li>
            </ul>
        </div>

    </section>

    
    <!--Check Out-->
    <section class="section-p1">
        <div class="text-center">
            <h2 class=".bold-text">Check Out</h2>
            <hr>
        </div>
        <div class="center-content">

            <form id="checkout-form"method="POST" action="server/place_order.php">
                <div class="form-group checkout-small-element">
                    <label>Name</label>
                    <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Name" required>
                </div>

                <div class="form-group checkout-small-element">
                    <label>Email</label>
                    <input type="text" class="form-control" id="checkout-email" name="email" placeholder="Email"
                        required>
                </div>

                <div class="form-group checkout-small-element">
                    <label>Phone</label>
                    <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="Phone"
                        required>
                </div>

                <div class="form-group checkout-small-element">
                    <label>City</label>
                    <input type="text" class="form-control" id="checkout-city" name="city" placeholder="City" required>
                </div>

                <div class="form-group checkout-large-element">
                    <label>Address</label>
                    <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Address" required>
                </div>

                <div class="form-group checkout-btn-container">
                    <p>Total Amount:<?php echo $_SESSION['total']; ?></p>
                    <input type="submit" class="btn" id="checkout-btn" name="place_order" value="Place Order">
                </div>
            </form>
        </div>


    </section>







    <!--Footer-->
    <footer class="section-p1">
        <div class="column">
            <img class="logo" src="assets/imgs/transparent2.png" alt="Lash Luxe logo" width="150" height="50">
            <p>Give your lashes the luxury they deserve</p>
            <div class="follow">
                <h4>Social Media</h4>
                <div class="icon">
                    <i class="fab fa-cart-shopping"></i><!--sort out-->
                    <i class="fab fa-cart-shopping"></i><!--sort out-->
                </div>
            </div>
        </div>
        <div class="column">
            <h4>Contact Us</h4>
            <p><strong>Phone:</strong> 0645798744</p>
            <p><strong>Email:</strong> .....gmail.com</p>
            <p><strong>Instagram:</strong>_lashluxe.zzzz-</p>


        </div>
        <div class="column">
            <h4>My Account</h4>
            <a href="#">Login</a>
            <a href="#">View Cart</a>
            <a href="#">Help</a>

        </div>
        <div class="copyright">
            <p>created by melane. 2024</p>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>