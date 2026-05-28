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
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    colors: {
                        brand: {
                            DEFAULT: '#1E7A5C',
                            light: '#2A9D76',
                            50: '#ECFDF5',
                            100: '#D1FAE5',
                        },
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .login-card {
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.06), 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .login-card:hover {
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.08), 0 2px 6px rgba(0, 0, 0, 0.04);
        }

        .input-field {
            transition: all 0.2s ease;
        }

        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(30, 122, 92, 0.12);
        }

        .btn-login {
            transition: all 0.2s ease;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(30, 122, 92, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .bg-pattern {
            background-image: radial-gradient(circle at 1px 1px, rgba(30, 122, 92, 0.04) 1px, transparent 0);
            background-size: 32px 32px;
        }
    </style>
</head>

<body class="bg-gray-50 bg-pattern min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <div
                class="w-14 h-14 bg-brand rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-brand/20">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Hotdie Admin</h1>
            <p class="text-gray-400 text-sm mt-1">Masuk ke dashboard admin</p>
        </div>

        {{-- Login Card --}}
        <div class="login-card bg-white border border-gray-100 rounded-2xl p-8 transition-shadow duration-300">
            @if (session('error'))
                <div class="mb-6 px-4 py-3 bg-red-50 border border-red-200 text-red-600 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="input-field w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:border-brand focus:bg-white focus:ring-0 text-sm"
                        placeholder="admin@hotdie.com">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Password</label>
                    <input type="password" name="password" required
                        class="input-field w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:border-brand focus:bg-white focus:ring-0 text-sm"
                        placeholder="••••••••">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="btn-login w-full py-3 bg-brand hover:bg-brand-light text-white font-semibold rounded-xl text-sm">
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-gray-400 text-xs mt-6">&copy; {{ date('Y') }} Kelompok 6. All rights reserved.
        </p>
    </div>
</body>

</html>
