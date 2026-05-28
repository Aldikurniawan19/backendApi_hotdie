@extends('admin.layouts.app')
@section('title', 'Tambah Banner')
@section('page-title', 'Tambah Banner')

@section('content')
    <div class="max-w-6xl">
        <div class="mb-6">
            <a href="{{ route('admin.banners.index') }}" class="text-gray-500 hover:text-gray-600 text-sm flex items-center gap-1 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>
        <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                <!-- Form Area -->
                <div class="lg:col-span-2 bg-surface-card border border-surface-border rounded-xl p-6 space-y-5">
                    <h3 class="text-gray-900 font-semibold text-lg">Banner Baru</h3>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Tag *</label>
                        <input type="text" name="tag" id="input-tag" value="{{ old('tag') }}" required class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:border-brand text-sm" placeholder="#WINTER SALE">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Teks Promo *</label>
                        <input type="text" name="offer_text" id="input-offer" value="{{ old('offer_text') }}" required class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:border-brand text-sm" placeholder="35% Off">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Deskripsi</label>
                        <input type="text" name="description" id="input-desc" value="{{ old('description') }}" class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:border-brand text-sm" placeholder="Discover our latest products">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Warna Background</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="background_color" id="input-bgcolor" value="{{ old('background_color', '#F5E6CC') }}" class="w-10 h-10 rounded-lg border border-surface-border cursor-pointer bg-transparent">
                                <span class="text-gray-500 text-xs">Warna latar banner</span>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Posisi Urutan</label>
                            <input type="number" name="position" value="{{ old('position', 0) }}" min="0" class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 focus:outline-none focus:border-brand text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Gambar Banner</label>
                        <div id="upload-area" class="border-2 border-dashed border-surface-border rounded-lg p-6 text-center hover:border-brand/50 transition cursor-pointer" onclick="document.getElementById('image-input').click()">
                            <div id="preview-container" class="hidden mb-3"><img id="preview-image" class="w-32 h-16 object-cover rounded-lg mx-auto" alt=""></div>
                            <div id="upload-placeholder">
                                <svg class="w-8 h-8 text-gray-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-gray-500 text-sm">Klik untuk upload</p>
                            </div>
                            <input type="file" name="image" id="image-input" accept="image/*" class="hidden" onchange="previewFile(this)">
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="is_active" id="is_active" value="1" checked class="w-4 h-4 rounded border-surface-border bg-surface text-brand focus:ring-brand">
                        <label for="is_active" class="text-sm text-gray-500">Aktif</label>
                    </div>
                </div>

                <!-- Preview Area -->
                <div class="lg:col-span-1 lg:sticky lg:top-24 space-y-6">
                    <div class="bg-white border border-gray-200/80 rounded-2xl p-6 shadow-sm">
                        <h3 class="text-gray-900 font-bold text-base mb-4">Preview Tampilan Aplikasi</h3>
                        
                        <!-- Mobile Banner Mock -->
                        <div id="preview-banner-bg" class="h-[200px] w-full rounded-2xl overflow-hidden shadow-sm relative flex bg-[#F5E6CC] max-w-sm mx-auto transition-colors duration-200">
                            <!-- Image Area (Left) -->
                            <div class="w-[40%] h-full p-4 flex-shrink-0 flex items-center justify-center">
                                <div class="w-full h-full rounded-lg bg-gray-200/80 overflow-hidden relative flex items-center justify-center shadow-sm">
                                    <img id="preview-banner-image" src="" class="hidden w-full h-full object-cover">
                                    <div id="preview-banner-placeholder-icon" class="absolute inset-0 flex items-center justify-center bg-gray-300/30">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Text Area (Right) -->
                            <div class="w-[60%] p-4 pl-0 flex flex-col justify-center space-y-1.5 text-left">
                                <span id="preview-banner-tag" class="text-xs font-bold text-brand uppercase tracking-wider">#WINTER SALE</span>
                                <h4 id="preview-banner-offer" class="text-2xl font-extrabold text-gray-800 leading-tight">35% Off</h4>
                                <p id="preview-banner-desc" class="text-[11px] text-gray-500 line-clamp-2 leading-relaxed">Discover our latest products</p>
                                
                                <div class="pt-2">
                                    <span class="inline-block px-4 py-1.5 text-[10px] font-bold text-white bg-brand rounded shadow-sm">Shop Now</span>
                                </div>
                            </div>

                            <!-- Nonaktif Badge -->
                            <div class="absolute top-2 right-2 z-10">
                                <span id="preview-badge-inactive" class="hidden px-2 py-0.5 text-[9px] font-bold text-white bg-red-500 rounded shadow-sm">NONAKTIF</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="px-6 py-2.5 bg-brand hover:bg-brand-light text-white text-sm font-medium rounded-lg transition">Simpan</button>
                <a href="{{ route('admin.banners.index') }}" class="px-6 py-2.5 bg-surface-hover hover:bg-surface-border text-gray-500 text-sm font-medium rounded-lg transition">Batal</a>
            </div>
        </form>
    </div>

    <script>
        function previewFile(input){
            if(input.files&&input.files[0]){
                const r=new FileReader();
                r.onload=function(e){
                    document.getElementById('preview-image').src=e.target.result;
                    document.getElementById('preview-container').classList.remove('hidden');
                    document.getElementById('upload-placeholder').innerHTML='<p class="text-gray-500 text-sm mt-2">'+input.files[0].name+'</p>';
                };
                r.readAsDataURL(input.files[0]);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const tagInput = document.getElementById('input-tag');
            const offerInput = document.getElementById('input-offer');
            const descInput = document.getElementById('input-desc');
            const colorInput = document.getElementById('input-bgcolor');
            const imageInput = document.getElementById('image-input');
            const activeCheckbox = document.getElementById('is_active');

            const bannerTag = document.getElementById('preview-banner-tag');
            const bannerOffer = document.getElementById('preview-banner-offer');
            const bannerDesc = document.getElementById('preview-banner-desc');
            const bannerBg = document.getElementById('preview-banner-bg');
            const bannerImage = document.getElementById('preview-banner-image');
            const bannerPlaceholderIcon = document.getElementById('preview-banner-placeholder-icon');
            const badgeInactive = document.getElementById('preview-badge-inactive');

            function updatePreview() {
                // Tag
                bannerTag.innerText = tagInput.value.trim() || '#TAG PROMO';

                // Offer
                bannerOffer.innerText = offerInput.value.trim() || 'Diskon';

                // Description
                bannerDesc.innerText = descInput.value.trim() || 'Deskripsi promo singkat';

                // Background Color
                bannerBg.style.backgroundColor = colorInput.value;

                // Active status
                if (activeCheckbox.checked) {
                    badgeInactive.classList.add('hidden');
                } else {
                    badgeInactive.classList.remove('hidden');
                }
            }

            tagInput.addEventListener('input', updatePreview);
            offerInput.addEventListener('input', updatePreview);
            descInput.addEventListener('input', updatePreview);
            colorInput.addEventListener('input', updatePreview);
            activeCheckbox.addEventListener('change', updatePreview);

            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        bannerImage.src = e.target.result;
                        bannerImage.classList.remove('hidden');
                        bannerPlaceholderIcon.classList.add('hidden');
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    bannerImage.classList.add('hidden');
                    bannerPlaceholderIcon.classList.remove('hidden');
                }
            });

            // Init
            updatePreview();
        });
    </script>
@endsection
