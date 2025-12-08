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
    <meta name="theme-color" content="#FF6B8A">
    <meta name="description" content="Sistem Pemantauan Tumbuh Kembang Anak - Posyandu">
    <link rel="manifest" href="/manifest.webmanifest">
    <link rel="icon" href="/icons/icon-192x192.svg" type="image/svg+xml">
    <title>{{ $title ?? $header ?? config('app.name') }}</title>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen pb-24 lg:pb-8 relative overflow-x-hidden">

    <!-- 🌸 Decorative Background Elements -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10">
        <div class="decorative-blob w-96 h-96 bg-primary-200 top-0 -right-48 animate-float"></div>
        <div class="decorative-blob w-80 h-80 bg-accent-200 bottom-20 -left-40" style="animation-delay: 2s;"></div>
        <div class="decorative-blob w-64 h-64 bg-secondary-200 top-1/2 right-1/4" style="animation-delay: 4s;"></div>
    </div>

    <!-- PWA Install Banner -->
    <div x-show="showInstallPrompt" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-full" x-transition:enter-end="opacity-100 translate-y-0"
        class="fixed top-0 left-0 right-0 z-50 bg-gradient-primary text-white p-4 shadow-soft-lg">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <div class="font-bold text-lg">Install Aplikasi 💕</div>
                    <div class="text-sm text-white/80">Akses lebih cepat & bisa offline</div>
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
                    class="bg-white text-primary-500 font-bold py-2 px-5 rounded-xl hover:bg-primary-50 transition-all duration-300">
                    Install
                </button>
                <button @click="showInstallPrompt = false"
                    class="p-2 text-white/80 hover:text-white hover:bg-white/20 rounded-xl transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Offline Banner -->
    <div x-show="!online" x-transition
        class="fixed top-0 left-0 right-0 z-40 bg-gradient-to-r from-warm-100 to-warm-50 text-warm-700 text-sm py-3 px-4 text-center font-semibold border-b-2 border-warm-200">
        <div class="flex items-center justify-center gap-2">
            <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.167-9.238m7.824 2.167a1 1 0 111.414 1.414m-1.414-1.414L3 3m8.293 8.293l1.414 1.414" />
            </svg>
            <span>Mode Offline ☁️ - Data akan tersinkron saat online kembali</span>
        </div>
    </div>

    <!-- 🎀 Top Header -->
    <header class="sticky top-0 z-30 bg-white/80 backdrop-blur-lg border-b border-primary-100/50 shadow-soft">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
            <!-- Left: Menu & Logo -->
            <div class="flex items-center gap-3">
                <button @click="sidebar = !sidebar"
                    class="lg:hidden p-2.5 rounded-xl bg-primary-50 hover:bg-primary-100 text-primary-500 transition-all duration-300 hover:scale-105 active:scale-95"
                    aria-label="Toggle menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <div
                        class="w-11 h-11 bg-gradient-primary rounded-2xl flex items-center justify-center shadow-soft group-hover:shadow-soft-lg group-hover:scale-105 transition-all duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <div class="hidden sm:block">
                        <div
                            class="font-heading font-bold text-neutral-800 group-hover:text-primary-600 transition-colors">
                            {{ config('app.name') }}</div>
                        <div class="text-xs text-neutral-500 font-medium">Pantau Tumbuh Kembang 💕</div>
                    </div>
                </a>
            </div>

            <!-- Right: Profile & Status -->
            <div class="flex items-center gap-3">
                <!-- Online Status -->
                <div class="hidden md:flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold transition-all duration-300"
                    :class="online ? 'bg-secondary-50 text-secondary-600 border border-secondary-200' : 'bg-warm-50 text-warm-600 border border-warm-200'">
                    <div class="w-2.5 h-2.5 rounded-full animate-pulse"
                        :class="online ? 'status-online' : 'status-offline'"></div>
                    <span x-text="online ? '✨ Online' : '☁️ Offline'"></span>
                </div>

                <!-- User Profile -->
                <div
                    class="flex items-center gap-3 px-3 py-2 bg-gradient-to-r from-primary-50 to-accent-50/50 rounded-2xl border border-primary-100/50 hover:shadow-soft transition-all duration-300 cursor-pointer group">
                    <div
                        class="w-9 h-9 bg-gradient-primary rounded-xl flex items-center justify-center text-white font-bold text-sm shadow-soft group-hover:scale-105 transition-transform duration-300">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="hidden sm:block">
                        <div class="text-sm font-bold text-neutral-700 leading-tight">
                            {{ Auth::user()->name ?? 'User' }}</div>
                        <div class="text-xs text-primary-500 font-medium">{{ ucfirst(Auth::user()->role ?? 'user') }} 🌟
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <div class="max-w-7xl mx-auto px-4 py-6 lg:grid lg:grid-cols-12 lg:gap-6">

        <!-- 🌷 Sidebar (Desktop) -->
        <aside class="hidden lg:block lg:col-span-3 xl:col-span-2">
            <nav class="card-cute sticky top-24 overflow-hidden">
                <div class="p-4 bg-gradient-to-r from-primary-50 to-accent-50/50 border-b border-primary-100">
                    <div class="text-xs font-bold text-primary-500 uppercase tracking-wider flex items-center gap-2">
                        <span>✨</span> Menu Utama
                    </div>
                </div>

                <div class="p-3 space-y-1">
                    <a href="{{ route('dashboard') }}"
                        class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Beranda</span>
                        <span class="ml-auto text-xs">🏠</span>
                    </a>
                    <a href="{{ route('children.index') }}"
                        class="sidebar-link {{ request()->routeIs('children.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>Data Anak</span>
                        <span class="ml-auto text-xs">👶</span>
                    </a>
                    <a href="{{ route('mothers.index') }}"
                        class="sidebar-link {{ request()->routeIs('mothers.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Data Ibu</span>
                        <span class="ml-auto text-xs">👩</span>
                    </a>
                    <a href="{{ route('measurements.index') }}"
                        class="sidebar-link {{ request()->routeIs('measurements.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span>Pengukuran</span>
                        <span class="ml-auto text-xs">📏</span>
                    </a>
                    <a href="{{ route('posyandu.index') }}"
                        class="sidebar-link {{ request()->routeIs('posyandu.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span>Posyandu</span>
                        <span class="ml-auto text-xs">🏥</span>
                    </a>
                    <a href="{{ route('users.index') }}"
                        class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>{{ Auth::user()->role === 'admin' ? 'User' : 'Kader' }}</span>
                        <span class="ml-auto text-xs">👥</span>
                    </a>
                    <a href="{{ route('recipes.index') }}"
                        class="sidebar-link {{ request()->routeIs('recipes.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span>Resep Sehat</span>
                        <span class="ml-auto text-xs">🍎</span>
                    </a>
                    <a href="{{ route('growth-standards.index') }}"
                        class="sidebar-link {{ request()->routeIs('growth-standards.*') ? 'active' : '' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                        <span>Standar WHO</span>
                        <span class="ml-auto text-xs">📊</span>
                    </a>
                </div>

                <a href="{{ route('profile') }}"
                    class="sidebar-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A4 4 0 0112 15a4 4 0 016.879 2.804M15 11a3 3 0 10-6 0 3 3 0 006 0z" />
                    </svg>
                    <span>Profil Saya</span>
                    <span class="ml-auto text-xs">💁‍♀️</span>
                </a>

                <!-- Logout -->
                <div class="p-3 border-t border-primary-100 bg-gradient-to-r from-red-50/50 to-warm-50/50">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="sidebar-link w-full text-red-500 hover:bg-red-50 hover:text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Keluar</span>
                            <span class="ml-auto text-xs">👋</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebar" x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebar = false"
            class="lg:hidden fixed inset-0 z-40 bg-neutral-900/40 backdrop-blur-sm">
        </div>

        <!-- 📱 Mobile Sidebar -->
        <aside x-show="sidebar" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="lg:hidden fixed left-0 top-0 bottom-0 z-50 w-80 bg-white/95 backdrop-blur-lg shadow-soft-lg overflow-y-auto rounded-r-3xl">

            <!-- Mobile Sidebar Header -->
            <div class="sticky top-0 bg-gradient-primary p-5 flex items-center justify-between rounded-br-3xl">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <div class="text-white">
                        <div class="font-heading font-bold text-lg">{{ config('app.name') }}</div>
                        <div class="text-sm text-white/80">{{ Auth::user()->name ?? 'User' }} 💕</div>
                    </div>
                </div>
                <button @click="sidebar = false"
                    class="p-2 text-white/80 hover:text-white hover:bg-white/20 rounded-xl transition-all duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu Items -->
            <nav class="p-4 space-y-2">
                <a href="{{ route('dashboard') }}" @click="sidebar = false"
                    class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-gradient-primary text-white shadow-soft' : 'text-neutral-600 hover:bg-primary-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="font-semibold">Beranda</span>
                    <span class="ml-auto">🏠</span>
                </a>
                <a href="{{ route('children.index') }}" @click="sidebar = false"
                    class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-300 {{ request()->routeIs('children.*') ? 'bg-gradient-primary text-white shadow-soft' : 'text-neutral-600 hover:bg-primary-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="font-semibold">Data Anak</span>
                    <span class="ml-auto">👶</span>
                </a>
                <a href="{{ route('mothers.index') }}" @click="sidebar = false"
                    class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-300 {{ request()->routeIs('mothers.*') ? 'bg-gradient-primary text-white shadow-soft' : 'text-neutral-600 hover:bg-primary-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="font-semibold">Data Ibu</span>
                    <span class="ml-auto">👩</span>
                </a>
                <a href="{{ route('measurements.index') }}" @click="sidebar = false"
                    class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-300 {{ request()->routeIs('measurements.*') ? 'bg-gradient-primary text-white shadow-soft' : 'text-neutral-600 hover:bg-primary-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span class="font-semibold">Pengukuran</span>
                    <span class="ml-auto">📏</span>
                </a>
                <a href="{{ route('posyandu.index') }}" @click="sidebar = false"
                    class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-300 {{ request()->routeIs('posyandu.*') ? 'bg-gradient-primary text-white shadow-soft' : 'text-neutral-600 hover:bg-primary-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span class="font-semibold">Posyandu</span>
                    <span class="ml-auto">🏥</span>
                </a>
                <a href="{{ route('users.index') }}" @click="sidebar = false"
                    class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-300 {{ request()->routeIs('users.*') ? 'bg-gradient-primary text-white shadow-soft' : 'text-neutral-600 hover:bg-primary-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="font-semibold">{{ Auth::user()->role === 'admin' ? 'User' : 'Kader' }}</span>
                    <span class="ml-auto">👥</span>
                </a>
                <a href="{{ route('recipes.index') }}" @click="sidebar = false"
                    class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-300 {{ request()->routeIs('recipes.*') ? 'bg-gradient-primary text-white shadow-soft' : 'text-neutral-600 hover:bg-primary-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span class="font-semibold">Resep Sehat</span>
                    <span class="ml-auto">🍎</span>
                </a>
                <a href="{{ route('growth-standards.index') }}" @click="sidebar = false"
                    class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-300 {{ request()->routeIs('growth-standards.*') ? 'bg-gradient-primary text-white shadow-soft' : 'text-neutral-600 hover:bg-primary-50' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                    <span class="font-semibold">Standar WHO</span>
                    <span class="ml-auto">📊</span>
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="mt-6 pt-4 border-t border-primary-100">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3.5 rounded-2xl text-red-500 hover:bg-red-50 transition-all duration-300 font-semibold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Keluar</span>
                        <span class="ml-auto">👋</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="lg:col-span-9 xl:col-span-10">
            <!-- Flash Messages -->
            @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                class="mb-6 card-cute border-l-4 border-l-secondary-400 px-5 py-4 flex items-start gap-3 bg-gradient-to-r from-secondary-50 to-white">
                <div class="w-8 h-8 bg-secondary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1 text-secondary-700 font-medium">{{ session('success') }} ✨</div>
                <button @click="show = false"
                    class="flex-shrink-0 text-secondary-400 hover:text-secondary-600 transition-colors p-1 hover:bg-secondary-100 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            @endif

            @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition
                class="mb-6 card-cute border-l-4 border-l-red-400 px-5 py-4 flex items-start gap-3 bg-gradient-to-r from-red-50 to-white">
                <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1 text-red-700 font-medium">{{ session('error') }}</div>
                <button @click="show = false"
                    class="flex-shrink-0 text-red-400 hover:text-red-600 transition-colors p-1 hover:bg-red-100 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            @endif

            @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" x-transition
                class="mb-6 card-cute border-l-4 border-l-red-400 px-5 py-4 bg-gradient-to-r from-red-50 to-white">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-red-700 mb-2">Oops! Ada yang perlu diperbaiki 💫</div>
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                            <li class="text-sm text-red-600 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-red-400 rounded-full"></span>
                                {{ $error }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <button @click="show = false"
                        class="flex-shrink-0 text-red-400 hover:text-red-600 transition-colors p-1 hover:bg-red-100 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            @endif

            <!-- Content Card -->
            <div class="card-cute">
                @isset($header)
                <div class="px-6 py-4 border-b border-primary-100 bg-gradient-to-r from-primary-50/50 to-accent-50/30">
                    <h1 class="page-title flex items-center gap-2">
                        {{ $header }}
                        <span class="text-lg">✨</span>
                    </h1>
                </div>
                @endisset
                <div class="p-6">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <!-- 📱 Bottom Navigation (Mobile Only) -->
    <nav
        class="lg:hidden fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-lg border-t border-primary-100 shadow-soft-lg z-30 rounded-t-3xl">
        <div class="grid grid-cols-5 h-20 px-2">
            <a href="{{ route('dashboard') }}"
                class="flex flex-col items-center justify-center gap-1 transition-all duration-300 {{ request()->routeIs('dashboard') ? 'text-primary-500' : 'text-neutral-400 hover:text-primary-400' }}">
                <div
                    class="w-10 h-10 rounded-2xl flex items-center justify-center transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-gradient-primary text-white shadow-soft' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <span class="text-xs font-bold">Beranda</span>
            </a>
            <a href="{{ route('children.index') }}"
                class="flex flex-col items-center justify-center gap-1 transition-all duration-300 {{ request()->routeIs('children.*') ? 'text-primary-500' : 'text-neutral-400 hover:text-primary-400' }}">
                <div
                    class="w-10 h-10 rounded-2xl flex items-center justify-center transition-all duration-300 {{ request()->routeIs('children.*') ? 'bg-gradient-primary text-white shadow-soft' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <span class="text-xs font-bold">Anak</span>
            </a>
            <a href="{{ route('mothers.index') }}"
                class="flex flex-col items-center justify-center gap-1 transition-all duration-300 {{ request()->routeIs('mothers.*') ? 'text-primary-500' : 'text-neutral-400 hover:text-primary-400' }}">
                <div
                    class="w-10 h-10 rounded-2xl flex items-center justify-center transition-all duration-300 {{ request()->routeIs('mothers.*') ? 'bg-gradient-primary text-white shadow-soft' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <span class="text-xs font-bold">Ibu</span>
            </a>
            <a href="{{ route('measurements.index') }}"
                class="flex flex-col items-center justify-center gap-1 transition-all duration-300 {{ request()->routeIs('measurements.*') ? 'text-primary-500' : 'text-neutral-400 hover:text-primary-400' }}">
                <div
                    class="w-10 h-10 rounded-2xl flex items-center justify-center transition-all duration-300 {{ request()->routeIs('measurements.*') ? 'bg-gradient-primary text-white shadow-soft' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <span class="text-xs font-bold">Ukur</span>
            </a>
            <button @click="sidebar = true"
                class="flex flex-col items-center justify-center gap-1 text-neutral-400 hover:text-primary-400 transition-all duration-300">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </div>
                <span class="text-xs font-bold">Menu</span>
            </button>
        </div>
    </nav>

    <!-- Footer (Desktop Only) -->
    <footer class="hidden lg:block text-center py-10 mt-8">
        <div class="flex items-center justify-center gap-2 text-neutral-500 font-medium">
            <span>Made with</span>
            <svg class="w-5 h-5 text-primary-400 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
            </svg>
            <span>oleh Tim {{ config('app.name') }}</span>
        </div>
        <p class="text-xs text-neutral-400 mt-2">© {{ date('Y') }} Dinas Ketahanan Pangan Kab. Muara Enim 💕</p>
    </footer>

    <!-- Page Scripts -->
    @stack('scripts')
</body>

</html>