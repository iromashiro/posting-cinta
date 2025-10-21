# 💖 Posting Cinta - Monitoring Pertumbuhan & Pola Makan Anak

![Laravel](https://img.shields.io/badge/Laravel-11-red?logo=laravel)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-3.4-38bdf8?logo=tailwindcss)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3.14-8bc0d0?logo=alpinedotjs)
![PWA](https://img.shields.io/badge/PWA-Ready-5a0fc8?logo=pwa)

Aplikasi web monitoring pertumbuhan dan pola makan anak untuk Posyandu berbasis Laravel 11 dengan UI/UX modern terinspirasi JAKI (Jakarta Kini).

---

## ✨ Fitur Utama

### 🎨 **Modern UI/UX (JAKI-Inspired)**

-   **Gradient Color Scheme**: Pink → Purple → Blue (ramah ibu & anak)
-   **Mobile-First Design**: Bottom navigation dengan 4 item utama
-   **Responsive Layout**: Desktop sidebar + Mobile drawer
-   **Rounded Cards**: border-radius 3xl, shadows, gradients
-   **Active States**: Visual feedback untuk navigasi aktif

### 🔐 **Sistem Autentikasi**

-   Login & Register dengan validasi lengkap
-   Session-based authentication
-   Role management (Admin, Puskesmas, Kader)
-   Auto-redirect setelah login/logout
-   Flash messages dengan auto-hide

### 📱 **Progressive Web App (PWA)**

-   **Install Prompt**: Banner install otomatis
-   **Offline Support**: Service Worker dengan cache strategy
-   **Offline Page**: Halaman khusus saat tidak ada koneksi
-   **Online/Offline Detection**: Banner status koneksi real-time
-   **Add to Home Screen**: Install seperti native app

### 📊 **Dashboard Analytics**

-   Stats cards: Total Anak, Ibu, Posyandu, Pengukuran
-   Status Gizi breakdown dengan visualisasi
-   Recent Measurements list
-   Role-based data filtering

### 🛠️ **Tech Stack**

-   **Backend**: Laravel 11 (PHP 8.2+)
-   **Frontend**: Blade SSR + Alpine.js 3.14
-   **Styling**: Tailwind CSS 3.4 (compiled via Vite)
-   **Build Tool**: Vite 6
-   **Database**: SQLite (dev) / MySQL/PostgreSQL (prod)

---

## 🚀 Quick Start

Lihat panduan lengkap di **[QUICK-START.md](QUICK-START.md)**

### Setup Singkat

```bash
# 1. Install dependencies
cd posting-cinta
composer install
npm install

# 2. Setup environment
cp .env.example .env
php artisan key:generate
php artisan storage:link

# 3. Database & seed
php artisan migrate
php artisan db:seed

# 4. Build & run
npm run build
php artisan serve
```

### Test Accounts

| Email                    | Password | Role      |
| ------------------------ | -------- | --------- |
| admin@postingcinta.local | password | Admin     |
| petugas@puskesmas.local  | password | Puskesmas |
| kader@posyandu.local     | password | Kader     |

Akses: **http://localhost:8000/login**

---

## 📐 UI/UX Design System

### Color Palette

```css
/* Primary Gradients */
from-pink-500 to-purple-500   /* Buttons, headers */
from-pink-50 to-purple-50     /* Active states */
from-pink-50 via-purple-50 to-blue-50  /* Body background */

/* Status Colors */
red-500    → Gizi Buruk
orange-500 → Gizi Kurang
green-500  → Gizi Baik
yellow-500 → Risiko Lebih
amber-500  → Gizi Lebih
```

### Typography

```css
/* Headings */
.text-3xl.font-bold  /* Page titles */
/* Page titles */
.text-2xl.font-bold  /* Section headers */
.text-lg.font-bold   /* Card titles */

/* Body */
.text-base           /* Normal text */
.text-sm             /* Helper text */
.text-xs; /* Captions */
```

### Components

```css
/* Buttons */
.btn-primary → bg-gradient-to-r from-pink-500 to-purple-500
              rounded-xl px-6 py-3 font-bold shadow-md
              hover:scale-[1.02] transition-all

/* Cards */
.card → bg-white rounded-3xl shadow-lg border-2 border-gray-100

/* Input Fields */
.input-field → w-full px-4 py-3 rounded-xl border-2
               focus:border-pink-500 focus:ring-4 ring-pink-100
```

---

## 📂 Project Structure

```
posting-cinta/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php       # Login/Register/Logout
│   │   │   ├── DashboardController.php  # Dashboard data
│   │   │   ├── ChildController.php      # CRUD Anak
│   │   │   ├── MotherController.php     # CRUD Ibu
│   │   │   ├── MeasurementController.php # CRUD Pengukuran
│   │   │   ├── PosyanduController.php   # CRUD Posyandu
│   │   │   └── RecipeController.php     # Resep Sehat
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php         # Auth guard
│   │   │   └── RedirectIfAuthenticated.php
│   │   └── Requests/                    # Form validations
│   ├── Models/                          # Eloquent models
│   └── Notifications/
│       └── MeasurementRecorded.php      # DB notifications
│
├── database/
│   ├── migrations/                      # Schema definitions
│   └── seeders/
│       ├── UserSeeder.php               # Test accounts
│       ├── RecipeSeeder.php             # Sample recipes
│       └── GrowthStandardSeeder.php     # WHO standards
│
├── resources/
│   ├── css/
│   │   └── app.css                      # Tailwind + custom styles
│   ├── js/
│   │   └── app.js                       # Alpine.js setup
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php            # Main layout (JAKI-style)
│       ├── auth/
│       │   ├── login.blade.php          # Login page
│       │   └── register.blade.php       # Register page
│       ├── dashboard.blade.php          # Dashboard
│       ├── children/                    # CRUD views for Anak
│       ├── mothers/                     # CRUD views for Ibu
│       ├── measurements/                # CRUD views for Pengukuran
│       ├── posyandu/                    # CRUD views for Posyandu
│       ├── recipes/                     # Recipe views
│       └── offline.blade.php            # PWA offline page
│
├── public/
│   ├── manifest.webmanifest             # PWA manifest
│   ├── service-worker.js                # Service worker
│   └── build/                           # Compiled assets (Vite)
│
├── routes/
│   └── web.php                          # Route definitions
│
├── .env.example                         # Environment template
├── composer.json                        # PHP dependencies
├── package.json                         # Node dependencies
├── tailwind.config.js                   # Tailwind configuration
├── vite.config.js                       # Vite build config
├── QUICK-START.md                       # Setup guide
└── README.md                            # This file
```

---

## 🎯 Key Features Breakdown

### 1. Authentication Flow

```
┌─────────┐     ┌──────────┐     ┌───────────┐
│ /login  │────▶│ Validate │────▶│ Dashboard │
└─────────┘     └──────────┘     └───────────┘
     │                │
     │                ▼
     │          (fail) Back
     │
     ▼
┌──────────┐
│ /register│
└──────────┘
```

**Controllers**: [`AuthController.php`](app/Http/Controllers/AuthController.php)  
**Views**: [`login.blade.php`](resources/views/auth/login.blade.php), [`register.blade.php`](resources/views/auth/register.blade.php)  
**Middleware**: [`Authenticate.php`](app/Http/Middleware/Authenticate.php)

### 2. Navigation System

**Desktop** (≥1024px):

-   Fixed sidebar (left)
-   Sticky header (top)
-   Active state highlighting

**Mobile** (<1024px):

-   Bottom navigation (4 items)
-   Drawer sidebar (hamburger menu)
-   Touch-optimized spacing

**Implementation**: [`app.blade.php`](resources/views/layouts/app.blade.php) lines 143-430

### 3. PWA Architecture

```
Service Worker (service-worker.js)
    │
    ├── Cache Strategy: Network-first with fallback
    ├── Cached Assets: CSS, JS, fonts, icons
    ├── Offline Page: /offline
    └── Install Prompt: beforeinstallprompt event
```

**Files**:

-   [`service-worker.js`](public/service-worker.js) - Cache & offline logic
-   [`manifest.webmanifest`](public/manifest.webmanifest) - App metadata
-   [`offline.blade.php`](resources/views/offline.blade.php) - Offline UI

### 4. Dashboard Stats

**Data Sources**:

```php
// DashboardController.php
$stats = [
    'total_anak' => Child::count(),
    'total_ibu' => Mother::count(),
    'total_posyandu' => Posyandu::count(),
    'total_pengukuran' => Measurement::count(),
];

$giziStats = Measurement::select('nutrition_status', DB::raw('count(*) as total'))
    ->whereIn('id', function ($query) {
        $query->select(DB::raw('MAX(id)'))->from('measurements')->groupBy('child_id');
    })
    ->groupBy('nutrition_status')
    ->pluck('total', 'nutrition_status');
```

**Visual Components**:

-   Welcome banner (gradient)
-   4 stat cards (icon + count)
-   Nutrition status breakdown (5 categories)
-   Recent measurements list

---

## 🧪 Testing Guide

### Manual Testing Checklist

#### Authentication

-   [ ] Login dengan credentials valid → redirect ke dashboard
-   [ ] Login dengan credentials invalid → error message
-   [ ] Register akun baru → auto-login & redirect
-   [ ] Logout → clear session & redirect ke login

#### Navigation

-   [ ] Click semua menu items → active state berubah
-   [ ] Toggle sidebar (mobile) → drawer muncul/hilang
-   [ ] Bottom nav (mobile) → navigasi berfungsi
-   [ ] Desktop sidebar → scroll smooth, active states jelas

#### PWA

-   [ ] PWA install banner muncul (Chrome/Edge)
-   [ ] Click "Install" → app ter-install
-   [ ] Disconnect network → offline banner muncul
-   [ ] Access offline → offline page tampil
-   [ ] Reconnect → banner hilang

#### Responsive

-   [ ] Mobile (375px) → bottom nav, drawer sidebar
-   [ ] Tablet (768px) → transisi layout smooth
-   [ ] Desktop (1024px+) → fixed sidebar muncul

### Automated Testing

```bash
# Run PHPUnit tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
```

---

## 🔧 Development

### Commands

```bash
# Development with hot reload
npm run dev

# Build for production
npm run build

# Watch CSS/JS changes
npm run watch

# Clear all caches
php artisan optimize:clear

# Fresh migration + seed
php artisan migrate:fresh --seed

# Code formatting (optional)
composer run format
npm run format
```

### Adding New Features

1. **Create Controller**:

    ```bash
    php artisan make:controller FeatureController
    ```

2. **Create Model + Migration**:

    ```bash
    php artisan make:model Feature -m
    ```

3. **Create Form Request**:

    ```bash
    php artisan make:request FeatureRequest
    ```

4. **Add Routes** in [`routes/web.php`](routes/web.php):

    ```php
    Route::resource('features', FeatureController::class);
    ```

5. **Create Views** in `resources/views/features/`:
    - `index.blade.php`
    - `create.blade.php`
    - `edit.blade.php`
    - `show.blade.php`

---

## 🚀 Deployment

### Production Checklist

```bash
# 1. Environment
cp .env.example .env
# Edit: APP_ENV=production, APP_DEBUG=false

# 2. Install dependencies
composer install --optimize-autoloader --no-dev
npm install

# 3. Build assets
npm run build

# 4. Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Database
php artisan migrate --force
php artisan db:seed --force

# 6. Permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# 7. Web server config
# - Point document root to /public
# - Configure PHP-FPM
# - Setup HTTPS (Let's Encrypt)
# - Enable gzip compression
```

### Recommended Stack

-   **Web Server**: Nginx 1.20+
-   **PHP**: 8.2+ with FPM
-   **Database**: MySQL 8.0+ / PostgreSQL 14+
-   **Process Manager**: Supervisor (for queue workers)
-   **SSL**: Let's Encrypt (Certbot)

---

## 📝 License & Credits

**Project**: Posting Cinta  
**Organization**: Dinas Ketahanan Pangan Kabupaten Muara Enim  
**Framework**: Laravel 11  
**UI Inspiration**: JAKI (Jakarta Kini)  
**Year**: 2025

---

## 📞 Support

Untuk pertanyaan teknis atau bantuan implementasi:

1. Baca [QUICK-START.md](QUICK-START.md)
2. Check [Laravel Documentation](https://laravel.com/docs/11.x)
3. Review code comments di controller/views
4. Contact: [email/wa support jika ada]

---

**Built with ❤️ for Indonesian Children's Health**
