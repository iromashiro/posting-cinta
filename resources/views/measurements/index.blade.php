@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="page-title">Daftar Pengukuran</h1>
            <p class="page-subtitle">Riwayat pengukuran tumbuh kembang anak</p>
        </div>
        <a href="{{ route('measurements.create') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Pengukuran
        </a>
    </div>
</div>

<!-- Filter Section -->
<div class="card card-padding mb-6">
    <div class="flex items-center gap-2 mb-4">
        <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
        </svg>
        <h3 class="font-semibold text-neutral-800">Filter Pengukuran</h3>
    </div>

    <form method="get" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Child Filter -->
        <div class="md:col-span-2">
            <select name="child_id" class="input-field">
                <option value="">Semua Anak</option>
                @foreach ($children as $c)
                <option value="{{ $c->id }}" @selected($childId==$c->id)>
                    {{ $c->name }} - {{ $c->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-2">
            <button type="submit" class="btn-primary flex-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filter
            </button>
            <a href="{{ route('measurements.index') }}" class="btn-secondary flex-1">
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
        <h3 class="text-lg font-semibold text-neutral-800 mb-2">Belum Ada Data Pengukuran</h3>
        <p class="text-neutral-600 mb-6">
            @if($childId)
            Belum ada pengukuran untuk anak yang dipilih.
            @else
            Mulai catat hasil pengukuran untuk monitoring tumbuh kembang anak.
            @endif
        </p>
        <a href="{{ route('measurements.create') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Pengukuran Pertama
        </a>
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
            <p class="text-sm text-neutral-500">Total Pengukuran</p>
            <p class="text-xl font-bold text-neutral-900">{{ $items->total() }} Pengukuran</p>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card overflow-hidden">
    <table class="table-premium">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Anak</th>
                <th>Ibu</th>
                <th>BB (kg)</th>
                <th>TB/PB (cm)</th>
                <th>Z TB/U</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td>
                    <div class="font-medium text-neutral-800">
                        {{ \Illuminate\Support\Carbon::parse($item->measured_at)->format('d M Y') }}
                    </div>
                    <div class="text-xs text-neutral-500">
                        {{ \Illuminate\Support\Carbon::parse($item->measured_at)->diffForHumans() }}
                    </div>
                </td>
                <td>
                    <a href="{{ route('children.show', $item->child) }}"
                        class="font-semibold text-primary-600 hover:text-primary-700 hover:underline">
                        {{ $item->child->name }}
                    </a>
                    <div class="text-xs text-neutral-500 mt-1">
                        Usia: {{ $item->age_months }} bulan
                    </div>
                </td>
                <td>
                    <span class="text-neutral-700">{{ optional($item->child->mother)->name ?? '-' }}</span>
                </td>
                <td>
                    <span class="font-semibold text-neutral-800">{{ number_format($item->weight, 2) }}</span>
                </td>
                <td>
                    <span class="font-semibold text-neutral-800">{{ number_format($item->height, 2) }}</span>
                </td>
                <td>
                    @if($item->height_for_age_z !== null)
                    <span
                        class="font-semibold {{ $item->height_for_age_z < -2 ? 'text-red-600' : 'text-neutral-800' }}">
                        {{ number_format($item->height_for_age_z, 2) }}
                    </span>
                    @else
                    <span class="text-neutral-400">-</span>
                    @endif
                </td>
                <td>
                    @if ($item->nutrition_status === 'severe')
                    <span class="badge badge-danger">Sangat Pendek</span>
                    @elseif ($item->nutrition_status === 'stunting')
                    <span class="badge badge-warning">Pendek</span>
                    @elseif ($item->nutrition_status === 'normal')
                    <span class="badge badge-success">Normal</span>
                    @else
                    <span class="badge badge-neutral">-</span>
                    @endif
                </td>
                <td>
                    <div class="flex items-center gap-1">
                        <a href="{{ route('measurements.show', $item) }}" class="btn-ghost btn-sm" title="Lihat Detail">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                        <a href="{{ route('measurements.edit', $item) }}" class="btn-secondary btn-sm" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <form method="post" action="{{ route('measurements.destroy', $item) }}" x-data
                            @submit.prevent="if(confirm('Hapus pengukuran tanggal {{ \Illuminate\Support\Carbon::parse($item->measured_at)->format('d M Y') }}?')) $el.submit()"
                            class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger btn-sm" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
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
            <h4 class="font-semibold text-blue-900 mb-1">Tentang Status Gizi</h4>
            <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                <li><strong>Normal:</strong> Z-Score TB/U ≥ -2 SD (tinggi badan sesuai usia)</li>
                <li><strong>Pendek (Stunting):</strong> -3 SD ≤ Z-Score &lt; -2 SD (perlu perhatian)</li>
                <li><strong>Sangat Pendek:</strong> Z-Score &lt; -3 SD (perlu intervensi segera)</li>
            </ul>
        </div>
    </div>
</div>

@endsection