@extends('admin.layouts.app')
@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')
    <div class="max-w-xl">
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-gray-600 text-sm flex items-center gap-1 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="bg-surface-card border border-surface-border rounded-xl p-6 space-y-5">
                <h3 class="text-gray-900 font-semibold text-lg">Edit: {{ $category->name }}</h3>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Nama Kategori *</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:border-brand text-sm">
                    @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Warna Background</label>
                    <input type="color" name="background_color" value="{{ old('background_color', $category->background_color) }}" class="w-10 h-10 rounded-lg border border-surface-border cursor-pointer bg-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Gambar</label>
                    <div class="border-2 border-dashed border-surface-border rounded-lg p-6 text-center hover:border-brand/50 transition cursor-pointer" onclick="document.getElementById('image-input').click()">
                        <div id="preview-container" class="{{ $category->image_url ? '' : 'hidden' }} mb-3"><img id="preview-image" src="{{ $category->image_url }}" class="w-20 h-20 object-cover rounded-lg mx-auto" alt=""></div>
                        <p class="text-gray-500 text-sm">{{ $category->image_url ? 'Klik untuk ganti' : 'Klik untuk upload' }}</p>
                        <input type="file" name="image" id="image-input" accept="image/*" class="hidden" onchange="previewFile(this)">
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ $category->is_active ? 'checked' : '' }} class="w-4 h-4 rounded border-surface-border bg-surface text-brand focus:ring-brand">
                    <label for="is_active" class="text-sm text-gray-500">Aktif</label>
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <button type="submit" class="px-6 py-2.5 bg-brand hover:bg-brand-light text-white text-sm font-medium rounded-lg transition">Update</button>
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-2.5 bg-surface-hover hover:bg-surface-border text-gray-500 text-sm font-medium rounded-lg transition">Batal</a>
            </div>
        </form>
    </div>
    <script>
        function previewFile(input){if(input.files&&input.files[0]){const r=new FileReader();r.onload=function(e){document.getElementById('preview-image').src=e.target.result;document.getElementById('preview-container').classList.remove('hidden');};r.readAsDataURL(input.files[0]);}}
    </script>
@endsection
