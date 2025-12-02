@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Edit Pengukuran</h1>
    <p class="page-subtitle">Perbarui data pengukuran {{ $measurement->child->name }}</p>
</div>

<div class="card card-padding">
    <form method="post" action="{{ route('measurements.update', $measurement) }}" class="space-y-6"
        x-data="{ submitting: false }" @submit="submitting = true">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Searchable Dropdown Anak -->
            <div class="md:col-span-2" x-data="searchableDropdown({
                items: {{ Js::from($children->map(fn($c) => [
                    'id' => $c->id,
                    'name' => $c->name,
                    'mother' => $c->mother?->name,
                    'gender' => $c->gender === 'male' ? 'L' : 'P'
                ])) }},
                selectedId: '{{ old('child_id', $measurement->child_id) }}',
                selectedName: '{{ old('child_id') ? $children->firstWhere('id', old('child_id'))?->name : $measurement->child->name }}'
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
                <input type="date" name="measured_at"
                    value="{{ old('measured_at', $measurement->measured_at->format('Y-m-d')) }}"
                    class="input-field @error('measured_at') input-error @enderror">
                <p class="input-helper">Tanggal pelaksanaan pengukuran</p>
                @error('measured_at') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Berat Badan -->
            <div>
                <label class="input-label">
                    Berat Badan (kg) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="weight" step="0.01" min="0.5" max="60"
                    value="{{ old('weight', $measurement->weight) }}" placeholder="Contoh: 12.5"
                    class="input-field @error('weight') input-error @enderror">
                <p class="input-helper">Berat badan dalam kilogram (0.5 - 60 kg)</p>
                @error('weight') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Tinggi/Panjang Badan -->
            <div>
                <label class="input-label">
                    Tinggi/Panjang Badan (cm) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="height" step="0.1" min="25" max="130"
                    value="{{ old('height', $measurement->height) }}" placeholder="Contoh: 85.5"
                    class="input-field @error('height') input-error @enderror">
                <p class="input-helper">Tinggi/panjang badan dalam cm (25 - 130 cm)</p>
                @error('height') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Lingkar Kepala -->
            <div>
                <label class="input-label">Lingkar Kepala (cm) - Opsional</label>
                <input type="number" name="head_circumference" step="0.1" min="20" max="60"
                    value="{{ old('head_circumference', $measurement->head_circumference) }}" placeholder="Contoh: 45.0"
                    class="input-field @error('head_circumference') input-error @enderror">
                <p class="input-helper">Lingkar kepala dalam cm (20 - 60 cm)</p>
                @error('head_circumference') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Catatan -->
            <div class="md:col-span-2">
                <label class="input-label">Catatan Tambahan - Opsional</label>
                <textarea name="notes" rows="3"
                    placeholder="Tambahkan catatan seperti kondisi anak, keluhan ibu, dll..."
                    class="input-field @error('notes') input-error @enderror">{{ old('notes', $measurement->notes) }}</textarea>
                <p class="input-helper">Catatan penting terkait kondisi atau keluhan</p>
                @error('notes') <p class="error-message">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Current Z-Score Info -->
        @if($measurement->height_for_age_z !== null)
        <div class="bg-neutral-50 border border-neutral-200 rounded-lg p-4">
            <h4 class="font-semibold text-neutral-900 mb-3">Data Saat Ini</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div>
                    <span class="text-neutral-500">Z-Score TB/U:</span>
                    <span
                        class="font-semibold {{ $measurement->height_for_age_z < -2 ? 'text-red-600' : 'text-neutral-900' }}">
                        {{ number_format($measurement->height_for_age_z, 2) }}
                    </span>
                </div>
                @if($measurement->weight_for_age_z !== null)
                <div>
                    <span class="text-neutral-500">Z-Score BB/U:</span>
                    <span
                        class="font-semibold text-neutral-900">{{ number_format($measurement->weight_for_age_z, 2) }}</span>
                </div>
                @endif
                @if($measurement->weight_for_height_z !== null)
                <div>
                    <span class="text-neutral-500">Z-Score BB/TB:</span>
                    <span
                        class="font-semibold text-neutral-900">{{ number_format($measurement->weight_for_height_z, 2) }}</span>
                </div>
                @endif
                <div>
                    <span class="text-neutral-500">Status:</span>
                    @if ($measurement->nutrition_status === 'severe')
                    <span class="badge badge-danger">Sangat Pendek</span>
                    @elseif ($measurement->nutrition_status === 'stunting')
                    <span class="badge badge-warning">Pendek</span>
                    @elseif ($measurement->nutrition_status === 'normal')
                    <span class="badge badge-success">Normal</span>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-neutral-200">
            <a href="{{ route('children.show', $measurement->child) }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary" :class="{ 'opacity-75 cursor-not-allowed': submitting }"
                :disabled="submitting">
                <template x-if="!submitting">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
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