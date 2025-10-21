# POSTING CINTA - ARCHITECTURE DOCUMENTATION

## PWA Monitoring Stunting Kabupaten Muara Enim

**Status**: ✅ **READY FOR DEVELOPMENT**  
**Version**: 1.0  
**Date**: 12 Oktober 2025  
**Architect**: Mateen (Senior System Architect)

---

## 📚 DOCUMENTATION INDEX

### Complete Architecture Suite (6 Documents)

| #   | Document                                                                     | Description                                       | Status      |
| --- | ---------------------------------------------------------------------------- | ------------------------------------------------- | ----------- |
| 1   | **[System Requirements Specification (SRS)](01-SRS-Posting-Cinta.md)**       | Requirements, scope, constraints, success metrics | ✅ Complete |
| 2   | **[Database Schema & ERD](02-Database-Schema-ERD.md)**                       | 10 tables, relationships, migrations, indexes     | ✅ Complete |
| 3   | **[System Architecture Design (SAD)](03-System-Architecture-Design.md)**     | PWA architecture, offline-first, deployment       | ✅ Complete |
| 4   | **[WHO Growth Charts & Z-Score](04-WHO-Growth-Charts-ZScore.md)**            | Z-score calculation, LMS method, chart rendering  | ✅ Complete |
| 5   | **[UI/UX Design & Wireframes](05-UI-UX-Design-Wireframes.md)**               | Mobile-first design, components, all screens      | ✅ Complete |
| 6   | **[Technical Specification Summary](06-Technical-Specification-Summary.md)** | Quick reference, dev checklist, priorities        | ✅ Complete |

**Total Pages**: ~5,000 lines of comprehensive technical documentation

---

## 🎯 PROJECT OVERVIEW

### The Problem

Tingginya angka stunting di Kabupaten Muara Enim karena:

- ❌ Sistem monitoring manual (paper-based)
- ❌ Data terlambat sampai ke Dinas (1-2 bulan)
- ❌ Tidak ada grafik pertumbuhan real-time
- ❌ Kader kesehatan kesulitan pakai aplikasi kompleks

### The Solution

**Posting Cinta**: PWA offline-first untuk monitoring stunting berbasis standar WHO dengan:

- ✅ Input data langsung (offline-capable)
- ✅ Auto-calculate Z-scores (WHO 2006 standards)
- ✅ Grafik pertumbuhan real-time (3 indicators)
- ✅ UI sederhana untuk kader gaptek (mobile-first)
- ✅ Notifikasi otomatis (deteksi gizi buruk)

### Key Features

1. **Monitoring Pertumbuhan**: BB, TB, LK + WHO Z-scores
2. **Growth Charts**: Visual WHO curves (terpisah laki/perempuan)
3. **Resep Makanan**: Database resep sehat per usia (MPASI, Balita, Anak)
4. **PWA Offline-First**: Kader bisa input tanpa internet, auto-sync
5. **Notifications**: In-app alerts (jadwal posyandu, deteksi stunting)
6. **Multi-Role**: Admin Dinas, Puskesmas, Kader (RBAC)

---

## 🏗️ ARCHITECTURE HIGHLIGHTS

### Tech Stack (PRAGMATIC - No Over-Engineering)

```
Backend:   Laravel 11 + PostgreSQL 17 (Monolith MVC)
Frontend:  Blade Templates + Alpine.js + Tailwind CSS
PWA:       Service Worker + IndexedDB + Background Sync
Cache:     File-based (storage/framework/cache)
Queue:     Database queue (Laravel default)
Hosting:   VPS (Nginx + PHP-FPM + Supervisor)
```

**Explicitly Forbidden**:

- ❌ Microservices, Redis, Memcached
- ❌ Email/SMS/WhatsApp integration
- ❌ Message brokers (RabbitMQ, Kafka)
- ❌ SPA frameworks (React, Vue, Angular)
- ❌ Docker, Kubernetes

### Database Schema (10 Tables)

```
users (auth + RBAC)
├─ puskesmas
│  └─ posyandu
│     ├─ mothers
│     │  └─ children ⚠️ 1 ibu → N anak
│     │     └─ measurements (Z-scores)
│     └─ growth_standards (WHO data)
├─ recipes (age-categorized)
├─ notifications (DB-driven)
└─ sync_queue (offline sync)
```

### Offline-First Flow

```
Kader Input Measurement (Offline)
    ↓
Save to IndexedDB
    ↓
Register Background Sync
    ↓
Auto-sync when online
    ↓
Laravel: Validate → Calculate Z-scores → Save DB
    ↓
Send notification if critical status
```

### WHO Z-Score Calculation (LMS Method)

```
Z = [(Y / M)^L - 1] / (L * S)

Where:
- Y = Measured value (weight/height)
- M = Median from WHO table
- L = Box-Cox transformation
- S = Coefficient of variation

3 Indicators:
1. Weight-for-Age (BB/U) → Underweight
2. Height-for-Age (TB/U) → Stunting ⭐ PRIMARY
3. Weight-for-Height (BB/TB) → Wasting

Classification:
- Z < -3 SD → Severely Stunted (🚨 CRITICAL)
- Z < -2 SD → Stunting (⚠️ WARNING)
- Z >= -2 SD → Normal (✅)
```

### UI/UX Principles (Gaptek-Friendly)

```
1. Mobile-First (360×640px baseline)
2. Big Touch Targets (min 48×48px)
3. High Contrast (WCAG AA 4.5:1)
4. Simple Navigation (max 3 clicks)
5. Forgiving Input (inline validation, undo)
6. Visual Feedback (loading, success, error states)

Bottom Navigation (4 items):
[🏠 Beranda] [👶 Anak] [📊 Grafik] [👤 Profil]
```

---

## 👥 USER ROLES & PERMISSIONS

### 1. Admin Dinas Ketahanan Pangan

**Access**:

- ✅ Dashboard kabupaten (aggregate semua puskesmas)
- ✅ Manage puskesmas & users
- ✅ Manage resep makanan (CRUD)
- ✅ Export laporan (PDF/Excel)
- ✅ View data semua posyandu

**Dashboard**:

- Total anak, prevalensi stunting kabupaten
- Tren 12 bulan
- Peta sebaran per kecamatan (future)
- Puskesmas prioritas (stunting tertinggi)

### 2. Pengelola Puskesmas

**Access**:

- ✅ Dashboard puskesmas (aggregate kader di wilayahnya)
- ✅ Manage kader yang bernaung
- ✅ Manage posyandu di wilayahnya
- ✅ Monitor kasus gizi buruk real-time
- ✅ Export laporan puskesmas

**Dashboard**:

- Total anak per posyandu
- Status gizi breakdown
- Top 5 posyandu butuh perhatian
- Grafik tren puskesmas

### 3. Kader Posyandu (PRIMARY USER)

**Access**:

- ✅ Input data pengukuran (offline-capable)
- ✅ View grafik pertumbuhan WHO per anak
- ✅ Manage data ibu & anak di wilayahnya
- ✅ View resep makanan sehat
- ✅ View jadwal posyandu & notifikasi

**Dashboard**:

- Total anak terdaftar
- Status gizi summary (normal/stunting/wasting)
- List anak butuh perhatian
- Jadwal posyandu berikutnya

---

## 📊 SUCCESS METRICS (KPIs)

### Adoption Metrics

- ✅ 90% kader aktif dalam 1 bulan pertama
- ✅ 80% data input via app (vs manual) dalam 3 bulan
- ✅ Rata-rata 95% data anak ter-update setiap bulan

### Operational Metrics

- ✅ Lag time data: dari 1-2 bulan → **real-time**
- ✅ Accuracy rate: < 5% error pada data entry
- ✅ System uptime: > 99% (max 7 jam downtime/bulan)

### Health Impact (Long-term)

- ✅ Deteksi dini stunting: dari 2-3 bulan delay → **0 bulan**
- ✅ Follow-up rate kasus gizi buruk: dari 60% → **> 90%**
- ✅ Prevalensi stunting kabupaten turun **5% dalam 1 tahun**

---

## 🚀 DEVELOPMENT TIMELINE

### Estimated: **8-10 Weeks** (2-2.5 Bulan)

| Phase                      | Duration | Deliverables                                    |
| -------------------------- | -------- | ----------------------------------------------- |
| **Phase 1: Setup & Core**  | Week 1-2 | Laravel setup, migrations, auth, RBAC           |
| **Phase 2: Core Features** | Week 3-5 | Dashboard, CRUD, measurements, Z-scores, charts |
| **Phase 3: PWA & Offline** | Week 6-7 | Service Worker, IndexedDB, background sync      |
| **Phase 4: Advanced**      | Week 7-8 | Recipes, notifications, reports, analytics      |
| **Phase 5: Testing**       | Week 8-9 | Unit tests, browser tests, UAT                  |
| **Phase 6: Deployment**    | Week 10  | Production deploy, training, go-live            |

### Must Have (MVP)

- ✅ Input measurement (offline-capable)
- ✅ Z-score calculation (WHO standards)
- ✅ Growth charts (3 indicators)
- ✅ Dashboard (role-based)
- ✅ CRUD data master
- ✅ PWA offline-first
- ✅ Notification system (DB-driven)

### Should Have (V1.1)

- Export laporan (PDF/Excel)
- Search & filter advanced
- Recipe management
- Bulk import data
- Audit log

### Nice to Have (Future)

- Peta sebaran stunting (GIS)
- Machine learning prediction
- Integration KIA digital
- Multi-language support
- Dark mode UI

---

## 📖 HOW TO READ THIS DOCUMENTATION

### For Project Managers

Start with:

1. **SRS** (`01-SRS-Posting-Cinta.md`) - Understand requirements & scope
2. **Technical Summary** (`06-Technical-Specification-Summary.md`) - Quick reference & timeline

### For Backend Developers

Focus on:

1. **Database Schema** (`02-Database-Schema-ERD.md`) - Tables, relationships, migrations
2. **System Architecture** (`03-System-Architecture-Design.md`) - Laravel structure, API endpoints
3. **WHO Z-Score** (`04-WHO-Growth-Charts-ZScore.md`) - Core business logic implementation

### For Frontend Developers

Focus on:

1. **UI/UX Design** (`05-UI-UX-Design-Wireframes.md`) - All screens, components, design system
2. **System Architecture** (`03-System-Architecture-Design.md`) - Alpine.js, PWA, offline sync

### For QA Testers

Focus on:

1. **SRS** (`01-SRS-Posting-Cinta.md`) - Functional requirements, test scenarios
2. **Technical Summary** (`06-Technical-Specification-Summary.md`) - Success criteria, checklist

### For Stakeholders (Dinas, Puskesmas)

Focus on:

1. **SRS** (`01-SRS-Posting-Cinta.md`) - Business requirements, ROI, KPIs
2. **UI/UX Design** (`05-UI-UX-Design-Wireframes.md`) - Visual preview of application

---

## ✅ ARCHITECTURE REVIEW CHECKLIST

**Before proceeding to development, please review**:

### Technical Architecture

- [ ] Tech stack approved (Laravel 11, PostgreSQL 17, Blade, Alpine.js, Tailwind)
- [ ] Database schema makes sense (10 tables, proper relationships)
- [ ] PWA offline-first strategy understood
- [ ] WHO Z-score calculation approach validated
- [ ] Notification system (DB-driven only) acceptable
- [ ] Deployment workflow feasible (VPS, Nginx, Git)

### Functional Requirements

- [ ] User roles & permissions clear (Admin, Puskesmas, Kader)
- [ ] Core features prioritized correctly (MVP vs V1.1)
- [ ] Offline mode requirements realistic
- [ ] UI/UX design suitable for target users (kader gaptek)
- [ ] Success metrics (KPIs) agreed upon
- [ ] Timeline realistic (8-10 weeks)

### Business Alignment

- [ ] Solves the stunting monitoring problem
- [ ] Fits within budget constraints
- [ ] Scalable for kabupaten-wide rollout
- [ ] Training plan for kaders feasible
- [ ] Support & maintenance plan in place

---

## 🎯 NEXT STEPS

### 1. Architecture Review & Approval

**Action**: User reviews all 6 documents
**Deliverable**: Written approval or requested changes
**Timeline**: 2-3 hari

### 2. Development Environment Setup

**Action**: Setup Laravel 11, PostgreSQL 17, Git repo
**Deliverable**: Working dev environment
**Timeline**: 1-2 hari

### 3. Start Development (Phase 1)

**Action**: Begin migrations, auth, RBAC
**Deliverable**: Core foundation
**Timeline**: Week 1-2

### 4. Iterative Development

**Action**: Follow phase plan, weekly demos
**Deliverable**: Working features
**Timeline**: Week 3-9

### 5. UAT & Deployment

**Action**: User acceptance testing, training, go-live
**Deliverable**: Production-ready application
**Timeline**: Week 10

---

## 📞 QUESTIONS OR CLARIFICATIONS?

**Ask if you need clarification on**:

- Technical decisions (why PostgreSQL vs MySQL?)
- Architecture choices (why monolith vs microservices?)
- Feature priorities (why X before Y?)
- Timeline estimates (can we go faster?)
- Budget concerns (hosting costs, etc.)

**Contact**:

- Architect: Mateen (available for Q&A)
- Development Team: [To be assigned]
- Project Manager: [To be assigned]

---

## 🏆 FINAL NOTES

### What Makes This Architecture PRAGMATIC

✅ **Simple Wins**: Monolith MVC, file cache, DB queue (no complex infrastructure)  
✅ **Battle-Tested**: Laravel 11 (mature framework), PostgreSQL 17 (reliable DB)  
✅ **Cost-Effective**: Single VPS hosting, no Redis/RabbitMQ, no cloud vendor lock-in  
✅ **Junior-Friendly**: Standard Laravel patterns, no DDD/CQRS/ES complexity  
✅ **Mobile-First**: PWA offline-first, perfect for kader di lapangan  
✅ **User-Centric**: UI/UX designed for 40-55 tahun, literasi digital rendah

### Why This Will Succeed

1. **Solves Real Problem**: Kader butuh tools simple untuk monitoring stunting
2. **Proven Tech Stack**: Laravel + PostgreSQL + PWA = stable & scalable
3. **Offline-First**: Kader bisa kerja tanpa internet, auto-sync saat online
4. **WHO Compliant**: Z-score calculation akurat, international standard
5. **Easy to Maintain**: Monolith architecture, single codebase, clear structure
6. **Budget-Friendly**: Hosting VPS ~$20-50/bulan, no expensive cloud services

---

**🎉 ARCHITECTURE COMPLETE - READY FOR DEVELOPMENT!**

**Semua dokumentasi sudah lengkap dan actionable. Development team bisa langsung mulai implementasi. Estimasi 8-10 minggu untuk MVP production-ready.**

**📅 Target Go-Live**: Desember 2025 (soft launch 1 puskesmas pilot)  
**📅 Full Rollout**: Januari 2026 (kabupaten-wide)

---

_Dokumentasi ini dibuat oleh Mateen (Senior System Architect) dengan prinsip PRAGMATIC - No over-engineering, simple wins, focus on ROI._

**Last Updated**: 12 Oktober 2025
