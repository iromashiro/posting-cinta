# UI/UX DESIGN & WIREFRAMES

## Aplikasi Posting Cinta - Mobile-First, Gaptek-Friendly

**Versi**: 1.0  
**Design Principles**: Mobile-First, High Contrast, Big Touch Targets, Simple Navigation  
**Target User**: Kader kesehatan (40-55 tahun, literasi digital rendah)

---

## 1. DESIGN PRINCIPLES

### 1.1 Core Principles

**1. Simple Wins (KISS)**

- Maximum 3 clicks to any feature
- One primary action per screen
- No hidden menus or gestures
- Clear visual hierarchy

**2. Big & Bold**

- Minimum touch target: 48×48px (16mm physical size)
- Body text: 16px minimum, 18px preferred
- Headings: 20px - 28px
- Buttons: Minimum 56px height
- Icons: Minimum 24×24px

**3. High Contrast**

- WCAG AA compliance (4.5:1 ratio minimum)
- Primary colors: Blue (#3B82F6), Green (#10B981), Red (#EF4444)
- Text: Dark gray (#1F2937) on white background
- Avoid pure black (#000) on pure white (#FFF)

**4. Forgiving & Helpful**

- Inline validation (real-time feedback)
- Clear error messages in Bahasa Indonesia
- Undo functionality for destructive actions
- Confirmation dialogs for critical actions
- Auto-save where possible

**5. Visual Feedback**

- Loading states (spinner + text)
- Success messages (green toast)
- Error messages (red toast)
- Progress indicators
- Disabled state clearly visible

### 1.2 Color Palette

```
Primary Colors:
├─ Blue: #3B82F6 (Primary actions, links)
├─ Green: #10B981 (Success, normal status)
├─ Yellow: #F59E0B (Warning, at-risk status)
└─ Red: #EF4444 (Error, critical status)

Neutral Colors:
├─ Gray 900: #111827 (Headings)
├─ Gray 700: #374151 (Body text)
├─ Gray 500: #6B7280 (Secondary text)
├─ Gray 300: #D1D5DB (Borders)
└─ Gray 100: #F3F4F6 (Background)

Background:
├─ White: #FFFFFF (Cards, modals)
└─ Gray 50: #F9FAFB (Page background)
```

### 1.3 Typography

```
Font Family: Inter, system-ui, -apple-system, sans-serif

Headings:
├─ H1: 28px, Bold, #111827
├─ H2: 24px, Bold, #111827
├─ H3: 20px, SemiBold, #374151
└─ H4: 18px, SemiBold, #374151

Body:
├─ Large: 18px, Regular, #374151
├─ Normal: 16px, Regular, #374151
└─ Small: 14px, Regular, #6B7280

Buttons:
├─ Primary: 18px, SemiBold
└─ Secondary: 16px, SemiBold
```

### 1.4 Spacing (Tailwind Scale)

```
├─ xs: 4px (0.25rem)
├─ sm: 8px (0.5rem)
├─ md: 16px (1rem)
├─ lg: 24px (1.5rem)
├─ xl: 32px (2rem)
└─ 2xl: 48px (3rem)
```

---

## 2. COMMON COMPONENTS

### 2.1 Navigation Bar (Bottom)

```
┌─────────────────────────────────────────────────────┐
│                    Page Title                        │ ← 24px, Bold
├─────────────────────────────────────────────────────┤
│                                                      │
│                   Page Content                       │
│                                                      │
│                                                      │
│                                                      │
└─────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────┐
│  [🏠 Beranda]  [👶 Anak]  [📊 Grafik]  [👤 Profil] │ ← Bottom Nav
│     Active       Inactive    Inactive    Inactive   │
│   (Blue #3B82F6) (Gray #6B7280)                     │
└─────────────────────────────────────────────────────┘
```

**Specs**:

- Height: 72px (comfortable thumb zone)
- Icons: 28×28px
- Label: 12px, Medium
- Active state: Blue icon + text
- Inactive state: Gray icon + text
- Ripple effect on tap

### 2.2 Button Styles

#### Primary Button

```
┌────────────────────────────────┐
│  ✓  Simpan Data                │ ← 56px height, Blue bg, White text
└────────────────────────────────┘
```

#### Secondary Button

```
┌────────────────────────────────┐
│     Batal                      │ ← 56px height, White bg, Blue border
└────────────────────────────────┘
```

#### Danger Button

```
┌────────────────────────────────┐
│  🗑️  Hapus Data                │ ← 56px height, Red bg, White text
└────────────────────────────────┘
```

### 2.3 Input Fields

```
┌─────────────────────────────────────────────────────┐
│ Berat Badan (kg) *                                  │ ← Label 16px, Bold
│ ┌─────────────────────────────────────────────────┐ │
│ │  12.5                                           │ │ ← Input 56px height
│ └─────────────────────────────────────────────────┘ │
│ Masukkan berat badan dalam kilogram (kg)            │ ← Helper text 14px
└─────────────────────────────────────────────────────┘
```

**Error State**:

```
┌─────────────────────────────────────────────────────┐
│ Berat Badan (kg) *                                  │
│ ┌─────────────────────────────────────────────────┐ │
│ │  999                                 ⚠️         │ │ ← Red border
│ └─────────────────────────────────────────────────┘ │
│ ❌ Berat badan tidak valid (max 200 kg)            │ ← Error text red
└─────────────────────────────────────────────────────┘
```

### 2.4 Cards

```
┌─────────────────────────────────────────────────────┐
│ 👶 Aisyah Putri Rahmawati              [Detail →]  │ ← Header
├─────────────────────────────────────────────────────┤
│ 📅 24 bulan (2 tahun 0 bulan)                      │
│ ⚖️  Berat: 12.5 kg    📏 Tinggi: 85.0 cm          │
│ 📊 Status: [Normal] ✓                              │ ← Green badge
└─────────────────────────────────────────────────────┘
```

### 2.5 Status Badges

```
[Normal] ✓        ← Green bg #10B981
[Stunting] ⚠️     ← Yellow bg #F59E0B
[Stunting Berat] 🚨 ← Red bg #EF4444
```

### 2.6 Toast Notifications

**Success**:

```
┌─────────────────────────────────────────┐
│ ✓ Data berhasil disimpan!               │ ← Green bg, slide from top
└─────────────────────────────────────────┘
```

**Error**:

```
┌─────────────────────────────────────────┐
│ ❌ Gagal menyimpan data. Coba lagi.     │ ← Red bg
└─────────────────────────────────────────┘
```

**Info (Offline)**:

```
┌─────────────────────────────────────────┐
│ ℹ️ Mode Offline - Data akan di-sync     │ ← Blue bg
│   otomatis saat online                   │
└─────────────────────────────────────────┘
```

---

## 3. LOGIN SCREEN

```
┌─────────────────────────────────────────────────────┐
│                                                      │
│                                                      │
│              [Logo Posting Cinta]                    │ ← 120×120px
│                                                      │
│         Posting Cinta Muara Enim                     │ ← 24px, Bold
│      Monitoring Stunting & Gizi Anak                 │ ← 16px, Regular
│                                                      │
│  ┌───────────────────────────────────────────────┐  │
│  │ Email                                         │  │
│  │ ┌─────────────────────────────────────────┐   │  │
│  │ │ 👤 contoh@email.com                    │   │  │ ← 56px height
│  │ └─────────────────────────────────────────┘   │  │
│  └───────────────────────────────────────────────┘  │
│                                                      │
│  ┌───────────────────────────────────────────────┐  │
│  │ Password                                      │  │
│  │ ┌─────────────────────────────────────────┐   │  │
│  │ │ 🔒 ••••••••••              [👁️ Show]  │   │  │
│  │ └─────────────────────────────────────────┘   │  │
│  └───────────────────────────────────────────────┘  │
│                                                      │
│  ┌───────────────────────────────────────────────┐  │
│  │          🔐 MASUK                            │  │ ← Primary button
│  └───────────────────────────────────────────────┘  │
│                                                      │
│             Lupa Password? →                         │ ← Link 14px
│                                                      │
└─────────────────────────────────────────────────────┘
```

**Features**:

- Auto-focus on email field
- Show/hide password toggle
- Remember me checkbox (optional)
- Enter key submits form
- Loading state: "Memverifikasi..."

---

## 4. DASHBOARD - KADER

```
┌─────────────────────────────────────────────────────┐
│ ☰ Beranda                       [🔔 3] [👤 Profil] │ ← Header 64px
├─────────────────────────────────────────────────────┤
│                                                      │
│ 👋 Halo, Bu Siti!                                   │ ← 20px, SemiBold
│ Posyandu Mawar - Kecamatan Gelumbang                │ ← 14px, Gray
│                                                      │
│ [🌐 ONLINE] Terakhir sync: 5 menit lalu             │ ← Status badge
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 📊 Ringkasan Bulan Ini (Oktober 2025)          │ │ ← Card
│ ├─────────────────────────────────────────────────┤ │
│ │ Total Anak: 45 anak                             │ │
│ │                                                  │ │
│ │ ┌──────────┐  ┌──────────┐  ┌──────────┐      │ │
│ │ │   38     │  │    5     │  │    2     │      │ │ ← Big numbers
│ │ │ ✓ Normal │  │ ⚠️Stunting│  │ 🚨Berat  │      │ │
│ │ └──────────┘  └──────────┘  └──────────┘      │ │
│ │                                                  │ │
│ │ Sudah diukur bulan ini: 32 dari 45 anak (71%)   │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 🎯 Tindakan Cepat                               │ │
│ ├─────────────────────────────────────────────────┤ │
│ │ ┌───────────────────────────────────────────┐   │ │
│ │ │ + INPUT DATA PENGUKURAN                   │   │ │ ← Primary
│ │ └───────────────────────────────────────────┘   │ │
│ │                                                  │ │
│ │ ┌───────────────────────────────────────────┐   │ │
│ │ │ 👶 DAFTAR ANAK                            │   │ │ ← Secondary
│ │ └───────────────────────────────────────────┘   │ │
│ │                                                  │ │
│ │ ┌───────────────────────────────────────────┐   │ │
│ │ │ 🍎 RESEP MAKANAN SEHAT                    │   │ │ ← Secondary
│ │ └───────────────────────────────────────────┘   │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ ⚠️ Anak Butuh Perhatian (2)                     │ │
│ ├─────────────────────────────────────────────────┤ │
│ │ 👶 Ahmad Fauzi                   [Lihat →]     │ │
│ │ Status: Stunting Berat 🚨                       │ │
│ │ Terakhir diukur: 3 hari lalu                    │ │
│ ├─────────────────────────────────────────────────┤ │
│ │ 👶 Siti Aisyah                   [Lihat →]     │ │
│ │ Status: Stunting ⚠️                             │ │
│ │ Terakhir diukur: 5 hari lalu                    │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 📅 Jadwal Posyandu Berikutnya                   │ │
│ ├─────────────────────────────────────────────────┤ │
│ │ 🗓️ Senin, 20 Oktober 2025                       │ │
│ │ 🕐 08:00 - 12:00 WIB                            │ │
│ │ 📍 Balai Desa Gelumbang                         │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
└─────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────┐
│  [🏠 Beranda]  [👶 Anak]  [🍎 Resep]  [👤 Profil]  │ ← Bottom Nav
└─────────────────────────────────────────────────────┘
```

**Features**:

- Auto-refresh setiap 60 detik (silent)
- Pull-to-refresh gesture
- Offline indicator at top
- Quick actions prominently displayed
- Critical cases highlighted in red

---

## 5. DASHBOARD - PUSKESMAS

```
┌─────────────────────────────────────────────────────┐
│ ☰ Dashboard Puskesmas           [🔔 5] [👤 Profil] │
├─────────────────────────────────────────────────────┤
│                                                      │
│ 🏥 Puskesmas Gelumbang                              │
│ Periode: Oktober 2025                [Filter ▼]     │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 📊 Ringkasan Kabupaten                          │ │
│ ├─────────────────────────────────────────────────┤ │
│ │ Total Posyandu: 12                               │ │
│ │ Total Kader Aktif: 24                            │ │
│ │ Total Anak Terdaftar: 540 anak                   │ │
│ │                                                  │ │
│ │ Status Gizi:                                     │ │
│ │ ┌──────────┐  ┌──────────┐  ┌──────────┐       │ │
│ │ │   456    │  │    60    │  │    24    │       │ │
│ │ │ ✓ Normal │  │ ⚠️Stunting│  │ 🚨Berat  │       │ │
│ │ │  84.4%   │  │  11.1%   │  │  4.5%    │       │ │
│ │ └──────────┘  └──────────┘  └──────────┘       │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 📈 Tren Stunting (6 Bulan Terakhir)             │ │
│ ├─────────────────────────────────────────────────┤ │
│ │      [Mini Line Chart]                          │ │
│ │  16% ─┐                                         │ │
│ │       │  ╲                                       │ │
│ │  12% ─┤   ╲                                      │ │
│ │       │    ╲  ╱╲                                 │ │
│ │   8% ─┤     ╲╱  ╲                               │ │
│ │       └──────────╲──────                        │ │
│ │       Mei Jun Jul Ags Sep Okt                   │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 🚨 Posyandu Prioritas (Stunting Tertinggi)      │ │
│ ├─────────────────────────────────────────────────┤ │
│ │ 1. Posyandu Melati              [Detail →]      │ │
│ │    Stunting: 8/35 (22.9%)                       │ │
│ │    Kader: Bu Ani                                │ │
│ ├─────────────────────────────────────────────────┤ │
│ │ 2. Posyandu Mawar               [Detail →]      │ │
│ │    Stunting: 7/45 (15.6%)                       │ │
│ │    Kader: Bu Siti                               │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ ⚙️ Manajemen                                     │ │
│ ├─────────────────────────────────────────────────┤ │
│ │ ┌─────────────────┐  ┌─────────────────┐       │ │
│ │ │ 📍 Kelola        │  │ 👥 Kelola        │       │ │
│ │ │    Posyandu      │  │    Kader         │       │ │
│ │ └─────────────────┘  └─────────────────┘       │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
└─────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────┐
│ [🏠 Beranda] [📊 Laporan] [⚙️ Kelola] [👤 Profil]  │
└─────────────────────────────────────────────────────┘
```

---

## 6. DASHBOARD - ADMIN DINAS

```
┌─────────────────────────────────────────────────────┐
│ ☰ Dashboard Kabupaten           [🔔 12] [👤 Admin] │
├─────────────────────────────────────────────────────┤
│                                                      │
│ 🏛️ Dinas Ketahanan Pangan Muara Enim               │
│ Periode: Oktober 2025                [Export ▼]     │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 📊 Ringkasan Kabupaten                          │ │
│ ├─────────────────────────────────────────────────┤ │
│ │ ┌──────────┐  ┌──────────┐  ┌──────────┐       │ │
│ │ │    15    │  │    120   │  │  5,400   │       │ │
│ │ │ Puskesmas │  │ Posyandu │  │  Anak    │       │ │
│ │ └──────────┘  └──────────┘  └──────────┘       │ │
│ │                                                  │ │
│ │ Prevalensi Stunting Kabupaten:                   │ │
│ │ ┌──────────────────────────────────────────────┐ │ │
│ │ │  [██████████░░░░░░░░░░░░░░░░░░░░░░░░░] 15.2% │ │ │
│ │ └──────────────────────────────────────────────┘ │ │
│ │ Target 2025: < 14% (⚠️ Belum Tercapai)          │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 🗺️ Peta Sebaran Stunting (By Kecamatan)         │ │
│ ├─────────────────────────────────────────────────┤ │
│ │ [Interactive Map Placeholder]                   │ │
│ │                                                  │ │
│ │ Legenda:                                         │ │
│ │ 🟢 < 10% (Rendah)                               │ │
│ │ 🟡 10-20% (Sedang)                              │ │
│ │ 🔴 > 20% (Tinggi)                               │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 📈 Tren Prevalensi (12 Bulan)                   │ │
│ ├─────────────────────────────────────────────────┤ │
│ │      [Bar Chart]                                │ │
│ │  20% ┤                                          │ │
│ │  15% ┤ ███ ███ ███ ██▓ ██▓ ██░ ██░ ██░ ██░    │ │
│ │  10% ┤ ███ ███ ███ ███ ███ ███ ███ ███ ███    │ │
│ │      └─────────────────────────────────────    │ │
│ │       Nov Dec Jan Feb Mar Apr Mei Jun Jul Ags  │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ ⚙️ Manajemen Sistem                              │ │
│ ├─────────────────────────────────────────────────┤ │
│ │ ┌──────────┐ ┌──────────┐ ┌──────────┐         │ │
│ │ │ 🏥 Kelola │ │ 👥 Kelola │ │ 🍎 Kelola │         │ │
│ │ │ Puskesmas │ │  User    │ │  Resep   │         │ │
│ │ └──────────┘ └──────────┘ └──────────┘         │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
└─────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────┐
│ [🏠 Beranda] [📊 Laporan] [⚙️ Kelola] [👤 Profil]  │
└─────────────────────────────────────────────────────┘
```

---

## 7. FORM INPUT PENGUKURAN

```
┌─────────────────────────────────────────────────────┐
│ ← Kembali          Input Pengukuran             [?] │
├─────────────────────────────────────────────────────┤
│                                                      │
│ Langkah 1 dari 2: Data Anak                         │ ← Progress indicator
│ [████████████░░░░░░░░░░░] 50%                      │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ Pilih Anak *                                    │ │
│ │ ┌─────────────────────────────────────────────┐ │ │
│ │ │ 🔍 Cari nama anak...                        │ │ │ ← Searchable
│ │ └─────────────────────────────────────────────┘ │ │
│ │                                                  │ │
│ │ Hasil (3 anak):                                  │ │
│ │ ┌─────────────────────────────────────────────┐ │ │
│ │ │ ○ Ahmad Fauzi                               │ │ │ ← Radio button
│ │ │   24 bulan • Posyandu Mawar                 │ │ │
│ │ └─────────────────────────────────────────────┘ │ │
│ │ ┌─────────────────────────────────────────────┐ │ │
│ │ │ ⦿ Aisyah Putri Rahmawati                    │ │ │ ← Selected
│ │ │   24 bulan • Posyandu Mawar                 │ │ │
│ │ └─────────────────────────────────────────────┘ │ │
│ │ ┌─────────────────────────────────────────────┐ │ │
│ │ │ ○ Budi Santoso                              │ │ │
│ │ │   36 bulan • Posyandu Mawar                 │ │ │
│ │ └─────────────────────────────────────────────┘ │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ Tanggal Pengukuran *                            │ │
│ │ ┌─────────────────────────────────────────────┐ │ │
│ │ │ 📅 12 Oktober 2025              [Kalender] │ │ │
│ │ └─────────────────────────────────────────────┘ │ │
│ │ Default: Hari ini                               │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │            LANJUT KE PENGUKURAN →               │ │ ← Primary button
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ [Anak belum terdaftar? Daftar anak baru →]          │ ← Link
│                                                      │
└─────────────────────────────────────────────────────┘
```

### Step 2: Input Measurements

```
┌─────────────────────────────────────────────────────┐
│ ← Kembali          Input Pengukuran             [?] │
├─────────────────────────────────────────────────────┤
│                                                      │
│ Langkah 2 dari 2: Data Pengukuran                   │
│ [████████████████████████] 100%                     │
│                                                      │
│ 👶 Aisyah Putri Rahmawati (Perempuan, 24 bulan)    │
│ 📅 12 Oktober 2025                                  │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ Berat Badan (kg) *                              │ │
│ │ ┌─────────────────────────────────────────────┐ │ │
│ │ │  12.5                       [⚖️ kg]         │ │ │ ← Big input
│ │ └─────────────────────────────────────────────┘ │ │
│ │ Contoh: 12.5 (gunakan titik untuk desimal)      │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ Tinggi Badan (cm) *                             │ │
│ │ ┌─────────────────────────────────────────────┐ │ │
│ │ │  85.0                       [📏 cm]         │ │ │
│ │ └─────────────────────────────────────────────┘ │ │
│ │ Untuk bayi < 24 bulan: ukur berbaring           │ │
│ │ Untuk anak ≥ 24 bulan: ukur berdiri             │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ Lingkar Kepala (cm) - Opsional                  │ │
│ │ ┌─────────────────────────────────────────────┐ │ │
│ │ │  48.5                       [🎯 cm]         │ │ │
│ │ └─────────────────────────────────────────────┘ │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ Catatan - Opsional                              │ │
│ │ ┌─────────────────────────────────────────────┐ │ │
│ │ │ Anak tampak sehat, aktif bermain            │ │ │
│ │ │                                              │ │ │
│ │ └─────────────────────────────────────────────┘ │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │            ✓ SIMPAN DATA                        │ │ ← Primary button
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │            Batal                                │ │ ← Secondary
│ └─────────────────────────────────────────────────┘ │
│                                                      │
└─────────────────────────────────────────────────────┘
```

### Confirmation Screen (After Save)

```
┌─────────────────────────────────────────────────────┐
│                                                      │
│                                                      │
│                     ✓                               │ ← Big checkmark
│                                                      │
│              Data Berhasil Disimpan!                │ ← 24px, Bold
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 👶 Aisyah Putri Rahmawati                       │ │
│ │ 📅 12 Oktober 2025 • 24 bulan                   │ │
│ │                                                  │ │
│ │ Hasil Pengukuran:                                │ │
│ │ ⚖️  Berat: 12.5 kg    📏 Tinggi: 85.0 cm       │ │
│ │                                                  │ │
│ │ Status Gizi:                                     │ │
│ │ [Normal] ✓                    🟢                │ │ ← Green badge
│ │                                                  │ │
│ │ • TB/U Z-score: +0.2 (Normal)                   │ │
│ │ • BB/U Z-score: +0.5 (Normal)                   │ │
│ │ • BB/TB Z-score: +0.8 (Normal)                  │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │      📊 LIHAT GRAFIK PERTUMBUHAN                │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │      + INPUT DATA ANAK LAIN                     │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ [← Kembali ke Beranda]                              │
│                                                      │
└─────────────────────────────────────────────────────┘
```

**If Stunting Detected**:

```
┌─────────────────────────────────────────────────────┐
│                   ⚠️                                │ ← Yellow/Red icon
│                                                      │
│         Terdeteksi Gizi Kurang (Stunting)          │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 👶 Ahmad Fauzi                                  │ │
│ │ Status: [Stunting] ⚠️            🟡            │ │ ← Yellow badge
│ │                                                  │ │
│ │ • TB/U Z-score: -2.3 (Stunting)                 │ │
│ │ • BB/U Z-score: -1.8 (Normal)                   │ │
│ │                                                  │ │
│ │ ⚠️ Tindakan yang Diperlukan:                     │ │
│ │ 1. Konseling gizi ke orang tua                  │ │
│ │ 2. Rujuk ke Puskesmas untuk pemeriksaan         │ │
│ │ 3. Pantau perkembangan setiap 2 minggu          │ │
│ │                                                  │ │
│ │ 📌 Notifikasi telah dikirim ke:                 │ │
│ │ • Puskesmas Gelumbang                           │ │
│ │ • Anda (Kader)                                  │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │      🍎 LIHAT REKOMENDASI RESEP                 │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │      📊 LIHAT GRAFIK PERTUMBUHAN                │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ [← Kembali ke Beranda]                              │
│                                                      │
└─────────────────────────────────────────────────────┘
```

---

## 8. DAFTAR ANAK

```
┌─────────────────────────────────────────────────────┐
│ ← Kembali          Daftar Anak              [+ Baru]│
├─────────────────────────────────────────────────────┤
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 🔍 Cari nama anak atau ibu...                   │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ Filter: [Semua ▼] [Status Gizi ▼]                  │
│                                                      │
│ 45 anak ditemukan                                    │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 👶 Ahmad Fauzi                  [Detail →]      │ │
│ │ 📅 24 bulan (2 tahun 0 bulan)                   │ │
│ │ 👩 Ibu: Siti Aminah                             │ │
│ │ ⚖️  12.5 kg  📏 85.0 cm  [Normal] ✓           │ │ ← Green
│ │ Terakhir diukur: 2 hari lalu                    │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 👶 Budi Santoso                 [Detail →]      │ │
│ │ 📅 36 bulan (3 tahun 0 bulan)                   │ │
│ │ 👩 Ibu: Mariana                                 │ │
│ │ ⚖️  13.2 kg  📏 92.0 cm  [Stunting] ⚠️        │ │ ← Yellow
│ │ Terakhir diukur: 5 hari lalu                    │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 👶 Citra Dewi                   [Detail →]      │ │
│ │ 📅 18 bulan (1 tahun 6 bulan)                   │ │
│ │ 👩 Ibu: Nur Fadillah                            │ │
│ │ ⚠️ Belum diukur bulan ini                       │ │ ← Gray, warning
│ │ Terakhir diukur: 32 hari lalu                   │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ [Load More...]                                       │
│                                                      │
└─────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────┐
│  [🏠 Beranda]  [👶 Anak]  [📊 Grafik]  [👤 Profil] │
└─────────────────────────────────────────────────────┘
```

### Detail Anak

```
┌─────────────────────────────────────────────────────┐
│ ← Kembali          Detail Anak              [Edit →]│
├─────────────────────────────────────────────────────┤
│                                                      │
│ 👶 Aisyah Putri Rahmawati                           │ ← 24px, Bold
│ Status: [Normal] ✓                    🟢            │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 📋 Informasi Dasar                              │ │
│ ├─────────────────────────────────────────────────┤ │
│ │ NIK: 1671234567890123                           │ │
│ │ Jenis Kelamin: Perempuan                        │ │
│ │ Tanggal Lahir: 12 Oktober 2023 (24 bulan)      │ │
│ │ Ibu: Siti Rahmawati                             │ │
│ │ Posyandu: Posyandu Mawar                        │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 📊 Data Pengukuran Terakhir                     │ │
│ ├─────────────────────────────────────────────────┤ │
│ │ Tanggal: 12 Oktober 2025                        │ │
│ │ Umur saat ukur: 24 bulan                        │ │
│ │                                                  │ │
│ │ Berat Badan: 12.5 kg                            │ │
│ │ Tinggi Badan: 85.0 cm                           │ │
│ │ Lingkar Kepala: 48.5 cm                         │ │
│ │                                                  │ │
│ │ Z-Scores:                                        │ │
│ │ • TB/U: +0.2 (Normal) ✓                        │ │
│ │ • BB/U: +0.5 (Normal) ✓                        │ │
│ │ • BB/TB: +0.8 (Normal) ✓                       │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │      📊 LIHAT GRAFIK PERTUMBUHAN                │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │      + INPUT PENGUKURAN BARU                    │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 📜 Riwayat Pengukuran (12 bulan terakhir)       │ │
│ ├─────────────────────────────────────────────────┤ │
│ │ 12 Okt 2025  12.5kg  85.0cm  [Normal] ✓        │ │
│ │ 12 Sep 2025  12.2kg  84.5cm  [Normal] ✓        │ │
│ │ 12 Ags 2025  12.0kg  84.0cm  [Normal] ✓        │ │
│ │ [Lihat Semua →]                                 │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
└─────────────────────────────────────────────────────┘
```

---

## 9. GRAFIK PERTUMBUHAN

```
┌─────────────────────────────────────────────────────┐
│ ← Kembali      Grafik Pertumbuhan                   │
├─────────────────────────────────────────────────────┤
│                                                      │
│ 👶 Aisyah Putri Rahmawati                           │
│ Perempuan, 24 bulan                                 │
│                                                      │
│ [TB/U] [BB/U] [BB/TB]                               │ ← Tabs
│ ▔▔▔▔▔                                               │ ← Active underline
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │          Tinggi Badan menurut Umur              │ │
│ │          (Height-for-Age)                        │ │
│ ├─────────────────────────────────────────────────┤ │
│ │                                                  │ │
│ │  100cm─┐    +3 SD ················             │ │
│ │        │ ─ +2 SD ──────────────                │ │
│ │   90cm─┤ ━ Median ━━━━━━━━━━━━                │ │
│ │        │ ─ -2 SD (Stunting) ─────              │ │
│ │   80cm─┤ ·· -3 SD ················             │ │
│ │        │      ╱─────●                           │ │ ← Child's data
│ │   70cm─┤    ╱                                   │ │
│ │        │  ●───●                                 │ │
│ │   60cm─┤●                                       │ │
│ │        └────────────────────────               │ │
│ │         0  6 12 18 24 30 36 (bulan)            │ │
│ │                                                  │ │
│ │ Status Saat Ini: [Normal] ✓        🟢          │ │
│ │ Z-score TB/U: +0.2                              │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ℹ️ Penjelasan:                                      │
│ • Titik biru (●) = Pengukuran anak                 │
│ • Garis hijau (━) = Median WHO                     │
│ • Garis merah (─) = Batas stunting (-2 SD)        │
│                                                      │
│ ⚠️ Anak dikatakan stunting jika titik biru         │
│    berada di bawah garis merah (-2 SD)             │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │      📥 DOWNLOAD GRAFIK (PDF)                   │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │      📤 BAGIKAN KE ORANG TUA                    │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
└─────────────────────────────────────────────────────┘
```

**Features**:

- Interactive chart (zoom, pan)
- Tooltips on data points
- Toggle WHO curves visibility
- Responsive design (landscape mode for better view)
- Pinch to zoom on mobile

---

## 10. RESEP MAKANAN

```
┌─────────────────────────────────────────────────────┐
│ ☰ Resep Makanan Sehat            [🔍]      [+ Baru]│ ← Admin only
├─────────────────────────────────────────────────────┤
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 🔍 Cari resep...                                │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ Kategori:                                            │
│ [Semua] [MPASI 6-12 bln] [Balita 1-3 thn] [Anak 3-5]│ ← Chips/Pills
│  ▔▔▔▔▔                                              │
│                                                      │
│ 45 resep ditemukan                                   │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ [Image]                                         │ │ ← Recipe photo
│ │                                                  │ │
│ │ Bubur Ayam Wortel Bayam                         │ │ ← 18px, Bold
│ │ MPASI 6-12 bulan                                │ │ ← Category badge
│ │                                                  │ │
│ │ ⏱️ 30 menit  🔥 120 kcal  👶 6+ bulan          │ │
│ │                                        [Lihat →]│ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ [Image]                                         │ │
│ │                                                  │ │
│ │ Nasi Tim Ikan Kembung                           │ │
│ │ Balita 1-3 tahun                                │ │
│ │                                                  │ │
│ │ ⏱️ 45 menit  🔥 200 kcal  👶 12+ bulan         │ │
│ │                                        [Lihat →]│ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ [Image]                                         │ │
│ │                                                  │ │
│ │ Telur Dadar Sayur                               │ │
│ │ Anak 3-5 tahun                                  │ │
│ │                                                  │ │
│ │ ⏱️ 15 menit  🔥 150 kcal  👶 24+ bulan         │ │
│ │                                        [Lihat →]│ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ [Load More...]                                       │
│                                                      │
└─────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────┐
│  [🏠 Beranda]  [👶 Anak]  [🍎 Resep]  [👤 Profil]  │
└─────────────────────────────────────────────────────┘
```

### Detail Resep

```
┌─────────────────────────────────────────────────────┐
│ ← Kembali          Detail Resep             [Edit →]│ ← Admin only
├─────────────────────────────────────────────────────┤
│                                                      │
│ [Large Recipe Photo]                                │ ← Full width
│                                                      │
│ Bubur Ayam Wortel Bayam                             │ ← 24px, Bold
│ [MPASI 6-12 bulan]                                  │ ← Blue badge
│                                                      │
│ ⏱️ Waktu: 30 menit                                  │
│ 🔥 Kalori: 120 kcal/porsi                          │
│ 👶 Cocok untuk: 6 bulan ke atas                    │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 🥘 Bahan-Bahan:                                 │ │
│ ├─────────────────────────────────────────────────┤ │
│ │ ☑ 50 gram ayam fillet, cincang halus            │ │ ← Checkboxes
│ │ ☑ 30 gram wortel, parut halus                   │ │
│ │ ☑ 20 gram bayam, iris halus                     │ │
│ │ ☑ 3 sdm beras putih                             │ │
│ │ ☑ 400 ml air/kaldu ayam                         │ │
│ │ ☑ 1 sdt minyak zaitun                           │ │
│ │ ☑ Sejumput garam (opsional)                     │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 👩‍🍳 Cara Membuat:                                │ │
│ ├─────────────────────────────────────────────────┤ │
│ │ 1️⃣ Cuci bersih beras, rendam 15 menit           │ │
│ │                                                  │ │
│ │ 2️⃣ Rebus beras dengan air/kaldu hingga         │ │
│ │    menjadi bubur (±20 menit)                    │ │
│ │                                                  │ │
│ │ 3️⃣ Tumis ayam cincang dengan minyak zaitun     │ │
│ │    hingga matang                                │ │
│ │                                                  │ │
│ │ 4️⃣ Masukkan wortel parut, masak 5 menit        │ │
│ │                                                  │ │
│ │ 5️⃣ Tambahkan bayam, masak hingga layu          │ │
│ │                                                  │ │
│ │ 6️⃣ Campurkan tumisan ke dalam bubur,           │ │
│ │    aduk rata                                    │ │
│ │                                                  │ │
│ │ 7️⃣ Sajikan hangat untuk bayi                    │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 💡 Tips:                                        │ │
│ │ • Pastikan tekstur bubur sesuai usia bayi       │ │
│ │ • Hindari garam berlebihan (ginjal bayi)        │ │
│ │ • Gunakan sayuran organik bila memungkinkan     │ │
│ │ • Simpan di kulkas max 24 jam                   │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 📊 Informasi Gizi:                              │ │
│ │ Protein: 8g  •  Karbohidrat: 15g  •  Lemak: 3g │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │      📤 BAGIKAN RESEP                           │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │      📥 DOWNLOAD PDF                            │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
└─────────────────────────────────────────────────────┘
```

---

## 11. NOTIFIKASI

```
┌─────────────────────────────────────────────────────┐
│ ← Kembali          Notifikasi           [✓ Tandai  ]│
│                                          Semua Sudah]│
├─────────────────────────────────────────────────────┤
│                                                      │
│ Hari Ini (3)                                         │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 🚨 Deteksi Gizi Buruk                           │ │ ← Unread (bold)
│ │ Ahmad Fauzi terdeteksi stunting berat           │ │
│ │ (TB/U: -3.2 SD). Segera lakukan tindak lanjut.  │ │
│ │                                                  │ │
│ │ 10 menit lalu                    [Lihat Detail] │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 📅 Reminder Jadwal Posyandu                     │ │
│ │ Posyandu Mawar besok (20 Okt) pukul 08:00 WIB.  │ │
│ │ Persiapkan alat timbang dan KMS.                │ │
│ │                                                  │ │
│ │ 2 jam lalu                               [✓]    │ │ ← Read (gray)
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ ℹ️ Reminder Input Data                          │ │
│ │ 13 anak belum diukur bulan ini. Jangan lupa     │ │
│ │ input data sebelum tanggal 25.                  │ │
│ │                                                  │ │
│ │ 5 jam lalu                               [✓]    │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ Kemarin (2)                                          │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ ✅ Data Berhasil Di-Sync                        │ │
│ │ 5 data pengukuran offline telah di-sync         │ │
│ │ ke server. Semua data sudah tersimpan aman.     │ │
│ │                                                  │ │
│ │ 19 Okt, 14:30                            [✓]    │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 🍎 Resep Baru Ditambahkan                       │ │
│ │ Admin menambahkan 3 resep MPASI baru.           │ │
│ │ Lihat sekarang untuk ide menu bergizi!          │ │
│ │                                                  │ │
│ │ 19 Okt, 10:15                     [Lihat Resep] │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ [Load More...]                                       │
│                                                      │
└─────────────────────────────────────────────────────┘
```

---

## 12. PROFIL & PENGATURAN

```
┌─────────────────────────────────────────────────────┐
│ ← Kembali          Profil                  [Edit →] │
├─────────────────────────────────────────────────────┤
│                                                      │
│          [Avatar Placeholder]                       │ ← 96×96px circle
│                                                      │
│           Bu Siti Rahma                             │ ← 20px, Bold
│           Kader Posyandu                            │ ← 14px, Gray
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 👤 Informasi Pribadi                            │ │
│ ├─────────────────────────────────────────────────┤ │
│ │ Nama: Siti Rahma                                │ │
│ │ Email: siti.rahma@postingcinta.id               │ │
│ │ No. HP: 0812-3456-7890                          │ │
│ │ Role: Kader                                     │ │
│ │ Posyandu: Posyandu Mawar                        │ │
│ │ Puskesmas: Puskesmas Gelumbang                  │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ ⚙️ Pengaturan                                    │ │
│ ├─────────────────────────────────────────────────┤ │
│ │ Notifikasi         [Toggle ON]                  │ │
│ │ Mode Gelap         [Toggle OFF]                 │ │
│ │ Sync Otomatis      [Toggle ON]                  │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │ 📊 Statistik Saya                               │ │
│ ├─────────────────────────────────────────────────┤ │
│ │ Total Anak Terdaftar: 45 anak                   │ │
│ │ Total Pengukuran Bulan Ini: 32                  │ │
│ │ Anak dengan Status Gizi Baik: 38                │ │
│ │ Rata-rata Response Time: 2 hari                 │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │      🔐 GANTI PASSWORD                          │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │      📱 TENTANG APLIKASI                        │ │
│ │      Versi 1.0.0                                │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │      🚪 KELUAR                                  │ │ ← Red text
│ └─────────────────────────────────────────────────┘ │
│                                                      │
└─────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────┐
│  [🏠 Beranda]  [👶 Anak]  [🍎 Resep]  [👤 Profil]  │
└─────────────────────────────────────────────────────┘
```

---

## 13. OFFLINE MODE INDICATORS

### Offline Banner (Top of Page)

```
┌─────────────────────────────────────────────────────┐
│ ⚠️ MODE OFFLINE - Data akan di-sync otomatis saat  │ ← Orange bg
│ online kembali. Anda tetap bisa input data.         │
└─────────────────────────────────────────────────────┘
```

### Sync Status Indicator

```
🌐 ONLINE  ✓ Tersinkron            ← Green
📶 OFFLINE ⏳ 3 data menunggu sync  ← Orange
```

### Pending Sync List

```
┌─────────────────────────────────────────────────────┐
│ 📂 Data Menunggu Sync (3)                           │
├─────────────────────────────────────────────────────┤
│                                                      │
│ ⏳ Pengukuran Ahmad Fauzi                           │
│    12 Okt 2025, 10:30                               │
│    Status: Menunggu sync...                         │
│                                                      │
│ ⏳ Pengukuran Budi Santoso                          │
│    12 Okt 2025, 11:15                               │
│    Status: Menunggu sync...                         │
│                                                      │
│ ⏳ Pengukuran Citra Dewi                            │
│    12 Okt 2025, 11:45                               │
│    Status: Menunggu sync...                         │
│                                                      │
│ [🔄 Coba Sync Sekarang]                             │
│                                                      │
└─────────────────────────────────────────────────────┘
```

---

## 14. ERROR STATES

### No Internet Connection

```
┌─────────────────────────────────────────────────────┐
│                                                      │
│                   📶 ❌                              │ ← Big icon
│                                                      │
│            Tidak Ada Koneksi Internet               │
│                                                      │
│         Anda sedang dalam mode offline.             │
│    Data yang Anda input akan tersimpan secara       │
│    lokal dan di-sync otomatis saat online.          │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │      🔄 COBA LAGI                               │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ [← Kembali]                                         │
│                                                      │
└─────────────────────────────────────────────────────┘
```

### Server Error

```
┌─────────────────────────────────────────────────────┐
│                   ⚠️                                 │
│                                                      │
│            Terjadi Kesalahan Server                 │
│                                                      │
│        Maaf, server sedang bermasalah.              │
│        Silakan coba beberapa saat lagi.             │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │      🔄 COBA LAGI                               │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
│ [🏠 Kembali ke Beranda]                             │
│                                                      │
└─────────────────────────────────────────────────────┘
```

### Empty State

```
┌─────────────────────────────────────────────────────┐
│                   📭                                │
│                                                      │
│            Belum Ada Data                           │
│                                                      │
│        Anda belum memiliki anak terdaftar.          │
│        Klik tombol di bawah untuk menambahkan.      │
│                                                      │
│ ┌─────────────────────────────────────────────────┐ │
│ │      + DAFTAR ANAK BARU                         │ │
│ └─────────────────────────────────────────────────┘ │
│                                                      │
└─────────────────────────────────────────────────────┘
```

---

## 15. LOADING STATES

### Full Page Loading

```
┌─────────────────────────────────────────────────────┐
│                                                      │
│                                                      │
│                    [Spinner]                        │ ← Animated
│                                                      │
│              Memuat data...                         │
│                                                      │
│         Mohon tunggu sebentar                       │
│                                                      │
│                                                      │
└─────────────────────────────────────────────────────┘
```

### Skeleton Loading (Card)

```
┌─────────────────────────────────────────────────────┐
│ [████████████████░░░░░░░░░░]                        │ ← Animated shimmer
│ [████████░░░░░░░░░░░░░░░░░░░░]                      │
│ [██████████████░░░░░░░░░░░░░░]                      │
└─────────────────────────────────────────────────────┘
```

---

## 16. RESPONSIVE BREAKPOINTS

```
Mobile Portrait:   320px - 480px  (Default design)
Mobile Landscape:  481px - 767px  (Adjust layout)
Tablet:            768px - 1024px (2-column grid)
Desktop:           1025px+        (3-column grid, sidebar)
```

**Optimization**:

- Touch targets: 48px minimum on mobile
- Font size scales with viewport (16px base)
- Images lazy-loaded
- Infinite scroll on lists (pagination for desktop)

---

## 17. ACCESSIBILITY FEATURES

✅ Screen reader support (aria-labels)
✅ Keyboard navigation (tab, enter, esc)
✅ High contrast mode support
✅ Focus indicators (blue outline)
✅ Error announcements (aria-live)
✅ Alt text for images
✅ Label for all form inputs
✅ Touch target size (min 48px)

---

**END OF UI/UX DESIGN DOCUMENT**
