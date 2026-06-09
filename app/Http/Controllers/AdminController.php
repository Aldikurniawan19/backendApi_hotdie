<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Banner;
use App\Models\Order;

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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            if (!Auth::user()->is_admin) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akun ini bukan admin.']);
            }
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
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
        $totalUsers = User::where('is_admin', false)->count();
        $lowStock = Product::where('stock', '<', 10)->count();
        $totalCategories = Category::count();
        $totalCoupons = Coupon::where('is_active', true)->count();
        $totalBanners = Banner::where('is_active', true)->count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();

        // Total Sales (sum of completed/all order totals)
        $totalSales = Order::where('status', 'completed')->sum('total');
        if ($totalSales == 0) {
            $totalSales = Order::sum('total'); // Fallback if no completed orders
        }

        // Monthly Sales for the current year
        $monthlySales = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlySales[] = (double) Order::whereYear('created_at', now()->year)
                ->whereMonth('created_at', $m)
                ->sum('total');
        }

        // Shipment Status counts
        $shipmentCounts = [
            'delivered'   => Order::where('status', 'completed')->count(),
            'on_delivery' => Order::where('status', 'on_delivery')->count(),
            'pending'     => Order::where('status', 'pending')->count(),
            'canceled'    => Order::where('status', 'canceled')->count(),
        ];

        // Transaksi Terkini (take 6, with items and products)
        $recentOrders = Order::with(['user', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // 5 Produk Terlaris
        $topProducts = Product::select('products.*')
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->selectRaw('COALESCE(SUM(order_items.quantity), 0) as total_sold')
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts', 'activeProducts', 'totalUsers', 'lowStock',
            'totalCategories', 'totalCoupons', 'totalBanners',
            'totalOrders', 'pendingOrders', 'recentOrders', 'topProducts',
            'totalSales', 'monthlySales', 'shipmentCounts'
        ));
    }
}
