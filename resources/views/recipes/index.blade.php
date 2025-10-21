@extends('layouts.app')

@section('content')
@php($header = 'Resep Makanan Sehat')

<div class="flex items-center justify-between mb-4">
    <h1 class="text-lg font-semibold">Resep Sehat</h1>
</div>

<form method="get" class="mb-5 grid grid-cols-1 md:grid-cols-3 gap-3">
    <div>
        <input type="text" name="q" value="{{ $q }}" placeholder="Cari judul resep..."
            class="w-full rounded border-slate-300 focus:border-brand-400 focus:ring-brand-400">
    </div>
    <div>
        <select name="age_category" class="w-full rounded border-slate-300 focus:border-brand-400 focus:ring-brand-400">
            <option value="">Semua Kelompok Usia</option>
            @foreach ($ageCategories as $key => $label)
            <option value="{{ $key }}" @selected($age==$key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex gap-2">
        <button class="px-3 py-2 rounded border border-slate-300 hover:bg-slate-50">Filter</button>
        <a href="{{ route('recipes.index') }}"
            class="px-3 py-2 rounded border border-slate-300 hover:bg-slate-50">Reset</a>
    </div>
</form>

@if ($items->count() === 0)
<div class="text-center text-slate-500 py-12">
    Belum ada resep yang dipublikasikan.
</div>
@else
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    @foreach ($items as $item)
    <a href="{{ route('recipes.show', $item) }}"
        class="block bg-white border border-slate-200 rounded-lg overflow-hidden hover:shadow-sm">
        <div class="h-36 bg-slate-100 flex items-center justify-center">
            @if ($item->image_path)
            <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" class="h-full w-full object-cover">
            @else
            <span class="text-slate-400 text-sm">Tidak ada gambar</span>
            @endif
        </div>
        <div class="p-4">
            <div class="text-xs text-slate-500 mb-1">
                {{ $ageCategories[$item->age_category] ?? ucfirst(str_replace('_',' ',$item->age_category)) }}
            </div>
            <div class="font-medium text-slate-900">{{ $item->title }}</div>
        </div>
    </a>
    @endforeach
</div>

<div class="mt-4">
    {{ $items->links() }}
</div>
@endif
@endsection
