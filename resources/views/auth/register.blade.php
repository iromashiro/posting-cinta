<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#FF9ECD">
    <title>Daftar - {{ config('app.name') }}</title>

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
    <div class="absolute top-10 right-10 text-6xl opacity-20 float-animation">🌟</div>
    <div class="absolute top-40 left-20 text-5xl opacity-20 pulse-soft-animation">✨</div>
    <div class="absolute bottom-20 right-20 text-5xl opacity-20 wiggle-animation">💕</div>
    <div class="absolute bottom-40 left-10 text-6xl opacity-20 float-animation">🎉</div>

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
                <p class="text-lg text-gray-600 font-medium">Yuk, Gabung dengan Kami! 🎉</p>
            </div>

            <!-- Register Card - Super cute -->
            <div class="bg-white rounded-3xl shadow-2xl p-8 border-4 border-pink-200 relative">
                <!-- Decorative corner -->
                <div class="absolute top-0 left-0 text-6xl opacity-10 -mt-3 -ml-3">🌺</div>

                <div class="relative z-10">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2 flex items-center gap-2">
                        <span class="text-3xl">✨</span>
                        Daftar Akun Baru
                    </h2>
                    <p class="text-sm text-gray-600 mb-6">Gratis! Isi formulir di bawah untuk memulai</p>

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

                    <form method="POST" action="{{ route('register') }}" class="space-y-5">
                        @csrf

                        <!-- Nama -->
                        <div>
                            <label for="name" class="form-label">
                                <span class="text-lg">👤</span>
                                Nama Lengkap
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                                class="input-field @error('name') input-error @enderror"
                                placeholder="contoh: Siti Nurhaliza">
                            @error('name')
                            <p class="error-message">
                                <span>⚠️</span>
                                <span>{{ $message }}</span>
                            </p>
                            @enderror
                            <p class="form-helper">
                                <span>💡</span>
                                <span>Tulis nama lengkap sesuai identitas</span>
                            </p>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="form-label">
                                <span class="text-lg">📧</span>
                                Email
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="input-field @error('email') input-error @enderror"
                                placeholder="contoh: siti@email.com">
                            @error('email')
                            <p class="error-message">
                                <span>⚠️</span>
                                <span>{{ $message }}</span>
                            </p>
                            @enderror
                            <p class="form-helper">
                                <span>💡</span>
                                <span>Gunakan email aktif yang bisa dihubungi</span>
                            </p>
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role" class="form-label">
                                <span class="text-lg">🎯</span>
                                Peran / Jabatan
                            </label>
                            <select id="role" name="role" required
                                class="input-field @error('role') input-error @enderror">
                                <option value="">-- Pilih peran kamu --</option>
                                <option value="kader" {{ old('role') == 'kader' ? 'selected' : '' }}>
                                    👥 Kader Posyandu
                                </option>
                                <option value="puskesmas" {{ old('role') == 'puskesmas' ? 'selected' : '' }}>
                                    🏥 Pengelola Puskesmas
                                </option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                    👑 Admin Dinas
                                </option>
                            </select>
                            @error('role')
                            <p class="error-message">
                                <span>⚠️</span>
                                <span>{{ $message }}</span>
                            </p>
                            @enderror
                            <p class="form-helper">
                                <span>💡</span>
                                <span>Pilih sesuai dengan posisi kamu saat ini</span>
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
                                placeholder="Minimal 8 karakter">
                            @error('password')
                            <p class="error-message">
                                <span>⚠️</span>
                                <span>{{ $message }}</span>
                            </p>
                            @enderror
                            <p class="form-helper">
                                <span>💡</span>
                                <span>Buat password yang kuat & mudah diingat</span>
                            </p>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="form-label">
                                <span class="text-lg">🔐</span>
                                Konfirmasi Password
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                class="input-field" placeholder="Ketik ulang password yang sama">
                            <p class="form-helper">
                                <span>💡</span>
                                <span>Pastikan password sama dengan yang di atas</span>
                            </p>
                        </div>

                        <!-- Info Box -->
                        <div class="p-4 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-2xl border-2 border-blue-200">
                            <div class="flex items-start gap-3 text-sm text-gray-700">
                                <span class="text-2xl flex-shrink-0">ℹ️</span>
                                <div>
                                    <p class="font-semibold mb-1">Kenapa harus daftar?</p>
                                    <ul class="space-y-1 text-xs">
                                        <li class="flex items-center gap-1">
                                            <span>✅</span>
                                            <span>Data tersimpan aman di cloud</span>
                                        </li>
                                        <li class="flex items-center gap-1">
                                            <span>✅</span>
                                            <span>Akses dari mana saja</span>
                                        </li>
                                        <li class="flex items-center gap-1">
                                            <span>✅</span>
                                            <span>Pantau tumbuh kembang real-time</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-primary w-full text-lg flex items-center justify-center gap-2">
                            <span>🚀</span>
                            <span>Daftar Sekarang</span>
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

                    <!-- Login Link -->
                    <div
                        class="text-center p-5 bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl border-3 border-purple-200">
                        <p class="text-gray-700 mb-3 font-semibold flex items-center justify-center gap-2">
                            <span class="text-2xl">👋</span>
                            <span>Sudah punya akun?</span>
                        </p>
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-bold rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                            <span>🔑</span>
                            <span>Masuk di Sini</span>
                        </a>
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