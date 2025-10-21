<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChildRequest;
use App\Models\Child;
use App\Models\Mother;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChildController extends Controller
{
    // GET /children
    public function index(Request $request)
    {
        $q = $request->string('q')->toString();
        $posyanduId = $request->integer('posyandu_id');
        $motherId = $request->integer('mother_id');

        $items = Child::query()
            ->when($q, function ($qb) use ($q) {
                $qb->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                        ->orWhere('nik', 'like', "%{$q}%");
                });
            })
            ->when($posyanduId, fn($qb) => $qb->where('posyandu_id', $posyanduId))
            ->when($motherId, fn($qb) => $qb->where('mother_id', $motherId))
            ->with(['mother:id,name', 'posyandu:id,name'])
            ->orderBy('name')
            ->simplePaginate(15)
            ->appends($request->query());

        $posyandus = Posyandu::orderBy('name')->get(['id', 'name']);
        $mothers = Mother::orderBy('name')->get(['id', 'name']);

        return view('children.index', compact('items', 'q', 'posyanduId', 'motherId', 'posyandus', 'mothers'));
    }

    // GET /children/create
    public function create(Request $request)
    {
        $posyandus = Posyandu::orderBy('name')->get(['id', 'name']);
        $mothers = Mother::orderBy('name')->get(['id', 'name', 'posyandu_id']);

        $prefill = [
            'mother_id' => $request->integer('mother_id') ?: null,
            'posyandu_id' => $request->integer('posyandu_id') ?: null,
        ];

        return view('children.create', compact('posyandus', 'mothers', 'prefill'));
    }

    // POST /children
    public function store(ChildRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::id() ?? 1;

        $item = Child::create($data);
        return redirect()->route('children.show', $item)->with('success', 'Anak berhasil dibuat.');
    }

    // GET /children/{child}
    public function show(Child $child)
    {
        $child->load(['mother', 'posyandu', 'measurements' => fn($q) => $q->orderByDesc('measured_at')]);
        return view('children.show', compact('child'));
    }

    // GET /children/{child}/edit
    public function edit(Child $child)
    {
        $posyandus = Posyandu::orderBy('name')->get(['id', 'name']);
        $mothers = Mother::orderBy('name')->get(['id', 'name', 'posyandu_id']);
        return view('children.edit', compact('child', 'posyandus', 'mothers'));
    }

    // PUT/PATCH /children/{child}
    public function update(ChildRequest $request, Child $child)
    {
        $data = $request->validated();
        $child->update($data);
        return redirect()->route('children.show', $child)->with('success', 'Data anak berhasil diperbarui.');
    }

    // DELETE /children/{child}
    public function destroy(Child $child)
    {
        $child->delete();
        return redirect()->route('children.index')->with('success', 'Data anak berhasil dihapus.');
    }
}
