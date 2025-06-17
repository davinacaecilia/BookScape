@extends('admin.product-create-layout')

@section('title', 'Detail Order')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/arrow.css') }}" />
<style>
    /* Style form container */
    .order-detail {
        max-width: 600px;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    /* Style label & input/textarea */
    label {
        font-weight: 600;
        margin-bottom: 0.3rem;
        display: block;
        color: var(--brown-medium);
    }

    input[type="text"],
    textarea {
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
</style>
@endsection
@section('content')
<!-- Tombol back dengan arrow -->
<button type="button" class="back-arrow" onclick="window.history.back()">
    <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path d="M9.707 14.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L6.414 9H17a1 1 0 110 2H6.414l3.293 3.293a1 1 0 010 1.414z"/>
    </svg>
    Back
</button>

<h1>Detail Order</h1>

    <div class="order-detail">
        <div>
            <label>Order ID:</label>
            <input type="text" value="ORDER12345" readonly>
        </div>
        <div>
            <label>Order Date:</label>
            <input type="text" value="30-05-2025" readonly>
        </div>
        <div>
    </div>

    </div>
    <div>
        <label>Buyer Name:</label>
        <input type="text" value="Igun Dwikasih" readonly>
    </div>
    <div>
        <label>Email:</label>
        <input type="text" value="igundw@example.com" readonly>
    </div>
    <div>
        <label>Phone:</label>
        <input type="text" value="+62 812 3456 7890" readonly>
    </div>
    <div>
        <label>Shipping Address:</label>
        <textarea readonly>Jl. Merdeka No. 123, Bandung, Jawa Barat</textarea>
    </div>
    <div>
        <label>Payment Method:</label>
        <input type="text" value="Credit Card" readonly>
    </div><br>
    <div>
        <label>Books Ordered:</label>
        <ul class="book-list">
            <li>
                <strong>Harry Potter</strong> by J.K. Rowling <br>
                Genre: Fantasy <br>
                Price: Rp 120.000 <br>
                Quantity: 1 <br>
                Subtotal: Rp 120.000
            </li>
            <hr class="divider">
            <li>
                <strong>Atomic Habits</strong> by James Clear <br>
                Genre: Self-help <br>
                Price: Rp 80.000 <br>
                Quantity: 2 <br>
                Subtotal: Rp 160.000
            </li>
        </ul>
    </div>
    <div>
    <div>
    <label>Total Price (incl. shipping):</label>
    <input type="text" value="Rp 300.000" readonly>
</div>
<!-- Tambahan status dropdown -->
<div>
    <label>Status:</label>
    <select name="status" id="status-select" style="width: 100%; padding: 0.5rem; border: 1px solid var(--brown-light); border-radius: 4px; font-size: 0.9rem;">
        <option value="Pending" selected>Pending</option>
        <option value="Process">Process</option>
        <option value="Completed">Completed</option>
        <option value="Canceled">Canceled</option>
    </select>
</div>

<!-- Bukti pembayaran -->
<div style="margin-top: 1rem;">
    <label>Bukti Pembayaran:</label>
    <img src="{{ asset('images/bukti-pembayaran.jpg') }}" alt="Bukti Pembayaran" style="max-width: 100%; height: auto; border: 1px solid var(--brown-light); border-radius: 4px;">
</div>
  </div>
      <button type="submit">Approve</button>
    </form>
</div>
@endsection
