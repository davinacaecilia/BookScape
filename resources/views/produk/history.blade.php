<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>History order — Bookscape</title>
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('produk/history.css') }}"/>
  <link rel="stylesheet" href="{{ asset('produk/navbar2.css') }}"/>
  <link rel="stylesheet" href="{{ asset('produk/footer.css') }}"/>
</head>
<body>

@include('produk.navbar2')

  <main class="order-history-container">
  <div class="order-card">
    <div class="order-details">
      <h3 class="order-title">The Hunger Games</h3>
      <p class="order-price">IDR 75.000,00</p>
    </div>
    <div class="order-status">
      <button class="status completed">Completed</button>
    </div>
  </div>

  <div class="order-card">
    <div class="order-details">
      <h3 class="order-title">Laskar Pelangi</h3>
      <p class="order-price">IDR 85.000,00</p>
    </div>
    <div class="order-status">
      <button class="status process">Process</button>
    </div>
  </div>

  <div class="order-card">
    <div class="order-details">
      <h3 class="order-title">Bumi Manusia</h3>
      <p class="order-price">IDR 90.000,00</p>
    </div>
    <div class="order-status">
      <button class="status pending">Pending</button>
    </div>
  </div>

  <div class="order-card">
    <div class="order-details">
      <h3 class="order-title">Koala Kumal</h3>
      <p class="order-price">IDR 67.000,00</p>
    </div>
    <div class="order-status">
      <button class="status canceled">Canceled</button>
    </div>
  </div>
  </main>

@include('produk.footer')

<script src="{{ asset('produk/js/history.js') }}"></script>
</body>
</html>
