@extends('layouts.app')

@section('content')
@php
$header = '👥 Kelola User/Kader';
$isAdmin = Auth::user()->role === 'admin';
@endphp

<div class="flex items-center justify-between mb-4">
    <h1 class="text-lg font-semibold">Daftar User</h1>
    <a href="{{ route('users.create') }}"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-brand-500 text-white hover:bg-brand-600 transition-all shadow-lg">
        <span>➕</span>
        <span>Tambah {{ $isAdmin ? 'User' : 'Kader' }}</span>
    </a>
</div>

<form method="get" class="mb-5 grid grid-cols-1 md:grid-cols-4 gap-3">
    <div>
        <input type="text" name="q" value="{{ $q }}" placeholder="Cari nama atau email..."
            class="w-full rounded-xl border-slate-300 focus:border-brand-400 focus:ring-brand-400">
    </div>
    @if($isAdmin)
    <div>
        <select name="role" class="w-full rounded-xl border-slate-300 focus:border-brand-400 focus:ring-brand-400">
            <option value="">Semua Role</option>
            @foreach ($roles as $r)
            <option value="{{ $r }}" {{ $role === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <select name="puskesmas_id"
            class="w-full rounded-xl border-slate-300 focus:border-brand-400 focus:ring-brand-400">
            <option value="">Semua Puskesmas</option>
            @foreach ($puskesmas as $p)
            <option value="{{ $p->id }}" {{ $puskesmasId == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
            @endforeach
        </select>
    </div>
    @endif
    <div class="flex gap-2">
        <button class="px-4 py-2 rounded-xl border border-slate-300 hover:bg-slate-50 transition-all">🔍 Filter</button>
        <a href="{{ route('users.index') }}"
            class="px-4 py-2 rounded-xl border border-slate-300 hover:bg-slate-50 transition-all">🔄 Reset</a>
    </div>
</form>

@if ($items->count() === 0)
<div class="text-center py-12">
    <div class="text-6xl mb-4">👤</div>
    <p class="text-slate-500">Belum ada data user.</p>
</div>
@else
<div class="overflow-x-auto rounded-xl border border-slate-200">
    <table class="min-w-full text-sm">
        <thead>
            <tr class="bg-gradient-to-r from-pink-50 to-purple-50 text-slate-700">
                <th class="text-left px-4 py-3 border-b font-semibold">Nama</th>
                <th class="text-left px-4 py-3 border-b font-semibold">Email</th>
                <th class="text-left px-4 py-3 border-b font-semibold">Role</th>
                @if($isAdmin)
                <th class="text-left px-4 py-3 border-b font-semibold">Puskesmas</th>
                @endif
                <th class="text-left px-4 py-3 border-b font-semibold">Status</th>
                <th class="text-right px-4 py-3 border-b font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            @php
            $roleColors = [
            'admin' => 'bg-purple-100 text-purple-700 border-purple-200',
            'puskesmas' => 'bg-blue-100 text-blue-700 border-blue-200',
            'kader' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
            ];
            $roleEmojis = [
            'admin' => '👑',
            'puskesmas' => '🏥',
            'kader' => '👩‍⚕️',
            ];
            $roleColor = $roleColors[$item->role] ?? 'bg-slate-100 text-slate-700';
            $roleEmoji = $roleEmojis[$item->role] ?? '👤';
            @endphp
            <tr class="hover:bg-slate-50 transition-colors">
                <td class="px-4 py-3 border-b">
                    <a href="{{ route('users.show', $item) }}" class="text-brand-600 hover:underline font-medium">
                        {{ $item->name }}
                    </a>
                </td>
                <td class="px-4 py-3 border-b text-slate-600">
                    {{ $item->email }}
                </td>
                <td class="px-4 py-3 border-b">
                    <span class="text-xs px-2 py-1 rounded-lg border {{ $roleColor }}">
                        {{ $roleEmoji }} {{ ucfirst($item->role) }}
                    </span>
                </td>
                @if($isAdmin)
                <td class="px-4 py-3 border-b text-slate-600">
                    {{ $item->puskesmas->name ?? '-' }}
                </td>
                @endif
                <td class="px-4 py-3 border-b">
                    @if ($item->is_active)
                    <span
                        class="text-emerald-700 bg-emerald-50 border border-emerald-200 text-xs px-2 py-1 rounded-lg">✓
                        Aktif</span>
                    @else
                    <span class="text-slate-600 bg-slate-50 border border-slate-200 text-xs px-2 py-1 rounded-lg">✗
                        Nonaktif</span>
                    @endif
                </td>
                <td class="px-4 py-3 border-b text-right">
                    <div class="inline-flex gap-2">
                        <a href="{{ route('users.edit', $item) }}"
                            class="px-3 py-1 rounded-lg border border-slate-300 hover:bg-slate-50 transition-all text-sm">✏️
                            Edit</a>
                        @if($item->id !== Auth::id())
                        <form method="post" action="{{ route('users.destroy', $item) }}" x-data
                            @submit.prevent="if(confirm('Hapus user ini?')) $el.submit()">
                            @csrf
                            @method('DELETE')
                            <button
                                class="px-3 py-1 rounded-lg border border-rose-300 text-rose-700 hover:bg-rose-50 transition-all text-sm">🗑️
                                Hapus</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $items->links() }}
</div>
@endif
@endsection