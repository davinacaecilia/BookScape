<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookScape - Register</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('signup.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="auth-container">
        <!-- Background elements -->
        <img class="auth-bg-image" src="{{asset('img/books-library-shelves-138556-1280-x-720-10.png')}}"
            alt="Background">
        <div class="auth-overlay"></div>

        <div class="auth-left-content">
            <div class="logo-container">
                <i class='bx bx-book-reader auth-logo-icon'></i>
                <div class="app-title">BOOKSCAPE</div>
            </div>

            <div class="tagline-text">
                Find your dream book in one click browse and shop anytime, anywhere
            </div>
        </div>

        <!-- Registration Form -->
        <div class="auth-form-container">
            <div class="auth-title">SIGN UP</div>

            @if($errors->any())
                <div class="auth-error-container">
                    @foreach($errors->all() as $error)
                        <div class="auth-error-msg">{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="auth-form">
                @csrf

                <!-- Name Input -->
                <div class="auth-input-field">
                    <i class='bx bx-user'></i>
                    <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required
                        autofocus />
                </div>

                <!-- Email Input -->
                <div class="auth-input-field">
                    <i class='bx bx-envelope'></i>
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
                </div>

                <!-- Password Input -->
                <div class="auth-input-field">
                    <i class='bx bx-lock-alt'></i>
                    <input type="password" name="password" placeholder="Password" required />
                </div>

                <!-- Confirm Password Input -->
                <div class="auth-input-field">
                    <i class='bx bx-lock-alt'></i>
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required />
                </div>

                <!-- Register Button -->
                <button type="submit" class="auth-button">
                    <span class="auth-button-text">SIGN UP</span>
                </button>
            </form>

            <div class="auth-alternate-action">
                <span>Already have an account?</span>
                <a href="{{ route('login') }}">SIGN IN</a>
            </div>
        </div>
    </div>
</body>

</html>