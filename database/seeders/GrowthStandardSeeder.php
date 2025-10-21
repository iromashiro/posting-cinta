<?php

namespace Database\Seeders;

use App\Models\GrowthStandard;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class GrowthStandardSeeder extends Seeder
{
    /**
     * Seeder "lengkap" untuk kurva WHO.
     *
     * Skenario:
     * - Jika file resources/data/who-growth-standards.json tersedia, import apa adanya (LMS resmi).
     * - Jika TIDAK ada, generate dataset sintetik komplit (0-60 bln untuk WFA & HFA, WFH 65-110 cm)
     *   berbasis anchor points (cukup untuk uji visual grafik). Disarankan ganti ke dataset resmi untuk produksi.
     */
    public function run(): void
    {
        $jsonPath = resource_path('data/who-growth-standards.json');

        if (File::exists($jsonPath)) {
            $this->command?->info('WHO JSON ditemukan. Import data resmi...');
            $rows = json_decode(File::get($jsonPath), true) ?: [];

            $count = 0;
            foreach ($rows as $r) {
                // Normalisasi key agar kompatibel (menerima "L/M/S" atau "l/m/s")
                $l = $r['l'] ?? $r['L'] ?? null;
                $m = $r['m'] ?? $r['M'] ?? null;
                $s = $r['s'] ?? $r['S'] ?? null;

                GrowthStandard::updateOrCreate(
                    [
                        'gender' => $r['gender'],
                        'indicator' => $r['indicator'],
                        'age_months' => $r['age_months'] ?? null,
                        'length_height_cm' => $r['length_height_cm'] ?? ($r['height'] ?? null),
                    ],
                    [
                        'l' => $l,
                        'm' => $m,
                        's' => $s,
                    ]
                );
                $count++;
            }

            $this->command?->info("✓ Imported {$count} WHO rows dari JSON");
            return;
        }

        // Fallback: generate dataset sintetik komplit (untuk DEV & demo grafik)
        $this->command?->warn('WHO JSON tidak ditemukan. Generate dataset sintetik lengkap untuk uji grafik...');

        $rows = array_merge(
            $this->generateHfa('male'),
            $this->generateHfa('female'),
            $this->generateWfa('male'),
            $this->generateWfa('female'),
            $this->generateWfh('male'),
            $this->generateWfh('female'),
        );

        $count = 0;
        foreach ($rows as $r) {
            GrowthStandard::updateOrCreate(
                [
                    'gender' => $r['gender'],
                    'indicator' => $r['indicator'],
                    'age_months' => $r['age_months'],
                    'length_height_cm' => $r['length_height_cm'],
                ],
                [
                    'l' => $r['l'],
                    'm' => $r['m'],
                    's' => $r['s'],
                ]
            );
            $count++;
        }

        $this->command?->info("✓ Seeded {$count} synthetic WHO rows (HFA/WFA 0-60 bln, WFH 65-110 cm)");
        $this->command?->line('Note: Untuk akurasi produksi, taruh file resmi di resources/data/who-growth-standards.json lalu jalankan ulang seeder.');
    }

    // --------------------------
    // Generators (Synthetic DEV)
    // --------------------------

    private function generateHfa(string $gender): array
    {
        // HFA = Height/Length-for-Age (TB/U)
        // Anchor "M" (median, cm) per bulan (0,12,24,36,48,60). Angka mendekati referensi WHO (aproksimasi visual).
        if ($gender === 'male') {
            $mAnchors = [
                0 => 49.8842,
                12 => 75.7000,
                24 => 87.8000,
                36 => 96.1000,
                48 => 102.3000,
                60 => 108.5000,
            ];
            $sAnchors = [
                0 => 0.03795,
                12 => 0.03297,
                24 => 0.03100,
                36 => 0.03000,
                48 => 0.02900,
                60 => 0.02800,
            ];
            $L = 1.0;
        } else {
            $mAnchors = [
                0 => 49.1477,
                12 => 74.0000,
                24 => 85.7000,
                36 => 94.9000,
                48 => 101.4000,
                60 => 107.3000,
            ];
            $sAnchors = [
                0 => 0.03790,
                12 => 0.03273,
                24 => 0.03100,
                36 => 0.03000,
                48 => 0.02900,
                60 => 0.02800,
            ];
            $L = 1.0;
        }

        $rows = [];
        for ($m = 0; $m <= 60; $m++) {
            $rows[] = [
                'gender' => $gender,
                'indicator' => 'hfa',
                'age_months' => $m,
                'length_height_cm' => null,
                'l' => round($L, 5),
                'm' => round($this->interpAnchors($mAnchors, $m), 4),
                's' => round($this->interpAnchors($sAnchors, $m), 5),
            ];
        }
        return $rows;
    }

    private function generateWfa(string $gender): array
    {
        // WFA = Weight-for-Age (BB/U)
        if ($gender === 'male') {
            $mAnchors = [
                0 => 3.3464,
                12 => 9.6000,
                24 => 12.2000,
                36 => 14.3000,
                48 => 16.3000,
                60 => 18.3000,
            ];
            $sAnchors = [
                0 => 0.14602,
                12 => 0.09029,
                24 => 0.08500,
                36 => 0.08200,
                48 => 0.08000,
                60 => 0.07900,
            ];
            $L = -0.3521;
        } else {
            $mAnchors = [
                0 => 3.2322,
                12 => 8.9000,
                24 => 11.5000,
                36 => 13.9000,
                48 => 16.0000,
                60 => 18.2000,
            ];
            $sAnchors = [
                0 => 0.14171,
                12 => 0.08920,
                24 => 0.08450,
                36 => 0.08150,
                48 => 0.07950,
                60 => 0.07850,
            ];
            $L = -0.3833;
        }

        $rows = [];
        for ($m = 0; $m <= 60; $m++) {
            $rows[] = [
                'gender' => $gender,
                'indicator' => 'wfa',
                'age_months' => $m,
                'length_height_cm' => null,
                'l' => round($L, 5),
                'm' => round($this->interpAnchors($mAnchors, $m), 4),
                's' => round($this->interpAnchors($sAnchors, $m), 5),
            ];
        }
        return $rows;
    }

    private function generateWfh(string $gender): array
    {
        // WFH = Weight-for-Height (BB/TB), x-axis = tinggi (cm)
        if ($gender === 'male') {
            // Anchor M (kg) di tinggi tertentu (cm) — aproksimasi visual
            $mAnchors = [
                65.0 => 6.5,
                70.0 => 7.6,
                75.0 => 9.2, // sample
                80.0 => 10.5,
                85.0 => 12.0,
                90.0 => 14.0,
                95.0 => 16.0,
                100.0 => 18.0,
                105.0 => 20.0,
                110.0 => 22.0,
            ];
            // Anchor S (koef. variasi)
            $sAnchors = [
                65.0 => 0.0950,
                75.0 => 0.0903, // sample
                85.0 => 0.0900,
                95.0 => 0.0950,
                105.0 => 0.1000,
                110.0 => 0.1020,
            ];
            $L = -0.3521;
        } else {
            $mAnchors = [
                65.0 => 6.2,
                70.0 => 7.3,
                74.0 => 8.7, // sample
                80.0 => 10.0,
                85.0 => 11.5,
                90.0 => 13.2,
                95.0 => 15.0,
                100.0 => 17.0,
                105.0 => 19.0,
                110.0 => 21.0,
            ];
            $sAnchors = [
                65.0 => 0.0940,
                74.0 => 0.0899, // sample
                85.0 => 0.0895,
                95.0 => 0.0940,
                105.0 => 0.0990,
                110.0 => 0.1010,
            ];
            $L = -0.3833;
        }

        $rows = [];
        for ($h = 65.0; $h <= 110.0; $h += 1.0) {
            $rows[] = [
                'gender' => $gender,
                'indicator' => 'wfh',
                'age_months' => null,
                'length_height_cm' => round($h, 1),
                'l' => round($L, 5),
                'm' => round($this->interpAnchorsFloat($mAnchors, $h), 4),
                's' => round($this->interpAnchorsFloat($sAnchors, $h), 5),
            ];
        }
        return $rows;
    }

    // --------------------------
    // Utilities
    // --------------------------

    /**
     * Linear interpolation untuk anchor berbasis bulan (integer).
     * $anchors: [x => y, ...] dengan x meningkat (mis: 0,12,24,...)
     */
    private function interpAnchors(array $anchors, int $x): float
    {
        if (isset($anchors[$x])) {
            return (float) $anchors[$x];
        }

        $keys = array_keys($anchors);
        sort($keys);
        $prev = $keys[0];
        $next = $keys[array_key_last($keys)];

        foreach ($keys as $k) {
            if ($k <= $x) {
                $prev = $k;
            }
            if ($k >= $x) {
                $next = $k;
                break;
            }
        }

        if ($prev === $next) {
            return (float) $anchors[$prev];
        }

        $y0 = (float) $anchors[$prev];
        $y1 = (float) $anchors[$next];
        $t = ($x - $prev) / ($next - $prev);

        return $y0 + $t * ($y1 - $y0);
    }

    /**
     * Linear interpolation untuk anchor berbasis tinggi (float).
     */
    private function interpAnchorsFloat(array $anchors, float $x): float
    {
        if (isset($anchors[$x])) {
            return (float) $anchors[$x];
        }

        $keys = array_map('floatval', array_keys($anchors));
        sort($keys);

        $prev = $keys[0];
        $next = $keys[count($keys) - 1];

        foreach ($keys as $k) {
            if ($k <= $x) {
                $prev = $k;
            }
            if ($k >= $x) {
                $next = $k;
                break;
            }
        }

        if (abs($next - $prev) < 1e-9) {
            return (float) $anchors[(string)$prev] ?? (float) $anchors[$prev] ?? 0.0;
        }

        $y0 = (float) ($anchors[(string)$prev] ?? $anchors[$prev]);
        $y1 = (float) ($anchors[(string)$next] ?? $anchors[$next]);
        $t = ($x - $prev) / ($next - $prev);

        return $y0 + $t * ($y1 - $y0);
    }
}
