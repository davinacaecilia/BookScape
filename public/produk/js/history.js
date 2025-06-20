document.addEventListener('DOMContentLoaded', function() {

    // --- Event Delegation untuk Tombol "Rate" ---
    document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('rate-button')) {
            event.preventDefault();
            // Ambil order ID dari kartu terdekat jika rute rating memerlukan ID spesifik
            // const orderId = event.target.closest('.order-card').dataset.orderId;
            window.location.href = 'rating'; // Atau `rating/${orderId}` jika diperlukan
        }
    });

    // --- Variabel untuk Modal Konfirmasi (Arrived -> Completed) ---
    const confirmModal = document.getElementById('confirmModal');
    const cancelConfirmButton = confirmModal ? confirmModal.querySelector('#cancelConfirm') : null;
    const confirmOrderButton = confirmModal ? confirmModal.querySelector('#confirmOrder') : null;
    let currentOrderCard = null; // Ini akan menyimpan kartu pesanan yang sedang diinteraksi
    let currentOrderIdToAct = null; // Menyimpan ID order yang akan dikonfirmasi/dibatalkan

    // --- Variabel untuk Modal Aksi Pending (Pending -> Payment / Canceled) ---
    const pendingActionModal = document.getElementById('pendingActionModal');
    const cancelPendingOrderButton = pendingActionModal ? pendingActionModal.querySelector('#cancelPendingOrder') : null;
    const proceedToPaymentButton = pendingActionModal ? pendingActionModal.querySelector('#proceedToPayment') : null;

    // --- Variabel untuk Modal Invoice --
    const invoiceModal = document.getElementById('invoiceModal');
    const invoiceDetailsDisplay = invoiceModal ? invoiceModal.querySelector('#invoiceDetailsDisplay') : null;


    // --- Fungsionalitas Modal Konfirmasi (Arrived -> Completed) ---
    // Gunakan event delegation untuk tombol confirm-button karena mereka dinamis
    document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('confirm-button')) {
            event.preventDefault();
            currentOrderCard = event.target.closest('.order-card');
            currentOrderIdToAct = currentOrderCard.dataset.orderId;
            if (confirmModal) confirmModal.classList.add('show');
        }
    });

    if (cancelConfirmButton) {
        cancelConfirmButton.addEventListener('click', () => {
            if (confirmModal) confirmModal.classList.remove('show');
            currentOrderIdToAct = null;
            currentOrderCard = null;
        });
    }

    if (confirmOrderButton) {
        confirmOrderButton.addEventListener('click', () => {
            if (currentOrderIdToAct) {
                fetch('/order/update-status', { // Ganti dengan rute API Anda
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        order_id: currentOrderIdToAct,
                        status: 'completed'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Berhasil!', 'Pesanan berhasil dikonfirmasi.', 'success').then(() => {
                            // Perbarui UI pada kartu spesifik tanpa reload
                            updateOrderCardUI(currentOrderCard, data.new_status);
                            if (confirmModal) confirmModal.classList.remove('show');
                            currentOrderIdToAct = null;
                            currentOrderCard = null;
                        });
                    } else {
                        Swal.fire('Error!', data.message || 'Gagal mengkonfirmasi pesanan.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error!', 'Terjadi kesalahan saat berkomunikasi dengan server.', 'error');
                });
            }
        });
    }

    // --- Fungsionalitas Modal Aksi Pending (Pending -> Payment / Canceled) ---
    // Gunakan event delegation untuk tombol pending-action-button
    document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('pending-action-button')) {
            event.preventDefault();
            currentOrderCard = event.target.closest('.order-card');
            currentOrderIdToAct = currentOrderCard.dataset.orderId;
            if (pendingActionModal) pendingActionModal.classList.add('show');
        }
    });

    if (cancelPendingOrderButton) {
        cancelPendingOrderButton.addEventListener('click', () => {
            if (currentOrderIdToAct) {
                fetch('/order/update-status', { // Ganti dengan rute API Anda
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        order_id: currentOrderIdToAct,
                        status: 'canceled'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Berhasil!', 'Pesanan berhasil dibatalkan.', 'success').then(() => {
                            // Perbarui UI pada kartu spesifik tanpa reload
                            updateOrderCardUI(currentOrderCard, data.new_status);
                            if (pendingActionModal) pendingActionModal.classList.remove('show');
                            currentOrderIdToAct = null;
                            currentOrderCard = null;
                        });
                    } else {
                        Swal.fire('Error!', data.message || 'Gagal membatalkan pesanan.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error!', 'Terjadi kesalahan saat berkomunikasi dengan server.', 'error');
                });
            }
        });
    }

    if (proceedToPaymentButton) {
        proceedToPaymentButton.addEventListener('click', () => {
            if (currentOrderIdToAct) {
                window.location.href = `/payment/${currentOrderIdToAct}`; // Ganti dengan rute Anda
            } else {
                Swal.fire('Error!', 'Order ID tidak ditemukan untuk pembayaran.', 'error');
            }
            if (pendingActionModal) pendingActionModal.classList.remove('show');
            currentOrderIdToAct = null;
            currentOrderCard = null;
        });
    }

    // --- FUNGSI BARU: MEMPERBARUI UI KARTU PESANAN ---
    function updateOrderCardUI(cardElement, newStatus) {
        const statusButton = cardElement.querySelector('.order-status-header .status');
        const actionButtonsContainer = cardElement.querySelector('.order-status-header .action-buttons');

        // Update status text dan class
        statusButton.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
        statusButton.className = `status ${newStatus}`; // Hapus kelas lama, tambahkan kelas baru

        // Update data-order-status atribut pada kartu
        cardElement.dataset.orderStatus = newStatus;

        // Kosongkan dan render ulang tombol aksi
        actionButtonsContainer.innerHTML = '';
        if (newStatus === 'completed') {
            const rateButton = document.createElement('a');
            rateButton.href = 'rating'; // Sesuaikan rute rating
            rateButton.classList.add('rate-button');
            rateButton.textContent = 'Rate';
            actionButtonsContainer.appendChild(rateButton);
        } else if (newStatus === 'arrived') {
            const confirmButton = document.createElement('button');
            confirmButton.classList.add('confirm-button');
            confirmButton.textContent = 'Confirm Order';
            actionButtonsContainer.appendChild(confirmButton);
        } else if (newStatus === 'pending') {
            const pendingButton = document.createElement('button');
            pendingButton.classList.add('pending-action-button');
            pendingButton.textContent = 'Action';
            actionButtonsContainer.appendChild(pendingButton);
        }

        // Periksa apakah tombol invoice perlu dirender ulang (jika status berubah menjadi yang bisa di-invoice)
        if (['completed', 'arrived', 'process'].includes(newStatus)) {
            const invoiceBlock = cardElement.querySelector('.invoice-group-block');
            if (invoiceBlock) {
                renderInvoiceButtonForInvoiceBlock(invoiceBlock);
            }
        } else {
             // Jika status tidak lagi bisa di-invoice, hapus tombol invoice
            const invoiceButtonsContainer = cardElement.querySelector('.invoice-buttons-per-group-container');
            if(invoiceButtonsContainer) {
                invoiceButtonsContainer.innerHTML = '';
            }
        }
    }


    // --- FUNGSI UTAMA: MERENDER ULANG TOMBOL INVOICE UNTUK SEBUAH BLOK INVOICE ---
    // Fungsi ini dipanggil saat DOM dimuat dan saat status berubah
    function renderInvoiceButtonForInvoiceBlock(invoiceGroupBlockElement) {
        const invoiceButtonsContainer = invoiceGroupBlockElement.querySelector('.invoice-buttons-per-group-container');
        if (!invoiceButtonsContainer) {
            console.error("Invoice buttons container not found for invoice group block:", invoiceGroupBlockElement);
            return;
        }

        invoiceButtonsContainer.innerHTML = ''; // Hapus tombol lama

        const invoiceNumber = invoiceGroupBlockElement.dataset.invoiceNumber;
        const invoiceDate = invoiceGroupBlockElement.dataset.invoiceDate;
        const invoiceTotalPrice = invoiceGroupBlockElement.dataset.invoiceTotalPrice; // Ambil total harga dari data attribute
        const items = [];

        // Ambil data dari individual-order-item di dalam order-card yang sama
        // Kita perlu mencari .individual-order-item dalam parent dari invoiceGroupBlockElement (yaitu .order-details-group)
        invoiceGroupBlockElement.closest('.order-details-group').querySelectorAll('.individual-order-item').forEach(itemElement => {
            const title = itemElement.dataset.itemTitle;
            const price = itemElement.dataset.itemPrice;
            const quantity = itemElement.dataset.itemQuantity; // Ambil kuantitas
            items.push({ title, price, quantity });
        });

        const button = document.createElement('button');
        button.classList.add('view-invoice-button');
        button.textContent = `Invoice`;

        // Simpan semua data invoice ke dalam atribut data tombol
        button.dataset.invoiceNumber = invoiceNumber;
        button.dataset.invoiceDate = invoiceDate;
        button.dataset.invoiceItems = JSON.stringify(items);
        button.dataset.invoiceTotalPrice = invoiceTotalPrice;

        invoiceButtonsContainer.appendChild(button);
        attachInvoiceButtonListeners(); // Lampirkan event listener
    }

    // --- Fungsionalitas Modal Invoice ---
    function attachInvoiceButtonListeners() {
        // Hapus listener lama untuk menghindari duplikasi saat renderInvoiceButtonForInvoiceBlock dipanggil berkali-kali
        document.querySelectorAll('.view-invoice-button').forEach(button => {
            button.removeEventListener('click', handleInvoiceButtonClick);
        });

        // Dapatkan semua tombol invoice yang ada di DOM saat ini dan tambahkan listener baru
        const currentViewInvoiceButtons = document.querySelectorAll('.view-invoice-button');
        currentViewInvoiceButtons.forEach(button => {
            button.addEventListener('click', handleInvoiceButtonClick);
        });
    }

    function handleInvoiceButtonClick(event) {
        const invoiceNumber = event.target.dataset.invoiceNumber;
        const invoiceDate = event.target.dataset.invoiceDate;
        const invoiceItems = JSON.parse(event.target.dataset.invoiceItems);
        const invoiceTotalPrice = event.target.dataset.invoiceTotalPrice;

        if (invoiceDetailsDisplay) invoiceDetailsDisplay.innerHTML = ''; // Clear previous details

        const invoiceHeader = document.createElement('h3');
        invoiceHeader.textContent = `Detail Invoice ${invoiceNumber}`;
        if (invoiceDetailsDisplay) invoiceDetailsDisplay.appendChild(invoiceHeader);

        const invoiceNumParagraph = document.createElement('p');
        invoiceNumParagraph.innerHTML = `<strong>Nomor Invoice:</strong> <span>${invoiceNumber}</span>`;
        if (invoiceDetailsDisplay) invoiceDetailsDisplay.appendChild(invoiceNumParagraph);

        const orderDateParagraph = document.createElement('p');
        orderDateParagraph.innerHTML = `<strong>Tanggal Order:</strong> <span>${invoiceDate}</span>`;
        if (invoiceDetailsDisplay) invoiceDetailsDisplay.appendChild(orderDateParagraph);

        const itemsHeader = document.createElement('p');
        itemsHeader.innerHTML = `<strong>Detail Buku:</strong>`;
        itemsHeader.style.marginTop = '15px';
        itemsHeader.style.fontWeight = 'bold';
        if (invoiceDetailsDisplay) invoiceDetailsDisplay.appendChild(itemsHeader);

        invoiceItems.forEach(item => {
            const itemDiv = document.createElement('div');
            itemDiv.classList.add('invoice-item-detail');
            itemDiv.innerHTML = `
                <p style="margin-left: 20px;">- <strong>Judul Buku:</strong> <span>${item.title}</span></p>
                <p style="margin-left: 20px;">&nbsp;&nbsp;<strong>Harga:</strong> <span>Rp ${item.price}</span></p>
                <p style="margin-left: 20px;">&nbsp;&nbsp;<strong>Jumlah:</strong> <span>${item.quantity}</span></p>
            `;
            if (invoiceDetailsDisplay) invoiceDetailsDisplay.appendChild(itemDiv);
        });

        const totalParagraph = document.createElement('p');
        totalParagraph.innerHTML = `<strong>Total Pembelian:</strong> <span>Rp ${parseFloat(invoiceTotalPrice).toLocaleString('id-ID', {minimumFractionDigits: 0})}</span>`;
        totalParagraph.style.marginTop = '15px';
        totalParagraph.style.fontSize = '18px';
        totalParagraph.style.fontWeight = 'bold';
        if (invoiceDetailsDisplay) invoiceDetailsDisplay.appendChild(totalParagraph);

        if (invoiceModal) invoiceModal.classList.add('show');
    }

    // --- Initial Rendering of Invoice Buttons on Page Load ---
   // --- Initial Rendering of Invoice Buttons and Action Buttons on Page Load ---
    // Panggil fungsi ini untuk setiap order card saat halaman dimuat
    document.querySelectorAll('.order-card').forEach(card => {
        const invoiceBlock = card.querySelector('.invoice-group-block');
        const currentStatus = card.dataset.orderStatus; // Ini akan mengambil status seperti 'Pending', 'process', 'Arrived', dll.

        // Memanggil updateOrderCardUI untuk merender tombol aksi dan status
        // Ini akan memastikan tombol 'Action' untuk 'Pending' muncul jika data-order-statusnya 'Pending' atau 'pending'
        updateOrderCardUI(card, currentStatus.toLowerCase()); // Kirim status dalam huruf kecil ke fungsi

        // Hanya render tombol invoice jika statusnya memungkinkan
        if (['completed', 'arrived', 'process'].includes(currentStatus.toLowerCase())) { // Pastikan perbandingan juga lowerCase
            if (invoiceBlock) {
                renderInvoiceButtonForInvoiceBlock(invoiceBlock);
            }
        }
    });

    // --- Generic Modal Closer Function ---\
    function closeModal(modalElement) {
        if (modalElement) {
            modalElement.classList.remove('show');
        }
    }

    // --- Event listener untuk semua tombol penutup modal (termasuk 'x' dan 'Tutup') ---
    document.body.addEventListener('click', function(event) {
        const closeButton = event.target.closest('[data-modal-close]');
        if (closeButton) {
            event.preventDefault();
            const modalId = closeButton.dataset.modalClose;
            const targetModal = document.getElementById(modalId);
            closeModal(targetModal);
        }
    });

    // --- Menutup Modal Saat Klik di Luar (Pada Overlay Modal) ---
    window.addEventListener('click', (event) => {
        if (event.target === confirmModal) {
            closeModal(confirmModal);
        }
        if (event.target === pendingActionModal) {
            closeModal(pendingActionModal);
        }
        if (event.target === invoiceModal) {
            closeModal(invoiceModal);
        }
    });
});
