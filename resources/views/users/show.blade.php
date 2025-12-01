@extends('layouts.app')

@section('content')
@php($header = '👤 Detail User')

<div class="card-cute">
    <!-- Header -->
    <div class="mb-6 text-center">
        <div
            class="w-24 h-24 mx-auto bg-gradient-to-br from-pink-400 via-purple-400 to-pink-500 rounded-full flex items-center justify-center text-white text-4xl font-bold shadow-lg mb-4">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
        <h2 class="text-2xl font-bold text-slate-800">{{ $user->name }}</h2>
        <p class="text-slate-500">{{ $user->email }}</p>
    </div>

    <!-- Info Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Role -->
        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-4 border-2 border-purple-200">
            <div class="text-2xl mb-2">🎭</div>
            <div class="text-sm text-slate-600">Role</div>
            <div class="font-bold text-purple-700">{{ ucfirst($user->role) }}</div>
        </div>

        <!-- Puskesmas -->
        <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-4 border-2 border-blue-200">
            <div class="text-2xl mb-2">🏥</div>
            <div class="text-sm text-slate-600">Puskesmas</div>
            <div class="font-bold text-blue-700">{{ optional($user->puskesmas)->name ?? '-' }}</div>
        </div>

        <!-- Status -->
        <div
            class="bg-gradient-to-br {{ $user->is_active ? 'from-emerald-50 to-green-50 border-emerald-200' : 'from-slate-50 to-gray-50 border-slate-200' }} rounded-xl p-4 border-2">
            <div class="text-2xl mb-2">{{ $user->is_active ? '✅' : '⏸️' }}</div>
            <div class="text-sm text-slate-600">Status</div>
            <div class="font-bold {{ $user->is_active ? 'text-emerald-700' : 'text-slate-700' }}">
                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
            </div>
        </div>
    </div>

    <!-- Detail Info -->
    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 mb-6">
        <h3 class="font-semibold text-slate-700 mb-3">📋 Informasi Akun</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-slate-500">Terdaftar:</span>
                <span class="font-medium text-slate-700">{{ $user->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div>
                <span class="text-slate-500">Terakhir Diperbarui:</span>
                <span class="font-medium text-slate-700">{{ $user->updated_at->format('d M Y, H:i') }}</span>
            </div>
            @if($user->last_login_at)
            <div>
                <span class="text-slate-500">Login Terakhir:</span>
                <span class="font-medium text-slate-700">{{ $user->last_login_at->format('d M Y, H:i') }}</span>
            </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex items-center gap-3 pt-4 border-t border-slate-200">
        <a href="{{ route('users.index') }}" class="btn-secondary">
            <span>← Kembali</span>
        </a>
        <a href="{{ route('users.edit', $user) }}" class="btn-primary">
            <span>✏️ Edit User</span>
        </a>
        @if($user->id !== Auth::id())
        <form method="post" action="{{ route('users.destroy', $user) }}" x-data
            @submit.prevent="if(confirm('Yakin ingin menghapus user ini?')) $el.submit()">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="px-4 py-2 rounded-xl border-2 border-rose-300 text-rose-700 hover:bg-rose-50 transition-all">
                🗑️ Hapus
            </button>
        </form>
        @endif
    </div>
</div>
@endsection