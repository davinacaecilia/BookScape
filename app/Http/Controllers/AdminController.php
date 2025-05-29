<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Buku;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function showDashboard()
    {
        $userCount = User::count();
        return view('admin.dashboard', compact('userCount'));
    }
    public function listMessage()
    {
        return view('admin.message');
    }
    public function listOrders()
    {
        return view('admin.orders');
    }

    public function listProduct() {
        $products = Buku::all();
        return view('product.product-management', [
            'products' => $products
        ]);
    }

    public function addProduct() {
        $genres = Genre::all();
        return view('product.product-create', [
            'genres' => $genres
        ]); 
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'judul_buku' => 'required|string|max:255',
            'penulis_buku' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'gambar_sampul' => 'nullable|image|mimes:jpg,jpeg,png|max:6048',
            'genres' => 'array',
            'sinopsis' => 'nullable|string',
            'stock' => 'required|integer'
        ]);

        // Simpan gambar
         if ($request->hasFile('gambar_sampul')) {
            $file = $request->file('gambar_sampul');
            $filename = $file->hashName();
            $file->storeAs('sampul', $filename, 'public');
        } else {
            $filename = null;
        }

        // Simpan buku
        $buku = Buku::create([
            'judul_buku' => $validated['judul_buku'],
            'penulis_buku' => $validated['penulis_buku'],
            'harga' => $validated['harga'],
            'gambar_sampul' => $filename,
            'sinopsis' => $validated['sinopsis'],
            'stock' => $validated['stock'],
        ]);

        $buku->genres()->sync($validated['genres']);

        return redirect()->route('product.management')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function editProduct(Request $request) {
        $products = Buku::find($request->id);
        $genres = Genre::all();
        return view('product.edit', [
            'products' => $products,
            'genres' => $genres
        ]);
    }

    public function updateProduct(Request $request, $id)
    {
        $validated = $request->validate([
            'judul_buku' => 'required|string|max:255',
            'penulis_buku' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'gambar_sampul' => 'nullable|image|mimes:jpg,jpeg,png|max:6048',
            'genres' => 'array',
            'sinopsis' => 'nullable|string',
            'stock' => 'required|integer'
        ]);

        $buku = Buku::findOrFail($id);

        // Jika ada gambar baru diupload
        if ($request->hasFile('gambar_sampul')) {
            // Hapus gambar lama dari storage
            if ($buku->gambar_sampul && Storage::disk('public')->exists('sampul/' . $buku->gambar_sampul)) {
                Storage::disk('public')->delete('sampul/' . $buku->gambar_sampul);
            }

            // Simpan gambar baru
            $file = $request->file('gambar_sampul');
            $filename = $file->hashName();
            $file->storeAs('sampul', $filename, 'public');

            $buku->gambar_sampul = $filename;
        }

        // Update data buku
        $buku->update([
            'judul_buku' => $validated['judul_buku'],
            'penulis_buku' => $validated['penulis_buku'],
            'harga' => $validated['harga'],
            'sinopsis' => $validated['sinopsis'],
            'stock' => $validated['stock'],
        ]);

        $buku->genres()->sync($validated['genres']);

        return redirect()->route('product.management')->with('success', 'Produk berhasil diperbarui');
    }


    public function deleteProduct($id) {
        $products = Buku::findOrFail($id);
        $products->delete();

        return redirect('/product-management')->with('success', 'Product deleted');
    }

    public function listUsers()
    {
        $users = User::all();
        return view('user-management', [
            'users' => $users
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('user-management')->with('success', 'User updated successfully');
    }
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user-management')->with('success', 'User deleted successfully');
    }
}
