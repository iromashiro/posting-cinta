# LAPORAN PENDAHULUAN PROYEK

## SISTEM INFORMASI POSYANDU "POSTING CINTA"

### Monitoring Stunting dan Gizi Anak Berbasis Progressive Web Application (PWA)

---

<div align="center">

**LAPORAN PENDAHULUAN**

**PENGEMBANGAN APLIKASI POSTING CINTA**
**KABUPATEN MUARA ENIM**

---

**Versi Dokumen**: 1.0  
**Tanggal**: 3 Maret 2025  
**Status**: Draft Final

---

**Tim Pengembang:**

**CV Alaska Sitrix Kreasi**

---

**Disusun untuk:**

**Dinas Ketahanan Pangan Kabupaten Muara Enim**
**Provinsi Sumatera Selatan**

</div>

---

## DAFTAR ISI

1. [Pendahuluan](#1-pendahuluan)
2. [Latar Belakang](#2-latar-belakang)
3. [Identifikasi Masalah](#3-identifikasi-masalah)
4. [Tujuan dan Sasaran Proyek](#4-tujuan-dan-sasaran-proyek)
5. [Ruang Lingkup Pengembangan](#5-ruang-lingkup-pengembangan)
6. [Metodologi Pengembangan](#6-metodologi-pengembangan)
7. [Rencana Jadwal Pengembangan](#7-rencana-jadwal-pengembangan)
8. [Tim Pengembang](#8-tim-pengembang)
9. [Analisis Kebutuhan Awal](#9-analisis-kebutuhan-awal)
10. [Penutup](#10-penutup)

---

## 1. PENDAHULUAN

### 1.1 Gambaran Umum Proyek

Proyek **"Posting Cinta"** (Posyandu Monitoring Stunting dan Gizi Anak) merupakan sebuah inisiatif pengembangan sistem informasi berbasis Progressive Web Application (PWA) yang dirancang khusus untuk mendukung kegiatan monitoring pertumbuhan dan status gizi anak di Kabupaten Muara Enim, Provinsi Sumatera Selatan.

Aplikasi ini dikembangkan sebagai solusi digital untuk membantu para kader posyandu dalam melakukan pencatatan, pemantauan, dan pelaporan data pertumbuhan anak secara real-time dengan kemampuan bekerja secara offline (offline-first), sehingga sangat cocok untuk digunakan di daerah dengan keterbatasan akses internet.

### 1.2 Informasi Dokumen

| Atribut            | Keterangan                                  |
| ------------------ | ------------------------------------------- |
| Nama Proyek        | Posting Cinta - PWA Monitoring Stunting     |
| Versi Dokumen      | 1.0                                         |
| Tanggal Penyusunan | 3 Maret 2025                                |
| Disiapkan Oleh     | Tim Pengembang CV Alaska Sitrix Kreasi      |
| Untuk              | Dinas Ketahanan Pangan Kabupaten Muara Enim |
| Jenis Dokumen      | Laporan Pendahuluan/Proposal Teknis         |

### 1.3 Referensi Dokumen

Dokumen ini disusun berdasarkan referensi berikut:

1. **System Requirements Specification (SRS)** - Spesifikasi kebutuhan sistem lengkap
2. **Database Schema Design** - Perancangan struktur database dan ERD
3. **System Architecture Design** - Arsitektur sistem PWA offline-first
4. **WHO Growth Standards** - Standar pertumbuhan WHO untuk kalkulasi Z-score
5. **UI/UX Design Guidelines** - Panduan desain antarmuka pengguna

---

## 2. LATAR BELAKANG

### 2.1 Kondisi Stunting di Indonesia

Stunting merupakan kondisi gagal tumbuh pada anak balita akibat kekurangan gizi kronis sehingga anak terlalu pendek untuk usianya. Stunting dapat terjadi sejak janin dalam kandungan dan baru terlihat saat anak berusia dua tahun. Berdasarkan data Survei Status Gizi Indonesia (SSGI), prevalensi stunting di Indonesia masih menjadi perhatian serius dengan target penurunan yang ambisius.

### 2.2 Kondisi di Kabupaten Muara Enim

Kabupaten Muara Enim sebagai salah satu kabupaten di Provinsi Sumatera Selatan memiliki tantangan tersendiri dalam penanganan stunting, antara lain:

-   **Geografis**: Wilayah yang luas dengan akses ke beberapa daerah yang sulit dijangkau
-   **Infrastruktur Digital**: Keterbatasan jaringan internet di beberapa kecamatan
-   **Sumber Daya Manusia**: Kader posyandu dengan tingkat literasi digital yang bervariasi
-   **Sistem Pencatatan**: Masih mengandalkan pencatatan manual yang rentan terhadap kesalahan dan keterlambatan pelaporan

### 2.3 Proses Pencatatan Saat Ini (AS-IS)

Berdasarkan analisis situasi yang dilakukan, proses pencatatan data pertumbuhan anak saat ini memiliki alur sebagai berikut:

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
```

### 2.4 Kebutuhan akan Solusi Digital

Melihat kondisi di atas, diperlukan sebuah solusi teknologi informasi yang:

1. **Mudah digunakan** oleh kader dengan berbagai tingkat literasi digital
2. **Dapat bekerja offline** untuk mengakomodasi keterbatasan jaringan internet
3. **Menyediakan analisis otomatis** untuk deteksi dini stunting berdasarkan standar WHO
4. **Mendukung pelaporan real-time** untuk pengambilan keputusan yang lebih cepat
5. **Terintegrasi** dari tingkat posyandu hingga Dinas Ketahanan Pangan

---

## 3. IDENTIFIKASI MASALAH

### 3.1 Permasalahan Utama

Berdasarkan analisis mendalam terhadap proses bisnis yang berjalan, teridentifikasi beberapa permasalahan kritis berikut:

#### 3.1.1 Duplikasi Data Entry

-   Kader harus mencatat data di buku KIA, kemudian memindahkan ke form Excel atau kertas rekapitulasi
-   Proses ini memakan waktu dan berpotensi menimbulkan kesalahan transkripsi
-   Tidak efisien dari segi waktu dan tenaga kader

#### 3.1.2 Lag Time Tinggi dalam Pelaporan

-   Data dari posyandu membutuhkan waktu 1-2 bulan untuk sampai ke Dinas
-   Keterlambatan ini menghambat intervensi dini terhadap kasus stunting
-   Keputusan kebijakan diambil berdasarkan data yang sudah tidak aktual

#### 3.1.3 Tingkat Kesalahan Manusia (Human Error)

-   Kesalahan perhitungan saat menghitung usia anak dalam bulan
-   Kesalahan penulisan atau pembacaan angka pengukuran
-   Data tidak akurat mempengaruhi kualitas analisis status gizi

#### 3.1.4 Tidak Ada Monitoring Real-Time

-   Tidak tersedia grafik pertumbuhan anak secara visual
-   Sulit mendeteksi tren penurunan atau peningkatan berat/tinggi badan
-   Kader kesulitan mengidentifikasi anak yang berisiko stunting

#### 3.1.5 Keterbatasan Akses Offline

-   Banyak posyandu berlokasi di daerah dengan sinyal internet lemah
-   Kader tidak dapat input data saat kegiatan posyandu berlangsung
-   Data sering terlambat diinput karena harus menunggu koneksi tersedia

#### 3.1.6 Komunikasi dan Koordinasi Tidak Efisien

-   Koordinasi antara kader, puskesmas, dan dinas melalui WhatsApp yang tidak terstruktur
-   Reminder jadwal posyandu dilakukan manual
-   Tidak ada sistem notifikasi otomatis untuk kasus-kasus kritis

### 3.2 Dampak Permasalahan

| Permasalahan                   | Dampak                                                   |
| ------------------------------ | -------------------------------------------------------- |
| Duplikasi data entry           | Beban kerja kader tinggi, waktu terbuang                 |
| Lag time pelaporan             | Keterlambatan intervensi, stunting tidak tertangani dini |
| Human error                    | Data tidak valid, analisis tidak akurat                  |
| Tidak ada monitoring real-time | Deteksi stunting terlambat                               |
| Keterbatasan offline           | Produktivitas kader terganggu                            |
| Komunikasi tidak efisien       | Koordinasi buruk, kasus terabaikan                       |

### 3.3 Kebutuhan Solusi

Berdasarkan identifikasi masalah di atas, dibutuhkan solusi dengan karakteristik:

1. ✅ **Single Data Entry** - Input data sekali, langsung tersimpan di sistem
2. ✅ **Real-time Sync** - Data tersinkronisasi secara real-time ke semua level
3. ✅ **Auto-calculation** - Perhitungan Z-score otomatis berdasarkan standar WHO
4. ✅ **Visual Growth Charts** - Grafik pertumbuhan anak yang mudah dipahami
5. ✅ **Offline-First** - Dapat bekerja tanpa koneksi internet
6. ✅ **Smart Notifications** - Notifikasi otomatis untuk jadwal dan kasus kritis

---

## 4. TUJUAN DAN SASARAN PROYEK

### 4.1 Tujuan Umum

Mengembangkan sistem informasi Posyandu berbasis Progressive Web Application (PWA) yang mampu mendukung kegiatan monitoring stunting dan gizi anak di Kabupaten Muara Enim secara efektif, efisien, dan real-time.

### 4.2 Tujuan Khusus

#### 4.2.1 Tujuan Teknis

-   Membangun aplikasi PWA dengan kemampuan offline-first
-   Mengimplementasikan standar pertumbuhan WHO untuk kalkulasi Z-score
-   Menyediakan visualisasi grafik pertumbuhan anak yang interaktif
-   Membangun sistem notifikasi berbasis database untuk koordinasi

#### 4.2.2 Tujuan Operasional

-   Menyederhanakan proses input data pengukuran anak
-   Mengotomatisasi perhitungan status gizi berdasarkan indikator WHO
-   Mempercepat proses pelaporan dari posyandu ke dinas
-   Meningkatkan akurasi data pertumbuhan anak

#### 4.2.3 Tujuan Strategis

-   Mendukung program penurunan prevalensi stunting di Kabupaten Muara Enim
-   Menyediakan data real-time untuk pengambilan keputusan kebijakan
-   Meningkatkan efektivitas intervensi gizi melalui deteksi dini

### 4.3 Sasaran Proyek

#### 4.3.1 Sasaran Jangka Pendek (0-3 Bulan)

| No  | Sasaran             | Indikator                                  |
| --- | ------------------- | ------------------------------------------ |
| 1   | Deployment aplikasi | Aplikasi live dan dapat diakses            |
| 2   | Adopsi kader        | 90% kader aktif menggunakan aplikasi       |
| 3   | Data entry via app  | 80% data diinput melalui aplikasi          |
| 4   | Waktu pelaporan     | Data tersedia real-time di dashboard dinas |

#### 4.3.2 Sasaran Jangka Menengah (3-12 Bulan)

| No  | Sasaran           | Indikator                              |
| --- | ----------------- | -------------------------------------- |
| 1   | Akurasi data      | Error rate < 5%                        |
| 2   | Follow-up kasus   | > 90% kasus gizi buruk ditindaklanjuti |
| 3   | System uptime     | > 99% (max 7 jam downtime/bulan)       |
| 4   | User satisfaction | SUS score > 70                         |

#### 4.3.3 Sasaran Jangka Panjang (> 12 Bulan)

| No  | Sasaran             | Indikator                       |
| --- | ------------------- | ------------------------------- |
| 1   | Prevalensi stunting | Turun 5% dalam 1 tahun          |
| 2   | Deteksi dini        | 100% kasus terdeteksi < 1 bulan |
| 3   | Digitalisasi        | 100% posyandu terintegrasi      |

### 4.4 Key Performance Indicators (KPIs)

**Adoption Metrics:**

-   90% kader aktif menggunakan app dalam 1 bulan pertama
-   80% data input dilakukan via app dalam 3 bulan
-   Rata-rata 95% data anak ter-update setiap bulan

**Operational Metrics:**

-   Lag time data ke Dinas: dari 1-2 bulan → **real-time**
-   Accuracy rate: < 5% error rate pada data entry
-   System uptime: > 99%

**Health Impact Metrics:**

-   Deteksi dini stunting: dari 2-3 bulan delay → **0 bulan** (real-time)
-   Follow-up rate kasus gizi buruk: dari 60% → **> 90%**
-   Prevalensi stunting kabupaten turun **5% dalam 1 tahun**

---

## 5. RUANG LINGKUP PENGEMBANGAN

### 5.1 Cakupan Fungsional

#### 5.1.1 Modul Manajemen Pengguna

**Fitur yang dikembangkan:**

-   Autentikasi pengguna (login/logout)
-   Role-based access control (RBAC) dengan 3 role: Admin, Puskesmas, Kader
-   Manajemen profil pengguna
-   Audit trail aktivitas pengguna

**Role dan Hak Akses:**

| Role                    | Deskripsi                     | Hak Akses                                                      |
| ----------------------- | ----------------------------- | -------------------------------------------------------------- |
| **Admin Dinas**         | Pengelola tingkat kabupaten   | Dashboard kabupaten, manage user, manage resep, export laporan |
| **Pengelola Puskesmas** | Koordinator tingkat puskesmas | Dashboard puskesmas, manage kader, monitor kasus               |
| **Kader Posyandu**      | Petugas di lapangan           | Input data, view grafik, manage data ibu & anak                |

#### 5.1.2 Modul Data Master

**1. Data Puskesmas**

-   Kode puskesmas (unik)
-   Nama puskesmas
-   Alamat lengkap
-   Kecamatan
-   Nomor telepon
-   Status aktif

**2. Data Posyandu**

-   Kode posyandu (unik)
-   Nama posyandu
-   Relasi ke puskesmas induk
-   Kader pengelola
-   Alamat lengkap (RT/RW/Desa/Kecamatan)
-   Jadwal rutin bulanan

**3. Data Ibu**

-   NIK (unik)
-   Nama lengkap
-   Tanggal lahir
-   Nomor HP (opsional)
-   Alamat lengkap
-   Posyandu tempat terdaftar

**4. Data Anak**

-   NIK (opsional untuk bayi baru lahir)
-   Nama lengkap
-   Jenis kelamin (penting untuk WHO charts)
-   Tanggal lahir
-   Relasi ke data ibu (1 ibu → N anak)
-   Posyandu tempat terdaftar
-   Status aktif

#### 5.1.3 Modul Pengukuran Pertumbuhan

**Input Pengukuran:**

-   Pemilihan anak (autocomplete search)
-   Tanggal pengukuran
-   Berat badan (kg, 1 desimal)
-   Tinggi badan (cm, 1 desimal)
-   Lingkar kepala (cm, opsional)
-   Catatan tambahan

**Kalkulasi Otomatis:**

-   Umur anak dalam bulan
-   Z-score BB/U (Weight-for-Age)
-   Z-score TB/U (Height-for-Age)
-   Z-score BB/TB (Weight-for-Height)
-   Status gizi (normal/stunting/wasting/underweight)

**Klasifikasi Status Gizi:**
| Status | Kriteria |
|--------|----------|
| Normal | Semua Z-score ≥ -2 SD |
| Stunting | TB/U < -2 SD |
| Severely Stunted | TB/U < -3 SD |
| Wasting | BB/TB < -2 SD |
| Severely Wasted | BB/TB < -3 SD |
| Underweight | BB/U < -2 SD |

#### 5.1.4 Modul Grafik Pertumbuhan WHO

**Jenis Grafik:**

1. Weight-for-Age (Berat Badan menurut Umur)
2. Height-for-Age (Tinggi Badan menurut Umur)
3. Weight-for-Height (Berat Badan menurut Tinggi Badan)

**Fitur Grafik:**

-   Kurva WHO untuk laki-laki dan perempuan terpisah
-   Plotting data pengukuran anak
-   Garis standar deviasi (-3 SD, -2 SD, Median, +2 SD, +3 SD)
-   Indikator warna (hijau = normal, kuning = risiko, merah = kritis)
-   Interactive tooltips

#### 5.1.5 Modul Resep Makanan Sehat

**Kategori Resep:**

-   MPASI (6-12 bulan)
-   Balita (1-3 tahun)
-   Anak (3-5 tahun)

**Informasi Resep:**

-   Judul dan foto
-   Bahan-bahan
-   Cara membuat
-   Informasi gizi (kalori, protein, karbohidrat)
-   Search dan filter

#### 5.1.6 Modul Notifikasi

**Jenis Notifikasi:**

-   Reminder jadwal posyandu (H-3, H-1, H-0)
-   Alert deteksi gizi buruk
-   Reminder input data
-   Laporan bulanan

**Delivery:**

-   In-app notifications
-   Badge counter
-   Mark as read

#### 5.1.7 Modul Dashboard dan Reporting

**Dashboard Kader:**

-   Total anak di posyandu
-   Statistik status gizi
-   Anak yang belum diukur bulan ini
-   Jadwal posyandu berikutnya

**Dashboard Puskesmas:**

-   Aggregate data dari semua kader
-   Breakdown per posyandu
-   Ranking posyandu berdasarkan kasus stunting
-   Tren per bulan

**Dashboard Dinas:**

-   Aggregate data kabupaten
-   Breakdown per puskesmas
-   Peta sebaran (future enhancement)
-   Export laporan Excel/PDF

### 5.2 Cakupan Non-Fungsional

#### 5.2.1 Progressive Web Application (PWA)

-   Installable di smartphone
-   Offline-first architecture
-   Background sync untuk data offline
-   Push notification (future)

#### 5.2.2 Offline Capability

-   Input data tanpa koneksi internet
-   Cache static assets
-   Auto-sync saat online kembali
-   Conflict resolution

#### 5.2.3 Performance

-   Dashboard load: < 2 detik
-   Form input save: < 1 detik
-   Chart rendering: < 1.5 detik

#### 5.2.4 Scalability

-   Support 100 kader concurrent
-   10,000 anak records per tahun
-   120,000 measurement records per tahun

### 5.3 Batasan Ruang Lingkup

**Tidak termasuk dalam scope proyek ini:**

| No  | Item                             | Keterangan                      |
| --- | -------------------------------- | ------------------------------- |
| 1   | Integrasi dengan BPJS/e-Health   | Kompleksitas integrasi tinggi   |
| 2   | Fitur telemedicine               | Diluar core function monitoring |
| 3   | SMS/Email/WhatsApp notifications | Hanya in-app notification       |
| 4   | Peta geografis (GIS)             | Future enhancement              |
| 5   | Machine learning prediction      | Future enhancement              |
| 6   | Import data KIA digital          | Manual input dulu               |
| 7   | Multi-language support           | Bahasa Indonesia only           |
| 8   | Dark mode UI                     | Light mode only                 |

---

## 6. METODOLOGI PENGEMBANGAN

### 6.1 Pendekatan Pengembangan

Proyek ini menggunakan pendekatan **Agile Software Development** dengan framework **Scrum** yang dimodifikasi untuk kebutuhan proyek. Pendekatan ini dipilih karena:

1. **Fleksibilitas** - Memungkinkan perubahan requirement selama pengembangan
2. **Iterative** - Deliverable bertahap sehingga stakeholder dapat memberikan feedback
3. **Transparency** - Progress terlihat jelas melalui sprint deliverables
4. **Quality Focus** - Testing terintegrasi dalam setiap sprint

### 6.2 Fase Pengembangan

#### Fase 1: Inception & Planning (Minggu 1-2)

**Aktivitas:**

-   Requirement gathering dan analisis
-   Stakeholder interviews
-   Business process mapping
-   Technical architecture design
-   Database schema design
-   UI/UX wireframing
-   Sprint planning

**Deliverables:**

-   System Requirements Specification (SRS)
-   Database Schema Design (ERD)
-   System Architecture Design
-   UI/UX Wireframes
-   Project plan dan timeline

#### Fase 2: Core Development (Minggu 3-5)

**Sprint 1 (Week 3):**

-   Project setup (Laravel 11, PostgreSQL)
-   Database migrations
-   Authentication & RBAC
-   Seeder untuk WHO growth standards

**Sprint 2 (Week 4):**

-   CRUD Data Master (Puskesmas, Posyandu, Mothers, Children)
-   Form input pengukuran
-   Z-score calculation service
-   Basic dashboard

**Sprint 3 (Week 5):**

-   Growth charts dengan Chart.js
-   Nutrition status classification
-   Data validation & error handling

#### Fase 3: Advanced Features (Minggu 6-7)

**Sprint 4 (Week 6):**

-   Recipe management
-   Notification system
-   Dashboard analytics
-   Role-based dashboard views

**Sprint 5 (Week 7):**

-   PWA implementation
-   Service Worker setup
-   Offline data storage (IndexedDB)
-   Background sync

#### Fase 4: Testing & Quality Assurance (Minggu 8)

**Aktivitas:**

-   Unit testing (PHPUnit)
-   Feature testing
-   Integration testing
-   Browser compatibility testing
-   PWA installation testing
-   Offline functionality testing
-   User Acceptance Testing (UAT)

**Deliverables:**

-   Test reports
-   Bug fix releases
-   Performance optimization

#### Fase 5: Deployment & Training (Minggu 9-10)

**Aktivitas:**

-   Server setup dan konfigurasi
-   Production deployment
-   SSL certificate installation
-   Training untuk kader pilot
-   User guide documentation
-   Soft launch
-   Full rollout

**Deliverables:**

-   Production environment
-   User training materials
-   Operation manual

### 6.3 Tools dan Teknologi

**Development:**

-   IDE: Visual Studio Code
-   Version Control: Git (GitHub/GitLab)
-   Package Manager: Composer (PHP), NPM (JavaScript)
-   Build Tool: Vite

**Testing:**

-   Unit Testing: PHPUnit
-   Browser Testing: Manual + Puppeteer
-   API Testing: Postman

**Project Management:**

-   Task Management: Jira / Trello
-   Documentation: Notion / Confluence
-   Communication: Slack / Teams

---

## 7. RENCANA JADWAL PENGEMBANGAN

### 7.1 Timeline Overview

```
┌──────────────────────────────────────────────────────────────────────────┐
│                    TIMELINE PROYEK (10 Minggu)                            │
├──────────────────────────────────────────────────────────────────────────┤
│                                                                           │
│  Minggu    1    2    3    4    5    6    7    8    9    10               │
│           ┌────┬────┬────┬────┬────┬────┬────┬────┬────┬────┐            │
│  Phase 1  │████│████│    │    │    │    │    │    │    │    │ Planning   │
│  Phase 2  │    │    │████│████│████│    │    │    │    │    │ Core Dev   │
│  Phase 3  │    │    │    │    │    │████│████│    │    │    │ Advanced   │
│  Phase 4  │    │    │    │    │    │    │    │████│    │    │ Testing    │
│  Phase 5  │    │    │    │    │    │    │    │    │████│████│ Deploy     │
│           └────┴────┴────┴────┴────┴────┴────┴────┴────┴────┘            │
│                                                                           │
│  Periode: Maret - Mei 2025                                                │
│                                                                           │
└──────────────────────────────────────────────────────────────────────────┘
```

### 7.2 Detail Jadwal Per Fase

| Fase                           | Periode   | Durasi   | Milestone                            |
| ------------------------------ | --------- | -------- | ------------------------------------ |
| **Phase 1: Planning**          | Week 1-2  | 2 minggu | SRS, ERD, Architecture approved      |
| **Phase 2: Core Development**  | Week 3-5  | 3 minggu | MVP ready (input, Z-score, charts)   |
| **Phase 3: Advanced Features** | Week 6-7  | 2 minggu | PWA, notifications, recipes complete |
| **Phase 4: Testing**           | Week 8    | 1 minggu | All tests passed, UAT approved       |
| **Phase 5: Deployment**        | Week 9-10 | 2 minggu | Production live, training complete   |

### 7.3 Milestone Deliverables

| Milestone                | Target Date      | Deliverables                                         |
| ------------------------ | ---------------- | ---------------------------------------------------- |
| **M1: Design Complete**  | Mid Maret 2025   | SRS, ERD, Architecture, Wireframes                   |
| **M2: MVP Ready**        | Awal April 2025  | Core features working (measurement, Z-score, charts) |
| **M3: Feature Complete** | Mid April 2025   | All features implemented including PWA               |
| **M4: Testing Complete** | Akhir April 2025 | All tests passed, bugs fixed                         |
| **M5: Production Ready** | Mid Mei 2025     | Application deployed, users trained                  |

### 7.4 Critical Path

1. Database schema design → Migrations → Core models
2. Z-score calculation service → Measurement input → Charts
3. Service Worker → Offline storage → Background sync
4. UAT → Bug fixes → Production deployment

---

## 8. TIM PENGEMBANG

### 8.1 Struktur Organisasi Tim

```
                    ┌─────────────────────┐
                    │   Project Manager   │
                    │   CV Alaska Sitrix  │
                    │       Kreasi        │
                    └──────────┬──────────┘
                               │
          ┌────────────────────┼────────────────────┐
          │                    │                    │
          ▼                    ▼                    ▼
┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐
│ Technical Lead  │  │   UI/UX Lead    │  │    QA Lead      │
│ CV Alaska Sitrix│  │  CV Alaska Sitrix│  │  CV Alaska Sitrix│
└────────┬────────┘  └────────┬────────┘  └────────┬────────┘
         │                    │                    │
    ┌────┴────┐          ┌────┴────┐          ┌────┴────┐
    ▼         ▼          ▼         ▼          ▼         ▼
┌───────┐ ┌───────┐  ┌───────┐ ┌───────┐  ┌───────┐ ┌───────┐
│Backend│ │Frontend│  │Designer│ │Designer│  │ Tester│ │ Tester│
│ Dev   │ │  Dev   │  │       │ │       │  │       │ │       │
└───────┘ └───────┘  └───────┘ └───────┘  └───────┘ └───────┘
```

### 8.2 Profil Tim

| No  | Peran                                  | Tanggung Jawab                                                               |
| --- | -------------------------------------- | ---------------------------------------------------------------------------- |
| 1   | **Project Manager**                    | Overall project coordination, stakeholder communication, timeline management |
| 2   | **Technical Lead / Backend Developer** | Architecture design, Laravel development, database design, code review       |
| 3   | **UI/UX Lead**                         | User research, wireframing, prototyping, design system                       |
| 4   | **QA Lead**                            | Test planning, test execution, quality assurance                             |
| 5   | **Backend Developer**                  | API development, service implementation, database optimization               |
| 6   | **Frontend Developer**                 | Blade templates, Alpine.js, PWA implementation                               |
| 7   | **UI Designer**                        | Visual design, icons, illustrations                                          |
| 8   | **UX Designer**                        | User flow, interaction design, usability testing                             |
| 9   | **QA Engineer**                        | Manual testing, test case writing, bug reporting                             |
| 10  | **QA Engineer**                        | Automated testing, performance testing                                       |

**Semua tim merupakan bagian dari CV Alaska Sitrix Kreasi**

### 8.3 Alokasi Waktu Tim

| Tim Member      | Alokasi | Minggu 1-2    | Minggu 3-5   | Minggu 6-7   | Minggu 8  | Minggu 9-10        |
| --------------- | ------- | ------------- | ------------ | ------------ | --------- | ------------------ |
| Project Manager | 100%    | Planning      | Coordination | Coordination | UAT       | Deployment         |
| Technical Lead  | 100%    | Architecture  | Development  | Development  | Support   | Deployment         |
| Backend Dev     | 100%    | Setup         | Core Dev     | Advanced     | Bug fixes | Support            |
| Frontend Dev    | 100%    | Mockup review | UI Dev       | PWA          | Bug fixes | Support            |
| UI/UX Lead      | 50%     | Wireframes    | Review       | Review       | -         | Training materials |
| QA Lead         | 50%     | Test planning | -            | Test prep    | Testing   | Final QA           |
| QA Engineers    | 100%    | -             | -            | -            | Testing   | Final QA           |

### 8.4 RACI Matrix

| Aktivitas    | PM  | Tech Lead | Backend | Frontend | UI/UX | QA  |
| ------------ | --- | --------- | ------- | -------- | ----- | --- |
| Requirements | A   | C         | C       | C        | C     | I   |
| Architecture | C   | A/R       | R       | R        | C     | I   |
| UI/UX Design | I   | C         | I       | C        | A/R   | I   |
| Backend Dev  | I   | A         | R       | I        | I     | I   |
| Frontend Dev | I   | A         | C       | R        | C     | I   |
| Testing      | C   | C         | C       | C        | I     | A/R |
| Deployment   | A   | R         | R       | R        | I     | R   |

_R = Responsible, A = Accountable, C = Consulted, I = Informed_

---

## 9. ANALISIS KEBUTUHAN AWAL

### 9.1 Kebutuhan Fungsional

#### 9.1.1 Kebutuhan Autentikasi dan Otorisasi

| ID     | Requirement                                                    | Priority | Status  |
| ------ | -------------------------------------------------------------- | -------- | ------- |
| FR-001 | Sistem harus menyediakan fitur login dengan email dan password | High     | Defined |
| FR-002 | Sistem harus mendukung 3 role: Admin, Puskesmas, Kader         | High     | Defined |
| FR-003 | Setiap role memiliki hak akses yang berbeda                    | High     | Defined |
| FR-004 | Session timeout setelah 4 jam idle                             | Medium   | Defined |
| FR-005 | Password minimal 8 karakter dengan 1 uppercase dan 1 angka     | Medium   | Defined |

#### 9.1.2 Kebutuhan Manajemen Data Master

| ID     | Requirement                                            | Priority | Status  |
| ------ | ------------------------------------------------------ | -------- | ------- |
| FR-010 | Admin dapat melakukan CRUD data puskesmas              | High     | Defined |
| FR-011 | Admin/Puskesmas dapat melakukan CRUD data posyandu     | High     | Defined |
| FR-012 | Kader dapat melakukan CRUD data ibu di posyandunya     | High     | Defined |
| FR-013 | Kader dapat melakukan CRUD data anak di posyandunya    | High     | Defined |
| FR-014 | Satu ibu dapat memiliki banyak anak (1:N relationship) | High     | Defined |

#### 9.1.3 Kebutuhan Input Pengukuran

| ID     | Requirement                                        | Priority | Status  |
| ------ | -------------------------------------------------- | -------- | ------- |
| FR-020 | Kader dapat input data pengukuran (BB, TB, LK)     | High     | Defined |
| FR-021 | Sistem otomatis menghitung usia anak dalam bulan   | High     | Defined |
| FR-022 | Sistem otomatis menghitung Z-score berdasarkan WHO | High     | Defined |
| FR-023 | Sistem otomatis menentukan status gizi             | High     | Defined |
| FR-024 | Input pengukuran dapat dilakukan offline           | High     | Defined |
| FR-025 | Data offline auto-sync saat online                 | High     | Defined |

#### 9.1.4 Kebutuhan Grafik Pertumbuhan

| ID     | Requirement                                   | Priority | Status  |
| ------ | --------------------------------------------- | -------- | ------- |
| FR-030 | Sistem menampilkan grafik BB/U, TB/U, BB/TB   | High     | Defined |
| FR-031 | Grafik terpisah untuk laki-laki dan perempuan | High     | Defined |
| FR-032 | Grafik menampilkan kurva WHO standar          | High     | Defined |
| FR-033 | Grafik interaktif dengan tooltips             | Medium   | Defined |

#### 9.1.5 Kebutuhan Notifikasi

| ID     | Requirement                                   | Priority | Status  |
| ------ | --------------------------------------------- | -------- | ------- |
| FR-040 | Sistem mengirim reminder jadwal posyandu      | Medium   | Defined |
| FR-041 | Sistem mengirim alert saat deteksi gizi buruk | High     | Defined |
| FR-042 | Sistem mengirim reminder input data           | Medium   | Defined |
| FR-043 | Notifikasi berbasis database (in-app only)    | High     | Defined |

### 9.2 Kebutuhan Non-Fungsional

#### 9.2.1 Performance Requirements

| ID      | Requirement             | Target      |
| ------- | ----------------------- | ----------- |
| NFR-001 | Dashboard load time     | < 2 detik   |
| NFR-002 | Form save response time | < 1 detik   |
| NFR-003 | Chart rendering time    | < 1.5 detik |
| NFR-004 | PWA install size        | < 5 MB      |
| NFR-005 | Offline cache size      | < 20 MB     |

#### 9.2.2 Scalability Requirements

| ID      | Requirement            | Target          |
| ------- | ---------------------- | --------------- |
| NFR-010 | Concurrent users       | 100 kader       |
| NFR-011 | Data anak per tahun    | 10,000 records  |
| NFR-012 | Measurements per tahun | 120,000 records |

#### 9.2.3 Usability Requirements

| ID      | Requirement               | Criteria       |
| ------- | ------------------------- | -------------- |
| NFR-020 | Touch target minimum      | 48×48 px       |
| NFR-021 | Font size minimum         | 16px body text |
| NFR-022 | Maximum clicks to feature | 3 clicks       |
| NFR-023 | WCAG compliance           | Level AA       |

#### 9.2.4 Security Requirements

| ID      | Requirement              | Implementation      |
| ------- | ------------------------ | ------------------- |
| NFR-030 | HTTPS mandatory          | SSL/TLS certificate |
| NFR-031 | SQL injection prevention | Eloquent ORM        |
| NFR-032 | CSRF protection          | Laravel CSRF tokens |
| NFR-033 | XSS protection           | Blade auto-escaping |

### 9.3 Kebutuhan Teknis

#### 9.3.1 Technology Stack

| Layer             | Technology                 | Version |
| ----------------- | -------------------------- | ------- |
| **Backend**       | Laravel                    | 11.x    |
| **Database**      | PostgreSQL                 | 17      |
| **Frontend**      | Blade + Alpine.js          | Latest  |
| **CSS Framework** | Tailwind CSS               | 3.x     |
| **Chart Library** | Chart.js                   | 4.x     |
| **PWA**           | Service Worker + IndexedDB | -       |

#### 9.3.2 Browser Support

| Browser          | Minimum Version |
| ---------------- | --------------- |
| Chrome (Android) | 90+             |
| Safari (iOS)     | 14+             |
| Firefox          | 88+             |
| Edge             | 90+             |

#### 9.3.3 Device Support

| Platform | Minimum Requirement  |
| -------- | -------------------- |
| Android  | 8.0+                 |
| iOS      | 14+                  |
| Screen   | 360px - 1920px width |

### 9.4 Kebutuhan Data

#### 9.4.1 WHO Growth Standards Data

Sistem membutuhkan data standar pertumbuhan WHO yang mencakup:

-   Height-for-Age (0-60 bulan)
-   Weight-for-Age (0-60 bulan)
-   Weight-for-Height (45-120 cm)
-   Terpisah untuk laki-laki dan perempuan
-   Mencakup nilai L, M, S untuk kalkulasi Z-score
-   Pre-calculated SD values (-3, -2, -1, 0, +1, +2, +3)

**Estimasi jumlah records:** ~3,600 records

#### 9.4.2 Sample Data Requirements

Untuk testing dan demonstrasi, dibutuhkan:

-   3 sample puskesmas
-   10 sample posyandu
-   20 sample data ibu
-   30 sample data anak
-   50 sample data pengukuran
-   30 sample resep makanan

---

## 10. PENUTUP

### 10.1 Ringkasan

Laporan pendahuluan ini telah menguraikan secara komprehensif tentang rencana pengembangan aplikasi **Posting Cinta** - sebuah Progressive Web Application untuk monitoring stunting dan gizi anak di Kabupaten Muara Enim.

Proyek ini diharapkan dapat memberikan solusi terhadap permasalahan yang dihadapi dalam proses monitoring pertumbuhan anak, yaitu:

1. **Menghilangkan duplikasi data entry** melalui single point of data input
2. **Mempercepat pelaporan** dari level posyandu hingga dinas secara real-time
3. **Meningkatkan akurasi data** melalui kalkulasi otomatis berbasis standar WHO
4. **Mendukung kerja offline** untuk kader di daerah dengan keterbatasan internet
5. **Menyediakan visualisasi** grafik pertumbuhan yang mudah dipahami

### 10.2 Langkah Selanjutnya

Setelah laporan pendahuluan ini disetujui, langkah selanjutnya adalah:

1. **Kick-off meeting** dengan stakeholder untuk validasi final requirements
2. **Environment setup** untuk pengembangan
3. **Sprint planning** untuk fase pertama development
4. **Database migration** dan seeding data WHO
5. **Memulai development** sesuai timeline yang telah disusun

### 10.3 Persetujuan Dokumen

Dokumen ini memerlukan persetujuan dari pihak-pihak berikut sebelum melanjutkan ke fase development:

| No  | Pihak                    | Nama                  | Jabatan                       | Tanda Tangan          | Tanggal   |
| --- | ------------------------ | --------------------- | ----------------------------- | --------------------- | --------- |
| 1   | Pemberi Kerja            | ..................... | Kepala Dinas Ketahanan Pangan | ..................... | ......... |
| 2   | Tim Teknis Pemberi Kerja | ..................... | Koordinator IT                | ..................... | ......... |
| 3   | Penyedia Jasa            | ..................... | Project Manager               | ..................... | ......... |
| 4   | Penyedia Jasa            | ..................... | Technical Lead                | ..................... | ......... |

---

**Dokumen ini disiapkan oleh:**

**CV Alaska Sitrix Kreasi**  
Tim Pengembang Aplikasi Posting Cinta

---

_Laporan Pendahuluan - Versi 1.0_  
_3 Maret 2025_
