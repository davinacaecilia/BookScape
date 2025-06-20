<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Buy now - — Bookscape</title>
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('produk/orderNow.css') }}"/>
  <link rel="stylesheet" href="{{ asset('produk/navbar2.css') }}"/>
  <link rel="stylesheet" href="{{ asset('produk/footer.css') }}"/>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

@include('produk.navbar2')

<main class="main-content">
    <section class="order-details-section">
        <div class="order-card detail-orderan">
            <h2>Detail Orderan</h2>
            @foreach($orderItems as $item)
            <div class="order-item">
            <div class="item-visual-section">
                <img src="{{ asset('storage/sampul/' . $item->buku->gambar_sampul) }}" alt="{{ $item->buku->judul_buku }}" class="book-cover">
            </div>
            <div class="item-info">
                <h3 class="book-title">{{ $item->buku->judul_buku }}</h3>
                <p class="book-author">{{ $item->buku->penulis_buku }}</p>
                <p class="item-price-per-unit">Rp {{ number_format($item->buku->harga, 0, ',', '.') }}</p>
                <div class="quantity-control">
                    <p class="quantity-label">Jumlah:</p>
                    <button class="quantity-btn minus-btn">-</button>
                    <span class="quantity-display">{{ $item->quantity }}</span>
                    <button class="quantity-btn plus-btn">+</button>
                </div>
                <button class="add-address-btn" id="addAddressButton">Tambahkan Alamat</button>
            </div>
            </div>
            @endforeach

        </div>
    </section>

    @include('produk.ringkasan-keranjang')
</main>

@include('produk.popup-order')

@include('produk.footer')

<script src="{{ asset('produk/js/cart.js') }}"></script>
<script src="{{ asset('produk/js/quantity.js') }}"></script>
<script src="{{ asset('produk/js/popuporder.js') }}"></script>
</body>
</html>
