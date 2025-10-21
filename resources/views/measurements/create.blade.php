@extends('layouts.app')

@section('content')
@php($header = '📏 Tambah Pengukuran')

<div class="card-cute">
    <!-- Header dengan ilustrasi -->
    <div class="mb-6 text-center">
        <div class="text-5xl mb-3">📏💕</div>
        <h2 class="text-xl font-semibold text-slate-800 mb-1">Catat Hasil Pengukuran</h2>
        <p class="text-sm text-slate-600">Input data pengukuran untuk monitoring tumbuh kembang anak</p>
    </div>

    <form method="post" action="{{ route('measurements.store') }}" class="space-y-6">
        @csrf

        <!-- Info Helper -->
        <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <div class="text-2xl">💡</div>
                <div class="flex-1 text-sm text-blue-800">
                    <strong>Penting:</strong> Pastikan pengukuran dilakukan dengan benar dan akurat. Data ini akan
                    digunakan untuk menghitung status gizi dan stunting anak.
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pilih Anak -->
            <div class="md:col-span-2">
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>👶</span>
                        <span>Pilih Anak <span class="text-rose-600">*</span></span>
                    </span>
                </label>
                <select name="child_id" class="input-field @error('child_id') input-error @enderror">
                    <option value="">Pilih anak yang akan diukur</option>
                    @foreach ($children as $c)
                    <option value="{{ $c->id }}" @selected(old('child_id', $prefillChildId ?? null)==$c->id)>
                        {{ $c->name }} - {{ $c->gender === 'male' ? '👦 Laki-laki' : '👧 Perempuan' }}
                    </option>
                    @endforeach
                </select>
                <p class="form-helper">Pilih nama anak yang akan diukur hari ini</p>
                @error('child_id') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <!-- Tanggal Ukur -->
            <div>
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>📅</span>
                        <span>Tanggal Pengukuran <span class="text-rose-600">*</span></span>
                    </span>
                </label>
                <input type="date" name="measured_at" value="{{ old('measured_at', now()->toDateString()) }}"
                    class="input-field @error('measured_at') input-error @enderror">
                <p class="form-helper">Tanggal pelaksanaan pengukuran</p>
                @error('measured_at') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <!-- Berat Badan -->
            <div>
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>⚖️</span>
                        <span>Berat Badan (kg) <span class="text-rose-600">*</span></span>
                    </span>
                </label>
                <input type="number" name="weight" step="0.01" min="0.5" max="60" value="{{ old('weight') }}"
                    placeholder="Contoh: 12.5" class="input-field @error('weight') input-error @enderror">
                <p class="form-helper">Berat badan dalam kilogram (0.5 - 60 kg)</p>
                @error('weight') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <!-- Tinggi/Panjang Badan -->
            <div>
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>📏</span>
                        <span>Tinggi/Panjang Badan (cm) <span class="text-rose-600">*</span></span>
                    </span>
                </label>
                <input type="number" name="height" step="0.1" min="25" max="130" value="{{ old('height') }}"
                    placeholder="Contoh: 85.5" class="input-field @error('height') input-error @enderror">
                <p class="form-helper">Tinggi/panjang badan dalam cm (25 - 130 cm)</p>
                @error('height') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <!-- Lingkar Kepala -->
            <div>
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>🎯</span>
                        <span>Lingkar Kepala (cm) - Opsional</span>
                    </span>
                </label>
                <input type="number" name="head_circumference" step="0.1" min="20" max="60"
                    value="{{ old('head_circumference') }}" placeholder="Contoh: 45.0"
                    class="input-field @error('head_circumference') input-error @enderror">
                <p class="form-helper">Lingkar kepala dalam cm (20 - 60 cm)</p>
                @error('head_circumference') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <!-- Catatan -->
            <div class="md:col-span-2">
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>📝</span>
                        <span>Catatan Tambahan - Opsional</span>
                    </span>
                </label>
                <textarea name="notes" rows="3"
                    placeholder="Tambahkan catatan seperti kondisi anak, keluhan ibu, dll..."
                    class="input-field @error('notes') input-error @enderror">{{ old('notes') }}</textarea>
                <p class="form-helper">Catatan penting terkait kondisi atau keluhan</p>
                @error('notes') <div class="error-message">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Tips Pengukuran -->
        <div class="bg-pink-50 border-2 border-pink-200 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <div class="text-2xl">📋</div>
                <div class="flex-1">
                    <h4 class="font-semibold text-pink-900 mb-1">Tips Pengukuran Akurat</h4>
                    <ul class="text-sm text-pink-800 space-y-1 list-disc list-inside">
                        <li><strong>Berat Badan:</strong> Ukur dengan timbangan digital, anak pakai pakaian tipis</li>
                        <li><strong>Tinggi Badan:</strong> Anak usia ≥2 tahun berdiri, <2 tahun berbaring</li>
                        <li><strong>Lingkar Kepala:</strong> Ukur bagian paling lebar kepala dengan pita meter</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="pt-4 flex items-center gap-3 border-t border-slate-200">
            <a href="{{ url()->previous() }}" class="btn-secondary">
                <span>← Kembali</span>
            </a>
            <button type="submit" class="btn-primary">
                <span>💾 Simpan Pengukuran</span>
            </button>
        </div>
    </form>
</div>

<!-- Decorative Elements -->
<div class="fixed bottom-4 right-4 text-6xl opacity-10 pointer-events-none animate-float"
    style="animation-delay: 0.5s;">
    📏
</div>
<div class="fixed top-20 right-20 text-4xl opacity-10 pointer-events-none animate-float" style="animation-delay: 1s;">
    ⚖️
</div>

@endsection