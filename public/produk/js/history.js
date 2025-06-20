document.addEventListener('DOMContentLoaded', function() {

    // --- Event Delegation untuk Tombol "Rate" ---
    document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('rate-button')) {
            event.preventDefault();
            window.location.href = 'rating';
        }
    });

    // --- Variabel untuk Modal Konfirmasi (Arrived -> Completed) ---
    const confirmModal = document.getElementById('confirmModal');
    const cancelConfirmButton = confirmModal ? confirmModal.querySelector('#cancelConfirm') : null;
    const confirmOrderButton = confirmModal ? confirmModal.querySelector('#confirmOrder') : null;
    let currentArrivedCard = null;
    let currentOrderIdToConfirm = null;

    // --- Variabel untuk Modal Aksi Pending (Pending -> Payment / Canceled) ---
    const pendingActionModal = document.getElementById('pendingActionModal');
    const cancelPendingOrderButton = pendingActionModal ? pendingActionModal.querySelector('#cancelPendingOrder') : null;
    const proceedToPaymentButton = pendingActionModal ? pendingActionModal.querySelector('#proceedToPayment') : null;
    let currentPendingCard = null;
    let currentOrderIdToAct = null;

    // --- Variabel untuk Modal Invoice --
    const invoiceModal = document.getElementById('invoiceModal');
    const invoiceDetailsDisplay = invoiceModal ? invoiceModal.querySelector('#invoiceDetailsDisplay') : null;


    // --- Fungsionalitas Modal Konfirmasi (Arrived -> Completed) ---
    document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('confirm-button')) {
            event.preventDefault();
            currentArrivedCard = event.target.closest('.order-card');
            if (currentArrivedCard) {
                const invoiceBlock = currentArrivedCard.querySelector('.invoice-group-block');
                if (invoiceBlock) {
                    currentOrderIdToConfirm = invoiceBlock.dataset.orderId;
                    if (confirmModal) confirmModal.classList.add('show');
                } else {
                    console.error("invoice-group-block not found within the clicked order-card for confirm.");
                }
            } else {
                console.error("order-card not found for the clicked confirm-button.");
            }
        }
    });

    if (cancelConfirmButton) {
        cancelConfirmButton.addEventListener('click', () => {
            if (confirmModal) confirmModal.classList.remove('show');
            currentOrderIdToConfirm = null;
        });
    }

    if (confirmOrderButton) {
        confirmOrderButton.addEventListener('click', () => {
            if (currentOrderIdToConfirm && currentArrivedCard) { // Pastikan kedua variabel ada
                fetch(`/api/orders/${currentOrderIdToConfirm}/complete`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: 'Completed' })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw new Error(errorData.message || 'Gagal mengkonfirmasi pesanan.');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire('Berhasil!', 'Pesanan berhasil dikonfirmasi.', 'success').then(() => {
                            // --- UPDATE UI LANGSUNG DI KARTU TERKAIT ---
                            // 1. Ubah teks status button
                            const statusButton = currentArrivedCard.querySelector('.order-status-header .status');
                            if (statusButton) {
                                statusButton.textContent = 'Completed';
                                statusButton.classList.remove('arrived'); // Hapus class lama
                                statusButton.classList.add('completed'); // Tambahkan class baru
                            }

                            // 2. Hapus tombol 'Confirm Order'
                            const confirmBtn = currentArrivedCard.querySelector('.confirm-button');
                            if (confirmBtn) {
                                confirmBtn.remove();
                            }

                            // 3. Tambahkan tombol 'Rate' (opsional, jika ingin rate muncul setelah completed)
                            const orderStatusHeader = currentArrivedCard.querySelector('.order-status-header');
                            if (orderStatusHeader && !orderStatusHeader.querySelector('.rate-button')) {
                                const rateLink = document.createElement('a');
                                rateLink.href = 'rating'; // Sesuaikan rute rating
                                rateLink.classList.add('rate-button');
                                rateLink.textContent = 'Rate';
                                orderStatusHeader.appendChild(rateLink);
                            }

                            // Update data-status-group pada card
                            currentArrivedCard.dataset.statusGroup = 'completed';
                        });
                    } else {
                        Swal.fire('Error!', data.message || 'Gagal mengkonfirmasi pesanan.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error!', error.message || 'Terjadi kesalahan saat berkomunikasi dengan server.', 'error');
                })
                .finally(() => {
                    if (confirmModal) confirmModal.classList.remove('show');
                    currentOrderIdToConfirm = null;
                    currentArrivedCard = null; // Reset kartu
                });
            }
        });
    }

    // --- Fungsionalitas Modal Aksi Pending (Pending -> Payment / Canceled) ---
    document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('pending-action-button')) {
            event.preventDefault();
            currentPendingCard = event.target.closest('.order-card');
            if (currentPendingCard) {
                const invoiceBlock = currentPendingCard.querySelector('.invoice-group-block');
                if (invoiceBlock) {
                    currentOrderIdToAct = invoiceBlock.dataset.orderId;
                    if (pendingActionModal) pendingActionModal.classList.add('show');
                } else {
                    console.error("invoice-group-block not found within the clicked order-card for pending action.");
                }
            } else {
                console.error("order-card not found for the clicked pending-action-button.");
            }
        }
    });

    if (cancelPendingOrderButton) {
        cancelPendingOrderButton.addEventListener('click', () => {
            if (currentOrderIdToAct && currentPendingCard) { // Pastikan kedua variabel ada
                fetch(`/api/orders/${currentOrderIdToAct}/cancel`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: 'Canceled' })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(errorData => {
                            throw new Error(errorData.message || 'Gagal membatalkan pesanan.');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire('Berhasil!', 'Pesanan berhasil dibatalkan.', 'success').then(() => {
                            // --- UPDATE UI LANGSUNG DI KARTU TERKAIT ---
                            // 1. Ubah teks status button
                            const statusButton = currentPendingCard.querySelector('.order-status-header .status');
                            if (statusButton) {
                                statusButton.textContent = 'Canceled';
                                statusButton.classList.remove('pending'); // Hapus class lama
                                statusButton.classList.add('canceled'); // Tambahkan class baru
                            }

                            // 2. Hapus tombol 'Action'
                            const actionBtn = currentPendingCard.querySelector('.pending-action-button');
                            if (actionBtn) {
                                actionBtn.remove();
                            }

                            // Update data-status-group pada card
                            currentPendingCard.dataset.statusGroup = 'canceled';
                        });
                    } else {
                        Swal.fire('Error!', data.message || 'Gagal membatalkan pesanan.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error!', error.message || 'Terjadi kesalahan saat berkomunikasi dengan server.', 'error');
                })
                .finally(() => {
                    if (pendingActionModal) pendingActionModal.classList.remove('show');
                    currentOrderIdToAct = null;
                    currentPendingCard = null; // Reset kartu
                });
            }
        });
    }

    if (proceedToPaymentButton) {
        proceedToPaymentButton.addEventListener('click', () => {
            if (currentOrderIdToAct) {
                window.location.href = `/payment/${currentOrderIdToAct}`; // Sesuaikan dengan rute Anda di web.php
            } else {
                window.location.href = 'payment'; // Fallback jika tidak ada orderId spesifik
            }
            if (pendingActionModal) pendingActionModal.classList.remove('show');
            currentOrderIdToAct = null;
            currentPendingCard = null; // Reset kartu
        });
    }

    // --- FUNGSI UTAMA: MERENDER ULANG TOMBOL INVOICE UNTUK SEBUAH BLOK INVOICE ---
    function renderInvoiceButtonForInvoiceBlock(invoiceGroupBlockElement) {
        const invoiceButtonsContainer = invoiceGroupBlockElement.querySelector('.invoice-buttons-per-group-container');
        if (!invoiceButtonsContainer) {
            console.warn("Container for invoice buttons not found for:", invoiceGroupBlockElement);
            return;
        }

        invoiceButtonsContainer.innerHTML = ''; // Hapus tombol lama sebelum menambahkan yang baru

        const orderId = invoiceGroupBlockElement.dataset.orderId;
        const invoiceNumber = invoiceGroupBlockElement.dataset.invoiceNumber;
        const invoiceDate = invoiceGroupBlockElement.dataset.invoiceDate;
        const invoiceTotalPrice = parseFloat(invoiceGroupBlockElement.dataset.invoiceTotalPrice || 0);
        const items = [];

        invoiceGroupBlockElement.querySelectorAll('.individual-order-item').forEach(itemElement => {
            const title = itemElement.dataset.itemTitle;
            const price = parseFloat(itemElement.dataset.itemPrice || 0);
            const quantity = parseInt(itemElement.dataset.itemQuantity || 0);
            items.push({ title, price, quantity });
        });

        const button = document.createElement('button');
        button.classList.add('view-invoice-button');
        button.textContent = `Lihat Invoice`;

        button.dataset.orderId = orderId;
        button.dataset.invoiceNumber = invoiceNumber;
        button.dataset.invoiceDate = invoiceDate;
        button.dataset.invoiceItems = JSON.stringify(items);
        button.dataset.invoiceTotalPrice = invoiceTotalPrice;

        invoiceButtonsContainer.appendChild(button);
        attachInvoiceButtonListeners(); // Panggil setiap kali tombol baru dirender
    }

    // --- Fungsionalitas Modal Invoice ---
    function attachInvoiceButtonListeners() {
        // Hapus listener lama dari SEMUA tombol untuk menghindari duplikasi
        document.querySelectorAll('.view-invoice-button').forEach(button => {
            button.removeEventListener('click', handleInvoiceButtonClick);
        });

        // Dapatkan semua tombol invoice yang ada di DOM saat ini dan tambahkan listener baru
        document.querySelectorAll('.view-invoice-button').forEach(button => {
            button.addEventListener('click', handleInvoiceButtonClick);
        });
    }

    function handleInvoiceButtonClick(event) {
        if (!invoiceDetailsDisplay) {
            console.error("invoiceDetailsDisplay element not found.");
            return;
        }

        const invoiceNumber = event.target.dataset.invoiceNumber;
        const invoiceDate = event.target.dataset.invoiceDate;
        const invoiceItems = JSON.parse(event.target.dataset.invoiceItems);
        const invoiceTotalPrice = parseFloat(event.target.dataset.invoiceTotalPrice);

        invoiceDetailsDisplay.innerHTML = ''; // Kosongkan konten sebelumnya

        const invoiceHeader = document.createElement('h3');
        invoiceHeader.textContent = `Detail Invoice Pesanan`;
        invoiceDetailsDisplay.appendChild(invoiceHeader);

        const invoiceNumParagraph = document.createElement('p');
        invoiceNumParagraph.innerHTML = `<strong>Nomor Invoice:</strong> <span>${invoiceNumber}</span>`;
        invoiceDetailsDisplay.appendChild(invoiceNumParagraph);

        const orderDateParagraph = document.createElement('p');
        orderDateParagraph.innerHTML = `<strong>Tanggal Order:</strong> <span>${invoiceDate}</span>`;
        invoiceDetailsDisplay.appendChild(orderDateParagraph);

        const itemsHeader = document.createElement('p');
        itemsHeader.innerHTML = `<strong>Detail Buku:</strong>`;
        itemsHeader.style.marginTop = '15px';
        itemsHeader.style.fontWeight = 'bold';
        invoiceDetailsDisplay.appendChild(itemsHeader);

        invoiceItems.forEach(item => {
            const itemDiv = document.createElement('div');
            itemDiv.classList.add('invoice-item-detail');
            itemDiv.innerHTML = `
                <p style="margin-left: 20px;">- <strong>Judul Buku:</strong> <span>${item.title}</span></p>
                <p style="margin-left: 20px;">&nbsp;&nbsp;<strong>Harga per unit:</strong> <span>IDR ${parseFloat(item.price).toLocaleString('id-ID', {minimumFractionDigits: 0})}</span></p>
                <p style="margin-left: 20px;">&nbsp;&nbsp;<strong>Jumlah:</strong> <span>${item.quantity}</span></p>
                <p style="margin-left: 20px;">&nbsp;&nbsp;<strong>Subtotal Item:</strong> <span>IDR ${(item.price * item.quantity).toLocaleString('id-ID', {minimumFractionDigits: 0})}</span></p>
            `;
            invoiceDetailsDisplay.appendChild(itemDiv);
        });

        const totalParagraph = document.createElement('p');
        totalParagraph.innerHTML = `<strong>Total Pembelian:</strong> <span>IDR ${invoiceTotalPrice.toLocaleString('id-ID', {minimumFractionDigits: 0})}</span>`;
        totalParagraph.style.marginTop = '15px';
        totalParagraph.style.fontSize = '18px';
        totalParagraph.style.fontWeight = 'bold';
        invoiceDetailsDisplay.appendChild(totalParagraph);

        if (invoiceModal) invoiceModal.classList.add('show');
    }

    // --- Initial Rendering of Invoice Buttons on Page Load ---
    document.querySelectorAll('.order-card').forEach(card => {
        card.querySelectorAll('.invoice-group-block').forEach(block => {
            renderInvoiceButtonForInvoiceBlock(block);
        });
    });

    // --- Generic Modal Closer Function ---
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
