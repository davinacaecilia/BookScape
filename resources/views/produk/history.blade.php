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
  {{-- Sangat Penting: Tambahkan meta tag CSRF Token untuk AJAX requests --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">
  {{-- Sangat Penting: Tambahkan SweetAlert2 CDN di sini, sebelum JS Anda --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

@include('produk.navbar2')

<main class="order-history-container">
  {{-- PASTIKAN DUMMY DATA INI DIHAPUS ATAU DIKOMENTARI SEPENUHNYA --}}
  {{-- @php
    $groupedOrders = [
        // ... dummy data ...
    ];
  @endphp --}}

  {{-- Pastikan ini mengiterasi $orderedGroupedOrders dari UserController --}}
  @foreach($orderedGroupedOrders as $status => $orders)
    @if($orders->isNotEmpty())
    <div class="order-card" data-status-group="{{ strtolower($status) }}"> {{-- Tambahkan data-status-group --}}
      <div class="order-status-header">
        <button class="status {{ strtolower($status) }}">{{ $status }}</button>
        @if($status === 'Completed')
          <a href="#" class="rate-button">Rate</a>
        @elseif($status === 'Arrived')
          <button class="confirm-button">Confirm Order</button>
        @elseif($status === 'Pending')
          <button class="pending-action-button">Action</button>
        @endif
      </div>
      <div class="order-details-group">
        @foreach($orders as $order)
          @php
            $invoiceTotalPrice = $order->items->sum(fn($item) => $item->price * $item->quantity);
          @endphp

          {{-- Wrapper ini penting untuk mengikat data order keseluruhan ke tombol invoice --}}
          <div class="invoice-group-block"
               data-order-id="{{ $order->id }}"
               data-invoice-number="INV-{{ $order->id }}" {{-- Contoh nomor invoice --}}
               data-invoice-date="{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}"
               data-invoice-total-price="{{ $invoiceTotalPrice }}"
          >
            @foreach($order->items as $item) {{-- Iterasi setiap OrderItem di dalam Order --}}
              <div class="individual-order-item"
                   data-item-title="{{ $item->buku->judul_buku }}"
                   data-item-price="{{ $item->price }}" {{-- Harga per unit item --}}
                   data-item-quantity="{{ $item->quantity }}"
              >
                <div class="item-header">
                  <h3 class="order-title">{{ $item->buku->judul_buku }}</h3>
                  <p class="order-date">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</p>
                </div>
                <div class="item-footer">
                    <p class="order-price">IDR {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                    {{-- Container di mana tombol 'Lihat Invoice' akan dirender oleh JS --}}
                    <div class="invoice-buttons-per-group-container">
                        {{-- Button will be inserted here by history.js --}}
                    </div>
                </div>
              </div>
            @endforeach
          </div>
        @endforeach
      </div>
    </div>
    @endif
  @endforeach
</main>

{{-- Modal Popup untuk konfirmasi pesanan (Arrived -> Completed) --}}
<div id="confirmModal" class="modal">
  <div class="modal-content">
    <span class="close-button" data-modal-close="confirmModal">&times;</span>
    <h2>Konfirmasi Pesanan</h2>
    <p>Apakah Anda yakin ingin mengkonfirmasi pesanan ini?</p>
    <div class="modal-actions">
      <button id="cancelConfirm" class="btn cancel-btn">Batal</button>
      <button id="confirmOrder" class="btn confirm-btn">Konfirmasi</button>
    </div>
  </div>
</div>

{{-- Modal Popup untuk aksi pesanan Pending (Bayar / Batal) --}}
<div id="pendingActionModal" class="modal">
  <div class="modal-content">
    <span class="close-button" data-modal-close="pendingActionModal">&times;</span>
    <h2>Pesanan Anda Sedang Pending</h2>
    <p>Silakan selesaikan pembayaran atau batalkan pesanan Anda.</p>
    <div class="modal-actions">
      <button id="cancelPendingOrder" class="btn cancel-btn">Batalkan Pesanan</button>
      <button id="proceedToPayment" class="btn confirm-btn">Lanjutkan Pembayaran</button>
    </div>
  </div>
</div>

{{-- Modal Popup untuk menampilkan Invoice (STRUKTUR PENTING, HARUS KOSONG) --}}
<div id="invoiceModal" class="modal">
  <div class="modal-content invoice-content">
    <span class="close-button" data-modal-close="invoiceModal">&times;</span>
    <h2>Detail Invoice Pesanan</h2>
    {{-- Ini adalah DIV KOSONG tempat JS akan mengisi konten secara DINAMIS --}}
    <div id="invoiceDetailsDisplay">
      {{-- Konten invoice akan di-generate di sini oleh history.js --}}
    </div>
    <div class="modal-actions">
      <button class="btn confirm-btn" data-modal-close="invoiceModal">Tutup</button>
    </div>
  </div>
</div>

@include('produk.footer')

<script src="{{ asset('produk/js/history.js') }}"></script>
</body>
</html>