@extends('layouts.app')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="page-title">Detail User</h1>
            <p class="page-subtitle">Informasi lengkap pengguna sistem</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('users.edit', $user) }}" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            @if($user->id !== Auth::id())
            <form method="post" action="{{ route('users.destroy', $user) }}" x-data
                @submit.prevent="if(confirm('Yakin ingin menghapus user {{ $user->name }}?')) $el.submit()">
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
            @endif
        </div>
    </div>
</div>

<!-- User Profile Card -->
<div class="card card-padding mb-6">
    <div class="flex flex-col md:flex-row items-center gap-6">
        <!-- Avatar -->
        <div
            class="w-24 h-24 rounded-full bg-primary-500 flex items-center justify-center text-white text-4xl font-bold shadow-lg">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>

        <!-- Basic Info -->
        <div class="flex-1 text-center md:text-left">
            <h2 class="text-2xl font-bold text-neutral-900">{{ $user->name }}</h2>
            <p class="text-neutral-500">{{ $user->email }}</p>

            <div class="flex flex-wrap justify-center md:justify-start gap-2 mt-3">
                @if($user->role === 'admin')
                <span class="badge bg-purple-50 text-purple-700">Admin</span>
                @elseif($user->role === 'puskesmas')
                <span class="badge badge-info">Puskesmas</span>
                @else
                <span class="badge badge-success">Kader</span>
                @endif

                @if ($user->is_active)
                <span class="badge badge-success">Aktif</span>
                @else
                <span class="badge badge-neutral">Nonaktif</span>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Info Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <!-- Role -->
    <div class="card card-padding">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-neutral-500">Role</p>
                <p class="font-semibold text-neutral-900">{{ ucfirst($user->role) }}</p>
            </div>
        </div>
    </div>

    <!-- Puskesmas -->
    <div class="card card-padding">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-neutral-500">Puskesmas</p>
                <p class="font-semibold text-neutral-900">{{ optional($user->puskesmas)->name ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Status -->
    <div class="card card-padding">
        <div class="flex items-center gap-3">
            <div
                class="w-10 h-10 rounded-lg {{ $user->is_active ? 'bg-green-50' : 'bg-neutral-100' }} flex items-center justify-center">
                @if($user->is_active)
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                @else
                <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                @endif
            </div>
            <div>
                <p class="text-xs text-neutral-500">Status</p>
                <p class="font-semibold {{ $user->is_active ? 'text-green-700' : 'text-neutral-700' }}">
                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Detail Info -->
<div class="card card-padding">
    <h3 class="font-semibold text-neutral-900 mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-neutral-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        Informasi Akun
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-neutral-50 rounded-lg p-4 border border-neutral-200">
            <p class="text-xs text-neutral-500 mb-1">Terdaftar</p>
            <p class="font-medium text-neutral-900">{{ $user->created_at->format('d M Y, H:i') }}</p>
        </div>
        <div class="bg-neutral-50 rounded-lg p-4 border border-neutral-200">
            <p class="text-xs text-neutral-500 mb-1">Terakhir Diperbarui</p>
            <p class="font-medium text-neutral-900">{{ $user->updated_at->format('d M Y, H:i') }}</p>
        </div>
        @if($user->last_login_at)
        <div class="bg-neutral-50 rounded-lg p-4 border border-neutral-200 md:col-span-2">
            <p class="text-xs text-neutral-500 mb-1">Login Terakhir</p>
            <p class="font-medium text-neutral-900">{{ $user->last_login_at->format('d M Y, H:i') }}</p>
        </div>
        @endif
    </div>
</div>

<!-- Back Button -->
<div class="mt-6">
    <a href="{{ route('users.index') }}" class="btn-secondary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Daftar
    </a>
</div>

@endsection