<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Payment — Bookscape</title>
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('produk/payment.css') }}"/>
  <link rel="stylesheet" href="{{ asset('produk/navbar2.css') }}"/>
  <link rel="stylesheet" href="{{ asset('produk/footer.css') }}"/>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

@include('produk.navbar2')

<main class="main-content">
    <section class="payment-section">
        <div class="payment-card">
            <div class="payment-header">
                <h2>Method Payment</h2>
            </div>

            <form id="paymentForm" action="{{ route('payment.uploadProof', ['order' => $order->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="order_id" value="{{ $order->id }}">
                {{-- Ini akan diupdate oleh JS dengan ID metode pembayaran --}}
                <input type="hidden" name="payment_method_id" id="selectedPaymentMethodInput">

                <div class="payment-methods-selection">
                    <div class="selected-method-display">
                        <p>Pilih Metode Pembayaran</p>
                        <i class='bx bx-chevron-down toggle-icon'></i>
                    </div>

                    <div class="payment-options-dropdown" style="display: none;">
                        {{-- Loop melalui paymentMethods yang dikirim dari controller --}}
                        @foreach($paymentMethods as $method)
                        <label class="payment-option-item"
                               data-method-id="{{ $method->id }}"
                               data-method-name="{{ $method->name }}"
                               data-method-description="{{ $method->description }}"
                               data-method-account-number="{{ $method->account_number }}"
                               data-method-account-name="{{ $method->account_name }}">
                            <div class="method-details">
                                <img src="{{ $method->logo_path }}" alt="{{ $method->name }}" class="bank-icon">
                                <span>{{ $method->name }}</span>
                            </div>
                            <input type="radio" name="paymentMethod" value="{{ $method->id }}">
                        </label>
                        @endforeach
                    </div>

                    <div class="selected-account-details">
                        </div>
                </div>

                <div class="payment-proof-upload">
                    <h3>Upload Bukti Pembayaran</h3>
                    <label for="paymentProofInput" class="upload-btn">
                        <i class='bx bx-upload'></i> Pilih Gambar
                        <input type="file" id="paymentProofInput" name="payment_proof" accept="image/*" class="hidden-input">
                    </label>
                    <span id="fileNameDisplay" class="file-name-display">Belum ada gambar terpilih</span>
                    <img id="imagePreview" src="#" alt="Image Preview" class="image-preview" style="display: none;">
                </div>

                <button type="submit" class="pay-button">Bayar</button>
            </form>

        </div>
    </section>
</main>

  @include('produk.footer')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('produk/js/payment.js') }}"></script>
</body>
</html>