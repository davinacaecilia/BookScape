<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet' />
    <!-- My CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/product-management.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}" />
    <title>Product Management</title>
</head>

<body>

    @include('partial.sidebar')

    <section id="content">

        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="nav-link">Categories</a>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="notification">
                <i class='bx bxs-bell'></i>
                <span class="num">8</span>
            </a>
            <a href="#" class="profile">
            </a>
        </nav>

        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Manage Products</h1>
                    <p>Manage Products</p>
                </div>
                <div class="right">
                    <a href="{{ route('product.create') }}" class="btn-add">
                        <i class='bx bx-plus'></i> Add Product
                    </a>
                </div>
            </div>

            <!-- PRODUCT LIST -->
            <div class="product-list">
                @foreach ($products as $product)
                    <div class="product">
                        <img src="{{ asset('storage/sampul/' . $product->gambar_sampul) }}"
                            alt="{{ $product['judul_buku'] }}" />
                        <h4>{{ $product['judul_buku'] }}</h4>
                        <!-- INi informasi tambahan ya di cards, ada author, stock, sama genre ny ((sesuai rikwes)) -->
                        <p class="product-author">Author: {{ $product->penulis_buku }}</p>
                        <p>Rp {{ number_format($product['harga'], 0, ',', '.') }}</p>
                        <p>Stock: {{ $product->stock }}</p>
                        <p>Genre:
                            @foreach($product->genres as $genre)
                                {{ $genre->nama_genre }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                        </p>
                        <div class="action-buttons">
                            <form action="{{ route('product.edit', $product->id) }}" method="GET">
                                <button type="submit" class="btn-update">
                                    <i class='bx bx-update'></i> Edit
                                </button>
                            </form>

                            <!-- KOREKSI PENTING DI SINI: $product->id digunakan, bukan $loop->iteration -->
                            <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="delete-form"
                                onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </section>

    <form id="logout-form-admin" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        function confirmAdminLogout() {
            if (confirm('Are You Sure Want to Log Out?')) {
                document.getElementById('logout-form-admin').submit();
            }
        }
    </script>

</body>
<script src="{{ asset('script/script.js') }}"></script>
<script src="{{ asset('script/delete.js')}}"></script>
<script src="{{ asset('script/pagination.js') }}"></script>

</html>