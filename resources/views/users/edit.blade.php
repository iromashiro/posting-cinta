@extends('layouts.app')

@section('content')
@php
$header = '✏️ Edit User';
@endphp

<div class="card-cute">
    <!-- Header -->
    <div class="mb-6 text-center">
        <div
            class="w-20 h-20 mx-auto bg-gradient-to-br from-pink-400 via-purple-400 to-pink-500 rounded-full flex items-center justify-center text-white text-3xl font-bold shadow-lg mb-4">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <h2 class="text-xl font-semibold text-slate-800 mb-1">Edit User</h2>
        <p class="text-sm text-slate-600">{{ $user->email }}</p>
    </div>

    <form method="post" action="{{ route('users.update', $user) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Info Helper -->
        <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
            <div class="flex items-start gap-3">
                <div class="text-2xl">💡</div>
                <div class="flex-1 text-sm text-blue-800">
                    <strong>Tips:</strong> Kosongkan password jika tidak ingin mengubahnya.
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
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    placeholder="Masukkan nama lengkap" class="input-field @error('name') input-error @enderror">
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
                <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="contoh@email.com"
                    class="input-field @error('email') input-error @enderror">
                @error('email') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>🔒</span>
                        <span>Password Baru</span>
                    </span>
                </label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak diubah"
                    class="input-field @error('password') input-error @enderror">
                <p class="form-helper">Minimal 8 karakter</p>
                @error('password') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="form-label">
                    <span class="flex items-center gap-2">
                        <span>🔒</span>
                        <span>Konfirmasi Password Baru</span>
                    </span>
                </label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                    class="input-field">
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
                    <option value="{{ $r }}" {{ old('role', $user->role) === $r ? 'selected' : '' }}>{{ ucfirst($r) }}
                    </option>
                    @endforeach
                </select>
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
                    <option value="{{ $p->id }}"
                        {{ old('puskesmas_id', $user->puskesmas_id) == $p->id ? 'selected' : '' }}>{{ $p->name }}
                    </option>
                    @endforeach
                </select>
                @error('puskesmas_id') <div class="error-message">{{ $message }}</div> @enderror
            </div>
            @else
            <input type="hidden" name="role" value="kader">
            <input type="hidden" name="puskesmas_id" value="{{ $accessiblePuskesmasId }}">
            @endif

            <!-- Status Aktif -->
            <div class="md:col-span-2">
                <label class="inline-flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1"
                        {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                        class="w-5 h-5 rounded border-slate-300 text-brand-500 focus:ring-brand-400">
                    <span class="text-sm font-medium text-slate-700">✓ Aktif (dapat login)</span>
                </label>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="pt-4 flex items-center gap-3 border-t border-slate-200">
            <a href="{{ route('users.show', $user) }}" class="btn-secondary">
                <span>← Batal</span>
            </a>
            <button type="submit" class="btn-primary">
                <span>💾 Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>
@endsection