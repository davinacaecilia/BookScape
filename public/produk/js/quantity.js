const cartCards = document.querySelectorAll('.cart-card');

cartCards.forEach(card => {
  const minusBtn = card.querySelector('.minus-btn');
  const plusBtn = card.querySelector('.plus-btn');
  const quantityDisplay = card.querySelector('.quantity-display');
  const cartId = card.dataset.id;

  function updateQuantityToServer(newQty) {
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

  if (plusBtn) {
    plusBtn.addEventListener('click', () => {
      let current = parseInt(quantityDisplay.textContent);
      current++;
      quantityDisplay.textContent = current;
      updateQuantityToServer(current);
      if (typeof updateCartSummary === 'function') updateCartSummary();
    });
  }

  if (minusBtn) {
    minusBtn.addEventListener('click', () => {
      let current = parseInt(quantityDisplay.textContent);
      if (current > 1) {
        current--;
        quantityDisplay.textContent = current;
        updateQuantityToServer(current);
        if (typeof updateCartSummary === 'function') updateCartSummary();
      }
    });
  }
});
