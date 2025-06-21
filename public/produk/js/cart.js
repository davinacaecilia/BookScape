window.updateCartSummary = function () {
  let total = 0;
  let totalQty = 0;

  document.querySelectorAll('.cart-card').forEach(card => {
    const checkbox = card.querySelector('.item-checkbox');
    if (!checkbox || !checkbox.checked) return;

    const priceText = card.querySelector('.item-price')?.innerText || '0';
    const price = parseInt(priceText.replace(/[^0-9]/g, ''));

    const qtyText = card.querySelector('.quantity-display')?.innerText || '1';
    const quantity = parseInt(qtyText);

    total += price * quantity;
    totalQty += quantity;
  });

  const summaryLabel = document.querySelector('.summary-line .summary-label');
  const summaryValue = document.querySelectorAll('.summary-value');

  if (summaryLabel) summaryLabel.innerText = `Total harga (${totalQty} barang)`;
  summaryValue.forEach(el => el.innerText = `Rp ${total.toLocaleString('id-ID')}`);
};


document.addEventListener('DOMContentLoaded', () => {
   const selectAllCheckbox = document.getElementById('selectAllItems');
  let itemCheckboxes = document.querySelectorAll('.cart-card .item-checkbox');
  const deleteAllSelectedButton = document.querySelector('.delete-selected-btn');
  const checkoutForm = document.getElementById('checkout-form');
  const hiddenInput = document.getElementById('selectedCartIds');

  function updateDeleteButtonState() {
    const anyItemSelected = Array.from(itemCheckboxes).some(checkbox => checkbox.checked);
    if (anyItemSelected) {
      deleteAllSelectedButton.removeAttribute('disabled');
    } else {
      deleteAllSelectedButton.setAttribute('disabled', 'true');
    }
  }

  function displayEmptyCartMessage() {
    const cartItemsContainer = document.querySelector('.cart-items-container');
    itemCheckboxes = document.querySelectorAll('.cart-card .item-checkbox');

    if (itemCheckboxes.length === 0 && cartItemsContainer) {
      let emptyCartMessage = document.createElement('p');
      emptyCartMessage.textContent = 'Keranjang Anda kosong.';
      emptyCartMessage.style.textAlign = 'center';
      emptyCartMessage.style.marginTop = '20px';
      emptyCartMessage.style.color = 'var(--text-dark)';
      emptyCartMessage.style.fontSize = '1.2em';
      cartItemsContainer.innerHTML = '';
      cartItemsContainer.appendChild(emptyCartMessage);
    }
  }

  // --- DELETE INDIVIDU PAKAI FORM ---
  document.querySelectorAll('.delete-cart-form').forEach(form => {
    const button = form.querySelector('.item-delete-btn');
    button.addEventListener('click', function (e) {
      e.preventDefault();

      Swal.fire({
        title: 'Hapus Item Ini?',
        text: 'Item ini akan dihapus dari keranjang Anda.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: 'gray',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });

  // --- DELETE SELECTED PAKAI FORM ---
  // --- DELETE SELECTED PAKAI AJAX ---
  if (deleteAllSelectedButton) {
    deleteAllSelectedButton.addEventListener('click', () => {
      // Mengambil semua ID keranjang dari item yang dicentang
      const selectedCartIds = Array.from(itemCheckboxes)
        .filter(cb => cb.checked) // Filter hanya yang dicentang
        .map(cb => cb.closest('.cart-card').dataset.id); // Ambil nilai data-id dari elemen .cart-card

      if (selectedCartIds.length === 0) return; // Jika tidak ada yang dipilih, hentikan

      Swal.fire({
        title: 'Hapus Produk',
        text: 'Produk yang dipilih akan dihapus dari keranjang.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: 'gray',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          fetch('/cart/delete-selected', { // Mengirim permintaan ke rute baru untuk penghapusan massal
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, // Token CSRF untuk keamanan
              'Content-Type': 'application/json', // Menentukan tipe konten sebagai JSON
              'Accept': 'application/json'
            },
            body: JSON.stringify({ cart_ids: selectedCartIds }) // Mengirim array ID dalam format JSON
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              Swal.fire('Dihapus!', 'Produk yang dipilih telah dihapus.', 'success').then(() => {
                location.reload(); // Memuat ulang halaman untuk memperbarui tampilan keranjang
              });
            } else {
              Swal.fire('Gagal!', data.message || 'Gagal menghapus produk.', 'error');
            }
          })
          .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error!', 'Terjadi kesalahan saat menghapus produk.', 'error');
          });
        }
      });
    });
  }

    if (checkoutForm) {
    checkoutForm.addEventListener('submit', function (e) {
      const selectedIds = [];
      let stockError = false; // Flag untuk menandai kesalahan stok
      let errorMessage = '';

      document.querySelectorAll('.cart-card').forEach(card => {
        const checkbox = card.querySelector('.item-checkbox');
        if (checkbox && checkbox.checked) {
          const quantityDisplay = card.querySelector('.quantity-display');
          const quantity = parseInt(quantityDisplay?.textContent || '1'); // Kuantitas yang diinginkan user
          
          // Asumsi Anda sudah menambahkan data-stock="{{ $item->buku->stock }}" di .cart-card
          const availableStock = parseInt(card.dataset.stock || '0'); 
          
          const bookTitle = card.querySelector('h4')?.textContent || 'Buku Tidak Dikenal'; // Ambil judul buku untuk pesan error

          if (availableStock === 0) {
            stockError = true;
            errorMessage = `Stok buku "${bookTitle}" sudah habis. Mohon hapus dari keranjang atau kurangi jumlahnya.`;
          } else if (quantity > availableStock) {
            stockError = true;
            errorMessage = `Kuantitas buku "${bookTitle}" (${quantity}) melebihi stok yang tersedia (${availableStock}).`;
          }

          if (!stockError) { // Hanya tambahkan ke selectedIds jika tidak ada masalah stok
            selectedIds.push(card.dataset.id);
          }
        }
      });

      if (stockError) {
        e.preventDefault(); // Gagalkan submit
        Swal.fire({
            icon: 'error',
            title: 'Stok Tidak Cukup!',
            text: errorMessage,
            confirmButtonText: 'OK'
        });
        return;
      }

      if (selectedIds.length === 0) {
        e.preventDefault(); // Gagalkan submit
        Swal.fire('Oops!', 'Pilih setidaknya satu item untuk checkout.', 'warning');
        return;
      }

      hiddenInput.value = selectedIds.join(','); // kirim sebagai string dipisah koma
    });
  }

  // --- SELECT ALL ---
  if (selectAllCheckbox) {
    selectAllCheckbox.addEventListener('change', (e) => {
      const isChecked = e.target.checked;
      itemCheckboxes.forEach(checkbox => checkbox.checked = isChecked);
      updateDeleteButtonState();
      updateCartSummary();
    });
  }

  // --- PER ITEM CHECKBOX ---
  itemCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', () => {
      const allItemsChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
      if (selectAllCheckbox) {
        selectAllCheckbox.checked = allItemsChecked;
      }
      updateDeleteButtonState();
      updateCartSummary();
    });
  });

  checkoutForm.addEventListener('submit', function (e) {
    const selectedIds = [];

    document.querySelectorAll('.cart-card').forEach(card => {
      const checkbox = card.querySelector('.item-checkbox');
      if (checkbox && checkbox.checked) {
        selectedIds.push(card.dataset.id);
      }
    });

    if (selectedIds.length === 0) {
      e.preventDefault(); // Gagalkan submit
      Swal.fire('Oops!', 'Pilih setidaknya satu item untuk checkout.', 'warning');
      return;
    }

    hiddenInput.value = selectedIds.join(','); // kirim sebagai string dipisah koma
  });


  updateDeleteButtonState();
  window.updateCartSummary(); // Panggil saat halaman dimuat
  displayEmptyCartMessage();
});
