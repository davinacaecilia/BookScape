<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Cart — Bookscape</title>
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('produk/cart.css') }}"/>
  <link rel="stylesheet" href="{{ asset('produk/navbar2.css') }}"/>
  <link rel="stylesheet" href="{{ asset('produk/footer.css') }}"/>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

@include('produk.navbar2')

  <main class="cart-content-wrapper">
    <div class="cart-layout-container">
      <div class="cart-items-column">
        <div class="delete-all-selected-card">
          <div class="delete-all-left">
            <input type="checkbox" id="selectAllItems" class="item-checkbox">
            <label for="selectAllItems" class="select-all-label">Select All Items</label>
          </div>
          <button class="delete-selected-btn">
              <i class='bx bx-trash'></i> Delete Selected
          </button>
        </div>

        <div class="cart-items-container">
                @foreach($items as $item)
                <div class="cart-card" data-id="{{ $item->id }}">
                    <div class="item-checkbox-container">
                        <input type="checkbox" class="item-checkbox">
                    </div>
                    <div class="item-details">
                        <h3 class="item-title">{{ $item->buku->judul_buku }}</h3>
                        <p class="item-price">Rp {{ number_format( $item->buku->harga, 0, ',', '.') }}</p>
                    </div>
                    <div class="item-quantity-control">
                        <button class="quantity-btn minus-btn">-</button>
                        <span class="quantity-display">{{ $item->quantity }}</span>
                        <button class="quantity-btn plus-btn">+</button>
                    </div>
                    <form action="{{ route('cart.delete') }}" method="POST" class="delete-cart-form">
                      @csrf
                      <input type="hidden" name="cart_id" value="{{ $item->id }}">
                      <button type="submit" class="item-delete-btn">
                        <i class='bx bx-trash'></i>
                      </button>
                    </form>
                </div>
                @endforeach
        </div>
      </div>

      <div class="cart-summary-column">
        <div class="cart-summary-card">
            <h3 class="summary-title">Ringkasan Keranjang</h3>
            <div class="summary-line">
                <span class="summary-label">Total harga (<span id="total-item-count">0</span> barang)</span>
                <span class="summary-value">Rp 0</span>
            </div>
            <div class="summary-separator"></div>
            <div class="summary-line total-line">
                <span class="summary-label">Subtotal</span>
                <span class="summary-value">Rp 0</span>
            </div>
            <form id="checkout-form" action="{{ route('cart.checkout') }}" method="POST">
              @csrf
              <input type="hidden" name="selected_cart_ids" id="selectedCartIds">
              <button type="submit" class="checkout-btn">Checkout</button>
            </form>
        </div>
      </div>
    </div>
  </main>

  @if(session('success'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session("success") }}',
    timer: 2000,
    showConfirmButton: false
  });
</script>
@endif

@if(session('error'))
<script>
  Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: '{{ session("error") }}',
    timer: 2000,
    showConfirmButton: false
  });
</script>
@endif


@include('produk.footer')

<script src="{{ asset('produk/js/cart.js') }}"></script>
<script src="{{ asset('produk/js/quantity.js') }}"></script>
</body>
</html>
