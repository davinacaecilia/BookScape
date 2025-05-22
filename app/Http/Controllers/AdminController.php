<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Product;

class AdminController extends Controller
{
    public function listUsers()
    {
        $users = User::all();
        return view('user-management', compact('users'));
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);
        return view('user-detail', compact('user'));
    }
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('user-management')->with('success', 'User updated successfully');
    }
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user-management')->with('success', 'User deleted successfully');
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function showMessage()
    {
        return view('admin.message');
    }
    public function showOrders()
    {
        return view('admin.orders');
    }
    public function showProductManagement()
    {
        return view('admin.product-management');
    }
    public function showUserManagement()
    {
        return view('admin.user-management');
    }
    public function showProductCreate()
    {
        return view('admin.product-create');
    }
    
}
