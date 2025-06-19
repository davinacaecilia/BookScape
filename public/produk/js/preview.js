    // --- KODE UNTUK TOMBOL CART ---
    const addToCartButton = document.getElementById('add-to-cart-button');

    if (addToCartButton) {
      addToCartButton.addEventListener('click', function() {
        showAddToCartPopup(isBookInStockPreview);
      });
    }

    // --- KODE BARU UNTUK TOMBOL "BUY NOW" ---
  const buyNowButton = document.getElementById('buy-now-button');

  if (buyNowButton) {
    buyNowButton.addEventListener('click', function() {
      window.location.href = '/order-cart';
    });
  }
