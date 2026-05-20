@extends('admin.layouts.app')
@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')

@section('content')
    <div class="max-w-xl">
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-gray-600 text-sm flex items-center gap-1 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>
        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="bg-surface-card border border-surface-border rounded-xl p-6 space-y-5">
                <h3 class="text-gray-900 font-semibold text-lg">Kategori Baru</h3>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Nama Kategori *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:border-brand text-sm" placeholder="Contoh: T-Shirt">
                    @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Warna Background</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="background_color" value="{{ old('background_color', '#F5E6CC') }}" class="w-10 h-10 rounded-lg border border-surface-border cursor-pointer bg-transparent">
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
            <div class="mt-6 flex gap-3">
                <button type="submit" class="px-6 py-2.5 bg-brand hover:bg-brand-light text-white text-sm font-medium rounded-lg transition">Simpan</button>
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-2.5 bg-surface-hover hover:bg-surface-border text-gray-500 text-sm font-medium rounded-lg transition">Batal</a>
            </div>
        </form>
    </div>
    <script>
        function previewFile(input){if(input.files&&input.files[0]){const r=new FileReader();r.onload=function(e){document.getElementById('preview-image').src=e.target.result;document.getElementById('preview-container').classList.remove('hidden');document.getElementById('upload-placeholder').innerHTML='<p class="text-gray-500 text-sm mt-2">'+input.files[0].name+'</p>';};r.readAsDataURL(input.files[0]);}}
    </script>
@endsection
