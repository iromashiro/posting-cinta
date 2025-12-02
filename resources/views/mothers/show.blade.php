@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="page-title">Detail Ibu</h1>
            <p class="page-subtitle">Informasi lengkap dan daftar anak</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('mothers.edit', $mother) }}" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <form method="post" action="{{ route('mothers.destroy', $mother) }}" x-data
                @submit.prevent="if(confirm('Hapus data ibu {{ $mother->name }}?\n\nSemua data anak dan pengukuran juga akan terhapus!')) $el.submit()"
                class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Mother Info Card -->
<div class="card card-padding mb-6">
    <div class="flex flex-col md:flex-row md:items-center gap-4">
        <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
        <div class="flex-1">
            <h2 class="text-xl font-bold text-neutral-900 mb-2">{{ $mother->name }}</h2>
            <div class="flex flex-wrap gap-4 text-sm text-neutral-600">
                @if($mother->nik)
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                    </svg>
                    {{ $mother->nik }}
                </span>
                @endif
                @if($mother->phone)
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <a href="tel:{{ $mother->phone }}" class="text-primary-600 hover:underline">{{ $mother->phone }}</a>
                </span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Info Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="card card-padding">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-secondary-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="text-xs text-neutral-500 mb-1">Posyandu</div>
                <div class="font-semibold text-neutral-900">{{ optional($mother->posyandu)->name ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="card card-padding">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="text-xs text-neutral-500 mb-1">Jumlah Anak</div>
                <div class="font-semibold text-neutral-900">{{ $mother->children->count() }} anak</div>
            </div>
        </div>
    </div>

    <div class="card card-padding">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div class="flex-1">
                <div class="text-xs text-neutral-500 mb-1">Terdaftar</div>
                <div class="font-semibold text-neutral-900">
                    {{ \Illuminate\Support\Carbon::parse($mother->created_at)->format('M Y') }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Address Card -->
    <div class="card card-padding lg:col-span-1">
        <h3 class="text-lg font-bold text-neutral-900 flex items-center gap-2 mb-3">
            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Alamat
        </h3>
        <div class="bg-neutral-50 rounded-lg p-4 min-h-[100px]">
            @if($mother->address)
            <p class="text-neutral-700">{{ $mother->address }}</p>
            @else
            <p class="text-neutral-400 text-center py-4">Alamat belum diisi</p>
            @endif
        </div>
    </div>

    <!-- Children List Card -->
    <div class="card card-padding lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-neutral-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Daftar Anak
            </h3>
            <a href="{{ route('children.create', ['mother_id' => $mother->id, 'posyandu_id' => $mother->posyandu_id]) }}"
                class="btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Anak
            </a>
        </div>

        @if ($mother->children->count() === 0)
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <p class="text-neutral-600 mb-4">Belum ada data anak untuk ibu ini</p>
            <a href="{{ route('children.create', ['mother_id' => $mother->id, 'posyandu_id' => $mother->posyandu_id]) }}"
                class="btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Anak Pertama
            </a>
        </div>
        @else
        <div class="overflow-x-auto -mx-6 md:mx-0">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>Nama Anak</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>Pengukuran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mother->children as $child)
                    <tr>
                        <td>
                            <a href="{{ route('children.show', $child) }}"
                                class="font-semibold text-primary-600 hover:text-primary-700 hover:underline">
                                {{ $child->name }}
                            </a>
                        </td>
                        <td>
                            @if($child->gender === 'male')
                            <span class="badge badge-info">Laki-laki</span>
                            @else
                            <span class="badge badge-primary">Perempuan</span>
                            @endif
                        </td>
                        <td>
                            <div class="text-neutral-700">
                                {{ \Illuminate\Support\Carbon::parse($child->date_of_birth)->format('d M Y') }}
                            </div>
                            <div class="text-xs text-neutral-500">
                                {{ \Illuminate\Support\Carbon::parse($child->date_of_birth)->age }} tahun
                            </div>
                        </td>
                        <td>
                            @if($child->measurements->count() > 0)
                            <span class="badge badge-success">{{ $child->measurements->count() }}x</span>
                            @else
                            <span class="badge badge-neutral">Belum ada</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-1">
                                <a href="{{ route('children.show', $child) }}" class="btn-ghost btn-sm" title="Lihat">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ route('children.edit', $child) }}" class="btn-secondary btn-sm"
                                    title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
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
<div class="card card-padding mb-6">
    <h3 class="text-lg font-bold text-neutral-900 flex items-center gap-2 mb-4">
        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
        </svg>
        Statistik Anak
    </h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
        $totalChildren = $mother->children->count();
        $maleCount = $mother->children->where('gender', 'male')->count();
        $femaleCount = $mother->children->where('gender', 'female')->count();
        $totalMeasurements = $mother->children->sum(function($child) { return $child->measurements->count(); });
        @endphp

        <div class="text-center p-4 bg-neutral-50 rounded-lg border border-neutral-200">
            <div class="w-10 h-10 mx-auto mb-2 rounded-full bg-blue-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="text-2xl font-bold text-neutral-900">{{ $totalChildren }}</div>
            <div class="text-xs text-neutral-500">Total Anak</div>
        </div>

        <div class="text-center p-4 bg-neutral-50 rounded-lg border border-neutral-200">
            <div class="w-10 h-10 mx-auto mb-2 rounded-full bg-indigo-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div class="text-2xl font-bold text-neutral-900">{{ $maleCount }}</div>
            <div class="text-xs text-neutral-500">Laki-laki</div>
        </div>

        <div class="text-center p-4 bg-neutral-50 rounded-lg border border-neutral-200">
            <div class="w-10 h-10 mx-auto mb-2 rounded-full bg-pink-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div class="text-2xl font-bold text-neutral-900">{{ $femaleCount }}</div>
            <div class="text-xs text-neutral-500">Perempuan</div>
        </div>

        <div class="text-center p-4 bg-neutral-50 rounded-lg border border-neutral-200">
            <div class="w-10 h-10 mx-auto mb-2 rounded-full bg-green-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </div>
            <div class="text-2xl font-bold text-neutral-900">{{ $totalMeasurements }}</div>
            <div class="text-xs text-neutral-500">Total Pengukuran</div>
        </div>
    </div>
</div>
@endif

<!-- Tips Box -->
<div class="card card-padding bg-blue-50 border-blue-200 mb-6">
    <div class="flex items-start gap-3">
        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="flex-1">
            <h4 class="font-semibold text-blue-900 mb-1">Tips Pemantauan</h4>
            <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
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
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Daftar Ibu
    </a>
</div>

@endsection