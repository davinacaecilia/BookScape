<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Your Cart — Bookscape</title>
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('produk/order.css') }}"/>
  <link rel="stylesheet" href="{{ asset('produk/navbar2.css') }}"/>
  <link rel="stylesheet" href="{{ asset('produk/footer.css') }}"/>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> </head>
<body>

@include('produk.navbar2')

<main class="order-main-content">
    <div class="left-column">
        <div class="address-section card">
            <h3>Alamat Pengiriman</h3>
            <div id="displayAddress" class="address-display"> <p class="no-address-text">Belum ada alamat yang terdaftar</p> </div>
            <button class="btn-create-address">Buat Alamat</button>
        </div>

        <div class="detail-order-section card">
            <h3>Detail Orderan</h3>
            <div class="order-item">
                <img src="https://ebooks.gramedia.com/ebook-covers/34734/big_covers/ID_KPG2016MTH10DDAG_B.jpg" alt="The Hunger Games">
                <div class="item-info">
                    <h4>The Hunger Games</h4>
                    <p>Suzanne Collins</p>
                    <p class="quantity">Jumlah: 1</p>
                </div>
                <span class="item-price">IDR 99.000,00</span>
            </div>
            <div class="order-item">
                <img src="https://ebooks.gramedia.com/ebook-covers/34734/big_covers/ID_KPG2016MTH10DDAG_B.jpg" alt="Perahu Kertas">
                <div class="item-info">
                    <h4>Perahu Kertas</h4>
                    <p>Dee Lestari</p>
                    <p class="quantity">Jumlah: 1</p>
                </div>
                <span class="item-price">IDR 100.000,00</span>
            </div>
            <div class="order-subtotal total-summary">
                <span>Total Pesanan</span>
                <span>IDR 199.000,00</span>
            </div>
        </div>
    </div>

    @include('produk.ringkasan-keranjang')
</main>

@include('produk.popup-order')

@include('produk.footer')


<script src="{{ asset('produk/js/popuporder.js') }}"></script>
</body>
</html>
