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
        return view('user.home');
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
        $products = Buku::with('genres');

        $genreFilter = $request->query('genre');
        if ($genreFilter) {
            $products = $products->whereHas('genres', function ($query) use ($genreFilter) {
                $query->where('genre', $genreFilter);
            });
        }

        $products = $products->get();
        $genres = Genre::orderBy('genre')->get();

        return view('produk.new', compact('products', 'genres', 'genreFilter'));
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
