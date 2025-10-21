@extends('layouts.app')

@section('content')
@php($header = 'Daftar Posyandu')

<div class="flex items-center justify-between mb-4">
    <h1 class="text-lg font-semibold">Posyandu</h1>
    <a href="{{ route('posyandu.create') }}"
        class="inline-flex items-center px-3 py-2 rounded bg-brand-500 text-white hover:bg-brand-600">
        + Tambah Posyandu
    </a>
</div>

<form method="get" class="mb-5 grid grid-cols-1 md:grid-cols-3 gap-3">
    <div>
        <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama posyandu..."
            class="w-full rounded border-slate-300 focus:border-brand-400 focus:ring-brand-400">
    </div>
    <div>
        <select name="puskesmas_id" class="w-full rounded border-slate-300 focus:border-brand-400 focus:ring-brand-400">
            <option value="">Semua Puskesmas</option>
            @foreach ($puskesmas as $p)
            <option value="{{ $p->id }}" @selected($puskesmasId==$p->id)>{{ $p->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex gap-2">
        <button class="px-3 py-2 rounded border border-slate-300 hover:bg-slate-50">Filter</button>
        <a href="{{ route('posyandu.index') }}"
            class="px-3 py-2 rounded border border-slate-300 hover:bg-slate-50">Reset</a>
    </div>
</form>

@if ($items->count() === 0)
<div class="text-center text-slate-500 py-12">
    Belum ada data posyandu.
</div>
@else
<div class="overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead>
            <tr class="bg-slate-50 text-slate-700">
                <th class="text-left px-3 py-2 border-b">Nama</th>
                <th class="text-left px-3 py-2 border-b">Puskesmas</th>
                <th class="text-left px-3 py-2 border-b">Kader</th>
                <th class="text-left px-3 py-2 border-b">Status</th>
                <th class="text-right px-3 py-2 border-b">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr class="hover:bg-slate-50">
                <td class="px-3 py-2 border-b">
                    <a href="{{ route('posyandu.show', $item) }}" class="text-brand-600 hover:underline font-medium">
                        {{ $item->name }}
                    </a>
                    <div class="text-xs text-slate-500">
                        {{ $item->village ? $item->village . ', ' : '' }}{{ $item->district }}
                    </div>
                </td>
                <td class="px-3 py-2 border-b">
                    {{ optional($item->puskesmas)->name ?? '-' }}
                </td>
                <td class="px-3 py-2 border-b">
                    {{ optional($item->kader)->name ?? '-' }}
                </td>
                <td class="px-3 py-2 border-b">
                    @if ($item->is_active)
                    <span
                        class="text-emerald-700 bg-emerald-50 border border-emerald-200 text-xs px-2 py-1 rounded">Aktif</span>
                    @else
                    <span
                        class="text-slate-600 bg-slate-50 border border-slate-200 text-xs px-2 py-1 rounded">Nonaktif</span>
                    @endif
                </td>
                <td class="px-3 py-2 border-b text-right">
                    <div class="inline-flex gap-2" x-data="{ open:false }">
                        <a href="{{ route('posyandu.edit', $item) }}"
                            class="px-2 py-1 rounded border border-slate-300 hover:bg-slate-50">Edit</a>
                        <form method="post" action="{{ route('posyandu.destroy', $item) }}" x-data
                            @submit.prevent="if(confirm('Hapus posyandu ini?')) $el.submit()">
                            @csrf
                            @method('DELETE')
                            <button
                                class="px-2 py-1 rounded border border-rose-300 text-rose-700 hover:bg-rose-50">Hapus</button>
                        </form>
                    </div>
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
