<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        }

        $products = $query->latest()->paginate(6);

        return view('admin.products.index', compact('products'));
    }

    public function search(Request $request)
    {
        $search = $request->get('q', '');
        $query = Product::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        }

        $products = $query->latest()->limit(10)->get();

        return response()->json($products);
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'boolean',
            'is_popular' => 'boolean',
            'is_trending' => 'boolean',
        ]);

        $data = $request->only(['name', 'description', 'price', 'stock', 'category']);
        $data['is_active'] = $request->has('is_active');
        $data['is_popular'] = $request->has('is_popular');
        $data['is_trending'] = $request->has('is_trending');

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        // Parse sizes and colors from comma-separated input
        $data['sizes'] = $request->sizes ? array_map('trim', explode(',', $request->sizes)) : [];
        $data['colors'] = $request->colors ? array_map('trim', explode(',', $request->colors)) : [];

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'boolean',
            'is_popular' => 'boolean',
            'is_trending' => 'boolean',
        ]);

        $data = $request->only(['name', 'description', 'price', 'stock', 'category']);
        $data['is_active'] = $request->has('is_active');
        $data['is_popular'] = $request->has('is_popular');
        $data['is_trending'] = $request->has('is_trending');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_url) {
                $oldPath = str_replace('/storage/', '', $product->image_url);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        $data['sizes'] = $request->sizes ? array_map('trim', explode(',', $request->sizes)) : [];
        $data['colors'] = $request->colors ? array_map('trim', explode(',', $request->colors)) : [];

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image_url) {
            $oldPath = str_replace('/storage/', '', $product->image_url);
            Storage::disk('public')->delete($oldPath);
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
