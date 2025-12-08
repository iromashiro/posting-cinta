@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="page-title">Daftar Anak</h1>
            <p class="page-subtitle">Kelola data anak yang terdaftar di posyandu</p>
        </div>
        <a href="{{ route('children.create') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Anak
        </a>
    </div>
</div>

<!-- Filter Section -->
<div class="card card-padding mb-6">
    <div class="flex items-center gap-2 mb-4">
        <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <h3 class="font-semibold text-neutral-800">Filter & Pencarian</h3>
    </div>

    <form method="get" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Search Box -->
        <div class="md:col-span-2">
            <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama atau NIK anak..." class="input-field">
        </div>

        <!-- Posyandu Filter -->
        <div>
            <select name="posyandu_id" class="input-field">
                <option value="">Semua Posyandu</option>
                @foreach ($posyandus as $p)
                <option value="{{ $p->id }}" @selected($posyanduId==$p->id)>{{ $p->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Mother Filter -->
        <div>
            <select name="mother_id" class="input-field">
                <option value="">Semua Ibu</option>
                @foreach ($mothers as $m)
                <option value="{{ $m->id }}" @selected($motherId==$m->id)>{{ $m->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Action Buttons -->
        <div class="md:col-span-4 flex gap-2">
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Cari
            </button>
            <a href="{{ route('children.index') }}" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Empty State atau Data Table -->
@if ($items->count() === 0)
<div class="card card-padding text-center">
    <div class="py-8">
        <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <h3 class="text-lg font-semibold text-neutral-800 mb-2">Belum Ada Data Anak</h3>
        <p class="text-neutral-600 mb-6">
            @if($q || $posyanduId || $motherId)
            Tidak ada hasil yang cocok dengan filter Anda. Coba ubah kriteria pencarian.
            @else
            Mulai tambahkan data anak untuk memantau tumbuh kembang mereka.
            @endif
        </p>
        @if(!$q && !$posyanduId && !$motherId)
        <a href="{{ route('children.create') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Anak Pertama
        </a>
        @endif
    </div>
</div>
@else
<!-- Stats Info -->
<div class="card card-padding mb-4">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center">
            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
        </div>
        <div>
            <p class="text-sm text-neutral-500">Total Anak Terdaftar</p>
            <p class="text-xl font-bold text-neutral-900">{{ $items->total() }} Anak</p>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table-premium min-w-[800px]">
            <thead>
                <tr>
                    <th>Nama Anak</th>
                    <th>Ibu</th>
                    <th>Posyandu</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Lahir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>
                        <a href="{{ route('children.show', $item) }}"
                            class="font-semibold text-primary-600 hover:text-primary-700 hover:underline">
                            {{ $item->name }}
                        </a>
                        @if($item->nik)
                        <div class="text-xs text-neutral-500 mt-1">NIK: {{ $item->nik }}</div>
                        @endif
                    </td>
                    <td>
                        <span class="text-neutral-700">{{ optional($item->mother)->name ?? '-' }}</span>
                    </td>
                    <td>
                        <span class="text-neutral-700">{{ optional($item->posyandu)->name ?? '-' }}</span>
                    </td>
                    <td>
                        @if($item->gender === 'male')
                        <span class="badge badge-info">Laki-laki</span>
                        @else
                        <span class="badge badge-primary">Perempuan</span>
                        @endif
                    </td>
                    <td>
                        <span class="text-neutral-700">
                            {{ \Illuminate\Support\Carbon::parse($item->date_of_birth)->format('d M Y') }}
                        </span>
                        <div class="text-xs text-neutral-500 mt-1">
                            Usia: {{ \Illuminate\Support\Carbon::parse($item->date_of_birth)->age }} tahun
                        </div>
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('children.show', $item) }}" class="btn-ghost btn-sm" title="Lihat Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Lihat
                            </a>
                            <a href="{{ route('children.edit', $item) }}" class="btn-secondary btn-sm"
                                title="Edit Data">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </a>
                            <form method="post" action="{{ route('children.destroy', $item) }}" x-data
                                @submit.prevent="if(confirm('Hapus data anak {{ $item->name }}?\n\nSemua riwayat pengukuran juga akan terhapus!')) $el.submit()"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger btn-sm" title="Hapus Data">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if($items->hasPages())
<div class="mt-6">
    {{ $items->links() }}
</div>
@endif
@endif

<!-- Tips Box -->
<div class="mt-6 card card-padding bg-blue-50 border-blue-200">
    <div class="flex items-start gap-3">
        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="flex-1">
            <h4 class="font-semibold text-blue-900 mb-1">Tips Manajemen Data Anak</h4>
            <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                <li>Pastikan data anak selalu up-to-date untuk monitoring yang akurat</li>
                <li>Gunakan filter untuk mempermudah pencarian data spesifik</li>
                <li>Klik nama anak untuk melihat detail dan riwayat pengukuran lengkap</li>
            </ul>
        </div>
    </div>
</div>

@endsection