document.addEventListener('DOMContentLoaded', function() {
    const addressRadios = document.querySelectorAll('.address-radio');
    const selectedAddressIdInput = document.getElementById('selectedAddressIdInput');
    const checkoutForm = document.getElementById('checkout-form'); // Asumsi form checkout ada di ringkasan-keranjang.blade.php

    // Fungsi untuk menandai alamat yang dipilih dan mengupdate input hidden
    function selectAddress(addressId) {
        addressRadios.forEach(radio => {
            if (radio.value == addressId) {
                radio.checked = true;
                radio.closest('.address-item').classList.add('selected');
            } else {
                radio.checked = false;
                radio.closest('.address-item').classList.remove('selected');
            }
        });
        selectedAddressIdInput.value = addressId; // Simpan ID alamat yang dipilih
    }

    // Event listener untuk setiap radio button alamat
    addressRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            selectAddress(this.value);
        });
    });

    // Inisialisasi: Pilih alamat pertama secara default jika ada
    if (addressRadios.length > 0) {
        addressRadios[0].checked = true;
        selectAddress(addressRadios[0].value);
    } else {
        // Jika tidak ada alamat, pastikan input hidden kosong
        selectedAddressIdInput.value = '';
    }

    // Validasi saat form checkout disubmit
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(event) {
            if (!selectedAddressIdInput.value) {
                event.preventDefault(); // Mencegah submit form
                Swal.fire({
                    icon: 'warning',
                    title: 'Alamat Pengiriman Belum Dipilih',
                    text: 'Mohon pilih salah satu alamat pengiriman Anda.',
                    confirmButtonText: 'OK'
                });
            }
            // Jika alamat dipilih, form akan disubmit secara normal
        });
    }

    // --- LOGIKA UNTUK POPUP ALAMAT (dari popuporder.js) ---
    // Pindahkan logika pembuatan/edit alamat dari popuporder.js ke sini
    // atau pastikan popuporder.js dimuat SETELAH order-address.js
    // dan memiliki fungsi yang bisa diakses (misal: window.showAddressForm)
    // Untuk kesederhanaan, saya asumsikan logika popuporder.js tidak berkonflik
    // dan btn-create-address masih memicu popup yang sama.

    // Contoh untuk btn-create-address (Jika Anda memindahkan popup logic ke sini)
    // const createAddressBtn = document.querySelector('.btn-create-address');
    // const addAddressModal = document.getElementById('addAddressModal'); // Asumsi ada modal ini
    // if (createAddressBtn && addAddressModal) {
    //     createAddressBtn.addEventListener('click', () => {
    //         // Logika untuk menampilkan modal dan mengisi form
    //         addAddressModal.classList.add('show');
    //     });
    //     // Logika untuk simpan alamat baru melalui AJAX di sini
    // }
});