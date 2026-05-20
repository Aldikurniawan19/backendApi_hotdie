@extends('admin.layouts.app')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-600 text-sm flex items-center gap-1 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke daftar produk
            </a>
        </div>

        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="bg-surface-card border border-surface-border rounded-xl p-6 space-y-5">
                <h3 class="text-gray-900 font-semibold text-lg">Edit: {{ $product->name }}</h3>

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Nama Produk *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                           class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:border-brand text-sm">
                    @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Deskripsi</label>
                    <textarea name="description" rows="3"
                              class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:border-brand text-sm resize-none">{{ old('description', $product->description) }}</textarea>
                </div>

                {{-- Price + Stock --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Harga (Rp) *</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" required step="0.01" min="0"
                               class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:border-brand text-sm">
                        @error('price') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Stok *</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                               class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:border-brand text-sm">
                        @error('stock') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Kategori *</label>
                    <input type="text" name="category" value="{{ old('category', $product->category) }}" required
                           class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:border-brand text-sm">
                    @error('category') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Image Upload --}}
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Gambar Produk</label>
                    <div id="upload-area" class="border-2 border-dashed border-surface-border rounded-lg p-6 text-center hover:border-brand/50 transition cursor-pointer"
                         onclick="document.getElementById('image-input').click()">
                        <div id="preview-container" class="{{ $product->image_url ? '' : 'hidden' }} mb-3">
                            <img id="preview-image" src="{{ $product->image_url }}" class="w-24 h-24 object-cover rounded-lg mx-auto" alt="">
                        </div>
                        <div id="upload-placeholder">
                            @if($product->image_url)
                                <p class="text-gray-500 text-sm">Gambar saat ini</p>
                                <p class="text-gray-600 text-xs">Klik untuk ganti gambar</p>
                            @else
                                <svg class="w-10 h-10 text-gray-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-gray-500 text-sm">Klik untuk upload gambar</p>
                                <p class="text-gray-600 text-xs mt-1">JPG, PNG, WebP • Max 2MB</p>
                            @endif
                        </div>
                        <input type="file" name="image" id="image-input" accept="image/jpeg,image/png,image/webp" class="hidden"
                               onchange="previewFile(this)">
                    </div>
                    @error('image') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Sizes + Colors --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Ukuran <span class="text-gray-600">(pisah koma)</span></label>
                        <input type="text" name="sizes" value="{{ old('sizes', is_array($product->sizes) ? implode(', ', $product->sizes) : '') }}"
                               class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:border-brand text-sm"
                               placeholder="S, M, L, XL">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Warna <span class="text-gray-600">(pisah koma)</span></label>
                        <input type="text" name="colors" value="{{ old('colors', is_array($product->colors) ? implode(', ', $product->colors) : '') }}"
                               class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:border-brand text-sm"
                               placeholder="Hitam, Putih, Navy">
                    </div>
                </div>

                {{-- Active --}}
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-surface-border bg-surface text-brand focus:ring-brand">
                    <label for="is_active" class="text-sm text-gray-500">Produk aktif (ditampilkan di toko)</label>
                </div>
            </div>

            {{-- Submit --}}
            <div class="mt-6 flex gap-3">
                <button type="submit"
                        class="px-6 py-2.5 bg-brand hover:bg-brand-light text-white text-sm font-medium rounded-lg transition">
                    Update Produk
                </button>
                <a href="{{ route('admin.products.index') }}"
                   class="px-6 py-2.5 bg-surface-hover hover:bg-surface-border text-gray-500 text-sm font-medium rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        function previewFile(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('preview-container').classList.remove('hidden');
                    document.getElementById('upload-placeholder').innerHTML =
                        '<p class="text-gray-500 text-sm mt-2">' + input.files[0].name + '</p>' +
                        '<p class="text-gray-600 text-xs">Klik untuk ganti gambar</p>';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
