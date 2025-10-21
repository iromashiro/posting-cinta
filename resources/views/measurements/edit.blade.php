@extends('layouts.app')

@section('content')
@php($header = '✏️ Edit Pengukuran')

<div class="card-cute">
    <!-- Header dengan ilustrasi -->
    <div class="mb-6 text-center">
        <div class="text-5xl mb-3">✏️📏</div>
        <h2 class="text-xl font-semibold text-slate-800 mb-1">Edit Data Pengukuran</h2>
        <p class="text-sm text-slate-600">Perbarui data pengukuran untuk hasil yang lebih akurat</p>
    </div>

    <!-- Current Info Display -->
    <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4 mb-6">
        <div class="flex items-start gap-3">
            <div class="text-2xl">{{ $measurement->child->gender === 'male' ? '👦' : '👧' }}</div>
            <div class="flex-1">
                <h3 class="font-bold text-blue-900">{{ $measurement->child->name }}</h3>
                <div class="text-sm text-blue-700 mt-1 space-y-1">
                    <p>📅 Tanggal: {{ \Illuminate\Support\Carbon::parse($measurement->measured_at)->format('d M Y') }}
                    </p>
                    <p>⚖️ BB: {{ number_format($measurement->weight, 2) }} kg | 📏 TB/PB:
                        {{ number_format($measurement->height, 2) }} cm</p>
                </div>
            </div>
        </div>
    </div>

    <form method="post" action="{{ route('measurements.update', $measurement) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Info Helper -->
        <div class="bg-amber-50 border-2 border-amber-200 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <div class="text-2xl">⚠️</div>
                <div class="flex-1 text-sm text-amber-800">
                    <strong>Perhatian:</strong> Perubahan data akan mempengaruhi perhitungan status gizi. Pastikan data
                    yang dimasukkan sudah benar.
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pilih Anak -->
            <div class="md:col-span-2">
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>👶</span>
                        <span>Nama Anak <span class="text-rose-600">*</span></span>
                    </span>
                </label>
                <select name="child_id" class="input-field @error('child_id') input-error @enderror">
                    @foreach ($children as $c)
                    <option value="{{ $c->id }}" @selected(old('child_id', $measurement->child_id) == $c->id)>
                        {{ $c->name }} - {{ $c->gender === 'male' ? '👦 Laki-laki' : '👧 Perempuan' }}
                    </option>
                    @endforeach
                </select>
                <p class="form-helper">Nama anak yang diukur</p>
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
                <input type="date" name="measured_at"
                    value="{{ old('measured_at', \Illuminate\Support\Carbon::parse($measurement->measured_at)->toDateString()) }}"
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
                <input type="number" name="weight" step="0.01" min="0.5" max="60"
                    value="{{ old('weight', $measurement->weight) }}" placeholder="Contoh: 12.5"
                    class="input-field @error('weight') input-error @enderror">
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
                <input type="number" name="height" step="0.1" min="25" max="130"
                    value="{{ old('height', $measurement->height) }}" placeholder="Contoh: 85.5"
                    class="input-field @error('height') input-error @enderror">
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
                    value="{{ old('head_circumference', $measurement->head_circumference) }}" placeholder="Contoh: 45.0"
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
                    class="input-field @error('notes') input-error @enderror">{{ old('notes', $measurement->notes) }}</textarea>
                <p class="form-helper">Catatan penting terkait kondisi atau keluhan</p>
                @error('notes') <div class="error-message">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="pt-4 flex items-center gap-3 border-t border-slate-200">
            <a href="{{ route('children.show', $measurement->child_id) }}" class="btn-secondary">
                <span>← Batal</span>
            </a>
            <button type="submit" class="btn-primary">
                <span>💾 Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>

@endsection