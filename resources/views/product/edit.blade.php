@extends('product.AddProduct-Layout')

@section('title', 'Edit Product')

@section('content')
<h1>Edit Product</h1>

<form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="title">Book Title:</label>
    <input type="text" name="title" id="title" value="{{ old('title', $product->title) }}" required>

    <label for="author">Author:</label>
    <input type="text" name="author" id="author" value="{{ old('author', $product->author) }}" required>

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
    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required>

    <label for="stock">Stock:</label>
    <input type="number" name="stock" id="stock" placeholder="example: 20" min="0" required>

    <label for="cover">Book Cover:</label>
    <input type="file" name="cover" id="cover" accept="image/*">
    <small>Current cover: <img src="{{ $product->cover }}" alt="Cover" style="max-width: 100px;"></small>

    <label for="description">Book Description:</label>
    <textarea name="description" id="description">{{ old('description', $product->description) }}</textarea>

    <button type="submit">Edit</button>
    <button type="button" onclick="window.location='{{ url('/product-management') }}'">Back</button>
</form>
@endsection
