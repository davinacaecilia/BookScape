document.addEventListener('DOMContentLoaded', () => {
  const selectAllCheckbox = document.getElementById('selectAllItems');
  let itemCheckboxes = document.querySelectorAll('.cart-card .item-checkbox');
  const deleteAllSelectedButton = document.querySelector('.delete-selected-btn');

  function updateDeleteButtonState() {
    const anyItemSelected = Array.from(itemCheckboxes).some(checkbox => checkbox.checked);
    if (anyItemSelected) {
      deleteAllSelectedButton.removeAttribute('disabled');
    } else {
      deleteAllSelectedButton.setAttribute('disabled', 'true');
    }
  }

  function updateCartSummary() {
    let total = 0;
    let totalQty = 0;

    document.querySelectorAll('.cart-card').forEach(card => {
      const checkbox = card.querySelector('.item-checkbox');
      if (!checkbox || !checkbox.checked) return;

      const priceText = card.querySelector('.item-price')?.innerText || '0';
      const price = parseInt(priceText.replace(/[^0-9]/g, ''));

      const qtyText = card.querySelector('.quantity-display')?.innerText || '1';
      const quantity = parseInt(qtyText);

      total += price * quantity;
      totalQty += quantity;
    });

    const summaryLabel = document.querySelector('.summary-line .summary-label');
    const summaryValue = document.querySelectorAll('.summary-value');

    if (summaryLabel) summaryLabel.innerText = `Total harga (${totalQty} barang)`;
    summaryValue.forEach(el => el.innerText = `Rp ${total.toLocaleString('id-ID')}`);
  }

  function displayEmptyCartMessage() {
    const cartItemsContainer = document.querySelector('.cart-items-container');
    itemCheckboxes = document.querySelectorAll('.cart-card .item-checkbox');

    if (itemCheckboxes.length === 0 && cartItemsContainer) {
      let emptyCartMessage = document.createElement('p');
      emptyCartMessage.textContent = 'Keranjang Anda kosong.';
      emptyCartMessage.style.textAlign = 'center';
      emptyCartMessage.style.marginTop = '20px';
      emptyCartMessage.style.color = 'var(--text-dark)';
      emptyCartMessage.style.fontSize = '1.2em';
      cartItemsContainer.innerHTML = '';
      cartItemsContainer.appendChild(emptyCartMessage);
    }
  }

  // --- DELETE INDIVIDU PAKAI FORM ---
  document.querySelectorAll('.delete-cart-form').forEach(form => {
    const button = form.querySelector('.item-delete-btn');
    button.addEventListener('click', function (e) {
      e.preventDefault();

      Swal.fire({
        title: 'Hapus Item Ini?',
        text: 'Item ini akan dihapus dari keranjang Anda.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: 'gray',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });

  // --- DELETE SELECTED PAKAI FORM ---
  if (deleteAllSelectedButton) {
    deleteAllSelectedButton.addEventListener('click', () => {
      const selectedCheckboxes = Array.from(itemCheckboxes).filter(cb => cb.checked);

      if (selectedCheckboxes.length === 0) return;

      Swal.fire({
        title: 'Hapus Produk',
        text: 'Produk yang dipilih akan dihapus dari keranjang.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: 'gray',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          selectedCheckboxes.forEach(cb => {
            const form = cb.closest('.cart-card').querySelector('.delete-cart-form');
            if (form) form.submit();
          });
        }
      });
    });
  }


  // --- SELECT ALL ---
  if (selectAllCheckbox) {
    selectAllCheckbox.addEventListener('change', (e) => {
      const isChecked = e.target.checked;
      itemCheckboxes.forEach(checkbox => checkbox.checked = isChecked);
      updateDeleteButtonState();
      updateCartSummary();
    });
  }

  // --- PER ITEM CHECKBOX ---
  itemCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', () => {
      const allItemsChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
      if (selectAllCheckbox) {
        selectAllCheckbox.checked = allItemsChecked;
      }
      updateDeleteButtonState();
      updateCartSummary();
    });
  });

  updateDeleteButtonState();
  updateCartSummary();
  displayEmptyCartMessage();
});
