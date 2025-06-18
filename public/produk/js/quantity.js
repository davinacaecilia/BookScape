 // --- Fungsionalitas Tombol Kuantitas (+/-) ---
    const cartCards = document.querySelectorAll('.cart-card, .detail-orderan');


    cartCards.forEach(card => {
      // Untuk setiap kartu, dapatkan tombol minus, display kuantitas, dan tombol plus
      const minusBtn = card.querySelector('.minus-btn');
      const plusBtn = card.querySelector('.plus-btn');
      const quantityDisplay = card.querySelector('.quantity-display');

      // Tambahkan event listener untuk tombol Plus
      if (plusBtn) {
        plusBtn.addEventListener('click', () => {
          let currentQuantity = parseInt(quantityDisplay.textContent);
          currentQuantity++; // Tambah 1
          quantityDisplay.textContent = currentQuantity;
          // Di sini Anda mungkin ingin memanggil fungsi untuk memperbarui total harga
        });
      }

      // Tambahkan event listener untuk tombol Minus
      if (minusBtn) {
        minusBtn.addEventListener('click', () => {
          let currentQuantity = parseInt(quantityDisplay.textContent);
          if (currentQuantity > 0) { // Pastikan tidak kurang dari 0
            currentQuantity--; // Kurang 1
            quantityDisplay.textContent = currentQuantity;
            // Di sini Anda mungkin ingin memanggil fungsi untuk memperbarui total harga
          }
        });
      }
    });
