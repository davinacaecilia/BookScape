<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Your review — Bookscape</title>
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('produk/rating.css') }}" />
  <link rel="stylesheet" href="{{ asset('produk/navbar2.css') }}" />
  <link rel="stylesheet" href="{{ asset('produk/footer.css') }}" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

  @include('produk.navbar2')

  <main class="rating-main-content">
    <div class="rating-card">
      @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
      <div class="book-info">
        <img src="https://ebooks.gramedia.com/ebook-covers/34734/big_covers/ID_KPG2016MTH10DDAG_B.jpg" alt="Sampul Buku"
          class="book-cover">
        <h3 class="book-title">The Hunger Games</h3>
        <p class="book-author">Oleh Suzanne Collins</p>
      </div>
      <form method="POST" action="{{ route('ratings.store', $buku->id) }}">
        @csrf
        <div class="rating-stars">
          <span class="rating-label">Beri Rating:</span>
          <div class="stars">
            <input type="radio" id="star5" name="rating" value="5"><label for="star5" title="5 bintang"><i
                class="fas fa-star"></i></label>
            <input type="radio" id="star4" name="rating" value="4"><label for="star4" title="4 bintang"><i
                class="fas fa-star"></i></label>
            <input type="radio" id="star3" name="rating" value="3"><label for="star3" title="3 bintang"><i
                class="fas fa-star"></i></label>
            <input type="radio" id="star2" name="rating" value="2"><label for="star2" title="2 bintang"><i
                class="fas fa-star"></i></label>
            <input type="radio" id="star1" name="rating" value="1"><label for="star1" title="1 bintang"><i
                class="fas fa-star"></i></label>
          </div>
        </div>

        <div class="review-section">
          <label for="reviewText">Apa pendapatmu tentang produk ini?</label>
          <textarea id="reviewText" name="review" placeholder="Tulis ulasanmu di sini..."></textarea>
        </div>

        <button type="submit" class="submit-review-btn" id="submitReviewBtn" disabled>Kirim</button>
    </div>
  </main>

  @include('produk.footer')

  <script src="{{ asset('produk/js/rating.js') }}"></script>
</body>

</html>