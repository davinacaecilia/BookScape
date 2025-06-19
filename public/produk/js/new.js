//kode dropdown
  const toggleBtn = document.getElementById('categoryToggle');
  const categoryMenu = document.getElementById('categoryMenu');
  const arrowIcon = document.getElementById('arrow');

  toggleBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    categoryMenu.classList.toggle('show');
    arrowIcon.classList.toggle('rotate');
    toggleBtn.classList.toggle('active');
  });

  document.addEventListener('click', function (e) {
    if (!categoryMenu.contains(e.target) && e.target !== toggleBtn) {
      categoryMenu.classList.remove('show');
      arrowIcon.classList.remove('rotate');
      toggleBtn.classList.remove('active');
    }
  });
  //akhir dropdown

  // --- KARTU BUKU ---
  const bookCards = document.querySelectorAll('.book-card');

  bookCards.forEach(card => {
    card.addEventListener('click', function() {
      const productId = this.dataset.id;
      window.location.href = `/product/detail/${productId}`;
    });
  });

  // --- KODE UNTUK TOMBOL "ADD TO CART ---
  const addToCartButtons = document.querySelectorAll('.add-to-cart-button');
  addToCartButtons.forEach(button => {
    button.addEventListener('click', function(event) {
      event.stopPropagation(); // Tetap penting agar tidak memicu klik kartu

      const isBookInStockProduk = false;

      showAddToCartPopup(isBookInStockProduk);
    });
  });
