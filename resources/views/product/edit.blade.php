@extends('product.AddProduct-Layout')

@section('title', 'Edit Product')

@section('content')
<h1>Edit Product</h1>

<form action="{{ route('product.update', $products->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="title">Book Title:</label>
    <input type="text" name="title" id="title" value="{{ $products->judul_buku }}" required>

    <label for="author">Author:</label>
    <input type="text" name="author" id="author" value="{{ $products->penulis_buku }}" required>

   <label for="genre">Genre:</label>
        <select name="genre" id="genre" required>
            <option value="" disabled selected>Select genre</option>
            <option value="Romance">Romance</option>
            <option value="Fantacy">Fantasy</option>
            <option value="Horor">Horor</option>
            <option value="Mystery">Mystery</option>
            <option value="Sci-Fi">Sci-Fi</option>
            <option value="Comedy">Comedy</option>
            <option value="Drama">Drama</option>
            <option value="Thiller">Thiller</option>
        </select>


    <label for="price">Price (Rp):</label>
    <input type="number" name="price" id="price" value="{{ $products->harga }}" required>

    <label for="stock">Stock:</label>
    <input type="number" name="stock" id="stock" value="{{ $products->stock }}" min="0" required>

    <label for="cover">Book Cover:</label>
    <input type="file" name="cover" id="cover" accept="image/*">
    <small>Current cover: <img src="{{ asset('storage/sampul/' . $products->gambar_sampul) }}" alt="Cover" style="max-width: 100px;"></small>

    <label for="description">Book Description:</label>
    <textarea name="description" id="description">{{ $products->sinopsis }}</textarea>

    <button type="submit">Edit</button>
    <button type="button" onclick="window.location='{{ url('/product-management') }}'">Back</button>
</form>
@endsection
