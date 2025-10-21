<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\GrowthStandard;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GrowthChartController extends Controller
{
    public function show(Child $child)
    {
        $measurements = $child->measurements()
            ->orderBy('measured_at')
            ->get(['age_months', 'height', 'weight', 'measured_at', 'height_for_age_z', 'weight_for_age_z', 'weight_for_height_z']);

        $gender = $child->gender;

        $hfaStd = GrowthStandard::where('gender', $gender)->where('indicator', 'hfa')->whereNotNull('age_months')->orderBy('age_months')->get();
        $wfaStd = GrowthStandard::where('gender', $gender)->where('indicator', 'wfa')->whereNotNull('age_months')->orderBy('age_months')->get();
        $wfhStd = GrowthStandard::where('gender', $gender)->where('indicator', 'wfh')->whereNotNull('length_height_cm')->orderBy('length_height_cm')->get();

        $hfa = [
            'sd' => [
                '-3' => $this->toPoints($hfaStd, 'age_months', -3),
                '-2' => $this->toPoints($hfaStd, 'age_months', -2),
                '0'  => $this->toPoints($hfaStd, 'age_months', 0),
                '2'  => $this->toPoints($hfaStd, 'age_months', 2),
                '3'  => $this->toPoints($hfaStd, 'age_months', 3),
            ],
            'child' => $measurements->map(fn($m) => ['x' => (int)$m->age_months, 'y' => (float)$m->height])->values(),
        ];

        $wfa = [
            'sd' => [
                '-3' => $this->toPoints($wfaStd, 'age_months', -3),
                '-2' => $this->toPoints($wfaStd, 'age_months', -2),
                '0'  => $this->toPoints($wfaStd, 'age_months', 0),
                '2'  => $this->toPoints($wfaStd, 'age_months', 2),
                '3'  => $this->toPoints($wfaStd, 'age_months', 3),
            ],
            'child' => $measurements->map(fn($m) => ['x' => (int)$m->age_months, 'y' => (float)$m->weight])->values(),
        ];

        $wfh = [
            'sd' => [
                '-3' => $this->toPoints($wfhStd, 'length_height_cm', -3),
                '-2' => $this->toPoints($wfhStd, 'length_height_cm', -2),
                '0'  => $this->toPoints($wfhStd, 'length_height_cm', 0),
                '2'  => $this->toPoints($wfhStd, 'length_height_cm', 2),
                '3'  => $this->toPoints($wfhStd, 'length_height_cm', 3),
            ],
            'child' => $measurements->map(fn($m) => ['x' => (float)$m->height, 'y' => (float)$m->weight])->values(),
        ];

        return view('growth-charts.show', compact('child', 'hfa', 'wfa', 'wfh'));
    }

    private function computeY(float $L, float $M, float $S, float $z): float
    {
        if (abs($L) > 0.000001) {
            return (float) ($M * pow(1 + $L * $S * $z, 1 / $L));
        }
        // L == 0
        return (float) ($M * exp($S * $z));
    }

    /**
     * @param \Illuminate\Support\Collection<int, \App\Models\GrowthStandard> $standards
     * @param string $xField 'age_months' or 'length_height_cm'
     * @param float $z
     * @return array<int, array{x: float|int, y: float}>
     */
    private function toPoints(Collection $standards, string $xField, float $z): array
    {
        return $standards->map(function (GrowthStandard $row) use ($xField, $z) {
            $y = $this->computeY((float)$row->l, (float)$row->m, (float)$row->s, $z);
            $x = $xField === 'age_months' ? (int)$row->age_months : (float)$row->length_height_cm;
            return ['x' => $x, 'y' => round($y, 2)];
        })->values()->all();
    }
}
