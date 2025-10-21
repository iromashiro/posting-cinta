@extends('layouts.app')

@section('content')
@php($header = 'Detail Standar WHO (LMS)')

<div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
    <div class="p-5">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div class="p-4 rounded border border-slate-200 bg-slate-50 text-center">
                <div class="text-xs text-slate-500">Indikator</div>
                <div class="text-lg font-semibold">{{ strtoupper($growthStandard->indicator) }}
                    ({{ $growthStandard->indicator === 'wfa' ? 'BB/U' : ($growthStandard->indicator === 'hfa' ? 'TB/U' : 'BB/TB') }})
                </div>
            </div>
            <div class="p-4 rounded border border-slate-200 bg-slate-50 text-center">
                <div class="text-xs text-slate-500">Jenis Kelamin</div>
                <div class="text-lg font-semibold">{{ $growthStandard->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}
                </div>
            </div>
            <div class="p-4 rounded border border-slate-200 bg-slate-50 text-center">
                <div class="text-xs text-slate-500">Usia (bulan) / TB (cm)</div>
                <div class="text-lg font-semibold">
                    {{ $growthStandard->age_months !== null ? $growthStandard->age_months . ' bln' : ($growthStandard->length_height_cm !== null ? number_format($growthStandard->length_height_cm, 1) . ' cm' : '-') }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-4 rounded border border-slate-200 bg-white text-center">
                <div class="text-xs text-slate-500">L</div>
                <div class="text-lg font-semibold">{{ number_format($growthStandard->l, 5) }}</div>
            </div>
            <div class="p-4 rounded border border-slate-200 bg-white text-center">
                <div class="text-xs text-slate-500">M</div>
                <div class="text-lg font-semibold">{{ number_format($growthStandard->m, 4) }}</div>
            </div>
            <div class="p-4 rounded border border-slate-200 bg-white text-center">
                <div class="text-xs text-slate-500">S</div>
                <div class="text-lg font-semibold">{{ number_format($growthStandard->s, 5) }}</div>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('growth-standards.index') }}"
                class="px-3 py-2 rounded border border-slate-300 hover:bg-slate-50">Kembali</a>
        </div>
    </div>
</div>
@endsection
