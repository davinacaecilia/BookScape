<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Library Books — Bookscape</title>
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('produk/produk.css') }}"/>
  <link rel="stylesheet" href="{{ asset('produk/popup.css') }}"/>
  <link rel="stylesheet" href="{{ asset('produk/footer.css') }}"/>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

@include('produk.navbar')

  <main class="book-grid">
    <div class="book-card">
  <img src="https://ebooks.gramedia.com/ebook-covers/34734/big_covers/ID_KPG2016MTH10DDAG_B.jpg" alt="Diary: Dagelan 2015" class="book-cover">
  <div class="book-info">
    <h2 class="book-title">Diary: Dagelan 2015</h2>
    <p class="book-genre">COMEDY <span class="rating">⭐ 4.0</span></p>
    <p class="book-price">Rp.79.00,00</p>
    <a href="#" class="add-to-cart-button">Add to Cart</a>
  </div>
</div>

    <div class="book-card">
      <img src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1474594228i/32184214.jpg" alt="(EX)PERIENCE" class="book-cover">
      <div class="book-info">
        <h2 class="book-title">(EX)PERIENCE</h2>
        <p class="book-genre">COMEDY, DRAMA <span class="rating">⭐ 4.7</span></p>
        <p class="book-price">Rp.55.00,00</p>
        <a href="#" class="add-to-cart-button">Add to Cart</a>
      </div>
    </div>

    <div class="book-card">
      <img src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg" alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
      <div class="book-info">
        <h2 class="book-title">Skripsick</h2>
        <p class="book-genre">SCI-FI<span class="rating">⭐ 4.5</span></p>
        <p class="book-price">Rp.40.00,00</p>
        <a href="#" class="add-to-cart-button">Add to Cart</a>
      </div>
    </div>

    <div class="book-card">
      <img src="https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/9786024260347C_9786024260347.jpg" alt="Setengah Jalan" class="book-cover">
      <div class="book-info">
        <h2 class="book-title">Setengah Jalan</h2>
        <p class="book-genre">COMEDY <span class="rating">⭐ 4.7</span></p>
        <p class="book-price">Rp.69.00,00</p>
        <a href="#" class="add-to-cart-button">Add to Cart</a>
      </div>
    </div>
  </main>

  @include('produk.footer')

<script src="{{ asset('produk/js/popup.js') }}"></script>
<script src="{{ asset('produk/js/new.js') }}"></script>
</body>
</html>
