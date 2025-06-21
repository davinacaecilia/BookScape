<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Buku;
use App\Models\Cart;
use App\Models\Genre;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\Rating;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showHome()
    {
        $myCarts = Cart::with('buku')
            ->where('user_id', auth()->user()->id)
            ->paginate(6);
        $newArrivals = Buku::orderBy('updated_at', 'desc')->paginate(6);
        $bestSellers = Buku::with('genres')
            ->select(
                'buku.id', // Harus disertakan di GROUP BY
                'buku.judul_buku', // Harus disertakan di GROUP BY
                'buku.penulis_buku', // Harus disertakan di GROUP BY
                'buku.gambar_sampul', // Harus disertakan di GROUP BY
                'buku.harga', // Harus disertakan di GROUP BY
                'buku.sinopsis', // Harus disertakan di GROUP BY
                'buku.stock', // Harus disertakan di GROUP BY
                'buku.created_at', // Harus disertakan di GROUP BY
                'buku.updated_at', // Harus disertakan di GROUP BY
                // Tambahkan semua kolom lain dari tabel 'buku' yang Anda pilih dengan 'buku.*'
                DB::raw('AVG(ratings.rating) as average_rating') // Ini adalah fungsi agregasi, tidak perlu di GROUP BY
            )
            ->join('ratings', 'buku.id', '=', 'ratings.buku_id')
            ->groupBy(
                'buku.id', // Wajib
                'buku.judul_buku', // Wajib
                'buku.penulis_buku', // Wajib
                'buku.gambar_sampul', // Wajib
                'buku.harga', // Wajib
                'buku.sinopsis', // Wajib
                'buku.stock', // Wajib
                'buku.created_at', // Wajib
                'buku.updated_at' // Wajib
                // Tambahkan semua kolom lain dari tabel 'buku' yang Anda pilih di SELECT ke sini
            )
            ->havingRaw('COUNT(ratings.rating) >= ?', [1]) // Contoh: minimal 1 ulasan
            ->orderByDesc('average_rating')
            ->limit(6)
            ->get();
        $libraries = Buku::query()->paginate(6);
        return view('user.home', compact('newArrivals', 'bestSellers', 'libraries', 'myCarts'));
    }

    public function showSettings()
    {
        return view('user.settings');
    }

    public function showLibrary(Request $request)
    {
        $genreFilter = $request->query('genre');
        $searchQuery = $request->query('search');

        $query = Buku::with('genres');

        if ($genreFilter) {
            $query->whereHas('genres', function ($q) use ($genreFilter) {
                $q->where('genre', $genreFilter);
            });
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('judul_buku', 'like', '%' . $searchQuery . '%')
                    ->orWhere('penulis_buku', 'like', '%' . $searchQuery . '%');
            });
        }

        $products = $query->get();
        $genres = Genre::orderBy('genre')->get();

        return view('produk.new', compact('products', 'genres', 'genreFilter', 'searchQuery'));
    }


    public function showDetail(Request $request)
    {
        $searchQuery = $request->query('search');
        $query = Buku::with('genres');
        if ($request->filled('search')) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('judul_buku', 'like', '%' . $searchQuery . '%')
                ->orWhere('penulis_buku', 'like', '%' . $searchQuery . '%');
            });
        }

        $buku = Buku::with('genres', 'ratings.user')->findOrFail($request->id); // Tambahkan eager loading untuk relasi yang dibutuhkan di Blade
        $previousBuku = Buku::where('id', '<', $request->id)->orderBy('id', 'desc')->first();
        $nextBuku = Buku::where('id', '>', $request->id)->orderBy('id', 'asc')->first();

        return view('produk.preview', compact('buku', 'previousBuku', 'nextBuku', 'searchQuery'));
    }

    public function addToCart($id)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $buku = Buku::findOrFail($id);

        if ($buku->stock < 1) {
            return response()->json(['message' => 'Stok habis'], 400);
        }

        Cart::updateOrCreate(
            ['user_id' => $user->id, 'buku_id' => $buku->id],
            ['quantity' => 1]
        );

        // Kirim balik JavaScript (untuk SweetAlert popup)
        return response()->json(['message' => 'Berhasil ditambahkan ke keranjang']);
    }

    public function showCart()
    {
        $user = auth()->user();

        $items = Cart::with('buku')
            ->where('user_id', $user->id)
            ->get();

        return view('produk.cart', compact('items'));
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id', // Ubah 'cart' menjadi 'carts'
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::where('id', $request->cart_id)
            ->where('user_id', auth()->user()->id)
            ->firstOrFail();

        $cart->quantity = $request->quantity;
        $cart->save();

        return response()->json(['success' => true]);
    }

    public function deleteCart(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
        ]);

        $cart = Cart::where('id', $request->cart_id)
            ->where('user_id', auth()->id())
            ->first();

        if ($cart) {
            $cart->delete();
            return redirect()->back()->with('success', 'Item berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Gagal menghapus item');
    }

    public function deleteSelectedCart(Request $request)
    {
        $request->validate([
            'cart_ids' => 'required|array', // Pastikan 'cart_ids' adalah array yang diperlukan
            'cart_ids.*' => 'required|exists:carts,id', // Validasi setiap ID dalam array, memastikan itu ada di tabel 'carts'
        ]);

        // Menghapus semua item keranjang dengan ID yang ada di array dan milik pengguna saat ini
        $deletedCount = Cart::whereIn('id', $request->cart_ids) // Menggunakan whereIn untuk menghapus banyak ID sekaligus
            ->where('user_id', auth()->id())
            ->delete();

        if ($deletedCount > 0) {
            return response()->json(['success' => true, 'message' => "$deletedCount item berhasil dihapus."]);
        }

        return response()->json(['success' => false, 'message' => 'Gagal menghapus item atau tidak ada item yang ditemukan.'], 400);
    }

    public function checkout(Request $request)
    {
        $ids = explode(',', $request->selected_cart_ids);

        $orderItems = Cart::with('buku')->whereIn('id', $ids)->get();
        $user = Auth::user();
        $alamatUser = $user->alamats()->where('is_primary', 1)->get();

        $subtotal = $orderItems->sum(fn($i) => $i->quantity * $i->buku->harga);
        $shippingCost = 0.05 * $subtotal;
        $total = $subtotal + $shippingCost;

        return view('produk.order-cart', compact('orderItems', 'subtotal', 'shippingCost', 'total', 'alamatUser'));
    }

    public function checkoutNow(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        $quantity = $request->quantity;
        $subtotal = $buku->harga * $quantity;
        $shippingCost = round($subtotal * 0.10); // Biaya pengiriman 10%
        $total = $subtotal + $shippingCost;

        // Ambil alamat user yang terdaftar
        $alamatUser = Alamat::where('user_id', Auth::id())->get(); //

        return view('produk.order-now', [
            'orderItems' => collect([ (object)[
                'id' => null, // Ini adalah flag untuk "Buy Now"
                'buku' => $buku,
                'quantity' => $quantity
            ]]),
            'subtotal' => $subtotal,
            'shippingCost' => $shippingCost,
            'total' => $total,
            'alamatUser' => $alamatUser, // <<< Kirimkan alamat ke view
        ]);
    }

    public function placeOrder(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'selected_address_id' => 'required|exists:alamats,id', // Validasi alamat yang dipilih
        ]);

        // Cek apakah ini mode "Buy Now"
        if ($request->has('is_buy_now') && $request->input('is_buy_now') == '1') {
            $request->validate([
                'buku_id' => 'required|exists:buku,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $buku = Buku::findOrFail($request->buku_id);
            $quantity = $request->quantity;

            if ($buku->stock < $quantity) {
                return redirect()->back()->with('error', 'Stok buku ' . $buku->judul_buku . ' tidak mencukupi.');
            }

            $subtotal = $buku->harga * $quantity;
            $shipping = round($subtotal * 0.10);
            $total = $subtotal + $shipping;

            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $total,
                'status' => 'pending',
                'payment_proof' => null,
                'pending_at' => Carbon::now(),
                'alamat_id' => $request->selected_address_id, // <<< SIMPAN ALAMAT ID UNTUK BUY NOW
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $buku->id,
                'quantity' => $quantity,
                'price' => $buku->harga
            ]);

            $buku->stock -= $quantity;
            $buku->save();

        } else {
            $request->validate([
                'selected_cart_ids' => 'required|string',
            ]);

            $cartIds = explode(',', $request->selected_cart_ids);
            $cartItems = Cart::with('buku')->whereIn('id', $cartIds)->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('product.cart')->with('error', 'Tidak ada item terpilih di keranjang.');
            }

            // Validasi stok untuk setiap item di keranjang SEBELUM MEMBUAT ORDER
            foreach ($cartItems as $cartItem) {
                if (!$cartItem->buku) { // Cek jika buku tidak ditemukan (misal: sudah dihapus)
                    return redirect()->back()->with('error', 'Beberapa item di keranjang tidak valid.');
                }
                if ($cartItem->buku->stock === 0) {
                    return redirect()->back()->with('error', 'Stok buku "' . $cartItem->buku->judul_buku . '" sudah habis. Mohon hapus dari keranjang atau kurangi jumlahnya.');
                }
                if ($cartItem->quantity > $cartItem->buku->stock) {
                    return redirect()->back()->with('error', 'Kuantitas buku "' . $cartItem->buku->judul_buku . '" melebihi stok yang tersedia. Stok: ' . $cartItem->buku->stock);
                }
            }

            $subtotal = $cartItems->sum(fn($item) => $item->buku->harga * $item->quantity);
            $shipping = $subtotal * 0.10;
            $total = $subtotal + $shipping;

            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $total,
                'status' => 'pending',
                'payment_proof' => null,
                'pending_at' => Carbon::now(),
                'alamat_id' => $request->selected_address_id,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $item->buku->id,
                    'quantity' => $item->quantity,
                    'price' => $item->buku->harga
                ]);

                // Kurangi stok setelah order item dibuat
                $buku = Buku::find($item->buku->id);
                if ($buku) {
                    $buku->stock -= $item->quantity;
                    $buku->save();
                }
            }

            // Hapus item dari keranjang setelah order dibuat
            Cart::whereIn('id', $cartIds)->delete();
        }

        return redirect()->route('order.payment', ['order' => $order->id]);
    }

    public function showPaymentPage(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Ambil semua metode pembayaran dari database
        $paymentMethods = PaymentMethod::all();

        return view('produk.payment', compact('order', 'paymentMethods')); // Kirimkan ke view
    }

    public function uploadPaymentProof(Request $request, Order $order)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'payment_method_id' => 'required|exists:payment_methods,id', // Validasi ID metode pembayaran
        ]);

        if ($order->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses ke order ini.'], 403);
        }

        try {
            if ($request->hasFile('payment_proof')) {
                $image = $request->file('payment_proof');
                $imageName = time() . '_' . $image->getClientOriginalName();

                $image->storeAs('bukti', $imageName, 'public');

                $order->payment_proof = $imageName;
                $order->payment_method_id = $request->payment_method_id; // Simpan ID metode pembayaran
                $order->status = 'pending';
                $order->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Bukti pembayaran berhasil diunggah. Pesanan Anda sedang diproses.',
                    'redirect_url' => route('order.history')
                ]);
            }

            return response()->json(['success' => false, 'message' => 'Gagal mengunggah bukti pembayaran.'], 400);

        } catch (\Exception $e) {
            \Log::error('Error uploading payment proof: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan server saat mengunggah bukti pembayaran.'], 500);
        }
    }


    public function showHistory() {
        // Ambil semua order untuk user yang sedang login
        // Eager load orderItems dan buku terkait untuk setiap order
        $userOrders = Order::with(['items.buku'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan tanggal terbaru
            ->get();

        // Filter pesanan yang tidak memiliki item
        $userOrders = $userOrders->filter(function ($order) {
            return $order->items->isNotEmpty(); // Hanya simpan order jika memiliki item
        });

        // Kirimkan langsung $userOrders ke view. Tidak perlu pengelompokan di sini lagi.
        return view('produk.history', compact('userOrders'));
    }

    // Fungsi untuk mengubah status pesanan (diperlukan oleh AJAX dari history.js)
    public function updateOrderStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'status' => 'required|string|in:completed,canceled' // Status yang diizinkan
        ]);

        $order = Order::where('id', $request->order_id)
                      ->where('user_id', auth()->id()) // Pastikan hanya owner yang bisa mengubah
                      ->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Pesanan tidak ditemukan atau Anda tidak memiliki akses.'], 404);
        }

        $order->status = $request->status;
        $order->save();

        return response()->json(['success' => true, 'new_status' => $order->status, 'message' => 'Status pesanan berhasil diperbarui.']);
    }
}
