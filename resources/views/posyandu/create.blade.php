@extends('layouts.app')

@section('content')
@php($header = 'Tambah Posyandu')

<form method="post" action="{{ route('posyandu.store') }}" class="space-y-4">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm mb-1">Puskesmas <span class="text-rose-600">*</span></label>
            <select name="puskesmas_id"
                class="w-full rounded border-slate-300 focus:border-brand-400 focus:ring-brand-400">
                <option value="">Pilih Puskesmas</option>
                @foreach ($puskesmas as $p)
                <option value="{{ $p->id }}" @selected(old('puskesmas_id')==$p->id)>{{ $p->name }}</option>
                @endforeach
            </select>
            @error('puskesmas_id') <div class="text-xs text-rose-600 mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="block text-sm mb-1">Nama Posyandu <span class="text-rose-600">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="w-full rounded border-slate-300 focus:border-brand-400 focus:ring-brand-400">
            @error('name') <div class="text-xs text-rose-600 mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="block text-sm mb-1">Desa/Kelurahan</label>
            <input type="text" name="village" value="{{ old('village') }}"
                class="w-full rounded border-slate-300 focus:border-brand-400 focus:ring-brand-400">
            @error('village') <div class="text-xs text-rose-600 mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="block text-sm mb-1">Kecamatan</label>
            <input type="text" name="district" value="{{ old('district') }}"
                class="w-full rounded border-slate-300 focus:border-brand-400 focus:ring-brand-400">
            @error('district') <div class="text-xs text-rose-600 mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm mb-1">Alamat</label>
            <textarea name="address" rows="3"
                class="w-full rounded border-slate-300 focus:border-brand-400 focus:ring-brand-400">{{ old('address') }}</textarea>
            @error('address') <div class="text-xs text-rose-600 mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="block text-sm mb-1">Telepon</label>
            <input type="text" name="phone" value="{{ old('phone') }}"
                class="w-full rounded border-slate-300 focus:border-brand-400 focus:ring-brand-400">
            @error('phone') <div class="text-xs text-rose-600 mt-1">{{ $message }}</div> @enderror
        </div>

        <div>
            <label class="block text-sm mb-1">Kader Penanggung Jawab</label>
            <select name="kader_id" class="w-full rounded border-slate-300 focus:border-brand-400 focus:ring-brand-400">
                <option value="">-</option>
                @foreach ($kaders as $k)
                <option value="{{ $k->id }}" @selected(old('kader_id')==$k->id)>{{ $k->name }}</option>
                @endforeach
            </select>
            @error('kader_id') <div class="text-xs text-rose-600 mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', true))
                class="rounded border-slate-300">
            <label for="is_active" class="text-sm">Aktif</label>
            @error('is_active') <div class="text-xs text-rose-600 mt-1">{{ $message }}</div> @enderror
        </div>
    </div>

    <div class="pt-4 flex items-center gap-2">
        <a href="{{ route('posyandu.index') }}"
            class="px-3 py-2 rounded border border-slate-300 hover:bg-slate-50">Batal</a>
        <button class="px-3 py-2 rounded bg-brand-500 text-white hover:bg-brand-600">Simpan</button>
    </div>
</form>
@endsection
