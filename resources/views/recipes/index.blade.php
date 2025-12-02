@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="page-title">Resep Makanan Sehat</h1>
            <p class="page-subtitle">Kumpulan resep bergizi untuk tumbuh kembang optimal</p>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card card-padding mb-6">
    <div class="flex items-center gap-2 mb-4">
        <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <h3 class="font-semibold text-neutral-800">Filter & Pencarian</h3>
    </div>

    <form method="get" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Search Box -->
        <div>
            <input type="text" name="q" value="{{ $q }}" placeholder="Cari judul resep..." class="input-field">
        </div>

        <!-- Age Category Filter -->
        <div>
            <select name="age_category" class="input-field">
                <option value="">Semua Kelompok Usia</option>
                @foreach ($ageCategories as $key => $label)
                <option value="{{ $key }}" @selected($age==$key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-2">
            <button type="submit" class="btn-primary flex-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Cari
            </button>
            <a href="{{ route('recipes.index') }}" class="btn-secondary flex-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Empty State atau Recipe Cards -->
@if ($items->count() === 0)
<div class="card card-padding text-center">
    <div class="py-8">
        <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        <h3 class="text-lg font-semibold text-neutral-800 mb-2">Belum Ada Resep</h3>
        <p class="text-neutral-600 mb-6">
            @if($q || $age)
            Tidak ada resep yang cocok dengan filter Anda. Coba ubah kriteria pencarian.
            @else
            Belum ada resep yang dipublikasikan saat ini.
            @endif
        </p>
    </div>
</div>
@else
<!-- Stats Info -->
<div class="card card-padding mb-4">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center">
            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
        </div>
        <div>
            <p class="text-sm text-neutral-500">Total Resep Tersedia</p>
            <p class="text-xl font-bold text-neutral-900">{{ $items->total() }} Resep</p>
        </div>
    </div>
</div>

<!-- Recipe Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($items as $item)
    <a href="{{ route('recipes.show', $item) }}" class="card overflow-hidden group">
        <!-- Image -->
        <div class="h-48 bg-neutral-100 flex items-center justify-center overflow-hidden">
            @if ($item->image_path)
            <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}"
                class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
            @else
            <div class="flex flex-col items-center justify-center text-neutral-400">
                <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-sm">Tidak ada gambar</span>
            </div>
            @endif
        </div>

        <!-- Content -->
        <div class="p-4">
            <div class="flex items-center gap-2 mb-2">
                @php
                $categoryColors = [
                'mpasi_6_12' => 'badge-primary',
                'balita_1_3' => 'badge-info',
                'anak_3_5' => 'badge-success',
                ];
                $categoryClass = $categoryColors[$item->age_category] ?? 'badge-neutral';
                @endphp
                <span class="badge {{ $categoryClass }}">
                    {{ $ageCategories[$item->age_category] ?? ucfirst(str_replace('_',' ',$item->age_category)) }}
                </span>
            </div>

            <h3 class="font-semibold text-neutral-900 group-hover:text-primary-600 transition-colors">
                {{ $item->title }}
            </h3>

            @if($item->calories || $item->protein)
            <div class="flex items-center gap-3 mt-3 text-xs text-neutral-500">
                @if($item->calories)
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                    </svg>
                    {{ $item->calories }} kkal
                </span>
                @endif
                @if($item->protein)
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    {{ $item->protein }}g protein
                </span>
                @endif
            </div>
            @endif
        </div>
    </a>
    @endforeach
</div>

<!-- Pagination -->
@if($items->hasPages())
<div class="mt-6">
    {{ $items->links() }}
</div>
@endif
@endif

<!-- Tips Box -->
<div class="mt-6 card card-padding bg-blue-50 border-blue-200">
    <div class="flex items-start gap-3">
        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="flex-1">
            <h4 class="font-semibold text-blue-900 mb-1">Tips Nutrisi Anak</h4>
            <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                <li><strong>MPASI (6-12 bulan):</strong> Tekstur halus, perkenalkan berbagai rasa</li>
                <li><strong>Balita (1-3 tahun):</strong> Porsi kecil, frekuensi sering, variasi makanan</li>
                <li><strong>Anak (3-5 tahun):</strong> Seimbangkan karbohidrat, protein, dan sayuran</li>
            </ul>
        </div>
    </div>
</div>

@endsection