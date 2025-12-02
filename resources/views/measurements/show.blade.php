@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="page-title">Detail Pengukuran</h1>
            <p class="page-subtitle">Informasi lengkap hasil pengukuran</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('measurements.edit', $measurement) }}" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <form method="post" action="{{ route('measurements.destroy', $measurement) }}" x-data
                @submit.prevent="if(confirm('Hapus pengukuran ini?')) $el.submit()" class="inline">
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

<!-- Child Info Card -->
<div class="card card-padding mb-6">
    <div class="flex flex-col md:flex-row md:items-center gap-4">
        <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
        <div class="flex-1">
            <h2 class="text-xl font-bold text-neutral-900 mb-2">
                <a href="{{ route('children.show', $measurement->child) }}" class="text-primary-600 hover:underline">
                    {{ $measurement->child->name }}
                </a>
            </h2>
            <div class="flex flex-wrap gap-4 text-sm text-neutral-600">
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    {{ optional($measurement->child->mother)->name ?? '-' }}
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    {{ optional($measurement->child->posyandu)->name ?? '-' }}
                </span>
            </div>
        </div>
        <div class="flex-shrink-0">
            <span
                class="inline-flex items-center gap-2 bg-primary-100 text-primary-800 px-4 py-2 rounded-full font-semibold text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ \Illuminate\Support\Carbon::parse($measurement->measured_at)->format('d M Y') }}
            </span>
        </div>
    </div>
</div>

<!-- Measurement Data Grid -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <!-- Berat Badan -->
    <div class="card card-padding text-center">
        <div class="w-10 h-10 mx-auto mb-2 rounded-full bg-blue-100 flex items-center justify-center">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
            </svg>
        </div>
        <div class="text-xs text-neutral-500 mb-1">Berat Badan</div>
        <div class="text-2xl font-bold text-neutral-900">{{ number_format($measurement->weight, 2) }}</div>
        <div class="text-xs text-neutral-500 mt-1">kg</div>
    </div>

    <!-- Tinggi/Panjang -->
    <div class="card card-padding text-center">
        <div class="w-10 h-10 mx-auto mb-2 rounded-full bg-indigo-100 flex items-center justify-center">
            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
            </svg>
        </div>
        <div class="text-xs text-neutral-500 mb-1">TB/PB</div>
        <div class="text-2xl font-bold text-neutral-900">{{ number_format($measurement->height, 2) }}</div>
        <div class="text-xs text-neutral-500 mt-1">cm</div>
    </div>

    <!-- Lingkar Kepala -->
    <div class="card card-padding text-center">
        <div class="w-10 h-10 mx-auto mb-2 rounded-full bg-pink-100 flex items-center justify-center">
            <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
        </div>
        <div class="text-xs text-neutral-500 mb-1">Lingkar Kepala</div>
        <div class="text-2xl font-bold text-neutral-900">
            {{ $measurement->head_circumference ? number_format($measurement->head_circumference, 2) : '-' }}
        </div>
        <div class="text-xs text-neutral-500 mt-1">cm</div>
    </div>

    <!-- Usia -->
    <div class="card card-padding text-center">
        <div class="w-10 h-10 mx-auto mb-2 rounded-full bg-green-100 flex items-center justify-center">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="text-xs text-neutral-500 mb-1">Usia Saat Ukur</div>
        <div class="text-2xl font-bold text-neutral-900">{{ $measurement->age_months }}</div>
        <div class="text-xs text-neutral-500 mt-1">bulan</div>
    </div>
</div>

<!-- Z-Score Grid -->
<div class="card card-padding mb-6">
    <h3 class="text-lg font-bold text-neutral-900 flex items-center gap-2 mb-4">
        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
        </svg>
        Nilai Z-Score (WHO)
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Z BB/U -->
        <div class="bg-neutral-50 rounded-lg p-4 border border-neutral-200">
            <div class="text-xs text-neutral-600 mb-1 font-medium">Z-Score BB/U</div>
            <div class="text-xl font-bold text-neutral-800">
                {{ $measurement->weight_for_age_z !== null ? number_format($measurement->weight_for_age_z, 2) : '-' }}
            </div>
            <div class="text-xs text-neutral-500 mt-1">Berat Badan menurut Usia</div>
        </div>

        <!-- Z TB/U -->
        <div class="bg-neutral-50 rounded-lg p-4 border border-neutral-200">
            <div class="text-xs text-neutral-600 mb-1 font-medium">Z-Score TB/U</div>
            <div
                class="text-xl font-bold {{ $measurement->height_for_age_z !== null && $measurement->height_for_age_z < -2 ? 'text-red-600' : 'text-neutral-800' }}">
                {{ $measurement->height_for_age_z !== null ? number_format($measurement->height_for_age_z, 2) : '-' }}
            </div>
            <div class="text-xs text-neutral-500 mt-1">Tinggi Badan menurut Usia</div>
        </div>

        <!-- Z BB/TB -->
        <div class="bg-neutral-50 rounded-lg p-4 border border-neutral-200">
            <div class="text-xs text-neutral-600 mb-1 font-medium">Z-Score BB/TB</div>
            <div class="text-xl font-bold text-neutral-800">
                {{ $measurement->weight_for_height_z !== null ? number_format($measurement->weight_for_height_z, 2) : '-' }}
            </div>
            <div class="text-xs text-neutral-500 mt-1">Berat Badan menurut Tinggi</div>
        </div>
    </div>
</div>

<!-- Nutrition Status -->
<div class="card card-padding mb-6">
    <h3 class="text-lg font-bold text-neutral-900 flex items-center gap-2 mb-4">
        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Status Gizi (TB/U)
    </h3>

    <div class="flex items-center gap-3 mb-4">
        @if ($measurement->nutrition_status === 'severe')
        <span class="badge badge-danger text-base px-4 py-2">Sangat Pendek (Severe Stunting)</span>
        @elseif ($measurement->nutrition_status === 'stunting')
        <span class="badge badge-warning text-base px-4 py-2">Pendek (Stunting)</span>
        @elseif ($measurement->nutrition_status === 'normal')
        <span class="badge badge-success text-base px-4 py-2">Normal</span>
        @else
        <span class="badge badge-neutral text-base px-4 py-2">Belum Terklasifikasi</span>
        @endif
    </div>

    <!-- Status Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="flex-1 text-sm text-blue-800">
                @if ($measurement->nutrition_status === 'severe')
                <strong>Perhatian Serius!</strong> Anak mengalami stunting parah (Z-Score &lt; -3 SD). Segera
                konsultasikan dengan tenaga kesehatan untuk intervensi gizi dan tumbuh kembang.
                @elseif ($measurement->nutrition_status === 'stunting')
                <strong>Perlu Perhatian!</strong> Anak mengalami stunting ringan (Z-Score -3 SD hingga -2 SD).
                Tingkatkan asupan gizi dan lakukan monitoring rutin.
                @elseif ($measurement->nutrition_status === 'normal')
                <strong>Bagus!</strong> Tinggi badan anak sesuai dengan usianya (Z-Score ≥ -2 SD). Pertahankan pola asuh
                dan gizi yang baik.
                @else
                Data belum dapat diklasifikasikan. Pastikan data pengukuran lengkap dan akurat.
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Notes Section -->
@if ($measurement->notes)
<div class="card card-padding mb-6">
    <h3 class="text-lg font-bold text-neutral-900 flex items-center gap-2 mb-4">
        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        Catatan
    </h3>
    <div class="bg-neutral-50 rounded-lg p-4 border border-neutral-200 whitespace-pre-line text-neutral-700">
        {{ $measurement->notes }}
    </div>
</div>
@endif

<!-- Action Buttons -->
<div class="flex items-center gap-3">
    <a href="{{ route('children.show', $measurement->child) }}" class="btn-secondary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Detail Anak
    </a>
    <a href="{{ route('measurements.index') }}" class="btn-ghost">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        Semua Pengukuran
    </a>
</div>

@endsection