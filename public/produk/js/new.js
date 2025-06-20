document.addEventListener('DOMContentLoaded', function () {
  // --- DROPDOWN KATEGORI ---
  const toggleBtn = document.getElementById('categoryToggle');
  const categoryMenu = document.getElementById('categoryMenu');
  const arrowIcon = document.getElementById('arrow');

  toggleBtn?.addEventListener('click', function (e) {
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

  // --- ADD TO CART FORM ---
  const forms = document.querySelectorAll('.cart-form');

  forms.forEach(form => {
    form.addEventListener('submit', function (e) {
      e.preventDefault();

      const button = form.querySelector('.add-to-cart-button');
      const stock = parseInt(button.dataset.stock);

      if (!stock || stock <= 0) {
        showAddToCartPopup(false);
        return;
      }

      const formData = new FormData(form);

      fetch(form.action, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json'
        },
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if (data.message === 'Berhasil ditambahkan ke keranjang') {
          showAddToCartPopup(true);
        } else {
          showAddToCartPopup(false);
        }
      })
      .catch(err => {
        console.error(err);
        showAddToCartPopup(false);
      });
    });
  });

  // --- BOOK CARD CLICK (NAVIGASI DETAIL) ---
  const bookCards = document.querySelectorAll('.book-card');

  bookCards.forEach(card => {
    card.addEventListener('click', function (e) {
      if (e.target.closest('.add-to-cart-button')) return;

      const productId = this.dataset.id;
      window.location.href = `/product/detail/${productId}`;
    });
  });
});
