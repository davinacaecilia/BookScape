<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class DashboardController extends Controller
{
    // DashboardController.php

public function index()
{
    // Ambil 5 order terbaru, bisa pakai with() buat eager loading user
    $recentOrders = Order::with('user')->orderBy('created_at', 'desc')->take(5)->get();

    return view('dashboard', compact('recentOrders'));
}

}
