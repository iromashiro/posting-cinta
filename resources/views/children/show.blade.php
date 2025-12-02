@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="page-title">Detail Anak</h1>
            <p class="page-subtitle">Informasi lengkap dan grafik pertumbuhan</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('measurements.create', ['child_id' => $child->id]) }}" class="btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pengukuran
            </a>
            <a href="{{ route('children.edit', $child) }}" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('growth-chart.show', $child) }}" class="btn-ghost">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Grafik WHO
            </a>
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
            <h2 class="text-xl font-bold text-neutral-900 mb-2">{{ $child->name }}</h2>
            <div class="flex flex-wrap gap-4 text-sm text-neutral-600">
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                    </svg>
                    {{ $child->nik ?: 'NIK belum diisi' }}
                </span>
                <span class="flex items-center gap-1">
                    @if($child->gender === 'male')
                    <span class="badge badge-info">Laki-laki</span>
                    @else
                    <span class="badge badge-primary">Perempuan</span>
                    @endif
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ \Illuminate\Support\Carbon::parse($child->date_of_birth)->format('d M Y') }}
                    <span
                        class="text-primary-600 font-semibold">({{ \Illuminate\Support\Carbon::parse($child->date_of_birth)->age }}
                        tahun)</span>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Info Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="card card-padding">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="text-xs text-neutral-500 mb-1">Nama Ibu</div>
                <div class="font-semibold text-neutral-900">{{ optional($child->mother)->name ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="card card-padding">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-secondary-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="text-xs text-neutral-500 mb-1">Posyandu</div>
                <div class="font-semibold text-neutral-900">{{ optional($child->posyandu)->name ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="card card-padding">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="text-xs text-neutral-500 mb-1">Total Pengukuran</div>
                <div class="font-semibold text-neutral-900">{{ $child->measurements->count() }} kali</div>
            </div>
        </div>
    </div>

    <div class="card card-padding">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="text-xs text-neutral-500 mb-1">Terakhir Diukur</div>
                <div class="font-semibold text-neutral-900">
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
    <div class="card card-padding">
        <div class="mb-4">
            <h3 class="text-lg font-bold text-neutral-900 flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                </svg>
                Grafik Z-Score TB/U (Stunting)
            </h3>
            <div class="flex items-center gap-4 text-sm text-neutral-600">
                <span class="flex items-center gap-1">
                    <span class="inline-block w-3 h-3 bg-red-500 rounded-full"></span>
                    -2 SD (batas stunting)
                </span>
                <span class="flex items-center gap-1">
                    <span class="inline-block w-3 h-3 bg-red-700 rounded-full"></span>
                    -3 SD (batas severe)
                </span>
            </div>
        </div>
        <div class="bg-neutral-50 rounded-lg p-4">
            <canvas id="hfaChart" height="200"></canvas>
        </div>
        @if($child->measurements->count() === 0)
        <div class="mt-4 text-center text-neutral-500 text-sm">
            <p>Belum ada data untuk ditampilkan</p>
            <p class="mt-2">Tambahkan pengukuran pertama untuk melihat grafik</p>
        </div>
        @endif
    </div>

    <!-- Measurement History Card -->
    <div class="card card-padding">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-neutral-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Riwayat Pengukuran
            </h3>
            @if($child->measurements->count() > 0)
            <span class="badge badge-success">{{ $child->measurements->count() }} data</span>
            @endif
        </div>

        @if($child->measurements->count() === 0)
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <p class="text-neutral-600 mb-4">Belum ada pengukuran untuk anak ini</p>
            <a href="{{ route('measurements.create', ['child_id' => $child->id]) }}" class="btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Pengukuran Pertama
            </a>
        </div>
        @else
        <div class="overflow-x-auto -mx-6 md:mx-0">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>BB (kg)</th>
                        <th>TB/PB (cm)</th>
                        <th>Z TB/U</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($child->measurements as $m)
                    <tr>
                        <td>
                            <div class="font-medium text-neutral-800">
                                {{ \Illuminate\Support\Carbon::parse($m->measured_at)->format('d M Y') }}
                            </div>
                            <div class="text-xs text-neutral-500">
                                {{ \Illuminate\Support\Carbon::parse($m->measured_at)->diffForHumans() }}
                            </div>
                        </td>
                        <td>
                            <span class="font-semibold text-neutral-800">{{ number_format($m->weight, 2) }}</span>
                        </td>
                        <td>
                            <span class="font-semibold text-neutral-800">{{ number_format($m->height, 2) }}</span>
                        </td>
                        <td>
                            @if($m->height_for_age_z !== null)
                            <span
                                class="font-semibold {{ $m->height_for_age_z < -2 ? 'text-red-600' : 'text-neutral-800' }}">
                                {{ number_format($m->height_for_age_z, 2) }}
                            </span>
                            @else
                            <span class="text-neutral-400">-</span>
                            @endif
                        </td>
                        <td>
                            @if ($m->nutrition_status === 'severe')
                            <span class="badge badge-danger">Sangat Pendek</span>
                            @elseif ($m->nutrition_status === 'stunting')
                            <span class="badge badge-warning">Pendek</span>
                            @elseif ($m->nutrition_status === 'normal')
                            <span class="badge badge-success">Normal</span>
                            @else
                            <span class="badge badge-neutral">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-1">
                                <a href="{{ route('measurements.edit', $m) }}" class="btn-secondary btn-sm"
                                    title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form method="post" action="{{ route('measurements.destroy', $m) }}" x-data
                                    @submit.prevent="if(confirm('Hapus pengukuran tanggal {{ \Illuminate\Support\Carbon::parse($m->measured_at)->format('d M Y') }}?')) $el.submit()"
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
        @endif
    </div>
</div>

<!-- Info Box -->
<div class="card card-padding bg-blue-50 border-blue-200 mb-6">
    <div class="flex items-start gap-3">
        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
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
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Daftar Anak
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
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99,102,241,0.1)',
                        borderWidth: 3,
                        tension: 0.3,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointBackgroundColor: '#6366f1',
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
                            text: 'Usia (bulan)',
                            font: { size: 13, weight: 'bold' }
                        },
                        grid: { color: '#e2e8f0' }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Z-Score TB/U',
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