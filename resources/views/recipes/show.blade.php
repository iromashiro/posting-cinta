@extends('layouts.app')

@section('content')
@php
$ageMap = [
'mpasi_6_12' => 'MPASI (6-12 bulan)',
'balita_1_3' => 'Balita (1-3 tahun)',
'anak_3_5' => 'Anak (3-5 tahun)'
];
$categoryColors = [
'mpasi_6_12' => 'badge-primary',
'balita_1_3' => 'badge-info',
'anak_3_5' => 'badge-success',
];
@endphp

<!-- Page Header -->
<div class="page-header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="page-title">{{ $recipe->title }}</h1>
            <p class="page-subtitle">Detail resep makanan sehat</p>
        </div>
        <a href="{{ route('recipes.index') }}" class="btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>
</div>

<!-- Recipe Content -->
<div class="card overflow-hidden">
    <div class="md:flex">
        <!-- Image Section -->
        <div class="md:w-2/5 bg-neutral-100 flex items-center justify-center min-h-[300px]">
            @if ($recipe->image_path)
            <img src="{{ asset($recipe->image_path) }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover">
            @else
            <div class="flex flex-col items-center justify-center text-neutral-400 p-6">
                <svg class="w-16 h-16 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-sm">Tidak ada gambar</span>
            </div>
            @endif
        </div>

        <!-- Content Section -->
        <div class="md:w-3/5 p-6">
            <!-- Category Badge -->
            <div class="mb-4">
                <span class="badge {{ $categoryColors[$recipe->age_category] ?? 'badge-neutral' }}">
                    {{ $ageMap[$recipe->age_category] ?? ucfirst(str_replace('_',' ',$recipe->age_category)) }}
                </span>
            </div>

            <!-- Title -->
            <h2 class="text-2xl font-bold text-neutral-900 mb-4">{{ $recipe->title }}</h2>

            <!-- Nutrition Info -->
            <div class="mb-6">
                <h3 class="font-semibold text-neutral-800 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Informasi Gizi
                </h3>
                <div class="flex flex-wrap gap-2">
                    @if(!is_null($recipe->calories))
                    <div class="bg-amber-50 border border-amber-200 rounded-lg px-3 py-2">
                        <p class="text-xs text-amber-600">Kalori</p>
                        <p class="font-semibold text-amber-800">{{ $recipe->calories }} kkal</p>
                    </div>
                    @endif
                    @if(!is_null($recipe->protein))
                    <div class="bg-green-50 border border-green-200 rounded-lg px-3 py-2">
                        <p class="text-xs text-green-600">Protein</p>
                        <p class="font-semibold text-green-800">{{ $recipe->protein }} g</p>
                    </div>
                    @endif
                    @if(!is_null($recipe->carbohydrate))
                    <div class="bg-blue-50 border border-blue-200 rounded-lg px-3 py-2">
                        <p class="text-xs text-blue-600">Karbohidrat</p>
                        <p class="font-semibold text-blue-800">{{ $recipe->carbohydrate }} g</p>
                    </div>
                    @endif
                </div>

                @if (is_array($recipe->nutrition_info) && count($recipe->nutrition_info))
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach ($recipe->nutrition_info as $k => $v)
                    <span class="badge badge-neutral">{{ ucfirst($k) }}: {{ $v }}</span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Ingredients & Instructions -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <!-- Bahan-bahan -->
    <div class="card card-padding">
        <h3 class="font-semibold text-neutral-900 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            Bahan-bahan
        </h3>
        <div class="bg-neutral-50 rounded-lg p-4 border border-neutral-200">
            <div class="prose prose-sm max-w-none text-neutral-700">
                {!! nl2br(e($recipe->ingredients)) !!}
            </div>
        </div>
    </div>

    <!-- Cara Memasak -->
    <div class="card card-padding">
        <h3 class="font-semibold text-neutral-900 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
            </svg>
            Cara Memasak
        </h3>
        <div class="bg-neutral-50 rounded-lg p-4 border border-neutral-200">
            <div class="prose prose-sm max-w-none text-neutral-700">
                {!! nl2br(e($recipe->instructions)) !!}
            </div>
        </div>
    </div>
</div>

<!-- Tips Box -->
<div class="mt-6 card card-padding bg-green-50 border-green-200">
    <div class="flex items-start gap-3">
        <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
            </svg>
        </div>
        <div class="flex-1">
            <h4 class="font-semibold text-green-900 mb-1">Tips Penyajian</h4>
            <p class="text-sm text-green-800">
                Sajikan makanan dalam keadaan hangat dan dalam porsi yang sesuai dengan usia anak.
                Pastikan tekstur makanan sudah sesuai dengan kemampuan mengunyah anak.
            </p>
        </div>
    </div>
</div>

@endsection