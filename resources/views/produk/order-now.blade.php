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
     <div class="order-item">
    <div class="item-visual-section">
        <img src="https://ebooks.gramedia.com/ebook-covers/34734/big_covers/ID_KPG2016MTH10DDAG_B.jpg" alt="Book Cover" class="book-cover">
        </div>
    <div class="item-info">
        <h3 class="book-title">The Hunger Games</h3>
        <p class="book-author">Suzanne Collins</p>
        <p class="item-price-per-unit">IDR 99.000,00</p> <div class="quantity-control">
            <p class="quantity-label">Jumlah:</p>
             <button class="quantity-btn minus-btn">-</button>
                  <span class="quantity-display">2</span>
                  <button class="quantity-btn plus-btn">+</button>
        </div>
        <button class="add-address-btn" id="addAddressButton">Tambahkan Alamat</button> </div>
    </div>
    </div>
    </section>

    @include('produk.ringkasan-keranjang')
</main>

@include('produk.popup-order')

@include('produk.footer')


<script src="{{ asset('produk/js/quantity.js') }}"></script>
<script src="{{ asset('produk/js/popuporder.js') }}"></script>
</body>
</html>
