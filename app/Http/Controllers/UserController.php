<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Cart;
use App\Models\Genre;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showHome()
    {
        $newArrivals = Buku::orderBy('updated_at', 'desc')->get();
        $libraries = Buku::all();
        return view('user.home', compact('newArrivals', 'libraries'));
    }

    public function showProfile()
    {
        return view('user.profile');
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
    public function addToCart(Request $request)
    {

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = auth()->id();

        // Jika sudah ada, update quantity
        $cartItem = Cart::where('user_id', $userId)->where('book_id')->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke keranjang');
    }

    public function showCart() {
        return view('produk.cart');
    }
    
}
