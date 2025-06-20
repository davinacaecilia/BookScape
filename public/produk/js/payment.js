document.addEventListener('DOMContentLoaded', () => {
    const paymentForm = document.getElementById('paymentForm');
    const paymentProofInput = document.getElementById('paymentProofInput');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const imagePreview = document.getElementById('imagePreview');
    const payButton = document.querySelector('.pay-button');
    const selectedPaymentMethodInput = document.getElementById('selectedPaymentMethodInput');

    const paymentMethodsSelection = document.querySelector('.payment-methods-selection');
    const selectedMethodDisplay = paymentMethodsSelection.querySelector('.selected-method-display p');
    const toggleIcon = paymentMethodsSelection.querySelector('.toggle-icon');
    const paymentOptionsDropdown = paymentMethodsSelection.querySelector('.payment-options-dropdown');
    const paymentOptionItems = paymentOptionsDropdown.querySelectorAll('.payment-option-item'); // Ambil label-label item
    const paymentRadioButtons = paymentOptionsDropdown.querySelectorAll('input[type="radio"][name="paymentMethod"]');
    const selectedAccountDetails = document.querySelector('.selected-account-details');

    let selectedPaymentMethodId = null; // Akan menyimpan ID metode pembayaran

    // --- Fungsionalitas Pemilihan Metode Pembayaran ---

    paymentMethodsSelection.addEventListener('click', (event) => {
        if (!event.target.closest('.payment-option-item') && !event.target.closest('input[type="radio"]')) {
            paymentOptionsDropdown.style.display = paymentOptionsDropdown.style.display === 'none' ? 'block' : 'none';
            toggleIcon.classList.toggle('active', paymentOptionsDropdown.style.display === 'block');
        }
    });

    paymentOptionItems.forEach(item => {
        item.addEventListener('click', () => {
            const radio = item.querySelector('input[type="radio"]');
            radio.checked = true; // Pastikan radio button dicentang saat label diklik

            selectedPaymentMethodId = item.dataset.methodId; // Ambil ID dari data-method-id
            selectedPaymentMethodInput.value = selectedPaymentMethodId; // Update hidden input

            const methodName = item.dataset.methodName;
            const methodDescription = item.dataset.methodDescription;
            const accountNumber = item.dataset.methodAccountNumber;
            const accountName = item.dataset.methodAccountName;

            selectedMethodDisplay.textContent = `${methodName} - ${methodDescription}`;

            selectedAccountDetails.innerHTML = `
                <p>Pembayaran via ${methodName}:</p>
                <p class="account-number">${accountNumber} (A/N ${accountName})</p>
                <p>Mohon transfer sesuai dengan jumlah total belanja.</p>
            `;
            selectedAccountDetails.style.display = 'block';

            paymentOptionsDropdown.style.display = 'none';
            toggleIcon.classList.remove('active');
        });
    });

    // Sembunyikan dropdown jika klik di luar area pemilihan
    document.addEventListener('click', (event) => {
        if (!paymentMethodsSelection.contains(event.target) && paymentOptionsDropdown.style.display === 'block') {
            paymentOptionsDropdown.style.display = 'none';
            toggleIcon.classList.remove('active');
        }
    });

    // --- Fungsionalitas Upload Bukti Pembayaran ---
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

    // --- Fungsionalitas Tombol Bayar (Menggunakan AJAX) ---
    if (payButton && paymentForm) {
        payButton.addEventListener('click', (event) => {
            event.preventDefault();

            const file = paymentProofInput.files[0];

            if (!selectedPaymentMethodId) { // Gunakan ID yang dipilih
                 Swal.fire({
                    icon: 'warning',
                    title: 'Metode Pembayaran Belum Dipilih',
                    text: 'Tolong pilih metode pembayaran Anda sebelum melanjutkan.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (!file) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Bukti Pembayaran Belum Diunggah',
                    text: 'Tolong masukkan bukti pembayaran Anda sebelum melanjutkan.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            const formData = new FormData(paymentForm);

            Swal.fire({
                title: 'Sedang Memproses Pembayaran...',
                text: 'Mohon tunggu sebentar.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(paymentForm.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pembayaran Berhasil!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = data.redirect_url;
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Pembayaran Gagal!',
                        text: data.message || 'Terjadi kesalahan saat memproses pembayaran.',
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan Jaringan!',
                    text: 'Tidak dapat menghubungi server. Mohon coba lagi.',
                    confirmButtonText: 'OK'
                });
            });
        });
    }
});