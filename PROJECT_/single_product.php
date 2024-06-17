<?php

include('server/connection.php');

if (isset($_GET['product_id'])) {
  $product_id = filter_var($_GET['product_id'], FILTER_SANITIZE_NUMBER_INT);

  if ($stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?")) {
    $stmt->bind_param("i", $product_id);

    $stmt->execute();

    $product = $stmt->get_result();

    if ($product->num_rows == 0) {
      // No product found, redirect to index
      header('location: index.php');
    }
  } else {
    // SQL error
    die('SQL error: ' . $conn->error);
  }
} else {
  // No product_id set, redirect to index
  header('location: index.php');
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

  <!--Navbar-->
  <section id="header">
    <a href="index.php"><img src="assets/imgs/transparent2.png" class="logo" alt="Lash Luxe logo" width="250" height="100"></a>

    <nav aria-label="Main Navigation">
      <ul id="navbar">
        <li><a class="active" href="index.php">Home</a></li>
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) : ?>
          <li><a href="account.php">My Account</a></li>
        <?php else : ?>
          <li><a href="login.php">Login</a></li>
        <?php endif; ?>
        <li><a href="cart.php">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
            <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
          </svg>
        </a></li>
      </ul>
    </nav>

    <div id="mobile">
      <i id="bar" class="fas fa-outdent"></i>
    </div>

  </section>

  <section id="productdetails" class="section-p1">
    <?php while ($row = $product->fetch_assoc()) { ?>
      <div class="single-image">
        <img src="assets/imgs/products/<?php echo htmlspecialchars($row['product_image']); ?>" width="100%" id="mainimg" alt="<?php echo htmlspecialchars($row['product_name']); ?>">
      </div>
      <div>
        <h4><?php echo htmlspecialchars($row['product_name']); ?></h4>
        <h4>R<?php echo htmlspecialchars($row['product_price']); ?></h4>
        <form method="POST" action="cart.php">
          <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($row['product_id']); ?>" />
          <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($row['product_image']); ?>" />
          <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['product_name']); ?>" />
          <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($row['product_price']); ?>" />
          <input type="number" name="product_quantity" value="1" min="1" />
          <button class="buy-btn" type="submit" name="add_to_cart">Add to Cart</button>
        </form>
        <p><?php echo htmlspecialchars($row['product_description']); ?></p>
      </div>
    <?php } ?>
  </section>

  <!--Footer-->
  <footer class="section-p1">
    <div class="column">
      <img class="logo" src="assets/imgs/transparent2.png" alt="Lash Luxe logo" width="150" height="50">
      <p>Give your lashes the luxury they deserve</p>
      <div class="follow">
        <h4>Social Media</h4>
        <div class="icon">
          <i class="fab fa-facebook-f"></i>
          <i class="fab fa-instagram"></i>
        </div>
      </div>
    </div>
    <div class="column">
      <h4>Contact Us</h4>
      <p><strong>Phone:</strong> 0645798744</p>
      <p><strong>Email:</strong> info@lashluxe.com</p>
      <p><strong>Instagram:</strong> _lashluxe.zzzz</p>
    </div>
    <div class="column">
      <h4>My Account</h4>
      <a href="login.php">Login</a>
      <a href="cart.php">View Cart</a>
      <a href="#">Help</a>
    </div>
    <div class="copyright">
      <p>Created by Melane, 2024</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>