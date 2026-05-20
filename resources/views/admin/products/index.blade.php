@extends('admin.layouts.app')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')
    {{-- Toast Notification --}}
    @if(session('success'))
        <div id="toast" class="fixed top-6 right-6 z-50 flex items-center gap-3 px-5 py-4 bg-white border border-emerald-200 rounded-2xl shadow-lg shadow-emerald-500/10 animate-slide-in">
            <div class="w-9 h-9 bg-emerald-50 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <p class="text-gray-800 text-sm font-semibold">Berhasil!</p>
                <p class="text-gray-500 text-xs mt-0.5">{{ session('success') }}</p>
            </div>
            <button onclick="closeToast()" class="ml-4 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    <div id="delete-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" onclick="closeDeleteModal()"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-white rounded-2xl p-8 w-full max-w-sm shadow-2xl shadow-gray-900/10 animate-modal-in">
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                    <h3 class="text-gray-900 font-bold text-lg">Hapus Produk</h3>
                    <p class="text-gray-500 text-sm mt-2 leading-relaxed">Apakah Anda yakin ingin menghapus<br><span id="delete-product-name" class="text-gray-800 font-semibold"></span>?</p>
                    <p class="text-gray-400 text-xs mt-1.5">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="flex gap-3 mt-7">
                    <button onclick="closeDeleteModal()"
                            class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium rounded-xl transition-colors">
                        Batal
                    </button>
                    <form id="delete-form" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-xl transition-colors shadow-sm shadow-red-500/25">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="text-gray-400 text-sm mt-1">Kelola semua produk toko Anda</p>
        </div>
        <a href="{{ route('admin.products.create') }}"
           class="group px-5 py-2.5 bg-brand hover:bg-brand-light text-white text-sm font-semibold rounded-xl transition-all duration-200 flex items-center gap-2 shadow-sm shadow-brand/25 hover:shadow-md hover:shadow-brand/30">
            <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Produk
        </a>
    </div>

    {{-- Search & Filter Bar --}}
    <div class="mb-6 flex items-center gap-4">
        <div class="relative max-w-sm flex-1">
            <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" id="live-search" placeholder="Cari produk..." autocomplete="off"
                   class="w-full pl-10 pr-10 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 text-sm transition-all duration-200">
            <button id="clear-search" class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors p-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <span id="search-count" class="text-gray-400 text-xs font-medium hidden"></span>
        <div class="ml-auto text-xs text-gray-400 font-medium">
            {{ $products->total() ?? $products->count() }} produk total
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white border border-gray-200/80 rounded-2xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full" id="product-table">
                <thead>
                    <tr class="bg-gray-50/80">
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="text-right px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="text-center px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="text-center px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="text-right px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody id="product-tbody" class="divide-y divide-gray-100">
                    @forelse($products as $product)
                        <tr class="product-row group hover:bg-gray-50/60 transition-colors duration-150" data-name="{{ strtolower($product->name) }}" data-category="{{ strtolower($product->category) }}">
                            {{-- Product Info --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3.5">
                                    @if($product->image_url)
                                        <div class="w-11 h-11 rounded-xl overflow-hidden flex-shrink-0 ring-1 ring-gray-200/80">
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="w-11 h-11 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="text-gray-800 font-semibold text-sm truncate max-w-[200px]">{{ $product->name }}</p>
                                        <p class="text-gray-400 text-xs mt-0.5 font-mono">#{{ $product->id }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Category --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 bg-brand/8 text-brand rounded-lg text-xs font-medium">
                                    {{ $product->category }}
                                </span>
                            </td>

                            {{-- Price --}}
                            <td class="px-6 py-4 text-right">
                                <span class="text-gray-800 text-sm font-semibold tabular-nums">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </td>

                            {{-- Stock --}}
                            <td class="px-6 py-4 text-center">
                                @if($product->stock == 0)
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-500">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                        Habis
                                    </span>
                                @elseif($product->stock < 10)
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-500">
                                        <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span>
                                        {{ $product->stock }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-600 font-medium tabular-nums">{{ $product->stock }}</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4 text-center">
                                @if($product->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-100 text-gray-500 rounded-lg text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>Nonaktif
                                    </span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-150" title="Edit">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <button onclick="openDeleteModal('{{ route('admin.products.destroy', $product) }}', '{{ $product->name }}')"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-500 hover:bg-red-50 rounded-lg transition-colors duration-150" title="Hapus">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 text-sm font-medium">Belum ada produk</p>
                                    <p class="text-gray-400 text-xs mt-1">Mulai tambahkan produk ke toko Anda</p>
                                    <a href="{{ route('admin.products.create') }}" class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 bg-brand hover:bg-brand-light text-white text-xs font-semibold rounded-lg transition-colors shadow-sm shadow-brand/20">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                        Tambah Produk
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    <style>
        /* Pagination Layout */
        nav[role="navigation"] {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        nav[role="navigation"] > div.hidden.sm\:flex-1 {
            justify-content: center !important;
            flex: none !important;
        }
        nav[role="navigation"] p.text-sm.text-gray-700 {
            display: none !important;
        }

        /* Pagination Buttons Spacing */
        nav[role="navigation"] span.relative.z-0 {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        nav[role="navigation"] span.relative.z-0 > a,
        nav[role="navigation"] span.relative.z-0 > span {
            border-radius: 8px !important;
            min-width: 36px;
            height: 36px;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 500;
            border: 1px solid #e5e7eb !important;
            background: white !important;
            color: #374151 !important;
            transition: all 0.15s ease;
        }
        /* Active page */
        nav[role="navigation"] span.relative.z-0 > span[aria-current="page"] > span {
            background: #1E7A5C !important;
            color: white !important;
            border-color: #1E7A5C !important;
            border-radius: 8px !important;
            min-width: 36px;
            height: 36px;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
        }
        /* Hover state */
        nav[role="navigation"] span.relative.z-0 > a:hover {
            background: #f3f4f6 !important;
            border-color: #d1d5db !important;
        }
        /* Previous button - margin kanan */
        nav[role="navigation"] span.relative.z-0 > a:first-child,
        nav[role="navigation"] span.relative.z-0 > span:first-child {
            margin-right: 8px !important;
            padding-left: 12px !important;
            padding-right: 12px !important;
        }
        /* Next button - margin kiri */
        nav[role="navigation"] span.relative.z-0 > a:last-child,
        nav[role="navigation"] span.relative.z-0 > span:last-child {
            margin-left: 8px !important;
            padding-left: 12px !important;
            padding-right: 12px !important;
        }
        /* Disabled state */
        nav[role="navigation"] span.relative.z-0 > span[aria-disabled="true"] > span {
            color: #d1d5db !important;
            cursor: not-allowed;
            background: #f9fafb !important;
        }
        /* Remove default ring/shadow */
        nav[role="navigation"] span.relative.z-0 > a:focus,
        nav[role="navigation"] span.relative.z-0 > span:focus {
            box-shadow: none !important;
            outline: none !important;
        }

        /* Animations */
        @keyframes slideIn {
            from { transform: translateX(120%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(120%); opacity: 0; }
        }
        @keyframes modalIn {
            from { transform: scale(0.95) translateY(10px); opacity: 0; }
            to { transform: scale(1) translateY(0); opacity: 1; }
        }
        .animate-slide-in { animation: slideIn 0.4s cubic-bezier(0.21, 1.02, 0.73, 1) forwards; }
        .animate-slide-out { animation: slideOut 0.25s ease-in forwards; }
        .animate-modal-in { animation: modalIn 0.25s ease-out forwards; }

        /* Tabular numbers for price alignment */
        .tabular-nums { font-variant-numeric: tabular-nums; }

        /* Custom brand opacity utility */
        .bg-brand\/8 { background-color: rgba(30, 122, 92, 0.08); }
    </style>

    <script>
        // Toast auto-dismiss
        const toast = document.getElementById('toast');
        if (toast) {
            setTimeout(() => closeToast(), 4000);
        }

        function closeToast() {
            const t = document.getElementById('toast');
            if (t) {
                t.classList.remove('animate-slide-in');
                t.classList.add('animate-slide-out');
                setTimeout(() => t.remove(), 300);
            }
        }

        // Delete modal
        function openDeleteModal(action, name) {
            document.getElementById('delete-form').action = action;
            document.getElementById('delete-product-name').textContent = name;
            document.getElementById('delete-modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDeleteModal();
        });

        // AJAX Live Search
        const searchInput = document.getElementById('live-search');
        const clearBtn = document.getElementById('clear-search');
        const searchCount = document.getElementById('search-count');
        const tbody = document.getElementById('product-tbody');
        let debounceTimer;
        let originalContent = tbody.innerHTML;

        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            const query = this.value.trim();

            clearBtn.classList.toggle('hidden', !query);

            if (!query) {
                tbody.innerHTML = originalContent;
                searchCount.classList.add('hidden');
                return;
            }

            debounceTimer = setTimeout(() => {
                fetch('{{ route("admin.products.search") }}?q=' + encodeURIComponent(query))
                    .then(res => res.json())
                    .then(products => {
                        if (products.length === 0) {
                            tbody.innerHTML = `
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mb-3">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 text-sm">Tidak ada produk yang cocok dengan "<span class="text-gray-700 font-medium">${query}</span>"</p>
                                        </div>
                                    </td>
                                </tr>`;
                        } else {
                            tbody.innerHTML = products.map(p => `
                                <tr class="group hover:bg-gray-50/60 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3.5">
                                            ${p.image_url
                                                ? `<div class="w-11 h-11 rounded-xl overflow-hidden flex-shrink-0 ring-1 ring-gray-200/80"><img src="${p.image_url}" alt="" class="w-full h-full object-cover"></div>`
                                                : `<div class="w-11 h-11 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0"><svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>`
                                            }
                                            <div class="min-w-0">
                                                <p class="text-gray-800 font-semibold text-sm truncate max-w-[200px]">${p.name}</p>
                                                <p class="text-gray-400 text-xs mt-0.5 font-mono">#${p.id}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 bg-brand/8 text-brand rounded-lg text-xs font-medium">${p.category}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-gray-800 text-sm font-semibold tabular-nums">Rp ${Number(p.price).toLocaleString('id-ID')}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        ${p.stock == 0
                                            ? '<span class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-500"><span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>Habis</span>'
                                            : p.stock < 10
                                                ? `<span class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-500"><span class="w-1.5 h-1.5 bg-amber-400 rounded-full"></span>${p.stock}</span>`
                                                : `<span class="text-sm text-gray-600 font-medium tabular-nums">${p.stock}</span>`
                                        }
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        ${p.is_active
                                            ? '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-semibold"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Aktif</span>'
                                            : '<span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-100 text-gray-500 rounded-lg text-xs font-semibold"><span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>Nonaktif</span>'
                                        }
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <a href="/admin/products/${p.id}/edit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-150" title="Edit">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                Edit
                                            </a>
                                            <button onclick="openDeleteModal('/admin/products/${p.id}', '${p.name}')" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-500 hover:bg-red-50 rounded-lg transition-colors duration-150" title="Hapus">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `).join('');
                        }
                        searchCount.textContent = products.length + ' produk ditemukan';
                        searchCount.classList.remove('hidden');
                    });
            }, 300);
        });

        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            searchInput.focus();
            tbody.innerHTML = originalContent;
            clearBtn.classList.add('hidden');
            searchCount.classList.add('hidden');
        });
    </script>
@endsection
