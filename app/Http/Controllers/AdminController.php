<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
        $bukuCount = Buku::count();
        $orderCount = Order::count();
        $query = Order::with(['user', 'items.buku'])
                        ->orderBy('created_at', 'desc');
        $orders = $query->paginate(5);
        return view('admin.dashboard', compact('userCount', 'bukuCount', 'orders', 'orderCount'));
    }
    public function listMessage()
    {
        return view('admin.message');
    }
    
    public function listOrders()
    {
        $query = Order::with(['user', 'items.buku'])
                        ->orderBy('created_at', 'desc');
        $orders = $query->paginate(10);
        return view('admin.orders', compact('orders'));
    }
    
    public function orderDetail(Request $request)
    {
        $order = Order::findOrFail($request->id);
        return view('admin.detail-order', compact('order'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        // Validasi input dasar
        $request->validate([
            'status' => 'required|string|in:pending,process,arrived,completed,canceled',
        ]);

        $newStatus = $request->status;
        $currentStatus = $order->status;

        if ($currentStatus === 'canceled') {
            return redirect()->back()->with('error', 'Order sudah dibatalkan dan tidak bisa diubah statusnya lagi.');
        }

        if ($currentStatus === 'completed') {
            return redirect()->back()->with('error', 'Order sudah selesai dan tidak bisa diubah statusnya lagi.');
        }

        if ($newStatus === 'completed') {
            return redirect()->back()->with('error', 'Admin tidak dapat langsung mengubah status menjadi "Completed". Status ini diset oleh pengguna atau sistem.');
        }

        $allowedTransitions = [
            'pending'                      => ['process', 'canceled'],
            'process'                      => ['arrived'],
            'arrived'                      => ['canceled'],
        ];

        if (isset($allowedTransitions[$currentStatus]) && !in_array($newStatus, $allowedTransitions[$currentStatus])) {
            return redirect()->back()->with('error', "Perubahan status dari '{$currentStatus}' ke '{$newStatus}' tidak diizinkan.");
        }

        if ($newStatus === 'canceled') {
            if ($order->cancelOrder()) { // Panggilan ke metode di model Order
                return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan dan stok dikembalikan.');
            } else {
                return redirect()->back()->with('error', 'Gagal membatalkan pesanan. Status order tidak valid untuk pembatalan.');
            }
        }

        $order->status = $newStatus;
        $order->save();

        return redirect()->back()->with('success', 'Status order berhasil diperbarui.');
    }

    public function listProduct() {
        $query = Buku::query();
        $products = $query->paginate(10);
        return view('admin.product-management', [
            'products' => $products
        ]);
    }

    public function addProduct() {
        $genres = Genre::all();
        return view('admin.product-create', [
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

        if ($request->hasFile('gambar_sampul')) {
            $file = $request->file('gambar_sampul');
            $filename = $file->hashName();
            $file->storeAs('sampul', $filename, 'public');
        } else {
            $filename = null;
        }

        $buku = Buku::create([
            'judul_buku' => $validated['judul_buku'],
            'penulis_buku' => $validated['penulis_buku'],
            'harga' => $validated['harga'],
            'gambar_sampul' => $filename,
            'sinopsis' => $validated['sinopsis'],
            'stock' => $validated['stock'],
        ]);

        $genreIds = $validated['genres'] ?? []; 
        $buku->genres()->sync($genreIds);  

        return redirect()->route('product.management')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function editProduct(Request $request) {
        $products = Buku::find($request->id);
        $genres = Genre::all();
        return view('admin.product-edit', [
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

        if ($request->hasFile('gambar_sampul')) {
            if ($buku->gambar_sampul && Storage::disk('public')->exists('sampul/' . $buku->gambar_sampul)) {
                Storage::disk('public')->delete('sampul/' . $buku->gambar_sampul);
            }

            $file = $request->file('gambar_sampul');
            $filename = $file->hashName();
            $file->storeAs('sampul', $filename, 'public');

            $buku->gambar_sampul = $filename;
        }

        $buku->update([
            'judul_buku' => $validated['judul_buku'],
            'penulis_buku' => $validated['penulis_buku'],
            'harga' => $validated['harga'],
            'sinopsis' => $validated['sinopsis'],
            'stock' => $validated['stock'],
        ]);

        $genreIds = $validated['genres'] ?? []; 
        $buku->genres()->sync($genreIds);  

        return redirect()->route('product.management')->with('success', 'Produk berhasil diperbarui');
    }


    public function deleteProduct($id) {
        $products = Buku::findOrFail($id);
        $products->delete();

        return redirect('/product-management')->with('success', 'Product deleted');
    }

    public function listUsers()
    {
        $query = User::query();
        $users = $query->paginate(10);
        return view('admin.user-management', compact('users'));
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

    public function showRatingsAndReviews()
{
    return view('admin.ratings');
}
}
