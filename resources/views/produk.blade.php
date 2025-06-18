<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Library Books</title>
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/styleList.css') }}"/>
</head>
<body>
  <header class="header">
    <div class="header-left">
    <i class="bx bx-arrow-back back-icon"></i>
    <span class="category-title">Library</span>
    </div>
    <div class="header-right">
        <div class="header-right">
  <div class="header-right-inner">
   <div class="category-dropdown">
  <button class="category-button" id="categoryToggle">
    Categories <span class="arrow" id="arrow">&#9660;</span>
  </button>
  <div class="category-menu" id="categoryMenu">
        <a href="#">Comedy</a>
        <a href="#">Drama</a>
        <a href="#">Romance</a>
        <a href="#">Horror</a>
        <a href="#">Sci-Fi</a>
        <a href="#">Fantasy</a>
        <a href="#">Thriller</a>
        <a href="#">Mystery</a>
      </div>
    </div>
    <div class="search-bar">
          <input type="text" placeholder="Search books, authors, or categories...">
          <button><i class='bx bx-search'></i></button>
        </div>
      </div>
    {{-- Ikon Kanan --}}
    <div class="nav-icons">
      <div class="notification-icon">
        <i class="fas fa-bell"></i>
        <span class="notification-badge">3</span>
      </div>

      <div class="shopping-cart">
        <i class="fas fa-shopping-cart"></i>
        <span class="cart-count">2</span>
      </div>

      <div class="profile-icon">
        <i class="fas fa-user"></i>
      </div>
    </div>
  </div>
</div>
    </div>
  </header>

  <main class="book-grid">
    <!-- Book 1 -->
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

    <div class="book-card">
      <img src="https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/9789797809157_9789797809157.jpg" alt="Ubur-Ubur Lembur" class="book-cover">
      <div class="book-info">
        <h2 class="book-title">Ubur-Ubur Lembur</h2>
        <p class="book-genre">COMEDY <span class="rating">⭐ 4.6</span></p>
        <p class="book-price">Rp.66.00,00</p>
        <a href="#" class="add-to-cart-button">Add to Cart</a>
      </div>
    </div>

    <div class="book-card">
      <img src="https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/9789797808990_Koala-Kumal-Edisi-Revisi.jpg" alt="Koala Kumal" class="book-cover">
      <div class="book-info">
        <h2 class="book-title">Koala Kumal</h2>
        <p class="book-genre">COMEDY <span class="rating">⭐ 4.8</span></p>
        <p class="book-price">Rp.67.00,00</p>
        <a href="#" class="add-to-cart-button">Add to Cart</a>
      </div>
    </div>

    <div class="book-card">
      <img src="https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/9789797808983_Manusia-Seten.jpg" alt="Manusia Setengah Salmon" class="book-cover">
      <div class="book-info">
        <h2 class="book-title">Manusia Setengah Salmon</h2>
        <p class="book-genre">COMEDY, ROMANCE <span class="rating">⭐ 4.6</span></p>
        <p class="book-price">Rp.79.00,00</p>
        <a href="#" class="add-to-cart-button">Add to Cart</a>
      </div>
    </div>

    <div class="book-card">
      <img src="https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/9786022202325C_9786022202325.jpg" alt="Catching Fire" class="book-cover">
      <div class="book-info">
        <h2 class="book-title">Marmut Merah Jambu</h2>
        <p class="book-genre">COMEDY <span class="rating">⭐ 4.6</span></p>
        <p class="book-price">Rp.60.00,00</p>
        <a href="#" class="add-to-cart-button">Add to Cart</a>
      </div>
    </div>

    <div class="book-card">
      <img src="https://image.gramedia.net/rs:fit:0:0/plain/https://cdn.gramedia.com/uploads/items/9786021456866_warkop_dki_reborn_jangkrik_boss_part-1.jpg" alt="Warkop DKI Reborn" class="book-cover">
      <div class="book-info">
        <h2 class="book-title">Warkop DKI Reborn</h2>
        <p class="book-genre">COMEDY, MYSTERY <span class="rating">⭐ 4.7</span></p>
        <p class="book-price">Rp.60.00,00</p>
        <a href="#" class="add-to-cart-button">Add to Cart</a>
      </div>
    </div>
  </main>

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

  <script>
  const toggleBtn = document.getElementById('categoryToggle');
  const categoryMenu = document.getElementById('categoryMenu');
  const arrowIcon = document.getElementById('arrow');

  toggleBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    categoryMenu.classList.toggle('show');
    arrowIcon.classList.toggle('rotate');
  });

  document.addEventListener('click', function (e) {
    if (!toggleBtn.contains(e.target)) {
      categoryMenu.classList.remove('show');
      arrowIcon.classList.remove('rotate');
    }
  });
</script>

</body>
</html>

