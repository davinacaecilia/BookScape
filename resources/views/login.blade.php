<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BookScape -  Signin</title>
  <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./style.css">
</head>
<body>
  <div class="auth-container">
    <!-- Background Elements -->
    <img class="auth-bg-image" src="{{asset('img/books-library-shelves-138556-1280-x-720-10.png')}}" alt="Background" />
    <div class="auth-overlay"></div>

  <div class="auth-left-content">
  <div class="logo-container">
    <i class='bx bx-book-reader auth-logo-icon'></i>
    <div class="app-title">BOOKSCAPE</div>
  </div>

  <div class="tagline-text">
    Find your dream book in one click 
    browse and shop anytime, anywhere
  </div></br>
</div>
    <!-- Login Form -->
    <div class="auth-form-container">
      <div class="auth-title">SIGN IN</div>

      <?php if (!empty($message)): ?>
        <div class="auth-error-container">
          <?php foreach ($message as $msg): ?>
            <div class="auth-error-msg"><?php echo htmlspecialchars($msg); ?></div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="" class="auth-form">
        <!-- Email Input -->
        <div class="auth-input-field">
          <i class='bx bx-envelope'></i>
          <input type="text" name="email" placeholder="Email"
                 value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required />
        </div>

        <!-- Password Input -->
        <div class="auth-input-field">
          <i class='bx bx-lock-alt'></i>
          <input type="password" name="pass" placeholder="Password" required />
        </div>

        <!-- Login Button -->
        <button type="submit" name="submit" class="auth-button">
          <span class="auth-button-text">SIGN IN</span>
        </button>
      </form>

      <!-- Sign Up Redirect -->
      <div class="auth-alternate-action">
        <span>Don't have an account?</span>
        <a href="register">SIGN UP</a>
      </div>
    </div>
  </div>
</body>
</html>
