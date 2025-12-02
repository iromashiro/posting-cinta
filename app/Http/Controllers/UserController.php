<?php

namespace App\Http\Controllers;

use App\Models\Puskesmas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Get puskesmas ID accessible by current user
     */
    private function getAccessiblePuskesmasId(): ?int
    {
        $user = Auth::user();

        // Admin can see all
        if ($user->role === 'admin') {
            return null;
        }

        return $user->puskesmas_id;
    }

    // GET /users
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $role = $request->string('role')->toString();
        $puskesmasId = $request->integer('puskesmas_id');

        $accessiblePuskesmasId = $this->getAccessiblePuskesmasId();

        $items = User::query()
            ->when($accessiblePuskesmasId !== null, fn($qb) => $qb->where('puskesmas_id', $accessiblePuskesmasId))
            // Non-admin users can only see kader role
            ->when($accessiblePuskesmasId !== null, fn($qb) => $qb->where('role', 'kader'))
            ->when($q, function ($qb) use ($q) {
                $qb->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->when($role && $accessiblePuskesmasId === null, fn($qb) => $qb->where('role', $role))
            ->when($puskesmasId && $accessiblePuskesmasId === null, fn($qb) => $qb->where('puskesmas_id', $puskesmasId))
            ->with('puskesmas')
            ->orderBy('name')
            ->paginate(15)
            ->appends($request->query());

        // Only show filters for admin
        $puskesmas = $accessiblePuskesmasId === null
            ? Puskesmas::orderBy('name')->get(['id', 'name'])
            : collect();

        $roles = $accessiblePuskesmasId === null
            ? ['admin', 'puskesmas', 'kader']
            : ['kader'];

        return view('users.index', compact('items', 'q', 'role', 'puskesmasId', 'puskesmas', 'roles'));
    }

    // GET /users/create
    public function create()
    {
        $accessiblePuskesmasId = $this->getAccessiblePuskesmasId();

        $puskesmas = $accessiblePuskesmasId === null
            ? Puskesmas::orderBy('name')->get(['id', 'name'])
            : Puskesmas::where('id', $accessiblePuskesmasId)->get(['id', 'name']);

        $roles = $accessiblePuskesmasId === null
            ? ['admin', 'puskesmas', 'kader']
            : ['kader'];

        return view('users.create', compact('puskesmas', 'roles', 'accessiblePuskesmasId'));
    }

    // POST /users
    public function store(Request $request)
    {
        $accessiblePuskesmasId = $this->getAccessiblePuskesmasId();

        // Non-admin can only create kader
        $allowedRoles = $accessiblePuskesmasId === null
            ? ['admin', 'puskesmas', 'kader']
            : ['kader'];

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in($allowedRoles)],
            'puskesmas_id' => ['nullable', 'exists:puskesmas,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // Verify puskesmas is accessible
        if ($accessiblePuskesmasId !== null) {
            $validated['puskesmas_id'] = $accessiblePuskesmasId;
            $validated['role'] = 'kader';
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->boolean('is_active', true);

        $user = User::create($validated);

        return redirect()->route('users.show', $user)->with('success', 'User berhasil dibuat.');
    }

    // GET /users/{user}
    public function show(User $user)
    {
        $accessiblePuskesmasId = $this->getAccessiblePuskesmasId();

        // Check access
        if ($accessiblePuskesmasId !== null) {
            if ($user->puskesmas_id != $accessiblePuskesmasId || $user->role !== 'kader') {
                abort(403, 'Anda tidak memiliki akses ke data ini.');
            }
        }

        $user->load('puskesmas');
        return view('users.show', compact('user'));
    }

    // GET /users/{user}/edit
    public function edit(User $user)
    {
        $accessiblePuskesmasId = $this->getAccessiblePuskesmasId();

        // Check access
        if ($accessiblePuskesmasId !== null) {
            if ($user->puskesmas_id != $accessiblePuskesmasId || $user->role !== 'kader') {
                abort(403, 'Anda tidak memiliki akses ke data ini.');
            }
        }

        $puskesmas = $accessiblePuskesmasId === null
            ? Puskesmas::orderBy('name')->get(['id', 'name'])
            : Puskesmas::where('id', $accessiblePuskesmasId)->get(['id', 'name']);

        $roles = $accessiblePuskesmasId === null
            ? ['admin', 'puskesmas', 'kader']
            : ['kader'];

        return view('users.edit', compact('user', 'puskesmas', 'roles', 'accessiblePuskesmasId'));
    }

    // PUT/PATCH /users/{user}
    public function update(Request $request, User $user)
    {
        $accessiblePuskesmasId = $this->getAccessiblePuskesmasId();

        // Check access
        if ($accessiblePuskesmasId !== null) {
            if ($user->puskesmas_id != $accessiblePuskesmasId || $user->role !== 'kader') {
                abort(403, 'Anda tidak memiliki akses ke data ini.');
            }
        }

        $allowedRoles = $accessiblePuskesmasId === null
            ? ['admin', 'puskesmas', 'kader']
            : ['kader'];

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in($allowedRoles)],
            'puskesmas_id' => ['nullable', 'exists:puskesmas,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // Verify puskesmas is accessible
        if ($accessiblePuskesmasId !== null) {
            $validated['puskesmas_id'] = $accessiblePuskesmasId;
            $validated['role'] = 'kader';
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        $user->update($validated);

        return redirect()->route('users.show', $user)->with('success', 'User berhasil diperbarui.');
    }

    // DELETE /users/{user}
    public function destroy(User $user)
    {
        $accessiblePuskesmasId = $this->getAccessiblePuskesmasId();

        // Check access
        if ($accessiblePuskesmasId !== null) {
            if ($user->puskesmas_id != $accessiblePuskesmasId || $user->role !== 'kader') {
                abort(403, 'Anda tidak memiliki akses ke data ini.');
            }
        }

        // Prevent self-delete
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
