<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class BannerController extends Controller
{
    /**
     * Get all active banners ordered by position
     */
    public function index()
    {
        $banners = Banner::where('is_active', true)
            ->orderBy('position')
            ->get()
            ->map(function ($banner) {
                return [
                    'id' => $banner->id,
                    'tag' => $banner->tag,
                    'offer_text' => $banner->offer_text,
                    'description' => $banner->description,
                    'image_url' => $banner->image_url,
                    'background_color' => $banner->background_color,
                    'position' => $banner->position,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $banners,
        ]);
    }
}
