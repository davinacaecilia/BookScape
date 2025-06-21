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
    <form id="checkout-form" action="{{ route('order.place') }}" method="POST"> {{-- PASTIKAN ID="checkout-form" --}}
        @csrf

        {{-- Logika untuk membedakan Order Now dan Cart Checkout --}}
        @php
            $isBuyNow = ($orderItems->count() === 1 && $orderItems->first()->id === null);
        @endphp

        @if ($isBuyNow)
            <input type="hidden" name="buku_id" value="{{ $orderItems->first()->buku->id }}">
            <input type="hidden" name="quantity" value="{{ $orderItems->first()->quantity }}">
            <input type="hidden" name="is_buy_now" value="1"> {{-- Flag untuk Order Now --}}
        @else
            <input type="hidden" name="selected_cart_ids" value="{{ implode(',', $orderItems->pluck('id')->toArray()) }}">
        @endif
        
        {{-- input hidden untuk selected_address_id sudah di order-cart.blade.php dan akan diisi JS --}}

        <button class="btn-pay-now" type="submit">Lanjutkan Pembayaran</button>
    </form>
</div>