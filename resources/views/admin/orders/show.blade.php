@extends('admin.layouts.app')
@section('title', 'Detail Order #' . $order->id)
@section('page-title', 'Detail Order')

@section('content')
    @if(session('success'))
        <div id="toast" class="fixed top-6 right-6 z-50 flex items-center gap-3 px-5 py-4 bg-surface-card border border-emerald-500/30 rounded-xl shadow-2xl animate-slide-in">
            <div class="w-8 h-8 bg-emerald-500/15 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <p class="text-gray-900 text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-gray-500 hover:text-gray-600 text-sm flex items-center gap-1 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-surface-card border border-surface-border rounded-xl p-6">
                <h3 class="text-gray-900 font-semibold mb-4">Order #{{ $order->id }}</h3>
                <div class="space-y-3">
                    @forelse($order->items as $item)
                        <div class="flex items-center gap-4 py-3 border-b border-surface-border/50 last:border-0">
                            @if($item->product && $item->product->image_url)
                                <img src="{{ $item->product->image_url }}" class="w-12 h-12 rounded-lg object-cover bg-surface">
                            @else
                                <div class="w-12 h-12 bg-surface rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <p class="text-gray-900 text-sm font-medium">{{ $item->product->name ?? 'Produk dihapus' }}</p>
                                @if($item->variant)<p class="text-gray-500 text-xs">{{ $item->variant }}</p>@endif
                            </div>
                            <p class="text-gray-500 text-sm">x{{ $item->quantity }}</p>
                            <p class="text-gray-900 text-sm font-medium">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">Tidak ada item</p>
                    @endforelse
                </div>
            </div>

            @if($order->shipping_address)
                <div class="bg-surface-card border border-surface-border rounded-xl p-6">
                    <h3 class="text-gray-900 font-semibold mb-2">Alamat Pengiriman</h3>
                    <p class="text-gray-500 text-sm">{{ $order->shipping_address }}</p>
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-surface-card border border-surface-border rounded-xl p-6">
                <h3 class="text-gray-900 font-semibold mb-4">Ringkasan</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Customer</span><span class="text-gray-900">{{ $order->user->name ?? '-' }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Tanggal</span><span class="text-gray-900">{{ $order->created_at->format('d M Y H:i') }}</span></div>
                    @if($order->coupon_code)
                        <div class="flex justify-between"><span class="text-gray-500">Kupon</span><span class="text-brand font-mono">{{ $order->coupon_code }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Diskon</span><span class="text-red-400">-Rp {{ number_format($order->discount, 0, ',', '.') }}</span></div>
                    @endif
                    <div class="border-t border-surface-border pt-3 flex justify-between font-semibold"><span class="text-gray-600">Total</span><span class="text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</span></div>
                </div>
            </div>

            <div class="bg-surface-card border border-surface-border rounded-xl p-6">
                <h3 class="text-gray-900 font-semibold mb-4">Update Status</h3>
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                    @csrf @method('PUT')
                    <select name="status" class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 text-sm focus:outline-none focus:border-brand mb-3">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="on_delivery" {{ $order->status === 'on_delivery' ? 'selected' : '' }}>On Delivery</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="canceled" {{ $order->status === 'canceled' ? 'selected' : '' }}>Canceled</option>
                    </select>
                    <button type="submit" class="w-full px-4 py-2.5 bg-brand hover:bg-brand-light text-white text-sm font-medium rounded-lg transition">Update Status</button>
                </form>
            </div>
        </div>
    </div>

    <style>
        @keyframes slideIn { from { transform: translateX(120%); } to { transform: translateX(0); } }
        .animate-slide-in { animation: slideIn 0.35s cubic-bezier(0.21,1.02,0.73,1) forwards; }
    </style>
    <script>if(document.getElementById('toast'))setTimeout(()=>{const t=document.getElementById('toast');if(t)t.remove()},4000);</script>
@endsection
