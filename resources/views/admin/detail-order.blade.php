@extends('admin.product-create-layout') {{-- Pastikan layout ini benar --}}

@section('title', 'Detail Order')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/arrow.css') }}" />
<style>
    .order-detail {
        max-width: 600px;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    label {
        font-weight: 600;
        margin-bottom: 0.3rem;
        display: block;
        color: var(--brown-medium);
    }

    input[type="text"],
    textarea,
    select { /* Tambahkan select */
        width: 100%;
        padding: 0.5rem;
        border: 1px solid var(--brown-light);
        border-radius: 4px;
        background-color: #fff;
        color: #333;
        resize: vertical;
        font-size: 0.9rem;
    }

    textarea {
        min-height: 80px;
    }

    ul.book-list {
        padding-left: 1.2rem;
        margin: 0;
        list-style-type: disc;
    }

    ul.book-list li {
        margin-bottom: 0.7rem;
        line-height: 1.3;
    }

    hr.divider {
        margin: 0.5rem 0;
        border: none;
        border-top: 1px solid var(--brown-light);
    }

    .status { /* Pastikan Anda memiliki styling untuk class status */
        padding: 0.3em 0.6em;
        border-radius: 4px;
        font-size: 0.85em;
        font-weight: bold;
        color: white; /* Default color */
    }
    .status.pending { background-color: orange; }
    .status.waiting_payment_confirmation { background-color: rgb(139, 139, 41); } /* Warna custom */
    .status.process { background-color: blue; }
    .status.arrived { background-color: purple; }
    .status.completed { background-color: green; }
    .status.canceled { background-color: red; }

    .payment-proof-image {
        max-width: 100%;
        height: auto;
        border: 1px solid var(--brown-light);
        border-radius: 4px;
        display: block; /* Agar tidak ada ruang ekstra di bawah gambar */
        margin-top: 0.5rem;
    }
</style>
@endsection

@section('content')
<button type="button" class="back-arrow" onclick="window.location.href = '{{ route('admin.orders') }}'">
    <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path d="M9.707 14.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L6.414 9H17a1 1 0 110 2H6.414l3.293 3.293a1 1 0 010 1.414z"/>
    </svg>
    Back
</button>

<h1>Detail Order</h1>

{{-- Form untuk update status order. Action dan method akan diisi oleh JavaScript --}}
{{-- Anda bisa membuat endpoint API terpisah untuk update status jika tidak mau submit form full --}}
<form id="updateOrderStatusForm" action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
    @csrf
    @method('POST') {{-- Atau PUT jika Anda menggunakan PUT method di route --}}

    <div class="order-detail">
        <div>
            <label>Order ID:</label>
            <input type="text" value="{{ $order->id }}" readonly>
        </div>
        <div>
            <label>Order Date:</label>
            <input type="text" value="{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i') }}" readonly>
        </div>
        {{-- Penutup div yang hilang di sini --}}
    </div> {{-- Penutup div yang hilang --}}

    {{-- Perbaiki struktur div --}}
    <div>
        <label>Buyer Name:</label>
        <input type="text" value="{{ $order->user->name ?? 'N/A' }}" readonly> {{-- Menggunakan $order->user->name jika ada kolom 'name' di User --}}
    </div>
    <div>
        <label>Email:</label>
        <input type="text" value="{{ $order->user->email ?? 'N/A' }}" readonly>
    </div>
    <div>
        <label>Phone:</label>
        <input type="text" value="{{ $order->alamat->phone ?? '+62 [Nomor Telepon Tidak Tersedia]' }}" readonly> {{-- Asumsi ada kolom 'phone' di tabel users --}}
    </div>
    <div>
        <label>Shipping Address:</label>
        <textarea readonly>{{ $order->alamat->address ?? 'Alamat tidak tersedia. (Pastikan kolom ada di tabel orders)' }}</textarea> {{-- Asumsi ada kolom 'shipping_address' di tabel orders --}}
    </div>
    <div>
        <label>Payment Method:</label>
        <input type="text" value="{{ $order->paymentMethod->name ?? 'N/A' }}" readonly> {{-- Mengambil nama metode pembayaran --}}
    </div><br>
    <div>
        <label>Books Ordered:</label>
        <ul class="book-list">
        @if($order->items->isEmpty()) {{-- Gunakan orderItems sesuai relasi --}}
			<li>Tidak ada buku dalam pesanan ini.</li>
		@else
			@foreach($order->items as $item)
                <li>
                    <strong>{{ $item->buku->judul_buku ?? 'Buku Tidak Ditemukan' }}</strong> by {{ $item->buku->penulis_buku ?? 'Penulis Tidak Ditemukan' }}<br>
                    Genre: {{ $item->buku->genres->pluck('genre')->join(', ') ?? 'N/A' }} <br> {{-- Asumsi buku punya relasi genres --}}
                    Price: Rp {{ number_format($item->price, 0, ',', '.') }} <br>
                    Quantity: {{ $item->quantity }} <br>
                    Subtotal: Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                </li>
            <hr class="divider">
			@endforeach
		@endif
        </ul>
    </div>
    <div> {{-- Ini adalah div penutup untuk bagian di atas --}}
        <label>Total Price (incl. shipping):</label>
        <input type="text" value="Rp {{ number_format($order->total_price, 0, ',', '.') }}" readonly>
    </div>
    {{-- Tambahan status dropdown --}}
    <div>
        <div>
    <label>Status:</label>
    @php
        $currentOrderStatus = strtolower($order->status);
        $disableStatusChange = in_array($currentOrderStatus, ['arrived', 'completed', 'canceled']); // Status-status yang tidak bisa diubah lagi oleh admin
    @endphp
    <select name="status" id="status-select"
            style="width: 100%; padding: 0.5rem; border: 1px solid var(--brown-light); border-radius: 4px; font-size: 0.9rem;"
            {{ $disableStatusChange ? 'disabled' : '' }}> {{-- Tambahkan atribut disabled di sini --}}
        {{-- Loop untuk status agar dinamis --}}
        @php
            $statuses = ['pending', 'process', 'arrived', 'canceled', 'completed'];
        @endphp
        @foreach($statuses as $statusOption)
            <option value="{{ $statusOption }}" {{ $currentOrderStatus === $statusOption ? 'selected' : '' }}>
                {{ ucwords(str_replace('_', ' ', $statusOption)) }}
            </option>
        @endforeach
    </select>
    @if ($disableStatusChange)
        <p style="color: red; font-size: 0.85em; margin-top: 0.5em;">Status order tidak dapat diubah lagi.</p>
    @endif
</div>

    </div>

    <div style="margin-top: 1rem;">
        <label>Bukti Pembayaran:</label>
        @if($order->payment_proof)
            <img src="{{ asset('storage/bukti/' . $order->payment_proof) }}" alt="Bukti Pembayaran" class="payment-proof-image">
        @else
            <p>Tidak ada bukti pembayaran diunggah.</p>
        @endif
    </div>

   {{-- Juga tambahkan kondisi untuk tombol submit --}}
@if (!$disableStatusChange)
    <button type="submit" style="margin-top: 1.5rem; padding: 0.7rem 1.2rem; background-color: var(--brown-dark); color: white; border: none; border-radius: 5px; cursor: pointer;">Update Status Order</button>
@else
    <button type="button" disabled style="margin-top: 1.5rem; padding: 0.7rem 1.2rem; background-color: #cccccc; color: #666666; border: none; border-radius: 5px; cursor: not-allowed;">Status Order Tidak Dapat Diubah</button>
@endif
</form> {{-- Penutup form --}}

@endsection