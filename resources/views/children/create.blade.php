@extends('layouts.app')

@section('content')
@php($header = '👶 Tambah Anak Baru')

<div class="card-cute">
    <!-- Header dengan ilustrasi -->
    <div class="mb-6 text-center">
        <div class="text-5xl mb-3">👶💕</div>
        <h2 class="text-xl font-semibold text-slate-800 mb-1">Daftarkan Anak Baru</h2>
        <p class="text-sm text-slate-600">Lengkapi data anak untuk mulai memantau tumbuh kembangnya</p>
    </div>

    <form method="post" action="{{ route('children.store') }}" class="space-y-6">
        @csrf

        <!-- Info Helper -->
        <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <div class="text-2xl">💡</div>
                <div class="flex-1 text-sm text-blue-800">
                    <strong>Tips:</strong> Pastikan data yang dimasukkan akurat untuk hasil pemantauan yang tepat. Data
                    bertanda <span class="text-rose-600 font-bold">*</span> wajib diisi.
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
                    <option value="{{ $p->id }}" @selected(old('posyandu_id', $prefill['posyandu_id'] ?? null)==$p->
                        id)>{{ $p->name }}</option>
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
                    <option value="{{ $m->id }}" @selected(old('mother_id', $prefill['mother_id'] ?? null)==$m->
                        id)>{{ $m->name }}</option>
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
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap anak"
                    class="input-field @error('name') input-error @enderror">
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
                <input type="text" name="nik" value="{{ old('nik') }}" placeholder="Nomor Induk Kependudukan"
                    class="input-field @error('nik') input-error @enderror">
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
                            class="w-4 h-4 text-brand-500 border-slate-300 focus:ring-brand-400"
                            @checked(old('gender')==='male' )>
                        <span class="text-sm font-medium text-slate-700">👦 Laki-laki</span>
                    </label>
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="gender" value="female"
                            class="w-4 h-4 text-brand-500 border-slate-300 focus:ring-brand-400"
                            @checked(old('gender')==='female' )>
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
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                    class="input-field @error('date_of_birth') input-error @enderror">
                <p class="form-helper">Tanggal lahir sesuai akta kelahiran</p>
                @error('date_of_birth') <div class="error-message">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="pt-4 flex items-center gap-3 border-t border-slate-200">
            <a href="{{ route('children.index') }}" class="btn-secondary">
                <span>← Kembali</span>
            </a>
            <button type="submit" class="btn-primary">
                <span>💾 Simpan Data Anak</span>
            </button>
        </div>
    </form>
</div>

<!-- Decorative Elements -->
<div class="fixed bottom-4 right-4 text-6xl opacity-10 pointer-events-none animate-float"
    style="animation-delay: 0.5s;">
    🍼
</div>
<div class="fixed top-20 right-20 text-4xl opacity-10 pointer-events-none animate-float" style="animation-delay: 1s;">
    ✨
</div>

@endsection