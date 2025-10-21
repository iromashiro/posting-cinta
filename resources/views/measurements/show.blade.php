@extends('layouts.app')

@section('content')
@php($header = '📏 Detail Pengukuran')

<!-- Header Card -->
<div class="card-cute mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div class="flex items-start gap-4">
            <div class="text-5xl">{{ $measurement->child->gender === 'male' ? '👦' : '👧' }}</div>
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-slate-800 mb-1">
                    <a href="{{ route('children.show', $measurement->child) }}" class="text-brand-600 hover:underline">
                        {{ $measurement->child->name }}
                    </a>
                </h1>
                <div class="flex flex-wrap gap-3 text-sm text-slate-600">
                    <span class="flex items-center gap-1">
                        <span>👩</span>
                        <span>{{ optional($measurement->child->mother)->name ?? '-' }}</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <span>🏥</span>
                        <span>{{ optional($measurement->child->posyandu)->name ?? '-' }}</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('measurements.edit', $measurement) }}" class="btn-success text-sm">
                <span>✏️ Edit</span>
            </a>
            <form method="post" action="{{ route('measurements.destroy', $measurement) }}" x-data
                @submit.prevent="if(confirm('🗑️ Hapus pengukuran ini?')) $el.submit()" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger text-sm">
                    <span>🗑️ Hapus</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Date Badge -->
    <div class="inline-flex items-center gap-2 bg-brand-100 text-brand-800 px-4 py-2 rounded-full font-semibold">
        <span>📅</span>
        <span>{{ \Illuminate\Support\Carbon::parse($measurement->measured_at)->format('d M Y') }}</span>
        <span
            class="text-xs font-normal">({{ \Illuminate\Support\Carbon::parse($measurement->measured_at)->diffForHumans() }})</span>
    </div>
</div>

<!-- Measurement Data Grid -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <!-- Berat Badan -->
    <div class="card bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 text-center">
        <div class="text-3xl mb-2">⚖️</div>
        <div class="text-xs text-blue-700 mb-1 font-medium">Berat Badan</div>
        <div class="text-2xl font-bold text-slate-800">{{ number_format($measurement->weight, 2) }}</div>
        <div class="text-xs text-slate-600 mt-1">kg</div>
    </div>

    <!-- Tinggi/Panjang -->
    <div class="card bg-gradient-to-br from-purple-50 to-purple-100 border-2 border-purple-200 text-center">
        <div class="text-3xl mb-2">📏</div>
        <div class="text-xs text-purple-700 mb-1 font-medium">TB/PB</div>
        <div class="text-2xl font-bold text-slate-800">{{ number_format($measurement->height, 2) }}</div>
        <div class="text-xs text-slate-600 mt-1">cm</div>
    </div>

    <!-- Lingkar Kepala -->
    <div class="card bg-gradient-to-br from-pink-50 to-pink-100 border-2 border-pink-200 text-center">
        <div class="text-3xl mb-2">🎯</div>
        <div class="text-xs text-pink-700 mb-1 font-medium">Lingkar Kepala</div>
        <div class="text-2xl font-bold text-slate-800">
            {{ $measurement->head_circumference ? number_format($measurement->head_circumference, 2) : '-' }}
        </div>
        <div class="text-xs text-slate-600 mt-1">cm</div>
    </div>

    <!-- Usia -->
    <div class="card bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 text-center">
        <div class="text-3xl mb-2">👶</div>
        <div class="text-xs text-green-700 mb-1 font-medium">Usia Saat Ukur</div>
        <div class="text-2xl font-bold text-slate-800">{{ $measurement->age_months }}</div>
        <div class="text-xs text-slate-600 mt-1">bulan</div>
    </div>
</div>

<!-- Z-Score Grid -->
<div class="card-cute mb-6">
    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2 mb-4">
        <span>📊</span>
        <span>Nilai Z-Score (WHO)</span>
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Z BB/U -->
        <div class="bg-slate-50 rounded-xl p-4 border-2 border-slate-200">
            <div class="text-xs text-slate-600 mb-1 font-medium">Z-Score BB/U</div>
            <div class="text-xl font-bold text-slate-800">
                {{ $measurement->weight_for_age_z !== null ? number_format($measurement->weight_for_age_z, 2) : '-' }}
            </div>
            <div class="text-xs text-slate-500 mt-1">Berat Badan menurut Usia</div>
        </div>

        <!-- Z TB/U -->
        <div class="bg-slate-50 rounded-xl p-4 border-2 border-slate-200">
            <div class="text-xs text-slate-600 mb-1 font-medium">Z-Score TB/U</div>
            <div
                class="text-xl font-bold {{ $measurement->height_for_age_z !== null && $measurement->height_for_age_z < -2 ? 'text-rose-600' : 'text-slate-800' }}">
                {{ $measurement->height_for_age_z !== null ? number_format($measurement->height_for_age_z, 2) : '-' }}
            </div>
            <div class="text-xs text-slate-500 mt-1">Tinggi Badan menurut Usia</div>
        </div>

        <!-- Z BB/TB -->
        <div class="bg-slate-50 rounded-xl p-4 border-2 border-slate-200">
            <div class="text-xs text-slate-600 mb-1 font-medium">Z-Score BB/TB</div>
            <div class="text-xl font-bold text-slate-800">
                {{ $measurement->weight_for_height_z !== null ? number_format($measurement->weight_for_height_z, 2) : '-' }}
            </div>
            <div class="text-xs text-slate-500 mt-1">Berat Badan menurut Tinggi</div>
        </div>
    </div>
</div>

<!-- Nutrition Status -->
<div class="card-cute mb-6">
    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2 mb-4">
        <span>🎯</span>
        <span>Status Gizi (TB/U)</span>
    </h3>

    <div class="flex items-center gap-3">
        @if ($measurement->nutrition_status === 'severe')
        <span class="badge-danger text-lg px-6 py-3">🚨 Sangat Pendek (Severe Stunting)</span>
        @elseif ($measurement->nutrition_status === 'stunting')
        <span class="badge-warning text-lg px-6 py-3">⚠️ Pendek (Stunting)</span>
        @elseif ($measurement->nutrition_status === 'normal')
        <span class="badge-success text-lg px-6 py-3">✅ Normal</span>
        @else
        <span class="badge-secondary text-lg px-6 py-3">❓ Belum Terklasifikasi</span>
        @endif
    </div>

    <!-- Status Info -->
    <div class="mt-4 bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
        <div class="flex items-start gap-3">
            <div class="text-2xl">💡</div>
            <div class="flex-1 text-sm text-blue-800">
                @if ($measurement->nutrition_status === 'severe')
                <strong>Perhatian Serius!</strong> Anak mengalami stunting parah (Z-Score < -3 SD). Segera konsultasikan
                    dengan tenaga kesehatan untuk intervensi gizi dan tumbuh kembang. @elseif ($measurement->
                    nutrition_status === 'stunting')
                    <strong>Perlu Perhatian!</strong> Anak mengalami stunting ringan (Z-Score -3 SD hingga -2 SD).
                    Tingkatkan asupan gizi dan lakukan monitoring rutin.
                    @elseif ($measurement->nutrition_status === 'normal')
                    <strong>Bagus!</strong> Tinggi badan anak sesuai dengan usianya (Z-Score ≥ -2 SD). Pertahankan pola
                    asuh dan gizi yang baik.
                    @else
                    Data belum dapat diklasifikasikan. Pastikan data pengukuran lengkap dan akurat.
                    @endif
            </div>
        </div>
    </div>
</div>

<!-- Notes Section -->
@if ($measurement->notes)
<div class="card-cute mb-6">
    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2 mb-4">
        <span>📝</span>
        <span>Catatan</span>
    </h3>
    <div class="bg-slate-50 rounded-xl p-4 border-2 border-slate-200 whitespace-pre-line text-slate-700">
        {{ $measurement->notes }}
    </div>
</div>
@endif

<!-- Action Buttons -->
<div class="flex items-center gap-3">
    <a href="{{ route('children.show', $measurement->child) }}" class="btn-secondary">
        <span>← Kembali ke Detail Anak</span>
    </a>
    <a href="{{ route('measurements.index') }}" class="btn-secondary">
        <span>📋 Lihat Semua Pengukuran</span>
    </a>
</div>

@endsection