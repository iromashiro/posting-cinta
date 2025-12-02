@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Edit Data Ibu</h1>
    <p class="page-subtitle">Perbarui informasi ibu untuk data yang lebih akurat</p>
</div>

<div class="card card-padding">
    <!-- Current Info Display -->
    <div class="bg-primary-50 border border-primary-200 rounded-lg p-4 mb-6">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-primary-900">{{ $mother->name }}</h3>
                <div class="text-sm text-primary-700 mt-1 space-y-1">
                    @if($mother->nik)
                    <p>NIK: {{ $mother->nik }}</p>
                    @endif
                    @if($mother->phone)
                    <p>{{ $mother->phone }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ route('mothers.update', $mother) }}" class="space-y-6">
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
                    <strong>Perhatian:</strong> Pastikan perubahan data sudah benar. Data bertanda <span
                        class="text-red-600 font-bold">*</span> wajib diisi.
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Posyandu -->
            <div class="md:col-span-2">
                <label class="input-label">
                    Posyandu <span class="text-red-500">*</span>
                </label>
                <select name="posyandu_id" class="input-field @error('posyandu_id') input-error @enderror">
                    <option value="">Pilih Posyandu</option>
                    @foreach ($posyandus as $p)
                    <option value="{{ $p->id }}" @selected(old('posyandu_id', $mother->posyandu_id) ==
                        $p->id)>{{ $p->name }}</option>
                    @endforeach
                </select>
                <p class="input-helper">Posyandu tempat ibu terdaftar</p>
                @error('posyandu_id') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Nama Ibu -->
            <div>
                <label class="input-label">
                    Nama Ibu <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $mother->name) }}"
                    placeholder="Masukkan nama lengkap ibu" class="input-field @error('name') input-error @enderror">
                <p class="input-helper">Nama lengkap sesuai KTP</p>
                @error('name') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- NIK -->
            <div>
                <label class="input-label">NIK (Opsional)</label>
                <input type="text" name="nik" value="{{ old('nik', $mother->nik) }}"
                    placeholder="Nomor Induk Kependudukan" class="input-field @error('nik') input-error @enderror">
                <p class="input-helper">16 digit NIK sesuai KTP</p>
                @error('nik') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Telepon -->
            <div>
                <label class="input-label">Nomor Telepon (Opsional)</label>
                <input type="text" name="phone" value="{{ old('phone', $mother->phone) }}"
                    placeholder="Contoh: 08123456789" class="input-field @error('phone') input-error @enderror">
                <p class="input-helper">Nomor telepon/WhatsApp yang aktif</p>
                @error('phone') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Alamat -->
            <div class="md:col-span-2">
                <label class="input-label">Alamat Lengkap (Opsional)</label>
                <textarea name="address" rows="3" placeholder="Masukkan alamat lengkap..."
                    class="input-field @error('address') input-error @enderror">{{ old('address', $mother->address) }}</textarea>
                <p class="input-helper">Alamat tempat tinggal untuk kunjungan dan pendampingan</p>
                @error('address') <p class="error-message">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-neutral-200">
            <a href="{{ route('mothers.show', $mother) }}" class="btn-secondary">Batal</a>
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