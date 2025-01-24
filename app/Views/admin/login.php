<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login or Register</title>
  <link rel="stylesheet" href="<?= base_url('/assets/css/login.css') ?>">
  <script>
    function toggleForms() {
      var loginForm = document.getElementById('loginForm');
      var registerForm = document.getElementById('registerForm');
      if (loginForm.style.display === 'none') {
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
      } else {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
      }
    }
  </script>
</head>
<body>
  <div class="wrapper">
  <?php if (session()->getFlashdata('msg')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
        <?php endif; ?>
    
    <div id="loginForm">
      <form id="form" action="<?= base_url('/login/authenticate') ?>" method="POST">
        <h2>Login</h2>
        <div class="input-field">
          <input type="text" id="username" name="username" required>
          <label for="username">Enter your username</label>
        </div>
        <div class="input-field">
          <input type="password" id="password" name="password" required>
          <label for="password">Enter your password</label>
        </div>
        <div class="forget">
          <label for="remember">
            <input type="checkbox" id="remember">
            <p>Remember me</p>
          </label>
          <a href="#">Forgot password?</a>
        </div>
        <button type="submit">Log In</button>
        <div class="register">
          <p>Don't have an account? <a href="javascript:void(0);" onclick="toggleForms()">Register</a></p>
        </div>
      </form>
    </div>

    <div id="registerForm" style="display:none;">
      <form action="<?= base_url('/register') ?>" method="POST">
        <h2>Register</h2>
        <div class="input-field">
          <input type="text" id="new_name" name="name" value="" required>
          <label for="new_name">Enter your name</label>
        </div>
        <div class="input-field">
          <input type="text" id="new_username" name="username" value="" required>
          <label for="new_username">Enter your username</label>
        </div>
        <div class="input-field">
          <input type="password" id="new_password" name="password" value="" required>
          <label for="new_password">Create a password</label>
        </div>
        <div class="input-field">
          <input type="password" id="confirm_password" name="confirm_password" value="" required>
          <label for="confirm_password">Confirm your password</label>
        </div>
        <button type="submit">Register</button>
        <div class="login">
          <p>Already have an account? <a href="javascript:void(0);" onclick="toggleForms()">Login</a></p>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
