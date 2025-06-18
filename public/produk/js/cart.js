 // --- Fungsionalitas Select All Items & Delete Selected ---
    const selectAllCheckbox = document.getElementById('selectAllItems');
    // Perhatikan: itemCheckboxes harus di-query ulang setelah item dihapus
    // karena DOM berubah. Untuk inisialisasi awal, ini cukup.
    let itemCheckboxes = document.querySelectorAll('.cart-card .item-checkbox');
    const deleteAllSelectedButton = document.querySelector('.delete-selected-btn');

    // Fungsi untuk memperbarui status tombol "Delete Selected"
    function updateDeleteButtonState() {
      // Periksa apakah ada checkbox item yang tercentang
      const anyItemSelected = Array.from(itemCheckboxes).some(checkbox => checkbox.checked);

      if (anyItemSelected) {
        deleteAllSelectedButton.removeAttribute('disabled'); // Aktifkan tombol
      } else {
        deleteAllSelectedButton.setAttribute('disabled', 'true'); // Nonaktifkan tombol
      }
    }

    // Fungsi untuk menghapus item yang dipilih dari keranjang
    function removeSelectedItems() {
      const selectedItems = Array.from(itemCheckboxes).filter(checkbox => checkbox.checked);

      selectedItems.forEach(checkbox => {
        const cartCard = checkbox.closest('.cart-card'); // Dapatkan elemen kartu terdekat
        if (cartCard) {
          cartCard.remove(); // Hapus kartu dari DOM
        }
      });

      // Setelah menghapus item, kita perlu memperbarui NodeList itemCheckboxes
      // agar tidak mencoba mengakses elemen yang sudah tidak ada
      itemCheckboxes = document.querySelectorAll('.cart-card .item-checkbox');

      // Jika selectAllCheckbox sebelumnya tercentang, batalkan centangnya
      // karena tidak semua item mungkin ada lagi atau terpilih
      if (selectAllCheckbox && selectAllCheckbox.checked) {
        selectAllCheckbox.checked = false;
      }

      // Perbarui status tombol Delete Selected setelah penghapusan
      updateDeleteButtonState();

      // Opsional: Tampilkan pesan "Keranjang kosong" jika tidak ada item tersisa
      // Anda perlu memiliki elemen HTML yang sesuai untuk ini.
      const cartItemsContainer = document.querySelector('.cart-items-container');
      if (itemCheckboxes.length === 0 && cartItemsContainer) {
          let emptyCartMessage = document.createElement('p');
          emptyCartMessage.textContent = 'Keranjang Anda kosong.';
          emptyCartMessage.style.textAlign = 'center';
          emptyCartMessage.style.marginTop = '20px';
          emptyCartMessage.style.color = 'var(--text-dark)';
          emptyCartMessage.style.fontSize = '1.2em';

          // Hapus semua konten yang mungkin tersisa di cartItemsContainer
          cartItemsContainer.innerHTML = '';
          cartItemsContainer.appendChild(emptyCartMessage);
      }

      // updateCartTotal(); // <-- Panggil fungsi untuk memperbarui total harga jika ada
    }

    // Event listener untuk checkbox "Select All"
    if (selectAllCheckbox) {
      selectAllCheckbox.addEventListener('change', (event) => {
        const isChecked = event.target.checked;
        itemCheckboxes.forEach(checkbox => {
          checkbox.checked = isChecked;
        });
        updateDeleteButtonState(); // Perbarui status tombol setelah mengubah semua checkbox
      });
    }

    // Event listeners untuk setiap checkbox item individual
    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            // Periksa apakah semua item tercentang untuk memperbarui "Select All"
            const allItemsChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
            if (selectAllCheckbox) { // Pastikan selectAllCheckbox ada
                selectAllCheckbox.checked = allItemsChecked;
            }
            updateDeleteButtonState(); // Perbarui status tombol saat item individu diubah
        });
    });

    // Event listener untuk tombol "Delete Selected"
    if (deleteAllSelectedButton) {
      deleteAllSelectedButton.addEventListener('click', () => {
        // Hanya tampilkan popup jika tombol tidak disabled (bisa diklik)
        if (!deleteAllSelectedButton.hasAttribute('disabled')) {
          Swal.fire({
            title: 'Hapus Produk',
            text: 'Produk yang dihapus akan hilang dari keranjang.',
            icon: 'warning', // Ikon peringatan
            showCancelButton: true,
            confirmButtonColor: '#d33', // Warna merah untuk tombol "Hapus"
            cancelButtonColor: 'gray', // Warna cokelat untuk tombol "Kembali"
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Kembali'
          }).then((result) => {
            if (result.isConfirmed) {
              // Jika pengguna mengklik "Hapus" (confirm)
              removeSelectedItems(); // Panggil fungsi untuk menghapus item
              Swal.fire(
                'Dihapus!',
                'Produk telah dihapus dari keranjang.',
                'success' // Ikon sukses
              );
            }
            // Jika result.isDismissed, tidak melakukan apa-apa (pengguna klik kembali/di luar popup)
          });
        }
      });
    }

    // Inisialisasi status tombol saat halaman pertama kali dimuat
    document.addEventListener('DOMContentLoaded', () => {
        updateDeleteButtonState();
    });

    // --- Fungsionalitas Hapus Item Individual (TRASH ICON) ---
const individualDeleteButtons = document.querySelectorAll('.item-delete-btn');

individualDeleteButtons.forEach(button => {
    button.addEventListener('click', (event) => {
        const cartCardToRemove = event.target.closest('.cart-card');

        if (cartCardToRemove) {
            Swal.fire({
                title: 'Hapus Item Ini?',
                text: 'Item ini akan dihapus dari keranjang Anda.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: 'gray',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    cartCardToRemove.remove();

                    // Perbarui itemCheckboxes setelah penghapusan
                    itemCheckboxes = document.querySelectorAll('.cart-card .item-checkbox');

                    // Perbarui status checkbox "Select All"
                    if (itemCheckboxes.length > 0) {
                        const allRemainingItemsChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
                        if (selectAllCheckbox) {
                            selectAllCheckbox.checked = allRemainingItemsChecked;
                        }
                    } else {
                        if (selectAllCheckbox) {
                            selectAllCheckbox.checked = false;
                        }
                    }

                    updateDeleteButtonState();
                    Swal.fire(
                        'Dihapus!',
                        'Item telah dihapus dari keranjang.',
                        'success'
                    );
                    displayEmptyCartMessage(); // Perbarui pesan keranjang kosong
                    // updateCartTotal(); // Jika ada
                }
            });
        }
    });
});

// Inisialisasi status tombol dan pesan keranjang kosong saat halaman pertama kali dimuat
document.addEventListener('DOMContentLoaded', () => {
    updateDeleteButtonState();
    displayEmptyCartMessage(); // Panggil saat memuat untuk mengecek keranjang kosong
});
