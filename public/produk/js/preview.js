    // --- KODE UNTUK TOMBOL CART ---
    const forms = document.querySelectorAll('.cart-form');

      forms.forEach(form => {
      form.addEventListener('submit', function (e) {
        e.preventDefault();

        const button = form.querySelector('#add-to-cart-button');
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

    // --- KODE BARU UNTUK TOMBOL "BUY NOW" ---
  const buyNowButton = document.getElementById('buy-now-button');

  if (buyNowButton) {
    buyNowButton.addEventListener('click', function() {
      window.location.href = '/order-cart';
    });
  }
