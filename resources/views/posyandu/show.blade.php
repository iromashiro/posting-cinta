@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="page-title">{{ $posyandu->name }}</h1>
            <p class="page-subtitle">Detail informasi posyandu</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('posyandu.edit', $posyandu) }}" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <form method="post" action="{{ route('posyandu.destroy', $posyandu) }}" x-data
                @submit.prevent="if(confirm('Hapus posyandu {{ $posyandu->name }}?')) $el.submit()">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="card card-padding">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-neutral-500">Puskesmas</p>
                <p class="font-semibold text-neutral-900">{{ optional($posyandu->puskesmas)->name ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="card card-padding">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-secondary-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-neutral-500">Kader PJ</p>
                <p class="font-semibold text-neutral-900">{{ optional($posyandu->kader)->name ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div class="card card-padding">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-neutral-500">Status</p>
                @if ($posyandu->is_active)
                <span class="badge badge-success">Aktif</span>
                @else
                <span class="badge badge-neutral">Nonaktif</span>
                @endif
            </div>
        </div>
    </div>

    <div class="card card-padding">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-neutral-500">Telepon</p>
                <p class="font-semibold text-neutral-900">{{ $posyandu->phone ?: '-' }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column - Detail Info -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Alamat Section -->
        <div class="card card-padding">
            <h3 class="font-semibold text-neutral-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Informasi Lokasi
            </h3>

            <div class="space-y-4">
                <div>
                    <p class="text-xs text-neutral-500 mb-1">Alamat Lengkap</p>
                    <div class="bg-neutral-50 rounded-lg p-3 border border-neutral-200 min-h-[64px]">
                        {{ $posyandu->address ?: 'Belum diisi' }}
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-neutral-500 mb-1">Desa/Kelurahan</p>
                        <div class="bg-neutral-50 rounded-lg p-3 border border-neutral-200">
                            {{ $posyandu->village ?: '-' }}
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-neutral-500 mb-1">Kecamatan</p>
                        <div class="bg-neutral-50 rounded-lg p-3 border border-neutral-200">
                            {{ $posyandu->district ?: '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Statistics -->
    <div class="space-y-6">
        <!-- Statistik -->
        <div class="card card-padding">
            <h3 class="font-semibold text-neutral-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Statistik Data
            </h3>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-primary-50 rounded-lg p-4 text-center border border-primary-100">
                    <div class="text-3xl font-bold text-primary-700">{{ $posyandu->mothers->count() }}</div>
                    <div class="text-xs text-primary-600 mt-1">Ibu Terdata</div>
                </div>
                <div class="bg-secondary-50 rounded-lg p-4 text-center border border-secondary-100">
                    <div class="text-3xl font-bold text-secondary-700">{{ $posyandu->children->count() }}</div>
                    <div class="text-xs text-secondary-600 mt-1">Anak Terdata</div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="card card-padding">
            <h3 class="font-semibold text-neutral-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
                Aksi Cepat
            </h3>

            <div class="space-y-2">
                <a href="{{ route('mothers.index', ['posyandu_id' => $posyandu->id]) }}"
                    class="flex items-center gap-3 p-3 rounded-lg hover:bg-neutral-50 transition-colors border border-neutral-200">
                    <div class="w-8 h-8 rounded-lg bg-primary-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-neutral-800">Lihat Daftar Ibu</p>
                        <p class="text-xs text-neutral-500">{{ $posyandu->mothers->count() }} ibu terdaftar</p>
                    </div>
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="{{ route('children.index', ['posyandu_id' => $posyandu->id]) }}"
                    class="flex items-center gap-3 p-3 rounded-lg hover:bg-neutral-50 transition-colors border border-neutral-200">
                    <div class="w-8 h-8 rounded-lg bg-secondary-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-neutral-800">Lihat Daftar Anak</p>
                        <p class="text-xs text-neutral-500">{{ $posyandu->children->count() }} anak terdaftar</p>
                    </div>
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Back Button -->
<div class="mt-6">
    <a href="{{ route('posyandu.index') }}" class="btn-secondary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Daftar
    </a>
</div>

@endsection