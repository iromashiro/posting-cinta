<?php

namespace App\Http\Controllers;

use App\Http\Requests\MotherRequest;
use App\Models\Mother;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MotherController extends Controller
{
    /**
     * Get posyandu IDs accessible by current user
     */
    private function getAccessiblePosyanduIds(): ?array
    {
        $user = Auth::user();

        // Admin can see all
        if ($user->role === 'admin') {
            return null;
        }

        // Puskesmas user can only see posyandu under their puskesmas
        if ($user->puskesmas_id) {
            return Posyandu::where('puskesmas_id', $user->puskesmas_id)
                ->pluck('id')
                ->toArray();
        }

        return [];
    }

    // GET /mothers
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $posyanduId = $request->integer('posyandu_id');

        $accessiblePosyanduIds = $this->getAccessiblePosyanduIds();

        $items = Mother::query()
            ->when($accessiblePosyanduIds !== null, fn($qb) => $qb->whereIn('posyandu_id', $accessiblePosyanduIds))
            ->when($q, function ($qb) use ($q) {
                $qb->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                        ->orWhere('nik', 'like', "%{$q}%");
                });
            })
            ->when($posyanduId, fn($qb) => $qb->where('posyandu_id', $posyanduId))
            ->withCount('children')
            ->with('posyandu')
            ->orderBy('name')
            ->simplePaginate(15)
            ->appends($request->query());

        $posyandus = Posyandu::query()
            ->when($accessiblePosyanduIds !== null, fn($q) => $q->whereIn('id', $accessiblePosyanduIds))
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('mothers.index', compact('items', 'q', 'posyanduId', 'posyandus'));
    }

    // GET /mothers/create
    public function create()
    {
        $accessiblePosyanduIds = $this->getAccessiblePosyanduIds();

        $posyandus = Posyandu::query()
            ->when($accessiblePosyanduIds !== null, fn($q) => $q->whereIn('id', $accessiblePosyanduIds))
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('mothers.create', compact('posyandus'));
    }

    // POST /mothers
    public function store(MotherRequest $request)
    {
        $data = $request->validated();

        // Verify posyandu is accessible
        $accessiblePosyanduIds = $this->getAccessiblePosyanduIds();
        if ($accessiblePosyanduIds !== null && !in_array($data['posyandu_id'], $accessiblePosyanduIds)) {
            abort(403, 'Anda tidak memiliki akses ke posyandu ini.');
        }

        $data['created_by'] = Auth::id() ?? 1;

        $item = Mother::create($data);
        return redirect()->route('mothers.show', $item)->with('success', 'Ibu berhasil dibuat.');
    }

    // GET /mothers/{mother}
    public function show(Mother $mother)
    {
        // Check access
        $accessiblePosyanduIds = $this->getAccessiblePosyanduIds();
        if ($accessiblePosyanduIds !== null && !in_array($mother->posyandu_id, $accessiblePosyanduIds)) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $mother->load(['posyandu', 'children']);
        return view('mothers.show', compact('mother'));
    }

    // GET /mothers/{mother}/edit
    public function edit(Mother $mother)
    {
        $accessiblePosyanduIds = $this->getAccessiblePosyanduIds();

        // Check access
        if ($accessiblePosyanduIds !== null && !in_array($mother->posyandu_id, $accessiblePosyanduIds)) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $posyandus = Posyandu::query()
            ->when($accessiblePosyanduIds !== null, fn($q) => $q->whereIn('id', $accessiblePosyanduIds))
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('mothers.edit', compact('mother', 'posyandus'));
    }

    // PUT/PATCH /mothers/{mother}
    public function update(MotherRequest $request, Mother $mother)
    {
        $accessiblePosyanduIds = $this->getAccessiblePosyanduIds();

        // Check access
        if ($accessiblePosyanduIds !== null && !in_array($mother->posyandu_id, $accessiblePosyanduIds)) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $data = $request->validated();

        // Verify new posyandu is accessible
        if ($accessiblePosyanduIds !== null && !in_array($data['posyandu_id'], $accessiblePosyanduIds)) {
            abort(403, 'Anda tidak memiliki akses ke posyandu ini.');
        }

        $mother->update($data);
        return redirect()->route('mothers.show', $mother)->with('success', 'Ibu berhasil diperbarui.');
    }

    // DELETE /mothers/{mother}
    public function destroy(Mother $mother)
    {
        $accessiblePosyanduIds = $this->getAccessiblePosyanduIds();

        // Check access
        if ($accessiblePosyanduIds !== null && !in_array($mother->posyandu_id, $accessiblePosyanduIds)) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $mother->delete();
        return redirect()->route('mothers.index')->with('success', 'Ibu berhasil dihapus.');
    }
}
