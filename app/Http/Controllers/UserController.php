<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Cart;
use App\Models\Genre;
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
        $products = Buku::find($request->id);

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

    public function showCart() {
        $user = auth()->user();

        $items = Cart::with('buku')  // relasi ke model Buku
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

        $subtotal = $orderItems->sum(fn($i) => $i->quantity * $i->buku->harga);
        $shippingCost = 0.05 * $subtotal;
        $total = $subtotal + $shippingCost;

        return view('produk.order-cart', compact('orderItems', 'subtotal', 'shippingCost', 'total'));
    }


    public function showHistory() {
        return view('produk.history');
    }
    
}
