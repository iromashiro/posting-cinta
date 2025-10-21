@extends('layouts.app')

@section('content')
@php($header = 'Standar WHO (LMS)')

<form method="get" class="mb-5 grid grid-cols-1 md:grid-cols-4 gap-3">
    <div>
        <label class="block text-xs text-slate-600 mb-1">Indikator</label>
        <select name="indicator" class="w-full rounded border-slate-300 focus:border-brand-400 focus:ring-brand-400">
            <option value="">Semua</option>
            <option value="wfa" @selected($indicator==='wfa' )>BB/U</option>
            <option value="hfa" @selected($indicator==='hfa' )>TB/U</option>
            <option value="wfh" @selected($indicator==='wfh' )>BB/TB</option>
        </select>
    </div>
    <div>
        <label class="block text-xs text-slate-600 mb-1">Jenis Kelamin</label>
        <select name="gender" class="w-full rounded border-slate-300 focus:border-brand-400 focus:ring-brand-400">
            <option value="">Semua</option>
            <option value="male" @selected($gender==='male' )>Laki-laki</option>
            <option value="female" @selected($gender==='female' )>Perempuan</option>
        </select>
    </div>
    <div class="flex items-end gap-2">
        <button class="px-3 py-2 rounded border border-slate-300 hover:bg-slate-50">Filter</button>
        <a href="{{ route('growth-standards.index') }}"
            class="px-3 py-2 rounded border border-slate-300 hover:bg-slate-50">Reset</a>
    </div>
</form>

@if ($items->count() === 0)
<div class="text-center text-slate-500 py-12">
    Belum ada data standar.
</div>
@else
<div class="overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead>
            <tr class="bg-slate-50 text-slate-700">
                <th class="text-left px-3 py-2 border-b">Indikator</th>
                <th class="text-left px-3 py-2 border-b">JK</th>
                <th class="text-left px-3 py-2 border-b">Usia (bln)</th>
                <th class="text-left px-3 py-2 border-b">Panjang/Tinggi (cm)</th>
                <th class="text-left px-3 py-2 border-b">L</th>
                <th class="text-left px-3 py-2 border-b">M</th>
                <th class="text-left px-3 py-2 border-b">S</th>
                <th class="text-right px-3 py-2 border-b">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $row)
            <tr class="hover:bg-slate-50">
                <td class="px-3 py-2 border-b">{{ strtoupper($row->indicator) }}</td>
                <td class="px-3 py-2 border-b">{{ $row->gender === 'male' ? 'L' : 'P' }}</td>
                <td class="px-3 py-2 border-b">{{ $row->age_months ?? '-' }}</td>
                <td class="px-3 py-2 border-b">{{ $row->length_height_cm ?? '-' }}</td>
                <td class="px-3 py-2 border-b">{{ number_format($row->l, 5) }}</td>
                <td class="px-3 py-2 border-b">{{ number_format($row->m, 4) }}</td>
                <td class="px-3 py-2 border-b">{{ number_format($row->s, 5) }}</td>
                <td class="px-3 py-2 border-b text-right">
                    <a href="{{ route('growth-standards.show', $row) }}"
                        class="px-2 py-1 rounded border border-slate-300 hover:bg-slate-50">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $items->links() }}
</div>
@endif
@endsection
