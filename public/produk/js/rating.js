// public/produk/js/rating.js

document.addEventListener('DOMContentLoaded', function() {
    // Ambil semua input radio untuk rating
    const ratingInputs = document.querySelectorAll('.stars input[name="rating"]');
    
    // Ambil tombol submit
    const submitButton = document.querySelector('.submit-review-btn');

    // Fungsi untuk mengaktifkan tombol submit
    function enableSubmitButton() {
        // Cek apakah ada bintang yang sudah dipilih
        const isStarSelected = document.querySelector('input[name="rating"]:checked');

        // Jika ada bintang yang dipilih
        if (isStarSelected) {
            // Aktifkan tombolnya (hapus atribut disabled)
            submitButton.disabled = false;
        }
        // Tidak ada 'else', jadi tombol akan tetap aktif setelah diaktifkan
    }

    // Tambahkan event listener ke setiap radio button bintang
    // Setiap kali pengguna mengubah pilihan bintang, kita panggil fungsinya
    ratingInputs.forEach(input => {
        input.addEventListener('change', enableSubmitButton);
    });

    // PENTING: KITA TIDAK MEMBUTUHKAN EVENT LISTENER UNTUK TOMBOL SUBMIT.
    // Kita ingin browser melakukan aksi default-nya, yaitu men-submit form.
});