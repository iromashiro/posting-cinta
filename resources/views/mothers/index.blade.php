@extends('layouts.app')

@section('content')
@php($header = '👩 Daftar Ibu')

<!-- Header Section -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
            <span>👩</span>
            <span>Daftar Ibu</span>
        </h1>
        <p class="text-sm text-slate-600 mt-1">Kelola data ibu yang terdaftar di posyandu</p>
    </div>
    <a href="{{ route('mothers.create') }}" class="btn-primary">
        <span>➕ Tambah Ibu</span>
    </a>
</div>

<!-- Filter Section -->
<div class="card mb-6">
    <div class="flex items-center gap-2 mb-4">
        <span class="text-xl">🔍</span>
        <h3 class="font-semibold text-slate-800">Filter & Pencarian</h3>
    </div>

    <form method="get" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Search Box -->
        <div>
            <input type="text" name="q" value="{{ $q }}" placeholder="🔎 Cari nama atau NIK ibu..." class="input-field">
        </div>

        <!-- Posyandu Filter -->
        <div>
            <select name="posyandu_id" class="input-field">
                <option value="">🏥 Semua Posyandu</option>
                @foreach ($posyandus as $p)
                <option value="{{ $p->id }}" @selected($posyanduId==$p->id)>{{ $p->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-2">
            <button type="submit" class="btn-primary flex-1">
                <span>🔍 Cari</span>
            </button>
            <a href="{{ route('mothers.index') }}" class="btn-secondary flex-1">
                <span>🔄 Reset</span>
            </a>
        </div>
    </form>
</div>

<!-- Empty State atau Data Table -->
@if ($items->count() === 0)
<div class="card-cute text-center py-12">
    <div class="text-6xl mb-4">👩💭</div>
    <h3 class="text-lg font-semibold text-slate-800 mb-2">Belum Ada Data Ibu</h3>
    <p class="text-slate-600 mb-6">
        @if($q || $posyanduId)
        Tidak ada hasil yang cocok dengan filter Anda. Coba ubah kriteria pencarian.
        @else
        Mulai tambahkan data ibu untuk memudahkan pendampingan tumbuh kembang anak.
        @endif
    </p>
    @if(!$q && !$posyanduId)
    <a href="{{ route('mothers.create') }}" class="btn-primary inline-flex">
        <span>➕ Tambah Ibu Pertama</span>
    </a>
    @endif
</div>
@else
<!-- Stats Info -->
<div class="bg-gradient-to-r from-pink-50 to-purple-50 rounded-xl p-4 mb-4 border-2 border-pink-200">
    <div class="flex items-center gap-3">
        <span class="text-2xl">📊</span>
        <div>
            <p class="text-sm text-slate-600">Total Ibu Terdaftar</p>
            <p class="text-2xl font-bold text-slate-800">{{ $items->count() }} Ibu</p>
        </div>
    </div>
</div>

<!-- Table -->
<div class="overflow-x-auto">
    <table class="table-cute">
        <thead>
            <tr>
                <th>👩 Nama Ibu</th>
                <th>🆔 NIK</th>
                <th>🏥 Posyandu</th>
                <th>📱 Telepon</th>
                <th>👶 Jumlah Anak</th>
                <th>⚙️ Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td>
                    <a href="{{ route('mothers.show', $item) }}"
                        class="font-semibold text-brand-600 hover:text-brand-700 hover:underline flex items-center gap-2">
                        <span>👩</span>
                        <span>{{ $item->name }}</span>
                    </a>
                    @if($item->address)
                    <div class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                        <span>🏠</span>
                        <span>{{ Str::limit($item->address, 40) }}</span>
                    </div>
                    @endif
                </td>
                <td>
                    <span class="text-slate-700">{{ $item->nik ?: '-' }}</span>
                </td>
                <td>
                    <span class="text-slate-700">{{ optional($item->posyandu)->name ?? '-' }}</span>
                </td>
                <td>
                    @if($item->phone)
                    <a href="tel:{{ $item->phone }}" class="text-brand-600 hover:underline flex items-center gap-1">
                        <span>📱</span>
                        <span>{{ $item->phone }}</span>
                    </a>
                    @else
                    <span class="text-slate-400">-</span>
                    @endif
                </td>
                <td>
                    @if($item->children_count > 0)
                    <span class="badge-success">👶 {{ $item->children_count }} anak</span>
                    @else
                    <span class="badge-secondary">Belum ada anak</span>
                    @endif
                </td>
                <td>
                    <div class="flex items-center gap-2 justify-end">
                        <a href="{{ route('mothers.show', $item) }}" class="btn-secondary text-xs px-3 py-1.5"
                            title="Lihat Detail">
                            👁️ Detail
                        </a>
                        <a href="{{ route('mothers.edit', $item) }}" class="btn-success text-xs px-3 py-1.5"
                            title="Edit Data">
                            ✏️ Edit
                        </a>
                        <form method="post" action="{{ route('mothers.destroy', $item) }}" x-data
                            @submit.prevent="if(confirm('❌ Hapus data ibu {{ $item->name }}?\n\nData anak dan pengukuran terkait juga akan terhapus!')) $el.submit()"
                            class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger text-xs px-3 py-1.5" title="Hapus Data">
                                🗑️ Hapus
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
<div class="mt-6 bg-pink-50 border-2 border-pink-200 rounded-xl p-4">
    <div class="flex items-start gap-3">
        <div class="text-2xl">💡</div>
        <div class="flex-1">
            <h4 class="font-semibold text-pink-900 mb-1">Tips Manajemen Data Ibu</h4>
            <ul class="text-sm text-pink-800 space-y-1 list-disc list-inside">
                <li>Pastikan data kontak ibu selalu up-to-date untuk komunikasi yang efektif</li>
                <li>Gunakan filter untuk mempermudah pencarian data spesifik</li>
                <li>Klik nama ibu untuk melihat detail lengkap dan daftar anak</li>
            </ul>
        </div>
    </div>
</div>

@endsection