<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#FF6B8A">
    <title>Masuk - {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-girly relative overflow-hidden">
    <!-- 🌸 Decorative Background Elements -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="decorative-blob w-96 h-96 bg-primary-200 top-0 -right-48 animate-float"></div>
        <div class="decorative-blob w-80 h-80 bg-accent-200 bottom-20 -left-40" style="animation-delay: 2s;"></div>
        <div class="decorative-blob w-64 h-64 bg-secondary-200 top-1/3 right-1/4" style="animation-delay: 4s;"></div>
        <div class="decorative-blob w-48 h-48 bg-warm-200 bottom-1/4 right-10" style="animation-delay: 3s;"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center px-4 py-12 relative z-10">
        <div class="w-full max-w-md">
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 bg-gradient-primary rounded-3xl shadow-soft-lg mb-6 animate-float">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                        </path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-neutral-800 font-heading mb-2">
                    {{ config('app.name') }} 💕
                </h1>
                <p class="text-neutral-500 font-medium">Pantau Tumbuh Kembang dengan Cinta ✨</p>
            </div>

            <!-- Login Card -->
            <div class="card-cute p-8">
                <div class="mb-6 text-center">
                    <h2 class="text-xl font-bold text-neutral-800 font-heading">
                        Selamat Datang Kembali! 👋
                    </h2>
                    <p class="text-sm text-neutral-500 mt-2">Masuk ke akun Anda untuk melanjutkan</p>
                </div>

                @if (session('success'))
                <div
                    class="mb-6 p-4 rounded-2xl bg-gradient-to-r from-secondary-50 to-secondary-100 border-2 border-secondary-200">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-secondary-200 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-secondary-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-sm text-secondary-700 font-semibold">{{ session('success') }} ✨</p>
                    </div>
                </div>
                @endif

                @if ($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-gradient-to-r from-red-50 to-warm-50 border-2 border-red-200">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-red-600 mb-1">Oops! Terjadi kesalahan 💫</p>
                            <ul class="text-sm text-red-500 space-y-0.5">
                                @foreach ($errors->all() as $error)
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-red-400 rounded-full"></span>
                                    {{ $error }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="input-label flex items-center gap-2">
                            <span>📧</span> Email
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            class="input-field @error('email') input-error @enderror" placeholder="nama@email.com">
                        @error('email')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="input-label flex items-center gap-2">
                            <span>🔒</span> Password
                        </label>
                        <input type="password" id="password" name="password" required
                            class="input-field @error('password') input-error @enderror"
                            placeholder="Masukkan password">
                        @error('password')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="remember" name="remember"
                            class="w-5 h-5 rounded-lg border-2 border-primary-200 text-primary-500 focus:ring-primary-200">
                        <label for="remember" class="text-sm text-neutral-600 font-medium">
                            Ingat saya di perangkat ini 💝
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary w-full text-lg">
                        <span>Masuk</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <div class="flex items-center justify-center gap-2 text-neutral-500 font-medium mb-2">
                    <span>Made with</span>
                    <svg class="w-5 h-5 text-primary-400 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                    <span>di Muara Enim</span>
                </div>
                <p class="text-xs text-neutral-400">
                    © {{ date('Y') }} {{ config('app.name') }} · Dinas Ketahanan Pangan 💕
                </p>
            </div>
        </div>
    </div>
</body>

</html>