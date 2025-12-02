<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#D9536F">
    <title>Daftar - {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-neutral-100">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-500 rounded-xl shadow-lg mb-5">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                        </path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-neutral-800 font-heading mb-1">
                    {{ config('app.name') }}
                </h1>
                <p class="text-neutral-500">Pantau Tumbuh Kembang dengan Cinta</p>
            </div>

            <!-- Register Card -->
            <div class="card card-padding-lg">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-neutral-800 font-heading">
                        Daftar Akun Baru
                    </h2>
                    <p class="text-sm text-neutral-500 mt-1">Isi formulir di bawah untuk membuat akun</p>
                </div>

                @if ($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-red-700 mb-1">Terjadi kesalahan</p>
                            <ul class="text-sm text-red-600 space-y-0.5">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Nama -->
                    <div class="space-y-1.5">
                        <label for="name" class="input-label">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                            class="input-field @error('name') input-error @enderror"
                            placeholder="Masukkan nama lengkap">
                        @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-neutral-500 mt-1">Tulis nama lengkap sesuai identitas</p>
                    </div>

                    <!-- Email -->
                    <div class="space-y-1.5">
                        <label for="email" class="input-label">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="input-field @error('email') input-error @enderror" placeholder="nama@email.com">
                        @error('email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-neutral-500 mt-1">Gunakan email aktif yang bisa dihubungi</p>
                    </div>

                    <!-- Role -->
                    <div class="space-y-1.5">
                        <label for="role" class="input-label">Peran / Jabatan</label>
                        <select id="role" name="role" required class="input-field @error('role') input-error @enderror">
                            <option value="">Pilih peran Anda</option>
                            <option value="kader" {{ old('role')=='kader' ? 'selected' : '' }}>Kader Posyandu</option>
                            <option value="puskesmas" {{ old('role')=='puskesmas' ? 'selected' : '' }}>Pengelola
                                Puskesmas</option>
                            <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin Dinas</option>
                        </select>
                        @error('role')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-neutral-500 mt-1">Pilih sesuai dengan posisi Anda saat ini</p>
                    </div>

                    <!-- Password -->
                    <div class="space-y-1.5">
                        <label for="password" class="input-label">Password</label>
                        <input type="password" id="password" name="password" required
                            class="input-field @error('password') input-error @enderror"
                            placeholder="Minimal 8 karakter">
                        @error('password')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-neutral-500 mt-1">Buat password yang kuat & mudah diingat</p>
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="input-label">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="input-field" placeholder="Ketik ulang password">
                        <p class="text-xs text-neutral-500 mt-1">Pastikan sama dengan password di atas</p>
                    </div>

                    <!-- Info Box -->
                    <div class="p-4 rounded-lg bg-blue-50 border border-blue-200">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-blue-800 mb-1">Keuntungan mendaftar:</p>
                                <ul class="text-xs text-blue-700 space-y-0.5">
                                    <li class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Data tersimpan aman di cloud
                                    </li>
                                    <li class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Akses dari mana saja
                                    </li>
                                    <li class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Pantau tumbuh kembang real-time
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary w-full">
                        Daftar Sekarang
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-neutral-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-3 bg-white text-neutral-400">atau</span>
                    </div>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-sm text-neutral-600 mb-3">Sudah punya akun?</p>
                    <a href="{{ route('login') }}" class="btn-secondary w-full">
                        Masuk di Sini
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-6">
                <p class="text-xs text-neutral-400">
                    © {{ date('Y') }} {{ config('app.name') }} · Dinas Ketahanan Pangan Kab. Muara Enim
                </p>
            </div>
        </div>
    </div>
</body>

</html>