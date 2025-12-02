@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Edit Posyandu</h1>
    <p class="page-subtitle">Perbarui data posyandu {{ $posyandu->name }}</p>
</div>

<div class="card card-padding">
    <form method="post" action="{{ route('posyandu.update', $posyandu) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Info Helper -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1 text-sm text-blue-800">
                    <strong>Tips:</strong> Pastikan data yang dimasukkan sudah benar. Data bertanda <span
                        class="text-red-600 font-bold">*</span> wajib diisi.
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Puskesmas -->
            <div>
                <label class="input-label">
                    Puskesmas <span class="text-red-500">*</span>
                </label>
                <select name="puskesmas_id" class="input-field @error('puskesmas_id') input-error @enderror">
                    <option value="">Pilih Puskesmas</option>
                    @foreach ($puskesmas as $p)
                    <option value="{{ $p->id }}" @selected(old('puskesmas_id', $posyandu->
                        puskesmas_id)==$p->id)>{{ $p->name }}</option>
                    @endforeach
                </select>
                <p class="input-helper">Puskesmas yang membawahi posyandu ini</p>
                @error('puskesmas_id') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Nama Posyandu -->
            <div>
                <label class="input-label">
                    Nama Posyandu <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $posyandu->name) }}"
                    placeholder="Masukkan nama posyandu" class="input-field @error('name') input-error @enderror">
                <p class="input-helper">Nama lengkap posyandu</p>
                @error('name') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Desa/Kelurahan -->
            <div>
                <label class="input-label">Desa/Kelurahan</label>
                <input type="text" name="village" value="{{ old('village', $posyandu->village) }}"
                    placeholder="Nama desa atau kelurahan" class="input-field @error('village') input-error @enderror">
                <p class="input-helper">Desa/kelurahan lokasi posyandu</p>
                @error('village') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Kecamatan -->
            <div>
                <label class="input-label">Kecamatan</label>
                <input type="text" name="district" value="{{ old('district', $posyandu->district) }}"
                    placeholder="Nama kecamatan" class="input-field @error('district') input-error @enderror">
                <p class="input-helper">Kecamatan lokasi posyandu</p>
                @error('district') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Alamat -->
            <div class="md:col-span-2">
                <label class="input-label">Alamat Lengkap</label>
                <textarea name="address" rows="3" placeholder="Alamat lengkap posyandu"
                    class="input-field @error('address') input-error @enderror">{{ old('address', $posyandu->address) }}</textarea>
                <p class="input-helper">Alamat detail untuk memudahkan pencarian lokasi</p>
                @error('address') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Telepon -->
            <div>
                <label class="input-label">Telepon</label>
                <input type="text" name="phone" value="{{ old('phone', $posyandu->phone) }}" placeholder="Nomor telepon"
                    class="input-field @error('phone') input-error @enderror">
                <p class="input-helper">Nomor telepon yang dapat dihubungi</p>
                @error('phone') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Kader PJ -->
            <div>
                <label class="input-label">Kader Penanggung Jawab</label>
                <select name="kader_id" class="input-field @error('kader_id') input-error @enderror">
                    <option value="">Pilih Kader</option>
                    @foreach ($kaders as $k)
                    <option value="{{ $k->id }}" @selected(old('kader_id', $posyandu->kader_id)==$k->id)>{{ $k->name }}
                    </option>
                    @endforeach
                </select>
                <p class="input-helper">Kader yang bertanggung jawab atas posyandu ini</p>
                @error('kader_id') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Status Aktif -->
            <div class="md:col-span-2">
                <label class="input-label">Status</label>
                <div class="flex items-center gap-3 mt-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active',
                            $posyandu->is_active))
                        class="w-4 h-4 text-primary-500 border-neutral-300 rounded focus:ring-primary-400">
                        <span class="text-sm font-medium text-neutral-700">Posyandu Aktif</span>
                    </label>
                </div>
                <p class="input-helper">Centang jika posyandu sedang beroperasi aktif</p>
                @error('is_active') <p class="error-message">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-neutral-200">
            <a href="{{ route('posyandu.show', $posyandu) }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection