<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Get all wishlist items for the authenticated user.
     */
    public function index(Request $request)
    {
        $wishlists = Wishlist::where('user_id', $request->user()->id)
            ->with('product')
            ->latest()
            ->get();

        // Return product data with wishlist info
        $products = $wishlists
            ->filter(fn ($w) => $w->product !== null)
            ->map(fn ($w) => $w->product)
            ->values();

        return response()->json([
            'success' => true,
            'message' => 'Wishlist berhasil dimuat',
            'data' => $products,
        ]);
    }

    /**
     * Toggle a product in the wishlist (add if not exists, remove if exists).
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $userId = $request->user()->id;
        $productId = $request->product_id;

        $existing = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'success' => true,
                'message' => 'Produk dihapus dari wishlist',
                'data' => [
                    'is_wishlisted' => false,
                ],
            ]);
        }

        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk ditambahkan ke wishlist',
            'data' => [
                'is_wishlisted' => true,
            ],
        ], 201);
    }

    /**
     * Check if a single product is in the user's wishlist.
     */
    public function check(Request $request, int $productId)
    {
        $exists = Wishlist::where('user_id', $request->user()->id)
            ->where('product_id', $productId)
            ->exists();

        return response()->json([
            'success' => true,
            'data' => [
                'is_wishlisted' => $exists,
            ],
        ]);
    }

    /**
     * Check multiple product IDs at once.
     * Useful for marking wishlist status on product listings.
     */
    public function checkMultiple(Request $request)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'integer',
        ]);

        $wishlistedIds = Wishlist::where('user_id', $request->user()->id)
            ->whereIn('product_id', $request->product_ids)
            ->pluck('product_id')
            ->toArray();

        return response()->json([
            'success' => true,
            'data' => [
                'wishlisted_ids' => $wishlistedIds,
            ],
        ]);
    }
}
