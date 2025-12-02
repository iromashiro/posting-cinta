@extends('layouts.app')

@php
// Header untuk layout
$header = 'Dashboard';

// Mapping warna badge status gizi
$badgeClasses = [
'gizi_buruk' => 'badge-danger',
'gizi_kurang' => 'badge-warning',
'gizi_baik' => 'badge-success',
'berisiko_gizi_lebih' => 'badge-warning',
'gizi_lebih' => 'badge-warning',
'severe' => 'badge-danger',
'stunting' => 'badge-warning',
'normal' => 'badge-success',
];
@endphp

@section('content')

<!-- 🌸 Welcome Banner -->
<div
    class="card-cute p-6 mb-6 bg-gradient-to-r from-primary-400 via-primary-500 to-accent-400 text-white border-0 relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-1/2 -translate-x-1/2"></div>

    <div class="flex items-start justify-between gap-4 relative z-10">
        <div class="flex-1">
            <p class="text-sm text-white/80 mb-1 font-medium">{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                ☀️</p>
            <h2 class="text-2xl md:text-3xl font-bold mb-2 font-heading">
                Hai, {{ $user->name }}! 👋💕
            </h2>
            <p class="text-white/90 mb-4 font-medium">
                Selamat datang kembali! Yuk pantau tumbuh kembang anak hari ini ✨
            </p>
            <div class="flex flex-wrap gap-2">
                <span class="badge bg-white/20 text-white border border-white/30">
                    {{ ucfirst($user->role) }} 🌟
                </span>
                <span class="badge bg-white/20 text-white border border-white/30">
                    Aktif Hari Ini 💪
                </span>
            </div>
        </div>
        <div class="hidden md:flex items-center justify-center w-28 h-28 bg-white/20 rounded-3xl backdrop-blur-sm">
            <svg class="w-14 h-14 text-white animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </div>
    </div>
</div>

<!-- 💡 Tips Section -->
<div class="card-cute p-5 mb-6 bg-gradient-to-r from-accent-50 to-primary-50 border-2 border-accent-100">
    <div class="flex items-start gap-4">
        <div
            class="w-12 h-12 rounded-2xl bg-gradient-to-br from-accent-400 to-accent-500 flex items-center justify-center flex-shrink-0 shadow-dreamy">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <h3 class="font-bold text-neutral-800 mb-1 font-heading">Tips Penggunaan Aplikasi 💡</h3>
            <p class="text-sm text-neutral-600 mb-3 leading-relaxed">
                <strong>Langkah mudah:</strong> Daftarkan data Ibu 👩 → Tambahkan data Anak 👶 → Input hasil pengukuran
                secara
                berkala 📏 → Lihat grafik pertumbuhan! 📊
            </p>
            <div class="flex flex-wrap gap-2">
                <span class="badge badge-accent">Mudah digunakan ✨</span>
                <span class="badge badge-primary">Bisa offline ☁️</span>
                <span class="badge badge-success">Data aman 🔒</span>
            </div>
        </div>
    </div>
</div>

<!-- ⚡ Quick Actions -->
<div class="card-cute p-6 mb-6">
    <div class="mb-5">
        <h3 class="text-lg font-bold text-neutral-800 font-heading flex items-center gap-2">
            <span>⚡</span> Aksi Cepat
        </h3>
        <p class="text-sm text-neutral-500 mt-1">Pilih menu di bawah untuk memulai</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Input Pengukuran -->
        <a href="{{ route('measurements.create') }}"
            class="card-cute p-4 hover:shadow-soft hover:-translate-y-1 transition-all duration-300 group border-2 border-primary-100 hover:border-primary-200">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-gradient-primary flex items-center justify-center shadow-soft group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-neutral-800">Input Pengukuran 📏</h4>
                    <p class="text-sm text-neutral-500">Catat BB & TB anak</p>
                </div>
            </div>
        </a>

        <!-- Daftar Anak Baru -->
        <a href="{{ route('children.create') }}"
            class="card-cute p-4 hover:shadow-soft hover:-translate-y-1 transition-all duration-300 group border-2 border-secondary-100 hover:border-secondary-200">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-secondary-400 to-secondary-500 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-neutral-800">Daftar Anak Baru 👶</h4>
                    <p class="text-sm text-neutral-500">Tambah data anak</p>
                </div>
            </div>
        </a>

        <!-- Daftar Ibu Baru -->
        <a href="{{ route('mothers.create') }}"
            class="card-cute p-4 hover:shadow-soft hover:-translate-y-1 transition-all duration-300 group border-2 border-accent-100 hover:border-accent-200">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-accent-400 to-accent-500 flex items-center justify-center shadow-dreamy group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-neutral-800">Daftar Ibu Baru 👩</h4>
                    <p class="text-sm text-neutral-500">Tambah data ibu</p>
                </div>
            </div>
        </a>

        <!-- Daftar Anak -->
        <a href="{{ route('children.index') }}"
            class="card-cute p-4 hover:shadow-soft hover:-translate-y-1 transition-all duration-300 group border-2 border-blue-100 hover:border-blue-200">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-500 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-neutral-800">Daftar Anak 📋</h4>
                    <p class="text-sm text-neutral-500">Lihat semua data</p>
                </div>
            </div>
        </a>

        <!-- Resep Sehat -->
        <a href="{{ route('recipes.index') }}"
            class="card-cute p-4 hover:shadow-soft hover:-translate-y-1 transition-all duration-300 group border-2 border-warm-100 hover:border-warm-200">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-warm-400 to-warm-500 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-neutral-800">Resep Sehat 🍎</h4>
                    <p class="text-sm text-neutral-500">Menu bergizi</p>
                </div>
            </div>
        </a>

        @if(in_array($user->role, ['admin','puskesmas']))
        <!-- Tambah Posyandu -->
        <a href="{{ route('posyandu.create') }}"
            class="card-cute p-4 hover:shadow-soft hover:-translate-y-1 transition-all duration-300 group border-2 border-indigo-100 hover:border-indigo-200">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-400 to-indigo-500 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-neutral-800">Tambah Posyandu 🏥</h4>
                    <p class="text-sm text-neutral-500">Daftar lokasi baru</p>
                </div>
            </div>
        </a>
        @endif
    </div>
</div>

<!-- 📊 Stats Grid -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Total Anak -->
    <div class="stat-card">
        <div class="stat-icon bg-gradient-primary shadow-soft">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </div>
        <div>
            <p class="stat-label">Total Anak 👶</p>
            <p class="stat-value">{{ number_format($stats['total_anak']) }}</p>
        </div>
    </div>

    <!-- Total Ibu -->
    <div class="stat-card">
        <div class="stat-icon bg-gradient-to-br from-accent-400 to-accent-500 shadow-dreamy">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
        <div>
            <p class="stat-label">Total Ibu 👩</p>
            <p class="stat-value">{{ number_format($stats['total_ibu']) }}</p>
        </div>
    </div>

    <!-- Total Posyandu -->
    <div class="stat-card">
        <div class="stat-icon bg-gradient-to-br from-blue-400 to-blue-500">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
        <div>
            <p class="stat-label">Posyandu 🏥</p>
            <p class="stat-value">{{ number_format($stats['total_posyandu']) }}</p>
        </div>
    </div>

    <!-- Total Pengukuran -->
    <div class="stat-card">
        <div class="stat-icon bg-gradient-to-br from-secondary-400 to-secondary-500">
            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
        </div>
        <div>
            <p class="stat-label">Pengukuran 📏</p>
            <p class="stat-value">{{ number_format($stats['total_pengukuran']) }}</p>
        </div>
    </div>
</div>

<!-- 🍎 Status Gizi -->
<div class="card-cute p-6 mb-6">
    <div class="mb-5">
        <h3 class="text-lg font-bold text-neutral-800 font-heading flex items-center gap-2">
            <span>🍎</span> Status Gizi Anak
        </h3>
        <p class="text-sm text-neutral-500 mt-1">Berdasarkan pengukuran terakhir per anak</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        @foreach($statusConfig as $key => $config)
        @php
        $colorMap = [
        'green' => ['bg' => 'bg-gradient-to-br from-secondary-50 to-secondary-100', 'text' => 'text-secondary-600',
        'border' => 'border-secondary-200'],
        'yellow' => ['bg' => 'bg-gradient-to-br from-warm-50 to-warm-100', 'text' => 'text-warm-600', 'border' =>
        'border-warm-200'],
        'orange' => ['bg' => 'bg-gradient-to-br from-orange-50 to-orange-100', 'text' => 'text-orange-600', 'border' =>
        'border-orange-200'],
        'red' => ['bg' => 'bg-gradient-to-br from-red-50 to-red-100', 'text' => 'text-red-500', 'border' =>
        'border-red-200'],
        ];
        $colors = $colorMap[$config['color']] ?? ['bg' => 'bg-neutral-50', 'text' => 'text-neutral-700', 'border' =>
        'border-neutral-200'];
        @endphp
        <div
            class="rounded-2xl p-4 {{ $colors['bg'] }} border-2 {{ $colors['border'] }} text-center hover:shadow-soft transition-all duration-300 hover:-translate-y-0.5">
            <div class="text-3xl font-bold {{ $colors['text'] }} mb-1 font-heading">
                {{ $giziStats[$key] ?? 0 }}
            </div>
            <div class="text-sm font-semibold text-neutral-600">{{ $config['label'] }}</div>
        </div>
        @endforeach
    </div>

    <!-- Info Helper -->
    <div class="mt-5 p-4 bg-gradient-to-r from-accent-50 to-primary-50 rounded-2xl border-2 border-accent-100">
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 bg-accent-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-sm text-neutral-600">
                <strong class="text-neutral-700">Catatan:</strong> Status gizi dihitung berdasarkan standar WHO (Tinggi
                Badan per Umur). Pastikan
                rutin melakukan pengukuran minimal 1 bulan sekali ya! 💪✨
            </p>
        </div>
    </div>
</div>

<!-- 📋 Recent Measurements -->
<div class="card-cute p-6">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h3 class="text-lg font-bold text-neutral-800 font-heading flex items-center gap-2">
                <span>📋</span> Pengukuran Terbaru
            </h3>
            <p class="text-sm text-neutral-500 mt-1">5 pengukuran terakhir yang dicatat</p>
        </div>
        <a href="{{ route('measurements.index') }}" class="btn-primary btn-sm hidden sm:inline-flex">
            Lihat Semua
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <div class="space-y-3">
        @forelse($recentMeasurements as $m)
        <div
            class="flex items-center gap-4 p-4 bg-gradient-to-r from-primary-50/50 to-accent-50/30 rounded-2xl hover:from-primary-50 hover:to-accent-50/50 transition-all duration-300 border border-primary-100/50">
            <div
                class="w-14 h-14 bg-gradient-primary rounded-2xl flex items-center justify-center text-white font-bold text-lg flex-shrink-0 shadow-soft">
                {{ strtoupper(substr($m->child->name ?? 'A', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-bold text-neutral-800 truncate">{{ $m->child->name ?? 'N/A' }}</div>
                <div class="flex flex-wrap items-center gap-3 text-sm text-neutral-500 mt-1">
                    <span class="flex items-center gap-1 font-medium">
                        <svg class="w-4 h-4 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                        </svg>
                        {{ number_format($m->weight, 1) }} kg
                    </span>
                    <span class="flex items-center gap-1 font-medium">
                        <svg class="w-4 h-4 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                        </svg>
                        {{ number_format($m->height, 1) }} cm
                    </span>
                    <span class="flex items-center gap-1 text-neutral-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $m->measured_at->format('d M Y') }}
                    </span>
                </div>
            </div>
            <div class="flex-shrink-0">
                @php
                $badgeClass = $badgeClasses[$m->nutrition_status] ?? 'badge-neutral';
                @endphp
                <span class="badge {{ $badgeClass }}">
                    {{ ucwords(str_replace('_', ' ', $m->nutrition_status)) }}
                </span>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-state-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <h4 class="empty-state-title">Belum ada data pengukuran 📏</h4>
            <p class="empty-state-text">Yuk, mulai catat pengukuran anak sekarang!</p>
            <a href="{{ route('measurements.create') }}" class="btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pengukuran Pertama ✨
            </a>
        </div>
        @endforelse
    </div>

    @if($recentMeasurements->count() > 0)
    <div class="mt-5 text-center sm:hidden">
        <a href="{{ route('measurements.index') }}" class="btn-primary">
            Lihat Semua Pengukuran
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
    @endif
</div>

@endsection