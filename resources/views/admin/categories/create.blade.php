@extends('admin.layouts.app')
@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')

@section('content')
    <div class="max-w-6xl">
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-gray-600 text-sm flex items-center gap-1 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>
        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                <!-- Form Area -->
                <div class="lg:col-span-2 bg-surface-card border border-surface-border rounded-xl p-6 space-y-5">
                    <h3 class="text-gray-900 font-semibold text-lg">Kategori Baru</h3>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Nama Kategori *</label>
                        <input type="text" name="name" id="input-name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:border-brand text-sm" placeholder="Contoh: T-Shirt">
                        @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Warna Background</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="background_color" id="input-bgcolor" value="{{ old('background_color', '#F5E6CC') }}" class="w-10 h-10 rounded-lg border border-surface-border cursor-pointer bg-transparent">
                            <span class="text-gray-500 text-xs">Warna latar kategori di aplikasi</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Gambar</label>
                        <div id="upload-area" class="border-2 border-dashed border-surface-border rounded-lg p-6 text-center hover:border-brand/50 transition cursor-pointer" onclick="document.getElementById('image-input').click()">
                            <div id="preview-container" class="hidden mb-3"><img id="preview-image" class="w-20 h-20 object-cover rounded-lg mx-auto" alt=""></div>
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
                        
                        <!-- Mobile Category Card Mock -->
                        <div id="preview-card-bg" class="h-[140px] rounded-xl overflow-hidden shadow-sm relative flex bg-[#F5E6CC] max-w-sm mx-auto transition-colors duration-200">
                            <!-- Detail Area -->
                            <div class="flex-1 p-5 flex flex-col justify-center space-y-1">
                                <h4 id="preview-card-title" class="text-xl font-bold text-gray-800 line-clamp-1 leading-tight">Nama Kategori</h4>
                                <span class="text-xs text-gray-500">120 items</span>
                                
                                <div class="pt-3">
                                    <span class="inline-block px-3 py-1.5 text-[10px] font-bold text-white bg-brand rounded-lg shadow-sm">Shop Now</span>
                                </div>
                            </div>
                            
                            <!-- Image Area -->
                            <div class="w-[120px] h-full bg-gray-200 relative overflow-hidden flex items-center justify-center flex-shrink-0">
                                <img id="preview-card-image" src="" class="hidden w-full h-full object-cover">
                                <div id="preview-card-placeholder-icon" class="absolute inset-0 flex items-center justify-center bg-gray-300/30">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                                </div>
                            </div>

                            <!-- Nonaktif Badge -->
                            <div class="absolute top-2 left-2 z-10">
                                <span id="preview-badge-inactive" class="hidden px-2 py-0.5 text-[9px] font-bold text-white bg-red-500 rounded shadow-sm">NONAKTIF</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="px-6 py-2.5 bg-brand hover:bg-brand-light text-white text-sm font-medium rounded-lg transition">Simpan</button>
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-2.5 bg-surface-hover hover:bg-surface-border text-gray-500 text-sm font-medium rounded-lg transition">Batal</a>
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
            const nameInput = document.getElementById('input-name');
            const colorInput = document.getElementById('input-bgcolor');
            const imageInput = document.getElementById('image-input');
            const activeCheckbox = document.getElementById('is_active');

            const cardTitle = document.getElementById('preview-card-title');
            const cardBg = document.getElementById('preview-card-bg');
            const cardImage = document.getElementById('preview-card-image');
            const cardPlaceholderIcon = document.getElementById('preview-card-placeholder-icon');
            const badgeInactive = document.getElementById('preview-badge-inactive');

            function updatePreview() {
                // Title
                cardTitle.innerText = nameInput.value.trim() || 'Nama Kategori';

                // Background Color
                cardBg.style.backgroundColor = colorInput.value;

                // Active status
                if (activeCheckbox.checked) {
                    badgeInactive.classList.add('hidden');
                } else {
                    badgeInactive.classList.remove('hidden');
                }
            }

            nameInput.addEventListener('input', updatePreview);
            colorInput.addEventListener('input', updatePreview);
            activeCheckbox.addEventListener('change', updatePreview);

            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        cardImage.src = e.target.result;
                        cardImage.classList.remove('hidden');
                        cardPlaceholderIcon.classList.add('hidden');
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    cardImage.classList.add('hidden');
                    cardPlaceholderIcon.classList.remove('hidden');
                }
            });

            // Init
            updatePreview();
        });
    </script>
@endsection
