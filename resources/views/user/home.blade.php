<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>BookScape - Home</title>
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="{{ asset('user/home.css') }}">
  <link rel="stylesheet" href="{{ asset('produk/popup.css') }}" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <div class="home-container">
    <!-- Background Elements -->
    <img class="home-bg-image" src="{{ asset('img/books-library-shelves-138556-1280-x-720-10.png') }}"
      alt="Library Background">
    <div class="home-overlay"></div>

    <nav class="home-nav">

      <div class="logo">
        <i class='bx bx-book-reader'></i>
        <span>BOOKSCAPE</span>
      </div>
      <div class="nav-links">
        <a href="{{ route('home') }}" class="active">Home</a>
        <a href="{{ route('product.library') }}">Library</a>
        <div class="cart-icon-container">
          <a href="{{ route('product.cart') }}" class="cart-icon">
            <i class='bx bx-cart'></i>
          </a>
          <div class="profile-container">
            <a href="#" class="pr le-icon profile-toggle" onclick="toggleDropdown(event)">
              <i class='bx bx-user'></i>
            </a>
            <div class="profile-dropdown" id="profileDropdown">
              <div class="sidebar-scrollable">
                <hr class="full-divider" />
                <ul>
                  <li>
                    <a href="{{ route('profile') }}">
                      <i class='bx bx-user'></i> My Profile
                    </a>
                  </li>
                  <li><a href="{{ route('order.history') }}"><i class='bx bx-cart'></i> History Order</a></li>
                  <li>
                    <a href="#" onclick="event.preventDefault(); confirmLogout();">
                      <i class='bx bx-log-out'></i> Logout
                    </a>
                  </li>
                  <script>
                    function confirmLogout() {
                      Swal.fire({
                        title: 'Logout',
                        text: "Apakah Anda yakin ingin logout?",
                        icon: 'warning', // Icon 'warning' atau 'question' lebih cocok
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Logout',
                        cancelButtonText: 'Batal'
                      }).then((result) => {
                        // Jika user menekan "Ya, Logout"
                        if (result.isConfirmed) {
                          // Langsung submit form-nya. TIDAK PERLU ada popup sukses lagi.
                          document.getElementById('logout-form').submit();
                        }
                      });
                    }
                  </script>
                </ul>
                <hr class="full-divider" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-content">
        <h1>WELCOME TO BOOKSCAPE</h1>
        <p>Explore thousands of books from all genres and find your perfect read</p>

        <div class="search-bar">
          <input type="text" placeholder="Search books or authors...">
          <button><i class='bx bx-search'></i></button>
        </div>
      </div>
    </section>

    <!-- New arrival -->
    @if($myCarts->isEmpty())
  @else
      <section class="featured-books">
        <h2>My Cart</h2>
        <div class="books-grid">
        @foreach ($myCarts as $myCart)
        <div class="book-card book-card-1">
        <a href="{{ route('product.detail', $myCart->buku->id) }}" style="text-decoration: none;">
        <img class="book-cover book-cover-1" src="{{ asset('storage/sampul/' . $myCart->buku->gambar_sampul) }}"
          alt="{{ $myCart->buku->judul_buku }}" class="book-cover">
        <div class="book-info">
          <h2 class="book-title">{{ $myCart->buku->judul_buku }}</h2>
          <p class="book-genre">
          @foreach($myCart->buku->genres as $genre)
        {{ $genre->genre }}{{ !$loop->last ? ', ' : '' }}
        @endforeach
          </p>
          <p class="book-price">Rp {{ number_format($myCart->buku->harga, 0, ',', '.') }}<span class="rating">⭐
          4.5</span></p>
        </div>
        </a>
        </div>
      @endforeach
        </div>
        <a href="{{ route('product.cart') }}" class="view-all">View All <i class='bx bx-chevron-right'></i></a>
      </div>
      </section>
    @endif


  <!-- New Arrival -->
  <section class="featured-books">
    <h2>New Arrival</h2>
    <div class="books-grid">
      @foreach ($newArrivals as $newArrival)
      <div class="book-card book-card-1">
      <a href="{{ route('product.detail', $newArrival->id) }}" style="text-decoration: none;">
        <img class="book-cover book-cover-1" src="{{ asset('storage/sampul/' . $newArrival->gambar_sampul) }}"
        alt="{{ $newArrival->judul_buku }}" class="book-cover">
        <div class="book-info">
        <h2 class="book-title">{{ $newArrival->judul_buku }}</h2>
        <p class="book-genre">
          @foreach($newArrival->genres as $genre)
        {{ $genre->genre }}{{ !$loop->last ? ', ' : '' }}
      @endforeach
        </p>
        <p class="book-price">Rp {{ number_format($newArrival['harga'], 0, ',', '.') }}
          <span class="rating">⭐ {{ $newArrival->averageRating() }}</span>
        </p>
        <form action="{{ route('product.addToCart', $newArrival->id) }}" method="POST" enctype="multipart/form-data"
          class="cart-form">
          @csrf
          <button type="submit" class="add-to-cart-button" data-stock="{{ $newArrival->stock }}"
          style="border: none;">
          Add to Cart
          </button>
        </form>
        </div>
      </a>
      </div>
    @endforeach
    </div>
    </div>
  </section>

  <!-- Best Seller -->
  <section class="featured-books">
    <h2>Best Seller</h2>
    <div class="books-grid">
      @foreach ($bestSellers as $bestSeller)
      <div class="book-card book-card-1">
      <a href="{{ route('product.detail', $bestSeller->id) }}" style="text-decoration: none;">
        <img class="book-cover book-cover-1" src="{{ asset('storage/sampul/' . $bestSeller->gambar_sampul) }}"
        alt="{{ $bestSeller->judul_buku }}" class="book-cover">
        <div class="book-info">
        <h2 class="book-title">{{ $bestSeller->judul_buku }}</h2>
        <p class="book-genre">
          @foreach($bestSeller->genres as $genre)
        {{ $genre->genre }}{{ !$loop->last ? ', ' : '' }}
      @endforeach
        </p>
        <p class="book-price">Rp {{ number_format($bestSeller['harga'], 0, ',', '.') }}
          <span class="rating">⭐ {{ $bestSeller->averageRating() }}</span>
        </p>
        <form action="{{ route('product.addToCart', $bestSeller->id) }}" method="POST" enctype="multipart/form-data"
          class="cart-form">
          @csrf
          <button type="submit" class="add-to-cart-button" data-stock="{{ $bestSeller->stock }}"
          style="border: none;">
          Add to Cart
          </button>
        </form>
        </div>
      </a>
      </div>
    @endforeach
    </div>
    </div>
  </section>

  <section class="featured-books">
    <h2>Library</h2>
    <div class="books-grid">
      <!-- Best seller -->
      @foreach ($libraries as $library)
      <div class="book-card book-card-1">
      <a href="{{ route('product.detail', $library->id) }}" style="text-decoration: none;">
        <img class="book-cover book-cover-1" src="{{ asset('storage/sampul/' . $library->gambar_sampul) }}"
        alt="{{ $library->judul_buku }}" class="book-cover">
        <div class="book-info">
        <h2 class="book-title">{{ $library->judul_buku }}</h2>
        <p class="book-genre">
          @foreach($library->genres as $genre)
        {{ $genre->genre }}{{ !$loop->last ? ', ' : '' }}
      @endforeach
        </p>
        <p class="book-price">Rp {{ number_format($library['harga'], 0, ',', '.') }}
          <span class="rating">⭐ {{ $library->averageRating() }}</span>
        </p>
        <form action="{{ route('product.addToCart', $library->id) }}" method="POST" enctype="multipart/form-data"
          class="cart-form">
          @csrf
          <button type="submit" class="add-to-cart-button" data-stock="{{ $library->stock }}" style="border: none;">
          Add to Cart
          </button>
        </form>
        </div>
      </a>
      </div>
    @endforeach
    </div>
    <a href="{{ route('product.library') }}" class="view-all">View All <i class='bx bx-chevron-right'></i></a>
  </section>


  <!-- Categories -->
  <section class="categories">
    <h2>Browse by Category</h2>
    <div class="category-grid">

      <!-- Comedy -->
      <a href="{{ route('product.library', ['genre' => 'Comedy']) }}" class="category-card">
        <div class="category-icon">
          <i class='bx bx-laugh'></i>
        </div>
        <span class="category-name">Comedy</span>
      </a>

      <!-- Drama -->
      <a href="{{ route('product.library', ['genre' => 'Drama']) }}" class="category-card">
        <div class="category-icon">
          <i class='bx bx-mask'></i>
        </div>
        <span class="category-name">Drama</span>
      </a>

      <!-- Romance -->
      <a href="{{ route('product.library', ['genre' => 'Romance']) }}" class="category-card">
        <div class="category-icon">
          <i class='bx bx-heart'></i>
        </div>
        <span class="category-name">Romance</span>
      </a>

      <!-- Horror -->
      <a href="{{ route('product.library', ['genre' => 'Horror']) }}" class="category-card">
        <div class="category-icon">
          <i class='bx bx-ghost'></i>
        </div>
        <span class="category-name">Horror</span>
      </a>
    </div>
  </section>



  <!-- Sci  -->
  <section class="categories2">
    <div class="category-grid2">
      <a href="{{ route('product.library', ['genre' => 'Sci-Fi']) }}" class="category-card">
        <div class="category-icon">
          <i class='bx bx-planet'></i>
        </div>
        <span class="category-name">Sci-Fi</span>
      </a>

      <!-- Fantasy -->
      <a href="{{ route('product.library', ['genre' => 'Fantasy']) }}" class="category-card2">
        <div class="category-icon2">
          <i class='bx bx-star'></i>
        </div>
        <span class="category-name2">Fantasy</span>
      </a>

      <!-- Thriller -->
      <a href="{{ route('product.library', ['genre' => 'Thriller']) }}" class="category-card2">
        <div class="category-icon2">
          <img class="categori-icon2" src="https://th.bing.com/th/id/OIP.pE3Fj-nk1vC5L2HyD1_nCAHaHa?rs=1&pid=ImgDetMain"
            alt="Thriller">
        </div>
        <span class="category-name2">Thriller</span>
      </a>

      <!-- Mystery -->
      <a href="{{ route('product.library', ['genre' => 'Mystery']) }}" class="category-card2">
        <div class="category-icon2">
          <i class='bx bx-question-mark'></i>
        </div>
        <span class="category-name2">Mystery</span>
      </a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="home-footer">
    <div class="footer-content">
      <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} BookScape. All rights reserved.</p>

        <div class="contact-links">
          <a href="mailto:info@bookscape.com" class="contact-item">
            <i class='bx bx-envelope'></i>
            <span>info@bookscape.com</span>
          </a>
          <a href="tel:+1234567890" class="contact-item">
            <i class='bx bx-phone'></i>
            <span>+1 (234) 567-890</span>
          </a>
        </div>
      </div>
  </footer>
  </div>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
  <script>
    function toggleDropdown(event) {
      event.preventDefault();
      const dropdown = document.getElementById('profileDropdown');
      dropdown.classList.toggle('show');
    }
    document.addEventListener('click', function (event) {
      const dropdown = document.getElementById('profileDropdown');
      const toggleButton = document.querySelector('.profile-toggle');

      if (!toggleButton.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.classList.remove('show');
      }
    });
  </script>

  <script src="{{ asset('produk/js/new.js') }}"></script>
  <script src="{{ asset('produk/js/popup.js') }}"></script>
</body>

</html>