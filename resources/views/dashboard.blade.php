@extends('layouts.app')

@php
// Header untuk layout
$header = 'Dashboard';
$headerIcon = '🏠';

// Mapping warna badge status gizi
$badgeColors = [
'gizi_buruk' => 'bg-red-100 text-red-700 border-2 border-red-300',
'gizi_kurang' => 'bg-orange-100 text-orange-700 border-2 border-orange-300',
'gizi_baik' => 'bg-green-100 text-green-700 border-2 border-green-300',
'berisiko_gizi_lebih' => 'bg-yellow-100 text-yellow-700 border-2 border-yellow-300',
'gizi_lebih' => 'bg-amber-100 text-amber-700 border-2 border-amber-300',
'severe' => 'bg-red-100 text-red-700 border-2 border-red-300',
'stunting' => 'bg-orange-100 text-orange-700 border-2 border-orange-300',
'normal' => 'bg-green-100 text-green-700 border-2 border-green-300',
];
@endphp

@section('content')

<!-- Welcome Banner - Super cute & personal -->
<div
    class="mb-8 bg-gradient-to-r from-pink-400 via-purple-400 to-pink-400 rounded-3xl p-8 text-white shadow-2xl relative overflow-hidden">
    <div class="absolute top-0 right-0 text-9xl opacity-10">💕</div>
    <div class="relative z-10">
        <div class="flex items-start justify-between gap-4">
            <div class="flex-1">
                <div
                    class="inline-block px-4 py-1.5 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium mb-4">
                    {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </div>
                <h2 class="text-3xl md:text-4xl font-bold mb-3">
                    Hai, {{ $user->name }}! 👋✨
                </h2>
                <p class="text-lg text-pink-100 mb-4">
                    Selamat datang kembali! Yuk pantau tumbuh kembang anak dengan cinta 💖
                </p>
                <div class="flex flex-wrap gap-2">
                    <span class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium">
                        👤 {{ ucfirst($user->role) }}
                    </span>
                    <span class="inline-block px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium">
                        🎯 Aktif Hari Ini
                    </span>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="w-32 h-32 bg-white/10 backdrop-blur-sm rounded-3xl flex items-center justify-center">
                    <span class="text-7xl">💕</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Helpful Tips - Onboarding guidance -->
<div class="mb-8 bg-gradient-to-r from-blue-100 to-cyan-100 rounded-3xl p-6 border-4 border-blue-200 shadow-lg">
    <div class="flex items-start gap-4">
        <div class="flex-shrink-0 text-4xl">💡</div>
        <div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Tips Penggunaan Aplikasi</h3>
            <p class="text-gray-700 text-sm leading-relaxed mb-3">
                <strong>Langkah mudah:</strong> 1️⃣ Daftarkan data Ibu → 2️⃣ Tambahkan data Anak → 3️⃣ Input hasil
                pengukuran secara berkala → 4️⃣ Lihat grafik pertumbuhan! 📈
            </p>
            <div class="flex flex-wrap gap-2">
                <span
                    class="inline-block px-3 py-1.5 bg-white rounded-full text-xs font-semibold text-blue-700 shadow-sm">
                    ✅ Mudah digunakan
                </span>
                <span
                    class="inline-block px-3 py-1.5 bg-white rounded-full text-xs font-semibold text-blue-700 shadow-sm">
                    📱 Bisa offline
                </span>
                <span
                    class="inline-block px-3 py-1.5 bg-white rounded-full text-xs font-semibold text-blue-700 shadow-sm">
                    🔒 Data aman
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions - Lebih visual & jelas -->
<div class="bg-white rounded-3xl p-6 shadow-xl border-4 border-pink-100 mb-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <span class="text-2xl">⚡</span>
                Aksi Cepat
            </h3>
            <p class="text-sm text-gray-600 mt-1">Pilih menu di bawah untuk memulai</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Tambah Pengukuran -->
        <a href="{{ route('measurements.create') }}"
            class="group relative overflow-hidden bg-gradient-to-br from-pink-100 to-purple-100 hover:from-pink-200 hover:to-purple-200 rounded-2xl p-6 border-3 border-pink-300 shadow-lg hover:shadow-xl transition-all active:scale-95">
            <div class="flex flex-col items-center text-center gap-3">
                <div
                    class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                    <span class="text-4xl">📊</span>
                </div>
                <div>
                    <div class="font-bold text-gray-800 text-lg mb-1">Input Pengukuran</div>
                    <div class="text-xs text-gray-600">Catat BB & TB anak</div>
                </div>
            </div>
        </a>

        <!-- Tambah Anak -->
        <a href="{{ route('children.create') }}"
            class="group relative overflow-hidden bg-gradient-to-br from-blue-100 to-cyan-100 hover:from-blue-200 hover:to-cyan-200 rounded-2xl p-6 border-3 border-blue-300 shadow-lg hover:shadow-xl transition-all active:scale-95">
            <div class="flex flex-col items-center text-center gap-3">
                <div
                    class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                    <span class="text-4xl">👶</span>
                </div>
                <div>
                    <div class="font-bold text-gray-800 text-lg mb-1">Daftar Anak Baru</div>
                    <div class="text-xs text-gray-600">Tambah data anak</div>
                </div>
            </div>
        </a>

        <!-- Tambah Ibu -->
        <a href="{{ route('mothers.create') }}"
            class="group relative overflow-hidden bg-gradient-to-br from-purple-100 to-pink-100 hover:from-purple-200 hover:to-pink-200 rounded-2xl p-6 border-3 border-purple-300 shadow-lg hover:shadow-xl transition-all active:scale-95">
            <div class="flex flex-col items-center text-center gap-3">
                <div
                    class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                    <span class="text-4xl">👩</span>
                </div>
                <div>
                    <div class="font-bold text-gray-800 text-lg mb-1">Daftar Ibu Baru</div>
                    <div class="text-xs text-gray-600">Tambah data ibu</div>
                </div>
            </div>
        </a>

        <!-- Lihat Data Anak -->
        <a href="{{ route('children.index') }}"
            class="group relative overflow-hidden bg-gradient-to-br from-green-100 to-emerald-100 hover:from-green-200 hover:to-emerald-200 rounded-2xl p-6 border-3 border-green-300 shadow-lg hover:shadow-xl transition-all active:scale-95">
            <div class="flex flex-col items-center text-center gap-3">
                <div
                    class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                    <span class="text-4xl">📋</span>
                </div>
                <div>
                    <div class="font-bold text-gray-800 text-lg mb-1">Daftar Anak</div>
                    <div class="text-xs text-gray-600">Lihat semua data</div>
                </div>
            </div>
        </a>

        <!-- Resep Sehat -->
        <a href="{{ route('recipes.index') }}"
            class="group relative overflow-hidden bg-gradient-to-br from-orange-100 to-amber-100 hover:from-orange-200 hover:to-amber-200 rounded-2xl p-6 border-3 border-orange-300 shadow-lg hover:shadow-xl transition-all active:scale-95">
            <div class="flex flex-col items-center text-center gap-3">
                <div
                    class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                    <span class="text-4xl">🍲</span>
                </div>
                <div>
                    <div class="font-bold text-gray-800 text-lg mb-1">Resep Sehat</div>
                    <div class="text-xs text-gray-600">Menu bergizi</div>
                </div>
            </div>
        </a>

        @if(in_array($user->role, ['admin','puskesmas']))
        <!-- Tambah Posyandu -->
        <a href="{{ route('posyandu.create') }}"
            class="group relative overflow-hidden bg-gradient-to-br from-indigo-100 to-purple-100 hover:from-indigo-200 hover:to-purple-200 rounded-2xl p-6 border-3 border-indigo-300 shadow-lg hover:shadow-xl transition-all active:scale-95">
            <div class="flex flex-col items-center text-center gap-3">
                <div
                    class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                    <span class="text-4xl">🏥</span>
                </div>
                <div>
                    <div class="font-bold text-gray-800 text-lg mb-1">Tambah Posyandu</div>
                    <div class="text-xs text-gray-600">Daftar lokasi baru</div>
                </div>
            </div>
        </a>
        @endif
    </div>
</div>

<!-- Stats Grid - Lebih colorful & informative -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <!-- Total Anak -->
    <div
        class="bg-gradient-to-br from-pink-100 to-rose-100 rounded-3xl p-6 shadow-lg border-4 border-pink-200 hover:scale-105 transition-transform">
        <div class="flex flex-col items-center text-center gap-3">
            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-md">
                <span class="text-4xl">👶</span>
            </div>
            <div>
                <div class="text-4xl font-bold text-gray-800 mb-1">{{ number_format($stats['total_anak']) }}</div>
                <div class="text-sm font-semibold text-gray-700">Total Anak</div>
            </div>
        </div>
    </div>

    <!-- Total Ibu -->
    <div
        class="bg-gradient-to-br from-purple-100 to-pink-100 rounded-3xl p-6 shadow-lg border-4 border-purple-200 hover:scale-105 transition-transform">
        <div class="flex flex-col items-center text-center gap-3">
            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-md">
                <span class="text-4xl">👩</span>
            </div>
            <div>
                <div class="text-4xl font-bold text-gray-800 mb-1">{{ number_format($stats['total_ibu']) }}</div>
                <div class="text-sm font-semibold text-gray-700">Total Ibu</div>
            </div>
        </div>
    </div>

    <!-- Total Posyandu -->
    <div
        class="bg-gradient-to-br from-blue-100 to-cyan-100 rounded-3xl p-6 shadow-lg border-4 border-blue-200 hover:scale-105 transition-transform">
        <div class="flex flex-col items-center text-center gap-3">
            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-md">
                <span class="text-4xl">🏥</span>
            </div>
            <div>
                <div class="text-4xl font-bold text-gray-800 mb-1">{{ number_format($stats['total_posyandu']) }}</div>
                <div class="text-sm font-semibold text-gray-700">Posyandu</div>
            </div>
        </div>
    </div>

    <!-- Total Pengukuran -->
    <div
        class="bg-gradient-to-br from-green-100 to-emerald-100 rounded-3xl p-6 shadow-lg border-4 border-green-200 hover:scale-105 transition-transform">
        <div class="flex flex-col items-center text-center gap-3">
            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-md">
                <span class="text-4xl">📊</span>
            </div>
            <div>
                <div class="text-4xl font-bold text-gray-800 mb-1">{{ number_format($stats['total_pengukuran']) }}</div>
                <div class="text-sm font-semibold text-gray-700">Pengukuran</div>
            </div>
        </div>
    </div>
</div>

<!-- Status Gizi Chart - Lebih visual & jelas -->
<div class="bg-white rounded-3xl p-8 shadow-xl border-4 border-pink-100 mb-8">
    <div class="mb-6">
        <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-3 mb-2">
            <span class="text-3xl">📊</span>
            Status Gizi Anak
        </h3>
        <p class="text-sm text-gray-600">Berdasarkan pengukuran terakhir per anak</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        @foreach($statusConfig as $key => $config)
        <div
            class="group bg-gradient-to-br from-{{ $config['color'] }}-50 to-{{ $config['color'] }}-100 rounded-2xl p-6 border-4 border-{{ $config['color'] }}-200 text-center hover:scale-105 transition-all shadow-lg">
            <div class="text-5xl mb-3">{{ $config['icon'] }}</div>
            <div class="text-4xl font-bold text-{{ $config['color'] }}-700 mb-2">
                {{ $giziStats[$key] ?? 0 }}
            </div>
            <div class="text-sm font-bold text-gray-700">{{ $config['label'] }}</div>
        </div>
        @endforeach
    </div>

    <!-- Info Helper -->
    <div class="mt-6 bg-gradient-to-r from-blue-50 to-cyan-50 rounded-2xl p-4 border-2 border-blue-200">
        <div class="flex items-start gap-3">
            <span class="text-2xl">ℹ️</span>
            <div class="text-sm text-gray-700">
                <strong>Catatan:</strong> Status gizi dihitung berdasarkan standar WHO (Tinggi Badan per Umur). Pastikan
                rutin melakukan pengukuran minimal 1 bulan sekali ya! 💪
            </div>
        </div>
    </div>
</div>

<!-- Recent Measurements - Lebih visual -->
<div class="bg-white rounded-3xl p-8 shadow-xl border-4 border-pink-100">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                <span class="text-3xl">📝</span>
                Pengukuran Terbaru
            </h3>
            <p class="text-sm text-gray-600 mt-1">5 pengukuran terakhir yang dicatat</p>
        </div>
        <a href="{{ route('measurements.index') }}"
            class="hidden sm:inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-pink-500 to-purple-500 text-white font-bold rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all">
            Lihat Semua
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <div class="space-y-4">
        @forelse($recentMeasurements as $m)
        <div
            class="flex items-center gap-4 p-5 bg-gradient-to-r from-gray-50 to-pink-50 rounded-2xl border-2 border-pink-100 hover:border-pink-300 transition-all hover:shadow-lg">
            <div
                class="w-14 h-14 bg-gradient-to-br from-pink-400 to-purple-400 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-md flex-shrink-0">
                {{ strtoupper(substr($m->child->name ?? 'A', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-bold text-gray-800 text-lg mb-1 truncate">{{ $m->child->name ?? 'N/A' }}</div>
                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600">
                    <span class="flex items-center gap-1">
                        <span class="text-pink-500">⚖️</span>
                        <span class="font-semibold">{{ number_format($m->weight, 1) }} kg</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="text-blue-500">📏</span>
                        <span class="font-semibold">{{ number_format($m->height, 1) }} cm</span>
                    </span>
                    <span class="flex items-center gap-1 text-gray-500">
                        <span>📅</span>
                        <span>{{ $m->measured_at->format('d M Y') }}</span>
                    </span>
                </div>
            </div>
            <div class="flex-shrink-0">
                @php
                $badgeClass = $badgeColors[$m->nutrition_status] ?? 'bg-gray-100 text-gray-700 border-2
                border-gray-300';
                @endphp
                <span class="inline-block px-3 py-2 rounded-full text-xs font-bold {{ $badgeClass }}">
                    {{ ucwords(str_replace('_', ' ', $m->nutrition_status)) }}
                </span>
            </div>
        </div>
        @empty
        <div class="text-center py-16">
            <div class="text-8xl mb-4">📊</div>
            <p class="text-gray-500 text-lg font-semibold mb-4">Belum ada data pengukuran</p>
            <p class="text-gray-400 text-sm mb-6">Yuk, mulai catat pengukuran anak sekarang!</p>
            <a href="{{ route('measurements.create') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-pink-500 to-purple-500 text-white font-bold rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                <span class="text-xl">➕</span>
                Tambah Pengukuran Pertama
            </a>
        </div>
        @endforelse
    </div>

    @if($recentMeasurements->count() > 0)
    <div class="mt-6 text-center">
        <a href="{{ route('measurements.index') }}"
            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-pink-500 to-purple-500 text-white font-bold rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all sm:hidden">
            Lihat Semua Pengukuran
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>
    @endif
</div>

@endsection