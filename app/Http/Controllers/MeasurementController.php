<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeasurementRequest;
use App\Models\Child;
use App\Models\GrowthStandard;
use App\Models\Measurement;
use App\Notifications\MeasurementRecorded;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MeasurementController extends Controller
{
    // GET /measurements
    public function index(Request $request)
    {
        $childId = $request->integer('child_id');
        $items = Measurement::query()
            ->when($childId, fn($q) => $q->where('child_id', $childId))
            ->with(['child.mother', 'child.posyandu'])
            ->orderByDesc('measured_at')
            ->simplePaginate(15)
            ->appends($request->query());

        $children = Child::orderBy('name')->get(['id', 'name']);

        return view('measurements.index', compact('items', 'children', 'childId'));
    }

    // GET /measurements/create
    public function create(Request $request)
    {
        $children = Child::orderBy('name')->get(['id', 'name']);
        $prefillChildId = $request->integer('child_id') ?: null;

        return view('measurements.create', compact('children', 'prefillChildId'));
    }

    // POST /measurements
    public function store(MeasurementRequest $request)
    {
        $data = $request->validated();

        $child = Child::with('creator')->findOrFail($data['child_id']);

        // Derive age in months using measured_at vs DOB
        $measuredAt = Carbon::parse($data['measured_at'])->startOfDay();
        $dob = Carbon::parse($child->date_of_birth)->startOfDay();
        $ageMonths = $dob->diffInMonths($measuredAt);
        $data['age_months'] = $ageMonths;

        // Compute z-scores based on WHO LMS
        [$wfaZ, $hfaZ, $wfhZ] = $this->computeZScores(
            gender: $child->gender,
            ageMonths: $ageMonths,
            weightKg: (float) $data['weight'],
            heightCm: (float) $data['height']
        );

        $data['weight_for_age_z'] = $wfaZ;
        $data['height_for_age_z'] = $hfaZ;
        $data['weight_for_height_z'] = $wfhZ;

        // Nutrition status (focus: stunting by HFA)
        $data['nutrition_status'] = $this->deriveNutritionStatus($hfaZ);

        $data['created_by'] = Auth::id() ?? 1;

        $measurement = Measurement::create($data);

        // Notify (DB notifications) child's creator if exists
        if ($child->creator) {
            $child->creator->notify(new MeasurementRecorded(
                measurementId: $measurement->id,
                childId: $child->id,
                childName: $child->name,
                measuredAt: $measurement->measured_at->format('Y-m-d'),
                nutritionStatus: $measurement->nutrition_status
            ));
        }

        return redirect()->route('children.show', $child)->with('success', 'Pengukuran berhasil disimpan.');
    }

    // GET /measurements/{measurement}
    public function show(Measurement $measurement)
    {
        $measurement->load('child.mother', 'child.posyandu');
        return view('measurements.show', compact('measurement'));
    }

    // GET /measurements/{measurement}/edit
    public function edit(Measurement $measurement)
    {
        $children = Child::orderBy('name')->get(['id', 'name']);
        return view('measurements.edit', compact('measurement', 'children'));
    }

    // PUT/PATCH /measurements/{measurement}
    public function update(MeasurementRequest $request, Measurement $measurement)
    {
        $data = $request->validated();
        $child = Child::findOrFail($data['child_id']);

        $measuredAt = Carbon::parse($data['measured_at'])->startOfDay();
        $dob = Carbon::parse($child->date_of_birth)->startOfDay();
        $ageMonths = $dob->diffInMonths($measuredAt);
        $data['age_months'] = $ageMonths;

        [$wfaZ, $hfaZ, $wfhZ] = $this->computeZScores(
            gender: $child->gender,
            ageMonths: $ageMonths,
            weightKg: (float) $data['weight'],
            heightCm: (float) $data['height']
        );

        $data['weight_for_age_z'] = $wfaZ;
        $data['height_for_age_z'] = $hfaZ;
        $data['weight_for_height_z'] = $wfhZ;
        $data['nutrition_status'] = $this->deriveNutritionStatus($hfaZ);

        $measurement->update($data);

        return redirect()->route('children.show', $child)->with('success', 'Pengukuran berhasil diperbarui.');
    }

    // DELETE /measurements/{measurement}
    public function destroy(Measurement $measurement)
    {
        $child = $measurement->child;
        $measurement->delete();
        return redirect()->route('children.show', $child)->with('success', 'Pengukuran berhasil dihapus.');
    }

    private function computeZScores(string $gender, int $ageMonths, float $weightKg, float $heightCm): array
    {
        $wfa = $this->nearestByAge($gender, 'wfa', $ageMonths);
        $hfa = $this->nearestByAge($gender, 'hfa', $ageMonths);
        $wfh = $this->nearestByLength($gender, 'wfh', $heightCm);

        $wfaZ = $wfa ? $this->zScore($weightKg, $wfa->l, $wfa->m, $wfa->s) : null;
        $hfaZ = $hfa ? $this->zScore($heightCm, $hfa->l, $hfa->m, $hfa->s) : null;
        $wfhZ = $wfh ? $this->zScore($weightKg, $wfh->l, $wfh->m, $wfh->s) : null;

        return [$wfaZ, $hfaZ, $wfhZ];
    }

    private function deriveNutritionStatus(?float $hfaZ): ?string
    {
        if ($hfaZ === null) {
            return null;
        }
        if ($hfaZ < -3) {
            return 'severe';
        }
        if ($hfaZ < -2) {
            return 'stunting';
        }
        return 'normal';
    }

    private function nearestByAge(string $gender, string $indicator, int $ageMonths): ?GrowthStandard
    {
        return GrowthStandard::query()
            ->where('gender', $gender)
            ->where('indicator', $indicator)
            ->whereNotNull('age_months')
            ->orderByRaw('ABS(age_months - ?) asc', [$ageMonths])
            ->first();
    }

    private function nearestByLength(string $gender, string $indicator, float $lengthCm): ?GrowthStandard
    {
        return GrowthStandard::query()
            ->where('gender', $gender)
            ->where('indicator', $indicator)
            ->whereNotNull('length_height_cm')
            ->orderByRaw('ABS(length_height_cm - ?) asc', [$lengthCm])
            ->first();
    }

    private function zScore(float $y, float $l, float $m, float $s): ?float
    {
        if ($m <= 0 || $s <= 0 || $y <= 0) {
            return null;
        }
        if (abs($l) < 1e-9) {
            return log($y / $m) / $s;
        }
        return ((pow($y / $m, $l) - 1.0) / ($l * $s));
    }
}
