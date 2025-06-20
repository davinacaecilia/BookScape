<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{

    public function store(Request $request, Buku $buku)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        // updateOrCreate akan membuat rating baru, 
        // atau mengupdate rating lama jika user ini sudah pernah memberi rating untuk buku ini.
        $buku->ratings()->updateOrCreate(
            ['user_id' => Auth::id()], // Kunci untuk mencari
            [
                'rating' => $request->rating,
                'review' => $request->review,
            ] // Data untuk diupdate atau dibuat
        );

        // Arahkan kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }

    public function create(Buku $buku)
    {
        // Cukup tampilkan view dan kirim data buku yang sesuai dari URL
        return view('produk.rating', ['buku' => $buku]);
    }
}