@extends('layouts.app')

@section('content')
@php($header = '👩 Detail Ibu')

<!-- Header Section with Mother Info -->
<div class="card-cute mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-start gap-4">
            <div class="text-5xl">👩</div>
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-slate-800 mb-1">{{ $mother->name }}</h1>
                <div class="flex flex-wrap gap-3 text-sm text-slate-600">
                    @if($mother->nik)
                    <span class="flex items-center gap-1">
                        <span>🆔</span>
                        <span>{{ $mother->nik }}</span>
                    </span>
                    @endif
                    @if($mother->phone)
                    <span class="flex items-center gap-1">
                        <span>📱</span>
                        <a href="tel:{{ $mother->phone }}"
                            class="text-brand-600 hover:underline">{{ $mother->phone }}</a>
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('mothers.edit', $mother) }}" class="btn-success text-sm">
                <span>✏️ Edit Data</span>
            </a>
            <form method="post" action="{{ route('mothers.destroy', $mother) }}" x-data
                @submit.prevent="if(confirm('❌ Hapus data ibu {{ $mother->name }}?\n\nSemua data anak dan pengukuran juga akan terhapus!')) $el.submit()"
                class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger text-sm">
                    <span>🗑️ Hapus</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Info Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="card bg-gradient-to-br from-purple-50 to-purple-100 border-2 border-purple-200">
        <div class="flex items-center gap-3">
            <div class="text-3xl">🏥</div>
            <div class="flex-1">
                <div class="text-xs text-purple-700 mb-1 font-medium">Posyandu</div>
                <div class="font-bold text-slate-800">{{ optional($mother->posyandu)->name ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="card bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200">
        <div class="flex items-center gap-3">
            <div class="text-3xl">👶</div>
            <div class="flex-1">
                <div class="text-xs text-blue-700 mb-1 font-medium">Jumlah Anak</div>
                <div class="font-bold text-slate-800">{{ $mother->children->count() }} anak</div>
            </div>
        </div>
    </div>

    <div class="card bg-gradient-to-br from-pink-50 to-pink-100 border-2 border-pink-200">
        <div class="flex items-center gap-3">
            <div class="text-3xl">📅</div>
            <div class="flex-1">
                <div class="text-xs text-pink-700 mb-1 font-medium">Terdaftar</div>
                <div class="font-bold text-slate-800">
                    {{ \Illuminate\Support\Carbon::parse($mother->created_at)->format('M Y') }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Address Card -->
    <div class="card-cute lg:col-span-1">
        <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2 mb-3">
            <span>🏠</span>
            <span>Alamat</span>
        </h3>
        <div class="bg-slate-50 rounded-xl p-4 min-h-[100px]">
            @if($mother->address)
            <p class="text-slate-700">{{ $mother->address }}</p>
            @else
            <p class="text-slate-400 text-center py-4">Alamat belum diisi</p>
            @endif
        </div>
    </div>

    <!-- Children List Card -->
    <div class="card-cute lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <span>👶</span>
                <span>Daftar Anak</span>
            </h3>
            <a href="{{ route('children.create', ['mother_id' => $mother->id, 'posyandu_id' => $mother->posyandu_id]) }}"
                class="btn-primary text-sm">
                <span>➕ Tambah Anak</span>
            </a>
        </div>

        @if ($mother->children->count() === 0)
        <div class="text-center py-12">
            <div class="text-5xl mb-3">👶💭</div>
            <p class="text-slate-600 mb-4">Belum ada data anak untuk ibu ini</p>
            <a href="{{ route('children.create', ['mother_id' => $mother->id, 'posyandu_id' => $mother->posyandu_id]) }}"
                class="btn-primary inline-flex">
                <span>➕ Tambah Anak Pertama</span>
            </a>
        </div>
        @else
        <div class="overflow-x-auto -mx-4 md:mx-0">
            <table class="table-cute">
                <thead>
                    <tr>
                        <th>👶 Nama Anak</th>
                        <th>👧👦 JK</th>
                        <th>🎂 Tgl Lahir</th>
                        <th>📏 Pengukuran</th>
                        <th>⚙️ Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mother->children as $child)
                    <tr>
                        <td>
                            <a href="{{ route('children.show', $child) }}"
                                class="font-semibold text-brand-600 hover:text-brand-700 hover:underline flex items-center gap-2">
                                <span>{{ $child->gender === 'male' ? '👦' : '👧' }}</span>
                                <span>{{ $child->name }}</span>
                            </a>
                        </td>
                        <td>
                            @if($child->gender === 'male')
                            <span class="badge-info">👦 Laki-laki</span>
                            @else
                            <span class="badge-danger">👧 Perempuan</span>
                            @endif
                        </td>
                        <td>
                            <div class="text-slate-700">
                                {{ \Illuminate\Support\Carbon::parse($child->date_of_birth)->format('d M Y') }}
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ \Illuminate\Support\Carbon::parse($child->date_of_birth)->age }} tahun
                            </div>
                        </td>
                        <td>
                            @if($child->measurements->count() > 0)
                            <span class="badge-success">📏 {{ $child->measurements->count() }}x</span>
                            @else
                            <span class="badge-secondary">Belum ada</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('children.show', $child) }}" class="btn-secondary text-xs px-2 py-1"
                                    title="Lihat Detail">
                                    👁️
                                </a>
                                <a href="{{ route('children.edit', $child) }}" class="btn-success text-xs px-2 py-1"
                                    title="Edit Data">
                                    ✏️
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

<!-- Statistics Card (if has children) -->
@if($mother->children->count() > 0)
<div class="card-cute mb-6">
    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2 mb-4">
        <span>📊</span>
        <span>Statistik Anak</span>
    </h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
        $totalChildren = $mother->children->count();
        $maleCount = $mother->children->where('gender', 'male')->count();
        $femaleCount = $mother->children->where('gender', 'female')->count();
        $totalMeasurements = $mother->children->sum(function($child) { return $child->measurements->count(); });
        @endphp

        <div class="text-center p-4 bg-blue-50 rounded-xl border-2 border-blue-200">
            <div class="text-3xl mb-2">👶</div>
            <div class="text-2xl font-bold text-slate-800">{{ $totalChildren }}</div>
            <div class="text-xs text-slate-600">Total Anak</div>
        </div>

        <div class="text-center p-4 bg-purple-50 rounded-xl border-2 border-purple-200">
            <div class="text-3xl mb-2">👦</div>
            <div class="text-2xl font-bold text-slate-800">{{ $maleCount }}</div>
            <div class="text-xs text-slate-600">Laki-laki</div>
        </div>

        <div class="text-center p-4 bg-pink-50 rounded-xl border-2 border-pink-200">
            <div class="text-3xl mb-2">👧</div>
            <div class="text-2xl font-bold text-slate-800">{{ $femaleCount }}</div>
            <div class="text-xs text-slate-600">Perempuan</div>
        </div>

        <div class="text-center p-4 bg-green-50 rounded-xl border-2 border-green-200">
            <div class="text-3xl mb-2">📏</div>
            <div class="text-2xl font-bold text-slate-800">{{ $totalMeasurements }}</div>
            <div class="text-xs text-slate-600">Total Pengukuran</div>
        </div>
    </div>
</div>
@endif

<!-- Tips Box -->
<div class="bg-pink-50 border-2 border-pink-200 rounded-xl p-4 mb-6">
    <div class="flex items-start gap-3">
        <div class="text-2xl">💡</div>
        <div class="flex-1">
            <h4 class="font-semibold text-pink-900 mb-1">Tips Pemantauan</h4>
            <ul class="text-sm text-pink-800 space-y-1 list-disc list-inside">
                <li>Pastikan semua anak sudah terdaftar dengan data lengkap</li>
                <li>Lakukan pengukuran rutin setiap bulan untuk monitoring optimal</li>
                <li>Klik nama anak untuk melihat detail tumbuh kembang dan grafik</li>
            </ul>
        </div>
    </div>
</div>

<!-- Back Button -->
<div class="flex items-center gap-3">
    <a href="{{ route('mothers.index') }}" class="btn-secondary">
        <span>← Kembali ke Daftar Ibu</span>
    </a>
</div>

@endsection