@props(['title' => null, 'header' => null])

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
    <meta name="theme-color" content="#ec4899">
    <meta name="description" content="Monitoring Pertumbuhan dan Pola Makan Anak - Posyandu Digital">
    <link rel="manifest" href="/manifest.webmanifest">
    <link rel="icon" href="/icons/icon-192x192.png" type="image/png">
    <title>{{ $title ?? $header ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gradient-to-br from-pink-50 via-purple-50 to-blue-50 pb-20 md:pb-6">

    <!-- PWA Install Banner -->
    <div x-show="showInstallPrompt" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-full" x-transition:enter-end="opacity-100 translate-y-0"
        class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-pink-500 to-purple-500 text-white p-4 shadow-lg">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                </svg>
                <div>
                    <div class="font-bold">Install Aplikasi</div>
                    <div class="text-sm text-pink-100">Akses lebih cepat & bisa offline</div>
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
                    class="px-4 py-2 bg-white text-pink-600 rounded-xl font-bold text-sm hover:bg-pink-50 transition-colors">
                    Install
                </button>
                <button @click="showInstallPrompt = false"
                    class="px-3 py-2 text-white hover:bg-white/20 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Offline Banner -->
    <div x-show="!online" x-transition
        class="fixed top-0 left-0 right-0 z-40 bg-amber-400 text-amber-900 text-sm py-2 px-4 text-center font-medium shadow-md">
        <div class="flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            Mode Offline - Perubahan akan disinkronkan saat online
        </div>
    </div>

    <!-- Top Header -->
    <header class="sticky top-0 z-30 bg-white/90 backdrop-blur-md border-b-2 border-pink-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button @click="sidebar = !sidebar"
                    class="lg:hidden p-2 rounded-xl hover:bg-pink-50 active:bg-pink-100 transition-colors"
                    aria-label="Toggle menu">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-pink-500 to-purple-500 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <span class="font-bold text-gray-800 hidden sm:inline">{{ config('app.name') }}</span>
                </a>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-medium"
                    :class="online ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700'">
                    <div class="w-2 h-2 rounded-full" :class="online ? 'bg-green-500' : 'bg-amber-500'"></div>
                    <span x-text="online ? 'Online' : 'Offline'"></span>
                </div>

                <div
                    class="flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-pink-50 to-purple-50 rounded-full border-2 border-pink-200">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-pink-400 to-purple-400 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <span
                        class="text-sm font-semibold text-gray-800 hidden sm:inline">{{ Auth::user()->name ?? 'User' }}</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Grid -->
    <div class="max-w-7xl mx-auto px-4 py-6 lg:grid lg:grid-cols-12 lg:gap-6">

        <!-- Sidebar (Desktop) -->
        <aside class="hidden lg:block lg:col-span-3 xl:col-span-2">
            <nav class="bg-white rounded-2xl shadow-md border-2 border-gray-100 overflow-hidden sticky top-24">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-5 py-4 hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 border-b border-gray-100 transition-all {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-pink-50 to-purple-50 text-pink-600 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Beranda</span>
                </a>
                <a href="{{ route('posyandu.index') }}"
                    class="flex items-center gap-3 px-5 py-4 hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 border-b border-gray-100 transition-all {{ request()->routeIs('posyandu.*') ? 'bg-gradient-to-r from-pink-50 to-purple-50 text-pink-600 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>Posyandu</span>
                </a>
                <a href="{{ route('mothers.index') }}"
                    class="flex items-center gap-3 px-5 py-4 hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 border-b border-gray-100 transition-all {{ request()->routeIs('mothers.*') ? 'bg-gradient-to-r from-pink-50 to-purple-50 text-pink-600 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Ibu</span>
                </a>
                <a href="{{ route('children.index') }}"
                    class="flex items-center gap-3 px-5 py-4 hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 border-b border-gray-100 transition-all {{ request()->routeIs('children.*') ? 'bg-gradient-to-r from-pink-50 to-purple-50 text-pink-600 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Anak</span>
                </a>
                <a href="{{ route('measurements.index') }}"
                    class="flex items-center gap-3 px-5 py-4 hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 border-b border-gray-100 transition-all {{ request()->routeIs('measurements.*') ? 'bg-gradient-to-r from-pink-50 to-purple-50 text-pink-600 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span>Pengukuran</span>
                </a>
                <a href="{{ route('recipes.index') }}"
                    class="flex items-center gap-3 px-5 py-4 hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 border-b border-gray-100 transition-all {{ request()->routeIs('recipes.*') ? 'bg-gradient-to-r from-pink-50 to-purple-50 text-pink-600 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Resep Sehat</span>
                </a>
                <a href="{{ route('growth-standards.index') }}"
                    class="flex items-center gap-3 px-5 py-4 hover:bg-gradient-to-r hover:from-pink-50 hover:to-purple-50 transition-all {{ request()->routeIs('growth-standards.*') ? 'bg-gradient-to-r from-pink-50 to-purple-50 text-pink-600 font-semibold' : 'text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Standar WHO</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="border-t-2 border-gray-200">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-5 py-4 hover:bg-red-50 text-red-600 font-semibold transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebar" x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebar = false"
            class="lg:hidden fixed inset-0 z-40 bg-gray-900 bg-opacity-50 backdrop-blur-sm">
        </div>

        <!-- Mobile Sidebar -->
        <aside x-show="sidebar" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="lg:hidden fixed left-0 top-0 bottom-0 z-50 w-72 bg-white shadow-2xl overflow-y-auto">

            <div
                class="sticky top-0 bg-gradient-to-r from-pink-500 to-purple-500 p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <div class="text-white">
                        <div class="font-bold">{{ config('app.name') }}</div>
                        <div class="text-xs text-pink-100">{{ Auth::user()->name ?? 'User' }}</div>
                    </div>
                </div>
                <button @click="sidebar = false" class="p-2 text-white hover:bg-white/20 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="p-2">
                <a href="{{ route('dashboard') }}" @click="sidebar = false"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-pink-50 to-purple-50 text-pink-600 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Beranda</span>
                </a>
                <a href="{{ route('posyandu.index') }}" @click="sidebar = false"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1 {{ request()->routeIs('posyandu.*') ? 'bg-gradient-to-r from-pink-50 to-purple-50 text-pink-600 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span>Posyandu</span>
                </a>
                <a href="{{ route('mothers.index') }}" @click="sidebar = false"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1 {{ request()->routeIs('mothers.*') ? 'bg-gradient-to-r from-pink-50 to-purple-50 text-pink-600 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Ibu</span>
                </a>
                <a href="{{ route('children.index') }}" @click="sidebar = false"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1 {{ request()->routeIs('children.*') ? 'bg-gradient-to-r from-pink-50 to-purple-50 text-pink-600 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>Anak</span>
                </a>
                <a href="{{ route('measurements.index') }}" @click="sidebar = false"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1 {{ request()->routeIs('measurements.*') ? 'bg-gradient-to-r from-pink-50 to-purple-50 text-pink-600 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span>Pengukuran</span>
                </a>
                <a href="{{ route('recipes.index') }}" @click="sidebar = false"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1 {{ request()->routeIs('recipes.*') ? 'bg-gradient-to-r from-pink-50 to-purple-50 text-pink-600 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Resep Sehat</span>
                </a>
                <a href="{{ route('growth-standards.index') }}" @click="sidebar = false"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl mb-1 {{ request()->routeIs('growth-standards.*') ? 'bg-gradient-to-r from-pink-50 to-purple-50 text-pink-600 font-semibold' : 'text-gray-700 hover:bg-gray-50' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Standar WHO</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="mt-4 pt-4 border-t-2 border-gray-200">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 font-semibold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="lg:col-span-9 xl:col-span-10">
            <!-- Flash Messages -->
            @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                class="mb-4 rounded-2xl border-2 border-green-200 bg-gradient-to-r from-green-50 to-emerald-50 px-5 py-4 flex items-start gap-3 shadow-md">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1 text-green-800 font-medium">
                    {{ session('success') }}
                </div>
                <button @click="show = false" class="flex-shrink-0 text-green-600 hover:text-green-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            @endif

            @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" x-transition
                class="mb-4 rounded-2xl border-2 border-red-200 bg-gradient-to-r from-red-50 to-rose-50 px-5 py-4 shadow-md">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="font-semibold text-red-800 mb-2">Perbaiki kesalahan berikut:</div>
                        <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button @click="show = false" class="flex-shrink-0 text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            @endif

            <!-- Content Card -->
            <div class="bg-white rounded-3xl shadow-lg border-2 border-gray-100">
                @isset($header)
                <div class="px-6 py-5 border-b-2 border-gray-100">
                    <h1 class="text-2xl font-bold text-gray-800">{{ $header }}</h1>
                </div>
                @endisset
                <div class="p-6">
                    {{ $slot }}
                </div>
            </div>
        </main>
    </div>

    <!-- Bottom Navigation (Mobile Only) -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t-2 border-gray-200 shadow-2xl z-30">
        <div class="grid grid-cols-4 h-20">
            <a href="{{ route('dashboard') }}"
                class="flex flex-col items-center justify-center gap-1 {{ request()->routeIs('dashboard') ? 'text-pink-600' : 'text-gray-500' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-xs font-semibold">Beranda</span>
            </a>
            <a href="{{ route('children.index') }}"
                class="flex flex-col items-center justify-center gap-1 {{ request()->routeIs('children.*') ? 'text-pink-600' : 'text-gray-500' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span class="text-xs font-semibold">Anak</span>
            </a>
            <a href="{{ route('measurements.index') }}"
                class="flex flex-col items-center justify-center gap-1 {{ request()->routeIs('measurements.*') ? 'text-pink-600' : 'text-gray-500' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <span class="text-xs font-semibold">Grafik</span>
            </a>
            <button @click="sidebar = true" class="flex flex-col items-center justify-center gap-1 text-gray-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span class="text-xs font-semibold">Menu</span>
            </button>
        </div>
    </nav>

    <footer class="hidden lg:block text-center text-sm text-gray-500 py-6 mt-8">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }} — Dinas Ketahanan Pangan Kab. Muara Enim</p>
    </footer>
</body>

</html>