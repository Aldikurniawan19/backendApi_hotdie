<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Hotdie Admin</title>
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
                        surface: { DEFAULT: '#0F1117', card: '#1A1D2E', hover: '#252840', border: '#2A2D3E' },
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link { transition: all 0.15s ease; }
        .sidebar-link:hover, .sidebar-link.active { background: rgba(30, 122, 92, 0.15); color: #2A9D76; }
        .sidebar-link.active { border-right: 3px solid #1E7A5C; }
        .stat-card { transition: transform 0.15s ease, box-shadow 0.15s ease; }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,0.3); }
        .table-row { transition: background 0.1s ease; }
        .table-row:hover { background: #1A1D2E; }
    </style>
</head>
<body class="bg-surface text-gray-200 min-h-screen">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-surface-card border-r border-surface-border flex flex-col fixed h-full z-10">
            {{-- Logo --}}
            <div class="p-6 border-b border-surface-border">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-brand rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg leading-none">Hotdie</h1>
                        <p class="text-gray-500 text-xs mt-0.5">Admin Panel</p>
                    </div>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 py-4">
                <p class="px-6 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Menu</p>

                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link flex items-center gap-3 px-6 py-2.5 text-sm {{ request()->routeIs('admin.dashboard') ? 'active text-brand' : 'text-gray-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.products.index') }}"
                   class="sidebar-link flex items-center gap-3 px-6 py-2.5 text-sm {{ request()->routeIs('admin.products.*') ? 'active text-brand' : 'text-gray-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Products
                </a>
            </nav>

            {{-- User --}}
            <div class="p-4 border-t border-surface-border">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-brand/20 text-brand rounded-full flex items-center justify-center text-sm font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
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
                <h2 class="text-lg font-semibold text-white">@yield('page-title', 'Dashboard')</h2>
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
