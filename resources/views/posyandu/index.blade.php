@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="page-title">Daftar Posyandu</h1>
            <p class="page-subtitle">Kelola data posyandu di wilayah kerja Anda</p>
        </div>
        <a href="{{ route('posyandu.create') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Posyandu
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

    <form method="get" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Search Box -->
        <div>
            <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama posyandu..." class="input-field">
        </div>

        <!-- Puskesmas Filter -->
        <div>
            <select name="puskesmas_id" class="input-field">
                <option value="">Semua Puskesmas</option>
                @foreach ($puskesmas as $p)
                <option value="{{ $p->id }}" @selected($puskesmasId==$p->id)>{{ $p->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-2">
            <button type="submit" class="btn-primary flex-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Cari
            </button>
            <a href="{{ route('posyandu.index') }}" class="btn-secondary flex-1">
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
                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
        </svg>
        <h3 class="text-lg font-semibold text-neutral-800 mb-2">Belum Ada Data Posyandu</h3>
        <p class="text-neutral-600 mb-6">
            @if($q || $puskesmasId)
            Tidak ada hasil yang cocok dengan filter Anda. Coba ubah kriteria pencarian.
            @else
            Mulai tambahkan data posyandu untuk mengelola layanan kesehatan.
            @endif
        </p>
        @if(!$q && !$puskesmasId)
        <a href="{{ route('posyandu.create') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Posyandu Pertama
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
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
        <div>
            <p class="text-sm text-neutral-500">Total Posyandu Terdaftar</p>
            <p class="text-xl font-bold text-neutral-900">{{ $items->total() }} Posyandu</p>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card overflow-hidden">
    <table class="table-premium">
        <thead>
            <tr>
                <th>Nama Posyandu</th>
                <th>Puskesmas</th>
                <th>Kader PJ</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td>
                    <a href="{{ route('posyandu.show', $item) }}"
                        class="font-semibold text-primary-600 hover:text-primary-700 hover:underline">
                        {{ $item->name }}
                    </a>
                    @if($item->village || $item->district)
                    <div class="text-xs text-neutral-500 mt-1">
                        {{ $item->village ? $item->village . ', ' : '' }}{{ $item->district }}
                    </div>
                    @endif
                </td>
                <td>
                    <span class="text-neutral-700">{{ optional($item->puskesmas)->name ?? '-' }}</span>
                </td>
                <td>
                    <span class="text-neutral-700">{{ optional($item->kader)->name ?? '-' }}</span>
                </td>
                <td>
                    @if ($item->is_active)
                    <span class="badge badge-success">Aktif</span>
                    @else
                    <span class="badge badge-neutral">Nonaktif</span>
                    @endif
                </td>
                <td>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('posyandu.show', $item) }}" class="btn-ghost btn-sm" title="Lihat Detail">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                        <a href="{{ route('posyandu.edit', $item) }}" class="btn-secondary btn-sm" title="Edit Data">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <form method="post" action="{{ route('posyandu.destroy', $item) }}" x-data
                            @submit.prevent="if(confirm('Hapus posyandu {{ $item->name }}?')) $el.submit()"
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
            <h4 class="font-semibold text-blue-900 mb-1">Tips Manajemen Posyandu</h4>
            <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                <li>Pastikan setiap posyandu memiliki kader penanggung jawab yang aktif</li>
                <li>Update data alamat secara berkala untuk kemudahan koordinasi</li>
                <li>Klik nama posyandu untuk melihat statistik lengkap</li>
            </ul>
        </div>
    </div>
</div>

@endsection