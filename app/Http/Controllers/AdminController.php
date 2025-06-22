<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Rating;
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
        $query = Order::with(['user', 'items.buku', 'alamat'])
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
        $query = Order::with(['user', 'items.buku', 'alamat'])
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

        // --- ATURAN 1: TIDAK BISA MENGUBAH DARI 'canceled', 'completed' ---
        // (sudah ditangani di awal fungsi)
        if ($currentStatus === 'canceled') {
            return redirect()->back()->with('error', 'Order sudah dibatalkan dan tidak bisa diubah statusnya lagi.');
        }
        if ($currentStatus === 'completed') {
            return redirect()->back()->with('error', 'Order sudah selesai dan tidak bisa diubah statusnya lagi.');
        }
        if ($currentStatus === 'arrived') {
            return redirect()->back()->with('error', 'Order sudah sampai dan tidak bisa diubah statusnya lagi.');
        }
        // Admin tidak bisa mengubah status menjadi 'completed' secara langsung
        if ($newStatus === 'completed') {
            return redirect()->back()->with('error', 'Admin tidak dapat langsung mengubah status menjadi "Completed". Status ini diset oleh pengguna atau sistem.');
        }
        // Aturan tambahan: Admin tidak bisa mengubah dari 'arrived' ke status lain selain 'canceled' (jika masih diizinkan)
        // Berdasarkan aturan baru, admin tidak bisa mengubah dari 'arrived' sama sekali kecuali pembatalan dari pending.
        // Jadi, kalau sudah 'arrived', tidak bisa diubah lagi oleh admin ke 'process' atau 'pending'.


        // --- ATURAN 2: ADMIN HANYA BISA MEMBATALKAN ('canceled') DARI 'pending' ---
        if ($newStatus === 'canceled') {
            if ($currentStatus === 'pending') { // Hanya izinkan pembatalan jika status saat ini 'pending'
                if ($order->cancelOrder()) {
                    return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan dan stok dikembalikan.');
                } else {
                    return redirect()->back()->with('error', 'Gagal membatalkan pesanan. Status order tidak valid untuk pembatalan atau ada masalah teknis.');
                }
            } else {
                // Pesan error jika mencoba batalkan dari status selain 'pending'
                return redirect()->back()->with('error', 'Admin hanya dapat membatalkan order jika statusnya "Pending".');
            }
        }


        // --- ATURAN 3: JIKA STATUS 'process', HANYA BISA UBAH MENJADI 'arrived' ---
        // Dan tidak ada transisi lain dari 'pending' selain ke 'process' (atau 'canceled' yang sudah di atas)
        $allowedTransitions = [
            'pending' => ['process'], // Dari pending, admin hanya bisa mengubah ke process
            'process' => ['arrived'], // Dari process, admin hanya bisa mengubah ke arrived
     // Dari arrived, admin tidak bisa mengubah ke status lain (kecuali cancel dari pending, yang sudah dicek)
        ];

        // Periksa apakah transisi yang diminta valid berdasarkan aturan yang ditetapkan
        // Ini mencegah transisi mundur dan transisi yang tidak diizinkan.
        if (isset($allowedTransitions[$currentStatus]) && !in_array($newStatus, $allowedTransitions[$currentStatus])) {
            return redirect()->back()->with('error', "Transisi status dari '{$currentStatus}' ke '{$newStatus}' tidak diizinkan oleh admin.");
        }

        // Jika semua validasi lolos dan status bukan 'canceled' (sudah ditangani di atas)
        $order->status = $newStatus;
        $order->save();

        return redirect()->back()->with('success', 'Status order berhasil diperbarui.');
    }

    public function listProduct() {
        $query = Buku::query();
        $products = $query->paginate(8);
        return view('admin.product-management', [
            'products' => $products
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
        $buku = Buku::findOrFail($id);

        // --- LOGIKA VALIDASI SEBELUM PENGHAPUSAN ---
        // 1. Cek apakah ada order_items yang terkait dengan buku ini.
        // 2. Jika ada, periksa status order dari order_items tersebut.
        //    Asumsi: Relasi dari Buku ke OrderItem adalah 'items' (sesuai diskusi terakhir).
        //    Asumsi: OrderItem memiliki relasi 'order' ke model Order.
        $hasPendingOrders = OrderItem::where('book_id', $buku->id) // Cari order item untuk buku ini
            ->whereHas('order', function ($query) { // Periksa status order terkait
                $query->whereNotIn('status', ['completed', 'canceled']); // Status yang TIDAK boleh dihapus produknya
            })
            ->exists(); // Cek apakah ada record yang cocok

        if ($hasPendingOrders) {
            return redirect()->route('product.management')->with('error', 'Produk tidak dapat dihapus karena masih ada order yang belum selesai atau dibatalkan.');
        }

        // --- Lanjutkan dengan penghapusan jika tidak ada order yang belum selesai ---
        try {
            // Hapus semua record terkait di tabel lain SECARA MANUAL jika onDelete('cascade') tidak digunakan
            // atau jika Anda ingin kontrol lebih lanjut.
            // Pastikan relasi ini sudah didefinisikan di model Buku.php
            // Contoh (sesuaikan dengan relasi yang benar di Buku.php Anda):
            if ($buku->carts()->exists()) { // Check if there are carts related
                $buku->carts()->delete();
            }
            if ($buku->ratings()->exists()) { // Check if there are ratings related
                $buku->ratings()->delete();
            }
            if ($buku->genres()->exists()) { // Detach many-to-many relationships
                $buku->genres()->detach();
            }
            // Catatan: Anda tidak perlu menghapus order_items secara langsung di sini
            // jika Anda sudah menambahkan onDelete('cascade') di migrasi foreign key dari order_items ke buku.
            // Namun, jika tidak ada cascade, baris $hasPendingOrders di atas sudah mencegah penghapusan jika ada order item aktif.

            $buku->delete(); // Hapus buku itu sendiri

            return redirect()->route('product.management')->with('success', 'Produk berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Error deleting product ' . $id . ': ' . $e->getMessage());
            return redirect()->route('product.management')->with('error', 'Gagal menghapus produk karena kesalahan database. Silakan periksa log.');
        }
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

        $ratings = Rating::with('user', 'buku')->latest()->get();

        return view('admin.ratings', compact('ratings'));
    }

    public function destroyRating(Rating $rating)
    {
        $rating->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
