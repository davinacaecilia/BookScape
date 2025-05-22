<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // pastikan file resources/views/login.blade.php ada
    }

    // LoginController.php

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            // Ambil user yang sedang login
            $user = auth()->user();

            // Cek level user
            if ($user->user_level == 0) {
                // Admin
                return redirect()->route('admin.dashboard');
            } else {
                // User biasa
                return redirect()->route('dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

}
