# 🚀 Setup Guide - Posting Cinta

## Prerequisites

-   PHP 8.2+
-   Composer
-   MySQL/PostgreSQL
-   Node.js & NPM (optional, untuk production build)

## 📦 Installation Steps

### 1. Clone & Install Dependencies

```bash
cd posting-cinta
composer install
```

### 2. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```env
APP_NAME="Posting Cinta"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=posting_cinta_db
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=file
QUEUE_CONNECTION=database
SESSION_DRIVER=file
```

### 3. Database Setup

```bash
# Buat database terlebih dahulu di MySQL/PostgreSQL
# Lalu jalankan migrations
php artisan migrate

# Seed data awal (users, resep, standar WHO)
php artisan db:seed
```

### 4. Storage Link

```bash
php artisan storage:link
```

### 5. PWA Icons Generation

Buat icon untuk PWA dengan langkah berikut:

**Option A: Manual (Recommended)**

1. Buat logo aplikasi (1024x1024px) dengan background gradasi pink-purple
2. Gunakan online tool: https://realfavicongenerator.net/
3. Upload logo, generate, download
4. Extract ke `public/icons/`
5. Pastikan ada: `icon-192x192.png` dan `icon-512x512.png`

**Option B: Placeholder**

```bash
# Buat folder icons
mkdir public/icons

# Download icon placeholder atau gunakan logo default
# Minimal: icon-192x192.png & icon-512x512.png
```

### 6. Build Assets (Vite)

```bash
# Install NPM dependencies
npm install

# Development (watch mode)
npm run dev
```

**Buka terminal baru**, lalu jalankan:

```bash
# Development server
php artisan serve

# Akses di: http://localhost:8000
```

**PENTING:** Untuk development, jalankan **DUA terminal**:

1. Terminal 1: `npm run dev` (Vite hot-reload)
2. Terminal 2: `php artisan serve` (Laravel server)

Untuk production build:

```bash
npm run build
```

### 7. Testing PWA

1. Buka aplikasi di Chrome/Edge
2. Cek Console untuk service worker registration
3. Test offline mode:
    - Buka DevTools > Network
    - Set "Offline"
    - Reload page → harus tampil offline page
4. Install prompt harus muncul (desktop/mobile)

## 👤 Default Users (Setelah Seeding)

| Email                     | Password | Role      |
| ------------------------- | -------- | --------- |
| admin@postingcinta.id     | password | admin     |
| puskesmas@postingcinta.id | password | puskesmas |
| kader@postingcinta.id     | password | kader     |

## 🎨 Design System

### Color Palette (JAKI-inspired)

-   Primary: `#ec4899` (Pink-500) → Warna utama
-   Secondary: `#8b5cf6` (Purple-500) → Aksen
-   Accent: `#3b82f6` (Blue-500) → Info
-   Success: `#10b981` (Green-500)
-   Warning: `#f59e0b` (Amber-500)
-   Danger: `#ef4444` (Red-500)

### Components

-   **Rounded**: `rounded-2xl` / `rounded-3xl` untuk cards
-   **Shadow**: `shadow-md` / `shadow-lg` / `shadow-xl`
-   **Border**: `border-2` dengan warna soft
-   **Gradients**: `from-pink-50 via-purple-50 to-blue-50`

## 📱 PWA Features

✅ **Install Prompt** - Auto-detect installability  
✅ **Offline Support** - Cache pages & assets  
✅ **Background Sync** - Ready for future enhancement  
✅ **Push Notifications** - Ready for future enhancement  
✅ **Bottom Navigation** - Mobile-first UX  
✅ **Responsive** - Desktop & Mobile optimized

## 🔒 Authentication Flow

1. **Guest** → Redirect ke `/login`
2. **Login** → Redirect ke `/dashboard`
3. **Register** → Auto-login & redirect dashboard
4. **Logout** → Clear session & redirect login

## 📊 Database Structure

-   **users** - Admin, Puskesmas, Kader
-   **puskesmas** - Data puskesmas
-   **posyandu** - Data posyandu per puskesmas
-   **mothers** - Data ibu (linked to user)
-   **children** - Data anak (linked to mother & posyandu)
-   **measurements** - Pengukuran berat/tinggi anak
-   **growth_standards** - Standar WHO z-score
-   **recipes** - Resep makanan sehat
-   **notifications** - In-app notifications (DB-based)

## 🚀 Deployment Tips

### Production Checklist

```bash
# 1. Optimize autoloader
composer install --optimize-autoloader --no-dev

# 2. Cache configs
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Update .env
APP_ENV=production
APP_DEBUG=false
```

### Server Requirements

-   PHP-FPM with OPcache enabled
-   Webserver (Nginx/Apache) with HTTPS
-   Cron job for queue worker:
    ```bash
    * * * * * cd /path/to/app && php artisan schedule:run >> /dev/null 2>&1
    ```

## 🐛 Troubleshooting

### Issue: Service Worker tidak register

**Solution**:

-   Clear browser cache
-   Check Console untuk error
-   Pastikan HTTPS atau localhost

### Issue: Icon tidak muncul

**Solution**:

-   Generate icon di `public/icons/`
-   Clear cache browser
-   Re-register service worker

### Issue: Offline page tidak muncul

**Solution**:

-   Check service-worker.js di DevTools
-   Pastikan OFFLINE_URL di cache
-   Force refresh (Ctrl+Shift+R)

## 📝 Development Notes

### Extending Features

1. **Add New Page**

    ```bash
    # Create controller
    php artisan make:controller FeatureController

    # Add routes in routes/web.php
    # Create views in resources/views/
    ```

2. **Add to Navigation**

    - Edit `resources/views/layouts/app.blade.php`
    - Add menu item di sidebar & bottom nav

3. **Customize PWA**
    - Edit `public/manifest.webmanifest`
    - Update `public/service-worker.js`
    - Update icons

## 🎯 Next Steps

-   [ ] Add real-time notifications
-   [ ] Implement background sync for offline data
-   [ ] Add data visualization charts
-   [ ] Export reports (PDF/Excel)
-   [ ] WhatsApp integration (optional)
-   [ ] Multi-language support

## 📧 Support

Contact: IT Team Dinas Ketahanan Pangan Kab. Muara Enim

---

**Built with ❤️ for Indonesia's Children**
