<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BookScape Admin - @yield('title', 'Dashboard')</title>
    
    <style>
        /* Palet warna coklat */
        :root {
            --brown-dark: #5D3A00;
            --brown-medium: #A66E3A;
            --brown-light: #D9B382;
            --brown-bg: #F5EFE6;
            --text-dark: #3B2F2F;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--brown-bg);
            color: var(--text-dark);
        }

        header {
            background-color: var(--brown-dark);
            color: var(--brown-bg);
            padding: 1rem 2rem;
            font-weight: bold;
            font-size: 1.3rem;
        }

        .container {
            max-width: 700px;
            margin: 2rem auto;
            background-color: white;
            padding: 2rem 2.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h1 {
            color: var(--brown-medium);
            margin-bottom: 1rem;
        }

        form label {
            display: block;
            margin-top: 1rem;
            font-weight: 600;
        }

        form input[type="text"],
        form input[type="number"],
        form input[type="file"],
        form textarea {
            width: 100%;
            padding: 0.5rem;
            margin-top: 0.3rem;
            border: 1.5px solid var(--brown-light);
            border-radius: 4px;
            font-size: 1rem;
            resize: vertical;
        }

        form textarea {
            min-height: 100px;
        }

        button[type="submit"] {
            margin-top: 1.5rem;
            background-color: var(--brown-medium);
            color: var(--brown-bg);
            border: none;
            padding: 0.7rem 1.4rem;
            font-size: 1.1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.25s ease;
        }

        button[type="submit"]:hover {
            background-color: var(--brown-dark);
        }
    </style>
    
    @yield('head') {{-- kalau mau tambah css/js lain di child view --}}
</head>
<body>
    <header>
        BookScape Admin Panel
    </header>

    <div class="container">
        @yield('content')
    </div>
</body>
</html>
