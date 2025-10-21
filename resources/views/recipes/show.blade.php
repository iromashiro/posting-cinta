@extends('layouts.app')

@section('content')
@php($header = 'Detail Resep')

<div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
    <div class="md:flex">
        <div class="md:w-1/3 bg-slate-50 flex items-center justify-center">
            @if ($recipe->image_path)
            <img src="{{ asset($recipe->image_path) }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover">
            @else
            <div class="h-full w-full flex items-center justify-center text-slate-400 text-sm p-6">
                Tidak ada gambar
            </div>
            @endif
        </div>
        <div class="md:w-2/3 p-5">
            <div class="text-xs text-slate-500 mb-1">
                @php($ageMap = ['mpasi_6_12' => 'MPASI (6-12 bln)', 'balita_1_3' => 'Balita (1-3 thn)', 'anak_3_5' =>
                'Anak (3-5 thn)'])
                {{ $ageMap[$recipe->age_category] ?? ucfirst(str_replace('_',' ',$recipe->age_category)) }}
            </div>
            <h1 class="text-xl font-semibold text-slate-900 mb-3">{{ $recipe->title }}</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="text-sm font-medium text-slate-700 mb-1">Bahan</div>
                    <div class="prose prose-sm max-w-none">
                        {!! nl2br(e($recipe->ingredients)) !!}
                    </div>
                </div>
                <div>
                    <div class="text-sm font-medium text-slate-700 mb-1">Cara Memasak</div>
                    <div class="prose prose-sm max-w-none">
                        {!! nl2br(e($recipe->instructions)) !!}
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div class="text-sm font-medium text-slate-700 mb-2">Info Gizi</div>
                <div class="flex flex-wrap gap-2">
                    @if(!is_null($recipe->calories))
                    <span class="text-xs px-2 py-1 rounded border border-slate-200 bg-slate-50">Kalori:
                        {{ $recipe->calories }} kkal</span>
                    @endif
                    @if(!is_null($recipe->protein))
                    <span class="text-xs px-2 py-1 rounded border border-slate-200 bg-slate-50">Protein:
                        {{ $recipe->protein }} g</span>
                    @endif
                    @if(!is_null($recipe->carbohydrate))
                    <span class="text-xs px-2 py-1 rounded border border-slate-200 bg-slate-50">Karbo:
                        {{ $recipe->carbohydrate }} g</span>
                    @endif
                </div>
                @if (is_array($recipe->nutrition_info) && count($recipe->nutrition_info))
                <div class="mt-2 text-xs text-slate-600">
                    @foreach ($recipe->nutrition_info as $k => $v)
                    <span
                        class="inline-block mr-2 mb-1 px-2 py-1 rounded border border-slate-200 bg-slate-50">{{ ucfirst($k) }}:
                        {{ $v }}</span>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="mt-6">
                <a href="{{ route('recipes.index') }}"
                    class="px-3 py-2 rounded border border-slate-300 hover:bg-slate-50">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
