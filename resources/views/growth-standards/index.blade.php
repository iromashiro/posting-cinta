@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="page-title">Standar Pertumbuhan WHO</h1>
            <p class="page-subtitle">Data referensi LMS untuk perhitungan Z-Score</p>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card card-padding mb-6">
    <div class="flex items-center gap-2 mb-4">
        <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
        </svg>
        <h3 class="font-semibold text-neutral-800">Filter Data</h3>
    </div>

    <form method="get" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Indicator Filter -->
        <div>
            <label class="input-label">Indikator</label>
            <select name="indicator" class="input-field">
                <option value="">Semua Indikator</option>
                <option value="wfa" @selected($indicator==='wfa' )>BB/U (Berat menurut Umur)</option>
                <option value="hfa" @selected($indicator==='hfa' )>TB/U (Tinggi menurut Umur)</option>
                <option value="wfh" @selected($indicator==='wfh' )>BB/TB (Berat menurut Tinggi)</option>
            </select>
        </div>

        <!-- Gender Filter -->
        <div>
            <label class="input-label">Jenis Kelamin</label>
            <select name="gender" class="input-field">
                <option value="">Semua</option>
                <option value="male" @selected($gender==='male' )>Laki-laki</option>
                <option value="female" @selected($gender==='female' )>Perempuan</option>
            </select>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-end gap-2">
            <button type="submit" class="btn-primary flex-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filter
            </button>
            <a href="{{ route('growth-standards.index') }}" class="btn-secondary flex-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Empty State atau Data Table -->
@if ($items->count() === 0)
<div class="card card-padding text-center">
    <div class="py-8">
        <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
        </svg>
        <h3 class="text-lg font-semibold text-neutral-800 mb-2">Belum Ada Data Standar</h3>
        <p class="text-neutral-600">Data standar WHO belum tersedia dalam sistem.</p>
    </div>
</div>
@else
<!-- Stats Info -->
<div class="card card-padding mb-4">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center">
            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
        </div>
        <div>
            <p class="text-sm text-neutral-500">Total Data Standar</p>
            <p class="text-xl font-bold text-neutral-900">{{ $items->total() }} Entri</p>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card overflow-hidden">
    <table class="table-premium">
        <thead>
            <tr>
                <th>Indikator</th>
                <th>JK</th>
                <th>Usia (bln)</th>
                <th>TB/PB (cm)</th>
                <th>L</th>
                <th>M</th>
                <th>S</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $row)
            <tr>
                <td>
                    @php
                    $indicatorLabels = [
                    'wfa' => 'BB/U',
                    'hfa' => 'TB/U',
                    'wfh' => 'BB/TB',
                    ];
                    $indicatorColors = [
                    'wfa' => 'badge-info',
                    'hfa' => 'badge-primary',
                    'wfh' => 'badge-success',
                    ];
                    @endphp
                    <span class="badge {{ $indicatorColors[$row->indicator] ?? 'badge-neutral' }}">
                        {{ $indicatorLabels[$row->indicator] ?? strtoupper($row->indicator) }}
                    </span>
                </td>
                <td>
                    @if($row->gender === 'male')
                    <span class="badge badge-info">L</span>
                    @else
                    <span class="badge badge-primary">P</span>
                    @endif
                </td>
                <td>
                    <span class="text-neutral-700">{{ $row->age_months ?? '-' }}</span>
                </td>
                <td>
                    <span class="text-neutral-700">{{ $row->length_height_cm ?? '-' }}</span>
                </td>
                <td>
                    <span class="font-mono text-sm text-neutral-700">{{ number_format($row->l, 5) }}</span>
                </td>
                <td>
                    <span class="font-mono text-sm text-neutral-700">{{ number_format($row->m, 4) }}</span>
                </td>
                <td>
                    <span class="font-mono text-sm text-neutral-700">{{ number_format($row->s, 5) }}</span>
                </td>
                <td>
                    <a href="{{ route('growth-standards.show', $row) }}" class="btn-ghost btn-sm" title="Lihat Detail">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Detail
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($items->hasPages())
<div class="mt-6">
    {{ $items->links() }}
</div>
@endif
@endif

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
            <h4 class="font-semibold text-blue-900 mb-1">Tentang Data LMS</h4>
            <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                <li><strong>L (Lambda):</strong> Box-Cox power untuk transformasi data</li>
                <li><strong>M (Mu):</strong> Median nilai pengukuran</li>
                <li><strong>S (Sigma):</strong> Koefisien variasi generalized</li>
                <li>Data berdasarkan WHO Child Growth Standards</li>
            </ul>
        </div>
    </div>
</div>

@endsection