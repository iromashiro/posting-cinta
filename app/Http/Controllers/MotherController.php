<?php

namespace App\Http\Controllers;

use App\Http\Requests\MotherRequest;
use App\Models\Mother;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MotherController extends Controller
{
    // GET /mothers
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $posyanduId = $request->integer('posyandu_id');

        $items = Mother::query()
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

        $posyandus = Posyandu::orderBy('name')->get(['id', 'name']);

        return view('mothers.index', compact('items', 'q', 'posyanduId', 'posyandus'));
    }

    // GET /mothers/create
    public function create()
    {
        $posyandus = Posyandu::orderBy('name')->get(['id', 'name']);
        return view('mothers.create', compact('posyandus'));
    }

    // POST /mothers
    public function store(MotherRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id() ?? 1;

        $item = Mother::create($data);
        return redirect()->route('mothers.show', $item)->with('success', 'Ibu berhasil dibuat.');
    }

    // GET /mothers/{mother}
    public function show(Mother $mother)
    {
        $mother->load(['posyandu', 'children']);
        return view('mothers.show', compact('mother'));
    }

    // GET /mothers/{mother}/edit
    public function edit(Mother $mother)
    {
        $posyandus = Posyandu::orderBy('name')->get(['id', 'name']);
        return view('mothers.edit', compact('mother', 'posyandus'));
    }

    // PUT/PATCH /mothers/{mother}
    public function update(MotherRequest $request, Mother $mother)
    {
        $data = $request->validated();
        $mother->update($data);
        return redirect()->route('mothers.show', $mother)->with('success', 'Ibu berhasil diperbarui.');
    }

    // DELETE /mothers/{mother}
    public function destroy(Mother $mother)
    {
        $mother->delete();
        return redirect()->route('mothers.index')->with('success', 'Ibu berhasil dihapus.');
    }
}
