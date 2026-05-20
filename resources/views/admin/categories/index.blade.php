@extends('admin.layouts.app')
@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')
    @if(session('success'))
        <div id="toast" class="fixed top-6 right-6 z-50 flex items-center gap-3 px-5 py-4 bg-surface-card border border-emerald-500/30 rounded-xl shadow-2xl shadow-black/30 animate-slide-in">
            <div class="w-8 h-8 bg-emerald-500/15 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <div>
                <p class="text-gray-900 text-sm font-medium">Berhasil!</p>
                <p class="text-gray-500 text-xs mt-0.5">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-4 text-gray-500 hover:text-gray-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
    @endif

    <div id="delete-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-surface-card border border-surface-border rounded-2xl p-6 w-full max-w-sm shadow-2xl animate-modal-in">
                <div class="text-center">
                    <div class="w-14 h-14 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </div>
                    <h3 class="text-gray-900 font-semibold text-lg">Hapus Kategori</h3>
                    <p class="text-gray-500 text-sm mt-2">Yakin ingin menghapus <span id="delete-item-name" class="text-gray-900 font-medium"></span>?</p>
                </div>
                <div class="flex gap-3 mt-6">
                    <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2.5 bg-surface-hover hover:bg-surface-border text-gray-500 text-sm font-medium rounded-xl transition">Batal</button>
                    <form id="delete-form" method="POST" class="flex-1">@csrf @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-xl transition">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between mb-6">
        <p class="text-gray-500 text-sm">Kelola kategori produk</p>
        <a href="{{ route('admin.categories.create') }}" class="px-4 py-2.5 bg-brand hover:bg-brand-light text-white text-sm font-medium rounded-lg transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Kategori
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($categories as $category)
            <div class="bg-surface-card border border-surface-border rounded-xl p-4 hover:border-brand/30 transition group">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden" style="background: {{ $category->background_color }}">
                        @if($category->image_url)
                            <img src="{{ $category->image_url }}" class="w-full h-full object-cover" alt="">
                        @else
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-gray-900 font-medium text-sm truncate">{{ $category->name }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            @if($category->is_active)
                                <span class="inline-flex items-center gap-1 text-xs text-emerald-400"><span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>Aktif</span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs text-gray-500"><span class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>Nonaktif</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex gap-1 transition">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-100 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <button onclick="openDeleteModal('{{ route('admin.categories.destroy', $category) }}', '{{ $category->name }}')" class="p-2 text-red-600 hover:text-red-800 hover:bg-red-100 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                <p class="text-gray-500 text-sm">Belum ada kategori</p>
            </div>
        @endforelse
    </div>

    <style>
        @keyframes slideIn { from { transform: translateX(120%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes modalIn { from { transform: scale(0.9); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        .animate-slide-in { animation: slideIn 0.35s cubic-bezier(0.21,1.02,0.73,1) forwards; }
        .animate-modal-in { animation: modalIn 0.2s ease-out forwards; }
    </style>
    <script>
        if(document.getElementById('toast')) setTimeout(()=>{const t=document.getElementById('toast');if(t)t.remove()},4000);
        function openDeleteModal(a,n){document.getElementById('delete-form').action=a;document.getElementById('delete-item-name').textContent=n;document.getElementById('delete-modal').classList.remove('hidden');}
        function closeDeleteModal(){document.getElementById('delete-modal').classList.add('hidden');}
        document.addEventListener('keydown',e=>{if(e.key==='Escape')closeDeleteModal();});
    </script>
@endsection
