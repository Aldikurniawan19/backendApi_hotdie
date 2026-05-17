<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    public function loginForm()
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            if (!Auth::user()->is_admin) {
                Auth::logout();
                return back()->with('error', 'Akun ini bukan admin.');
            }
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $totalUsers = User::count();
        $lowStock = Product::where('stock', '<', 10)->count();

        return view('admin.dashboard', compact(
            'totalProducts', 'activeProducts', 'totalUsers', 'lowStock'
        ));
    }
}
