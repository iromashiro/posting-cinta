<?php

namespace App\Http\Controllers;

use App\Http\Requests\PosyanduRequest;
use App\Models\Posyandu;
use App\Models\Puskesmas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosyanduController extends Controller
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

    // GET /posyandu
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $puskesmasId = $request->integer('puskesmas_id');

        $accessiblePuskesmasId = $this->getAccessiblePuskesmasId();

        $items = Posyandu::query()
            ->when($accessiblePuskesmasId !== null, fn($qBuilder) => $qBuilder->where('puskesmas_id', $accessiblePuskesmasId))
            ->when($q, fn($qBuilder) => $qBuilder->where('name', 'like', "%{$q}%"))
            ->when($puskesmasId && $accessiblePuskesmasId === null, fn($qBuilder) => $qBuilder->where('puskesmas_id', $puskesmasId))
            ->with(['puskesmas', 'kader'])
            ->orderBy('name')
            ->paginate(15)
            ->appends($request->query());

        // Only show puskesmas filter for admin
        $puskesmas = $accessiblePuskesmasId === null
            ? Puskesmas::orderBy('name')->get(['id', 'name'])
            : collect();

        return view('posyandu.index', compact('items', 'q', 'puskesmas', 'puskesmasId'));
    }

    // GET /posyandu/create
    public function create()
    {
        $accessiblePuskesmasId = $this->getAccessiblePuskesmasId();

        $puskesmas = $accessiblePuskesmasId === null
            ? Puskesmas::orderBy('name')->get(['id', 'name'])
            : Puskesmas::where('id', $accessiblePuskesmasId)->get(['id', 'name']);

        $kaders = User::where('role', 'kader')
            ->when($accessiblePuskesmasId !== null, fn($q) => $q->where('puskesmas_id', $accessiblePuskesmasId))
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('posyandu.create', compact('puskesmas', 'kaders'));
    }

    // POST /posyandu
    public function store(PosyanduRequest $request)
    {
        $data = $request->validated();

        // Verify puskesmas is accessible
        $accessiblePuskesmasId = $this->getAccessiblePuskesmasId();
        if ($accessiblePuskesmasId !== null && $data['puskesmas_id'] != $accessiblePuskesmasId) {
            abort(403, 'Anda tidak memiliki akses ke puskesmas ini.');
        }

        $item = Posyandu::create($data);
        return redirect()->route('posyandu.show', $item)->with('success', 'Posyandu berhasil dibuat.');
    }

    // GET /posyandu/{posyandu}
    public function show(Posyandu $posyandu)
    {
        // Check access
        $accessiblePuskesmasId = $this->getAccessiblePuskesmasId();
        if ($accessiblePuskesmasId !== null && $posyandu->puskesmas_id != $accessiblePuskesmasId) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $posyandu->load(['puskesmas', 'kader', 'mothers', 'children']);
        return view('posyandu.show', compact('posyandu'));
    }

    // GET /posyandu/{posyandu}/edit
    public function edit(Posyandu $posyandu)
    {
        $accessiblePuskesmasId = $this->getAccessiblePuskesmasId();

        // Check access
        if ($accessiblePuskesmasId !== null && $posyandu->puskesmas_id != $accessiblePuskesmasId) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $puskesmas = $accessiblePuskesmasId === null
            ? Puskesmas::orderBy('name')->get(['id', 'name'])
            : Puskesmas::where('id', $accessiblePuskesmasId)->get(['id', 'name']);

        $kaders = User::where('role', 'kader')
            ->when($accessiblePuskesmasId !== null, fn($q) => $q->where('puskesmas_id', $accessiblePuskesmasId))
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('posyandu.edit', compact('posyandu', 'puskesmas', 'kaders'));
    }

    // PUT/PATCH /posyandu/{posyandu}
    public function update(PosyanduRequest $request, Posyandu $posyandu)
    {
        $accessiblePuskesmasId = $this->getAccessiblePuskesmasId();

        // Check access
        if ($accessiblePuskesmasId !== null && $posyandu->puskesmas_id != $accessiblePuskesmasId) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $data = $request->validated();

        // Verify new puskesmas is accessible
        if ($accessiblePuskesmasId !== null && $data['puskesmas_id'] != $accessiblePuskesmasId) {
            abort(403, 'Anda tidak memiliki akses ke puskesmas ini.');
        }

        $posyandu->update($data);
        return redirect()->route('posyandu.show', $posyandu)->with('success', 'Posyandu berhasil diperbarui.');
    }

    // DELETE /posyandu/{posyandu}
    public function destroy(Posyandu $posyandu)
    {
        $accessiblePuskesmasId = $this->getAccessiblePuskesmasId();

        // Check access
        if ($accessiblePuskesmasId !== null && $posyandu->puskesmas_id != $accessiblePuskesmasId) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $posyandu->delete();
        return redirect()->route('posyandu.index')->with('success', 'Posyandu berhasil dihapus.');
    }
}
