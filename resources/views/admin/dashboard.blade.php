@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Overview')

@section('content')
    <div class="space-y-6">
        {{-- Welcome Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Selamat Datang, {{ auth()->user()->name ?? 'Admin' }}!</h2>
                <p class="text-gray-600 mt-1 text-sm">Berikut adalah ringkasan performa toko Anda hari ini.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.orders.index') }}" class="px-5 py-2.5 bg-brand text-white text-sm font-medium rounded-xl hover:bg-brand-light transition-all shadow-[0_0_15px_rgba(30,122,92,0.2)] hover:shadow-[0_0_20px_rgba(30,122,92,0.4)] flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    Kelola Pesanan
                </a>
            </div>
        </div>

        {{-- Primary Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- Stat 1 --}}
            <div class="relative overflow-hidden bg-surface-card rounded-2xl border border-surface-border p-5 group hover:border-brand/50 transition duration-300 shadow-sm">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-brand/20 to-brand/5 flex items-center justify-center border border-brand/10 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Produk</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-0.5 tracking-tight">{{ $totalProducts }}</h3>
                    </div>
                </div>
                <div class="flex items-center text-xs text-brand font-medium">
                    <span class="bg-brand/10 px-2 py-1 rounded-md flex items-center gap-1.5">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ $activeProducts }} Produk Aktif
                    </span>
                </div>
            </div>

            {{-- Stat 2 --}}
            <div class="relative overflow-hidden bg-surface-card rounded-2xl border border-surface-border p-5 group hover:border-blue-500/50 transition duration-300 shadow-sm">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500/20 to-blue-500/5 flex items-center justify-center border border-blue-500/10 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Pengguna</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-0.5 tracking-tight">{{ $totalUsers }}</h3>
                    </div>
                </div>
                 <div class="flex items-center text-xs text-blue-600 font-medium">
                    <span class="bg-blue-50 px-2 py-1 rounded-md flex items-center gap-1.5 border border-blue-100">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Pelanggan Terdaftar
                    </span>
                </div>
            </div>

            {{-- Stat 3 --}}
            <div class="relative overflow-hidden bg-surface-card rounded-2xl border border-surface-border p-5 group hover:border-purple-500/50 transition duration-300 shadow-sm">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500/20 to-purple-500/5 flex items-center justify-center border border-purple-500/10 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Pesanan</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-0.5 tracking-tight">{{ $totalOrders }}</h3>
                    </div>
                </div>
                <div class="flex items-center text-xs text-purple-600 font-medium">
                    <span class="bg-purple-50 px-2 py-1 rounded-md flex items-center gap-1.5 border border-purple-100">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        Keseluruhan Transaksi
                    </span>
                </div>
            </div>

            {{-- Stat 4 --}}
            <div class="relative overflow-hidden bg-surface-card rounded-2xl border border-amber-200 p-5 group hover:border-amber-400 transition duration-300 shadow-sm shadow-amber-100">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500/20 to-amber-500/5 flex items-center justify-center border border-amber-200 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-amber-700">Pesanan Pending</p>
                        <h3 class="text-2xl font-bold text-amber-600 mt-0.5 tracking-tight">{{ $pendingOrders }}</h3>
                    </div>
                </div>
                <div class="flex items-center text-xs text-amber-600 font-medium">
                    <span class="bg-amber-50 px-2 py-1 rounded-md flex items-center gap-1.5 border border-amber-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                        Perlu Segera Diproses
                    </span>
                </div>
            </div>
        </div>

        {{-- Secondary Stats & Lists --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
            {{-- Recent Transactions --}}
            <div class="xl:col-span-2 bg-surface-card rounded-2xl border border-surface-border p-6 lg:p-8 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-base font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Transaksi Terkini
                    </h3>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-brand hover:text-brand-light font-medium transition">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-500 uppercase bg-surface border-y border-surface-border">
                            <tr>
                                <th class="px-4 py-3 font-medium">Order ID</th>
                                <th class="px-4 py-3 font-medium">Pelanggan</th>
                                <th class="px-4 py-3 font-medium">Total</th>
                                <th class="px-4 py-3 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-border">
                            @forelse($recentOrders as $order)
                            <tr class="hover:bg-surface transition">
                                <td class="px-4 py-3 text-gray-600 font-medium">#{{ $order->id }}</td>
                                <td class="px-4 py-3 text-gray-900 font-medium">{{ $order->user->name ?? 'User' }}</td>
                                <td class="px-4 py-3 text-brand font-semibold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    @if($order->status == 'pending')
                                        <span class="px-2.5 py-1 text-xs font-medium bg-amber-50 text-amber-600 rounded-lg border border-amber-200">Pending</span>
                                    @elseif($order->status == 'processing')
                                        <span class="px-2.5 py-1 text-xs font-medium bg-blue-50 text-blue-600 rounded-lg border border-blue-200">Proses</span>
                                    @elseif($order->status == 'shipped')
                                        <span class="px-2.5 py-1 text-xs font-medium bg-purple-50 text-purple-600 rounded-lg border border-purple-200">Dikirim</span>
                                    @elseif($order->status == 'completed')
                                        <span class="px-2.5 py-1 text-xs font-medium bg-emerald-50 text-emerald-600 rounded-lg border border-emerald-200">Selesai</span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-medium bg-red-50 text-red-600 rounded-lg border border-red-200">Dibatalkan</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500">Belum ada transaksi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Top Products --}}
            <div class="bg-surface-card rounded-2xl border border-surface-border p-6 lg:p-8 shadow-sm">
                <h3 class="text-base font-semibold text-gray-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    5 Produk Terlaris
                </h3>
                <div class="flex flex-col gap-4">
                    @forelse($topProducts as $index => $product)
                    <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-surface transition group border border-transparent hover:border-surface-border">
                        <div class="w-10 h-10 rounded-lg bg-surface flex items-center justify-center font-bold border {{ $index == 0 ? 'text-amber-500 border-amber-300 bg-amber-50' : ($index == 1 ? 'text-gray-500 border-gray-300 bg-gray-50' : ($index == 2 ? 'text-amber-700 border-amber-600/30 bg-amber-50/50' : 'text-gray-400 border-surface-border')) }}">
                            #{{ $index + 1 }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $product->name }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Terjual: <span class="text-brand font-semibold">{{ $product->total_sold }}</span> unit</p>
                        </div>
                    </div>
                    @empty
                    <div class="py-8 text-center text-gray-500 text-sm">Belum ada data penjualan</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
