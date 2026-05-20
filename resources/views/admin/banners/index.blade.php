@extends('admin.layouts.app')
@section('title', 'Banners')
@section('page-title', 'Banners')

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
                    <h3 class="text-gray-900 font-semibold text-lg">Hapus Banner</h3>
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
        <p class="text-gray-500 text-sm">Kelola banner promo di halaman utama</p>
        <a href="{{ route('admin.banners.create') }}" class="px-4 py-2.5 bg-brand hover:bg-brand-light text-white text-sm font-medium rounded-lg transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Banner
        </a>
    </div>

    <div class="space-y-4">
        @forelse($banners as $banner)
            <div class="bg-surface-card border border-surface-border rounded-xl overflow-hidden hover:border-brand/30 transition group">
                <div class="flex items-center">
                    <div class="w-48 h-24 flex-shrink-0 flex items-center justify-center" style="background: {{ $banner->background_color }}">
                        @if($banner->image_url)
                            <img src="{{ $banner->image_url }}" class="w-full h-full object-cover" alt="">
                        @else
                            <svg class="w-8 h-8 text-gray-700/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        @endif
                    </div>
                    <div class="flex-1 px-5 py-3">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-brand text-xs font-medium">{{ $banner->tag }}</span>
                            <span class="text-gray-600 text-xs">• Posisi {{ $banner->position }}</span>
                        </div>
                        <p class="text-gray-900 font-semibold text-sm">{{ $banner->offer_text }}</p>
                        <p class="text-gray-500 text-xs mt-0.5">{{ $banner->description }}</p>
                    </div>
                    <div class="px-4 flex items-center gap-3">
                        @if($banner->is_active)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-500/10 text-emerald-400 rounded-full text-xs font-medium"><span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>Aktif</span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-500/10 text-gray-500 rounded-full text-xs font-medium"><span class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>Off</span>
                        @endif
                        <div class="flex gap-1 transition">
                            <a href="{{ route('admin.banners.edit', $banner) }}" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-100 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <button onclick="openDeleteModal('{{ route('admin.banners.destroy', $banner) }}', '{{ $banner->offer_text }}')" class="p-2 text-red-600 hover:text-red-800 hover:bg-red-100 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-16">
                <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-gray-500 text-sm">Belum ada banner</p>
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
