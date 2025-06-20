<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showHome()
    {
        return view('user.home');
    }

    public function showProfile()
    {
        $user = Auth::user(); 
        return view('user.profile', compact('user'));
    }

    public function showSettings()
    {
        return view('user.settings');
    }
}
