<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
      <img src="{{ asset('storage/sampul/' . $products->gambar_sampul) }}" class="book-cover-detail">
      <div class="book-detail-info">
        <h2 class="book-detail-title">{{ $products->judul_buku }}</h2>
        <span class="book-detail-author">{{ $products->penulis_buku }}</span>
        <div class="genre-rating-wrapper">
          <div class="book-genres">
            @foreach($products->genres as $genre)
              <span class="book-detail-genre">{{ $genre->genre }}</span>
            @endforeach
          </div>

          <div class="book-detail-rating">
            <i class="fas fa-star"></i>
            <span>4.7</span>
          </div>
        </div>
        <p class="book-detail-description">{{ $products->sinopsis }}</p>
        <div class="price-actions-wrapper">
          <p class="book-detail-price">Rp {{ number_format($products['harga'], 0, ',', '.') }}</p>
          <div class="book-detail-actions">
            <form action="{{ route('product.addToCart', $products->id) }}" method="POST" enctype="multipart/form-data" class="cart-form">
            @csrf
              <button id="add-to-cart-button" data-stock="{{ $products->stock }}" class="cart-icon-button" title="Add to Cart"><i class='fa-solid fa-cart-plus'></i></button>
            </form>
            <form action="{{ route('order.checkout') }}" method="POST" class="buy-now-form">
                @csrf
                <input type="hidden" name="buku_id" value="{{ $products->id }}">
                <input type="hidden" name="quantity" id="quantityInputBuyNow" value="1"> 
                <button type="submit" class="buy-now-button" id="buy-now-button">Buy Now</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <section class="product-reviews">
      <h3 class="reviews-title">Ulasan Produk</h3>
      <div class="review-grid">
        <div class="review-card">
          <div class="review-header">
            <img src="https://dailydoll.shop/wp-content/uploads/2022/04/icm_fullxfull.361401571_okwof16ahs00ogw480wo.jpg" alt="Profile Picture" class="profile-review-pic">
            <span class="reviewer-name">Davina Karamoy</span>
            <div class="review-rating">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star-half-alt"></i>
              <span>4.5</span>
            </div>
          </div>
          <p class="review-text">Buku ini luar biasa! Ceritanya sangat menarik dan membuat saya tidak bisa berhenti membaca. Sangat direkomendasikan!</p>
        </div>
        <div class="review-card">
          <div class="review-header">
            <img src="https://i.pinimg.com/736x/38/e1/e7/38e1e7671c6db8842ce55c44a1e8c3a0.jpg" alt="Profile Picture" class="profile-review-pic">
            <span class="reviewer-name">Anomali Windah</span>
            <div class="review-rating">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <span>5.0</span>
            </div>
          </div>
          <p class="review-text">Salah satu buku terbaik yang pernah saya baca. Plotnya cerdas dan karakternya sangat relatable. Wajib punya!</p>
        </div>
        <div class="review-card">
          <div class="review-header">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR8keiXE4E5qYg4FJyyQ5zENi2rz4buBec-aQ&s" alt="Profile Picture" class="profile-review-pic">
            <span class="reviewer-name">Gojo Satoru</span>
            <div class="review-rating">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <span>4.0</span>
            </div>
          </div>
          <p class="review-text">Cerita yang bagus, meskipun beberapa bagian terasa agak lambat. Secara keseluruhan, pengalaman membaca yang menyenangkan.</p>
        </div>
      </div>
    </section>
  </main>

  @include('produk.footer')

  <div class="nav-arrows">
    @if ($previousBuku)
    <a href="{{ route('product.detail', $previousBuku->id) }}" style="text-decoration: none;">
      <button class="nav-arrow prev-arrow"><i class='bx bx-chevron-left'></i></button>
    </a>
    @else
      <button class="nav-arrow prev-arrow" style="visibility: hidden;"><i class='bx bx-chevron-left'></i></button>
    @endif

    @if ($nextBuku)
    <a href="{{ route('product.detail', $nextBuku->id) }}" style="text-decoration: none;">
      <button class="nav-arrow next-arrow"><i class='bx bx-chevron-right'></i></button>
    </a>
    @else
      <button class="nav-arrow next-arrow" style="visibility: hidden;"><i class='bx bx-chevron-right'></i></button>
    @endif
  </div>

  <script src="{{ asset('produk/js/popup.js') }}"></script>
  <script src="{{ asset('produk/js/preview.js') }}"></script>
  </body>
</html>
