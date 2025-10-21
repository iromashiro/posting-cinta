<!DOCTYPE html>
<html lang="id" x-data="{
    sidebar: false,
    online: navigator.onLine,
    showInstallPrompt: false,
    deferredPrompt: null
}" x-init="
    window.addEventListener('online', () => online = true);
    window.addEventListener('offline', () => online = false);

    // PWA Install Prompt
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        showInstallPrompt = true;
    });

    // Service Worker Registration
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/service-worker.js').catch(console.error);
        });
    }
">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#FF9ECD">
    <meta name="description" content="Pantau Tumbuh Kembang Anak dengan Cinta 💕">
    <link rel="manifest" href="/manifest.webmanifest">
    <link rel="icon" href="/icons/icon-192x192.png" type="image/png">
    <title>{{ $title ?? $header ?? config('app.name') }}</title>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-pink-50 via-purple-50 to-blue-50 pb-24 lg:pb-8">

    <!-- PWA Install Banner - Lebih cute -->
    <div x-show="showInstallPrompt" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-full" x-transition:enter-end="opacity-100 translate-y-0"
        class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-pink-400 via-purple-400 to-pink-400 text-white p-4 shadow-2xl">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="text-4xl">📱</div>
                <div>
                    <div class="font-bold text-lg">Yuk, Install Aplikasi! ✨</div>
                    <div class="text-sm text-pink-100">Akses lebih mudah & bisa offline 💕</div>
                </div>
            </div>
            <div class="flex gap-2">
                <button @click="
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then(() => {
                        deferredPrompt = null;
                        showInstallPrompt = false;
                    });
                "
                    class="px-5 py-2.5 bg-white text-pink-600 rounded-full font-bold text-sm hover:bg-pink-50 transition-all shadow-lg">
                    Install Sekarang 🎉
                </button>
                <button @click="showInstallPrompt = false"
                    class="px-3 py-2 text-white hover:bg-white/20 rounded-full transition-colors">
                    ✕
                </button>
            </div>
        </div>
    </div>

    <!-- Offline Banner - Lebih friendly -->
    <div x-show="!online" x-transition
        class="fixed top-0 left-0 right-0 z-40 bg-gradient-to-r from-amber-300 to-orange-300 text-amber-900 text-sm py-3 px-4 text-center font-medium shadow-lg">
        <div class="flex items-center justify-center gap-2">
            <span class="text-xl">📡</span>
            <span>Mode Offline - Data akan tersinkron otomatis saat online kembali ya 🙏</span>
        </div>
    </div>

    <!-- Top Header - Lebih cute & colorful -->
    <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-xl border-b-4 border-pink-200 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 h-20 flex items-center justify-between">
            <!-- Left: Menu & Logo -->
            <div class="flex items-center gap-3">
                <button @click="sidebar = !sidebar"
                    class="lg:hidden p-3 rounded-2xl bg-gradient-to-br from-pink-100 to-purple-100 hover:from-pink-200 hover:to-purple-200 active:scale-95 transition-all"
                    aria-label="Toggle menu">
                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-pink-400 via-purple-400 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                        <span class="text-2xl">💕</span>
                    </div>
                    <div class="hidden sm:block">
                        <div class="font-bold text-gray-800 text-lg leading-tight">{{ config('app.name') }}</div>
                        <div class="text-xs text-pink-500 font-medium">Pantau dengan Cinta 💖</div>
                    </div>
                </a>
            </div>

            <!-- Right: Profile & Status -->
            <div class="flex items-center gap-3">
                <!-- Online Status -->
                <div class="hidden md:flex items-center gap-2 px-4 py-2 rounded-full text-xs font-semibold shadow-md transition-all"
                    :class="online ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-700' : 'bg-gradient-to-r from-amber-100 to-orange-100 text-amber-700'">
                    <div class="w-2.5 h-2.5 rounded-full animate-pulse"
                        :class="online ? 'bg-green-500' : 'bg-amber-500'"></div>
                    <span x-text="online ? '✓ Online' : '⚠ Offline'"></span>
                </div>

                <!-- User Profile - Lebih cute -->
                <div
                    class="flex items-center gap-2.5 px-4 py-2 bg-gradient-to-r from-pink-100 via-purple-100 to-pink-100 rounded-full border-2 border-pink-300 shadow-lg hover:shadow-xl transition-all">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-pink-400 via-purple-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="hidden sm:block">
                        <div class="text-sm font-bold text-gray-800 leading-tight">{{ Auth::user()->name ?? 'User' }}
                        </div>
                        <div class="text-xs text-pink-600 font-medium">{{ ucfirst(Auth::user()->role ?? 'user') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <div class="max-w-7xl mx-auto px-4 py-6 lg:grid lg:grid-cols-12 lg:gap-6">

        <!-- Sidebar (Desktop) - Lebih cute -->
        <aside class="hidden lg:block lg:col-span-3 xl:col-span-2">
            <nav class="bg-white rounded-3xl shadow-xl border-4 border-pink-100 overflow-hidden sticky top-28">
                <div class="p-4 bg-gradient-to-r from-pink-100 to-purple-100 border-b-4 border-pink-200">
                    <div class="text-sm font-bold text-gray-700 text-center">Menu Utama 📋</div>
                </div>

                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-5 py-4 hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 border-b-2 border-gray-100 transition-all group {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-pink-100 to-purple-100 text-pink-600 font-bold' : 'text-gray-700' }}">
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center {{ request()->routeIs('dashboard') ? 'bg-white shadow-md' : 'bg-gray-100 group-hover:bg-white group-hover:shadow' }} transition-all">
                        <span class="text-xl">🏠</span>
                    </div>
                    <span class="text-sm">Beranda</span>
                </a>
                <a href="{{ route('children.index') }}"
                    class="flex items-center gap-3 px-5 py-4 hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 border-b-2 border-gray-100 transition-all group {{ request()->routeIs('children.*') ? 'bg-gradient-to-r from-pink-100 to-purple-100 text-pink-600 font-bold' : 'text-gray-700' }}">
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center {{ request()->routeIs('children.*') ? 'bg-white shadow-md' : 'bg-gray-100 group-hover:bg-white group-hover:shadow' }} transition-all">
                        <span class="text-xl">👶</span>
                    </div>
                    <span class="text-sm">Data Anak</span>
                </a>
                <a href="{{ route('mothers.index') }}"
                    class="flex items-center gap-3 px-5 py-4 hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 border-b-2 border-gray-100 transition-all group {{ request()->routeIs('mothers.*') ? 'bg-gradient-to-r from-pink-100 to-purple-100 text-pink-600 font-bold' : 'text-gray-700' }}">
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center {{ request()->routeIs('mothers.*') ? 'bg-white shadow-md' : 'bg-gray-100 group-hover:bg-white group-hover:shadow' }} transition-all">
                        <span class="text-xl">👩</span>
                    </div>
                    <span class="text-sm">Data Ibu</span>
                </a>
                <a href="{{ route('measurements.index') }}"
                    class="flex items-center gap-3 px-5 py-4 hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 border-b-2 border-gray-100 transition-all group {{ request()->routeIs('measurements.*') ? 'bg-gradient-to-r from-pink-100 to-purple-100 text-pink-600 font-bold' : 'text-gray-700' }}">
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center {{ request()->routeIs('measurements.*') ? 'bg-white shadow-md' : 'bg-gray-100 group-hover:bg-white group-hover:shadow' }} transition-all">
                        <span class="text-xl">📊</span>
                    </div>
                    <span class="text-sm">Pengukuran</span>
                </a>
                <a href="{{ route('posyandu.index') }}"
                    class="flex items-center gap-3 px-5 py-4 hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 border-b-2 border-gray-100 transition-all group {{ request()->routeIs('posyandu.*') ? 'bg-gradient-to-r from-pink-100 to-purple-100 text-pink-600 font-bold' : 'text-gray-700' }}">
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center {{ request()->routeIs('posyandu.*') ? 'bg-white shadow-md' : 'bg-gray-100 group-hover:bg-white group-hover:shadow' }} transition-all">
                        <span class="text-xl">🏥</span>
                    </div>
                    <span class="text-sm">Posyandu</span>
                </a>
                <a href="{{ route('recipes.index') }}"
                    class="flex items-center gap-3 px-5 py-4 hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 border-b-2 border-gray-100 transition-all group {{ request()->routeIs('recipes.*') ? 'bg-gradient-to-r from-pink-100 to-purple-100 text-pink-600 font-bold' : 'text-gray-700' }}">
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center {{ request()->routeIs('recipes.*') ? 'bg-white shadow-md' : 'bg-gray-100 group-hover:bg-white group-hover:shadow' }} transition-all">
                        <span class="text-xl">🍲</span>
                    </div>
                    <span class="text-sm">Resep Sehat</span>
                </a>
                <a href="{{ route('growth-standards.index') }}"
                    class="flex items-center gap-3 px-5 py-4 hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 transition-all group {{ request()->routeIs('growth-standards.*') ? 'bg-gradient-to-r from-pink-100 to-purple-100 text-pink-600 font-bold' : 'text-gray-700' }}">
                    <div
                        class="w-10 h-10 rounded-xl flex items-center justify-center {{ request()->routeIs('growth-standards.*') ? 'bg-white shadow-md' : 'bg-gray-100 group-hover:bg-white group-hover:shadow' }} transition-all">
                        <span class="text-xl">📈</span>
                    </div>
                    <span class="text-sm">Standar WHO</span>
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="border-t-4 border-pink-200 mt-2">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-5 py-4 hover:bg-red-50 text-red-500 font-bold transition-all group">
                        <div
                            class="w-10 h-10 rounded-xl flex items-center justify-center bg-red-100 group-hover:bg-red-200 transition-all">
                            <span class="text-xl">👋</span>
                        </div>
                        <span class="text-sm">Keluar</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebar" x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebar = false"
            class="lg:hidden fixed inset-0 z-40 bg-gray-900/60 backdrop-blur-sm">
        </div>

        <!-- Mobile Sidebar - Lebih cute -->
        <aside x-show="sidebar" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="lg:hidden fixed left-0 top-0 bottom-0 z-50 w-80 bg-white shadow-2xl overflow-y-auto">

            <!-- Mobile Sidebar Header -->
            <div
                class="sticky top-0 bg-gradient-to-r from-pink-400 via-purple-400 to-pink-400 p-5 flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="text-4xl">💕</div>
                    <div class="text-white">
                        <div class="font-bold text-lg">{{ config('app.name') }}</div>
                        <div class="text-sm text-pink-100">{{ Auth::user()->name ?? 'User' }}</div>
                    </div>
                </div>
                <button @click="sidebar = false"
                    class="p-2 text-white hover:bg-white/20 rounded-xl transition-all active:scale-95">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu Items -->
            <nav class="p-4">
                <a href="{{ route('dashboard') }}" @click="sidebar = false"
                    class="flex items-center gap-4 px-4 py-4 rounded-2xl mb-2 transition-all {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-pink-100 to-purple-100 text-pink-600 font-bold shadow-md' : 'text-gray-700 hover:bg-gray-50' }}">
                    <span class="text-2xl">🏠</span>
                    <span>Beranda</span>
                </a>
                <a href="{{ route('children.index') }}" @click="sidebar = false"
                    class="flex items-center gap-4 px-4 py-4 rounded-2xl mb-2 transition-all {{ request()->routeIs('children.*') ? 'bg-gradient-to-r from-pink-100 to-purple-100 text-pink-600 font-bold shadow-md' : 'text-gray-700 hover:bg-gray-50' }}">
                    <span class="text-2xl">👶</span>
                    <span>Data Anak</span>
                </a>
                <a href="{{ route('mothers.index') }}" @click="sidebar = false"
                    class="flex items-center gap-4 px-4 py-4 rounded-2xl mb-2 transition-all {{ request()->routeIs('mothers.*') ? 'bg-gradient-to-r from-pink-100 to-purple-100 text-pink-600 font-bold shadow-md' : 'text-gray-700 hover:bg-gray-50' }}">
                    <span class="text-2xl">👩</span>
                    <span>Data Ibu</span>
                </a>
                <a href="{{ route('measurements.index') }}" @click="sidebar = false"
                    class="flex items-center gap-4 px-4 py-4 rounded-2xl mb-2 transition-all {{ request()->routeIs('measurements.*') ? 'bg-gradient-to-r from-pink-100 to-purple-100 text-pink-600 font-bold shadow-md' : 'text-gray-700 hover:bg-gray-50' }}">
                    <span class="text-2xl">📊</span>
                    <span>Pengukuran</span>
                </a>
                <a href="{{ route('posyandu.index') }}" @click="sidebar = false"
                    class="flex items-center gap-4 px-4 py-4 rounded-2xl mb-2 transition-all {{ request()->routeIs('posyandu.*') ? 'bg-gradient-to-r from-pink-100 to-purple-100 text-pink-600 font-bold shadow-md' : 'text-gray-700 hover:bg-gray-50' }}">
                    <span class="text-2xl">🏥</span>
                    <span>Posyandu</span>
                </a>
                <a href="{{ route('recipes.index') }}" @click="sidebar = false"
                    class="flex items-center gap-4 px-4 py-4 rounded-2xl mb-2 transition-all {{ request()->routeIs('recipes.*') ? 'bg-gradient-to-r from-pink-100 to-purple-100 text-pink-600 font-bold shadow-md' : 'text-gray-700 hover:bg-gray-50' }}">
                    <span class="text-2xl">🍲</span>
                    <span>Resep Sehat</span>
                </a>
                <a href="{{ route('growth-standards.index') }}" @click="sidebar = false"
                    class="flex items-center gap-4 px-4 py-4 rounded-2xl mb-2 transition-all {{ request()->routeIs('growth-standards.*') ? 'bg-gradient-to-r from-pink-100 to-purple-100 text-pink-600 font-bold shadow-md' : 'text-gray-700 hover:bg-gray-50' }}">
                    <span class="text-2xl">📈</span>
                    <span>Standar WHO</span>
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="mt-6 pt-6 border-t-4 border-pink-200">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-4 px-4 py-4 rounded-2xl text-red-500 hover:bg-red-50 font-bold transition-all active:scale-95">
                        <span class="text-2xl">👋</span>
                        <span>Keluar</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="lg:col-span-9 xl:col-span-10">
            <!-- Flash Messages - Lebih cute -->
            @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                class="mb-6 rounded-3xl border-4 border-green-200 bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-5 flex items-start gap-4 shadow-xl">
                <div class="flex-shrink-0 text-3xl">✅</div>
                <div class="flex-1 text-green-800 font-semibold">
                    {{ session('success') }}
                </div>
                <button @click="show = false"
                    class="flex-shrink-0 text-green-600 hover:text-green-800 p-2 hover:bg-green-100 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            @endif

            @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" x-transition
                class="mb-6 rounded-3xl border-4 border-red-200 bg-gradient-to-r from-red-50 to-rose-50 px-6 py-5 shadow-xl">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 text-3xl">⚠️</div>
                    <div class="flex-1">
                        <div class="font-bold text-red-800 mb-3 text-lg">Ups! Ada yang perlu diperbaiki:</div>
                        <ul class="list-none space-y-2">
                            @foreach ($errors->all() as $error)
                            <li class="flex items-start gap-2 text-sm text-red-700">
                                <span class="text-red-500 mt-0.5">•</span>
                                <span>{{ $error }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <button @click="show = false"
                        class="flex-shrink-0 text-red-600 hover:text-red-800 p-2 hover:bg-red-100 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            @endif

            <!-- Content Card - Lebih soft & rounded -->
            <div class="bg-white rounded-3xl shadow-2xl border-4 border-pink-100">
                @isset($header)
                <div class="px-8 py-6 border-b-4 border-pink-100 bg-gradient-to-r from-pink-50 to-purple-50">
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                        <span class="text-4xl">{{ $headerIcon ?? '📋' }}</span>
                        {{ $header }}
                    </h1>
                </div>
                @endisset
                <div class="p-8">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <!-- Bottom Navigation (Mobile Only) - Lebih cute -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t-4 border-pink-200 shadow-2xl z-30">
        <div class="grid grid-cols-4 h-20">
            <a href="{{ route('dashboard') }}"
                class="flex flex-col items-center justify-center gap-1 transition-all {{ request()->routeIs('dashboard') ? 'text-pink-600 bg-gradient-to-t from-pink-50' : 'text-gray-500' }}">
                <span class="text-2xl">🏠</span>
                <span class="text-xs font-bold">Beranda</span>
            </a>
            <a href="{{ route('children.index') }}"
                class="flex flex-col items-center justify-center gap-1 transition-all {{ request()->routeIs('children.*') ? 'text-pink-600 bg-gradient-to-t from-pink-50' : 'text-gray-500' }}">
                <span class="text-2xl">👶</span>
                <span class="text-xs font-bold">Anak</span>
            </a>
            <a href="{{ route('measurements.index') }}"
                class="flex flex-col items-center justify-center gap-1 transition-all {{ request()->routeIs('measurements.*') ? 'text-pink-600 bg-gradient-to-t from-pink-50' : 'text-gray-500' }}">
                <span class="text-2xl">📊</span>
                <span class="text-xs font-bold">Ukur</span>
            </a>
            <button @click="sidebar = true"
                class="flex flex-col items-center justify-center gap-1 text-gray-500 hover:text-pink-600 transition-all active:scale-95">
                <span class="text-2xl">☰</span>
                <span class="text-xs font-bold">Menu</span>
            </button>
        </div>
    </nav>

    <!-- Footer (Desktop Only) -->
    <footer class="hidden lg:block text-center text-sm text-gray-500 py-8 mt-8">
        <p class="flex items-center justify-center gap-2">
            <span>Made with</span>
            <span class="text-red-500 text-lg">❤️</span>
            <span>© {{ date('Y') }} {{ config('app.name') }}</span>
        </p>
        <p class="text-xs text-gray-400 mt-2">Dinas Ketahanan Pangan Kab. Muara Enim</p>
    </footer>
</body>

</html>