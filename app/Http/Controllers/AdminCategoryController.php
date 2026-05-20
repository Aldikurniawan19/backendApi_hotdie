<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'background_color' => 'required|string|max:7',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['name', 'background_color']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'background_color' => 'required|string|max:7',
            'is_active' => 'boolean',
        ]);

        $data = $request->only(['name', 'background_color']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($category->image_url) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $category->image_url));
            }
            $path = $request->file('image')->store('categories', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->image_url) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $category->image_url));
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
