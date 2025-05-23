<?php

namespace App\Http\Controllers;

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
}
