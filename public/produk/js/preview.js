   // Ubah nilai ini untuk menguji skenario yang berbeda di halaman preview.html
    const isBookInStockPreview = false;

    // --- KODE LAMA UNTUK NAVIGASI PANAH KIRI/KANAN ---
    const prevArrow = document.querySelector('.prev-arrow');
    const nextArrow = document.querySelector('.next-arrow');
    if (prevArrow) {
      prevArrow.addEventListener('click', function() {
        window.location.href = 'produk.html';
      });
    }
    if (nextArrow) {
      nextArrow.addEventListener('click', function() {
        window.location.href = 'produk.html';
      });
    }

    // --- KODE UNTUK TOMBOL CART ---
    const addToCartButton = document.getElementById('add-to-cart-button');

    if (addToCartButton) {
      addToCartButton.addEventListener('click', function() {
        showAddToCartPopup(isBookInStockPreview); // Panggil fungsi dari popup.js
      });
    }

    // --- KODE BARU UNTUK TOMBOL "BUY NOW" ---
  const buyNowButton = document.getElementById('buy-now-button');

  if (buyNowButton) {
    buyNowButton.addEventListener('click', function() {
      // Arahkan pengguna ke halaman pembayaran
      window.location.href = 'orderNow.html'; // Pastikan Anda memiliki file payment.html
    });
  }
