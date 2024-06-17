<?php
session_start();
include('server/connection.php');

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}


/*Log out */
if (isset($_GET['logout'])) {
    if (isset($_SESSION['logged_in'])) {
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        header('location: login.php');
        exit;
    }
}

/*Show orders */
if(isset($_SESSION['logged_in'])){
    $user_id = $_SESSION['user_id'];
    
    $stmt = $conn->prepare('SELECT * FROM orders where user_id=?');
    
    $stmt->bind_param('i',$user_id);

    $stmt->execute();

    $orders = $stmt->get_result();

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
        <a href="index.php"><img src="assets/imgs/transparent2.png" class="logo" alt="Lash Luxe logo" width="250" height="100"></a>

        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a class="active" href="account.php">My Account</a></li>
                <li><a href="cart.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
                            <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
                        </svg></a></li>
            </ul>
        </div>

    </section>

    <!--Account-->
    <section id="account-page" class="section-p1">
        <div>

            <div id="account-colcumn" class="section-m1">
                <div>
                    <h3>Account</h3>
                    <p>Name:<span><?php if (isset($_SESSION['user_name'])) {
                                        echo $_SESSION['user_name'];
                                    } ?></span></p>
                    <p>Email:<span><?php if (isset($_SESSION['user_email'])) {
                                        echo $_SESSION['user_email'];
                                    } ?></span></p>
                    <p><a href="#orders" id="order-btn">Your orders</a></p>
                    <p><a href="account.php?logout=1" id="logout-btn">Logout</a></p>
                </div>
                <div>
                    <form id="account-form">
                        <h3>Change Password</h3>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" required id="account-password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label> Confirm Password</label>
                            <input type="password" class="form-control" name="confirmpassword " required id="account-password-confirm" placeholder="Confirm Password">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Change Password" class="btn" id="change-pass-btn">
                        </div>

                    </form>
                </div>
            </div>

        </div>


    </section>

    <!--Orders-->
    <section class="orders section-p1">

        <div>
            <h2 class=" center-content bold-text">Your Orders</h2>
            <hr>
        </div>

        <table class="section-m1" >
            <tr>
                <th>Order ID</th>
                <th>Order Cost</th>
                <th>Order Status</th>
                <th>Date</th>
                <th>Order Details</th>
            </tr>

            <?php while($row = $orders->fetch_assoc()){?>

                <tr>
                    

                    <td>
                        <span><?php echo $row['order_id']; ?></span>
                    </td>

                    <td>
                        <span><?php echo $row['order_cost']; ?></span>
                    </td>

                    <td>
                        <span><?php echo $row['order_status']; ?></span>
                    </td>

                    <td>
                        <span><?php echo $row['order_date']; ?></span>
                    </td>

                    <td>
                       <form method="POST" action="order_details.php">
                        <input type="hidden" value="<?php echo $row['order_id'] ;?>" name="order_id" />
                        <input type="submit" name="order_details_btn" class="button order-detail-btn" value="Order Details">
                       </form>
                    </td>
                    
                </tr>
            <?php } ?>
        </table>
    </section>

    <?php include('layout/footer.php'); ?>

