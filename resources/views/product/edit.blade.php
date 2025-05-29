@extends('product.AddProduct-Layout')

@section('title', 'Edit Product')

@section('content')
<h1>Edit Product</h1>

<form action="{{ route('product.update', $products->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="judul_buku">Book Title:</label>
    <input type="text" name="judul_buku" id="title" value="{{ $products->judul_buku }}" required>

    <label for="penulis_buku">Author:</label>
    <input type="text" name="penulis_buku" id="author" value="{{ $products->penulis_buku }}" required>

   <label for="genre">Genre:</label>
        @foreach ($genres as $genre)
            <div class="form-check form-check-inline">
                <label>
                    <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                        {{ $products->genres->contains($genre->id) ? 'checked' : '' }}>
                    {{ $genre->genre }}
                </label>
            </div>
        @endforeach


    <label for="harga">Price (Rp):</label>
    <input type="number" name="harga" id="price" value="{{ $products->harga }}" required>

    <label for="stock">Stock:</label>
    <input type="number" name="stock" id="stock" value="{{ $products->stock }}" min="0" required>

    <label for="gambar_sampul">Book Cover:</label>
    <input type="file" name="gambar_sampul" id="cover" accept="image/*">
    <small>Current cover: <img src="{{ asset('storage/sampul/' . $products->gambar_sampul) }}" alt="Cover" style="max-width: 100px;"></small>

    <label for="sinopsis">Book Description:</label>
    <textarea name="sinopsis" id="description">{{ $products->sinopsis }}</textarea>

    <button type="submit">Edit</button>
</form>
@endsection
