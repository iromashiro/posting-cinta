@extends('layouts.app')

@section('content')
@php
$isAdmin = !$accessiblePuskesmasId;
@endphp

<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Edit User</h1>
    <p class="page-subtitle">Perbarui data {{ $user->name }}</p>
</div>

<div class="card card-padding">
    <form method="post" action="{{ route('users.update', $user) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Info Helper -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1 text-sm text-blue-800">
                    <strong>Tips:</strong> Kosongkan password jika tidak ingin mengubahnya.
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama -->
            <div>
                <label class="input-label">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    placeholder="Masukkan nama lengkap" class="input-field @error('name') input-error @enderror">
                <p class="input-helper">Nama lengkap pengguna</p>
                @error('name') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="input-label">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="contoh@email.com"
                    class="input-field @error('email') input-error @enderror">
                <p class="input-helper">Email akan digunakan untuk login</p>
                @error('email') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="input-label">Password Baru</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak diubah"
                    class="input-field @error('password') input-error @enderror">
                <p class="input-helper">Minimal 8 karakter, kosongkan jika tidak diubah</p>
                @error('password') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="input-label">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                    class="input-field">
                <p class="input-helper">Masukkan ulang password baru</p>
            </div>

            @if($isAdmin)
            <!-- Role -->
            <div>
                <label class="input-label">
                    Role <span class="text-red-500">*</span>
                </label>
                <select name="role" class="input-field @error('role') input-error @enderror">
                    <option value="">Pilih Role</option>
                    @foreach ($roles as $r)
                    <option value="{{ $r }}" {{ old('role', $user->role) === $r ? 'selected' : '' }}>{{ ucfirst($r) }}
                    </option>
                    @endforeach
                </select>
                <p class="input-helper">Admin: akses penuh, Puskesmas: kelola wilayah, Kader: input data</p>
                @error('role') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Puskesmas -->
            <div>
                <label class="input-label">Puskesmas</label>
                <select name="puskesmas_id" class="input-field @error('puskesmas_id') input-error @enderror">
                    <option value="">- Tidak Ada (Admin) -</option>
                    @foreach ($puskesmas as $p)
                    <option value="{{ $p->id }}"
                        {{ old('puskesmas_id', $user->puskesmas_id) == $p->id ? 'selected' : '' }}>{{ $p->name }}
                    </option>
                    @endforeach
                </select>
                <p class="input-helper">Wajib diisi untuk role Puskesmas dan Kader</p>
                @error('puskesmas_id') <p class="error-message">{{ $message }}</p> @enderror
            </div>
            @else
            <input type="hidden" name="role" value="kader">
            <input type="hidden" name="puskesmas_id" value="{{ $accessiblePuskesmasId }}">
            @endif

            <!-- Status Aktif -->
            <div class="md:col-span-2">
                <label class="input-label">Status</label>
                <div class="flex items-center gap-3 mt-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1"
                            {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                            class="w-4 h-4 text-primary-500 border-neutral-300 rounded focus:ring-primary-400">
                        <span class="text-sm font-medium text-neutral-700">Aktif (dapat login ke sistem)</span>
                    </label>
                </div>
                <p class="input-helper">Nonaktifkan jika user tidak perlu akses sementara</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-neutral-200">
            <a href="{{ route('users.show', $user) }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection