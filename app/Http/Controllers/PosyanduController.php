<?php

namespace App\Http\Controllers;

use App\Http\Requests\PosyanduRequest;
use App\Models\Posyandu;
use App\Models\Puskesmas;
use App\Models\User;
use Illuminate\Http\Request;

class PosyanduController extends Controller
{
    // GET /posyandu
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $puskesmasId = $request->integer('puskesmas_id');

        $items = Posyandu::query()
            ->when($q, fn($qBuilder) => $qBuilder->where('name', 'like', "%{$q}%"))
            ->when($puskesmasId, fn($qBuilder) => $qBuilder->where('puskesmas_id', $puskesmasId))
            ->with(['puskesmas', 'kader'])
            ->orderBy('name')
            ->simplePaginate(15)
            ->appends($request->query());

        $puskesmas = Puskesmas::orderBy('name')->get(['id', 'name']);

        return view('posyandu.index', compact('items', 'q', 'puskesmas', 'puskesmasId'));
    }

    // GET /posyandu/create
    public function create()
    {
        $puskesmas = Puskesmas::orderBy('name')->get(['id', 'name']);
        $kaders = User::where('role', 'kader')->orderBy('name')->get(['id', 'name']);
        return view('posyandu.create', compact('puskesmas', 'kaders'));
    }

    // POST /posyandu
    public function store(PosyanduRequest $request)
    {
        $data = $request->validated();
        $item = Posyandu::create($data);
        return redirect()->route('posyandu.show', $item)->with('success', 'Posyandu berhasil dibuat.');
    }

    // GET /posyandu/{posyandu}
    public function show(Posyandu $posyandu)
    {
        $posyandu->load(['puskesmas', 'kader', 'mothers', 'children']);
        return view('posyandu.show', compact('posyandu'));
    }

    // GET /posyandu/{posyandu}/edit
    public function edit(Posyandu $posyandu)
    {
        $puskesmas = Puskesmas::orderBy('name')->get(['id', 'name']);
        $kaders = User::where('role', 'kader')->orderBy('name')->get(['id', 'name']);
        return view('posyandu.edit', compact('posyandu', 'puskesmas', 'kaders'));
    }

    // PUT/PATCH /posyandu/{posyandu}
    public function update(PosyanduRequest $request, Posyandu $posyandu)
    {
        $data = $request->validated();
        $posyandu->update($data);
        return redirect()->route('posyandu.show', $posyandu)->with('success', 'Posyandu berhasil diperbarui.');
    }

    // DELETE /posyandu/{posyandu}
    public function destroy(Posyandu $posyandu)
    {
        $posyandu->delete();
        return redirect()->route('posyandu.index')->with('success', 'Posyandu berhasil dihapus.');
    }
}
