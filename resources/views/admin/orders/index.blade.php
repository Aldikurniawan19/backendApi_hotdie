@extends('admin.layouts.app')
@section('title', 'Orders')
@section('page-title', 'Orders')

@section('content')
    @if(session('success'))
        <div id="toast" class="fixed top-6 right-6 z-50 flex items-center gap-3 px-5 py-4 bg-surface-card border border-emerald-500/30 rounded-xl shadow-2xl animate-slide-in">
            <div class="w-8 h-8 bg-emerald-500/15 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <p class="text-gray-900 text-sm">{{ session('success') }}</p>
            <button onclick="this.parentElement.remove()" class="ml-3 text-gray-500 hover:text-gray-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <p class="text-gray-500 text-sm">Kelola semua pesanan</p>
        <div class="flex gap-2">
            <a href="{{ route('admin.orders.index') }}" class="px-3 py-1.5 text-sm rounded-lg transition {{ !request('status') ? 'bg-brand text-white' : 'bg-surface-hover text-gray-500' }}">Semua</a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-3 py-1.5 text-sm rounded-lg transition {{ request('status') === 'pending' ? 'bg-amber-500 text-white' : 'bg-surface-hover text-gray-500' }}">Pending</a>
            <a href="{{ route('admin.orders.index', ['status' => 'on_delivery']) }}" class="px-3 py-1.5 text-sm rounded-lg transition {{ request('status') === 'on_delivery' ? 'bg-blue-500 text-white' : 'bg-surface-hover text-gray-500' }}">Dikirim</a>
            <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}" class="px-3 py-1.5 text-sm rounded-lg transition {{ request('status') === 'completed' ? 'bg-emerald-500 text-white' : 'bg-surface-hover text-gray-500' }}">Selesai</a>
            <a href="{{ route('admin.orders.index', ['status' => 'canceled']) }}" class="px-3 py-1.5 text-sm rounded-lg transition {{ request('status') === 'canceled' ? 'bg-red-500 text-white' : 'bg-surface-hover text-gray-500' }}">Batal</a>
        </div>
    </div>

    <div class="bg-surface-card border border-surface-border rounded-xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-surface-border">
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">ID</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">User</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Total</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="table-row border-b border-surface-border/50">
                        <td class="px-6 py-4 text-gray-500 text-sm font-mono">#{{ $order->id }}</td>
                        <td class="px-6 py-4 text-gray-900 text-sm">{{ $order->user->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-right text-gray-900 text-sm font-medium">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            @php $sc = ['pending'=>'amber','on_delivery'=>'blue','completed'=>'emerald','canceled'=>'red'][$order->status] ?? 'gray'; @endphp
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-{{ $sc }}-500/10 text-{{ $sc }}-400 rounded-full text-xs font-medium">
                                <span class="w-1.5 h-1.5 bg-{{ $sc }}-400 rounded-full"></span>
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-sm">{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}" class="px-3 py-1.5 bg-surface-hover hover:bg-surface-border text-gray-500 text-xs rounded-lg transition">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-16 text-center text-gray-500 text-sm">Belum ada pesanan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <style>
        @keyframes slideIn { from { transform: translateX(120%); } to { transform: translateX(0); } }
        .animate-slide-in { animation: slideIn 0.35s cubic-bezier(0.21,1.02,0.73,1) forwards; }
    </style>
    <script>if(document.getElementById('toast'))setTimeout(()=>{const t=document.getElementById('toast');if(t)t.remove()},4000);</script>
@endsection
