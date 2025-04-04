<?php
require_once '../config/config.php';
// include APP_ROOT . '/views/shared/header.php';
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="../public/css/login/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <title>Buddy</title>
</head>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('form') === 'register') {
            document.getElementById('container').classList.add("active");
        }
    });
</script>


<body>

  <div class="container" id="container">
      <div class="form-container sign-up">
          <form action="<?='../public/index.php?controller=login&action=signup'?>" method="post">
            <h1>Create Account</h1>
            <div class="social-icons">
              <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
              <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
              <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
              <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
            <span>or use your email for registration</span>
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button>Sign Up</button>

            <?php if (isset($_SESSION['error'])): ?>
              <div class="alert alert-danger">
                  <?= $_SESSION['error']; ?>
              </div>
              <?php unset($_SESSION['error']); // Xóa lỗi sau khi hiển thị ?>
          <?php endif; ?>
          </form>
      </div>

    <div class="form-container sign-in">
      <form action="<?='../public/index.php?controller=login&action=signin'?>" method="post">
        <h2>Sign in</h2>
        <div class="social-icons">
          <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
          <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
          <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
        </div>
        <span>or use your email</span>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <a href="#">Forget Your Password?</a>
        <button>Sign In</button>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error']; ?>
            </div>
            <?php unset($_SESSION['error']); // Xóa lỗi sau khi hiển thị ?>
        <?php endif; ?>


      </form>
    </div>
    <div class="toggle-container">
      <div class="toggle">
        <div class="toggle-panel toggle-left">
          <h2>Welcome Back</h2>
          <p>Enter your personal details to use all of site features</p>
          <button class="hidden" id="login">Sign In</button>
        </div>

        <div class="toggle-panel toggle-right">
          <h2>Hello there</h2>
          <p>Register with your personal details to use all of site features</p>
          <button class="hidden" id="register">Sign Up</button>

        </div>
      </div>
    </div>

  </div>

  <script src="../public/js/script.js"></script>

</body>

</html>
