
    function confirmDelete(event) {
        if (!confirm("Are You Sure Want to Delete This Product?")) {
            event.preventDefault(); // Batalin submit form
            return false;
        }
        // Untuk simulasi frontend (hapus elemen kartu)
        const form = event.target;
        const card = form.closest('.product');
        if (card) {
            card.remove();
        }
        event.preventDefault(); // Karena belum ada backend, cegah redirect
        return false; // Jangan submit form beneran
    }

    