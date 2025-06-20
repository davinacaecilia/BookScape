<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Cart;
use App\Models\Genre;
use DB;
use Illuminate\Http\Request;

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

    public function showProfile()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
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
        
        $previousBuku = Buku::where('id', '<', $request->id)->orderBy('id', 'desc')->first();
        $nextBuku = Buku::where('id', '>', $request->id)->orderBy('id', 'asc')->first();
        
        return view('produk.preview', compact('products', 'previousBuku', 'nextBuku'));
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
            'cart_id' => 'required|exists:cart,id',
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




    public function showHistory() {
        return view('produk.history');
    }
    
}
