<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BookScape - Signin</title>
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>
    <div class="auth-container">
        <img class="auth-bg-image" src="{{ asset('img/books-library-shelves-138556-1280-x-720-10.png') }}"
            alt="Background" />
        <div class="auth-overlay"></div>

        <div class="auth-left-content">
            <div class="logo-container">
                <i class='bx bx-book-reader auth-logo-icon'></i>
                <div class="app-title">BOOKSCAPE</div>
            </div>
            <div class="tagline-text">
                Find your dream book in one click
                browse and shop anytime, anywhere
            </div>
        </div>

        <div class="auth-form-container">
            <div class="auth-title">SIGN IN</div>

            @if($errors->any())
                <div class="auth-error-container">
                    @foreach ($errors->all() as $error)
                        <div class="auth-error-msg">{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf {{-- BENAR: Menambahkan CSRF Token --}}

                <div class="auth-input-field">
                    <i class='bx bx-envelope'></i>
                    {{-- BENAR: Menggunakan old('email') untuk menjaga input setelah error --}}
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required
                        autofocus />
                </div>

                <div class="auth-input-field">
                    <i class='bx bx-lock-alt'></i>
                    {{-- BENAR: Menggunakan name="password" --}}
                    <input type="password" name="password" placeholder="Password" required />
                </div>

                <button type="submit" class="auth-button">
                    <span class="auth-button-text">SIGN IN</span>
                </button>
            </form>

            <div class="auth-alternate-action">
                <span>Don't have an account?</span>
                {{-- BENAR: Menggunakan helper route() untuk link --}}
                <a href="{{ route('register') }}">SIGN UP</a>
            </div>
        </div>
    </div>
</body>

</html>