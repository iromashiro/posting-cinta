@extends('layouts.app')

@section('content')
@php($header = 'Detail Posyandu')

<div class="flex items-center justify-between mb-4">
    <h1 class="text-lg font-semibold">{{ $posyandu->name }}</h1>
    <div class="flex gap-2">
        <a href="{{ route('posyandu.edit', $posyandu) }}"
            class="px-3 py-2 rounded border border-slate-300 hover:bg-slate-50">Edit</a>
        <form method="post" action="{{ route('posyandu.destroy', $posyandu) }}" x-data
            @submit.prevent="if(confirm('Hapus posyandu ini?')) $el.submit()">
            @csrf
            @method('DELETE')
            <button class="px-3 py-2 rounded border border-rose-300 text-rose-700 hover:bg-rose-50">Hapus</button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="p-4 rounded border border-slate-200 bg-slate-50">
        <div class="text-xs text-slate-500 mb-1">Puskesmas</div>
        <div class="font-medium">{{ optional($posyandu->puskesmas)->name ?? '-' }}</div>
    </div>
    <div class="p-4 rounded border border-slate-200 bg-slate-50">
        <div class="text-xs text-slate-500 mb-1">Kader PJ</div>
        <div class="font-medium">{{ optional($posyandu->kader)->name ?? '-' }}</div>
    </div>
    <div class="p-4 rounded border border-slate-200 bg-slate-50">
        <div class="text-xs text-slate-500 mb-1">Status</div>
        <div>
            @if ($posyandu->is_active)
            <span
                class="text-emerald-700 bg-emerald-50 border border-emerald-200 text-xs px-2 py-1 rounded">Aktif</span>
            @else
            <span class="text-slate-600 bg-slate-50 border border-slate-200 text-xs px-2 py-1 rounded">Nonaktif</span>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="space-y-3">
        <div>
            <div class="text-xs text-slate-500 mb-1">Alamat</div>
            <div class="rounded border border-slate-200 bg-white p-3 min-h-[64px]">{{ $posyandu->address ?: '-' }}</div>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <div class="text-xs text-slate-500 mb-1">Desa/Kelurahan</div>
                <div class="rounded border border-slate-200 bg-white p-3">{{ $posyandu->village ?: '-' }}</div>
            </div>
            <div>
                <div class="text-xs text-slate-500 mb-1">Kecamatan</div>
                <div class="rounded border border-slate-200 bg-white p-3">{{ $posyandu->district ?: '-' }}</div>
            </div>
        </div>
        <div>
            <div class="text-xs text-slate-500 mb-1">Telepon</div>
            <div class="rounded border border-slate-200 bg-white p-3">{{ $posyandu->phone ?: '-' }}</div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div class="p-4 rounded border border-slate-200 bg-white text-center">
            <div class="text-3xl font-semibold text-slate-800">{{ $posyandu->mothers->count() }}</div>
            <div class="text-xs text-slate-500 mt-1">Ibu Terdata</div>
        </div>
        <div class="p-4 rounded border border-slate-200 bg-white text-center">
            <div class="text-3xl font-semibold text-slate-800">{{ $posyandu->children->count() }}</div>
            <div class="text-xs text-slate-500 mt-1">Anak Terdata</div>
        </div>
    </div>
</div>

<div class="mt-6">
    <a href="{{ route('posyandu.index') }}"
        class="inline-flex items-center px-3 py-2 rounded border border-slate-300 hover:bg-slate-50">Kembali</a>
</div>
@endsection
