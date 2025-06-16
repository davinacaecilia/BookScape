@extends('product.AddProduct-Layout')

@section('title', 'Reply Message')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/arrow.css') }}" />
@endsection

@section('content')
<button type="button" class="back-arrow" onclick="window.history.back()">
    <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path d="M9.707 14.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L6.414 9H17a1 1 0 110 2H6.414l3.293 3.293a1 1 0 010 1.414z"/>
    </svg>
    Back
</button>

<h1>Reply to Customer</h1>

<form action="#" method="POST">
    @csrf
    <label>To</label>
    <input type="text" value="@johndoe" readonly>

    <label>Original Message</label>
    <textarea readonly>Hello, I need help with my order!</textarea>

    <label>Your Reply</label>
    <textarea name="reply" placeholder="Type your message here..." required></textarea>

    <button type="submit">Send Reply</button>
</form>
@endsection
