<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // Method untuk nampilin halaman product management
    public function index()
{
    // Data dummy
    $products = [
        [
            'title' => 'Sample Book 1',
            'author' => 'Author 1',
            'price' => 50000,
            'cover' => 'https://via.placeholder.com/150',
        ],
        [
            'title' => 'Sample Book 2',
            'author' => 'Author 2',
            'price' => 75000,
            'cover' => 'https://via.placeholder.com/150',
        ],
        // Tambah data dummy lain kalau mau
    ];

    return view('product.product-management', compact('products'));
}


    public function create()
    {
        return view('product.product-create'); 
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'author' => 'required',
            'genre' => 'required',  // jangan lupa validasi genre juga
            'price' => 'required|numeric',
            'cover' => 'nullable|image|max:2048',
            'description' => 'nullable|string'
        ]);

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        DB::table('products')->insert($validated);

        return redirect('/product-management')->with('success', 'Product added!');
    }

    public function edit($id)
{
    // Data dummy sama kayak di index()
    $products = [
        1 => [
            'title' => 'Sample Book 1',
            'author' => 'Author 1',
            'genre' => 'Romance',
            'price' => 50000,
            'cover' => 'https://via.placeholder.com/150',
            'description' => 'Deskripsi 1',
        ],
        2 => [
            'title' => 'Sample Book 2',
            'author' => 'Author 2',
            'genre' => 'Fantacy',
            'price' => 75000,
            'cover' => 'https://via.placeholder.com/150',
            'description' => 'Deskripsi 2',
        ],
    ];

    if (!isset($products[$id])) {
        abort(404);
    }

    $product = (object) $products[$id]; // biar bisa akses pakai -> di blade
    $product->id = $id;

    return view('product.edit', compact('product'));
}

    public function update(Request $request, $id)
{
    // Sementara cuma untuk testing, karena data masih dummy
    return redirect()->route('product.index')->with('success', 'Product updated (dummy).');
}

}
