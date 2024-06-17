<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lash Luxe</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css" type="text/css" />
</head>

<body>

  <!--Navbar-->
  <section id="header">
    <a href="index.php"><img src="assets/imgs/transparent2.png" class="logo" alt="Lash Luxe logo" width="250" height="100"></a>

    <nav aria-label="Main Navigation">
      <ul id="navbar">
        <li><a class="active" href="index.php">Home</a></li>
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
          <li><a href="account.php">My Account</a></li>
        <?php else: ?>
          <li><a href="login.php">Login</a></li>
        <?php endif; ?>
        <li><a href="cart.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
              <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
            </svg></a></li>
      </ul>
    </nav>

  </section>

  <!--hero-->
  <section id="hero">
    <div class="container">
      <h4>LASH LUXE</h4>
      <h1>Give your lashes<br>the luxury they deserve</h1>
    </div>
  </section>

  <!--Featured Products-->
  <section id="product1" class="section-p1">
    <h2>Shop Our Products</h2>
    <p>Check out our diy products</p>
    <div class="pro-container">

      <?php include('server/get_featured_products.php'); ?>
      <?php while ($row = $featured_products->fetch_assoc()) { ?>
        <div class="col-md-4  section-p1">
          <div onclick="window.location.href='single_product.php?product_id=<?php echo $row['product_id']; ?>';" class="pro"/>
            <img src="assets/imgs/products/<?php echo $row['product_image']; ?>" alt="" height="300" width="450"/>
            <div class="des">
              <span><?php echo $row['product_name']; ?></span>
              <h4>R<?php echo $row['product_price']; ?></h4>
              <a href="single_product.php?product_id=<?php echo $row['product_id']; ?>"><i class="fas fa-shopping-cart"></i></a>
            </div>
          </div>
        </div>
      <?php } ?>
      
    </div>
  </section>

  <?php include('layout/footer.php'); ?>

</body>
</html>
