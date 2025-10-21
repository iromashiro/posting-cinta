@extends('layouts.app')

@section('content')
@php($header = '📏 Daftar Pengukuran')

<!-- Header Section -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
            <span>📏</span>
            <span>Daftar Pengukuran</span>
        </h1>
        <p class="text-sm text-slate-600 mt-1">Riwayat pengukuran tumbuh kembang anak</p>
    </div>
    <a href="{{ route('measurements.create') }}" class="btn-primary">
        <span>➕ Tambah Pengukuran</span>
    </a>
</div>

<!-- Filter Section -->
<div class="card mb-6">
    <div class="flex items-center gap-2 mb-4">
        <span class="text-xl">🔍</span>
        <h3 class="font-semibold text-slate-800">Filter Pengukuran</h3>
    </div>

    <form method="get" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Child Filter -->
        <div class="md:col-span-2">
            <select name="child_id" class="input-field">
                <option value="">👶 Semua Anak</option>
                @foreach ($children as $c)
                <option value="{{ $c->id }}" @selected($childId==$c->id)>
                    {{ $c->name }} - {{ $c->gender === 'male' ? '👦' : '👧' }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-2">
            <button type="submit" class="btn-primary flex-1">
                <span>🔍 Filter</span>
            </button>
            <a href="{{ route('measurements.index') }}" class="btn-secondary flex-1">
                <span>🔄 Reset</span>
            </a>
        </div>
    </form>
</div>

<!-- Empty State atau Data Table -->
@if ($items->count() === 0)
<div class="card-cute text-center py-12">
    <div class="text-6xl mb-4">📏💭</div>
    <h3 class="text-lg font-semibold text-slate-800 mb-2">Belum Ada Data Pengukuran</h3>
    <p class="text-slate-600 mb-6">
        @if($childId)
        Belum ada pengukuran untuk anak yang dipilih.
        @else
        Mulai catat hasil pengukuran untuk monitoring tumbuh kembang anak.
        @endif
    </p>
    <a href="{{ route('measurements.create') }}" class="btn-primary inline-flex">
        <span>➕ Tambah Pengukuran Pertama</span>
    </a>
</div>
@else
<!-- Stats Info -->
<div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-4 mb-4 border-2 border-blue-200">
    <div class="flex items-center gap-3">
        <span class="text-2xl">📊</span>
        <div>
            <p class="text-sm text-slate-600">Total Pengukuran</p>
            <p class="text-2xl font-bold text-slate-800">{{ $items->count() }} Pengukuran</p>
        </div>
    </div>
</div>

<!-- Table -->
<div class="overflow-x-auto">
    <table class="table-cute">
        <thead>
            <tr>
                <th>📅 Tanggal</th>
                <th>👶 Nama Anak</th>
                <th>👩 Ibu</th>
                <th>🏥 Posyandu</th>
                <th>⚖️ BB (kg)</th>
                <th>📏 TB/PB (cm)</th>
                <th>📊 Z TB/U</th>
                <th>🎯 Status</th>
                <th>⚙️ Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td>
                    <div class="font-medium text-slate-800">
                        {{ \Illuminate\Support\Carbon::parse($item->measured_at)->format('d M Y') }}
                    </div>
                    <div class="text-xs text-slate-500">
                        {{ \Illuminate\Support\Carbon::parse($item->measured_at)->diffForHumans() }}
                    </div>
                </td>
                <td>
                    <a href="{{ route('children.show', $item->child) }}"
                        class="font-semibold text-brand-600 hover:text-brand-700 hover:underline flex items-center gap-2">
                        <span>{{ $item->child->gender === 'male' ? '👦' : '👧' }}</span>
                        <span>{{ $item->child->name }}</span>
                    </a>
                    <div class="text-xs text-slate-500 mt-1">
                        Usia: {{ $item->age_months }} bulan
                    </div>
                </td>
                <td>
                    <span class="text-slate-700">{{ optional($item->child->mother)->name ?? '-' }}</span>
                </td>
                <td>
                    <span class="text-slate-700">{{ optional($item->child->posyandu)->name ?? '-' }}</span>
                </td>
                <td>
                    <span class="font-semibold text-slate-800">{{ number_format($item->weight, 2) }}</span>
                </td>
                <td>
                    <span class="font-semibold text-slate-800">{{ number_format($item->height, 2) }}</span>
                </td>
                <td>
                    @if($item->height_for_age_z !== null)
                    <span class="font-semibold {{ $item->height_for_age_z < -2 ? 'text-rose-600' : 'text-slate-800' }}">
                        {{ number_format($item->height_for_age_z, 2) }}
                    </span>
                    @else
                    <span class="text-slate-400">-</span>
                    @endif
                </td>
                <td>
                    @if ($item->nutrition_status === 'severe')
                    <span class="badge-danger">🚨 Sangat Pendek</span>
                    @elseif ($item->nutrition_status === 'stunting')
                    <span class="badge-warning">⚠️ Pendek</span>
                    @elseif ($item->nutrition_status === 'normal')
                    <span class="badge-success">✅ Normal</span>
                    @else
                    <span class="badge-secondary">-</span>
                    @endif
                </td>
                <td>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('measurements.show', $item) }}" class="btn-secondary text-xs px-2 py-1"
                            title="Lihat Detail">
                            👁️
                        </a>
                        <a href="{{ route('measurements.edit', $item) }}" class="btn-success text-xs px-2 py-1"
                            title="Edit">
                            ✏️
                        </a>
                        <form method="post" action="{{ route('measurements.destroy', $item) }}" x-data
                            @submit.prevent="if(confirm(`🗑️ Hapus pengukuran tanggal {{ \Illuminate\Support\Carbon::parse($item->measured_at)->format('d M Y') }}?`)) $el.submit()"
                            class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger text-xs px-2 py-1" title="Hapus">
                                🗑️
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
<div class="mt-6 bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
    <div class="flex items-start gap-3">
        <div class="text-2xl">💡</div>
        <div class="flex-1">
            <h4 class="font-semibold text-blue-900 mb-1">Tentang Status Gizi</h4>
            <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                <li><strong>✅ Normal:</strong> Z-Score TB/U ≥ -2 SD (tinggi badan sesuai usia)</li>
                <li><strong>⚠️ Pendek (Stunting):</strong> -3 SD ≤ Z-Score < -2 SD (perlu perhatian)</li>
                <li><strong>🚨 Sangat Pendek:</strong> Z-Score < -3 SD (perlu intervensi segera)</li>
            </ul>
        </div>
    </div>
</div>

@endsection