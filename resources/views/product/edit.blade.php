@extends('product.AddProduct-Layout')

@section('title', 'Edit Product')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/arrow.css') }}" />
<style>
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
<!-- Tombol back dengan arrow -->
<button type="button" class="back-arrow" onclick="window.location='{{ url('/product-management') }}'">
    <svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path d="M9.707 14.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L6.414 9H17a1 1 0 110 2H6.414l3.293 3.293a1 1 0 010 1.414z"/>
    </svg>
    Back
</button>

<h1>Edit Product</h1>

<form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="title">Book Title:</label>
    <input type="text" name="title" id="title" value="{{ old('title', $product->title) }}" required>

    <label for="author">Author:</label>
    <input type="text" name="author" id="author" value="{{ old('author', $product->author) }}" required>

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


    <button type="submit">Edit</button>
</form>
@endsection
