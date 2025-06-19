<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BookScape - Home</title>
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="{{ asset('user/home.css') }}">
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
        <a href="#" class="active">Home</a>
        <a href="#">Browse</a>
        <a href="#">Categories</a>
        <div class="cart-icon-container">
          <a href="#" class="cart-icon">
            <i class='bx bx-cart'></i>
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
                    <li><a href="#"><i class='bx bx-cart'></i> History Order</a></li>
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
          </a>
        </div>
        </a>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-content">
        <h1>WELCOME TO BOOKSCAPE</h1>
        <p>Explore thousands of books from all genres and find your perfect read</p>

        <div class="search-bar">
          <input type="text" placeholder="Search books, authors, or categories...">
          <button><i class='bx bx-search'></i></button>
        </div>
      </div>
    </section>

    <!-- New arrival -->
    <section class="featured-books">
      <h2>My Cart</h2>
      <div class="books-grid">
        <!-- Book 1 -->
        <div class="book-card book-card-1">
          <img class="book-cover book-cover-1"
            src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg"
            alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
          <div class="book-info">
            <h2 class="book-title">Skripsick</h2>
            <p class="book-genre">Comedy</p>
            <p class="book-price">Rp.40.00,00<span class="rating">⭐ 4.5</span></p>
            <a href="#" class="add-to-cart-button">Add to Cart</a>
          </div>
              
        </div>


        <!-- Book 2 -->
        <div class="book-card book-card-2">
          <img class="book-cover book-cover-1"
            src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg"
            alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
          <div class="book-info">
            <h2 class="book-title">Skripsick</h2>
            <p class="book-genre">Comedy</p>
            <p class="book-price">Rp.40.00,00<span class="rating">⭐ 4.5</span></p>
            <a href="#" class="add-to-cart-button">Add to Cart</a>
          </div>
              
        </div>

        <!-- Book 3 -->
        <div class="book-card book-card-3">
          <img class="book-cover book-cover-1"
            src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg"
            alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
          <div class="book-info">
            <h2 class="book-title">Skripsick</h2>
            <p class="book-genre">Comedy</p>
            <p class="book-price">Rp.40.00,00<span class="rating">⭐ 4.5</span></p>
            <a href="#" class="add-to-cart-button">Add to Cart</a>
          </div>
              
        </div>

        <!-- Book 4 -->
        <div class="book-card book-card-4">
          <img class="book-cover book-cover-1"
            src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg"
            alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
          <div class="book-info">
            <h2 class="book-title">Skripsick</h2>
            <p class="book-genre">Comedy</p>
            <p class="book-price">Rp.40.00,00<span class="rating">⭐ 4.5</span></p>
            <a href="#" class="add-to-cart-button">Add to Cart</a>
          </div>
              
        </div>

        <!-- Book 5 -->
        <div class="book-card book-card-4">
          <img class="book-cover book-cover-1"
            src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg"
            alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
          <div class="book-info">
            <h2 class="book-title">Skripsick</h2>
            <p class="book-genre">Comedy</p>
            <p class="book-price">Rp.40.00,00<span class="rating">⭐ 4.5</span></p>
            <a href="#" class="add-to-cart-button">Add to Cart</a>
          </div>
              
        </div>
      </div>
      <a href="#" class="view-all">View All <i class='bx bx-chevron-right'></i></a>
  </div>
  </section>


  <!-- New Arrival -->
  <section class="featured-books">
    <h2>New Arrival</h2>
    <div class="books-grid">
      <div class="book-card book-card-1">
        <img class="book-cover book-cover-1"
          src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg"
          alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
        <div class="book-info">
          <h2 class="book-title">Skripsick</h2>
          <p class="book-genre">Comedy</p>
          <p class="book-price">Rp.40.00,00 <span class="rating">⭐ 4.5</span></p>
          <a href="#" class="add-to-cart-button">Add to Cart</a>
        </div>
            
      </div>

      <!-- Book 2 -->
      <div class="book-card book-card-2">
        <img class="book-cover book-cover-1"
          src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg"
          alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
        <div class="book-info">
          <h2 class="book-title">Skripsick</h2>
          <p class="book-genre">Comedy</p>
          <p class="book-price">Rp.40.00,00<span class="rating">⭐ 4.5</span></p>
          <a href="#" class="add-to-cart-button">Add to Cart</a>
        </div>
            
      </div>

      <!-- Book 3 -->
      <div class="book-card book-card-3">
        <img class="book-cover book-cover-1"
          src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg"
          alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
        <div class="book-info">
          <h2 class="book-title">Skripsick</h2>
          <p class="book-genre">Comedy</p>
          <p class="book-price">Rp.40.00,00<span class="rating">⭐ 4.5</span></p>
          <a href="#" class="add-to-cart-button">Add to Cart</a>
        </div>
            
      </div>

      <!-- Book 4 -->
      <div class="book-card book-card-4">
        <img class="book-cover book-cover-1"
          src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg"
          alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
        <div class="book-info">
          <h2 class="book-title">Skripsick</h2>
          <p class="book-genre">Comedy</p>
          <p class="book-price">Rp.40.00,00<span class="rating">⭐ 4.5</span></p>
          <a href="#" class="add-to-cart-button">Add to Cart</a>
        </div>
            
      </div>

      <!-- Book 5 -->
      <div class="book-card book-card-5">
        <img class="book-cover book-cover-1"
          src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg"
          alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
        <div class="book-info">
          <h2 class="book-title">Skripsick</h2>
          <p class="book-genre">Comedy</p>
          <p class="book-price">Rp.40.00,00<span class="rating">⭐ 4.5</span></p>
          <a href="#" class="add-to-cart-button">Add to Cart</a>
        </div>
            
      </div>
    </div>
    </div>
  </section>

  <!-- Best Seller -->
  <section class="featured-books">
    <h2>Best Seller</h2>
    <div class="books-grid">
      <!-- Best seller -->
      <div class="book-card book-card-1">
        <img class="book-cover book-cover-1"
          src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg"
          alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
        <div class="book-info">
          <h2 class="book-title">Skripsick</h2>
          <p class="book-genre">Comedy</p>
          <p class="book-price">Rp.40.00,00 <span class="rating">⭐ 4.5</span></p>
          <a href="#" class="add-to-cart-button">Add to Cart</a>
        </div>
            
      </div>

      <!-- Book 2 -->
      <div class="book-card book-card-2">
        <img class="book-cover book-cover-1"
          src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg"
          alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
        <div class="book-info">
          <h2 class="book-title">Skripsick</h2>
          <p class="book-genre">Comedy</p>
          <p class="book-price">Rp.40.00,00<span class="rating">⭐ 4.5</span></p>
          <a href="#" class="add-to-cart-button">Add to Cart</a>
        </div>
            
      </div>

      <!-- Book 3 -->
      <div class="book-card book-card-3">
        <img class="book-cover book-cover-1"
          src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg"
          alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
        <div class="book-info">
          <h2 class="book-title">Skripsick</h2>
          <p class="book-genre">Comedy</p>
          <p class="book-price">Rp.40.00,00<span class="rating">⭐ 4.5</span></p>
          <a href="#" class="add-to-cart-button">Add to Cart</a>
        </div>
            
      </div>

      <!-- Book 4 -->
      <div class="book-card book-card-4">
        <img class="book-cover book-cover-1"
          src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg"
          alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
        <div class="book-info">
          <h2 class="book-title">Skripsick</h2>
          <p class="book-genre">Comedy</p>
          <p class="book-price">Rp.40.00,00<span class="rating">⭐ 4.5</span></p>
          <a href="#" class="add-to-cart-button">Add to Cart</a>
        </div>
            
      </div>

      <!-- Book 5 -->
      <div class="book-card book-card-5">
        <img class="book-cover book-cover-1"
          src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg"
          alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
        <div class="book-info">
          <h2 class="book-title">Skripsick</h2>
          <p class="book-genre">Comedy</p>
          <p class="book-price">Rp.40.00,00<span class="rating">⭐ 4.5</span></p>
          <a href="#" class="add-to-cart-button">Add to Cart</a>
        </div>
            
      </div>
    </div>
    </div>
  </section>

  <section class="featured-books">
    <h2>Library</h2>
    <div class="books-grid">
      <!-- Best seller -->
      <div class="book-card book-card-1">
        <img class="book-cover book-cover-1"
          src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg"
          alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
        <div class="book-info">
          <h2 class="book-title">Skripsick</h2>
          <p class="book-genre">Comedy</p>
          <p class="book-price">Rp.40.00,00 <span class="rating">⭐ 4.5</span></p>
          <a href="#" class="add-to-cart-button">Add to Cart</a>
        </div>
            
      </div>

      <!-- Book 2 -->
      <div class="book-card book-card-2">
        <img class="book-cover book-cover-1"
          src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg"
          alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
        <div class="book-info">
          <h2 class="book-title">Skripsick</h2>
          <p class="book-genre">Comedy</p>
          <p class="book-price">Rp.40.00,00<span class="rating">⭐ 4.5</span></p>
          <a href="#" class="add-to-cart-button">Add to Cart</a>
        </div>
            
      </div>

      <!-- Book 3 -->
      <div class="book-card book-card-3">
        <img class="book-cover book-cover-1"
          src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg"
          alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
        <div class="book-info">
          <h2 class="book-title">Skripsick</h2>
          <p class="book-genre">Comedy</p>
          <p class="book-price">Rp.40.00,00<span class="rating">⭐ 4.5</span></p>
          <a href="#" class="add-to-cart-button">Add to Cart</a>
        </div>
            
      </div>

      <!-- Book 4 -->
      <div class="book-card book-card-4">
        <img class="book-cover book-cover-1"
          src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg"
          alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
        <div class="book-info">
          <h2 class="book-title">Skripsick</h2>
          <p class="book-genre">Comedy</p>
          <p class="book-price">Rp.40.00,00<span class="rating">⭐ 4.5</span></p>
          <a href="#" class="add-to-cart-button">Add to Cart</a>
        </div>
            
      </div>

      <!-- Book 5 -->
      <div class="book-card book-card-5">
        <img class="book-cover book-cover-1"
          src="https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1394359102i/21408196.jpg"
          alt="Skripsick: Derita Mahasiswa Abadi" class="book-cover">
        <div class="book-info">
          <h2 class="book-title">Skripsick</h2>
          <p class="book-genre">Comedy</p>
          <p class="book-price">Rp.40.00,00<span class="rating">⭐ 4.5</span></p>
          <a href="#" class="add-to-cart-button">Add to Cart</a>
        </div>
            
      </div>
    </div>
    </div>
    <a href="#" class="view-all">View All <i class='bx bx-chevron-right'></i></a>
  </section>


  <!-- Categories -->
  <section class="categories">
    <h2>Browse by Category</h2>
    <div class="category-grid">

      <!-- Comedy -->
      <a href="#" class="category-card">
        <div class="category-icon">
          <i class='bx bx-laugh'></i>
        </div>
        <span class="category-name">Comedy</span>
      </a>

      <!-- Drama -->
      <a href="#" class="category-card">
        <div class="category-icon">
          <i class='bx bx-mask'></i>
        </div>
        <span class="category-name">Drama</span>
      </a>

      <!-- Romance -->
      <a href="#" class="category-card">
        <div class="category-icon">
          <i class='bx bx-heart'></i>
        </div>
        <span class="category-name">Romance</span>
      </a>

      <!-- Horror -->
      <a href="#" class="category-card">
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
      <a href="#" class="category-card">
        <div class="category-icon">
          <i class='bx bx-planet'></i>
        </div>
        <span class="category-name">Sci </span>
      </a>

      <!-- Fantasy -->
      <a href="#" class="category-card2">
        <div class="category-icon2">
          <i class='bx bx-star'></i>
        </div>
        <span class="category-name2">Fantasy</span>
      </a>

      <!-- Thriller -->
      <a href="#" class="category-card2">
        <div class="category-icon2">
          <img class="categori-icon2" src="https://th.bing.com/th/id/OIP.pE3Fj-nk1vC5L2HyD1_nCAHaHa?rs=1&pid=ImgDetMain"
            alt="Thriller">
        </div>
        <span class="category-name2">Thriller</span>
      </a>

      <!-- Mystery -->
      <a href="#" class="category-card2">
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
</body>

</html>