<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // Method untuk nampilin halaman product management
public function index()
{
    $products = [
        [
            'title' => 'Sample Book 1',
            'author' => 'Author 1',
            'genre' => 'Romance',
            'stock' => 10,
            'price' => 50000,
            'cover' => asset('img/Screenshot 2025-05-19 110152.png'),
        ],
        [
            'title' => 'Sample Book 2',
            'author' => 'Author 2',
            'genre' => 'Fantasy',
            'stock' => 25,
            'price' => 75000,
            'cover' => asset('img/Screenshot 2025-05-15 132219.png'),
        ],
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
            'stock' => 10,
            'cover' => 'public/Screenshot 2025-05-19 110152.png',
            'description' => 'Deskripsi 1',
        ],
        2 => [
            'title' => 'Sample Book 2',
            'author' => 'Author 2',
            'genre' => 'Fantacy',
            'price' => 75000,
            'stock' => 25,
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
    return redirect()->route('product.management')->with('success', 'Product updated (dummy).');

}

}
