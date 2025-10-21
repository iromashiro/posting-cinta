<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Child;
use App\Models\Mother;
use App\Models\Measurement;
use App\Models\Posyandu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Stats dasar
        $stats = [
            'total_anak' => Child::count(),
            'total_ibu' => Mother::count(),
            'total_posyandu' => Posyandu::count(),
            'total_pengukuran' => Measurement::count(),
        ];

        // Stats gizi berdasarkan pengukuran terakhir
        // Stats gizi per kategori UI (berdasarkan pengukuran terakhir per anak, by measured_at)
        $latest = Measurement::select('child_id', DB::raw('MAX(measured_at) as max_date'))
            ->groupBy('child_id');

        $giziRaw = Measurement::joinSub($latest, 'latest', function ($join) {
            $join->on('measurements.child_id', '=', 'latest.child_id')
                ->on('measurements.measured_at', '=', 'latest.max_date');
        })
            ->select('measurements.nutrition_status', DB::raw('COUNT(*) as total'))
            ->groupBy('measurements.nutrition_status')
            ->pluck('total', 'measurements.nutrition_status')
            ->toArray();

        // Map ke kategori UI (status di DB: normal|stunting|severe [+ opsi lain jika ada])
        $giziStats = [
            'gizi_buruk' => ($giziRaw['severe'] ?? 0) + ($giziRaw['severely_underweight'] ?? 0) + ($giziRaw['severely_wasted'] ?? 0) + ($giziRaw['severely_stunted'] ?? 0),
            'gizi_kurang' => ($giziRaw['stunting'] ?? 0) + ($giziRaw['underweight'] ?? 0) + ($giziRaw['wasting'] ?? 0),
            'gizi_baik' => $giziRaw['normal'] ?? 0,
            'berisiko_gizi_lebih' => $giziRaw['overweight'] ?? 0,
            'gizi_lebih' => $giziRaw['obesity'] ?? 0,
        ];
        // Fallback: jika hasil 0 semua (mis. join by measured_at tidak match), gunakan pendekatan MAX(id)
        if (array_sum($giziStats) === 0) {
            $giziRaw = Measurement::select('nutrition_status', DB::raw('count(*) as total'))
                ->whereIn('id', function ($query) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('measurements')
                        ->groupBy('child_id');
                })
                ->groupBy('nutrition_status')
                ->pluck('total', 'nutrition_status')
                ->toArray();

            $giziStats = [
                'gizi_buruk' => ($giziRaw['severe'] ?? 0) + ($giziRaw['severely_underweight'] ?? 0) + ($giziRaw['severely_wasted'] ?? 0) + ($giziRaw['severely_stunted'] ?? 0),
                'gizi_kurang' => ($giziRaw['stunting'] ?? 0) + ($giziRaw['underweight'] ?? 0) + ($giziRaw['wasting'] ?? 0),
                'gizi_baik' => $giziRaw['normal'] ?? 0,
                'berisiko_gizi_lebih' => $giziRaw['overweight'] ?? 0,
                'gizi_lebih' => $giziRaw['obesity'] ?? 0,
            ];
        }

        // Pengukuran terbaru (urut berdasarkan tanggal ukur)
        $recentMeasurements = Measurement::with(['child', 'child.mother'])
            ->orderByDesc('measured_at')
            ->take(5)
            ->get();

        // Konfigurasi tampilan status gizi (untuk blade)
        $statusConfig = [
            'gizi_buruk' => ['label' => 'Gizi Buruk', 'color' => 'red', 'icon' => '⚠️'],
            'gizi_kurang' => ['label' => 'Gizi Kurang', 'color' => 'orange', 'icon' => '⚡'],
            'gizi_baik' => ['label' => 'Gizi Baik', 'color' => 'green', 'icon' => '✓'],
            'berisiko_gizi_lebih' => ['label' => 'Risiko Lebih', 'color' => 'yellow', 'icon' => '⚡'],
            'gizi_lebih' => ['label' => 'Gizi Lebih', 'color' => 'amber', 'icon' => '⚠️'],
        ];

        return view('dashboard', compact(
            'user',
            'stats',
            'giziStats',
            'recentMeasurements',
            'statusConfig'
        ));
    }
}
