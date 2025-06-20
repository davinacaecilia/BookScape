function showAddToCartPopup(isBookInStock) {
  if (isBookInStock) {
    // Popup untuk stok tersedia (berhasil)
    Swal.fire({
      title: 'Berhasil!',
      text: 'Buku telah dimasukkan ke keranjang.',
      icon: 'success',
      showCancelButton: true,
      confirmButtonText: 'Lanjutkan Belanja',
      cancelButtonText: 'Cek Keranjang',
      reverseButtons: true,
      background: 'var(--dark-brown)',
      color: 'var(--text-light)',
      confirmButtonColor: 'var(--medium-brown)',
      cancelButtonColor: 'var(--medium-brown)',
      customClass: {
        popup: 'custom-swal-popup',
        title: 'custom-swal-title',
        content: 'custom-swal-content',
        confirmButton: 'custom-swal-confirm-button',
        cancelButton: 'custom-swal-cancel-button'
      }
    }).then((result) => {
      if (result.dismiss === Swal.DismissReason.cancel) {
        window.location.href = '/cart';
      }
    });
  } else {
    // Popup untuk stok habis (gagal)
    Swal.fire({
      title: 'Stok Habis!',
      text: 'Gagal memasukkan ke keranjang.',
      icon: 'error',
      confirmButtonText: 'Oke',
      background: '#D93644', 
      color: 'var(--text-light)',
      confirmButtonColor: 'white',
      customClass: {
          popup: 'custom-swal-popup',
          title: 'custom-swal-title',
          content: 'custom-swal-content',
          confirmButton: 'custom-swal-confirm-button'
      }
    });
  }
}