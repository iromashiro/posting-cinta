@extends('layouts.app')

@section('content')
@php($header = '✏️ Edit Data Anak')

<div class="card-cute">
    <!-- Header dengan ilustrasi -->
    <div class="mb-6 text-center">
        <div class="text-5xl mb-3">✏️👶</div>
        <h2 class="text-xl font-semibold text-slate-800 mb-1">Edit Data Anak</h2>
        <p class="text-sm text-slate-600">Perbarui informasi anak untuk data yang lebih akurat</p>
    </div>

    <!-- Current Info Display -->
    <div class="bg-purple-50 border-2 border-purple-200 rounded-xl p-4 mb-6">
        <div class="flex items-start gap-3">
            <div class="text-2xl">{{ $child->gender === 'male' ? '👦' : '👧' }}</div>
            <div class="flex-1">
                <h3 class="font-bold text-purple-900">{{ $child->name }}</h3>
                <p class="text-sm text-purple-700 mt-1">
                    {{ \Illuminate\Support\Carbon::parse($child->date_of_birth)->format('d M Y') }}
                    ({{ \Illuminate\Support\Carbon::parse($child->date_of_birth)->age }} tahun)
                </p>
            </div>
        </div>
    </div>

    <form method="post" action="{{ route('children.update', $child) }}" class="space-y-6">
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
            <div>
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>🏥</span>
                        <span>Posyandu <span class="text-rose-600">*</span></span>
                    </span>
                </label>
                <select name="posyandu_id" class="input-field @error('posyandu_id') input-error @enderror">
                    <option value="">Pilih Posyandu</option>
                    @foreach ($posyandus as $p)
                    <option value="{{ $p->id }}" @selected(old('posyandu_id', $child->posyandu_id) ==
                        $p->id)>{{ $p->name }}</option>
                    @endforeach
                </select>
                <p class="form-helper">Posyandu tempat anak terdaftar</p>
                @error('posyandu_id') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <!-- Ibu -->
            <div>
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>👩</span>
                        <span>Nama Ibu <span class="text-rose-600">*</span></span>
                    </span>
                </label>
                <select name="mother_id" class="input-field @error('mother_id') input-error @enderror">
                    <option value="">Pilih Ibu</option>
                    @foreach ($mothers as $m)
                    <option value="{{ $m->id }}" @selected(old('mother_id', $child->mother_id) == $m->id)>{{ $m->name }}
                    </option>
                    @endforeach
                </select>
                <p class="form-helper">Ibu dari anak ini</p>
                @error('mother_id') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <!-- Nama Anak -->
            <div>
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>👶</span>
                        <span>Nama Anak <span class="text-rose-600">*</span></span>
                    </span>
                </label>
                <input type="text" name="name" value="{{ old('name', $child->name) }}"
                    placeholder="Masukkan nama lengkap anak" class="input-field @error('name') input-error @enderror">
                <p class="form-helper">Nama lengkap sesuai akta kelahiran</p>
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
                <input type="text" name="nik" value="{{ old('nik', $child->nik) }}"
                    placeholder="Nomor Induk Kependudukan" class="input-field @error('nik') input-error @enderror">
                <p class="form-helper">16 digit NIK anak jika sudah ada</p>
                @error('nik') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <!-- Jenis Kelamin -->
            <div>
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>👧👦</span>
                        <span>Jenis Kelamin <span class="text-rose-600">*</span></span>
                    </span>
                </label>
                <div class="flex items-center gap-6 mt-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="gender" value="male"
                            class="w-4 h-4 text-brand-500 border-slate-300 focus:ring-brand-400" @checked(old('gender',
                            $child->gender) === 'male')>
                        <span class="text-sm font-medium text-slate-700">👦 Laki-laki</span>
                    </label>
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="gender" value="female"
                            class="w-4 h-4 text-brand-500 border-slate-300 focus:ring-brand-400" @checked(old('gender',
                            $child->gender) === 'female')>
                        <span class="text-sm font-medium text-slate-700">👧 Perempuan</span>
                    </label>
                </div>
                <p class="form-helper">Pilih jenis kelamin anak</p>
                @error('gender') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <!-- Tanggal Lahir -->
            <div>
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>🎂</span>
                        <span>Tanggal Lahir <span class="text-rose-600">*</span></span>
                    </span>
                </label>
                <input type="date" name="date_of_birth"
                    value="{{ old('date_of_birth', \Illuminate\Support\Carbon::parse($child->date_of_birth)->toDateString()) }}"
                    class="input-field @error('date_of_birth') input-error @enderror">
                <p class="form-helper">Tanggal lahir sesuai akta kelahiran</p>
                @error('date_of_birth') <div class="error-message">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Warning Box -->
        <div class="bg-amber-50 border-2 border-amber-200 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <div class="text-2xl">⚠️</div>
                <div class="flex-1 text-sm text-amber-800">
                    <strong>Catatan:</strong> Perubahan tanggal lahir akan mempengaruhi perhitungan usia dan status gizi
                    pada pengukuran yang sudah ada.
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="pt-4 flex items-center gap-3 border-t border-slate-200">
            <a href="{{ route('children.show', $child) }}" class="btn-secondary">
                <span>← Batal</span>
            </a>
            <button type="submit" class="btn-primary">
                <span>💾 Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>

@endsection