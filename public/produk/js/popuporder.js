// public/produk/js/popuporder.js - VERSI FINAL YANG SUDAH DIPERIKSA

document.addEventListener("DOMContentLoaded", function () {
    const createAddressBtn = document.querySelector(".btn-create-address");
    const addressModalOverlay = document.getElementById("addressModalOverlay");
    const addressForm = document.getElementById("addressForm");
    const closeModalBtn = document.querySelector(".close-modal-btn");
    const addressListContainer = document.getElementById("addressList");

    if (!createAddressBtn || !addressModalOverlay || !addressForm) {
        return;
    }

    function showModal() {
        const primaryPhone = createAddressBtn.dataset.phone;
        const primaryAddress = createAddressBtn.dataset.address;

        document.querySelector('#addressForm input[name="phone"]').value =
            primaryPhone || "";
        document.querySelector('#addressForm textarea[name="address"]').value =
            primaryAddress || "";

        addressModalOverlay.style.display = "flex";
    }

    function hideModal() {
        addressModalOverlay.style.display = "none";
    }

    window.saveAddress = function () {
        const formData = new FormData(addressForm);
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        const formActionUrl = addressForm.action;

        fetch(formActionUrl, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                Accept: "application/json",
            },
            body: formData,
        })
            .then((response) => {
                if (!response.ok) {
                    return response.json().then((err) => {
                        throw err;
                    });
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil!",
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false,
                    });

                    const noAddressText =
                        document.getElementById("noAddressText");
                    if (noAddressText) noAddressText.remove();

                    // Mengganti isi div, bukan menambah
                    const addressDisplayContainer =
                        document.getElementById("addressList");
                    // Kosongkan dulu isinya untuk memastikan hanya satu yang tampil
                    addressDisplayContainer.innerHTML = "";

                    const newAddressDiv = document.createElement("div");
                    newAddressDiv.classList.add("address-item");
                    newAddressDiv.innerHTML = `
                <div class="address-item-radio">
                    <input type="radio" name="selected_address" value="${data.alamat.id}" id="alamat-${data.alamat.id}" checked>
                    <label for="alamat-${data.alamat.id}">
                        <strong>Alamat Pengiriman:</strong>
                        <p>${data.alamat.phone}</p>
                        <p>${data.alamat.address}</p>
                    </label>
                </div>
                `;
                    addressListContainer.appendChild(newAddressDiv);

                    hideModal();
                }
            })
            .catch((error) => {
                let errorMessages = "Terjadi kesalahan.";
                if (error && error.errors) {
                    errorMessages = Object.values(error.errors)
                        .map((err) => `<li>${err[0]}</li>`)
                        .join("");
                    // INI BARIS YANG SUDAH DIPERBAIKI DENGAN BENAR
                    errorMessages = `<ul style="text-align:left; padding-left:20px;">${errorMessages}</ul>`;
                }

                Swal.fire({
                    icon: "error",
                    title: "Gagal Menyimpan",
                    html: errorMessages,
                });
            });
    };

    createAddressBtn.addEventListener("click", showModal);
    closeModalBtn.addEventListener("click", hideModal);
    addressForm.addEventListener("submit", saveAddress);
});
