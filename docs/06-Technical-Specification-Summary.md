# TECHNICAL SPECIFICATION SUMMARY

## Posting Cinta - Ready for Development

**Project**: PWA Monitoring Stunting Kabupaten Muara Enim  
**Version**: 1.0  
**Date**: 12 Oktober 2025  
**Status**: ✅ Architecture Complete - Ready for Development

---

## 📋 QUICK REFERENCE

### Documentation Index

1. ✅ **SRS** - System Requirements Specification (`01-SRS-Posting-Cinta.md`)
2. ✅ **Database Schema** - ERD & Migrations (`02-Database-Schema-ERD.md`)
3. ✅ **System Architecture** - PWA Offline-First (`03-System-Architecture-Design.md`)
4. ✅ **WHO Z-Score** - Growth Charts Implementation (`04-WHO-Growth-Charts-ZScore.md`)
5. ✅ **UI/UX Design** - Wireframes & Components (`05-UI-UX-Design-Wireframes.md`)

### Tech Stack (NON-NEGOTIABLE)

```
Backend:  Laravel 11 + PostgreSQL 17
Frontend: Blade + Alpine.js + Tailwind CSS
PWA:      Service Worker + IndexedDB
Cache:    File-based (storage/framework/cache)
Queue:    Database (default Laravel)
```

---

## 🎯 PROJECT GOALS

**Problem**: Tingginya angka stunting di Muara Enim karena minimnya tools monitoring yang mudah digunakan kader gaptek.

**Solution**: PWA offline-first untuk monitoring stunting berbasis standar WHO dengan UI sederhana.

**KPI**:

- 90% kader aktif dalam 1 bulan
- Lag time data: dari 1-2 bulan → real-time
- Deteksi dini stunting: dari 2-3 bulan delay → 0 bulan
- Prevalensi stunting turun 5% dalam 1 tahun

---

## 👥 USER ROLES

### 1. Admin Dinas Ketahanan Pangan

- View dashboard kabupaten
- Manage puskesmas & users
- Manage resep makanan
- Export laporan

### 2. Pengelola Puskesmas

- View dashboard puskesmas
- Manage kader di wilayahnya
- Manage posyandu
- Monitor kasus gizi buruk

### 3. Kader Posyandu (PRIMARY USER)

- Input data pengukuran (offline-capable)
- View grafik pertumbuhan WHO
- Manage data ibu & anak
- Akses resep makanan
- View jadwal & notifikasi

---

## 📊 DATABASE SCHEMA (10 Tables)

```
users (auth, RBAC)
├─ puskesmas (parent: none)
│  └─ posyandu (parent: puskesmas, kader)
│     ├─ mothers (parent: posyandu)
│     │  └─ children (parent: mothers) ⚠️ 1 ibu → N anak
│     │     └─ measurements (parent: children)
│     └─ growth_standards (WHO reference data)
│
├─ recipes (standalone, age-categorized)
├─ notifications (DB-driven, per user)
└─ sync_queue (offline sync management)
```

**Key Relationships**:

- 1 Puskesmas → N Posyandu
- 1 Posyandu → N Mothers
- **1 Mother → N Children** ⚠️ PENTING
- 1 Child → N Measurements

**Migrations Order**:

```
1. puskesmas
2. users (FK: puskesmas)
3. posyandu (FK: puskesmas, kader)
4. mothers (FK: posyandu, created_by)
5. children (FK: mothers, posyandu, created_by)
6. measurements (FK: children, created_by)
7. growth_standards (WHO data)
8. recipes (standalone)
9. notifications (FK: users)
10. sync_queue (FK: users)
```

---

## 🏗️ FOLDER STRUCTURE (Laravel 11)

```
app/
├── Console/Commands/
│   ├── SendPosyanduReminders.php
│   └── CleanOldNotifications.php
├── Http/
│   ├── Controllers/
│   │   ├── DashboardController.php
│   │   ├── MeasurementController.php
│   │   ├── GrowthChartController.php
│   │   ├── RecipeController.php
│   │   └── SyncController.php (API for offline sync)
│   ├── Middleware/
│   │   └── CheckRole.php (RBAC)
│   └── Requests/
│       └── StoreMeasurementRequest.php
├── Models/
│   ├── User.php (role: admin/puskesmas/kader)
│   ├── Child.php (gender: male/female)
│   ├── Measurement.php (Z-scores, nutrition_status)
│   └── GrowthStandard.php (WHO LMS data)
├── Services/
│   ├── ZScoreService.php ⭐ CORE LOGIC
│   ├── NutritionStatusService.php
│   ├── SyncService.php (offline → online)
│   └── NotificationService.php
└── Jobs/
    ├── ProcessSyncQueue.php
    └── SendPosyanduReminder.php

resources/views/
├── layouts/app.blade.php
├── dashboard/
│   ├── kader.blade.php
│   ├── puskesmas.blade.php
│   └── admin.blade.php
├── measurements/create.blade.php
├── growth-charts/show.blade.php
└── components/ (Blade components)

public/
├── service-worker.js ⭐ PWA CORE
├── manifest.json
├── js/
│   ├── app.js (Alpine.js entry)
│   └── sync.js (offline sync logic)
└── data/
    └── who-growth-standards.json (cached)
```

---

## 🔄 OFFLINE-FIRST FLOW

### Scenario: Kader Input Measurement (Offline)

```
[1] Kader fill form → Alpine.js check navigator.onLine
    │
    ├─ IF ONLINE:
    │  └─ POST /api/measurements → Laravel → DB → Response
    │
    └─ IF OFFLINE:
       ├─ Save to IndexedDB (local)
       ├─ Register Background Sync (Service Worker)
       └─ Toast: "Data disimpan offline, akan di-sync otomatis"

[2] Service Worker Background Sync (when online)
    ├─ Fetch pending items from IndexedDB
    ├─ POST /api/sync/measurements (batch)
    ├─ Laravel: Validate, Calculate Z-scores, Save to DB
    ├─ IF SUCCESS:
    │  └─ Remove from IndexedDB, Send notification if critical
    └─ IF FAIL:
       └─ Retry 3x (exponential backoff), then mark as failed
```

### Service Worker Cache Strategy

| Resource            | Strategy            | Rationale                  |
| ------------------- | ------------------- | -------------------------- |
| CSS, JS, Images     | Cache First         | Static, rarely change      |
| WHO JSON            | Cache First         | Large file, rarely updated |
| HTML Pages          | Network First       | Dynamic content            |
| API GET             | Network First       | Fresh data preferred       |
| API POST/PUT/DELETE | Network Only + Sync | Write operations           |

---

## 📈 WHO Z-SCORE CALCULATION

### Core Formula (LMS Method)

```
Z = [(Y / M)^L - 1] / (L * S)

Where:
- Y = Measured value (weight/height)
- M = Median from WHO table
- L = Box-Cox transformation
- S = Coefficient of variation
```

### Implementation Steps

1. **Calculate Age in Months** (with decimal)

   ```php
   $ageInMonths = $dob->diffInDays($measuredAt) / 30.4375;
   ```

2. **Interpolate WHO Standards** (if age is between integer months)

   ```php
   $M = $M_floor + ($age - $age_floor) * ($M_ceil - $M_floor);
   ```

3. **Calculate Z-scores** (3 indicators)

   - Weight-for-Age (BB/U)
   - Height-for-Age (TB/U) ⭐ PRIMARY for stunting
   - Weight-for-Height (BB/TB)

4. **Determine Nutrition Status**

   ```
   Z < -3 SD → Severely Stunted/Wasted (🚨 CRITICAL)
   Z < -2 SD → Stunting/Wasting (⚠️ WARNING)
   Z >= -2 SD → Normal (✅)
   ```

5. **Auto-create Notification** (if critical status detected)

### Service Class Structure

```php
// app/Services/ZScoreService.php
public function calculateZScores(
    float $weight,
    float $height,
    string $dateOfBirth,
    string $measuredAt,
    string $gender
): array {
    $ageInMonths = $this->calculateAgeInMonths(...);
    $wfaZ = $this->calculateWeightForAge(...);
    $hfaZ = $this->calculateHeightForAge(...);
    $wfhZ = $this->calculateWeightForHeight(...);

    return [
        'age_months' => (int) floor($ageInMonths),
        'weight_for_age_z' => round($wfaZ, 2),
        'height_for_age_z' => round($hfaZ, 2),
        'weight_for_height_z' => round($wfhZ, 2),
    ];
}
```

---

## 🎨 UI/UX GUIDELINES

### Design Principles

1. **Mobile-First** - Optimize for 360×640px
2. **Big Targets** - Minimum 48×48px touch area
3. **High Contrast** - WCAG AA (4.5:1 ratio)
4. **Simple Navigation** - Max 3 clicks to any feature
5. **Forgiving** - Inline validation, undo capability

### Color Palette

```
Primary:   #3B82F6 (Blue)
Success:   #10B981 (Green) - Normal status
Warning:   #F59E0B (Yellow) - At-risk status
Danger:    #EF4444 (Red) - Critical status
Text:      #374151 (Gray 700)
Border:    #D1D5DB (Gray 300)
```

### Typography

```
Headings:  20-28px, Bold
Body:      16-18px, Regular
Buttons:   18px, SemiBold
Helper:    14px, Regular
```

### Components

- **Bottom Navigation** (72px height, 4 items max)
- **Primary Button** (56px height, full-width)
- **Input Fields** (56px height, large text)
- **Cards** (rounded-lg, shadow-md, padding-6)
- **Status Badges** (color-coded by nutrition status)
- **Toast Notifications** (slide from top, auto-dismiss 3s)

---

## 🔔 NOTIFICATION SYSTEM (DB-Driven)

### Types of Notifications

1. **Posyandu Schedule** (H-3, H-1, H-0)

   ```php
   NotificationService::sendPosyanduReminder($posyandu, $date);
   ```

2. **Stunting Alert** (saat deteksi gizi buruk)

   ```php
   NotificationService::sendStuntingAlert($child, $measurement);
   // To: Kader + Puskesmas
   ```

3. **Input Reminder** (H+7 jika belum input)

   ```php
   NotificationService::sendInputReminder($kader, $anak_belum_diukur);
   ```

4. **Monthly Report** (akhir bulan)
   ```php
   NotificationService::sendMonthlyReport($user, $stats);
   ```

### Implementation

```php
// In-app notifications only (NO email/SMS)
Notification::create([
    'user_id' => $user->id,
    'type' => 'stunting_alert',
    'title' => 'Deteksi Gizi Buruk',
    'message' => "Anak {$child->name} terdeteksi stunting berat (TB/U: {$z_score} SD)",
    'data' => json_encode([
        'child_id' => $child->id,
        'measurement_id' => $measurement->id,
        'action_required' => true
    ]),
]);
```

---

## 🚀 DEPLOYMENT WORKFLOW

### Development Setup

```bash
# Clone repo
git clone <repo-url> posting-cinta
cd posting-cinta

# Install dependencies
composer install
npm install

# Environment
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate --seed

# WHO data seeder
php artisan db:seed --class=GrowthStandardSeeder

# Build assets
npm run dev

# Run server
php artisan serve
```

### Production Deployment (VPS)

```bash
# On server (automated via script)
cd /var/www/posting-cinta/repo
git pull origin main

# Create release
RELEASE_DIR="releases/$(date +%Y-%m-%d_%H-%M-%S)"
mkdir -p /var/www/posting-cinta/$RELEASE_DIR
cp -r * /var/www/posting-cinta/$RELEASE_DIR/

# Install & build
cd /var/www/posting-cinta/$RELEASE_DIR
composer install --no-dev --optimize-autoloader
npm ci --production
npm run build

# Migrate
php artisan migrate --force

# Clear cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Switch symlink
ln -sfn /var/www/posting-cinta/$RELEASE_DIR /var/www/posting-cinta/current

# Reload services
sudo systemctl reload php8.2-fpm
sudo supervisorctl restart posting-cinta-worker:*
```

### Nginx Config

```nginx
server {
    listen 443 ssl http2;
    server_name postingcinta.muaraenim.go.id;
    root /var/www/posting-cinta/current/public;

    # SSL
    ssl_certificate /etc/letsencrypt/live/.../fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/.../privkey.pem;

    # Laravel routing
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP-FPM
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

---

## ✅ DEVELOPMENT CHECKLIST

### Phase 1: Setup & Core (Week 1-2)

- [ ] Laravel 11 project setup
- [ ] PostgreSQL 17 database setup
- [ ] Migrations (10 tables)
- [ ] Seeders (admin user, WHO data)
- [ ] Auth scaffolding (Laravel Breeze)
- [ ] RBAC middleware (CheckRole)

### Phase 2: Core Features (Week 3-5)

- [ ] Dashboard (3 roles)
- [ ] CRUD: Mothers, Children, Posyandu
- [ ] Input Measurement form
- [ ] ZScoreService implementation
- [ ] NutritionStatusService
- [ ] GrowthChartService (Chart.js)

### Phase 3: PWA & Offline (Week 6-7)

- [ ] Service Worker setup
- [ ] Cache strategies implementation
- [ ] IndexedDB for offline storage
- [ ] Background Sync API
- [ ] SyncService (offline → online)
- [ ] Offline indicators (UI)

### Phase 4: Advanced Features (Week 7-8)

- [ ] Recipe CRUD (admin)
- [ ] Notification system (DB-driven)
- [ ] NotificationService
- [ ] Scheduler (reminders, reports)
- [ ] Dashboard analytics (charts)
- [ ] Export laporan (PDF/Excel)

### Phase 5: Testing & Polish (Week 8-9)

- [ ] Unit tests (Services, Models)
- [ ] Feature tests (Controllers)
- [ ] Browser testing (Chrome, Safari, Firefox)
- [ ] PWA install flow testing
- [ ] Offline sync testing
- [ ] Performance optimization

### Phase 6: Deployment & Training (Week 10)

- [ ] VPS setup (Nginx, PHP-FPM, Supervisor)
- [ ] SSL certificate (Let's Encrypt)
- [ ] Deploy production
- [ ] UAT dengan kader pilot
- [ ] Training materials (user guide)
- [ ] Go-live rollout

---

## 🔧 DEVELOPMENT PRIORITIES

### MUST HAVE (MVP)

✅ Input measurement (offline-capable)
✅ Z-score calculation (WHO standards)
✅ Growth charts (3 indicators)
✅ Dashboard (role-based)
✅ CRUD data master (ibu, anak)
✅ PWA offline-first
✅ Notification system (DB-driven)

### SHOULD HAVE (V1.1)

- Export laporan Excel/PDF
- Search & filter (anak, ibu)
- Recipe management
- Bulk import data
- Audit log

### NICE TO HAVE (Future)

- Peta sebaran stunting (GIS)
- Machine learning prediction
- Integration with KIA digital
- Multi-language support
- Dark mode UI

---

## 📞 SUPPORT & RESOURCES

### Documentation

- Laravel 11: https://laravel.com/docs/11.x
- Alpine.js: https://alpinejs.dev
- Tailwind CSS: https://tailwindcss.com
- Chart.js: https://www.chartjs.org
- WHO Standards: https://www.who.int/tools/child-growth-standards

### Development Team Contacts

- Project Manager: [Contact]
- Backend Developer: [Contact]
- Frontend Developer: [Contact]
- QA Tester: [Contact]

### Stakeholders

- Dinas Ketahanan Pangan Muara Enim
- Puskesmas Gelumbang (pilot)
- Kader Posyandu (end users)

---

## 🎯 SUCCESS CRITERIA

### Technical

- [ ] All 10 migrations run successfully
- [ ] WHO Z-score calculation accuracy > 99%
- [ ] PWA offline sync success rate > 95%
- [ ] Page load time < 2 seconds
- [ ] No critical bugs in production

### Business

- [ ] 90% kader adoption in 1 month
- [ ] < 5% error rate on data entry
- [ ] Real-time data availability
- [ ] 5% reduction in stunting prevalence (1 year)

### User Satisfaction

- [ ] System Usability Scale (SUS) score > 70
- [ ] User training completion rate > 90%
- [ ] Support ticket resolution < 24 hours
- [ ] User satisfaction rating > 4/5

---

## 📝 NOTES FOR DEVELOPERS

### Code Style

- Follow PSR-12 coding standard
- Use Laravel naming conventions
- Comment complex logic (especially Z-score calculation)
- Use type hints (PHP 8.2+)

### Git Workflow

- `main` branch for production
- `develop` branch for development
- Feature branches: `feature/measurement-form`
- Commit messages: Conventional Commits format

### Testing

- Write tests for critical services (ZScoreService, SyncService)
- Test offline scenarios extensively
- Test with realistic WHO data
- Test on actual mobile devices (Android, iOS)

### Performance

- Eager load relationships (avoid N+1)
- Cache WHO standards (forever)
- Optimize database indexes
- Lazy load images
- Minify assets (Vite)

### Security

- Validate all inputs (FormRequests)
- Use CSRF tokens (Blade forms)
- Sanitize output (Blade auto-escapes)
- SQL injection protection (Eloquent ORM)
- HTTPS mandatory

---

**READY FOR DEVELOPMENT** ✅

Semua dokumentasi arsitektur sudah complete. Development team bisa langsung mulai implementasi mengikuti tech spec ini.

**Next Steps**:

1. Setup development environment
2. Create Laravel project
3. Implement migrations
4. Build core features (measurements, Z-scores)
5. Implement PWA offline-first
6. Testing & deployment

**Estimated Timeline**: 8-10 minggu (2-2.5 bulan)

---

**END OF TECHNICAL SPECIFICATION**
