# SYSTEM REQUIREMENTS SPECIFICATION (SRS)

## Aplikasi Posting Cinta - Monitoring Stunting Anak

**Versi**: 1.0  
**Tanggal**: 12 Oktober 2025  
**Prepared by**: Senior System Architect  
**Project**: PWA Monitoring Stunting untuk Kabupaten Muara Enim

---

## 1. EXECUTIVE SUMMARY

**Problem**: Tingginya angka stunting di Kabupaten Muara Enim akibat minimnya tools monitoring tumbuh kembang anak yang mudah digunakan oleh kader posyandu dengan literasi digital rendah.

**Solution**: Aplikasi PWA "Posting Cinta" berbasis Laravel 11 dengan offline-first capability untuk monitoring stunting berbasis standar WHO, dilengkapi resep makanan sehat dan notifikasi otomatis.

**Key Features**:

- ✅ Monitoring pertumbuhan anak (BB, TB, LK) dengan deteksi otomatis stunting/wasting/underweight
- ✅ Grafik pertumbuhan berbasis WHO growth charts (terpisah laki-laki/perempuan)
- ✅ Resep makanan sehat ter-kategorisasi per usia (MPASI, Balita, Anak)
- ✅ PWA offline-first untuk kader di lapangan dengan sinyal lemah
- ✅ Notifikasi jadwal posyandu, deteksi gizi buruk, reminder input data
- ✅ UI/UX sederhana untuk user gaptek (kader kesehatan)

**ROI**: Deteksi dini stunting → penanganan cepat → penurunan prevalensi stunting → peningkatan kualitas SDM generasi mendatang.

**Timeline**: 6-8 minggu development + 2 minggu testing & deployment.

---

## 2. PROCESS ANALYSIS

### 2.1 AS-IS Process (Current State)

```
┌─────────────────────────────────────────────────────────────┐
│                      PROSES SAAT INI                        │
└─────────────────────────────────────────────────────────────┘

Kader Posyandu                    Puskesmas              Dinas Ketahanan Pangan
      │                                │                            │
      │ [1] Timbang anak               │                            │
      │     (Manual di posyandu)       │                            │
      │                                │                            │
      │ [2] Catat di buku KIA          │                            │
      │     (Paper-based)              │                            │
      │                                │                            │
      │ [3] Rekap manual ke            │                            │
      │     form Excel/Kertas  ────────►[4] Kompilasi data         │
      │                                │     dari semua kader       │
      │                                │     (Manual, lambat)       │
      │                                │                            │
      │                                │ [5] Laporan bulanan  ──────►[6] Terima laporan
      │                                │     via WhatsApp/Email     │     (Terlambat)
      │                                │                            │
      │ [7] TIDAK ADA grafik           │                            │
      │     pertumbuhan real-time      │ [8] TIDAK ADA deteksi      │
      │                                │     otomatis stunting      │
      ▼                                ▼                            ▼
```

**Pain Points**:

1. ❌ **Data entry duplikat** - Kader nulis di buku KIA, kemudian input lagi ke Excel
2. ❌ **Lag time tinggi** - Data sampai ke Dinas bisa 1-2 bulan, terlambat untuk intervensi
3. ❌ **Human error** - Salah hitung/tulis saat transfer manual, data tidak akurat
4. ❌ **No real-time monitoring** - Tidak ada grafik pertumbuhan, susah deteksi stunting dini
5. ❌ **Offline limitation** - Kader tidak bisa input data saat sinyal lemah di desa
6. ❌ **Komunikasi ineffisien** - Koordinasi via WhatsApp, reminder manual, sering terlewat

### 2.2 TO-BE Process (Proposed Solution)

```
┌─────────────────────────────────────────────────────────────┐
│              PROSES DENGAN POSTING CINTA                    │
└─────────────────────────────────────────────────────────────┘

Kader Posyandu (PWA)         Puskesmas (Web)        Dinas (Web Dashboard)
      │                            │                          │
      │ [1] Timbang anak           │                          │
      │                            │                          │
      │ [2] Input langsung di PWA  │                          │
      │     (Offline-capable)      │                          │
      │     ├─ BB, TB, LK         │                          │
      │     ├─ Auto-calc Z-score   │                          │
      │     └─ Grafik WHO real-time│                          │
      │                            │                          │
      │ [3] Deteksi otomatis  ─────►[4] Notifikasi real-time │
      │     stunting/wasting       │     di dashboard         │
      │                            │                          │
      │ [4] Data sync otomatis     │                          │
      │     saat online      ──────►[5] View data terkini ───►[6] Dashboard analytics
      │                            │     per kader/posyandu   │     real-time
      │                            │                          │
      │ [5] Terima notif:          │ [6] Monitor semua kader  │ [7] Export laporan
      │     - Jadwal posyandu      │     dan respon cepat     │     per periode
      │     - Reminder input       │     kasus gizi buruk     │
      │     - Resep makanan        │                          │
      ▼                            ▼                          ▼
```

**Improvements**:

1. ✅ **Single data entry** - Input sekali langsung ke sistem, no duplikasi
2. ✅ **Real-time monitoring** - Data langsung sync, deteksi stunting instant
3. ✅ **Auto-calculation** - Sistem hitung Z-score otomatis, no human error
4. ✅ **Visual growth charts** - Grafik WHO otomatis per anak, mudah dipahami
5. ✅ **Offline-first** - Kader bisa kerja tanpa sinyal, auto-sync saat online
6. ✅ **Smart notifications** - Sistem kirim reminder & alert otomatis via DB notifications

---

## 3. FUNCTIONAL SCOPE

### 3.1 User Roles & Access Control

#### **Role 1: Admin Dinas Ketahanan Pangan**

- ✅ Dashboard analytics kabupaten (total anak, prevalensi stunting, tren)
- ✅ View data semua puskesmas & posyandu
- ✅ Manage user accounts (Puskesmas, Kader)
- ✅ Export laporan (PDF/Excel) per periode
- ✅ Manage resep makanan sehat (CRUD)
- ✅ Set jadwal posyandu kabupaten

#### **Role 2: Pengelola Puskesmas**

- ✅ Dashboard analytics puskesmas (data kader di bawahnya)
- ✅ Manage kader yang bernaung di puskesmasnya
- ✅ View & export data per posyandu
- ✅ Monitor kasus gizi buruk & stunting real-time
- ✅ Set jadwal posyandu per kader

#### **Role 3: Kader Posyandu**

- ✅ Input data pertumbuhan anak (BB, TB, LK)
- ✅ View grafik pertumbuhan per anak (WHO charts)
- ✅ Lihat status gizi otomatis (normal/stunting/wasting/underweight)
- ✅ Manage data ibu & anak di wilayahnya
- ✅ Akses resep makanan sehat (filter per usia)
- ✅ View jadwal posyandu & reminder
- ✅ **Offline mode**: Input data tanpa internet, auto-sync saat online

### 3.2 Core Features

#### **Feature 1: Manajemen Data Master**

**1.1 Data Ibu**

- Nama lengkap, NIK, tanggal lahir, alamat lengkap (RT/RW/Desa/Kecamatan)
- Nomor HP (opsional)
- Relasi: 1 ibu → N anak (one-to-many)

**1.2 Data Anak**

- Nama lengkap, NIK (opsional untuk bayi), jenis kelamin, tanggal lahir
- Nama ibu (foreign key)
- Posyandu tempat terdaftar
- Status aktif/tidak aktif

**1.3 Data Posyandu**

- Nama posyandu, kode posyandu
- Alamat lengkap (RT/RW/Desa/Kecamatan)
- Puskesmas induk (foreign key)
- Kader pengelola (foreign key)
- Jadwal rutin (setiap tanggal berapa)

#### **Feature 2: Input & Monitoring Pertumbuhan**

**2.1 Form Input Pengukuran**

- Pilih anak (autocomplete search)
- Tanggal pengukuran (default: hari ini)
- Input measurements:
  - Berat Badan (kg, 1 desimal)
  - Tinggi Badan (cm, 1 desimal)
  - Lingkar Kepala (cm, 1 desimal, opsional)
- Catatan tambahan (textarea, opsional)
- **Auto-save to local storage** saat offline

**2.2 Auto-calculation Z-Score**

- Hitung otomatis saat input selesai:
  - Weight-for-Age Z-score (BB/U)
  - Height-for-Age Z-score (TB/U)
  - Weight-for-Height Z-score (BB/TB)
- Klasifikasi status gizi:
  - **Stunting**: TB/U < -2 SD
  - **Severely Stunted**: TB/U < -3 SD
  - **Wasting**: BB/TB < -2 SD
  - **Severely Wasted**: BB/TB < -3 SD
  - **Underweight**: BB/U < -2 SD
  - **Normal**: semua indikator >= -2 SD

**2.3 WHO Growth Charts (Visual)**

- Tampilkan 3 grafik per anak:
  - **BB/U Chart** (Weight-for-Age)
  - **TB/U Chart** (Height-for-Age)
  - **BB/TB Chart** (Weight-for-Height)
- Grafik terpisah laki-laki vs perempuan
- Plot point pengukuran anak di atas kurva WHO
- Warna indikator:
  - 🟢 Hijau: Normal (>= -2 SD)
  - 🟡 Kuning: At risk (-2 SD s/d -3 SD)
  - 🔴 Merah: Severe (< -3 SD)

#### **Feature 3: Resep Makanan Sehat**

**3.1 Kategori Resep**

- **MPASI 6-12 bulan**: Bubur, puree, finger food
- **Balita 1-3 tahun**: Nasi tim, sup, camilan sehat
- **Anak 3-5 tahun**: Makanan keluarga, menu seimbang

**3.2 Detail Resep**

- Judul resep
- Foto resep (upload/optional)
- Bahan-bahan (list)
- Cara membuat (step-by-step)
- Informasi gizi (kalori, protein, karbohidrat - opsional)
- Kategori usia (MPASI/Balita/Anak)
- Search & filter (by kategori, keyword)

#### **Feature 4: Notification System (DB-Driven)**

**4.1 Jenis Notifikasi**

- 🔔 **Jadwal Posyandu**: Reminder H-3, H-1, H-0 jadwal posyandu
- 🔔 **Deteksi Gizi Buruk**: Alert saat ada anak terdeteksi stunting/wasting baru
- 🔔 **Reminder Input**: Reminder H+7 jika belum input data bulan ini
- 🔔 **Laporan Bulanan**: Notif ke Puskesmas & Dinas setiap akhir bulan

**4.2 Delivery Method**

- In-app notifications (DB table: `notifications`)
- Badge counter di menu notifikasi
- Mark as read functionality

#### **Feature 5: PWA Offline-First**

**5.1 Service Worker Strategy**

- Cache static assets (CSS, JS, images, fonts)
- Cache WHO growth chart data (JSON)
- Cache halaman utama (dashboard, form input)
- Background sync untuk data pengukuran

**5.2 Offline Functionality**

- Input data pengukuran → save to IndexedDB
- View data anak yang sudah di-cache
- View resep makanan (jika sudah di-akses)
- Auto-sync queue saat online kembali

**5.3 Online Indicator**

- Status bar online/offline
- Toast notification saat status berubah
- Sync progress indicator

#### **Feature 6: Dashboard & Reporting**

**6.1 Dashboard Kader**

- Total anak terdaftar di posyandunya
- Jumlah anak per status gizi (normal/stunting/wasting)
- Grafik tren per bulan (jumlah pengukuran)
- List anak yang belum diukur bulan ini
- Upcoming jadwal posyandu

**6.2 Dashboard Puskesmas**

- Aggregate data dari semua kader
- Breakdown per posyandu
- Top 5 posyandu dengan kasus stunting tertinggi
- Grafik tren kabupaten per bulan

**6.3 Dashboard Dinas**

- Aggregate data kabupaten
- Breakdown per puskesmas
- Peta sebaran stunting per kecamatan (optional, future enhancement)
- Export laporan Excel/PDF

---

## 4. CONSTRAINTS & NON-FUNCTIONAL REQUIREMENTS

### 4.1 Technical Constraints

**Stack (STRICT - No exceptions)**:

- ✅ Laravel 11 (monolith MVC)
- ✅ Blade templating (server-side rendering)
- ✅ Alpine.js (lightweight reactivity, max 50KB gzipped)
- ✅ Tailwind CSS (utility-first, no custom CSS framework)
- ✅ PostgreSQL 17 (single database, no sharding)
- ✅ File-based cache (`storage/framework/cache`) - NO Redis/Memcached
- ✅ DB-driven notifications (`notifications` table) - NO email/SMS/push
- ✅ Local storage + IndexedDB - NO external CDN
- ✅ Git deployment - NO Docker/Kubernetes

**Explicitly Forbidden**:

- ❌ Microservices architecture
- ❌ Redis, Memcached, or any cache server
- ❌ Email/SMS/WhatsApp integration
- ❌ Message brokers (RabbitMQ, Kafka, etc.)
- ❌ External APIs (except WHO JSON data - static file)
- ❌ Repository pattern (use Eloquent directly)
- ❌ SPA frameworks (React, Vue, Angular)
- ❌ GraphQL
- ❌ WebSockets

### 4.2 Performance Targets

**Response Time**:

- Dashboard load: < 2 seconds
- Form input save: < 1 second
- Chart rendering: < 1.5 seconds
- Offline sync queue: background job

**Scalability**:

- Support 100 kader concurrent users
- 10,000 anak records per tahun
- 120,000 measurement records per tahun (10k anak × 12 bulan)
- File cache size: < 100MB

**Mobile Performance**:

- PWA install size: < 5MB
- Offline cache: < 20MB
- Works on 3G connection (load time < 5s)
- Battery efficient (minimal background tasks)

### 4.3 Usability Requirements

**Target User**: Kader kesehatan (40-55 tahun, literasi digital rendah)

**UI/UX Principles**:

1. ✅ **Big buttons** - Minimum 48×48px touch target
2. ✅ **Large fonts** - Minimum 16px body text, 20px+ untuk heading
3. ✅ **High contrast** - WCAG AA compliance
4. ✅ **Minimal steps** - Maximum 3 clicks to any feature
5. ✅ **Clear labels** - Bahasa Indonesia sederhana, no jargon
6. ✅ **Visual feedback** - Loading states, success/error messages
7. ✅ **Forgiving input** - Auto-format, validation real-time
8. ✅ **Undo functionality** - Easy error recovery

**Mobile-First Design**:

- Optimize for 360×640px (common Android phone)
- Vertical scrolling preferred over horizontal
- Bottom navigation for primary actions
- Sticky header/footer for context

### 4.4 Security Requirements

**Authentication**:

- Laravel Breeze (simple auth scaffolding)
- Role-based access control (RBAC)
- Session timeout: 4 hours idle
- Password policy: min 8 chars, 1 uppercase, 1 number

**Data Protection**:

- HTTPS mandatory (SSL/TLS)
- SQL injection prevention (Eloquent ORM)
- CSRF tokens (Laravel default)
- XSS protection (Blade auto-escaping)
- No sensitive data in local storage (only sync queue IDs)

**Privacy**:

- NIK anak di-mask (show last 4 digits only untuk non-admin)
- Audit log untuk perubahan data sensitif
- Data retention policy (hapus setelah anak usia 6 tahun)

### 4.5 Browser & Device Support

**Minimum Requirements**:

- Chrome 90+ (Android)
- Safari 14+ (iOS)
- Firefox 88+
- Edge 90+
- **PWA support required** (Service Worker, Cache API, IndexedDB)

**Device**:

- Android 8.0+ (recommended 9.0+)
- iOS 14+
- Screen resolution: 360px - 1920px width
- Touch-enabled device

---

## 5. ASSUMPTIONS & RISKS

### 5.1 Assumptions

**Business Assumptions**:

1. ✅ Kader memiliki smartphone Android/iOS (provided by Dinas atau pribadi)
2. ✅ Posyandu memiliki timbangan bayi & infantometer (alat ukur tinggi badan)
3. ✅ Ada internet (meski lemah) di area puskesmas untuk sync data
4. ✅ Data WHO growth charts tersedia dalam format JSON (public domain)
5. ✅ Dinas Ketahanan Pangan menyediakan server hosting (VPS/cloud)
6. ✅ Training dasar smartphone akan diberikan ke kader sebelum go-live

**Technical Assumptions**:

1. ✅ PostgreSQL 17 compatible dengan hosting environment
2. ✅ Laravel 11 stabil untuk production (sudah release)
3. ✅ Service Worker API support di semua target browser
4. ✅ IndexedDB quota minimum 50MB tersedia di browser
5. ✅ Git workflow untuk deployment sudah di-setup

### 5.2 Risks & Mitigation

#### **Risk 1: User Adoption (HIGH)**

**Risk**: Kader gaptek menolak pakai aplikasi, prefer manual

**Mitigation**:

- UI/UX maksimal sederhana (3-click rule)
- Training hands-on 2 hari sebelum go-live
- Provide manual user guide (Bahasa Indonesia + gambar)
- Onboarding tutorial di dalam app (first-time user)
- Helpdesk via WhatsApp untuk support 24/7 (minggu pertama)

#### **Risk 2: Offline Sync Conflict (MEDIUM)**

**Risk**: Data conflict saat 2 kader edit anak yang sama secara offline

**Mitigation**:

- Last-write-wins strategy (timestamp based)
- Conflict detection UI (show warning jika ada conflict)
- Lock mechanism: 1 anak hanya bisa diedit 1 kader saat online
- Audit log untuk track semua changes

#### **Risk 3: Data Accuracy (MEDIUM)**

**Risk**: Kader salah input data (typo, salah anak, dll)

**Mitigation**:

- Input validation ketat (min/max values untuk BB, TB, LK)
- Auto-complete search untuk pilih anak (prevent typo nama)
- Confirmation screen sebelum save (review data)
- Edit history (bisa lihat & rollback data sebelumnya)
- Alert jika Z-score terlalu ekstrim (outlier detection)

#### **Risk 4: Server Downtime (LOW)**

**Risk**: Server hosting down, kader tidak bisa sync data

**Mitigation**:

- Offline-first architecture (app tetap jalan)
- Auto-retry sync dengan exponential backoff
- Queue system untuk pending uploads (Laravel queue worker)
- Backup server (optional, untuk production)
- Monitoring & alerting (Laravel Telescope - development only)

#### **Risk 5: WHO Chart Data Maintenance (LOW)**

**Risk**: WHO update growth charts, data jadi outdated

**Mitigation**:

- WHO charts disimpan sebagai versioned JSON files
- Artisan command untuk update charts: `php artisan who:update-charts`
- Version check saat app load (compare local vs server version)
- Graceful fallback jika chart version mismatch

#### **Risk 6: Storage Limitation (LOW)**

**Risk**: IndexedDB penuh, data offline tidak bisa disimpan

**Mitigation**:

- Auto-cleanup old cached data (> 7 hari)
- Compression untuk data pengukuran (JSON.stringify + gzip)
- Warning notification jika storage < 10MB
- Prioritize critical data (measurement > resep makanan)

---

## 6. SUCCESS METRICS (KPIs)

### 6.1 Adoption Metrics

- ✅ 90% kader aktif menggunakan app dalam 1 bulan pertama
- ✅ 80% data input dilakukan via app (vs manual) dalam 3 bulan
- ✅ Rata-rata 95% data anak ter-update setiap bulan

### 6.2 Operational Metrics

- ✅ Lag time data ke Dinas: dari 1-2 bulan → **real-time**
- ✅ Accuracy rate: < 5% error rate pada data entry
- ✅ System uptime: > 99% (max 7 jam downtime per bulan)

### 6.3 Health Impact Metrics (Long-term)

- ✅ Deteksi dini stunting: dari 2-3 bulan delay → **0 bulan** (real-time)
- ✅ Follow-up rate kasus gizi buruk: dari 60% → **> 90%**
- ✅ Prevalensi stunting kabupaten turun **5% dalam 1 tahun**

---

## 7. PROJECT TIMELINE (Estimasi)

### Phase 1: Setup & Design (Week 1-2)

- Setup Laravel 11 + PostgreSQL + Tailwind
- Database schema design & migration
- UI/UX wireframe & mockup
- WHO growth charts integration (JSON)

### Phase 2: Core Development (Week 3-5)

- Auth & RBAC implementation
- CRUD data master (Ibu, Anak, Posyandu)
- Form input pengukuran + Z-score calculation
- WHO growth charts rendering (Chart.js)

### Phase 3: Advanced Features (Week 6-7)

- Resep makanan CRUD
- Notification system (DB-driven)
- Dashboard & reporting
- PWA implementation (Service Worker, offline sync)

### Phase 4: Testing & Deployment (Week 8)

- Unit testing (PHPUnit)
- Browser testing (Chrome, Safari, Firefox)
- UAT dengan sample kader (5-10 orang)
- Deployment ke production server

### Phase 5: Training & Go-Live (Week 9-10)

- Training kader (2 hari)
- Soft launch (1 puskesmas pilot)
- Bug fixing & adjustment
- Full rollout kabupaten

---

## 8. OUT OF SCOPE (Future Enhancements)

**Tidak termasuk dalam MVP ini**:

- ❌ Integration dengan sistem BPJS/e-Health
- ❌ Fitur telemedicine/konsultasi online
- ❌ SMS/Email/WhatsApp notifications (hanya in-app)
- ❌ Peta geografis sebaran stunting (GIS)
- ❌ Machine learning prediction stunting
- ❌ Import data dari KIA digital (manual input dulu)
- ❌ Multi-language support (Bahasa Indonesia only)
- ❌ Dark mode UI (light mode only)

---

**END OF SRS DOCUMENT**

---
