@extends('layouts.app')

@section('content')
@php($header = '✏️ Edit Data Ibu')

<div class="card-cute">
    <!-- Header dengan ilustrasi -->
    <div class="mb-6 text-center">
        <div class="text-5xl mb-3">✏️👩</div>
        <h2 class="text-xl font-semibold text-slate-800 mb-1">Edit Data Ibu</h2>
        <p class="text-sm text-slate-600">Perbarui informasi ibu untuk data yang lebih akurat</p>
    </div>

    <!-- Current Info Display -->
    <div class="bg-pink-50 border-2 border-pink-200 rounded-xl p-4 mb-6">
        <div class="flex items-start gap-3">
            <div class="text-2xl">👩</div>
            <div class="flex-1">
                <h3 class="font-bold text-pink-900">{{ $mother->name }}</h3>
                <div class="text-sm text-pink-700 mt-1 space-y-1">
                    @if($mother->nik)
                    <p class="flex items-center gap-1">
                        <span>🆔</span>
                        <span>NIK: {{ $mother->nik }}</span>
                    </p>
                    @endif
                    @if($mother->phone)
                    <p class="flex items-center gap-1">
                        <span>📱</span>
                        <span>{{ $mother->phone }}</span>
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ route('mothers.update', $mother) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Info Helper -->
        <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <div class="text-2xl">💡</div>
                <div class="flex-1 text-sm text-blue-800">
                    <strong>Perhatian:</strong> Pastikan perubahan data sudah benar. Data bertanda <span
                        class="text-rose-600 font-bold">*</span> wajib diisi.
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Posyandu -->
            <div class="md:col-span-2">
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>🏥</span>
                        <span>Posyandu <span class="text-rose-600">*</span></span>
                    </span>
                </label>
                <select name="posyandu_id" class="input-field @error('posyandu_id') input-error @enderror">
                    <option value="">Pilih Posyandu</option>
                    @foreach ($posyandus as $p)
                    <option value="{{ $p->id }}" @selected(old('posyandu_id', $mother->posyandu_id) ==
                        $p->id)>{{ $p->name }}</option>
                    @endforeach
                </select>
                <p class="form-helper">Posyandu tempat ibu terdaftar</p>
                @error('posyandu_id') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <!-- Nama Ibu -->
            <div>
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>👩</span>
                        <span>Nama Ibu <span class="text-rose-600">*</span></span>
                    </span>
                </label>
                <input type="text" name="name" value="{{ old('name', $mother->name) }}"
                    placeholder="Masukkan nama lengkap ibu" class="input-field @error('name') input-error @enderror">
                <p class="form-helper">Nama lengkap sesuai KTP</p>
                @error('name') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <!-- NIK -->
            <div>
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>🆔</span>
                        <span>NIK (Opsional)</span>
                    </span>
                </label>
                <input type="text" name="nik" value="{{ old('nik', $mother->nik) }}"
                    placeholder="Nomor Induk Kependudukan" class="input-field @error('nik') input-error @enderror">
                <p class="form-helper">16 digit NIK sesuai KTP</p>
                @error('nik') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <!-- Telepon -->
            <div>
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>📱</span>
                        <span>Nomor Telepon (Opsional)</span>
                    </span>
                </label>
                <input type="text" name="phone" value="{{ old('phone', $mother->phone) }}"
                    placeholder="Contoh: 08123456789" class="input-field @error('phone') input-error @enderror">
                <p class="form-helper">Nomor telepon/WhatsApp yang aktif</p>
                @error('phone') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <!-- Alamat -->
            <div class="md:col-span-2">
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>🏠</span>
                        <span>Alamat Lengkap (Opsional)</span>
                    </span>
                </label>
                <textarea name="address" rows="3" placeholder="Masukkan alamat lengkap..."
                    class="input-field @error('address') input-error @enderror">{{ old('address', $mother->address) }}</textarea>
                <p class="form-helper">Alamat tempat tinggal untuk kunjungan dan pendampingan</p>
                @error('address') <div class="error-message">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="pt-4 flex items-center gap-3 border-t border-slate-200">
            <a href="{{ route('mothers.show', $mother) }}" class="btn-secondary">
                <span>← Batal</span>
            </a>
            <button type="submit" class="btn-primary">
                <span>💾 Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>

@endsection