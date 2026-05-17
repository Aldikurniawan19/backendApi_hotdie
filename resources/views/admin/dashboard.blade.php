@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card bg-surface-card border border-surface-border rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 bg-brand/15 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-white">{{ $totalProducts }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Produk</p>
        </div>

        <div class="stat-card bg-surface-card border border-surface-border rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 bg-emerald-500/15 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-white">{{ $activeProducts }}</p>
            <p class="text-sm text-gray-500 mt-1">Produk Aktif</p>
        </div>

        <div class="stat-card bg-surface-card border border-surface-border rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 bg-blue-500/15 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-white">{{ $totalUsers }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Users</p>
        </div>

        <div class="stat-card bg-surface-card border border-surface-border rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 bg-amber-500/15 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-white">{{ $lowStock }}</p>
            <p class="text-sm text-gray-500 mt-1">Stok Rendah</p>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-surface-card border border-surface-border rounded-xl p-6">
        <h3 class="text-white font-semibold mb-4">Quick Actions</h3>
        <div class="flex gap-3">
            <a href="{{ route('admin.products.create') }}"
               class="px-4 py-2.5 bg-brand hover:bg-brand-light text-white text-sm font-medium rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Produk
            </a>
            <a href="{{ route('admin.products.index') }}"
               class="px-4 py-2.5 bg-surface-hover hover:bg-surface-border text-gray-300 text-sm font-medium rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                Lihat Produk
            </a>
        </div>
    </div>
@endsection
