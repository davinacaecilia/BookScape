@extends('product.AddProduct-Layout')

@section('title', 'Add Product')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/arrow.css') }}" />
<style>
    .stars {
        display: flex;
        flex-direction: row;
        gap: 5px;
        margin-top: 0.3rem;
    }
    .stars input {
        display: none;
    }
    .stars label {
        font-size: 1.8rem;
        color: #ccc;
        cursor: pointer;
        transition: color 0.2s;
    }
    .stars input:checked ~ label {
        color: gold;
    }
    .stars label:hover ~ label {
        color: #ccc;
    }
    .stars label {
        order: 1;
    }
    .genre-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0.5rem 1rem;
    margin-bottom: 1rem;
    }
    .genre-grid label {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
</style>
@endsection

@section('content')
<button type="button" class="back-arrow" onclick="window.location='{{ url('/product-management') }}'">
        <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path d="M9.707 14.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L6.414 9H17a1 1 0 110 2H6.414l3.293 3.293a1 1 0 010 1.414z"/>
        </svg>
        Back
    </button>

    <h1>Add New Product</h1>

    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="title">Book Title:</label>
        <input type="text" name="title" id="title" placeholder="Enter book title" required>

        <label for="author">Author:</label>
        <input type="text" name="author" id="author" placeholder="Enter author name" required>

        <label for="genre">Genre:</label>
        <div id="genre" class="genre-grid">
            <label><input type="checkbox" name="genre[]" value="Romance"> Romance</label>
            <label><input type="checkbox" name="genre[]" value="Fantacy"> Fantacy</label>
            <label><input type="checkbox" name="genre[]" value="Horor"> Horor</label>
            <label><input type="checkbox" name="genre[]" value="Mystery"> Mystery</label>
            <label><input type="checkbox" name="genre[]" value="Sci-Fi"> Sci-Fi</label>
            <label><input type="checkbox" name="genre[]" value="Comedy"> Comedy</label>
            <label><input type="checkbox" name="genre[]" value="Drama"> Drama</label>
            <label><input type="checkbox" name="genre[]" value="Thiller"> Thiller</label><br>
        </div>


        <label for="price">Price (Rp):</label>
        <input type="number" name="price" id="price" placeholder="example: 50000" required>

        <label for="stock">Stock:</label>
        <input type="number" name="stock" id="stock" placeholder="example: 20" min="0" required>

        <label for="cover">Book Cover:</label>
        <input type="file" name="cover" id="cover" accept="image/*">

        <label for="description">Book Description:</label>
        <textarea name="description" id="description" placeholder="Write a short description about the book..."></textarea>

        <button type="submit">Publish</button>
    </form>

    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    </form>

{{-- </section> --}} {{-- Ini baris komentar penutup section content --}}
@endsection