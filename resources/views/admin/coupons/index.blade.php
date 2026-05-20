@extends('admin.layouts.app')
@section('title', 'Coupons')
@section('page-title', 'Coupons')

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
                    <h3 class="text-gray-900 font-semibold text-lg">Hapus Kupon</h3>
                    <p class="text-gray-500 text-sm mt-2">Yakin ingin menghapus kupon <span id="delete-item-name" class="text-gray-900 font-medium font-mono"></span>?</p>
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
        <p class="text-gray-500 text-sm">Kelola kupon & promo</p>
        <a href="{{ route('admin.coupons.create') }}" class="px-4 py-2.5 bg-brand hover:bg-brand-light text-white text-sm font-medium rounded-lg transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Kupon
        </a>
    </div>

    <div class="bg-surface-card border border-surface-border rounded-xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-surface-border">
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kode</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Diskon</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Min. Pembelian</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Berlaku Sampai</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $coupon)
                    <tr class="table-row border-b border-surface-border/50">
                        <td class="px-6 py-4">
                            <span class="px-3 py-1.5 bg-brand/10 text-brand rounded-lg text-sm font-mono font-bold">{{ $coupon->code }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-900 text-sm">
                            {{ $coupon->discount_type === 'percentage' ? $coupon->discount_value . '%' : 'Rp ' . number_format($coupon->discount_value, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-sm">Rp {{ number_format($coupon->min_purchase, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm {{ $coupon->expires_at && $coupon->expires_at->isPast() ? 'text-red-400' : 'text-gray-500' }}">
                            {{ $coupon->expires_at ? $coupon->expires_at->format('d M Y') : 'Tidak ada batas' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($coupon->is_active && (!$coupon->expires_at || !$coupon->expires_at->isPast()))
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-500/10 text-emerald-400 rounded-full text-xs font-medium"><span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>Aktif</span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-500/10 text-gray-500 rounded-full text-xs font-medium"><span class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>{{ $coupon->expires_at && $coupon->expires_at->isPast() ? 'Expired' : 'Nonaktif' }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.coupons.edit', $coupon) }}" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-100 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <button onclick="openDeleteModal('{{ route('admin.coupons.destroy', $coupon) }}', '{{ $coupon->code }}')" class="p-2 text-red-600 hover:text-red-800 hover:bg-red-100 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-16 text-center"><p class="text-gray-500 text-sm">Belum ada kupon</p></td></tr>
                @endforelse
            </tbody>
        </table>
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
