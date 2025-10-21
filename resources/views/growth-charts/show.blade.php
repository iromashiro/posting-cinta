@extends('layouts.app')

@section('content')
@php($header = 'Grafik Pertumbuhan WHO')

<div class="mb-4 flex items-start justify-between">
    <div>
        <div class="text-sm text-slate-500">Anak</div>
        <div class="text-xl font-semibold">{{ $child->name }}</div>
        <div class="text-xs text-slate-500">{{ $child->gender === 'male' ? 'Laki-laki' : 'Perempuan' }} •
            {{ $child->age_months }} bln</div>
    </div>
    <a href="{{ route('children.show', $child) }}"
        class="px-3 py-2 rounded border border-slate-300 hover:bg-slate-50">Kembali</a>
</div>

<div x-data="{ tab: 'hfa' }" class="bg-white border border-slate-200 rounded-xl overflow-hidden">
    <div class="border-b border-slate-200 p-2 flex gap-2">
        <button @click="tab='hfa'"
            :class="tab==='hfa' ? 'bg-pink-100 text-pink-700' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'"
            class="px-3 py-2 rounded-lg text-sm font-semibold">TB/U</button>
        <button @click="tab='wfa'"
            :class="tab==='wfa' ? 'bg-pink-100 text-pink-700' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'"
            class="px-3 py-2 rounded-lg text-sm font-semibold">BB/U</button>
        <button @click="tab='wfh'"
            :class="tab==='wfh' ? 'bg-pink-100 text-pink-700' : 'bg-slate-50 text-slate-600 hover:bg-slate-100'"
            class="px-3 py-2 rounded-lg text-sm font-semibold">BB/TB</button>
    </div>

    <div class="p-4">
        <div x-show="tab==='hfa'">
            <div class="mb-2 text-sm text-slate-600">Grafik Tinggi/Panjang Badan menurut Umur (TB/U)</div>
            <div class="h-64">
                <canvas id="chart-hfa"></canvas>
            </div>
            <div class="mt-2 text-xs text-slate-500">Garis referensi: −3 SD, −2 SD, Median, +2 SD, +3 SD</div>
        </div>

        <div x-show="tab==='wfa'">
            <div class="mb-2 text-sm text-slate-600">Grafik Berat Badan menurut Umur (BB/U)</div>
            <div class="h-64">
                <canvas id="chart-wfa"></canvas>
            </div>
        </div>

        <div x-show="tab==='wfh'">
            <div class="mb-2 text-sm text-slate-600">Grafik Berat Badan menurut Tinggi/Panjang (BB/TB)</div>
            <div class="h-64">
                <canvas id="chart-wfh"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="mt-6 text-xs text-blue-700 bg-blue-50 border border-blue-200 rounded-xl p-3">
    Tips: Zona di bawah −2 SD mengindikasikan risiko stunting/gizi kurang. Pastikan pengukuran akurat dan konsisten.
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
            borderWidth: 2,
            pointRadius: 3,
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
                x: { type: 'linear', title: { display: true, text: xTitle } },
                y: { title: { display: true, text: yTitle } },
            },
            plugins: {
                legend: { display: true, position: 'bottom' },
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