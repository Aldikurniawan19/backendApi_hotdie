@extends('admin.layouts.app')
@section('title', 'Edit Kupon')
@section('page-title', 'Edit Kupon')

@section('content')
    <div class="max-w-xl">
        <div class="mb-6">
            <a href="{{ route('admin.coupons.index') }}" class="text-gray-500 hover:text-gray-600 text-sm flex items-center gap-1 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali
            </a>
        </div>
        <form method="POST" action="{{ route('admin.coupons.update', $coupon) }}">
            @csrf @method('PUT')
            <div class="bg-surface-card border border-surface-border rounded-xl p-6 space-y-5">
                <h3 class="text-gray-900 font-semibold text-lg">Edit: {{ $coupon->code }}</h3>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Kode Kupon *</label>
                    <input type="text" name="code" value="{{ old('code', $coupon->code) }}" required class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 focus:outline-none focus:border-brand text-sm font-mono uppercase">
                    @error('code') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Tipe Diskon *</label>
                        <select name="discount_type" class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 focus:outline-none focus:border-brand text-sm">
                            <option value="percentage" {{ old('discount_type', $coupon->discount_type) === 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                            <option value="fixed" {{ old('discount_type', $coupon->discount_type) === 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Nilai Diskon *</label>
                        <input type="number" name="discount_value" value="{{ old('discount_value', $coupon->discount_value) }}" required min="0" step="0.01" class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 focus:outline-none focus:border-brand text-sm">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Min. Pembelian (Rp)</label>
                        <input type="number" name="min_purchase" value="{{ old('min_purchase', $coupon->min_purchase) }}" min="0" class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 focus:outline-none focus:border-brand text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">Berlaku Sampai</label>
                        <input type="date" name="expires_at" value="{{ old('expires_at', $coupon->expires_at?->format('Y-m-d')) }}" class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 focus:outline-none focus:border-brand text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 mb-2">Deskripsi</label>
                    <input type="text" name="description" value="{{ old('description', $coupon->description) }}" class="w-full px-4 py-2.5 bg-surface border border-surface-border rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:border-brand text-sm">
                </div>
                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ $coupon->is_active ? 'checked' : '' }} class="w-4 h-4 rounded border-surface-border bg-surface text-brand focus:ring-brand">
                    <label for="is_active" class="text-sm text-gray-500">Aktif</label>
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <button type="submit" class="px-6 py-2.5 bg-brand hover:bg-brand-light text-white text-sm font-medium rounded-lg transition">Update</button>
                <a href="{{ route('admin.coupons.index') }}" class="px-6 py-2.5 bg-surface-hover hover:bg-surface-border text-gray-500 text-sm font-medium rounded-lg transition">Batal</a>
            </div>
        </form>
    </div>
@endsection
