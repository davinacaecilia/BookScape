<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Book Details — Bookscape</title>
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
 <link rel="stylesheet" href="{{ asset('produk/preview.css') }}"/>
  <link rel="stylesheet" href="{{ asset('produk/popup.css') }}"/>
  <link rel="stylesheet" href="{{ asset('produk/footer.css') }}"/>
  <link rel="stylesheet" href="{{ asset('produk/navbar2.css') }}"/>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

@include('produk.navbar2')

  <main>
    <div class="book-detail-card">
      <img src="https://ebooks.gramedia.com/ebook-covers/34734/big_covers/ID_KPG2016MTH10DDAG_B.jpg" alt="The Hunger Games" class="book-cover-detail">
      <div class="book-detail-info">
        <h2 class="book-detail-title">THE HUNGER GAMES</h2>
        <span class="book-detail-author">Suzanne Collins</span>
        <div class="genre-rating-wrapper">
          <span class="book-detail-genre">Sci-Fi</span>
          <div class="book-detail-rating">
            <i class="fas fa-star"></i>
            <span>4.7</span>
          </div>
        </div>
        <p class="book-detail-description">In the nation of Panem, established in the remains of North America after an apocalyptic event, the wealthy Capitol exploits the twelve surrounding districts for their natural resources and labor. As punishment for a past failed rebellion against the Capitol, which resulted in the obliteration of District 13, one boy and one girl between the ages of 12 and 18 from each of the remaining districts are selected by an annual lottery to participate in the Hunger Games, a contest in which the "tributes" must fight to the death in an outdoor arena until only one remains.</p>
        <div class="price-actions-wrapper">
          <p class="book-detail-price">IDR 100.000,00</p>
          <div class="book-detail-actions">
  <button id="add-to-cart-button" class="cart-icon-button" title="Add to Cart"><i class='fa-solid fa-cart-plus'></i></button>
  <button id="buy-now-button" class="buy-now-button">Buy Now</button>
</div>
        </div>
      </div>
    </div>
  </main>

  @include('produk.footer')

<div class="nav-arrows">
    <button class="nav-arrow prev-arrow"><i class='bx bx-chevron-left'></i></button>
    <button class="nav-arrow next-arrow"><i class='bx bx-chevron-right'></i></button>
  </div>


  <script src="{{ asset('produk/js/popup.js') }}"></script>
<script src="{{ asset('produk/js/preview.js') }}"></script>
  </body>
</html>
