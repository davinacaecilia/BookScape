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

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="judul_buku">Book Title:</label>
        <input type="text" name="judul_buku" id="judul_buku" placeholder="Enter book title" required>

        <label for="penulis_buku">Author:</label>
        <input type="text" name="penulis_buku" id="penulis_buku" placeholder="Enter author name" required>

        <label for="genre">Genre:</label>
            @foreach ($genres as $genre)
                <div class="form-check form-check-inline">
                    <label>
                        <input type="checkbox" name="genres[]" value="{{ $genre->id }}">
                        {{ $genre->genre }}
                    </label>
                </div>
            @endforeach

        <label for="harga">Price (Rp):</label>
        <input type="number" name="harga" id="harga" placeholder="example: 50000" required>

        <label for="stock">Stock:</label>
        <input type="number" name="stock" id="stock" placeholder="example: 20" min="0" required>

        <label for="gambar_sampul">Book Cover:</label>
        <input type="file" name="gambar_sampul" id="gambar_sampul">

        <label for="sinposis">Book Description:</label>
        <textarea name="sinopsis" id="sinopsis" placeholder="Write a short description about the book..."></textarea>

        <button type="submit">Publish</button>
    </form>
</form>

@endsection