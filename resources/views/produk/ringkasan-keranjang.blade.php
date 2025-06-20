<div class="summary-section card">
        <h3>Ringkasan Belanja</h3>
        <div class="summary-details">
            <div class="summary-item">
                <span>Total Harga ({{ $orderItems->sum('quantity') }} Barang)</span>
                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="summary-item">
                <span>Total Biaya Pengiriman</span>
                <span>Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
            </div>
            <div class="summary-item total-summary">
                <span>Total Belanja</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>
        <button class="btn-pay-now">Lanjutkan Pembayaran</button>
    </div>
