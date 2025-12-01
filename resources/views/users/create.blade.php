@extends('layouts.app')

@section('content')
@php
$header = '➕ Tambah ' . ($accessiblePuskesmasId ? 'Kader' : 'User');
@endphp

<div class="card-cute">
    <!-- Header -->
    <div class="mb-6 text-center">
        <div class="text-5xl mb-3">👤✨</div>
        <h2 class="text-xl font-semibold text-slate-800 mb-1">Tambah
            {{ $accessiblePuskesmasId ? 'Kader Baru' : 'User Baru' }}</h2>
        <p class="text-sm text-slate-600">Isi data untuk membuat akun baru</p>
    </div>

    <form method="post" action="{{ route('users.store') }}" class="space-y-6">
        @csrf

        <!-- Info Helper -->
        <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <div class="text-2xl">💡</div>
                <div class="flex-1 text-sm text-blue-800">
                    <strong>Tips:</strong> Data bertanda <span class="text-rose-600 font-bold">*</span> wajib diisi.
                    Password minimal 8 karakter.
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama -->
            <div>
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>👤</span>
                        <span>Nama Lengkap <span class="text-rose-600">*</span></span>
                    </span>
                </label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap"
                    class="input-field @error('name') input-error @enderror">
                @error('name') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>📧</span>
                        <span>Email <span class="text-rose-600">*</span></span>
                    </span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com"
                    class="input-field @error('email') input-error @enderror">
                @error('email') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>🔒</span>
                        <span>Password <span class="text-rose-600">*</span></span>
                    </span>
                </label>
                <input type="password" name="password" placeholder="Minimal 8 karakter"
                    class="input-field @error('password') input-error @enderror">
                @error('password') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>🔒</span>
                        <span>Konfirmasi Password <span class="text-rose-600">*</span></span>
                    </span>
                </label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password" class="input-field">
            </div>

            @if(!$accessiblePuskesmasId)
            <!-- Role -->
            <div>
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>🎭</span>
                        <span>Role <span class="text-rose-600">*</span></span>
                    </span>
                </label>
                <select name="role" class="input-field @error('role') input-error @enderror">
                    <option value="">Pilih Role</option>
                    @foreach ($roles as $r)
                    <option value="{{ $r }}" {{ old('role') === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                    @endforeach
                </select>
                <p class="form-helper">Admin: akses penuh, Puskesmas: kelola data di puskesmas, Kader: input data</p>
                @error('role') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <!-- Puskesmas -->
            <div>
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>🏥</span>
                        <span>Puskesmas</span>
                    </span>
                </label>
                <select name="puskesmas_id" class="input-field @error('puskesmas_id') input-error @enderror">
                    <option value="">- Tidak Ada (Admin) -</option>
                    @foreach ($puskesmas as $p)
                    <option value="{{ $p->id }}" {{ old('puskesmas_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}
                    </option>
                    @endforeach
                </select>
                <p class="form-helper">Wajib diisi untuk role Puskesmas dan Kader</p>
                @error('puskesmas_id') <div class="error-message">{{ $message }}</div> @enderror
            </div>
            @else
            <input type="hidden" name="role" value="kader">
            <input type="hidden" name="puskesmas_id" value="{{ $accessiblePuskesmasId }}">
            @endif

            <!-- Status Aktif -->
            <div class="md:col-span-2">
                <label class="inline-flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        class="w-5 h-5 rounded border-slate-300 text-brand-500 focus:ring-brand-400">
                    <span class="text-sm font-medium text-slate-700">✓ Aktif (dapat login)</span>
                </label>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="pt-4 flex items-center gap-3 border-t border-slate-200">
            <a href="{{ route('users.index') }}" class="btn-secondary">
                <span>← Kembali</span>
            </a>
            <button type="submit" class="btn-primary">
                <span>💾 Simpan User</span>
            </button>
        </div>
    </form>
</div>
@endsection