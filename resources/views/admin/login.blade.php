<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hotdie Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: { DEFAULT: '#1E7A5C', light: '#2A9D76' },
                        surface: { DEFAULT: '#0F1117', card: '#1A1D2E', border: '#2A2D3E' },
                    }
                }
            }
        }
    </script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-surface min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="w-14 h-14 bg-brand rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">Hotdie Admin</h1>
            <p class="text-gray-500 text-sm mt-1">Masuk ke dashboard admin</p>
        </div>

        {{-- Login Card --}}
        <div class="bg-surface-card border border-surface-border rounded-2xl p-8">
            @if(session('error'))
                <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/20 text-red-400 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-3 bg-surface border border-surface-border rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition text-sm"
                           placeholder="admin@hotdie.com">
                    @error('email')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-400 mb-2">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 bg-surface border border-surface-border rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition text-sm"
                           placeholder="••••••••">
                    @error('password')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full py-3 bg-brand hover:bg-brand-light text-white font-semibold rounded-xl transition text-sm">
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-gray-600 text-xs mt-6">&copy; {{ date('Y') }} Hotdie. All rights reserved.</p>
    </div>
</body>
</html>
