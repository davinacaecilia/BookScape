<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function showCart()
    {
        return view('user.home');
    }

    public function addToCart(Request $request, $bookId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = auth()->id();

        // Jika sudah ada, update quantity
        $cartItem = Cart::where('user_id', $userId)->where('book_id', $bookId)->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'book_id' => $bookId,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke keranjang');
    }

    public function checkout()
    {
        $userId = auth()->id();
        $cartItems = Cart::with('book')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        // Hitung total
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->book->harga * $item->quantity;
        }

        // Buat order
        $order = Order::create([
            'user_id' => $userId,
            'total_price' => $total,
        ]);

        // Isi order_items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $item->book_id,
                'quantity' => $item->quantity,
                'price' => $item->book->harga,
            ]);
        }

        // Kosongkan cart
        Cart::where('user_id', $userId)->delete();

        return redirect()->route('orders.show', $order->id)->with('success', 'Checkout berhasil!');
    }

    public function uploadPayment(Request $request, Order $order)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($order->user_id != auth()->id()) {
            abort(403);
        }

        // Simpan gambar
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        // Update order
        $order->payment_proof = $path;
        $order->status = 'paid';
        $order->save();

        return back()->with('success', 'Bukti pembayaran berhasil diunggah!');
    }


}
