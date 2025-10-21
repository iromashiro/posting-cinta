<?php

namespace App\Http\Controllers;

use App\Models\GrowthStandard;
use Illuminate\Http\Request;

class GrowthStandardController extends Controller
{
    // GET /growth-standards
    public function index(Request $request)
    {
        $indicator = $request->string('indicator')->toString(); // wfa|hfa|wfh
        $gender = $request->string('gender')->toString();       // male|female

        $items = GrowthStandard::query()
            ->when($indicator, fn($q) => $q->where('indicator', $indicator))
            ->when($gender, fn($q) => $q->where('gender', $gender))
            ->orderBy('indicator')
            ->orderBy('gender')
            ->orderByRaw('COALESCE(age_months, 100000), COALESCE(length_height_cm, 100000)')
            ->simplePaginate(25)
            ->appends($request->query());

        $indicators = ['wfa' => 'BB/U', 'hfa' => 'TB/U', 'wfh' => 'BB/TB'];

        return view('growth-standards.index', compact('items', 'indicator', 'gender', 'indicators'));
    }

    // GET /growth-standards/{growthStandard}
    public function show(GrowthStandard $growthStandard)
    {
        return view('growth-standards.show', compact('growthStandard'));
    }
}
