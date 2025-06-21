function confirmDelete(event) {
    // Dapatkan form yang memicu event ini
    const form = event.target;

    // Tampilkan konfirmasi bawaan browser
    if (!confirm("Are You Sure Want to Delete This Product?")) {
        // Jika user memilih "Cancel" (false), cegah submit form
        event.preventDefault();
        return false;
    }

    // Jika user memilih "OK" (true), JANGAN cegah submit form lagi
    // Form akan otomatis disubmit karena ini adalah tombol type="submit" di dalam form
    // dan kita tidak memanggil event.preventDefault() di sini jika user klik OK.

    // Baris ini (untuk simulasi frontend) HARUS DIHAPUS jika Anda ingin backend bekerja
    // const card = form.closest('.product');
    // if (card) {
    //     card.remove();
    // }

    // Baris ini (untuk mencegah redirect) HARUS DIHAPUS jika Anda ingin backend bekerja
    // event.preventDefault(); // Karena belum ada backend, cegah redirect
    // return false; // Jangan submit form beneran

    // Tidak perlu kode lain di sini, form akan disubmit secara alami
}