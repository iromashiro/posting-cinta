@extends('layouts.app')

@section('content')
@php
$indicatorLabels = [
'wfa' => 'BB/U (Berat Badan menurut Umur)',
'hfa' => 'TB/U (Tinggi Badan menurut Umur)',
'wfh' => 'BB/TB (Berat Badan menurut Tinggi)',
];
$indicatorShort = [
'wfa' => 'BB/U',
'hfa' => 'TB/U',
'wfh' => 'BB/TB',
];
@endphp

<!-- Page Header -->
<div class="page-header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="page-title">Detail Standar WHO</h1>
            <p class="page-subtitle">Data referensi LMS untuk perhitungan Z-Score</p>
        </div>
        <a href="{{ route('growth-standards.index') }}" class="btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="card card-padding">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-neutral-500">Indikator</p>
                <p class="font-semibold text-neutral-900">
                    {{ $indicatorShort[$growthStandard->indicator] ?? strtoupper($growthStandard->indicator) }}
                </p>
                <p class="text-xs text-neutral-500">{{ $indicatorLabels[$growthStandard->indicator] ?? '' }}</p>
            </div>
        </div>
    </div>

    <div class="card card-padding">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-neutral-500">Jenis Kelamin</p>
                @if($growthStandard->gender === 'male')
                <span class="badge badge-info">Laki-laki</span>
                @else
                <span class="badge badge-primary">Perempuan</span>
                @endif
            </div>
        </div>
    </div>

    <div class="card card-padding">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-secondary-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-neutral-500">Usia / Tinggi Badan</p>
                <p class="font-semibold text-neutral-900">
                    @if($growthStandard->age_months !== null)
                    {{ $growthStandard->age_months }} bulan
                    @elseif($growthStandard->length_height_cm !== null)
                    {{ number_format($growthStandard->length_height_cm, 1) }} cm
                    @else
                    -
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<!-- LMS Values -->
<div class="card card-padding">
    <h3 class="font-semibold text-neutral-900 mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
        </svg>
        Nilai LMS
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-center">
            <div class="w-12 h-12 mx-auto rounded-full bg-amber-100 flex items-center justify-center mb-3">
                <span class="text-lg font-bold text-amber-700">L</span>
            </div>
            <p class="text-xs text-amber-600 mb-1">Lambda (Box-Cox Power)</p>
            <p class="text-2xl font-bold text-amber-800 font-mono">{{ number_format($growthStandard->l, 5) }}</p>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
            <div class="w-12 h-12 mx-auto rounded-full bg-blue-100 flex items-center justify-center mb-3">
                <span class="text-lg font-bold text-blue-700">M</span>
            </div>
            <p class="text-xs text-blue-600 mb-1">Mu (Median)</p>
            <p class="text-2xl font-bold text-blue-800 font-mono">{{ number_format($growthStandard->m, 4) }}</p>
        </div>

        <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
            <div class="w-12 h-12 mx-auto rounded-full bg-green-100 flex items-center justify-center mb-3">
                <span class="text-lg font-bold text-green-700">S</span>
            </div>
            <p class="text-xs text-green-600 mb-1">Sigma (Coefficient of Variation)</p>
            <p class="text-2xl font-bold text-green-800 font-mono">{{ number_format($growthStandard->s, 5) }}</p>
        </div>
    </div>
</div>

<!-- Formula Info -->
<div class="mt-6 card card-padding bg-neutral-50 border-neutral-200">
    <h4 class="font-semibold text-neutral-900 mb-3 flex items-center gap-2">
        <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
        </svg>
        Rumus Z-Score
    </h4>
    <div class="bg-white rounded-lg p-4 border border-neutral-200">
        <p class="text-sm text-neutral-700 mb-2">Z-Score dihitung dengan formula:</p>
        <div class="bg-neutral-100 rounded p-3 font-mono text-sm text-center">
            Z = [(Y/M)<sup>L</sup> - 1] / (L × S)
        </div>
        <p class="text-xs text-neutral-500 mt-2">
            Dimana Y adalah nilai pengukuran aktual (berat atau tinggi badan)
        </p>
    </div>
</div>

<!-- Info Box -->
<div class="mt-6 card card-padding bg-blue-50 border-blue-200">
    <div class="flex items-start gap-3">
        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="flex-1">
            <h4 class="font-semibold text-blue-900 mb-1">Interpretasi Z-Score</h4>
            <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                <li><strong>Z &lt; -3:</strong> Sangat pendek/kurus (severe)</li>
                <li><strong>-3 ≤ Z &lt; -2:</strong> Pendek/kurus (moderate)</li>
                <li><strong>-2 ≤ Z ≤ +2:</strong> Normal</li>
                <li><strong>Z &gt; +2:</strong> Tinggi/gemuk (di atas normal)</li>
            </ul>
        </div>
    </div>
</div>

@endsection