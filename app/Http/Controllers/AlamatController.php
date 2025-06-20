<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Alamat;

class AlamatController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|max:25',
            'address' => 'required|string',
        ]);

        $user = Auth::user();
        $validated['user_id'] = $user->id;

        if ($user->alamats()->count() === 0) {
            $validated['is_primary'] = true;
        } else {
            $validated['is_primary'] = false;
        }

        // Data berhasil dibuat
        $alamat = Alamat::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Alamat baru berhasil disimpan!',
            'alamat' => $alamat
        ]);
    }
    public function destroy(Alamat $alamat)
    {
        // Pastikan user hanya bisa menghapus alamatnya sendiri
        if ($alamat->user_id !== Auth::id()) {
            abort(403, 'UNAUTHORIZED ACTION');
        }

        $alamat->delete();
        return back()->with('success', 'Alamat berhasil dihapus.');
    }

    public function setDefault(Alamat $alamat)
    {
        // Pastikan user hanya bisa mengatur alamatnya sendiri
        if ($alamat->user_id !== Auth::id()) {
            abort(403, 'UNAUTHORIZED ACTION');
        }

        // Gunakan transaksi database untuk memastikan proses aman
        DB::transaction(function () use ($alamat) {
            // 1. Set semua alamat milik user ini menjadi tidak utama
            Auth::user()->alamats()->update(['is_primary' => false]);
            // 2. Set alamat yang dipilih menjadi utama
            $alamat->update(['is_primary' => true]);
        });

        return back()->with('success', 'Alamat utama berhasil diubah.');
    }
}
