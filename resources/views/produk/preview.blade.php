<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Book Details — Bookscape</title>
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('produk/preview.css') }}" />
  <link rel="stylesheet" href="{{ asset('produk/popup.css') }}" />
  <link rel="stylesheet" href="{{ asset('produk/footer.css') }}" />
  <link rel="stylesheet" href="{{ asset('produk/navbar2.css') }}" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

  @include('produk.navbar2')

  <main>
    <div class="book-detail-card">
      <img src="{{ asset('storage/sampul/' . $buku->gambar_sampul) }}" class="book-cover-detail">
      <div class="book-detail-info">
        <h2 class="book-detail-title">{{ $buku->judul_buku }}</h2>
        <span class="book-detail-author">{{ $buku->penulis_buku }}</span>
        <div class="genre-rating-wrapper">
          <div class="book-genres">
            @foreach($buku->genres as $genre)
        <span class="book-detail-genre">{{ $genre->genre }}</span>
      @endforeach
          </div>

          <div class="book-detail-rating">
            <i class="fas fa-star"></i>
            <span>{{ $buku->averageRating() }} (dari {{ $buku->ratingCount() }} ulasan)</span>
          </div>
        </div>
        <p class="book-detail-description">{{ $buku->sinopsis }}</p>
        <div class="price-actions-wrapper">
          <p class="book-detail-price">Rp {{ number_format($buku['harga'], 0, ',', '.') }}</p>
          <div class="book-detail-actions">
            <form action="{{ route('product.addToCart', $buku->id) }}" method="POST" enctype="multipart/form-data"
              class="cart-form">
              @csrf
              <button id="add-to-cart-button" data-stock="{{ $buku->stock }}" class="cart-icon-button"
                title="Add to Cart"><i class='fa-solid fa-cart-plus'></i></button>
            </form>
            <button id="buy-now-button" class="buy-now-button">Buy Now</button>
          </div>
        </div>
      </div>
    </div>

    <section class="product-reviews">
      <h3 class="reviews-title">Ulasan Produk ({{ $buku->ratingCount() }})</h3>

      <div class="review-grid">
        {{-- Lakukan perulangan untuk setiap rating yang dimiliki oleh buku ini --}}
        @forelse ($buku->ratings as $rating)
        <div class="review-card">
          <div class="review-header">
          {{-- Tampilkan nama user yang memberi ulasan --}}
          <img src="https://ui-avatars.com/api/?name={{ urlencode($rating->user->name) }}&background=random"
            alt="Profile Picture" class="profile-review-pic">
          <span class="reviewer-name">{{ $rating->user->name }}</span>

          {{-- Tampilkan bintang sesuai rating yang diberikan --}}
          <div class="review-rating">
            @for ($i = 1; $i <= 5; $i++)
          @if ($i <= $rating->rating)
          <i class="fas fa-star"></i> {{-- Bintang Penuh --}}
        @else
          <i class="far fa-star"></i> {{-- Bintang Kosong --}}
        @endif
        @endfor
            <span style="margin-left: 5px;">{{ number_format($rating->rating, 1) }}</span>
          </div>
          </div>
          {{-- Tampilkan teks ulasan jika ada --}}
          @if ($rating->review)
        <p class="review-text">{{ $rating->review }}</p>
        @endif
          <small class="review-date">{{ $rating->created_at->diffForHumans() }}</small>
        </div>
    @empty
      {{-- Tampilkan pesan ini jika belum ada ulasan sama sekali --}}
      <p>Jadilah yang pertama memberikan ulasan untuk buku ini!</p>
    @endforelse
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