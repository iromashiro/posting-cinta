@extends('layouts.app')

@section('content')
@php($header = '👶 Detail Anak & Grafik Pertumbuhan')

<!-- Header Section with Child Info -->
<div class="card-cute mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-start gap-4">
            <div class="text-5xl">{{ $child->gender === 'male' ? '👦' : '👧' }}</div>
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-slate-800 mb-1">{{ $child->name }}</h1>
                <div class="flex flex-wrap gap-3 text-sm text-slate-600">
                    <span class="flex items-center gap-1">
                        <span>🆔</span>
                        <span>{{ $child->nik ?: 'NIK belum diisi' }}</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <span>👧👦</span>
                        <span>{{ $child->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</span>
                    </span>
                    <span class="flex items-center gap-1">
                        <span>🎂</span>
                        <span>{{ \Illuminate\Support\Carbon::parse($child->date_of_birth)->format('d M Y') }}</span>
                        <span
                            class="text-brand-600 font-semibold">({{ \Illuminate\Support\Carbon::parse($child->date_of_birth)->age }}
                            tahun)</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('measurements.create', ['child_id' => $child->id]) }}" class="btn-primary text-sm">
                <span>📏 Tambah Pengukuran</span>
            </a>
            <a href="{{ route('children.edit', $child) }}" class="btn-success text-sm">
                <span>✏️ Edit Data</span>
            </a>
            <a href="{{ route('growth-chart.show', $child) }}" class="btn-secondary text-sm">
                <span>📊 Grafik WHO</span>
            </a>
        </div>
    </div>
</div>

<!-- Info Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="card bg-gradient-to-br from-pink-50 to-pink-100 border-2 border-pink-200">
        <div class="flex items-center gap-3">
            <div class="text-3xl">👩</div>
            <div class="flex-1">
                <div class="text-xs text-pink-700 mb-1 font-medium">Nama Ibu</div>
                <div class="font-bold text-slate-800">{{ optional($child->mother)->name ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="card bg-gradient-to-br from-purple-50 to-purple-100 border-2 border-purple-200">
        <div class="flex items-center gap-3">
            <div class="text-3xl">🏥</div>
            <div class="flex-1">
                <div class="text-xs text-purple-700 mb-1 font-medium">Posyandu</div>
                <div class="font-bold text-slate-800">{{ optional($child->posyandu)->name ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="card bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200">
        <div class="flex items-center gap-3">
            <div class="text-3xl">📏</div>
            <div class="flex-1">
                <div class="text-xs text-blue-700 mb-1 font-medium">Total Pengukuran</div>
                <div class="font-bold text-slate-800">{{ $child->measurements->count() }} kali</div>
            </div>
        </div>
    </div>

    <div class="card bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200">
        <div class="flex items-center gap-3">
            <div class="text-3xl">📅</div>
            <div class="flex-1">
                <div class="text-xs text-green-700 mb-1 font-medium">Terakhir Diukur</div>
                <div class="font-bold text-slate-800">
                    @if($child->measurements->count() > 0)
                    {{ \Illuminate\Support\Carbon::parse($child->measurements->first()->measured_at)->diffForHumans() }}
                    @else
                    Belum pernah
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Chart Card -->
    <div class="card-cute">
        <div class="mb-4">
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2 mb-2">
                <span>📈</span>
                <span>Grafik Z-Score TB/U (Stunting)</span>
            </h3>
            <p class="text-sm text-slate-600">
                <span class="inline-block w-3 h-3 bg-red-500 rounded-full"></span>
                Garis merah: -2 SD (batas stunting)
            </p>
        </div>
        <div class="bg-slate-50 rounded-xl p-4">
            <canvas id="hfaChart" height="200"></canvas>
        </div>
        @if($child->measurements->count() === 0)
        <div class="mt-4 text-center text-slate-500 text-sm">
            <p>Belum ada data untuk ditampilkan</p>
            <p class="mt-2">Tambahkan pengukuran pertama untuk melihat grafik</p>
        </div>
        @endif
    </div>

    <!-- Measurement History Card -->
    <div class="card-cute">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <span>📋</span>
                <span>Riwayat Pengukuran</span>
            </h3>
            @if($child->measurements->count() > 0)
            <span class="badge-success">{{ $child->measurements->count() }} data</span>
            @endif
        </div>

        @if($child->measurements->count() === 0)
        <div class="text-center py-12">
            <div class="text-5xl mb-3">📏💭</div>
            <p class="text-slate-600 mb-4">Belum ada pengukuran untuk anak ini</p>
            <a href="{{ route('measurements.create', ['child_id' => $child->id]) }}" class="btn-primary inline-flex">
                <span>📏 Tambah Pengukuran Pertama</span>
            </a>
        </div>
        @else
        <div class="overflow-x-auto -mx-4 md:mx-0">
            <table class="table-cute">
                <thead>
                    <tr>
                        <th>📅 Tanggal</th>
                        <th>⚖️ BB (kg)</th>
                        <th>📏 TB/PB (cm)</th>
                        <th>📊 Z TB/U</th>
                        <th>🎯 Status</th>
                        <th>⚙️ Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($child->measurements as $m)
                    <tr>
                        <td>
                            <div class="font-medium text-slate-800">
                                {{ \Illuminate\Support\Carbon::parse($m->measured_at)->format('d M Y') }}
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ \Illuminate\Support\Carbon::parse($m->measured_at)->diffForHumans() }}
                            </div>
                        </td>
                        <td>
                            <span class="font-semibold text-slate-800">{{ number_format($m->weight, 2) }}</span>
                        </td>
                        <td>
                            <span class="font-semibold text-slate-800">{{ number_format($m->height, 2) }}</span>
                        </td>
                        <td>
                            @if($m->height_for_age_z !== null)
                            <span
                                class="font-semibold {{ $m->height_for_age_z < -2 ? 'text-rose-600' : 'text-slate-800' }}">
                                {{ number_format($m->height_for_age_z, 2) }}
                            </span>
                            @else
                            <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td>
                            @if ($m->nutrition_status === 'severe')
                            <span class="badge-danger">🚨 Sangat Pendek</span>
                            @elseif ($m->nutrition_status === 'stunting')
                            <span class="badge-warning">⚠️ Pendek</span>
                            @elseif ($m->nutrition_status === 'normal')
                            <span class="badge-success">✅ Normal</span>
                            @else
                            <span class="badge-secondary">- </span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('measurements.edit', $m) }}" class="btn-success text-xs px-2 py-1"
                                    title="Edit Pengukuran">
                                    ✏️
                                </a>
                                <form method="post" action="{{ route('measurements.destroy', $m) }}" x-data
                                    @submit.prevent="if(confirm(`🗑️ Hapus pengukuran tanggal {{ \Illuminate\Support\Carbon::parse($m->measured_at)->format('d M Y') }}?`)) $el.submit()"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger text-xs px-2 py-1" title="Hapus Pengukuran">
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
        @endif
    </div>
</div>

<!-- Info Box -->
<div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4 mb-6">
    <div class="flex items-start gap-3">
        <div class="text-2xl">💡</div>
        <div class="flex-1">
            <h4 class="font-semibold text-blue-900 mb-1">Tentang Z-Score TB/U</h4>
            <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                <li><strong>Normal:</strong> Z-Score ≥ -2 SD</li>
                <li><strong>Pendek (Stunting):</strong> -3 SD ≤ Z-Score < -2 SD</li>
                <li><strong>Sangat Pendek (Severe Stunting):</strong> Z-Score < -3 SD</li>
            </ul>
        </div>
    </div>
</div>

<!-- Back Button -->
<div class="flex items-center gap-3">
    <a href="{{ route('children.index') }}" class="btn-secondary">
        <span>← Kembali ke Daftar Anak</span>
    </a>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function () {
        const ctx = document.getElementById('hfaChart');
        if (!ctx) return;

        const data = @json($child->measurements->sortBy('age_months')->values()->map(function($m){
            return [
                'x' => $m->age_months,
                'y' => $m->height_for_age_z
            ];
        }));

        if (data.length === 0) {
            // Show empty state message on canvas
            const ctxCanvas = ctx.getContext('2d');
            ctxCanvas.font = '14px sans-serif';
            ctxCanvas.fillStyle = '#94a3b8';
            ctxCanvas.textAlign = 'center';
            ctxCanvas.fillText('Belum ada data pengukuran', ctx.width / 2, ctx.height / 2);
            return;
        }

        const labels = data.map(p => p.x);
        const values = data.map(p => p.y);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels,
                datasets: [
                    {
                        label: 'Z TB/U',
                        data: values,
                        borderColor: '#ec4899',
                        backgroundColor: 'rgba(236,72,153,0.1)',
                        borderWidth: 3,
                        tension: 0.3,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointBackgroundColor: '#ec4899',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    },
                    {
                        label: '-2 SD (Batas Stunting)',
                        data: labels.map(() => -2),
                        borderColor: '#ef4444',
                        borderWidth: 2,
                        borderDash: [6, 6],
                        pointRadius: 0,
                        fill: false
                    },
                    {
                        label: '-3 SD (Batas Severe)',
                        data: labels.map(() => -3),
                        borderColor: '#dc2626',
                        borderWidth: 2,
                        borderDash: [3, 3],
                        pointRadius: 0,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: '📅 Usia (bulan)',
                            font: { size: 13, weight: 'bold' }
                        },
                        grid: { color: '#e2e8f0' }
                    },
                    y: {
                        title: {
                            display: true,
                            text: '📊 Z-Score TB/U',
                            font: { size: 13, weight: 'bold' }
                        },
                        suggestedMin: -4,
                        suggestedMax: 3,
                        grid: { color: '#e2e8f0' }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: { size: 11 },
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 12,
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 12 },
                        cornerRadius: 8
                    }
                }
            }
        });
    })();
</script>

@endsection