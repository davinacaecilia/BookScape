document.addEventListener('DOMContentLoaded', function() {
      // Pilih semua tombol yang memiliki kelas 'status' dan 'completed'
      const completedStatusButtons = document.querySelectorAll('.status.completed');

      // Iterasi (loop) melalui setiap tombol 'completed' yang ditemukan
      completedStatusButtons.forEach(button => {
        // Tambahkan event listener untuk klik pada setiap tombol 'completed'
        button.addEventListener('click', function() {
          // Ketika tombol 'completed' diklik, alihkan ke halaman 'ratings.html'
          window.location.href = 'rating';
        });
      });
    });
