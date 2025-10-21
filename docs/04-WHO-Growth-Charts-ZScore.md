# WHO GROWTH CHARTS & Z-SCORE CALCULATION

## Implementasi Standar WHO untuk Deteksi Stunting

**Versi**: 1.0  
**Reference**: WHO Child Growth Standards 2006  
**Indicators**: Weight-for-Age, Height-for-Age, Weight-for-Height

---

## 1. WHO GROWTH STANDARDS OVERVIEW

### 1.1 Background

WHO Child Growth Standards (2006) adalah standar internasional untuk menilai pertumbuhan dan perkembangan anak usia 0-60 bulan (0-5 tahun). Standar ini didasarkan pada studi multi-negara yang melibatkan anak-anak yang diberi ASI eksklusif dan hidup dalam kondisi optimal.

**Key Points**:

- ✅ Berlaku untuk semua anak di seluruh dunia (universal)
- ✅ Terpisah untuk laki-laki dan perempuan (sexual dimorphism)
- ✅ Menggunakan kurva Z-score (standard deviation)
- ✅ Mencakup 3 indikator utama: BB/U, TB/U, BB/TB

### 1.2 Indicators

#### **1. Weight-for-Age (BB/U)**

Mengukur berat badan anak relatif terhadap usianya.

**Interpretasi**:

- `Z > +2 SD`: Overweight
- `0 ≤ Z ≤ +2 SD`: Normal
- `-2 SD ≤ Z < 0`: At risk
- `Z < -2 SD`: **Underweight**
- `Z < -3 SD`: **Severely Underweight**

**Use Case**: Deteksi kekurangan gizi secara umum (composite indicator).

---

#### **2. Height-for-Age (TB/U)**

Mengukur tinggi badan anak relatif terhadap usianya.

**Interpretasi**:

- `Z > +2 SD`: Tall (jarang)
- `0 ≤ Z ≤ +2 SD`: Normal
- `-2 SD ≤ Z < 0`: At risk
- `Z < -2 SD`: **Stunting** ⚠️ TARGET UTAMA
- `Z < -3 SD`: **Severe Stunting** 🚨 CRITICAL

**Use Case**: Deteksi stunting (pertumbuhan linear terhambat, indikator kekurangan gizi kronis).

---

#### **3. Weight-for-Height (BB/TB)**

Mengukur berat badan anak relatif terhadap tinggi badannya (body proportionality).

**Interpretasi**:

- `Z > +3 SD`: Obesity
- `Z > +2 SD`: Overweight
- `0 ≤ Z ≤ +2 SD`: Normal
- `-2 SD ≤ Z < 0`: At risk
- `Z < -2 SD`: **Wasting** (kurus/akut)
- `Z < -3 SD`: **Severe Wasting** (sangat kurus)

**Use Case**: Deteksi wasting (kekurangan gizi akut).

---

## 2. Z-SCORE CALCULATION

### 2.1 Formula (LMS Method)

WHO menggunakan **LMS method** (Lambda-Mu-Sigma) untuk menghitung Z-score:

```
Z = [(Y / M)^L - 1] / (L * S)
```

Dimana:

- `Y` = Nilai measurement (berat/tinggi) yang diukur
- `M` = Median (SD 0) dari tabel WHO untuk umur/gender tertentu
- `L` = Box-Cox transformation (untuk normalize distribusi)
- `S` = Coefficient of variation (standar deviasi)

**Simplified Formula** (jika L ≈ 0, seperti untuk Height-for-Age):

```
Z ≈ (Y - M) / S
```

### 2.2 Interpolation (Age Between Months)

Karena data WHO hanya tersedia per bulan integer (0, 1, 2, ..., 60), kita perlu interpolasi untuk umur dengan hari (e.g., 12.5 bulan).

**Linear Interpolation Formula**:

```
Value(age) = Value(age_floor) + (age - age_floor) * [Value(age_ceil) - Value(age_floor)]
```

**Example**:
Anak perempuan, umur 12.5 bulan, tinggi 75 cm.

1. Ambil data WHO untuk 12 bulan dan 13 bulan:

   - M(12) = 74.0 cm, S(12) = 2.5
   - M(13) = 75.2 cm, S(13) = 2.6

2. Interpolasi untuk 12.5 bulan:

   - M(12.5) = 74.0 + 0.5 \* (75.2 - 74.0) = 74.6 cm
   - S(12.5) = 2.5 + 0.5 \* (2.6 - 2.5) = 2.55

3. Hitung Z-score:
   - Z = (75 - 74.6) / 2.55 = 0.16 SD (Normal)

### 2.3 Weight-for-Height Special Case

Untuk BB/TB, `x-axis` bukan umur tetapi tinggi badan. WHO menyediakan tabel dengan increment 0.1 cm (e.g., 45.0, 45.1, 45.2, ..., 120.0 cm).

**Lookup Logic**:

1. Round tinggi anak ke 0.1 cm terdekat (e.g., 75.23 → 75.2)
2. Cari di tabel WHO untuk gender + tinggi tersebut
3. Hitung Z-score dengan formula LMS

---

## 3. IMPLEMENTATION IN LARAVEL

### 3.1 Service: ZScoreService

**File**: `app/Services/ZScoreService.php`

```php
<?php

namespace App\Services;

use App\Models\GrowthStandard;
use Carbon\Carbon;

class ZScoreService
{
    /**
     * Calculate Z-scores untuk satu measurement
     *
     * @param int $childId
     * @param float $weight (kg)
     * @param float $height (cm)
     * @param string $dateOfBirth
     * @param string $measuredAt
     * @param string $gender ('male' atau 'female')
     * @return array ['weight_for_age_z', 'height_for_age_z', 'weight_for_height_z']
     */
    public function calculateZScores(
        float $weight,
        float $height,
        string $dateOfBirth,
        string $measuredAt,
        string $gender
    ): array {
        // Hitung umur dalam bulan (dengan desimal)
        $ageInMonths = $this->calculateAgeInMonths($dateOfBirth, $measuredAt);

        // Calculate each Z-score
        $weightForAgeZ = $this->calculateWeightForAge($weight, $ageInMonths, $gender);
        $heightForAgeZ = $this->calculateHeightForAge($height, $ageInMonths, $gender);
        $weightForHeightZ = $this->calculateWeightForHeight($weight, $height, $gender);

        return [
            'age_months' => (int) floor($ageInMonths),
            'weight_for_age_z' => round($weightForAgeZ, 2),
            'height_for_age_z' => round($heightForAgeZ, 2),
            'weight_for_height_z' => round($weightForHeightZ, 2),
        ];
    }

    /**
     * Hitung umur dalam bulan (desimal)
     */
    protected function calculateAgeInMonths(string $dateOfBirth, string $measuredAt): float
    {
        $dob = Carbon::parse($dateOfBirth);
        $measured = Carbon::parse($measuredAt);

        // Total days difference
        $totalDays = $dob->diffInDays($measured);

        // Convert to months (approximate: 1 month = 30.4375 days)
        return $totalDays / 30.4375;
    }

    /**
     * Calculate Weight-for-Age Z-score
     */
    protected function calculateWeightForAge(float $weight, float $ageInMonths, string $gender): float
    {
        // Get WHO standards via interpolation
        $standards = $this->getInterpolatedStandards($ageInMonths, $gender, 'weight_for_age');

        // LMS formula
        $L = $standards['L'];
        $M = $standards['M'];
        $S = $standards['S'];

        if ($L != 0) {
            $z = (pow($weight / $M, $L) - 1) / ($L * $S);
        } else {
            // Simplified formula jika L ≈ 0
            $z = ($weight - $M) / ($M * $S);
        }

        return $z;
    }

    /**
     * Calculate Height-for-Age Z-score
     */
    protected function calculateHeightForAge(float $height, float $ageInMonths, string $gender): float
    {
        $standards = $this->getInterpolatedStandards($ageInMonths, $gender, 'height_for_age');

        $L = $standards['L'];
        $M = $standards['M'];
        $S = $standards['S'];

        // Untuk Height-for-Age, L biasanya sangat kecil, pakai simplified
        $z = ($height - $M) / ($M * $S);

        return $z;
    }

    /**
     * Calculate Weight-for-Height Z-score
     */
    protected function calculateWeightForHeight(float $weight, float $height, string $gender): float
    {
        // Round height ke 0.1 cm terdekat
        $heightRounded = round($height, 1);

        // Get WHO standards berdasarkan height (bukan age)
        $standard = GrowthStandard::where('gender', $gender)
            ->where('indicator', 'weight_for_height')
            ->where('height', $heightRounded) // Custom column untuk BB/TB
            ->first();

        if (!$standard) {
            // Fallback: interpolasi antara 2 height terdekat
            return $this->interpolateWeightForHeight($weight, $height, $gender);
        }

        $L = $standard->L;
        $M = $standard->M;
        $S = $standard->S;

        if ($L != 0) {
            $z = (pow($weight / $M, $L) - 1) / ($L * $S);
        } else {
            $z = ($weight - $M) / ($M * $S);
        }

        return $z;
    }

    /**
     * Interpolasi linear untuk mendapatkan LMS values di antara 2 age months
     */
    protected function getInterpolatedStandards(float $ageInMonths, string $gender, string $indicator): array
    {
        $ageFloor = floor($ageInMonths);
        $ageCeil = ceil($ageInMonths);

        // Jika integer months, tidak perlu interpolasi
        if ($ageFloor == $ageCeil) {
            $standard = GrowthStandard::where('gender', $gender)
                ->where('indicator', $indicator)
                ->where('age_months', $ageFloor)
                ->first();

            return [
                'L' => $standard->L,
                'M' => $standard->M,
                'S' => $standard->S,
            ];
        }

        // Get data untuk floor dan ceil age
        $standardFloor = GrowthStandard::where('gender', $gender)
            ->where('indicator', $indicator)
            ->where('age_months', $ageFloor)
            ->first();

        $standardCeil = GrowthStandard::where('gender', $gender)
            ->where('indicator', $indicator)
            ->where('age_months', $ageCeil)
            ->first();

        // Linear interpolation
        $fraction = $ageInMonths - $ageFloor;

        $L = $standardFloor->L + $fraction * ($standardCeil->L - $standardFloor->L);
        $M = $standardFloor->M + $fraction * ($standardCeil->M - $standardFloor->M);
        $S = $standardFloor->S + $fraction * ($standardCeil->S - $standardFloor->S);

        return ['L' => $L, 'M' => $M, 'S' => $S];
    }

    /**
     * Interpolasi untuk Weight-for-Height (based on height, not age)
     */
    protected function interpolateWeightForHeight(float $weight, float $height, string $gender): float
    {
        $heightFloor = floor($height * 10) / 10; // Round down to 0.1
        $heightCeil = ceil($height * 10) / 10;   // Round up to 0.1

        $standardFloor = GrowthStandard::where('gender', $gender)
            ->where('indicator', 'weight_for_height')
            ->where('height', $heightFloor)
            ->first();

        $standardCeil = GrowthStandard::where('gender', $gender)
            ->where('indicator', 'weight_for_height')
            ->where('height', $heightCeil)
            ->first();

        if (!$standardFloor || !$standardCeil) {
            // Out of range (height terlalu rendah/tinggi)
            throw new \Exception("Height {$height} cm out of WHO range for gender {$gender}");
        }

        // Interpolate L, M, S
        $fraction = ($height - $heightFloor) / ($heightCeil - $heightFloor);

        $L = $standardFloor->L + $fraction * ($standardCeil->L - $standardFloor->L);
        $M = $standardFloor->M + $fraction * ($standardCeil->M - $standardFloor->M);
        $S = $standardFloor->S + $fraction * ($standardCeil->S - $standardFloor->S);

        // Calculate Z-score
        if ($L != 0) {
            $z = (pow($weight / $M, $L) - 1) / ($L * $S);
        } else {
            $z = ($weight - $M) / ($M * $S);
        }

        return $z;
    }
}
```

### 3.2 Service: NutritionStatusService

**File**: `app/Services/NutritionStatusService.php`

```php
<?php

namespace App\Services;

class NutritionStatusService
{
    /**
     * Determine nutrition status dari Z-scores
     *
     * @param array $zScores ['weight_for_age_z', 'height_for_age_z', 'weight_for_height_z']
     * @return string Status gizi
     */
    public function determineStatus(array $zScores): string
    {
        $wfaZ = $zScores['weight_for_age_z'];
        $hfaZ = $zScores['height_for_age_z'];
        $wfhZ = $zScores['weight_for_height_z'];

        $statuses = [];

        // Check stunting (Height-for-Age)
        if ($hfaZ < -3) {
            $statuses[] = 'severely_stunted';
        } elseif ($hfaZ < -2) {
            $statuses[] = 'stunting';
        }

        // Check wasting (Weight-for-Height)
        if ($wfhZ < -3) {
            $statuses[] = 'severely_wasted';
        } elseif ($wfhZ < -2) {
            $statuses[] = 'wasting';
        }

        // Check underweight (Weight-for-Age)
        if ($wfaZ < -3) {
            $statuses[] = 'severely_underweight';
        } elseif ($wfaZ < -2) {
            $statuses[] = 'underweight';
        }

        // Check overweight/obesity (Weight-for-Height)
        if ($wfhZ > 3) {
            $statuses[] = 'obesity';
        } elseif ($wfhZ > 2) {
            $statuses[] = 'overweight';
        }

        // Priority order: Severe conditions first
        if (in_array('severely_stunted', $statuses)) {
            return 'severely_stunted';
        }
        if (in_array('severely_wasted', $statuses)) {
            return 'severely_wasted';
        }
        if (in_array('severely_underweight', $statuses)) {
            return 'severely_underweight';
        }
        if (in_array('stunting', $statuses)) {
            return 'stunting';
        }
        if (in_array('wasting', $statuses)) {
            return 'wasting';
        }
        if (in_array('underweight', $statuses)) {
            return 'underweight';
        }
        if (in_array('obesity', $statuses)) {
            return 'obesity';
        }
        if (in_array('overweight', $statuses)) {
            return 'overweight';
        }

        return 'normal';
    }

    /**
     * Get human-readable status label (Bahasa Indonesia)
     */
    public function getStatusLabel(string $status): string
    {
        $labels = [
            'normal' => 'Normal',
            'stunting' => 'Stunting',
            'severely_stunted' => 'Stunting Berat',
            'wasting' => 'Gizi Kurang (Wasting)',
            'severely_wasted' => 'Gizi Buruk (Severe Wasting)',
            'underweight' => 'Berat Badan Kurang',
            'severely_underweight' => 'Berat Badan Sangat Kurang',
            'overweight' => 'Berat Badan Lebih',
            'obesity' => 'Obesitas',
        ];

        return $labels[$status] ?? 'Unknown';
    }

    /**
     * Get badge color untuk UI (Tailwind CSS classes)
     */
    public function getBadgeColor(string $status): string
    {
        $colors = [
            'normal' => 'bg-green-100 text-green-800',
            'stunting' => 'bg-yellow-100 text-yellow-800',
            'severely_stunted' => 'bg-red-100 text-red-800',
            'wasting' => 'bg-yellow-100 text-yellow-800',
            'severely_wasted' => 'bg-red-100 text-red-800',
            'underweight' => 'bg-yellow-100 text-yellow-800',
            'severely_underweight' => 'bg-red-100 text-red-800',
            'overweight' => 'bg-orange-100 text-orange-800',
            'obesity' => 'bg-red-100 text-red-800',
        ];

        return $colors[$status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Check if status is critical (perlu tindakan segera)
     */
    public function isCritical(string $status): bool
    {
        return in_array($status, [
            'severely_stunted',
            'severely_wasted',
            'severely_underweight',
        ]);
    }
}
```

### 3.3 Usage in Controller

**File**: `app/Http/Controllers/MeasurementController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use App\Models\Child;
use App\Services\ZScoreService;
use App\Services\NutritionStatusService;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    public function __construct(
        protected ZScoreService $zScoreService,
        protected NutritionStatusService $nutritionStatusService,
        protected NotificationService $notificationService
    ) {}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'child_id' => 'required|exists:children,id',
            'measured_at' => 'required|date|before_or_equal:today',
            'weight' => 'required|numeric|min:1|max:200',
            'height' => 'required|numeric|min:30|max:250',
            'head_circumference' => 'nullable|numeric|min:20|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Get child data
        $child = Child::findOrFail($validated['child_id']);

        // Calculate Z-scores
        $zScores = $this->zScoreService->calculateZScores(
            weight: $validated['weight'],
            height: $validated['height'],
            dateOfBirth: $child->date_of_birth,
            measuredAt: $validated['measured_at'],
            gender: $child->gender
        );

        // Determine nutrition status
        $nutritionStatus = $this->nutritionStatusService->determineStatus($zScores);

        // Create measurement record
        $measurement = Measurement::create([
            'child_id' => $child->id,
            'measured_at' => $validated['measured_at'],
            'weight' => $validated['weight'],
            'height' => $validated['height'],
            'head_circumference' => $validated['head_circumference'],
            'age_months' => $zScores['age_months'],
            'weight_for_age_z' => $zScores['weight_for_age_z'],
            'height_for_age_z' => $zScores['height_for_age_z'],
            'weight_for_height_z' => $zScores['weight_for_height_z'],
            'nutrition_status' => $nutritionStatus,
            'notes' => $validated['notes'],
            'created_by' => auth()->id(),
        ]);

        // Send notification if critical status detected
        if ($this->nutritionStatusService->isCritical($nutritionStatus)) {
            $this->notificationService->sendStuntingAlert($child, $measurement);
        }

        return redirect()
            ->route('children.show', $child->id)
            ->with('success', 'Data pengukuran berhasil disimpan');
    }
}
```

---

## 4. WHO DATA STRUCTURE

### 4.1 Database Table: `growth_standards`

```sql
CREATE TABLE growth_standards (
    id BIGSERIAL PRIMARY KEY,
    gender VARCHAR(10) NOT NULL, -- 'male' atau 'female'
    indicator VARCHAR(20) NOT NULL, -- 'weight_for_age', 'height_for_age', 'weight_for_height'
    age_months INT, -- NULL untuk weight_for_height
    height DECIMAL(5,1), -- NULL untuk weight_for_age & height_for_age
    L DECIMAL(8,5) NOT NULL, -- Box-Cox transformation
    M DECIMAL(8,3) NOT NULL, -- Median
    S DECIMAL(8,5) NOT NULL, -- Coefficient of variation
    sd_neg3 DECIMAL(8,3), -- -3 SD (pre-calculated untuk chart rendering)
    sd_neg2 DECIMAL(8,3), -- -2 SD
    sd_neg1 DECIMAL(8,3), -- -1 SD
    sd_0 DECIMAL(8,3), -- Median (sama dengan M)
    sd_1 DECIMAL(8,3), -- +1 SD
    sd_2 DECIMAL(8,3), -- +2 SD
    sd_3 DECIMAL(8,3), -- +3 SD
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_growth_standards_lookup ON growth_standards(gender, indicator, age_months);
CREATE INDEX idx_growth_standards_height ON growth_standards(gender, indicator, height);
```

### 4.2 Sample Data (Male, Height-for-Age, 12 months)

```json
{
  "gender": "male",
  "indicator": "height_for_age",
  "age_months": 12,
  "L": 1,
  "M": 75.7,
  "S": 0.03297,
  "sd_neg3": 68.6,
  "sd_neg2": 71.0,
  "sd_neg1": 73.4,
  "sd_0": 75.7,
  "sd_1": 78.1,
  "sd_2": 80.5,
  "sd_3": 82.9
}
```

### 4.3 Seeder: GrowthStandardSeeder

**File**: `database/seeders/GrowthStandardSeeder.php`

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GrowthStandard;
use Illuminate\Support\Facades\File;

class GrowthStandardSeeder extends Seeder
{
    public function run()
    {
        // Load WHO data dari JSON file
        $whoDataPath = resource_path('data/who-growth-standards.json');

        if (!File::exists($whoDataPath)) {
            $this->command->error('WHO data file not found!');
            return;
        }

        $whoData = json_decode(File::get($whoDataPath), true);

        $this->command->info('Seeding WHO Growth Standards...');

        foreach ($whoData as $item) {
            GrowthStandard::create($item);
        }

        $this->command->info('✓ WHO Growth Standards seeded successfully');
    }
}
```

---

## 5. GROWTH CHART VISUALIZATION

### 5.1 Chart.js Configuration

**File**: `resources/js/components/growth-chart.js` (Extended)

```javascript
function renderHeightForAgeChart(childMeasurements, whoStandards, gender) {
  const ctx = document.getElementById("height-for-age-chart").getContext("2d");

  // WHO curves data
  const whoCurves = {
    sd_3: { label: "+3 SD", color: "rgba(0, 0, 0, 0.2)", dash: [5, 5] },
    sd_2: { label: "+2 SD", color: "rgba(255, 206, 86, 0.6)", dash: [] },
    sd_0: { label: "Median", color: "rgba(75, 192, 192, 1)", dash: [] },
    sd_neg2: {
      label: "-2 SD (Stunting)",
      color: "rgba(255, 99, 132, 0.8)",
      dash: [],
    },
    sd_neg3: {
      label: "-3 SD (Severe)",
      color: "rgba(255, 0, 0, 1)",
      dash: [5, 5],
    },
  };

  const datasets = [];

  // Add WHO curves
  Object.entries(whoCurves).forEach(([key, config]) => {
    datasets.push({
      label: config.label,
      data: whoStandards
        .filter((s) => s.gender === gender && s.indicator === "height_for_age")
        .map((s) => ({ x: s.age_months, y: s[key] })),
      borderColor: config.color,
      backgroundColor: "transparent",
      borderWidth: key === "sd_0" ? 3 : 2,
      borderDash: config.dash,
      pointRadius: 0,
      fill: false,
    });
  });

  // Add child's measurements
  datasets.push({
    label: "Pengukuran Anak",
    data: childMeasurements.map((m) => ({
      x: m.age_months,
      y: m.height,
    })),
    borderColor: "rgba(54, 162, 235, 1)",
    backgroundColor: "rgba(54, 162, 235, 0.5)",
    borderWidth: 3,
    pointRadius: 8,
    pointHoverRadius: 10,
    fill: false,
    showLine: true,
  });

  const chart = new Chart(ctx, {
    type: "line",
    data: { datasets },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          type: "linear",
          title: {
            display: true,
            text: "Umur (bulan)",
            font: { size: 14, weight: "bold" },
          },
          min: 0,
          max: 60,
          ticks: { stepSize: 6 },
        },
        y: {
          title: {
            display: true,
            text: "Tinggi Badan (cm)",
            font: { size: 14, weight: "bold" },
          },
          min: 45,
          max: 120,
        },
      },
      plugins: {
        legend: {
          display: true,
          position: "bottom",
          labels: { font: { size: 12 } },
        },
        tooltip: {
          callbacks: {
            label: function (context) {
              const label = context.dataset.label || "";
              const value = context.parsed.y.toFixed(1);
              return `${label}: ${value} cm`;
            },
          },
        },
        annotation: {
          annotations: {
            stuntingZone: {
              type: "box",
              yMin: 0,
              yMax: whoStandards.find((s) => s.age_months === 60).sd_neg2,
              backgroundColor: "rgba(255, 99, 132, 0.1)",
              borderWidth: 0,
            },
          },
        },
      },
      interaction: {
        mode: "nearest",
        axis: "x",
        intersect: false,
      },
    },
  });

  return chart;
}
```

### 5.2 Blade View for Chart

**File**: `resources/views/growth-charts/show.blade.php`

```blade
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Grafik Pertumbuhan</h1>
            <p class="text-gray-600">
                <span class="font-semibold">{{ $child->name }}</span>
                <span class="ml-2 text-sm">
                    ({{ $child->gender === 'male' ? 'Laki-laki' : 'Perempuan' }},
                    {{ $child->age_months }} bulan)
                </span>
            </p>
        </div>

        <!-- Tabs -->
        <div x-data="{ activeTab: 'height-for-age' }" class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-4">
                    <button
                        @click="activeTab = 'height-for-age'"
                        :class="activeTab === 'height-for-age' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="py-4 px-6 border-b-2 font-medium text-sm">
                        Tinggi Badan / Umur
                    </button>
                    <button
                        @click="activeTab = 'weight-for-age'"
                        :class="activeTab === 'weight-for-age' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="py-4 px-6 border-b-2 font-medium text-sm">
                        Berat Badan / Umur
                    </button>
                    <button
                        @click="activeTab = 'weight-for-height'"
                        :class="activeTab === 'weight-for-height' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="py-4 px-6 border-b-2 font-medium text-sm">
                        Berat Badan / Tinggi Badan
                    </button>
                </nav>
            </div>

            <!-- Chart Containers -->
            <div class="mt-6">
                <!-- Height-for-Age Chart -->
                <div x-show="activeTab === 'height-for-age'" class="chart-container" style="height: 500px;">
                    <canvas id="height-for-age-chart"></canvas>
                </div>

                <!-- Weight-for-Age Chart -->
                <div x-show="activeTab === 'weight-for-age'" class="chart-container" style="height: 500px;">
                    <canvas id="weight-for-age-chart"></canvas>
                </div>

                <!-- Weight-for-Height Chart -->
                <div x-show="activeTab === 'weight-for-height'" class="chart-container" style="height: 500px;">
                    <canvas id="weight-for-height-chart"></canvas>
                </div>
            </div>
        </div>

        <!-- Legend Explanation -->
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mt-6">
            <h3 class="font-semibold text-blue-800 mb-2">Penjelasan Grafik:</h3>
            <ul class="text-sm text-blue-700 space-y-1">
                <li>🟢 <strong>Di atas -2 SD</strong>: Pertumbuhan normal</li>
                <li>🟡 <strong>-2 SD s/d -3 SD</strong>: Berisiko stunting/gizi kurang</li>
                <li>🔴 <strong>Di bawah -3 SD</strong>: Stunting berat / gizi buruk</li>
            </ul>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const childMeasurements = @json($measurements);
    const whoStandards = @json($whoStandards);
    const gender = @json($child->gender);

    // Render charts
    document.addEventListener('DOMContentLoaded', function() {
        renderHeightForAgeChart(childMeasurements, whoStandards, gender);
        renderWeightForAgeChart(childMeasurements, whoStandards, gender);
        renderWeightForHeightChart(childMeasurements, whoStandards, gender);
    });
</script>
@endpush
@endsection
```

---

## 6. DATA VALIDATION

### 6.1 Input Ranges (Realistic)

```php
// app/Http/Requests/StoreMeasurementRequest.php

public function rules()
{
    return [
        'weight' => [
            'required',
            'numeric',
            'min:1',    // Minimum: 1 kg (prematur extreme)
            'max:200',  // Maximum: 200 kg (obesity extreme)
        ],
        'height' => [
            'required',
            'numeric',
            'min:30',   // Minimum: 30 cm (prematur extreme)
            'max:250',  // Maximum: 250 cm (abnormal tall)
        ],
        'head_circumference' => [
            'nullable',
            'numeric',
            'min:20',   // Minimum: 20 cm (microcephaly)
            'max:100',  // Maximum: 100 cm (hydrocephalus extreme)
        ],
    ];
}

public function withValidator($validator)
{
    $validator->after(function ($validator) {
        // Custom validation: Check outliers
        $weight = $this->input('weight');
        $height = $this->input('height');

        // BMI check (untuk detect input error)
        $bmi = $weight / (($height / 100) ** 2);

        if ($bmi < 5 || $bmi > 50) {
            $validator->errors()->add(
                'weight',
                'Kombinasi berat dan tinggi badan tidak realistis. Mohon cek kembali input Anda.'
            );
        }
    });
}
```

### 6.2 Outlier Detection

```php
// In ZScoreService, add validation method

public function validateZScore(float $zScore, string $indicator): bool
{
    // WHO recommends flagging data if |Z-score| > 5 as potential outliers
    if (abs($zScore) > 5) {
        Log::warning('Potential outlier detected', [
            'indicator' => $indicator,
            'z_score' => $zScore
        ]);
        return false;
    }
    return true;
}
```

---

## 7. TESTING

### 7.1 Unit Test: Z-Score Calculation

**File**: `tests/Unit/ZScoreServiceTest.php`

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ZScoreService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ZScoreServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ZScoreService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ZScoreService();

        // Seed WHO standards
        $this->seed(\Database\Seeders\GrowthStandardSeeder::class);
    }

    /** @test */
    public function it_calculates_normal_height_for_age_z_score()
    {
        // Male, 12 months, height 75.7 cm (median)
        $result = $this->service->calculateZScores(
            weight: 9.6,
            height: 75.7,
            dateOfBirth: now()->subMonths(12)->toDateString(),
            measuredAt: now()->toDateString(),
            gender: 'male'
        );

        $this->assertEqualsWithDelta(0.0, $result['height_for_age_z'], 0.1);
    }

    /** @test */
    public function it_detects_stunting()
    {
        // Male, 24 months, height 81 cm (< -2 SD, stunting)
        $result = $this->service->calculateZScores(
            weight: 10.5,
            height: 81.0,
            dateOfBirth: now()->subMonths(24)->toDateString(),
            measuredAt: now()->toDateString(),
            gender: 'male'
        );

        $this->assertLessThan(-2.0, $result['height_for_age_z']);
    }

    /** @test */
    public function it_handles_interpolation_correctly()
    {
        // Test with 12.5 months (between integer months)
        $result = $this->service->calculateZScores(
            weight: 9.8,
            height: 76.0,
            dateOfBirth: now()->subMonths(12)->subDays(15)->toDateString(),
            measuredAt: now()->toDateString(),
            gender: 'male'
        );

        $this->assertIsFloat($result['height_for_age_z']);
        $this->assertNotNull($result['weight_for_age_z']);
    }
}
```

---

## 8. PERFORMANCE OPTIMIZATION

### 8.1 Cache WHO Standards

```php
// In ZScoreService, add caching

protected function getWHOStandards(string $gender, string $indicator): Collection
{
    $cacheKey = "who_standards_{$gender}_{$indicator}";

    return Cache::rememberForever($cacheKey, function() use ($gender, $indicator) {
        return GrowthStandard::where('gender', $gender)
            ->where('indicator', $indicator)
            ->orderBy('age_months')
            ->get();
    });
}
```

### 8.2 Eager Loading

```php
// In MeasurementController

public function history(Child $child)
{
    $measurements = $child->measurements()
        ->with('creator:id,name')
        ->orderBy('measured_at', 'desc')
        ->get();

    return view('measurements.history', compact('child', 'measurements'));
}
```

---

## 9. RESOURCES

### 9.1 WHO Official Data Sources

- **WHO Website**: https://www.who.int/tools/child-growth-standards
- **Data Tables**: https://cdn.who.int/media/docs/default-source/child-growth/child-growth-standards/indicators/
- **Charts**: https://cdn.who.int/media/docs/default-source/child-growth/child-growth-standards/charts/

### 9.2 Implementation References

- **LMS Method Paper**: Cole TJ, Green PJ. "Smoothing reference centile curves: the LMS method and penalized likelihood." Statistics in Medicine 1992; 11:1305-1319.
- **WHO R igrowup Package**: https://www.who.int/tools/child-growth-standards/software

---

**END OF WHO GROWTH CHARTS & Z-SCORE DOCUMENT**
