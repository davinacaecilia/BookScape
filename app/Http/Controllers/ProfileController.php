<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{

    public function edit(): View
    {
        return view('user.profile', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:25'],
            'address' => ['nullable', 'string'],
        ]);

        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);

        // LOGIKA CERDAS UNTUK ALAMAT UTAMA
        $user->alamats()->updateOrCreate(
            ['is_primary' => true], // Cari alamat yang utama
            [
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'user_id' => $user->id,
            ]
        );

        return Redirect::route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}