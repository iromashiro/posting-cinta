@extends('layouts.app')

@section('content')
@php($header = '👶 Daftar Anak')

<!-- Header Section -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
            <span>👶</span>
            <span>Daftar Anak</span>
        </h1>
        <p class="text-sm text-slate-600 mt-1">Kelola data anak yang terdaftar di posyandu</p>
    </div>
    <a href="{{ route('children.create') }}" class="btn-primary">
        <span>➕ Tambah Anak</span>
    </a>
</div>

<!-- Filter Section -->
<div class="card mb-6">
    <div class="flex items-center gap-2 mb-4">
        <span class="text-xl">🔍</span>
        <h3 class="font-semibold text-slate-800">Filter & Pencarian</h3>
    </div>

    <form method="get" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Search Box -->
        <div class="md:col-span-2">
            <input type="text" name="q" value="{{ $q }}" placeholder="🔎 Cari nama atau NIK anak..."
                class="input-field">
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

        <!-- Mother Filter -->
        <div>
            <select name="mother_id" class="input-field">
                <option value="">👩 Semua Ibu</option>
                @foreach ($mothers as $m)
                <option value="{{ $m->id }}" @selected($motherId==$m->id)>{{ $m->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Action Buttons -->
        <div class="md:col-span-4 flex gap-2">
            <button type="submit" class="btn-primary">
                <span>🔍 Cari</span>
            </button>
            <a href="{{ route('children.index') }}" class="btn-secondary">
                <span>🔄 Reset Filter</span>
            </a>
        </div>
    </form>
</div>

<!-- Empty State atau Data Table -->
@if ($items->count() === 0)
<div class="card-cute text-center py-12">
    <div class="text-6xl mb-4">👶💭</div>
    <h3 class="text-lg font-semibold text-slate-800 mb-2">Belum Ada Data Anak</h3>
    <p class="text-slate-600 mb-6">
        @if($q || $posyanduId || $motherId)
        Tidak ada hasil yang cocok dengan filter Anda. Coba ubah kriteria pencarian.
        @else
        Mulai tambahkan data anak untuk memantau tumbuh kembang mereka.
        @endif
    </p>
    @if(!$q && !$posyanduId && !$motherId)
    <a href="{{ route('children.create') }}" class="btn-primary inline-flex">
        <span>➕ Tambah Anak Pertama</span>
    </a>
    @endif
</div>
@else
<!-- Stats Info -->
<div class="bg-gradient-to-r from-pink-50 to-purple-50 rounded-xl p-4 mb-4 border-2 border-pink-200">
    <div class="flex items-center gap-3">
        <span class="text-2xl">📊</span>
        <div>
            <p class="text-sm text-slate-600">Total Anak Terdaftar</p>
            <p class="text-2xl font-bold text-slate-800">{{ $items->count() }} Anak</p>
        </div>
    </div>
</div>

<!-- Table -->
<div class="overflow-x-auto">
    <table class="table-cute">
        <thead>
            <tr>
                <th>👶 Nama Anak</th>
                <th>👩 Ibu</th>
                <th>🏥 Posyandu</th>
                <th>👧👦 JK</th>
                <th>🎂 Tgl Lahir</th>
                <th>⚙️ Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td>
                    <a href="{{ route('children.show', $item) }}"
                        class="font-semibold text-brand-600 hover:text-brand-700 hover:underline flex items-center gap-2">
                        <span>{{ $item->gender === 'male' ? '👦' : '👧' }}</span>
                        <span>{{ $item->name }}</span>
                    </a>
                    @if($item->nik)
                    <div class="text-xs text-slate-500 mt-1">NIK: {{ $item->nik }}</div>
                    @endif
                </td>
                <td>
                    <span class="text-slate-700">{{ optional($item->mother)->name ?? '-' }}</span>
                </td>
                <td>
                    <span class="text-slate-700">{{ optional($item->posyandu)->name ?? '-' }}</span>
                </td>
                <td>
                    @if($item->gender === 'male')
                    <span class="badge-info">👦 Laki-laki</span>
                    @else
                    <span class="badge-danger">👧 Perempuan</span>
                    @endif
                </td>
                <td>
                    <span class="text-slate-700">
                        {{ \Illuminate\Support\Carbon::parse($item->date_of_birth)->format('d M Y') }}
                    </span>
                    <div class="text-xs text-slate-500 mt-1">
                        Usia: {{ \Illuminate\Support\Carbon::parse($item->date_of_birth)->age }} tahun
                    </div>
                </td>
                <td>
                    <div class="flex items-center gap-2 justify-end">
                        <a href="{{ route('children.show', $item) }}" class="btn-secondary text-xs px-3 py-1.5"
                            title="Lihat Detail">
                            👁️ Detail
                        </a>
                        <a href="{{ route('children.edit', $item) }}" class="btn-success text-xs px-3 py-1.5"
                            title="Edit Data">
                            ✏️ Edit
                        </a>
                        <form method="post" action="{{ route('children.destroy', $item) }}" x-data
                            @submit.prevent="if(confirm('❌ Hapus data anak {{ $item->name }}?\n\nSemua riwayat pengukuran juga akan terhapus!')) $el.submit()"
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
<div class="mt-6 bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
    <div class="flex items-start gap-3">
        <div class="text-2xl">💡</div>
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