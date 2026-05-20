@extends('admin.layouts.app')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-1.5 text-gray-400 hover:text-brand text-sm font-medium transition-colors duration-200 group">
                <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke daftar produk
            </a>
        </div>

        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="bg-white border border-gray-200/80 rounded-2xl p-7 space-y-6 shadow-sm">
                <div>
                    <h3 class="text-gray-900 font-bold text-lg">Informasi Produk</h3>
                    <p class="text-gray-400 text-xs mt-1">Lengkapi detail produk baru Anda</p>
                </div>

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk <span class="text-red-400">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 focus:bg-white text-sm transition-all duration-200"
                           placeholder="Contoh: Kaos Polos Premium">
                    @error('name') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" rows="3"
                              class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 focus:bg-white text-sm resize-none transition-all duration-200"
                              placeholder="Deskripsi produk...">{{ old('description') }}</textarea>
                </div>

                {{-- Price + Stock --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Harga (Rp) <span class="text-red-400">*</span></label>
                        <input type="number" name="price" value="{{ old('price') }}" required step="0.01" min="0"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 focus:bg-white text-sm transition-all duration-200"
                               placeholder="150000">
                        @error('price') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Stok <span class="text-red-400">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" required min="0"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 focus:bg-white text-sm transition-all duration-200">
                        @error('stock') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Category --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori <span class="text-red-400">*</span></label>
                    <input type="text" name="category" value="{{ old('category') }}" required
                           class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 focus:bg-white text-sm transition-all duration-200"
                           placeholder="Tshirt, Jacket, dll">
                    @error('category') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                </div>

                {{-- Image Upload --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Gambar Produk</label>
                    <div id="upload-area" class="border-2 border-dashed border-gray-200 rounded-xl p-8 text-center hover:border-brand/40 hover:bg-brand/[0.02] transition-all duration-200 cursor-pointer"
                         onclick="document.getElementById('image-input').click()">
                        <div id="preview-container" class="hidden mb-3">
                            <img id="preview-image" class="w-24 h-24 object-cover rounded-xl mx-auto ring-2 ring-gray-100" alt="">
                        </div>
                        <div id="upload-placeholder">
                            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <p class="text-gray-600 text-sm font-medium">Klik untuk upload gambar</p>
                            <p class="text-gray-400 text-xs mt-1">JPG, PNG, WebP • Max 2MB</p>
                        </div>
                        <input type="file" name="image" id="image-input" accept="image/jpeg,image/png,image/webp" class="hidden"
                               onchange="previewFile(this)">
                    </div>
                    @error('image') <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p> @enderror
                </div>

                {{-- Sizes + Colors --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Ukuran <span class="text-gray-400 font-normal">(pisah koma)</span></label>
                        <input type="text" name="sizes" value="{{ old('sizes') }}"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 focus:bg-white text-sm transition-all duration-200"
                               placeholder="S, M, L, XL">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Warna <span class="text-gray-400 font-normal">(pisah koma)</span></label>
                        <input type="text" name="colors" value="{{ old('colors') }}"
                               class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 focus:bg-white text-sm transition-all duration-200"
                               placeholder="Hitam, Putih, Navy">
                    </div>
                </div>

                {{-- Active --}}
                <div class="flex items-center gap-3 pt-1">
                    <input type="checkbox" name="is_active" id="is_active" value="1" checked
                           class="w-4 h-4 rounded border-gray-300 bg-gray-50 text-brand focus:ring-brand focus:ring-offset-0">
                    <label for="is_active" class="text-sm text-gray-600">Produk aktif (ditampilkan di toko)</label>
                </div>
            </div>

            {{-- Submit --}}
            <div class="mt-6 flex gap-3">
                <button type="submit"
                        class="px-6 py-2.5 bg-brand hover:bg-brand-light text-white text-sm font-semibold rounded-xl transition-all duration-200 shadow-sm shadow-brand/20 hover:shadow-md hover:shadow-brand/25">
                    Simpan Produk
                </button>
                <a href="{{ route('admin.products.index') }}"
                   class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-xl transition-colors duration-200">
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
                        '<p class="text-gray-600 text-sm font-medium mt-2">' + input.files[0].name + '</p>' +
                        '<p class="text-gray-400 text-xs mt-0.5">Klik untuk ganti gambar</p>';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
