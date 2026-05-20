<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class AdminCouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:255',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['code', 'discount_type', 'discount_value', 'min_purchase', 'category', 'description', 'expires_at']);
        $data['code'] = strtoupper($data['code']);
        $data['is_active'] = $request->has('is_active');

        Coupon::create($data);
        return redirect()->route('admin.coupons.index')->with('success', 'Kupon berhasil ditambahkan.');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:255',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['code', 'discount_type', 'discount_value', 'min_purchase', 'category', 'description', 'expires_at']);
        $data['code'] = strtoupper($data['code']);
        $data['is_active'] = $request->has('is_active');

        $coupon->update($data);
        return redirect()->route('admin.coupons.index')->with('success', 'Kupon berhasil diperbarui.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Kupon berhasil dihapus.');
    }
}
