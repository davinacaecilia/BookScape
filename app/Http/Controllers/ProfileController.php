<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil user beserta form editnya.
     * Kita gunakan nama 'edit' sesuai konvensi Laravel.
     */
    public function edit(): View
    {
        // Mengambil user yang sedang login dan mengirimkannya ke view.
        // Pastikan view Anda berada di 'resources/views/user/profile.blade.php'
        return view('user.profile', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Memproses dan menyimpan perubahan data profil.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Validasi data yang masuk.
        // Aturan 'unique' untuk email akan mengabaikan email user saat ini.
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Mengisi data user dengan data yang sudah divalidasi
        $user->fill([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);
        
        // Jika ada perubahan email, reset status verifikasi (praktik baik dari Breeze)
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Hanya update password jika field password diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        // Simpan perubahan pada data user
        $user->save();

        // Simpan atau update data alamat di tabel terpisah
        $user->alamat()->updateOrCreate(
            ['user_id' => $user->id], // Kunci untuk mencari
            [
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address']
            ] // Data alamat untuk disimpan
        );

        // Arahkan kembali ke halaman profil dengan pesan sukses.
        // Kita beri nama rute 'profile.edit' nanti di web.php
        return Redirect::route('profile.edit')->with('status', 'Profile berhasil diperbarui!');
    }
}