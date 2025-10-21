<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#FF9ECD">
    <title>Masuk - {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-pink-100 via-purple-100 to-blue-100 relative overflow-hidden">
    <!-- Decorative floating elements -->
    <div class="absolute top-10 left-10 text-6xl opacity-20 float-animation">💕</div>
    <div class="absolute top-40 right-20 text-5xl opacity-20 pulse-soft-animation">✨</div>
    <div class="absolute bottom-20 left-20 text-5xl opacity-20 wiggle-animation">🌟</div>
    <div class="absolute bottom-40 right-10 text-6xl opacity-20 float-animation">💖</div>

    <div class="min-h-screen flex items-center justify-center px-4 py-12 relative z-10">
        <div class="w-full max-w-md">
            <!-- Logo & Header - Lebih cute -->
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-pink-400 via-purple-400 to-pink-500 rounded-3xl shadow-2xl mb-6 float-animation">
                    <span class="text-5xl">💕</span>
                </div>
                <h1 class="text-4xl font-bold text-gray-800 mb-3 flex items-center justify-center gap-2">
                    {{ config('app.name') }}
                </h1>
                <p class="text-lg text-gray-600 font-medium">Pantau Tumbuh Kembang dengan Cinta 💖</p>
            </div>

            <!-- Login Card - Super cute -->
            <div class="bg-white rounded-3xl shadow-2xl p-8 border-4 border-pink-200 relative">
                <!-- Decorative corner -->
                <div class="absolute top-0 right-0 text-6xl opacity-10 -mt-3 -mr-3">🌸</div>

                <div class="relative z-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2 flex items-center gap-2">
                        <span class="text-3xl">👋</span>
                        Hai! Selamat Datang Kembali
                    </h2>
                    <p class="text-sm text-gray-600 mb-6">Masuk ke akunmu untuk melanjutkan</p>

                    @if (session('success'))
                    <div
                        class="mb-6 p-5 rounded-2xl bg-gradient-to-r from-green-50 to-emerald-50 border-3 border-green-300 flex items-start gap-3 shadow-lg">
                        <span class="text-3xl">✅</span>
                        <div class="flex-1 text-green-800 font-semibold">{{ session('success') }}</div>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div
                        class="mb-6 p-5 rounded-2xl bg-gradient-to-r from-red-50 to-rose-50 border-3 border-red-300 shadow-lg">
                        <div class="flex items-start gap-3 mb-3">
                            <span class="text-3xl">⚠️</span>
                            <div class="font-bold text-red-800 text-lg">Ups! Ada yang perlu diperbaiki:</div>
                        </div>
                        <ul class="text-sm space-y-1 ml-12">
                            @foreach ($errors->all() as $error)
                            <li class="flex items-start gap-2 text-red-700">
                                <span class="text-red-500">•</span>
                                <span>{{ $error }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="form-label">
                                <span class="text-lg">📧</span>
                                Email
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                class="input-field @error('email') input-error @enderror"
                                placeholder="contoh: nama@email.com">
                            @error('email')
                            <p class="error-message">
                                <span>⚠️</span>
                                <span>{{ $message }}</span>
                            </p>
                            @enderror
                            <p class="form-helper">
                                <span>💡</span>
                                <span>Masukkan email yang sudah terdaftar</span>
                            </p>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="form-label">
                                <span class="text-lg">🔒</span>
                                Password
                            </label>
                            <input type="password" id="password" name="password" required
                                class="input-field @error('password') input-error @enderror"
                                placeholder="Masukkan password kamu">
                            @error('password')
                            <p class="error-message">
                                <span>⚠️</span>
                                <span>{{ $message }}</span>
                            </p>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div
                            class="flex items-center gap-3 p-4 bg-gradient-to-r from-pink-50 to-purple-50 rounded-2xl border-2 border-pink-200">
                            <input type="checkbox" id="remember" name="remember"
                                class="w-5 h-5 rounded-lg border-2 border-pink-300 text-pink-500 focus:ring-pink-400 focus:ring-4">
                            <label for="remember" class="text-sm font-semibold text-gray-700 flex items-center gap-2">
                                <span>💾</span>
                                <span>Ingat saya di perangkat ini</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-primary w-full text-lg flex items-center justify-center gap-2">
                            <span>🚀</span>
                            <span>Masuk Sekarang</span>
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t-2 border-pink-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500 font-medium">atau</span>
                        </div>
                    </div>

                    <!-- Register Link -->
                    <div
                        class="text-center p-5 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-2xl border-3 border-blue-200">
                        <p class="text-gray-700 mb-3 font-semibold flex items-center justify-center gap-2">
                            <span class="text-2xl">✨</span>
                            <span>Belum punya akun?</span>
                        </p>
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-bold rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                            <span>➕</span>
                            <span>Daftar Gratis Sekarang</span>
                        </a>
                        <p class="text-xs text-gray-600 mt-3">Gratis, mudah, & aman! 🔒</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8 space-y-2">
                <p class="text-sm text-gray-600 font-medium flex items-center justify-center gap-2">
                    <span>Made with</span>
                    <span class="text-red-500 text-xl">❤️</span>
                    <span>© {{ date('Y') }}</span>
                </p>
                <p class="text-xs text-gray-500">{{ config('app.name') }} - Dinas Ketahanan Pangan Kab. Muara Enim</p>
            </div>
        </div>
    </div>
</body>

</html>