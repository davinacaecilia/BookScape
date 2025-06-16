<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function listUsers()
    {
        $users = User::all();
        return view('admin.user-management', compact('users'));
    }

    public function showRatingsAndReviews()
{
    return view('admin.ratings');
}
}
