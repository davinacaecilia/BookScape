<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
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
    @forelse ($products as $product)
      <div class="book-card" data-id="{{ $product->id }}">
        <img src="{{ asset('storage/sampul/' . $product->gambar_sampul) }}" alt="{{ $product->judul_buku }}" class="book-cover">
        
        <div class="book-info">
          <h2 class="book-title">{{ $product->judul_buku }}</h2>
          <p class="book-genre">
            @foreach($product->genres as $genre)
              {{ $genre->genre }}{{ !$loop->last ? ', ' : '' }}
            @endforeach 
            <span class="rating">⭐ 4.0</span>
          </p>
          <p class="book-price">Rp {{ number_format($product['harga'], 0, ',', '.') }}</p>
          <form action="{{ route('product.addToCart', $product->id) }}" method="POST" enctype="multipart/form-data" class="cart-form">
            @csrf
            <button type="submit" class="add-to-cart-button" data-stock="{{ $product->stock }}" style="border: none;">
              Add to Cart
            </button>
          </form>
        </div>
      </div>
    @empty
      <p>Tidak ada produk ditemukan pada kategori ini.</p>
    @endforelse
  </main>


  @include('produk.footer')

  <script src="{{ asset('produk/js/new.js') }}"></script>
  <script src="{{ asset('produk/js/popup.js') }}"></script>
</body>
</html>
