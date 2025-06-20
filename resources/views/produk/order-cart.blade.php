<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Your Cart — Bookscape</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('produk/order.css') }}" />
    <link rel="stylesheet" href="{{ asset('produk/navbar2.css') }}" />
    <link rel="stylesheet" href="{{ asset('produk/footer.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    @include('produk.navbar2')

    <main class="order-main-content">
        <div class="left-column">
            <div class="address-section card">
                <h3>Alamat Pengiriman</h3>
                <div id="addressList" class="address-list">
                    @forelse ($alamatUser as $alamat)
                        <div class="address-item" data-id="{{ $alamat->id }}">
                            <div class="address-item-radio">
                                <label for="alamat-{{ $alamat->id }}">
                                    <p>{{ $alamat->address }}</p>
                                </label>
                            </div>
                        </div>
                    @empty
                        <p id="noAddressText" class="no-address-text">Anda belum memiliki alamat pengiriman.</p>
                    @endforelse
                </div>

                <button class="btn-create-address" data-phone="{{ Auth::user()->primaryAlamat?->phone }}"
                    data-address="{{ Auth::user()->primaryAlamat?->address }}">
                    <i class='bx bx-plus'></i> Buat Alamat
                </button>
            </div>

            <div class="detail-order-section card">
                <h3>Detail Orderan</h3>
                @foreach ($orderItems as $item)
                    <div class="order-item">
                        <img src="{{ asset('storage/sampul/' . $item->buku->gambar_sampul) }}"
                            alt="{{ $item->buku->judul_buku }}">
                        <div class="item-info">
                            <h4>{{ $item->buku->judul_buku }}</h4>
                            <p>{{ $item->buku->penulis_buku }}</p>
                            <p class="quantity">Jumlah: {{ $item->quantity }}</p>
                        </div>
                        <span class="item-price">Rp
                            {{ number_format($item->buku->harga * $item->quantity, 0, ',', '.') }}</span>
                    </div>
                @endforeach


                <div class="order-subtotal total-summary">
                    <span>Total Pesanan</span>
                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
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