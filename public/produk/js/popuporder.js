// popuporder.js

// Targetkan tombol "Tambahkan Alamat" di order-now.blade.php
const addAddressButton = document.getElementById('addAddressButton');

// Targetkan tombol "Create Address" yang mungkin ada di halaman lain
// Pastikan elemen dengan kelas 'btn-create-address' ada di halaman tersebut
const createAddressBtn = document.querySelector('.btn-create-address');


const addressModalOverlay = document.getElementById('addressModalOverlay');
const closeModalBtn = document.querySelector('.close-modal-btn');
const saveAddressBtn = document.querySelector('.btn-save-address');
// Input fields
const namaPenerimaInput = document.getElementById('namaPenerima');
const emailInput = document.getElementById('email');
const noTelpInput = document.getElementById('noTelp');
const alamatLengkapTextarea = document.getElementById('alamatLengkap');

function showModal() {
    addressModalOverlay.style.display = 'flex';
    // Optional: Reset form fields when opening
    namaPenerimaInput.value = '';
    emailInput.value = '';
    noTelpInput.value = '';
    alamatLengkapTextarea.value = '';
}

function hideModal() {
    addressModalOverlay.style.display = 'none';
}

// Tambahkan event listener untuk addAddressButton
if (addAddressButton) {
    addAddressButton.addEventListener('click', showModal);
}

// Tambahkan event listener untuk createAddressBtn
if (createAddressBtn) { // Pastikan tombol ini ada di halaman
    createAddressBtn.addEventListener('click', showModal);
}

closeModalBtn.addEventListener('click', hideModal);
addressModalOverlay.addEventListener('click', (event) => {
    if (event.target === addressModalOverlay) {
        hideModal();
    }
});

saveAddressBtn.addEventListener('click', () => {
    const namaPenerima = namaPenerimaInput.value.trim();
    const noTelp = noTelpInput.value.trim();
    const alamatLengkap = alamatLengkapTextarea.value.trim();

    // Cek apakah semua field wajib terisi
    const isMandatoryFieldsFilled = namaPenerima !== '' && emailInput.value.trim() !== '' && noTelp !== '' && alamatLengkap !== '';

    if (isMandatoryFieldsFilled) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil Disimpan!',
            text: 'Detail alamat Anda telah berhasil disimpan.',
            showConfirmButton: false,
            timer: 1500
        });

        hideModal();
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Input Tidak Lengkap',
            text: 'Mohon lengkapi Nama Lengkap, Email, No. Telp, dan Shipping Address.',
        });
    }
});
