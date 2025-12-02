@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Catat Hasil Pengukuran</h1>
    <p class="page-subtitle">Input data pengukuran untuk monitoring tumbuh kembang anak</p>
</div>

<!-- Success Banner with Next Options -->
@if(session('show_next_options'))
<div class="card card-padding mb-6 bg-green-50 border-green-200">
    <div class="flex items-start gap-3">
        <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <div class="flex-1">
            <p class="font-semibold text-green-800">Pengukuran {{ session('last_child_name') }} berhasil disimpan!</p>
            <p class="text-sm text-green-700 mb-3">Pilih anak lain untuk melanjutkan pengukuran, atau lihat hasil
                pengukuran.</p>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('children.show', session('last_child_id')) }}" class="btn-secondary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Lihat Detail {{ session('last_child_name') }}
                </a>
                <a href="{{ route('measurements.index') }}" class="btn-ghost btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                    </svg>
                    Lihat Semua Pengukuran
                </a>
            </div>
        </div>
    </div>
</div>
@endif

<div class="card card-padding">
    <form method="post" action="{{ route('measurements.store') }}" class="space-y-6" x-data="{ submitting: false }"
        @submit="submitting = true">
        @csrf

        <!-- Info Helper -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1 text-sm text-blue-800">
                    <strong>Penting:</strong> Pastikan pengukuran dilakukan dengan benar dan akurat. Data ini akan
                    digunakan untuk menghitung status gizi dan stunting anak.
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Searchable Dropdown Anak -->
            <div class="md:col-span-2" x-data="searchableDropdown({
                items: {{ Js::from($children->map(fn($c) => [
                    'id' => $c->id,
                    'name' => $c->name,
                    'mother' => $c->mother?->name,
                    'gender' => $c->gender === 'male' ? 'L' : 'P'
                ])) }},
                selectedId: '{{ old('child_id', $prefillChildId ?? '') }}',
                selectedName: '{{ old('child_id') ? $children->firstWhere('id', old('child_id'))?->name : ($prefillChildName ?? '') }}'
            })">
                <label class="input-label">
                    Pilih Anak <span class="text-red-500">*</span>
                </label>

                <!-- Hidden input for form submission -->
                <input type="hidden" name="child_id" x-model="selectedId">

                <div class="relative">
                    <!-- Trigger button -->
                    <button type="button" @click="open = !open"
                        class="input-field text-left flex items-center justify-between w-full @error('child_id') input-error @enderror">
                        <span x-show="!selectedName" class="text-neutral-400">Ketik nama anak atau ibu untuk
                            mencari...</span>
                        <span x-show="selectedName" x-text="selectedName" class="text-neutral-900"></span>
                        <svg class="w-5 h-5 text-neutral-400 flex-shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown panel -->
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute z-50 w-full mt-1 bg-white border border-neutral-200 rounded-lg shadow-lg overflow-hidden">

                        <!-- Search input -->
                        <div class="p-3 border-b border-neutral-100 bg-neutral-50">
                            <div class="relative">
                                <svg class="w-5 h-5 text-neutral-400 absolute left-3 top-1/2 -translate-y-1/2"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input type="text" x-model="search" x-ref="searchInput"
                                    placeholder="Cari nama anak atau ibu..." class="input-field pl-10"
                                    @keydown.escape="open = false" @keydown.enter.prevent="selectFirst()">
                            </div>
                        </div>

                        <!-- Options list -->
                        <ul class="max-h-60 overflow-auto py-1">
                            <template x-for="child in filteredItems" :key="child.id">
                                <li @click="selectItem(child)"
                                    class="px-4 py-3 hover:bg-primary-50 cursor-pointer flex items-center justify-between group">
                                    <div>
                                        <span x-text="child.name" class="font-medium text-neutral-900"></span>
                                        <span x-show="child.mother" class="text-sm text-neutral-500 ml-1">
                                            - Ibu: <span x-text="child.mother"></span>
                                        </span>
                                    </div>
                                    <span x-text="child.gender" class="text-xs font-medium px-2 py-0.5 rounded-full"
                                        :class="child.gender === 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700'"></span>
                                </li>
                            </template>
                            <li x-show="filteredItems.length === 0"
                                class="px-4 py-3 text-neutral-500 text-sm text-center">
                                <svg class="w-8 h-8 mx-auto text-neutral-300 mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Tidak ada anak ditemukan
                            </li>
                        </ul>

                        <!-- Quick add link -->
                        <div class="p-2 border-t border-neutral-100 bg-neutral-50">
                            <a href="{{ route('children.create') }}"
                                class="flex items-center gap-2 text-sm text-primary-600 hover:text-primary-700 font-medium px-2 py-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Anak Baru
                            </a>
                        </div>
                    </div>
                </div>

                <p class="input-helper">Ketik untuk mencari berdasarkan nama anak atau nama ibu</p>
                @error('child_id') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Tanggal Ukur -->
            <div>
                <label class="input-label">
                    Tanggal Pengukuran <span class="text-red-500">*</span>
                </label>
                <input type="date" name="measured_at" value="{{ old('measured_at', now()->toDateString()) }}"
                    class="input-field @error('measured_at') input-error @enderror">
                <p class="input-helper">Tanggal pelaksanaan pengukuran</p>
                @error('measured_at') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Berat Badan -->
            <div>
                <label class="input-label">
                    Berat Badan (kg) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="weight" step="0.01" min="0.5" max="60" value="{{ old('weight') }}"
                    placeholder="Contoh: 12.5" class="input-field @error('weight') input-error @enderror">
                <p class="input-helper">Berat badan dalam kilogram (0.5 - 60 kg)</p>
                @error('weight') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Tinggi/Panjang Badan -->
            <div>
                <label class="input-label">
                    Tinggi/Panjang Badan (cm) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="height" step="0.1" min="25" max="130" value="{{ old('height') }}"
                    placeholder="Contoh: 85.5" class="input-field @error('height') input-error @enderror">
                <p class="input-helper">Tinggi/panjang badan dalam cm (25 - 130 cm)</p>
                @error('height') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Lingkar Kepala -->
            <div>
                <label class="input-label">Lingkar Kepala (cm) - Opsional</label>
                <input type="number" name="head_circumference" step="0.1" min="20" max="60"
                    value="{{ old('head_circumference') }}" placeholder="Contoh: 45.0"
                    class="input-field @error('head_circumference') input-error @enderror">
                <p class="input-helper">Lingkar kepala dalam cm (20 - 60 cm)</p>
                @error('head_circumference') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Catatan -->
            <div class="md:col-span-2">
                <label class="input-label">Catatan Tambahan - Opsional</label>
                <textarea name="notes" rows="3"
                    placeholder="Tambahkan catatan seperti kondisi anak, keluhan ibu, dll..."
                    class="input-field @error('notes') input-error @enderror">{{ old('notes') }}</textarea>
                <p class="input-helper">Catatan penting terkait kondisi atau keluhan</p>
                @error('notes') <p class="error-message">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Tips Pengukuran -->
        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <div class="flex-1">
                    <h4 class="font-semibold text-amber-900 mb-1">Tips Pengukuran Akurat</h4>
                    <ul class="text-sm text-amber-800 space-y-1 list-disc list-inside">
                        <li><strong>Berat Badan:</strong> Ukur dengan timbangan digital, anak pakai pakaian tipis</li>
                        <li><strong>Tinggi Badan:</strong> Anak usia ≥2 tahun berdiri, &lt;2 tahun berbaring</li>
                        <li><strong>Lingkar Kepala:</strong> Ukur bagian paling lebar kepala dengan pita meter</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-neutral-200">
            <a href="{{ url()->previous() }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary" :class="{ 'opacity-75 cursor-not-allowed': submitting }"
                :disabled="submitting">
                <template x-if="!submitting">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Pengukuran
                    </span>
                </template>
                <template x-if="submitting">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Menyimpan...
                    </span>
                </template>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function searchableDropdown(config) {
    return {
        open: false,
        search: '',
        items: config.items || [],
        selectedId: config.selectedId || '',
        selectedName: config.selectedName || '',

        get filteredItems() {
            if (!this.search) return this.items;
            const searchLower = this.search.toLowerCase();
            return this.items.filter(item =>
                item.name.toLowerCase().includes(searchLower) ||
                (item.mother && item.mother.toLowerCase().includes(searchLower))
            );
        },

        selectItem(item) {
            this.selectedId = item.id;
            this.selectedName = item.name;
            this.open = false;
            this.search = '';
        },

        selectFirst() {
            if (this.filteredItems.length > 0) {
                this.selectItem(this.filteredItems[0]);
            }
        },

        init() {
            this.$watch('open', (value) => {
                if (value) {
                    this.$nextTick(() => {
                        this.$refs.searchInput?.focus();
                    });
                }
            });
        }
    }
}
</script>
@endpush

@endsection