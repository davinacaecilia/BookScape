document.addEventListener('DOMContentLoaded', function() {

    // --- Variabel untuk Modal Konfirmasi (Arrived -> Completed) ---
    const confirmModal = document.getElementById('confirmModal');
    const cancelConfirmButton = confirmModal ? confirmModal.querySelector('#cancelConfirm') : null;
    const confirmOrderButton = confirmModal ? confirmModal.querySelector('#confirmOrder') : null;
    let currentOrderCard = null; // Ini akan menyimpan kartu pesanan (div.order-card) yang sedang diinteraksi
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

            // Validasi di frontend: Hanya bisa konfirmasi dari 'arrived'
            const currentStatus = currentOrderCard.dataset.orderStatus.toLowerCase();
            if (currentStatus !== 'arrived') {
                Swal.fire({
                    icon: 'error',
                    title: 'Aksi Tidak Diizinkan',
                    text: 'Pesanan hanya bisa dikonfirmasi jika statusnya "Arrived".',
                    confirmButtonText: 'OK'
                });
                return; // Hentikan proses jika validasi gagal
            }

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
                Swal.fire({
                    title: 'Konfirmasi Penerimaan Order?',
                    text: 'Status order akan diubah menjadi "Completed".',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Konfirmasi!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('order/update-status', { // Menggunakan url() helper untuk rute
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
                                Swal.fire('Berhasil!', data.message, 'success').then(() => {
                                    updateOrderCardUI(currentOrderCard, data.new_status);
                                    if (confirmModal) closeModal(confirmModal);
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
        });
    }

    // --- Fungsionalitas Modal Aksi Pending (Pending -> Payment / Canceled) ---
    document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('pending-action-button')) {
            event.preventDefault();
            currentOrderCard = event.target.closest('.order-card');
            currentOrderIdToAct = currentOrderCard.dataset.orderId;

            const currentStatus = currentOrderCard.dataset.orderStatus.toLowerCase();

            // Tampilkan modal jika statusnya pending, jika tidak, langsung tampilkan error
            if (currentStatus === 'pending') {
                if (pendingActionModal) pendingActionModal.classList.add('show');
            } else {
                // Pesan error di frontend jika mencoba aksi 'Action' dari status selain pending
                 Swal.fire({
                    icon: 'error',
                    title: 'Aksi Tidak Diizinkan',
                    text: 'Aksi hanya bisa dilakukan jika status pesanan "Pending".',
                    confirmButtonText: 'OK'
                });
            }
        }
    });

    if (cancelPendingOrderButton) {
        cancelPendingOrderButton.addEventListener('click', () => {
            const currentStatus = currentOrderCard ? currentOrderCard.dataset.orderStatus.toLowerCase() : '';

            // Validasi di frontend: Hanya bisa cancel jika statusnya 'pending'
            if (currentStatus !== 'pending') {
                Swal.fire({
                    icon: 'error',
                    title: 'Aksi Tidak Diizinkan',
                    text: 'Pesanan hanya bisa dibatalkan jika statusnya "Pending".',
                    confirmButtonText: 'OK'
                });
                if (pendingActionModal) closeModal(pendingActionModal);
                return;
            }

            if (currentOrderIdToAct) {
                Swal.fire({
                    title: 'Batalkan Pesanan Ini?',
                    text: 'Pesanan ini akan dibatalkan dan stok buku akan dikembalikan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: 'gray',
                    confirmButtonText: 'Ya, Batalkan!',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('order/update-status', {
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
                                Swal.fire('Berhasil!', data.message, 'success').then(() => {
                                    updateOrderCardUI(currentOrderCard, data.new_status);
                                    if (pendingActionModal) closeModal(pendingActionModal);
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
        });
    }

    if (proceedToPaymentButton) {
        proceedToPaymentButton.addEventListener('click', () => {
            const currentStatus = currentOrderCard ? currentOrderCard.dataset.orderStatus.toLowerCase() : '';
            // Pembayaran hanya bisa dilanjutkan jika statusnya 'pending'
            if (currentStatus !== 'pending') {
                Swal.fire({
                    icon: 'error',
                    title: 'Aksi Tidak Diizinkan',
                    text: 'Pembayaran hanya bisa dilanjutkan jika statusnya "Pending".',
                    confirmButtonText: 'OK'
                });
                if (pendingActionModal) closeModal(pendingActionModal);
                return;
            }
            if (currentOrderIdToAct) {
                window.location.href = `/payment/${currentOrderIdToAct}`;
            } else {
                Swal.fire('Error!', 'Order ID tidak ditemukan untuk pembayaran.', 'error');
            }
            if (pendingActionModal) closeModal(pendingActionModal);
            currentOrderIdToAct = null;
            currentOrderCard = null;
        });
    }

    // --- FUNGSI UTAMA: MEMPERBARUI UI KARTU PESANAN ---
    // Fungsi ini dipanggil saat DOM dimuat dan saat status berubah
    function updateOrderCardUI(cardElement, newStatus) {
        const statusButton = cardElement.querySelector('.order-status-header .status');
        const actionButtonsContainer = cardElement.querySelector('.order-status-header .action-buttons');

        // Update status text dan class
        statusButton.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1).replace(/_/g, ' ');
        statusButton.className = `status ${newStatus}`;

        // Update data-order-status atribut pada kartu
        cardElement.dataset.orderStatus = newStatus;

        // Kosongkan dan render ulang tombol aksi (per ORDER)
        if (actionButtonsContainer) {
            actionButtonsContainer.innerHTML = '';

            if (newStatus === 'arrived') {
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
            // Untuk 'completed', 'process', 'canceled' tidak ada tombol aksi per order di sini
        }

        cardElement.querySelectorAll('.individual-order-item').forEach(itemElement => {
            // Kita akan mencari elemen yang akan menjadi kontainer tombol "Rate"
            const itemFooter = itemElement.querySelector('.item-footer');
            if (!itemFooter) return; // Pastikan item-footer ada

            let rateButton = itemFooter.querySelector('.rate-button'); // Cari tombol Rate yang mungkin sudah ada

            if (newStatus === 'completed') {
                if (!rateButton) { // Jika belum ada, buat
                    rateButton = document.createElement('a');
                    const bookId = itemElement.dataset.bookId;
                    if (bookId) {
                        rateButton.href = `/rating/${bookId}`; // Gunakan ID buku
                    } else {
                        rateButton.href = `'rating/${bookId}`; // Fallback jika ID buku tidak ada
                    }
                    rateButton.classList.add('rate-button'); // <<< GUNAKAN KELAS CSS YANG ANDA INGINKAN
                    rateButton.textContent = 'Rate'; // Teks tombol
                    itemFooter.appendChild(rateButton);
                }
                // Jika sudah ada, tidak perlu melakukan apa-apa karena sudah benar
            } else {
                if (rateButton) { // Jika ada, hapus karena status bukan 'completed'
                    rateButton.remove();
                }
            }
        });


        // Periksa apakah tombol invoice perlu dirender ulang
        if (['completed', 'arrived', 'process'].includes(newStatus)) {
            const invoiceBlock = cardElement.querySelector('.invoice-group-block');
            if (invoiceBlock) {
                renderInvoiceButtonForInvoiceBlock(invoiceBlock);
            }
        } else {
            const invoiceButtonsContainer = cardElement.querySelector('.invoice-buttons-per-group-container');
            if(invoiceButtonsContainer) {
                invoiceButtonsContainer.innerHTML = '';
            }
        }
    }


    // --- FUNGSI UTAMA: MERENDER ULANG TOMBOL INVOICE UNTUK SEBUAH BLOK INVOICE ---
    function renderInvoiceButtonForInvoiceBlock(invoiceGroupBlockElement) {
        const invoiceButtonsContainer = invoiceGroupBlockElement.querySelector('.invoice-buttons-per-group-container');
        if (!invoiceButtonsContainer) {
            console.error("Invoice buttons container not found for invoice group block:", invoiceGroupBlockElement);
            return;
        }

        invoiceButtonsContainer.innerHTML = ''; // Hapus tombol lama

        const invoiceNumber = invoiceGroupBlockElement.dataset.invoiceNumber;
        const invoiceDate = invoiceGroupBlockElement.dataset.invoiceDate;
        const invoiceTotalPrice = invoiceGroupBlockElement.dataset.invoiceTotalPrice;
        const items = [];

        // Ambil data dari individual-order-item di dalam order-card yang sama
        const orderDetailsGroup = invoiceGroupBlockElement.closest('.order-details-group');
        if (orderDetailsGroup) {
            orderDetailsGroup.querySelectorAll('.individual-order-item').forEach(itemElement => {
                const title = itemElement.dataset.itemTitle;
                const price = itemElement.dataset.itemPrice;
                const quantity = itemElement.dataset.itemQuantity;
                items.push({ title, price, quantity });
            });
        }


        const button = document.createElement('button');
        button.classList.add('view-invoice-button');
        button.textContent = `Invoice`;

        button.dataset.invoiceNumber = invoiceNumber;
        button.dataset.invoiceDate = invoiceDate;
        button.dataset.invoiceItems = JSON.stringify(items);
        button.dataset.invoiceTotalPrice = invoiceTotalPrice;

        invoiceButtonsContainer.appendChild(button);
        attachInvoiceButtonListeners();
    }

    // --- Fungsionalitas Modal Invoice ---
    function attachInvoiceButtonListeners() {
        document.querySelectorAll('.view-invoice-button').forEach(button => {
            button.removeEventListener('click', handleInvoiceButtonClick);
        });

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

        if (invoiceDetailsDisplay) invoiceDetailsDisplay.innerHTML = '';

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

    // --- Initial Rendering of Invoice Buttons and Action Buttons on Page Load ---
    document.querySelectorAll('.order-card').forEach(card => {
        const invoiceBlock = card.querySelector('.invoice-group-block');
        const currentStatus = card.dataset.orderStatus;

        updateOrderCardUI(card, currentStatus.toLowerCase());

        if (['completed', 'arrived', 'process'].includes(currentStatus.toLowerCase())) {
            if (invoiceBlock) {
                renderInvoiceButtonForInvoiceBlock(invoiceBlock);
            }
        }
    });
});