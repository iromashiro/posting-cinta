@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="page-title">Grafik Pertumbuhan WHO</h1>
            <p class="page-subtitle">Kurva pertumbuhan berdasarkan standar WHO</p>
        </div>
        <a href="{{ route('children.show', $child) }}" class="btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>
</div>

<!-- Child Info Card -->
<div class="card card-padding mb-6">
    <div class="flex items-center gap-4">
        <div
            class="w-16 h-16 rounded-full bg-primary-500 flex items-center justify-center text-white text-2xl font-bold">
            {{ strtoupper(substr($child->name, 0, 1)) }}
        </div>
        <div class="flex-1">
            <h2 class="text-xl font-bold text-neutral-900">{{ $child->name }}</h2>
            <div class="flex flex-wrap items-center gap-3 mt-1">
                @if($child->gender === 'male')
                <span class="badge badge-info">Laki-laki</span>
                @else
                <span class="badge badge-primary">Perempuan</span>
                @endif
                <span class="text-sm text-neutral-500">{{ $child->age_months }} bulan</span>
            </div>
        </div>
    </div>
</div>

<!-- Chart Tabs -->
<div x-data="{ tab: 'hfa' }" class="card overflow-hidden">
    <!-- Tab Navigation -->
    <div class="border-b border-neutral-200 bg-neutral-50 p-2 flex gap-2">
        <button @click="tab='hfa'"
            :class="tab==='hfa' ? 'bg-primary-500 text-white shadow-sm' : 'bg-white text-neutral-600 hover:bg-neutral-100 border border-neutral-200'"
            class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                TB/U
            </span>
        </button>
        <button @click="tab='wfa'"
            :class="tab==='wfa' ? 'bg-primary-500 text-white shadow-sm' : 'bg-white text-neutral-600 hover:bg-neutral-100 border border-neutral-200'"
            class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                </svg>
                BB/U
            </span>
        </button>
        <button @click="tab='wfh'"
            :class="tab==='wfh' ? 'bg-primary-500 text-white shadow-sm' : 'bg-white text-neutral-600 hover:bg-neutral-100 border border-neutral-200'"
            class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                BB/TB
            </span>
        </button>
    </div>

    <!-- Chart Content -->
    <div class="p-6">
        <!-- TB/U Chart -->
        <div x-show="tab==='hfa'" x-transition>
            <div class="mb-4">
                <h3 class="font-semibold text-neutral-900">Tinggi/Panjang Badan menurut Umur (TB/U)</h3>
                <p class="text-sm text-neutral-500">Menilai pertumbuhan linear anak dan risiko stunting</p>
            </div>
            <div class="h-80 bg-neutral-50 rounded-lg p-2">
                <canvas id="chart-hfa"></canvas>
            </div>
        </div>

        <!-- BB/U Chart -->
        <div x-show="tab==='wfa'" x-transition>
            <div class="mb-4">
                <h3 class="font-semibold text-neutral-900">Berat Badan menurut Umur (BB/U)</h3>
                <p class="text-sm text-neutral-500">Menilai status gizi anak berdasarkan berat badan</p>
            </div>
            <div class="h-80 bg-neutral-50 rounded-lg p-2">
                <canvas id="chart-wfa"></canvas>
            </div>
        </div>

        <!-- BB/TB Chart -->
        <div x-show="tab==='wfh'" x-transition>
            <div class="mb-4">
                <h3 class="font-semibold text-neutral-900">Berat Badan menurut Tinggi/Panjang (BB/TB)</h3>
                <p class="text-sm text-neutral-500">Menilai proporsionalitas tubuh anak</p>
            </div>
            <div class="h-80 bg-neutral-50 rounded-lg p-2">
                <canvas id="chart-wfh"></canvas>
            </div>
        </div>

        <!-- Legend -->
        <div class="mt-4 flex flex-wrap items-center gap-4 text-xs">
            <div class="flex items-center gap-2">
                <span class="w-4 h-0.5 bg-red-500"></span>
                <span class="text-neutral-600">−3 SD (Sangat Pendek)</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-4 h-0.5 bg-amber-500"></span>
                <span class="text-neutral-600">−2 SD (Pendek)</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-4 h-0.5 bg-indigo-500"></span>
                <span class="text-neutral-600">Median</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-4 h-0.5 bg-emerald-500"></span>
                <span class="text-neutral-600">+2 SD</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-4 h-0.5 bg-teal-600"></span>
                <span class="text-neutral-600">+3 SD</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-4 h-1 bg-sky-500 rounded"></span>
                <span class="text-neutral-600">Data Anak</span>
            </div>
        </div>
    </div>
</div>

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
            <h4 class="font-semibold text-blue-900 mb-1">Interpretasi Grafik</h4>
            <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                <li><strong>Di bawah −3 SD:</strong> Sangat pendek/kurus, perlu intervensi segera</li>
                <li><strong>Antara −3 SD dan −2 SD:</strong> Pendek/kurus, perlu perhatian khusus</li>
                <li><strong>Antara −2 SD dan +2 SD:</strong> Normal</li>
                <li><strong>Di atas +2 SD:</strong> Tinggi/gemuk, perlu evaluasi lebih lanjut</li>
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>
<script>
    (function () {
    const HFA = @json($hfa);
    const WFA = @json($wfa);
    const WFH = @json($wfh);

    function buildSdDataset(label, data, color, dashed = false) {
        return {
            label,
            data,
            borderColor: color,
            backgroundColor: 'transparent',
            borderWidth: 2,
            tension: 0.2,
            pointRadius: 0,
            fill: false,
            borderDash: dashed ? [6, 6] : [],
            parsing: { xAxisKey: 'x', yAxisKey: 'y' },
        };
    }

    function buildChildDataset(label, data, color) {
        return {
            label,
            data,
            borderColor: color,
            backgroundColor: 'rgba(14,165,233,0.15)',
            borderWidth: 3,
            pointRadius: 4,
            pointBackgroundColor: color,
            showLine: true,
            tension: 0.25,
            parsing: { xAxisKey: 'x', yAxisKey: 'y' },
        };
    }

    function makeOptions(xTitle, yTitle) {
        return {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    type: 'linear',
                    title: { display: true, text: xTitle, font: { weight: 'bold' } },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                y: {
                    title: { display: true, text: yTitle, font: { weight: 'bold' } },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
            },
            plugins: {
                legend: { display: false },
                tooltip: { intersect: false, mode: 'nearest' },
            },
            interaction: { intersect: false, mode: 'nearest', axis: 'xy' },
        };
    }

    const hfaEl = document.getElementById('chart-hfa');
    if (hfaEl) {
        const ctx = hfaEl.getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                datasets: [
                    buildSdDataset('-3 SD', HFA.sd['-3'] || [], '#ef4444', true),
                    buildSdDataset('-2 SD', HFA.sd['-2'] || [], '#f59e0b', true),
                    buildSdDataset('Median', HFA.sd['0'] || [], '#6366f1'),
                    buildSdDataset('+2 SD', HFA.sd['2'] || [], '#10b981', true),
                    buildSdDataset('+3 SD', HFA.sd['3'] || [], '#059669', true),
                    buildChildDataset('Data Anak (TB)', HFA.child || [], '#0ea5e9'),
                ],
            },
            options: makeOptions('Usia (bulan)', 'Tinggi/Panjang (cm)'),
        });
    }

    const wfaEl = document.getElementById('chart-wfa');
    if (wfaEl) {
        const ctx = wfaEl.getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                datasets: [
                    buildSdDataset('-3 SD', WFA.sd['-3'] || [], '#ef4444', true),
                    buildSdDataset('-2 SD', WFA.sd['-2'] || [], '#f59e0b', true),
                    buildSdDataset('Median', WFA.sd['0'] || [], '#6366f1'),
                    buildSdDataset('+2 SD', WFA.sd['2'] || [], '#10b981', true),
                    buildSdDataset('+3 SD', WFA.sd['3'] || [], '#059669', true),
                    buildChildDataset('Data Anak (BB)', WFA.child || [], '#6366f1'),
                ],
            },
            options: makeOptions('Usia (bulan)', 'Berat (kg)'),
        });
    }

    const wfhEl = document.getElementById('chart-wfh');
    if (wfhEl) {
        const ctx = wfhEl.getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                datasets: [
                    buildSdDataset('-3 SD', WFH.sd['-3'] || [], '#ef4444', true),
                    buildSdDataset('-2 SD', WFH.sd['-2'] || [], '#f59e0b', true),
                    buildSdDataset('Median', WFH.sd['0'] || [], '#6366f1'),
                    buildSdDataset('+2 SD', WFH.sd['2'] || [], '#10b981', true),
                    buildSdDataset('+3 SD', WFH.sd['3'] || [], '#059669', true),
                    buildChildDataset('Data Anak (BB vs TB)', WFH.child || [], '#ec4899'),
                ],
            },
            options: makeOptions('Tinggi/Panjang (cm)', 'Berat (kg)'),
        });
    }
})();
</script>

@endsection