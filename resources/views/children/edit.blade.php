@extends('layouts.app')

@section('content')
@php
$header = '✏️ Edit Data Anak';
@endphp

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
            <!-- Posyandu - Searchable -->
            <div x-data="searchableSelect({
                items: {{ Js::from($posyandus->map(fn($p) => ['id' => $p->id, 'name' => $p->name])) }},
                selected: {{ old('posyandu_id', $child->posyandu_id) ?? 'null' }},
                inputName: 'posyandu_id',
                placeholder: 'Cari posyandu...',
                limitBeforeSearch: 10
            })">
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>🏥</span>
                        <span>Posyandu <span class="text-rose-600">*</span></span>
                    </span>
                </label>
                <div class="relative">
                    <input type="hidden" :name="inputName" :value="selectedId">
                    <button type="button" @click="open = !open"
                        class="input-field text-left flex items-center justify-between @error('posyandu_id') input-error @enderror">
                        <span x-text="selectedName || 'Pilih Posyandu'"
                            :class="!selectedName && 'text-slate-400'"></span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform" :class="open && 'rotate-180'"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute z-50 w-full mt-1 bg-white border-2 border-slate-200 rounded-xl shadow-lg max-h-60 overflow-hidden">
                        <div class="p-2 border-b border-slate-100">
                            <input type="text" x-model="search" x-ref="searchInput" @keydown.escape="open = false"
                                placeholder="Ketik untuk mencari..."
                                class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-400">
                        </div>
                        <ul class="max-h-48 overflow-y-auto">
                            <template x-for="item in displayItems" :key="item.id">
                                <li @click="selectItem(item)"
                                    class="px-4 py-2 cursor-pointer hover:bg-brand-50 flex items-center gap-2"
                                    :class="selectedId == item.id && 'bg-brand-100 text-brand-700'">
                                    <span x-text="item.name"></span>
                                    <svg x-show="selectedId == item.id" class="w-4 h-4 text-brand-600 ml-auto"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </li>
                            </template>
                            <li x-show="displayItems.length === 0" class="px-4 py-3 text-sm text-slate-500 text-center">
                                Tidak ada hasil ditemukan
                            </li>
                            <li x-show="!search && items.length > limitBeforeSearch"
                                class="px-4 py-2 text-xs text-slate-400 text-center bg-slate-50 border-t">
                                <span x-text="'Ketik untuk mencari dari ' + items.length + ' data'"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <p class="form-helper">Posyandu tempat anak terdaftar</p>
                @error('posyandu_id') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <!-- Ibu - Searchable (Limited to 5 before search) -->
            <div x-data="searchableSelect({
                items: {{ Js::from($mothers->map(fn($m) => ['id' => $m->id, 'name' => $m->name, 'posyandu_id' => $m->posyandu_id])) }},
                selected: {{ old('mother_id', $child->mother_id) ?? 'null' }},
                inputName: 'mother_id',
                placeholder: 'Cari ibu...',
                limitBeforeSearch: 5
            })">
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>👩</span>
                        <span>Nama Ibu <span class="text-rose-600">*</span></span>
                    </span>
                </label>
                <div class="relative">
                    <input type="hidden" :name="inputName" :value="selectedId">
                    <button type="button" @click="open = !open"
                        class="input-field text-left flex items-center justify-between @error('mother_id') input-error @enderror">
                        <span x-text="selectedName || 'Pilih Ibu'" :class="!selectedName && 'text-slate-400'"></span>
                        <svg class="w-5 h-5 text-slate-400 transition-transform" :class="open && 'rotate-180'"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute z-50 w-full mt-1 bg-white border-2 border-slate-200 rounded-xl shadow-lg max-h-60 overflow-hidden">
                        <div class="p-2 border-b border-slate-100">
                            <input type="text" x-model="search" x-ref="searchInput" @keydown.escape="open = false"
                                placeholder="Ketik nama ibu untuk mencari..."
                                class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-400">
                        </div>
                        <ul class="max-h-48 overflow-y-auto">
                            <template x-for="item in displayItems" :key="item.id">
                                <li @click="selectItem(item)"
                                    class="px-4 py-2 cursor-pointer hover:bg-brand-50 flex items-center gap-2"
                                    :class="selectedId == item.id && 'bg-brand-100 text-brand-700'">
                                    <span x-text="item.name"></span>
                                    <svg x-show="selectedId == item.id" class="w-4 h-4 text-brand-600 ml-auto"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </li>
                            </template>
                            <li x-show="displayItems.length === 0 && search"
                                class="px-4 py-3 text-sm text-slate-500 text-center">
                                Tidak ada hasil ditemukan
                            </li>
                            <li x-show="!search && items.length > limitBeforeSearch"
                                class="px-4 py-2 text-xs text-slate-400 text-center bg-slate-50 border-t">
                                <span x-text="'Ketik untuk mencari dari ' + items.length + ' data ibu'"></span>
                            </li>
                        </ul>
                    </div>
                </div>
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
                            class="w-4 h-4 text-brand-500 border-slate-300 focus:ring-brand-400"
                            {{ old('gender', $child->gender) === 'male' ? 'checked' : '' }}>
                        <span class="text-sm font-medium text-slate-700">👦 Laki-laki</span>
                    </label>
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="gender" value="female"
                            class="w-4 h-4 text-brand-500 border-slate-300 focus:ring-brand-400"
                            {{ old('gender', $child->gender) === 'female' ? 'checked' : '' }}>
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

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
    Alpine.data('searchableSelect', (config) => ({
        items: config.items || [],
        selectedId: config.selected,
        selectedName: '',
        inputName: config.inputName || 'select',
        placeholder: config.placeholder || 'Search...',
        limitBeforeSearch: config.limitBeforeSearch || 10,
        search: '',
        open: false,

        init() {
            // Set initial selected name
            if (this.selectedId) {
                const found = this.items.find(item => item.id == this.selectedId);
                if (found) this.selectedName = found.name;
            }

            // Focus search input when dropdown opens
            this.$watch('open', (value) => {
                if (value) {
                    this.$nextTick(() => {
                        this.$refs.searchInput?.focus();
                    });
                } else {
                    this.search = '';
                }
            });
        },

        get filteredItems() {
            if (!this.search) return this.items;
            const searchLower = this.search.toLowerCase();
            return this.items.filter(item =>
                item.name.toLowerCase().includes(searchLower)
            );
        },

        get displayItems() {
            // If searching, show all filtered results
            if (this.search) {
                return this.filteredItems;
            }
            // If not searching, limit to configured amount
            return this.items.slice(0, this.limitBeforeSearch);
        },

        selectItem(item) {
            this.selectedId = item.id;
            this.selectedName = item.name;
            this.open = false;
            this.search = '';
        }
    }));
});
</script>
@endpush