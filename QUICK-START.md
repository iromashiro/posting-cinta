# 🚀 Quick Start - Posting Cinta

## 📋 Prerequisites

-   PHP 8.2+
-   Composer
-   Node.js 18+ & npm
-   SQLite (atau MySQL/PostgreSQL)

## ⚡ Setup Super Cepat (5 Menit)

### 1️⃣ Clone & Install Dependencies

```bash
cd posting-cinta
composer install
npm install
```

### 2️⃣ Setup Environment

```bash
# Copy .env
cp .env.example .env

# Generate key
php artisan key:generate

# Link storage
php artisan storage:link
```

### 3️⃣ Setup Database & Seed

```bash
# Jalankan migrations
php artisan migrate

# Seed data (termasuk user test)
php artisan db:seed
```

### 4️⃣ Build Assets & Run

```bash
# Build assets (production)
npm run build

# ATAU untuk development dengan hot reload:
# Terminal 1:
npm run dev

# Terminal 2:
php artisan serve
```

## 🔐 Test Accounts

Setelah seeding, gunakan akun berikut untuk login:

| Role                  | Email                    | Password |
| --------------------- | ------------------------ | -------- |
| **Admin**             | admin@postingcinta.local | password |
| **Petugas Puskesmas** | petugas@puskesmas.local  | password |
| **Kader Posyandu**    | kader@posyandu.local     | password |

## 🌐 Akses Aplikasi

Buka browser dan akses:

```
http://localhost:8000/login
```

## 🎨 Fitur UI/UX JAKI-Style

✅ **Gradient Color Scheme**: Pink → Purple → Blue  
✅ **Bottom Navigation** (Mobile): 4 item - Beranda, Anak, Grafik, Menu  
✅ **Sidebar Navigation** (Desktop): Expandable dengan active states  
✅ **PWA Ready**: Install prompt, offline mode, service worker  
✅ **Responsive Cards**: Rounded-3xl, shadow-lg, border-2  
✅ **Alpine.js**: Interactive sidebar, PWA banner, online/offline detection  
✅ **Modern Typography**: Bold headings, clear hierarchy

## 📱 PWA Testing

1. **Install Prompt**: Banner muncul otomatis di browser yang support PWA
2. **Offline Mode**:
    - Matikan koneksi internet
    - Refresh page → akan muncul banner kuning "Mode Offline"
    - Service Worker akan cache assets penting
3. **Install to Home Screen**:
    - Chrome: Klik tombol "Install" di address bar
    - Mobile: "Add to Home Screen" dari browser menu

## 🔧 Development Commands

```bash
# Watch CSS/JS changes (hot reload)
npm run dev

# Build for production
npm run build

# Clear all caches
php artisan optimize:clear

# Fresh migration + seed
php artisan migrate:fresh --seed

# Run tests
php artisan test
```

## 📂 Struktur File Penting

```
posting-cinta/
├── app/Http/Controllers/
│   ├── AuthController.php          # Login/Register/Logout
│   └── DashboardController.php     # Dashboard stats & data
├── resources/
│   ├── css/app.css                 # Tailwind + custom styles
│   ├── js/app.js                   # Alpine.js setup
│   └── views/
│       ├── layouts/app.blade.php   # Main layout (JAKI-style)
│       ├── auth/login.blade.php    # Login page
│       ├── auth/register.blade.php # Register page
│       └── dashboard.blade.php     # Dashboard
├── routes/web.php                  # Routes configuration
├── public/
│   ├── manifest.webmanifest        # PWA manifest
│   └── service-worker.js           # Service worker (offline support)
└── database/seeders/
    └── UserSeeder.php              # Test accounts
```

## 🐛 Troubleshooting

### Error: "Vite manifest not found"

```bash
npm run build
```

### Error: "SQLSTATE[HY000]: General error: 1 no such table"

```bash
php artisan migrate:fresh --seed
```

### Assets tidak muncul

```bash
php artisan storage:link
npm run build
php artisan optimize:clear
```

### Port 8000 sudah digunakan

```bash
php artisan serve --port=8001
```

## 🎯 Testing Checklist

-   [ ] Login dengan 3 akun berbeda (admin, petugas, kader)
-   [ ] Dashboard menampilkan stats & grafik gizi
-   [ ] Bottom navigation berfungsi (mobile view)
-   [ ] Sidebar toggle berfungsi (mobile & desktop)
-   [ ] PWA install prompt muncul
-   [ ] Offline mode banner muncul saat disconnect
-   [ ] Flash messages muncul dan auto-hide (5 detik)
-   [ ] Logout redirect ke login page
-   [ ] Responsive di mobile/tablet/desktop

## 🚀 Production Deployment

```bash
# 1. Optimize configs
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 2. Build assets
npm run build

# 3. Set permissions
chmod -R 775 storage bootstrap/cache

# 4. Set APP_ENV=production in .env
```

---

💖 **Posting Cinta** - Monitoring Pertumbuhan dan Pola Makan Anak  
Dinas Ketahanan Pangan Kabupaten Muara Enim
