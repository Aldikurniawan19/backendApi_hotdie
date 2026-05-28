@extends('admin.layouts.app')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')

@section('content')
    <div class="max-w-6xl">
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                <!-- Form Area -->
                <div class="lg:col-span-2 bg-white border border-gray-200/80 rounded-2xl p-7 space-y-6 shadow-sm">
                    <div>
                        <h3 class="text-gray-900 font-bold text-lg">Informasi Produk</h3>
                        <p class="text-gray-400 text-xs mt-1">Lengkapi detail produk baru Anda</p>
                    </div>

                    {{-- Name --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk <span class="text-red-400">*</span></label>
                        <input type="text" name="name" id="input-name" value="{{ old('name') }}" required
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
                            <input type="number" name="price" id="input-price" value="{{ old('price') }}" required step="0.01" min="0"
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
                        <input type="text" name="category" id="input-category" value="{{ old('category') }}" required
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

                    {{-- Active, Popular, Trending --}}
                    <div class="space-y-3 pt-1">
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="is_active" id="is_active" value="1" checked
                                   class="w-4 h-4 rounded border-gray-300 bg-gray-50 text-brand focus:ring-brand focus:ring-offset-0">
                            <label for="is_active" class="text-sm text-gray-600 font-medium">Produk aktif (ditampilkan di toko)</label>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="is_popular" id="is_popular" value="1"
                                   class="w-4 h-4 rounded border-gray-300 bg-gray-50 text-brand focus:ring-brand focus:ring-offset-0">
                            <label for="is_popular" class="text-sm text-gray-600 font-medium">Tampilkan di "Most Popular" halaman utama</label>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="is_trending" id="is_trending" value="1"
                                   class="w-4 h-4 rounded border-gray-300 bg-gray-50 text-brand focus:ring-brand focus:ring-offset-0">
                            <label for="is_trending" class="text-sm text-gray-600 font-medium">Tampilkan di "Trending Now" halaman utama</label>
                        </div>
                    </div>
                </div>

                <!-- Preview Area -->
                <div class="lg:col-span-1 lg:sticky lg:top-24 space-y-6">
                    <div class="bg-white border border-gray-200/80 rounded-2xl p-6 shadow-sm">
                        <h3 class="text-gray-900 font-bold text-base mb-4">Preview Tampilan Aplikasi</h3>
                        
                        <!-- Real Mock Product Card -->
                        <div class="border border-gray-100 rounded-2xl overflow-hidden bg-gray-50/50 shadow-sm max-w-sm mx-auto">
                            <!-- Image Area -->
                            <div class="aspect-square w-full bg-gray-200 relative overflow-hidden flex items-center justify-center">
                                <img id="preview-card-image" src="" class="hidden w-full h-full object-cover">
                                <div id="preview-card-placeholder" class="absolute inset-0 bg-gradient-to-br from-[#E8F5E9] to-[#B2DFDB] flex items-center justify-center">
                                    <span id="preview-card-initial" class="text-[#1E7A5C] text-5xl font-bold opacity-30">?</span>
                                </div>
                                
                                <!-- Status Badges -->
                                <div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10">
                                    <span id="preview-badge-popular" class="hidden px-2.5 py-1 text-[10px] font-bold text-white bg-brand rounded-lg shadow-sm">POPULAR</span>
                                    <span id="preview-badge-trending" class="hidden px-2.5 py-1 text-[10px] font-bold text-white bg-amber-500 rounded-lg shadow-sm">TRENDING</span>
                                    <span id="preview-badge-inactive" class="hidden px-2.5 py-1 text-[10px] font-bold text-white bg-red-500 rounded-lg shadow-sm">NONAKTIF</span>
                                </div>
                            </div>
                            
                            <!-- Detail Area -->
                            <div class="p-4 bg-white space-y-2">
                                <span id="preview-card-category" class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Kategori</span>
                                <h4 id="preview-card-title" class="text-sm font-bold text-gray-800 line-clamp-2 h-10 leading-tight">Nama Produk</h4>
                                
                                <div class="pt-2 flex items-baseline gap-2">
                                    <span id="preview-card-price" class="text-base font-bold text-brand">Rp 0</span>
                                    <span id="preview-card-old-price" class="text-xs text-gray-400 line-through">Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>
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

        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('input-name');
            const priceInput = document.getElementById('input-price');
            const categoryInput = document.getElementById('input-category');
            const imageInput = document.getElementById('image-input');
            const activeCheckbox = document.getElementById('is_active');
            const popularCheckbox = document.getElementById('is_popular');
            const trendingCheckbox = document.getElementById('is_trending');

            const cardTitle = document.getElementById('preview-card-title');
            const cardCategory = document.getElementById('preview-card-category');
            const cardPrice = document.getElementById('preview-card-price');
            const cardOldPrice = document.getElementById('preview-card-old-price');
            const cardImage = document.getElementById('preview-card-image');
            const cardPlaceholder = document.getElementById('preview-card-placeholder');
            const cardInitial = document.getElementById('preview-card-initial');

            const badgePopular = document.getElementById('preview-badge-popular');
            const badgeTrending = document.getElementById('preview-badge-trending');
            const badgeInactive = document.getElementById('preview-badge-inactive');

            function formatRupiah(price) {
                if (!price || isNaN(price)) return 'Rp 0';
                if (price >= 1000000000) {
                    return 'Rp ' + (price / 1000000000).toFixed(1) + 'M';
                } else if (price >= 1000000) {
                    const val = price / 1000000;
                    return 'Rp ' + (val % 1 === 0 ? val.toFixed(0) : val.toFixed(1)) + 'jt';
                } else if (price >= 1000) {
                    return 'Rp ' + (price / 1000).toFixed(0) + 'rb';
                }
                return 'Rp ' + Math.round(price).toLocaleString('id-ID');
            }

            function updatePreview() {
                // Title
                const name = nameInput.value.trim();
                cardTitle.innerText = name || 'Nama Produk';
                cardInitial.innerText = name ? name.charAt(0).toUpperCase() : '?';

                // Category
                cardCategory.innerText = categoryInput.value.trim() || 'Kategori';

                // Price
                const price = parseFloat(priceInput.value);
                if (!isNaN(price) && price >= 0) {
                    cardPrice.innerText = formatRupiah(price);
                    cardOldPrice.innerText = formatRupiah(price * 1.2);
                    cardOldPrice.classList.remove('hidden');
                } else {
                    cardPrice.innerText = 'Rp 0';
                    cardOldPrice.innerText = '';
                    cardOldPrice.classList.add('hidden');
                }

                // Badges
                if (activeCheckbox.checked) {
                    badgeInactive.classList.add('hidden');
                } else {
                    badgeInactive.classList.remove('hidden');
                }

                if (popularCheckbox.checked) {
                    badgePopular.classList.remove('hidden');
                } else {
                    badgePopular.classList.add('hidden');
                }

                if (trendingCheckbox.checked) {
                    badgeTrending.classList.remove('hidden');
                } else {
                    badgeTrending.classList.add('hidden');
                }
            }

            // Bind listeners
            nameInput.addEventListener('input', updatePreview);
            priceInput.addEventListener('input', updatePreview);
            categoryInput.addEventListener('input', updatePreview);
            activeCheckbox.addEventListener('change', updatePreview);
            popularCheckbox.addEventListener('change', updatePreview);
            trendingCheckbox.addEventListener('change', updatePreview);

            // Handle image change
            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        cardImage.src = e.target.result;
                        cardImage.classList.remove('hidden');
                        cardPlaceholder.classList.add('hidden');
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    cardImage.classList.add('hidden');
                    cardPlaceholder.classList.remove('hidden');
                }
            });

            // Init
            updatePreview();
        });
    </script>
@endsection
