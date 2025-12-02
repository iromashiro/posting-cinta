@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Edit Resep</h1>
    <p class="page-subtitle">Perbarui informasi resep "{{ $recipe->title }}"</p>
</div>

<div class="card card-padding">
    <form method="post" action="{{ route('recipes.update', $recipe) }}" enctype="multipart/form-data" class="space-y-6">
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
                    <strong>Tips:</strong> Perubahan akan langsung diterapkan setelah disimpan. Data bertanda <span
                        class="text-red-600 font-bold">*</span> wajib diisi.
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Judul Resep -->
            <div>
                <label class="input-label">
                    Judul Resep <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title', $recipe->title) }}"
                    placeholder="Contoh: Bubur Ayam Wortel" class="input-field @error('title') input-error @enderror">
                <p class="input-helper">Nama resep yang mudah diingat</p>
                @error('title') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Slug -->
            <div>
                <label class="input-label">Slug URL</label>
                <input type="text" name="slug" value="{{ old('slug', $recipe->slug) }}" placeholder="bubur-ayam-wortel"
                    class="input-field @error('slug') input-error @enderror">
                <p class="input-helper">Akan di-generate otomatis jika dikosongkan</p>
                @error('slug') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Kategori Usia -->
            <div>
                <label class="input-label">
                    Kategori Usia <span class="text-red-500">*</span>
                </label>
                <select name="age_category" class="input-field @error('age_category') input-error @enderror">
                    <option value="">Pilih Kategori Usia</option>
                    @foreach ($ageCategories as $key => $label)
                    <option value="{{ $key }}" @selected(old('age_category', $recipe->age_category)==$key)>{{ $label }}
                    </option>
                    @endforeach
                </select>
                <p class="input-helper">Kelompok usia anak yang cocok untuk resep ini</p>
                @error('age_category') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Gambar -->
            <div
                x-data="{ previewUrl: null, useUrl: {{ $recipe->image_path && !str_starts_with($recipe->image_path, 'storage/') ? 'true' : 'false' }} }">
                <label class="input-label">Gambar Resep</label>

                <!-- Current Image Preview -->
                @if($recipe->image_path)
                <div class="mb-3 p-3 bg-neutral-50 rounded-lg border border-neutral-200">
                    <p class="text-xs text-neutral-500 mb-2">Gambar saat ini:</p>
                    <div class="flex items-center gap-3">
                        <img src="{{ asset($recipe->image_path) }}" alt="{{ $recipe->title }}"
                            class="w-20 h-20 object-cover rounded-lg">
                        <div class="text-sm text-neutral-600">
                            <p>{{ basename($recipe->image_path) }}</p>
                            <p class="text-xs text-neutral-400">Upload gambar baru untuk mengganti</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Toggle Upload/URL -->
                <div class="flex items-center gap-4 mb-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="radio" x-model="useUrl" :value="false" class="w-4 h-4 text-primary-500">
                        <span class="text-sm text-neutral-700">Upload File</span>
                    </label>
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="radio" x-model="useUrl" :value="true" class="w-4 h-4 text-primary-500">
                        <span class="text-sm text-neutral-700">URL Gambar</span>
                    </label>
                </div>

                <!-- Upload File -->
                <div x-show="!useUrl">
                    <input type="file" name="image" accept="image/*"
                        @change="previewUrl = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                        class="input-field @error('image') input-error @enderror">
                    <p class="input-helper">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengganti.
                    </p>

                    <!-- Preview -->
                    <div x-show="previewUrl" class="mt-2">
                        <p class="text-xs text-neutral-500 mb-1">Gambar baru:</p>
                        <img :src="previewUrl" alt="Preview" class="w-32 h-32 object-cover rounded-lg border">
                    </div>
                </div>

                <!-- URL Gambar -->
                <div x-show="useUrl">
                    <input type="text" name="image_url"
                        value="{{ old('image_url', !str_starts_with($recipe->image_path ?? '', 'storage/') ? $recipe->image_path : '') }}"
                        placeholder="https://example.com/gambar.jpg"
                        class="input-field @error('image_url') input-error @enderror">
                    <p class="input-helper">URL gambar dari internet</p>
                </div>

                @error('image') <p class="error-message">{{ $message }}</p> @enderror
                @error('image_url') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Bahan-bahan -->
            <div class="md:col-span-2">
                <label class="input-label">
                    Bahan-bahan <span class="text-red-500">*</span>
                </label>
                <textarea name="ingredients" rows="6"
                    placeholder="Tuliskan bahan-bahan yang diperlukan, satu per baris."
                    class="input-field @error('ingredients') input-error @enderror">{{ old('ingredients', $recipe->ingredients) }}</textarea>
                <p class="input-helper">Tuliskan daftar bahan lengkap dengan takaran</p>
                @error('ingredients') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Cara Memasak -->
            <div class="md:col-span-2">
                <label class="input-label">
                    Cara Memasak <span class="text-red-500">*</span>
                </label>
                <textarea name="instructions" rows="8" placeholder="Tuliskan langkah-langkah memasak secara berurutan."
                    class="input-field @error('instructions') input-error @enderror">{{ old('instructions', $recipe->instructions) }}</textarea>
                <p class="input-helper">Jelaskan langkah-langkah memasak dengan detail</p>
                @error('instructions') <p class="error-message">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Informasi Gizi -->
        <div class="border-t border-neutral-200 pt-6">
            <h3 class="font-semibold text-neutral-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Informasi Gizi (Opsional)
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Kalori -->
                <div>
                    <label class="input-label">Kalori (kkal)</label>
                    <input type="number" name="calories" value="{{ old('calories', $recipe->calories) }}"
                        placeholder="Contoh: 250" min="0" max="9999"
                        class="input-field @error('calories') input-error @enderror">
                    @error('calories') <p class="error-message">{{ $message }}</p> @enderror
                </div>

                <!-- Protein -->
                <div>
                    <label class="input-label">Protein (gram)</label>
                    <input type="number" name="protein" value="{{ old('protein', $recipe->protein) }}"
                        placeholder="Contoh: 15" min="0" max="999"
                        class="input-field @error('protein') input-error @enderror">
                    @error('protein') <p class="error-message">{{ $message }}</p> @enderror
                </div>

                <!-- Karbohidrat -->
                <div>
                    <label class="input-label">Karbohidrat (gram)</label>
                    <input type="number" name="carbohydrate" value="{{ old('carbohydrate', $recipe->carbohydrate) }}"
                        placeholder="Contoh: 30" min="0" max="999"
                        class="input-field @error('carbohydrate') input-error @enderror">
                    @error('carbohydrate') <p class="error-message">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Status Publikasi -->
        <div class="border-t border-neutral-200 pt-6">
            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_published" value="1" id="is_published"
                    class="w-5 h-5 text-primary-500 border-neutral-300 rounded focus:ring-primary-400"
                    {{ old('is_published', $recipe->is_published) ? 'checked' : '' }}>
                <label for="is_published" class="cursor-pointer">
                    <span class="font-medium text-neutral-800">Publikasikan Resep</span>
                    <p class="text-sm text-neutral-500">Resep akan terlihat oleh semua pengguna</p>
                </label>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-neutral-200">
            <a href="{{ route('recipes.index') }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<!-- Danger Zone -->
<div class="mt-6 card card-padding bg-red-50 border-red-200">
    <h3 class="font-semibold text-red-800 mb-3 flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        Zona Berbahaya
    </h3>
    <p class="text-sm text-red-700 mb-4">Menghapus resep tidak dapat dibatalkan. Pastikan Anda yakin sebelum
        melanjutkan.</p>
    <form method="post" action="{{ route('recipes.destroy', $recipe) }}" class="inline"
        onsubmit="return confirm('Apakah Anda yakin ingin menghapus resep ini? Tindakan ini tidak dapat dibatalkan.')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-danger">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            Hapus Resep
        </button>
    </form>
</div>
@endsection