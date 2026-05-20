@extends('admin.layouts.app')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')
    {{-- Toast Notification --}}
    @if(session('success'))
        <div id="toast" class="fixed top-6 right-6 z-50 flex items-center gap-3 px-5 py-4 bg-surface-card border border-emerald-500/30 rounded-xl shadow-2xl shadow-black/30 animate-slide-in">
            <div class="w-8 h-8 bg-emerald-500/15 rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <p class="text-gray-900 text-sm font-medium">Berhasil!</p>
                <p class="text-gray-500 text-xs mt-0.5">{{ session('success') }}</p>
            </div>
            <button onclick="closeToast()" class="ml-4 text-gray-500 hover:text-gray-600 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    <div id="delete-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative bg-surface-card border border-surface-border rounded-2xl p-6 w-full max-w-sm shadow-2xl shadow-black/50 animate-modal-in">
                <div class="text-center">
                    <div class="w-14 h-14 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                    <h3 class="text-gray-900 font-semibold text-lg">Hapus Produk</h3>
                    <p class="text-gray-500 text-sm mt-2">Apakah Anda yakin ingin menghapus<br><span id="delete-product-name" class="text-gray-900 font-medium"></span>?</p>
                    <p class="text-gray-500 text-xs mt-1">Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="flex gap-3 mt-6">
                    <button onclick="closeDeleteModal()"
                            class="flex-1 px-4 py-2.5 bg-surface-hover hover:bg-surface-border text-gray-500 text-sm font-medium rounded-xl transition">
                        Batal
                    </button>
                    <form id="delete-form" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-xl transition">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-gray-500 text-sm">Kelola semua produk toko</p>
        </div>
        <a href="{{ route('admin.products.create') }}"
           class="px-4 py-2.5 bg-brand hover:bg-brand-light text-white text-sm font-medium rounded-lg transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Produk
        </a>
    </div>

    {{-- Search --}}
    <div class="mb-6 flex items-center gap-4">
        <div class="relative max-w-md flex-1">
            <svg class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" id="live-search" placeholder="Cari produk..." autocomplete="off"
                   class="w-full pl-10 pr-10 py-2.5 bg-surface-card border border-surface-border rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:border-brand text-sm">
            <button id="clear-search" class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-600 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <span id="search-count" class="text-gray-500 text-sm hidden"></span>
    </div>

    {{-- Table --}}
    <div class="bg-surface-card border border-surface-border rounded-xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-surface-border">
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Stok</th>
                    <th class="text-center px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody id="product-tbody">
                @forelse($products as $product)
                    <tr class="table-row border-b border-surface-border/50 product-row" data-name="{{ strtolower($product->name) }}" data-category="{{ strtolower($product->category) }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="" class="w-10 h-10 rounded-lg object-cover bg-surface">
                                @else
                                    <div class="w-10 h-10 bg-surface rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-gray-900 font-medium text-sm">{{ $product->name }}</p>
                                    <p class="text-gray-500 text-xs mt-0.5">ID: {{ $product->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 bg-surface rounded-md text-xs text-gray-500">{{ $product->category }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <p class="text-gray-900 text-sm font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm {{ $product->stock < 10 ? 'text-amber-400' : 'text-gray-600' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($product->is_active)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-500/10 text-emerald-400 rounded-full text-xs font-medium">
                                    <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-500/10 text-gray-500 rounded-full text-xs font-medium">
                                    <span class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-100 rounded-lg transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <button onclick="openDeleteModal('{{ route('admin.products.destroy', $product) }}', '{{ $product->name }}')"
                                        class="p-2 text-red-600 hover:text-red-800 hover:bg-red-100 rounded-lg transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <p class="text-gray-500 text-sm">Belum ada produk</p>
                            <a href="{{ route('admin.products.create') }}" class="text-brand text-sm mt-2 inline-block hover:underline">+ Tambah produk pertama</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="px-6 py-4 border-t border-surface-border">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    <style>
        /* Center Tailwind Pagination */
        nav[role="navigation"] {
            display: flex;
            justify-content: center;
            width: 100%;
        }
        nav[role="navigation"] > div.hidden.sm\:flex-1 {
            justify-content: center !important;
            flex: none !important;
        }
        nav[role="navigation"] p.text-sm.text-gray-700 {
            display: none !important;
        }

        @keyframes slideIn {
            from { transform: translateX(120%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(120%); opacity: 0; }
        }
        @keyframes modalIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        .animate-slide-in { animation: slideIn 0.35s cubic-bezier(0.21, 1.02, 0.73, 1) forwards; }
        .animate-slide-out { animation: slideOut 0.25s ease-in forwards; }
        .animate-modal-in { animation: modalIn 0.2s ease-out forwards; }
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
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                        <p class="text-gray-500 text-sm">Tidak ada produk yang cocok dengan "<span class="text-gray-700">${query}</span>"</p>
                                    </td>
                                </tr>`;
                        } else {
                            tbody.innerHTML = products.map(p => `
                                <tr class="table-row border-b border-surface-border/50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            ${p.image_url
                                                ? `<img src="${p.image_url}" alt="" class="w-10 h-10 rounded-lg object-cover bg-surface">`
                                                : `<div class="w-10 h-10 bg-surface rounded-lg flex items-center justify-center"><svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>`
                                            }
                                            <div>
                                                <p class="text-gray-900 font-medium text-sm">${p.name}</p>
                                                <p class="text-gray-500 text-xs mt-0.5">ID: ${p.id}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 bg-surface rounded-md text-xs text-gray-500">${p.category}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <p class="text-gray-900 text-sm font-medium">Rp ${Number(p.price).toLocaleString('id-ID')}</p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm ${p.stock < 10 ? 'text-amber-400' : 'text-gray-600'}">${p.stock}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        ${p.is_active
                                            ? '<span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-500/10 text-emerald-400 rounded-full text-xs font-medium"><span class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></span>Aktif</span>'
                                            : '<span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-500/10 text-gray-500 rounded-full text-xs font-medium"><span class="w-1.5 h-1.5 bg-gray-500 rounded-full"></span>Nonaktif</span>'
                                        }
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="/admin/products/${p.id}/edit" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-100 rounded-lg transition" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                            <button onclick="openDeleteModal('/admin/products/${p.id}', '${p.name}')" class="p-2 text-red-600 hover:text-red-800 hover:bg-red-100 rounded-lg transition" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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
