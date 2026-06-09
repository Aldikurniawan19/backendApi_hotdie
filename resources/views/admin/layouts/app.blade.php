<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - W3Cart Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: { DEFAULT: '#1E7A5C', light: '#2A9D76', dark: '#16644A' },
                        surface: { DEFAULT: '#F3F4F6', card: '#FFFFFF', hover: '#F9FAFB', border: '#E5E7EB' },
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link { transition: all 0.2s ease; border-right: 3px solid transparent; }
        .sidebar-link:hover { background: rgba(30, 122, 92, 0.08); color: #2A9D76; }
        .sidebar-link.active { background: rgba(30, 122, 92, 0.1); color: #1E7A5C; border-right-color: #1E7A5C; }
        .stat-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        /* Hide scrollbar */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-surface text-gray-800 min-h-screen">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-surface-card border-r border-surface-border flex flex-col fixed h-full z-10">
            {{-- Logo --}}
            <div class="p-6 border-b border-surface-border">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-brand rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                            <line x1="12" y1="22.08" x2="12" y2="12"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-brand font-bold text-lg leading-none">W3Cart</h1>
                        <p class="text-gray-500 text-xs mt-0.5">Admin Panel</p>
                    </div>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 py-4 overflow-y-auto no-scrollbar">
                <p class="px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Menu</p>

                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link flex items-center gap-3 px-6 py-2.5 text-sm {{ request()->routeIs('admin.dashboard') ? 'active text-brand' : 'text-gray-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Dashboard
                </a>

                <p class="px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-5 mb-3">Catalog</p>

                <a href="{{ route('admin.products.index') }}"
                   class="sidebar-link flex items-center gap-3 px-6 py-2.5 text-sm {{ request()->routeIs('admin.products.*') ? 'active text-brand' : 'text-gray-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Products
                </a>

                <a href="{{ route('admin.categories.index') }}"
                   class="sidebar-link flex items-center gap-3 px-6 py-2.5 text-sm {{ request()->routeIs('admin.categories.*') ? 'active text-brand' : 'text-gray-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Categories
                </a>

                <a href="{{ route('admin.banners.index') }}"
                   class="sidebar-link flex items-center gap-3 px-6 py-2.5 text-sm {{ request()->routeIs('admin.banners.*') ? 'active text-brand' : 'text-gray-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Banners
                </a>

                <p class="px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-5 mb-3">Commerce</p>

                <a href="{{ route('admin.orders.index') }}"
                   class="sidebar-link flex items-center gap-3 px-6 py-2.5 text-sm {{ request()->routeIs('admin.orders.*') ? 'active text-brand' : 'text-gray-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    Orders
                </a>

                <a href="{{ route('admin.coupons.index') }}"
                   class="sidebar-link flex items-center gap-3 px-6 py-2.5 text-sm {{ request()->routeIs('admin.coupons.*') ? 'active text-brand' : 'text-gray-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                    Coupons
                </a>

                <p class="px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider mt-5 mb-3">System</p>

                <a href="{{ route('admin.users.index') }}"
                   class="sidebar-link flex items-center gap-3 px-6 py-2.5 text-sm {{ request()->routeIs('admin.users.*') ? 'active text-brand' : 'text-gray-600' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Users
                </a>
            </nav>

            {{-- User --}}
            <div class="p-4 border-t border-surface-border">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-brand/20 text-brand rounded-full flex items-center justify-center text-sm font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">Admin</p>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-500 hover:text-red-400 transition" title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 ml-64">
            {{-- Topbar --}}
            <header class="h-16 border-b border-surface-border flex items-center justify-between px-8 bg-surface-card/50 backdrop-blur-sm sticky top-0 z-[5]">
                <h2 class="text-lg font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h2>
                <div class="text-sm text-gray-500">{{ now()->format('l, d M Y') }}</div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mx-8 mt-6 px-4 py-3 bg-green-500/10 border border-green-500/20 text-green-400 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mx-8 mt-6 px-4 py-3 bg-red-500/10 border border-red-500/20 text-red-400 rounded-lg text-sm flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Page Content --}}
            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
