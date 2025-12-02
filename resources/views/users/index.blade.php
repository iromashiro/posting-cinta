@extends('layouts.app')

@section('content')
@php
$isAdmin = Auth::user()->role === 'admin';
@endphp

<!-- Page Header -->
<div class="page-header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="page-title">Kelola {{ $isAdmin ? 'User' : 'Kader' }}</h1>
            <p class="page-subtitle">Manajemen pengguna sistem posyandu</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah {{ $isAdmin ? 'User' : 'Kader' }}
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
        <div>
            <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama atau email..." class="input-field">
        </div>

        @if($isAdmin)
        <!-- Role Filter -->
        <div>
            <select name="role" class="input-field">
                <option value="">Semua Role</option>
                @foreach ($roles as $r)
                <option value="{{ $r }}" {{ $role === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                @endforeach
            </select>
        </div>

        <!-- Puskesmas Filter -->
        <div>
            <select name="puskesmas_id" class="input-field">
                <option value="">Semua Puskesmas</option>
                @foreach ($puskesmas as $p)
                <option value="{{ $p->id }}" {{ $puskesmasId == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex gap-2">
            <button type="submit" class="btn-primary flex-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Cari
            </button>
            <a href="{{ route('users.index') }}" class="btn-secondary flex-1">
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
        <h3 class="text-lg font-semibold text-neutral-800 mb-2">Belum Ada Data User</h3>
        <p class="text-neutral-600 mb-6">
            @if($q || $role || $puskesmasId)
            Tidak ada hasil yang cocok dengan filter Anda. Coba ubah kriteria pencarian.
            @else
            Mulai tambahkan data user untuk mengelola sistem.
            @endif
        </p>
        @if(!$q && !$role && !$puskesmasId)
        <a href="{{ route('users.create') }}" class="btn-primary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah User Pertama
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
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <div>
            <p class="text-sm text-neutral-500">Total User Terdaftar</p>
            <p class="text-xl font-bold text-neutral-900">{{ $items->total() }} User</p>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card overflow-hidden">
    <table class="table-premium">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                @if($isAdmin)
                <th>Puskesmas</th>
                @endif
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td>
                    <a href="{{ route('users.show', $item) }}"
                        class="font-semibold text-primary-600 hover:text-primary-700 hover:underline">
                        {{ $item->name }}
                    </a>
                </td>
                <td>
                    <span class="text-neutral-700">{{ $item->email }}</span>
                </td>
                <td>
                    @if($item->role === 'admin')
                    <span class="badge bg-purple-50 text-purple-700">Admin</span>
                    @elseif($item->role === 'puskesmas')
                    <span class="badge badge-info">Puskesmas</span>
                    @else
                    <span class="badge badge-success">Kader</span>
                    @endif
                </td>
                @if($isAdmin)
                <td>
                    <span class="text-neutral-700">{{ $item->puskesmas->name ?? '-' }}</span>
                </td>
                @endif
                <td>
                    @if ($item->is_active)
                    <span class="badge badge-success">Aktif</span>
                    @else
                    <span class="badge badge-neutral">Nonaktif</span>
                    @endif
                </td>
                <td>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('users.show', $item) }}" class="btn-ghost btn-sm" title="Lihat Detail">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                        <a href="{{ route('users.edit', $item) }}" class="btn-secondary btn-sm" title="Edit Data">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        @if($item->id !== Auth::id())
                        <form method="post" action="{{ route('users.destroy', $item) }}" x-data
                            @submit.prevent="if(confirm('Hapus user {{ $item->name }}?')) $el.submit()" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger btn-sm" title="Hapus Data">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                        @endif
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
            <h4 class="font-semibold text-blue-900 mb-1">Informasi Role</h4>
            <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                <li><strong>Admin:</strong> Akses penuh ke semua fitur dan data</li>
                <li><strong>Puskesmas:</strong> Kelola data di wilayah puskesmas terkait</li>
                <li><strong>Kader:</strong> Input dan lihat data posyandu yang ditugaskan</li>
            </ul>
        </div>
    </div>
</div>

@endsection