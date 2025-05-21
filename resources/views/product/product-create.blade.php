@extends('product.AddProduct-Layout')

@section('title', 'Add Product')

@section('head')
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
</style>
@endsection

@section('content')
    <h1>Add New Product</h1>

    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="title">Book Title:</label>
        <input type="text" name="title" id="title" placeholder="Enter book title" required>

        <label for="author">Author:</label>
        <input type="text" name="author" id="author" placeholder="Enter author name" required>

        <label for="genre">Genre:</label>
        <select name="genre" id="genre" required>
            <option value="" disabled selected>Select genre</option>
            <option value="Romance">Romance</option>
            <option value="Fantacy">Fantacy</option>
            <option value="Horor">Horor</option>
            <option value="Mystery">Mystery</option>
            <option value="Sci-Fi">Sci-Fi</option>
            <option value="Comedy">Comedy</option>
            <option value="Drama">Drama</option>
            <option value="Thiller">Thiller</option>
        </select>

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
    <button type="button" onclick="window.location='{{ url('/product-management') }}'">Back</button>
</form>

@endsection