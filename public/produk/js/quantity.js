const cartCards = document.querySelectorAll('.cart-card, .detail-orderan');

cartCards.forEach(card => {
  const minusBtn = card.querySelector('.minus-btn');
  const plusBtn = card.querySelector('.plus-btn');
  const quantityDisplay = card.querySelector('.quantity-display');
  const cartId = card.dataset.id;

  function updateQuantityToServer(newQty) {
    if (!cartId) return;
    const formData = new FormData();
    formData.append('cart_id', cartId);
    formData.append('quantity', newQty);

    fetch('/cart/update-quantity', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json'
      },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (!data.success) {
        console.error('Gagal update kuantitas di server.');
      }
    })
    .catch(err => console.error('Fetch error:', err));
  }

  function updateFrontendSummary() {
    // Ambil semua order-item (biasanya cuma 1 di order-now)
    const orderItems = document.querySelectorAll('.order-item');
    let total = 0;
    let totalQty = 0;

    orderItems.forEach(order => {
      const qty = parseInt(order.querySelector('.quantity-display')?.textContent || '1');
      const priceText = order.querySelector('.item-price-per-unit')?.textContent || 'Rp 0';
      const price = parseInt(priceText.replace(/[^0-9]/g, ''));

      total += price * qty;
      totalQty += qty;
    });

    const shipping = Math.round(total * 0.10);
    const grandTotal = total + shipping;

    // Ini pastikan sesuai dengan struktur HTML-mu
    const summarySection = document.querySelector('.summary-section');
    if (summarySection) {
      const summaryItems = summarySection.querySelectorAll('.summary-item');

      if (summaryItems[0]) {
        summaryItems[0].querySelectorAll('span')[0].textContent = `Total Harga (${totalQty} Barang)`;
        summaryItems[0].querySelectorAll('span')[1].textContent = `Rp ${total.toLocaleString('id-ID')}`;
      }

      if (summaryItems[1]) {
        summaryItems[1].querySelectorAll('span')[1].textContent = `Rp ${shipping.toLocaleString('id-ID')}`;
      }

      if (summaryItems[2]) {
        summaryItems[2].querySelectorAll('span')[1].textContent = `Rp ${grandTotal.toLocaleString('id-ID')}`;
      }
    }
  }


if (plusBtn) {
    plusBtn.addEventListener('click', () => {
      let current = parseInt(quantityDisplay.textContent);
      current++;
      quantityDisplay.textContent = current;
      updateQuantityToServer(current);
      updateFrontendSummary();
    });
  }

  if (minusBtn) {
    minusBtn.addEventListener('click', () => {
      let current = parseInt(quantityDisplay.textContent);
      if (current > 1) {
        current--;
        quantityDisplay.textContent = current;
        updateQuantityToServer(current);
        updateFrontendSummary();
      }
    });
  }
});