<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Get active coupons.
     */
    public function index()
    {
        $coupons = Coupon::where('is_active', true)
            ->where(function($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>=', now()->toDateString());
            })
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Kupon berhasil dimuat',
            'data'    => $coupons,
        ]);
    }

    /**
     * Validate a coupon code and calculate discount.
     */
    public function check(Request $request)
    {
        $request->validate([
            'code'     => 'required|string',
            'subtotal' => 'required|numeric',
        ]);

        $coupon = Coupon::where('code', $request->code)
            ->where('is_active', true)
            ->where(function($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>=', now()->toDateString());
            })
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Kupon tidak valid atau sudah kedaluwarsa.',
            ], 422);
        }

        if ($request->subtotal < $coupon->min_purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Minimal pembelian untuk menggunakan kupon ini adalah Rp ' . number_format($coupon->min_purchase, 0, ',', '.'),
            ], 422);
        }

        // Calculate discount
        $discount = 0.0;
        if ($coupon->discount_type === 'percentage') {
            $discount = (double) $request->subtotal * ($coupon->discount_value / 100);
        } else {
            $discount = (double) $coupon->discount_value;
        }

        // Cap discount to subtotal
        if ($discount > $request->subtotal) {
            $discount = (double) $request->subtotal;
        }

        return response()->json([
            'success' => true,
            'message' => 'Kupon berhasil digunakan.',
            'data'    => [
                'code'            => $coupon->code,
                'discount_type'   => $coupon->discount_type,
                'discount_value'  => $coupon->discount_value,
                'discount_amount' => $discount,
                'min_purchase'    => $coupon->min_purchase,
            ],
        ]);
    }
}
