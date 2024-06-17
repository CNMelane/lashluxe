<?php
session_start();
include('server/connection.php');

if (isset($_SESSION['logged_in'])) {
  header('location: account.php');
  exit;
}

if (isset($_POST['register'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];

  // Check password length
  if (strlen($password) < 6) {
    header('location: register.php?error=passwords must be atleast 6 characters');
    exit;
  }

  // Check if passwords match
  if ($password !== $confirmPassword) {
    header('location: register.php?error=passwords dont match');
    exit;
  }

  // Check if user is already registered
  $stmt1 = $conn->prepare("SELECT count(*) FROM users where user_email=?");
  $stmt1->bind_param('s', $email);
  $stmt1->execute();
  $stmt1->bind_result($num_rows);
  $stmt1->fetch();
  $stmt1->close();

  if ($num_rows != 0) {
    header('location: register.php?error=email has already been registered');
    exit;
  }

  // Create new user
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $stmt = $conn->prepare("INSERT INTO users (user_name,user_email,user_password) VALUES (?,?,?)");
  $stmt->bind_param('sss', $name, $email, $hashed_password);

  if ($stmt->execute()) {
    $user_id = $stmt->insert_id;
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_name'] = $name;
    $_SESSION['logged_in'] = true;
    header('location: account.php?register=You have registred successfully');
    exit;
  } else {
    header('location: register.php?register=Account could not be created');
    exit;
  }
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
        <li><a class="active" href="register.php">Register</a></li>
        <li><a href="cart.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
              <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
            </svg></a></li>
      </ul>
    </div>

  </section>


  <!--Register-->
  <section id="Rigister" class="section-p1">
    <div class="text-center">
      <h2>Register</h2>
    </div>
    <div class="center-content">
      <form id="register-form" method="POST" action="register.php">
        <p style="color: red;"><?php if (isset($_GET['error'])) {
                                  echo $_GET['error'];
                                } ?></p>
        <div class="form-group">
          <label for="Name">Name</label>
          <input type="text" class="form-control" id="register-name" name="name" placeholder="Name" required>
        </div>

        <div class="form-group">
          <label for="Email">Email</label>
          <input type="text" class="form-control" id="register-email" name="email" placeholder="Email" required>
        </div>

        <div class="form-group">
          <label for="Password">Password</label>
          <input type="text" class="form-control" id="register-password" name="password" placeholder="Password" required>
        </div>

        <div class="form-group">
          <label for="Password"> Confirm Password</label>
          <input type="text" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="Confirm Password" required>
        </div>

        <div class="form-group">
          <input type="submit" class="btn" id="register-btn" name="register" value="Register">
        </div>

        <div class="form-group">
          <a href="login.php" id="login-url" class="btn">Do you have an account? Login</a>

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


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>