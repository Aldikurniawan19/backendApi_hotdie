<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminBannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('position')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tag' => 'required|string|max:100',
            'offer_text' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'background_color' => 'required|string|max:7',
            'position' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['tag', 'offer_text', 'description', 'background_color', 'position']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        Banner::create($data);
        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil ditambahkan.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'tag' => 'required|string|max:100',
            'offer_text' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'background_color' => 'required|string|max:7',
            'position' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['tag', 'offer_text', 'description', 'background_color', 'position']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($banner->image_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $banner->image_url));
            }
            $path = $request->file('image')->store('banners', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        $banner->update($data);
        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil diperbarui.');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $banner->image_url));
        }
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil dihapus.');
    }
}
