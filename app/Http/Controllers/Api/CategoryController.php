<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Get all active categories with dynamic product counts.
     */
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount(['products' => function ($query) {
                $query->where('is_active', true);
            }])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }
}
