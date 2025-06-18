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
</head>
<body>

@include('produk.navbar2')

<main class="main-content">
    <section class="payment-section">
        <div class="payment-card">
            <div class="payment-header">
                <h2>Method Payment</h2>
            </div>

<div class="payment-methods-selection">
                <div class="selected-method-display">
                    <p>Pilih Metode Pembayaran</p>
                    <i class='bx bx-chevron-down toggle-icon'></i>
                </div>

                <div class="payment-options-dropdown" style="display: none;">
                    <label class="payment-option-item">
                        <div class="method-details">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5c/Bank_Central_Asia.svg/1200px-Bank_Central_Asia.svg.png" alt="BCA" class="bank-icon">
                            <span>BCA</span>
                        </div>
                        <input type="radio" name="paymentMethod" value="BCA">
                    </label>
                    <label class="payment-option-item">
                        <div class="method-details">
                            <img src="https://developers.bri.co.id/sites/default/files/inline-images/BRIVA-BRI.jpg" alt="BRIVA" class="ewallet-icon">
                            <span>BRIVA</span>
                        </div>
                        <input type="radio" name="paymentMethod" value="BRIVA">
                    </label>
                    <label class="payment-option-item">
                        <div class="method-details">
                            <img src="https://upload.wikimedia.org/wikipedia/id/thumb/f/fa/Bank_Mandiri_logo.svg/2560px-Bank_Mandiri_logo.svg.png" alt="Mandiri" class="bank-icon">
                            <span>Mandiri</span>
                        </div>
                        <input type="radio" name="paymentMethod" value="Mandiri">
                    </label>
                    <label class="payment-option-item">
                        <div class="method-details">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/2560px-Logo_dana_blue.svg.png" alt="DANA" class="ewallet-icon">
                            <span>DANA</span>
                        </div>
                        <input type="radio" name="paymentMethod" value="DANA">
                    </label>
                </div>

                <div class="selected-account-details">
                    </div>
            </div>

            <div class="payment-proof-upload">
                <h3>Upload Bukti Pembayaran</h3>
                <label for="paymentProofInput" class="upload-btn">
                    <i class='bx bx-upload'></i> Pilih Gambar
                    <input type="file" id="paymentProofInput" accept="image/*" class="hidden-input">
                </label>
                <span id="fileNameDisplay" class="file-name-display">Belum ada gambar terpilih</span>
                <img id="imagePreview" src="#" alt="Image Preview" class="image-preview" style="display: none;">
            </div>

            <button class="pay-button">Bayar</button>
        </div>
    </section>
</main>

  @include('produk.footer')

<script src="{{ asset('produk/js/payment.js') }}"></script>
</body>
</html>
