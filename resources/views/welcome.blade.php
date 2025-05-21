<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./welcome.css" />
    <title>Welcome</title>
    <meta name="csrf-token" content="{{csrf_token() }}">
</head>
<body>
<div class="welcomepage">
  <img class="books-library-shelves-138556-1280-x-720-1"
       src="{{asset('img/books-library-shelves-138556-1280-x-720-10.png') }}" />
  <div class="ellipse-1"></div>
  <img class="rectangle-8" src="{{asset('svg/rectangle-80.svg') }}" />
  <div class="rectangle-9"></div>
  
  <div class="logo-container">
    <div class="logo-icon">
      <i class='bx bx-book-reader'></i>
    </div>
    <div class="app-title">
      BOOKSCAPE
    </div>
  </div>

    <div class="tagline">
    Find your dream book in one click browse and shop anytime, anywhere
  </div>
</div>
  
  <div class="auth-buttons">
    <div class="button-group">
      <a href="{{ route('login') }}" class="btn-login">
        <div class="btn-text">SIGN IN</div>
      </a>
      <a href="{{ route('register') }}" class="btn-signup">
        <div class="btn-text">SIGN UP</div>
      </a>
    </div>
  </div>
</div>
</body>
</html>