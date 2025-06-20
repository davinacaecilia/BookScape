<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Cart;
use App\Models\Genre;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showHome()
    {
        $myCarts = Cart::with('buku')
            ->where('user_id', auth()->user()->id)
            ->get();
        $newArrivals = Buku::orderBy('updated_at', 'desc')->get();
        $bestSellers = Buku::all();
        $libraries = Buku::all();
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

        $previousBuku = Buku::where('id', '<', $request->id)->orderBy('id', 'desc')->first();
        $nextBuku = Buku::where('id', '>', $request->id)->orderBy('id', 'asc')->first();

        return view('produk.preview', compact('products', 'previousBuku', 'nextBuku', 'searchQuery'));
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
        $alamatUser = $user->alamats;

        $subtotal = $orderItems->sum(fn($i) => $i->quantity * $i->buku->harga);
        $shippingCost = 0.05 * $subtotal;
        $total = $subtotal + $shippingCost;

        return view('produk.order-cart', compact(
            'orderItems',
            'subtotal',
            'shippingCost',
            'total',
            'alamatUser'
        ));
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
        $shippingCost = round($subtotal * 0.10);
        $total = $subtotal + $shippingCost;

        return view('produk.order-now', [
            'orderItems' => collect([ (object)[
                'id' => null,
                'buku' => $buku,
                'quantity' => $quantity
            ]]),
            'subtotal' => $subtotal,
            'shippingCost' => $shippingCost,
            'total' => $total
        ]);
    }

    public function placeOrder(Request $request)
        {
            $user = auth()->user();

            // Cek apakah ini mode "Buy Now"
            if ($request->has('is_buy_now') && $request->input('is_buy_now') == '1') {
                $request->validate([
                    'buku_id' => 'required|exists:buku,id',
                    'quantity' => 'required|integer|min:1'
                ]);

                $buku = Buku::findOrFail($request->buku_id);
                $quantity = $request->quantity;

                $subtotal = $buku->harga * $quantity;
                $shipping = round($subtotal * 0.10); // Gunakan konsisten dengan checkoutNow
                $total = $subtotal + $shipping;

                $order = Order::create([
                    'user_id' => $user->id,
                    'total_price' => $total, // Sesuaikan dengan nama kolom di Order.php
                    'status' => 'pending',
                    'payment_proof' => null, // Sesuaikan dengan nama kolom di Order.php
                ]);

                OrderItem::create([
                    'order_id' => $order->id,
                    'book_id' => $buku->id, // Sesuaikan dengan nama kolom di OrderItem.php
                    'quantity' => $quantity,
                    'price' => $buku->harga // Sesuaikan dengan nama kolom di OrderItem.php
                ]);

                // Tidak ada item keranjang untuk dihapus di mode Buy Now

            } else {
                // Ini adalah alur untuk Checkout dari Keranjang (Cart)
                $request->validate([
                    'selected_cart_ids' => 'required|string', // contoh: "3,5,6"
                ]);

                $cartIds = explode(',', $request->selected_cart_ids);
                $cartItems = Cart::with('buku')->whereIn('id', $cartIds)->get();

                if ($cartItems->isEmpty()) {
                    // Jangan pakai return back() jika ini yang memicu masalah GET.
                    // Lebih baik redirect ke halaman cart dengan pesan error.
                    return redirect()->route('product.cart')->with('error', 'Keranjang tidak valid atau item belum dipilih.');
                }

                $subtotal = $cartItems->sum(fn($item) => $item->buku->harga * $item->quantity);
                $shipping = $subtotal * 0.10;
                $total = $subtotal + $shipping;

                $order = Order::create([
                    'user_id' => $user->id,
                    'total_price' => $total, // Sesuaikan dengan nama kolom di Order.php
                    'status' => 'pending',
                    'payment_proof' => null, // Sesuaikan dengan nama kolom di Order.php
                ]);

                foreach ($cartItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'book_id' => $item->buku->id, // Sesuaikan dengan nama kolom di OrderItem.php
                        'quantity' => $item->quantity,
                        'price' => $item->buku->harga // Sesuaikan dengan nama kolom di OrderItem.php
                    ]);
                }

                Cart::whereIn('id', $cartIds)->delete();
            }

            // Redirect ke halaman pembayaran setelah Order berhasil dibuat (baik dari cart atau buy now)
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
                $path = 'public/bukti';

                $image->storeAs($path, $imageName);

                $order->payment_proof = $imageName;
                $order->payment_method_id = $request->payment_method_id; // Simpan ID metode pembayaran
                $order->status = 'process';
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
        $userOrders = Order::with(['items.buku'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        $groupedOrders = $userOrders->groupBy('status');

        $desiredOrder = ['Completed', 'Arrived', 'Process', 'Pending', 'Canceled'];
        $orderedGroupedOrders = collect($desiredOrder)->mapWithKeys(function ($status) use ($groupedOrders) {
            return [$status => $groupedOrders->get($status, collect())];
        });

        // PASTIKAN INI ADALAH BARIS YANG BENAR
        dd($orderedGroupedOrders);
        return view('produk.history', compact('orderedGroupedOrders'));
    }

}
