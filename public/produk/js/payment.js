document.addEventListener('DOMContentLoaded', () => {
        const paymentProofInput = document.getElementById('paymentProofInput');
        const fileNameDisplay = document.getElementById('fileNameDisplay');
        const imagePreview = document.getElementById('imagePreview');
        const payButton = document.querySelector('.pay-button');

        // Elemen-elemen baru untuk pemilihan metode pembayaran
        const paymentMethodsSelection = document.querySelector('.payment-methods-selection');
        const selectedMethodDisplay = paymentMethodsSelection.querySelector('.selected-method-display p');
        const toggleIcon = paymentMethodsSelection.querySelector('.toggle-icon');
        const paymentOptionsDropdown = paymentMethodsSelection.querySelector('.payment-options-dropdown');
        const paymentRadioButtons = paymentOptionsDropdown.querySelectorAll('input[type="radio"][name="paymentMethod"]');
        const selectedAccountDetails = document.querySelector('.selected-account-details');

        // Data untuk detail metode pembayaran (Anda bisa menambahkan lebih banyak di sini)
        const paymentMethodsData = {
            'BCA': {
                name: 'BCA',
                description: 'Bank Central Asia',
                accountNumber: '0812345678 (A/N Nama Rekening Anda)'
            },
            'DANA': {
                name: 'DANA',
                description: 'E-wallet DANA',
                accountNumber: '0876543210 (A/N Nama Akun Dana Anda)'
            },
            'Mandiri': { // Contoh metode ketiga
                name: 'Mandiri',
                description: 'Bank Mandiri',
                accountNumber: '1234567890 (A/N Nama Rekening Mandiri Anda)'
            },
            'BRIVA': {
                name: 'BRIVA',
                description: 'BRI Virtual Account',
                accountNumber: '1234567890 (A/N Nama Rekening BRI Anda)'
            }
        };

        let selectedPaymentMethod = null; // Untuk menyimpan metode pembayaran yang dipilih

        // --- Fungsionalitas Pemilihan Metode Pembayaran ---

        // Tampilkan/Sembunyikan dropdown saat area display utama diklik
        paymentMethodsSelection.addEventListener('click', (event) => {
            // Pastikan klik tidak berasal dari radio button atau label di dalamnya,
            // ini agar klik pada radio button tidak langsung menutup dropdown.
            if (!event.target.closest('.payment-option-item') && !event.target.closest('input[type="radio"]')) {
                paymentOptionsDropdown.style.display = paymentOptionsDropdown.style.display === 'none' ? 'block' : 'none';
                toggleIcon.classList.toggle('active', paymentOptionsDropdown.style.display === 'block');
            }
        });

        // Tangani pemilihan radio button
        paymentRadioButtons.forEach(radio => {
            radio.addEventListener('change', () => {
                if (radio.checked) {
                    selectedPaymentMethod = radio.value;
                    const method = paymentMethodsData[selectedPaymentMethod];

                    // Perbarui teks di display utama
                    selectedMethodDisplay.textContent = `${method.name} - ${method.description}`;

                    // Tampilkan detail rekening
                    selectedAccountDetails.innerHTML = `
                        <p>Pembayaran via ${method.name}:</p>
                        <p class="account-number">${method.accountNumber}</p>
                        <p>Mohon transfer sesuai dengan jumlah total belanja.</p>
                    `;
                    selectedAccountDetails.style.display = 'block';

                    // Sembunyikan dropdown setelah memilih
                    paymentOptionsDropdown.style.display = 'none';
                    toggleIcon.classList.remove('active');
                }
            });
        });

        // Sembunyikan dropdown jika klik di luar area pemilihan
        document.addEventListener('click', (event) => {
            if (!paymentMethodsSelection.contains(event.target) && paymentOptionsDropdown.style.display === 'block') {
                paymentOptionsDropdown.style.display = 'none';
                toggleIcon.classList.remove('active');
            }
        });


        // --- Fungsionalitas Upload Bukti Pembayaran (TIDAK DIUBAH) ---
        if (paymentProofInput) {
            paymentProofInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                    fileNameDisplay.textContent = file.name;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    fileNameDisplay.textContent = 'Belum ada gambar terpilih';
                    imagePreview.src = '#';
                    imagePreview.style.display = 'none';
                }
            });
        }

        // --- Fungsionalitas Tombol Bayar (Validasi TIDAK DIUBAH untuk upload gambar, ditambah validasi metode pembayaran) ---
        if (payButton) {
            payButton.addEventListener('click', () => {
                const file = paymentProofInput.files[0]; // Dapatkan file yang dipilih

                // Validasi: Apakah metode pembayaran sudah dipilih?
                if (!selectedPaymentMethod) {
                     Swal.fire({
                        icon: 'warning',
                        title: 'Metode Pembayaran Belum Dipilih',
                        text: 'Tolong pilih metode pembayaran Anda sebelum melanjutkan.',
                        confirmButtonText: 'OK'
                    });
                    return; // Hentikan eksekusi
                }

                // Validasi: Apakah bukti pembayaran sudah diunggah?
                if (!file) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Bukti Pembayaran Belum Diunggah',
                        text: 'Tolong masukkan bukti pembayaran Anda sebelum melanjutkan.',
                        confirmButtonText: 'OK'
                    });
                    return; // Hentikan eksekusi
                }

                 // Jika semua validasi berhasil
                Swal.fire({
                    icon: 'success',
                    title: 'Pembayaran Berhasil!',
                    text: 'Bukti pembayaran Anda telah diterima. Pesanan Anda akan segera diproses.',
                    showConfirmButton: false,
                    timer: 2000 // Popup akan otomatis tertutup setelah 2 detik
                }).then(() => {
                    // Ini akan dieksekusi setelah popup SweetAlert tertutup (setelah 2 detik)
                    window.location.href = 'history.html'; // Ganti 'orderNow.html' dengan URL halaman histori pesanan Anda
                });
            });
        }
    });
