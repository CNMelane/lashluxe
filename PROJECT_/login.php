<?php
//Starting the session
session_start();
include('server/connection.php');

//If the user is already logged in, redirect to account.php
if (isset($_SESSION['logged_in'])) {
  header('location: account.php');
  exit;
}

if (isset($_POST['login_btn'])) {

  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT user_id, user_name, user_email, user_password FROM users WHERE user_email=? LIMIT 1");
  $stmt->bind_param('s', $email);

  if ($stmt->execute()) {
    $stmt->bind_result($user_id, $user_name, $user_email, $user_password);
    $stmt->store_result();

     //If user emails already exists
    if ($stmt->num_rows() == 1) {
      $stmt->fetch();

      // Verify the password
      if (password_verify($password, $user_password)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $user_name;
        $_SESSION['user_email'] = $user_email;
        $_SESSION['logged_in'] = true;
        header('location: account.php?message=logged in');
        exit;
      } else {
        // If password is incorrect error message
        $_SESSION['error'] = 'Incorrect password';
      }
    } else {
      $_SESSION['error'] = 'No account found with that email';
    }
  } else {
    $_SESSION['error'] = 'Something went wrong. Please try again later.';
  }

  header('location: login.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lash Luxe</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-JCFfG/G4uQ/v1V+hdqc3JF1p4z10PQ54b7Fp5S+I7H4BzNtmEv3BrclN3tq5rJKC" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/css/style.css" type="text/css" />
  
</head>

<body>

  <!--Navbar-->
  <section id="header">
    <a href="index.php"><img src="assets/imgs/transparent2.png" class="logo" alt="Lash Luxe logo" width="250" height="100"></a>
    <div>
      <ul id="navbar">
        <li><a href="index.php">Home</a></li>
        <li><a class="active" href="login.php">Login</a></li>
        <li><a href="cart.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
              <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z" />
            </svg></a></li>
      </ul>
    </div>
  </section>

  <!--Login-->
  <section id="login" class="section-p1">
    <div class="text-center">
      <h2>Login</h2>
    </div>

    <div class="center-content">
      <form id="login-form" method="POST" action="login.php">
        <?php
        if (isset($_SESSION['error'])) {
          echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
          unset($_SESSION['error']);
        }
        ?>
        <div class="form-group">
          <label for="Email">Email</label>
          <input type="email" class="form-control" id="login-email" name="email" placeholder="Email" required>
        </div>

        <div class="form-group">
          <label for="Password">Password</label>
          <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required>
        </div>

        <div class="form-group">
          <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login">
        </div>

        <div class="form-group">
          <a id="register-url" class="btn" href="register.php">Don't have an account? Register</a>
        </div>
      </form>
    </div>
  </section>

  <?php include('layout/footer.php'); ?>