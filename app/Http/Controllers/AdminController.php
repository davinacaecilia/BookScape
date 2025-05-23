<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('product.product-create'); 
    }

     public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'judul_buku' => 'required',
            'penulis_buku' => 'required',
            'harga' => 'required|numeric',
            'gambar_sampul' => 'image|max:2048',
            'sinopsis' => 'string'
        ]);

        if ($request->hasFile('gambar_sampul')) {
            $validated['gambar_sampul'] = $request->file('gambar_sampul')->store('gambar_sampul', 'public');
        }

        DB::table('buku')->insert($validated);

        return redirect('product-management')->with('success', 'Product added!');
    }

    public function editProduct(Request $request) {
        $products = Buku::find($request->id);
        return view('product.edit', [
            'products' => $products
        ]);
    }

    public function updateProduct(Request $request) {
        $validated = $request->validate([
            'judul_buku' => 'required',
            'penulis_buku' => 'required',
            'harga' => 'required|numeric',
            'gambar_sampul' => 'image|max:2048',
            'sinopsis' => 'string'
        ]);

        if ($request->hasFile('gambar_sampul')) {
            $validated['gambar_sampul'] = $request->file('gambar_sampul')->store('gambar_sampul', 'public');
        }

        DB::table('buku')->where('id', $request->id)->update($validated);

        return redirect('product-management')->with('success', 'Product updated!');
    }
    public function deleteProduct($id) {
        $products = Buku::findOrFail($id);
        $products->delete();

        return redirect()->route('product-management')->with('success', 'Product deleted');
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
