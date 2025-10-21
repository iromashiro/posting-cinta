# SYSTEM ARCHITECTURE DESIGN (SAD)

## Aplikasi Posting Cinta - PWA Offline-First Architecture

**Versi**: 1.0  
**Tech Stack**: Laravel 11, Blade, Alpine.js, Tailwind CSS, PostgreSQL 17  
**Architecture Pattern**: Monolith MVC + PWA

---

## 1. HIGH-LEVEL ARCHITECTURE

```
┌─────────────────────────────────────────────────────────────────┐
│                         CLIENT LAYER                             │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │              Browser (Chrome/Safari/Firefox)              │  │
│  │                                                            │  │
│  │  ┌──────────────────────────────────────────────────┐    │  │
│  │  │          Service Worker (offline-first)          │    │  │
│  │  │  - Cache static assets (CSS, JS, images)         │    │  │
│  │  │  - Cache API responses (GET only)                │    │  │
│  │  │  - Background sync queue (POST/PUT/DELETE)       │    │  │
│  │  │  - Push notification handler (future)            │    │  │
│  │  └──────────────────────────────────────────────────┘    │  │
│  │                                                            │  │
│  │  ┌──────────────────────────────────────────────────┐    │  │
│  │  │            IndexedDB (local storage)             │    │  │
│  │  │  - Cached children data                          │    │  │
│  │  │  - Cached mothers data                           │    │  │
│  │  │  - Pending measurements (offline mode)           │    │  │
│  │  │  - Sync queue metadata                           │    │  │
│  │  └──────────────────────────────────────────────────┘    │  │
│  │                                                            │  │
│  │  ┌──────────────────────────────────────────────────┐    │  │
│  │  │         Blade Templates + Alpine.js              │    │  │
│  │  │  - Server-side rendered HTML (Blade)             │    │  │
│  │  │  - Client-side reactivity (Alpine.js)            │    │  │
│  │  │  - Tailwind CSS styling                          │    │  │
│  │  └──────────────────────────────────────────────────┘    │  │
│  └──────────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────────┘
                              ▲ │
                        HTTPS │ │ JSON API
                              │ ▼
┌─────────────────────────────────────────────────────────────────┐
│                      APPLICATION LAYER                           │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │                 Laravel 11 (Monolith)                     │  │
│  │                                                            │  │
│  │  [Routes] ──► [Controllers] ──► [Services] ──► [Models]  │  │
│  │                                        │                   │  │
│  │  [Middleware]     [Jobs/Queues]       │                   │  │
│  │    - Auth         - ProcessSyncQueue  │                   │  │
│  │    - CORS         - SendNotifications │                   │  │
│  │    - CSRF         - GenerateReports   │                   │  │
│  │                                        │                   │  │
│  │  [Cache]                               │                   │  │
│  │    storage/framework/cache/            │                   │  │
│  │                                        ▼                   │  │
│  │                          [Eloquent ORM]                    │  │
│  └──────────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────────┘
                              ▲ │
                      SQL/PDO │ │
                              │ ▼
┌─────────────────────────────────────────────────────────────────┐
│                        DATA LAYER                                │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │              PostgreSQL 17 Database                       │  │
│  │                                                            │  │
│  │  [users] [puskesmas] [posyandu] [mothers] [children]     │  │
│  │  [measurements] [growth_standards] [recipes]              │  │
│  │  [notifications] [sync_queue]                             │  │
│  │                                                            │  │
│  │  Indexes, Constraints, Foreign Keys                       │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │              File System Storage                          │  │
│  │  - storage/app/public/recipes/ (recipe images)            │  │
│  │  - storage/framework/cache/ (file cache)                  │  │
│  │  - storage/logs/ (application logs)                       │  │
│  └──────────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────────┘
```

---

## 2. LARAVEL FOLDER STRUCTURE

```
posting-cinta-reborn/
│
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       ├── CalculateZScore.php         # Recalculate Z-scores
│   │       ├── SendPosyanduReminders.php   # Scheduler untuk reminder
│   │       └── CleanOldNotifications.php   # Cleanup notifikasi lama
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                       # Laravel Breeze auth
│   │   │   ├── DashboardController.php     # Dashboard semua role
│   │   │   ├── MotherController.php        # CRUD ibu
│   │   │   ├── ChildController.php         # CRUD anak
│   │   │   ├── MeasurementController.php   # Input & view pengukuran
│   │   │   ├── GrowthChartController.php   # Render WHO charts
│   │   │   ├── RecipeController.php        # CRUD resep
│   │   │   ├── NotificationController.php  # View & mark as read
│   │   │   ├── SyncController.php          # API sync offline data
│   │   │   ├── PuskesmasController.php     # Manage puskesmas (Admin)
│   │   │   ├── PosyanduController.php      # Manage posyandu
│   │   │   └── UserController.php          # Manage users
│   │   │
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php            # Laravel default
│   │   │   ├── CheckRole.php               # RBAC middleware
│   │   │   └── EnsureOnline.php            # Block offline writes to sensitive data
│   │   │
│   │   └── Requests/
│   │       ├── StoreMeasurementRequest.php # Validation untuk measurement
│   │       ├── StoreMotherRequest.php
│   │       ├── StoreChildRequest.php
│   │       └── SyncQueueRequest.php
│   │
│   ├── Models/
│   │   ├── User.php
│   │   ├── Puskesmas.php
│   │   ├── Posyandu.php
│   │   ├── Mother.php
│   │   ├── Child.php
│   │   ├── Measurement.php
│   │   ├── GrowthStandard.php
│   │   ├── Recipe.php
│   │   ├── Notification.php
│   │   └── SyncQueue.php
│   │
│   ├── Services/                            # Business logic layer
│   │   ├── ZScoreService.php               # Z-score calculation
│   │   ├── NutritionStatusService.php      # Klasifikasi status gizi
│   │   ├── GrowthChartService.php          # Generate chart data
│   │   ├── SyncService.php                 # Handle offline sync
│   │   ├── NotificationService.php         # Create notifications
│   │   └── ReportService.php               # Generate reports
│   │
│   ├── Jobs/
│   │   ├── ProcessSyncQueue.php            # Process pending sync
│   │   ├── SendPosyanduReminder.php        # Send reminder notif
│   │   └── GenerateMonthlyReport.php       # Generate laporan bulanan
│   │
│   └── Helpers/
│       └── helpers.php                      # Global helper functions
│
├── bootstrap/
│   ├── app.php
│   └── cache/
│
├── config/
│   ├── app.php
│   ├── database.php                         # PostgreSQL config
│   ├── cache.php                            # File cache config
│   └── pwa.php                              # PWA manifest config (custom)
│
├── database/
│   ├── factories/                           # Model factories untuk testing
│   ├── migrations/                          # Database migrations
│   │   ├── 2024_01_01_create_puskesmas_table.php
│   │   ├── 2024_01_02_create_users_table.php
│   │   ├── 2024_01_03_create_posyandu_table.php
│   │   ├── 2024_01_04_create_mothers_table.php
│   │   ├── 2024_01_05_create_children_table.php
│   │   ├── 2024_01_06_create_measurements_table.php
│   │   ├── 2024_01_07_create_growth_standards_table.php
│   │   ├── 2024_01_08_create_recipes_table.php
│   │   ├── 2024_01_09_create_notifications_table.php
│   │   └── 2024_01_10_create_sync_queue_table.php
│   │
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php                   # Default admin user
│       ├── GrowthStandardSeeder.php         # Load WHO data
│       └── RecipeSeeder.php                 # Sample recipes
│
├── public/
│   ├── index.php
│   ├── manifest.json                        # PWA manifest
│   ├── service-worker.js                    # Service Worker
│   ├── offline.html                         # Offline fallback page
│   │
│   ├── css/
│   │   └── app.css                          # Compiled Tailwind CSS
│   │
│   ├── js/
│   │   ├── app.js                           # Main Alpine.js entry
│   │   ├── sync.js                          # Offline sync logic
│   │   ├── chart.js                         # Chart.js library
│   │   └── alpine.min.js                    # Alpine.js CDN fallback
│   │
│   ├── images/
│   │   ├── icons/                           # PWA icons (192x192, 512x512)
│   │   ├── logo.png
│   │   └── placeholder.png
│   │
│   └── data/
│       └── who-growth-standards.json        # Cached WHO data
│
├── resources/
│   ├── css/
│   │   └── app.css                          # Tailwind source
│   │
│   ├── js/
│   │   ├── app.js                           # Alpine.js components
│   │   ├── bootstrap.js                     # Axios setup
│   │   └── service-worker-register.js       # SW registration
│   │
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php                # Main layout
│       │   ├── navigation.blade.php         # Nav menu (role-based)
│       │   └── offline-banner.blade.php     # Offline status banner
│       │
│       ├── auth/                            # Laravel Breeze views
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       │
│       ├── dashboard/
│       │   ├── admin.blade.php              # Dashboard Admin Dinas
│       │   ├── puskesmas.blade.php          # Dashboard Puskesmas
│       │   └── kader.blade.php              # Dashboard Kader
│       │
│       ├── mothers/
│       │   ├── index.blade.php              # List ibu
│       │   ├── create.blade.php             # Form tambah ibu
│       │   ├── edit.blade.php               # Form edit ibu
│       │   └── show.blade.php               # Detail ibu + anak-anaknya
│       │
│       ├── children/
│       │   ├── index.blade.php              # List anak
│       │   ├── create.blade.php             # Form tambah anak
│       │   ├── edit.blade.php               # Form edit anak
│       │   └── show.blade.php               # Detail anak + riwayat pengukuran
│       │
│       ├── measurements/
│       │   ├── index.blade.php              # List pengukuran
│       │   ├── create.blade.php             # Form input pengukuran
│       │   └── history.blade.php            # Riwayat per anak
│       │
│       ├── growth-charts/
│       │   └── show.blade.php               # Halaman WHO growth charts
│       │
│       ├── recipes/
│       │   ├── index.blade.php              # List resep (filter kategori)
│       │   ├── create.blade.php             # Form tambah resep (Admin)
│       │   ├── edit.blade.php               # Form edit resep
│       │   └── show.blade.php               # Detail resep
│       │
│       ├── notifications/
│       │   └── index.blade.php              # List notifikasi
│       │
│       ├── posyandu/
│       │   ├── index.blade.php              # Manage posyandu
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       │
│       ├── puskesmas/
│       │   ├── index.blade.php              # Manage puskesmas (Admin only)
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       │
│       ├── users/
│       │   ├── index.blade.php              # Manage users
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       │
│       └── components/                      # Reusable Blade components
│           ├── alert.blade.php              # Alert message
│           ├── card.blade.php               # Card wrapper
│           ├── button.blade.php             # Styled button
│           ├── input.blade.php              # Form input
│           ├── select.blade.php             # Form select
│           ├── loading.blade.php            # Loading spinner
│           └── offline-badge.blade.php      # Online/offline indicator
│
├── routes/
│   ├── web.php                              # Web routes (Blade pages)
│   ├── api.php                              # API routes (JSON untuk sync)
│   └── console.php                          # Artisan commands
│
├── storage/
│   ├── app/
│   │   ├── public/
│   │   │   └── recipes/                     # Recipe images
│   │   └── private/
│   │
│   ├── framework/
│   │   ├── cache/                           # File cache storage
│   │   ├── sessions/
│   │   └── views/
│   │
│   └── logs/
│       └── laravel.log
│
├── tests/
│   ├── Feature/                             # Integration tests
│   └── Unit/                                # Unit tests (Services, Models)
│
├── .env                                     # Environment config
├── .env.example
├── artisan                                  # Laravel CLI
├── composer.json
├── package.json                             # NPM dependencies
├── tailwind.config.js                       # Tailwind config
├── vite.config.js                           # Vite build config
└── README.md
```

---

## 3. PWA ARCHITECTURE (Offline-First)

### 3.1 Service Worker Lifecycle

```
┌──────────────────────────────────────────────────────────┐
│          Service Worker Lifecycle & Caching              │
└──────────────────────────────────────────────────────────┘

[1] INSTALL
    ├─ Cache static assets (CSS, JS, images, fonts)
    ├─ Cache offline.html fallback page
    ├─ Cache WHO growth standards JSON
    └─ Pre-cache critical pages (login, dashboard)

[2] ACTIVATE
    ├─ Clean old caches (version-based)
    └─ Claim all clients (take control immediately)

[3] FETCH (Request Interception)
    │
    ├─ Is request for static asset?
    │  └─ YES → Cache First Strategy
    │           └─ Return from cache, fallback to network
    │
    ├─ Is API GET request (read data)?
    │  └─ YES → Network First Strategy
    │           └─ Try network, fallback to cache
    │
    ├─ Is API POST/PUT/DELETE (write data)?
    │  └─ YES → Network Only + Background Sync
    │           ├─ If online → Send immediately
    │           └─ If offline → Queue in IndexedDB + register sync
    │
    └─ Is HTML navigation?
       └─ YES → Network First Strategy
                └─ Try network, fallback to offline.html

[4] BACKGROUND SYNC
    ├─ Triggered when connection restored
    ├─ Process sync_queue from IndexedDB
    ├─ Send queued POST/PUT/DELETE requests
    └─ Update UI on success/failure
```

### 3.2 Cache Strategy Matrix

| Resource Type       | Strategy                | Rationale                                  |
| ------------------- | ----------------------- | ------------------------------------------ |
| CSS, JS, images     | **Cache First**         | Static assets rarely change, fast load     |
| WHO growth data     | **Cache First**         | Large JSON, rarely updated                 |
| HTML pages          | **Network First**       | Dynamic content, but need offline fallback |
| API GET (read)      | **Network First**       | Fresh data preferred, cached as backup     |
| API POST/PUT/DELETE | **Network Only + Sync** | Write operations must reach server         |
| Fonts               | **Cache First**         | Never change, large files                  |
| Recipe images       | **Cache First**         | Large files, infrequent updates            |

### 3.3 Service Worker Implementation

**File**: `public/service-worker.js`

```javascript
const CACHE_VERSION = "v1.0.0";
const CACHE_NAME = `posting-cinta-${CACHE_VERSION}`;

const STATIC_CACHE = [
  "/offline.html",
  "/css/app.css",
  "/js/app.js",
  "/js/alpine.min.js",
  "/js/chart.js",
  "/images/logo.png",
  "/data/who-growth-standards.json",
];

// INSTALL - Pre-cache static assets
self.addEventListener("install", (event) => {
  event.waitUntil(
    caches
      .open(CACHE_NAME)
      .then((cache) => {
        return cache.addAll(STATIC_CACHE);
      })
      .then(() => {
        return self.skipWaiting(); // Activate immediately
      })
  );
});

// ACTIVATE - Clean old caches
self.addEventListener("activate", (event) => {
  event.waitUntil(
    caches
      .keys()
      .then((cacheNames) => {
        return Promise.all(
          cacheNames.map((cacheName) => {
            if (cacheName !== CACHE_NAME) {
              return caches.delete(cacheName);
            }
          })
        );
      })
      .then(() => {
        return self.clients.claim();
      })
  );
});

// FETCH - Intercept requests
self.addEventListener("fetch", (event) => {
  const { request } = event;
  const url = new URL(request.url);

  // Strategy: Cache First (static assets)
  if (
    request.destination === "style" ||
    request.destination === "script" ||
    request.destination === "image" ||
    request.destination === "font"
  ) {
    event.respondWith(
      caches.match(request).then((response) => {
        return response || fetch(request);
      })
    );
    return;
  }

  // Strategy: Network First (API GET)
  if (url.pathname.startsWith("/api") && request.method === "GET") {
    event.respondWith(
      fetch(request)
        .then((response) => {
          // Cache successful responses
          if (response.ok) {
            const responseClone = response.clone();
            caches.open(CACHE_NAME).then((cache) => {
              cache.put(request, responseClone);
            });
          }
          return response;
        })
        .catch(() => {
          // Fallback to cache
          return caches.match(request);
        })
    );
    return;
  }

  // Strategy: Network Only + Background Sync (API POST/PUT/DELETE)
  if (
    url.pathname.startsWith("/api") &&
    ["POST", "PUT", "DELETE"].includes(request.method)
  ) {
    event.respondWith(
      fetch(request).catch(() => {
        // Queue for background sync
        return request
          .clone()
          .text()
          .then((body) => {
            return addToSyncQueue({
              url: request.url,
              method: request.method,
              body: body,
              headers: [...request.headers],
            }).then(() => {
              return new Response(
                JSON.stringify({
                  message: "Queued for sync",
                  offline: true,
                }),
                {
                  status: 202,
                  headers: { "Content-Type": "application/json" },
                }
              );
            });
          });
      })
    );
    return;
  }

  // Strategy: Network First (HTML pages)
  if (request.mode === "navigate") {
    event.respondWith(
      fetch(request).catch(() => {
        return caches.match("/offline.html");
      })
    );
    return;
  }

  // Default: Network First
  event.respondWith(
    fetch(request).catch(() => {
      return caches.match(request);
    })
  );
});

// BACKGROUND SYNC - Process queue when online
self.addEventListener("sync", (event) => {
  if (event.tag === "sync-measurements") {
    event.waitUntil(processSyncQueue());
  }
});

// Helper: Add to IndexedDB sync queue
function addToSyncQueue(requestData) {
  return openDB().then((db) => {
    const tx = db.transaction("sync_queue", "readwrite");
    const store = tx.objectStore("sync_queue");
    return store.add({
      ...requestData,
      timestamp: Date.now(),
      status: "pending",
    });
  });
}

// Helper: Process sync queue
function processSyncQueue() {
  return openDB()
    .then((db) => {
      const tx = db.transaction("sync_queue", "readonly");
      const store = tx.objectStore("sync_queue");
      return store.getAll();
    })
    .then((items) => {
      const promises = items.map((item) => {
        return fetch(item.url, {
          method: item.method,
          body: item.body,
          headers: item.headers,
        }).then((response) => {
          if (response.ok) {
            // Remove from queue on success
            return removeFromSyncQueue(item.id);
          }
        });
      });
      return Promise.all(promises);
    });
}

// Helper: Open IndexedDB
function openDB() {
  return new Promise((resolve, reject) => {
    const request = indexedDB.open("posting-cinta-db", 1);
    request.onsuccess = () => resolve(request.result);
    request.onerror = () => reject(request.error);
    request.onupgradeneeded = (event) => {
      const db = event.target.result;
      if (!db.objectStoreNames.contains("sync_queue")) {
        db.createObjectStore("sync_queue", {
          keyPath: "id",
          autoIncrement: true,
        });
      }
    };
  });
}

// Helper: Remove from sync queue
function removeFromSyncQueue(id) {
  return openDB().then((db) => {
    const tx = db.transaction("sync_queue", "readwrite");
    const store = tx.objectStore("sync_queue");
    return store.delete(id);
  });
}
```

---

## 4. OFFLINE-FIRST DATA FLOW

### 4.1 Input Measurement (Offline → Online)

```
┌──────────────────────────────────────────────────────────────┐
│     Kader Input Measurement (Offline Scenario)               │
└──────────────────────────────────────────────────────────────┘

[1] USER ACTION
    Kader mengisi form input pengukuran
    ├─ Pilih anak (dari cached list)
    ├─ Input BB, TB, LK
    ├─ Tanggal pengukuran
    └─ Click "Simpan"

[2] ALPINE.JS (Client-side)
    Check online status
    │
    ├─ IF ONLINE:
    │  └─ POST /api/measurements
    │     └─ Server save ke DB
    │        └─ Response: success + redirect
    │
    └─ IF OFFLINE:
       ├─ Save to IndexedDB (local storage)
       │  └─ Object: { child_id, weight, height, ... }
       │
       ├─ Register Background Sync
       │  └─ navigator.serviceWorker.ready.then(sw =>
       │       sw.sync.register('sync-measurements'))
       │
       └─ UI Feedback
          └─ Toast: "Data disimpan offline, akan di-sync otomatis"

[3] SERVICE WORKER
    Background Sync Event Triggered (when online)
    │
    ├─ Fetch items from IndexedDB sync_queue
    │
    ├─ For each item:
    │  ├─ POST /api/sync/measurements
    │  │  └─ Payload: { ...measurement_data }
    │  │
    │  ├─ IF SUCCESS (200):
    │  │  ├─ Remove from IndexedDB
    │  │  ├─ Update cache dengan server response
    │  │  └─ Send postMessage ke UI: { status: 'synced' }
    │  │
    │  └─ IF FAILED (4xx/5xx):
    │     ├─ Increment retry_count
    │     ├─ If retry_count > 3:
    │     │  └─ Mark as 'failed' (require manual intervention)
    │     └─ Else:
    │        └─ Keep in queue, retry later (exponential backoff)
    │
    └─ UI UPDATE (via postMessage)
       └─ Toast: "3 data berhasil di-sync"

[4] SERVER (Laravel)
    POST /api/sync/measurements
    │
    ├─ Validate request (FormRequest)
    │
    ├─ Check duplicate (by child_id + measured_at)
    │  └─ If exists: Skip (idempotent)
    │
    ├─ Create Measurement
    │  ├─ Calculate age_months
    │  ├─ Calculate Z-scores (ZScoreService)
    │  ├─ Determine nutrition_status
    │  └─ Save to DB
    │
    ├─ IF stunting/wasting detected:
    │  └─ Create Notification
    │     └─ To: Kader, Puskesmas
    │        Message: "Anak {name} terdeteksi {status}"
    │
    └─ Response: { success: true, data: { id, z_scores, ... } }
```

### 4.2 View Growth Chart (Offline Fallback)

```
┌──────────────────────────────────────────────────────────────┐
│       Kader View Growth Chart (Offline Scenario)             │
└──────────────────────────────────────────────────────────────┘

[1] USER ACTION
    Kader click "Lihat Grafik Pertumbuhan" pada detail anak

[2] BLADE + ALPINE.JS
    GET /growth-charts/{child_id}
    │
    ├─ IF ONLINE:
    │  ├─ Fetch from server
    │  │  └─ GET /api/children/{id}/measurements
    │  │     └─ Returns: [{ measured_at, weight, height, z_scores }]
    │  │
    │  ├─ Cache response in Service Worker
    │  │
    │  └─ Render chart dengan Chart.js
    │     ├─ Load WHO standards (from cache)
    │     ├─ Plot child's measurements
    │     └─ Show growth curves
    │
    └─ IF OFFLINE:
       ├─ Check IndexedDB cache
       │  └─ Key: `child_${id}_measurements`
       │
       ├─ If cached:
       │  ├─ Load dari cache
       │  ├─ Show offline banner
       │  └─ Render chart
       │
       └─ If NOT cached:
          └─ Show message: "Grafik hanya tersedia online atau
             setelah pernah diakses sebelumnya"
```

---

## 5. API ENDPOINTS

### 5.1 Web Routes (Blade SSR)

```php
// routes/web.php

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {

    // Dashboard (role-based view)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Mothers
    Route::resource('mothers', MotherController::class);

    // Children
    Route::resource('children', ChildController::class);

    // Measurements
    Route::resource('measurements', MeasurementController::class);
    Route::get('/children/{child}/measurements', [MeasurementController::class, 'history'])
        ->name('measurements.history');

    // Growth Charts
    Route::get('/children/{child}/growth-chart', [GrowthChartController::class, 'show'])
        ->name('growth-chart.show');

    // Recipes
    Route::resource('recipes', RecipeController::class);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::resource('puskesmas', PuskesmasController::class);
        Route::resource('users', UserController::class);
    });

    // Puskesmas routes
    Route::middleware('role:puskesmas')->group(function () {
        Route::resource('posyandu', PosyanduController::class);
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
```

### 5.2 API Routes (JSON for Sync)

```php
// routes/api.php

Route::middleware('auth:sanctum')->group(function () {

    // Sync endpoints (for offline-first)
    Route::post('/sync/measurements', [SyncController::class, 'syncMeasurements']);
    Route::post('/sync/mothers', [SyncController::class, 'syncMothers']);
    Route::post('/sync/children', [SyncController::class, 'syncChildren']);
    Route::get('/sync/status', [SyncController::class, 'status']);

    // Read endpoints (cacheable)
    Route::get('/children', [ChildController::class, 'apiIndex']);
    Route::get('/children/{child}', [ChildController::class, 'apiShow']);
    Route::get('/children/{child}/measurements', [MeasurementController::class, 'apiHistory']);
    Route::get('/mothers', [MotherController::class, 'apiIndex']);
    Route::get('/recipes', [RecipeController::class, 'apiIndex']);

    // Notifications
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);
});
```

---

## 6. COMPONENT ARCHITECTURE (Alpine.js)

### 6.1 Measurement Input Component

```javascript
// resources/js/components/measurement-form.js

Alpine.data("measurementForm", () => ({
  isOnline: navigator.onLine,
  isSaving: false,
  child: null,
  form: {
    child_id: "",
    measured_at: new Date().toISOString().split("T")[0],
    weight: "",
    height: "",
    head_circumference: "",

    notes: "",
  },

  init() {
    // Listen to online/offline events
    window.addEventListener("online", () => {
      this.isOnline = true;
      this.syncPendingData();
    });

    window.addEventListener("offline", () => {
      this.isOnline = false;
    });
  },

  async submitForm() {
    this.isSaving = true;

    try {
      if (this.isOnline) {
        // Online: Send directly to server
        await this.saveOnline();
      } else {
        // Offline: Save to IndexedDB
        await this.saveOffline();
      }
    } catch (error) {
      this.showError(error.message);
    } finally {
      this.isSaving = false;
    }
  },

  async saveOnline() {
    const response = await fetch("/api/measurements", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
          .content,
      },
      body: JSON.stringify(this.form),
    });

    if (response.ok) {
      this.showSuccess("Data berhasil disimpan");
      window.location.href = `/children/${this.form.child_id}/measurements`;
    } else {
      throw new Error("Gagal menyimpan data");
    }
  },

  async saveOffline() {
    // Save to IndexedDB
    const db = await this.openDB();
    const tx = db.transaction("measurements", "readwrite");
    const store = tx.objectStore("measurements");

    await store.add({
      ...this.form,
      id: "temp_" + Date.now(), // Temporary ID
      synced: false,
      created_at: new Date().toISOString(),
    });

    // Register background sync
    const registration = await navigator.serviceWorker.ready;
    await registration.sync.register("sync-measurements");

    this.showSuccess(
      "Data disimpan offline, akan di-sync otomatis saat online"
    );

    // Redirect to pending sync page
    window.location.href = "/measurements/pending";
  },

  async syncPendingData() {
    // Triggered when back online
    const db = await this.openDB();
    const tx = db.transaction("measurements", "readonly");
    const store = tx.objectStore("measurements");
    const pendingItems = await store.getAll();

    const unsyncedItems = pendingItems.filter((item) => !item.synced);

    if (unsyncedItems.length > 0) {
      this.showInfo(`Syncing ${unsyncedItems.length} pending data...`);
    }
  },

  openDB() {
    return new Promise((resolve, reject) => {
      const request = indexedDB.open("posting-cinta-db", 1);
      request.onsuccess = () => resolve(request.result);
      request.onerror = () => reject(request.error);
      request.onupgradeneeded = (event) => {
        const db = event.target.result;
        if (!db.objectStoreNames.contains("measurements")) {
          db.createObjectStore("measurements", { keyPath: "id" });
        }
      };
    });
  },

  showSuccess(message) {
    // Use Alpine's dispatch or custom toast component
    this.$dispatch("toast", { type: "success", message });
  },

  showError(message) {
    this.$dispatch("toast", { type: "error", message });
  },

  showInfo(message) {
    this.$dispatch("toast", { type: "info", message });
  },
}));
```

### 6.2 Growth Chart Component

```javascript
// resources/js/components/growth-chart.js

Alpine.data("growthChart", (childId, gender) => ({
  isLoading: true,
  measurements: [],
  whoStandards: null,
  chart: null,

  async init() {
    await this.loadData();
    this.renderChart();
  },

  async loadData() {
    try {
      // Load child measurements
      const measurementsResponse = await fetch(
        `/api/children/${childId}/measurements`
      );
      this.measurements = await measurementsResponse.json();

      // Load WHO standards (from cache or server)
      const whoResponse = await fetch("/data/who-growth-standards.json");
      const whoData = await whoResponse.json();
      this.whoStandards = whoData[gender]; // 'male' or 'female'
    } catch (error) {
      console.error("Failed to load chart data:", error);
    } finally {
      this.isLoading = false;
    }
  },

  renderChart() {
    const ctx = document.getElementById("growth-chart").getContext("2d");

    this.chart = new Chart(ctx, {
      type: "line",
      data: {
        datasets: [
          // WHO Standard curves
          {
            label: "+3 SD",
            data: this.whoStandards.height_for_age.map((item) => ({
              x: item.age_months,
              y: item.sd_3,
            })),
            borderColor: "rgba(0, 0, 0, 0.3)",
            backgroundColor: "transparent",
            borderWidth: 1,
            pointRadius: 0,
            borderDash: [5, 5],
          },
          {
            label: "+2 SD",
            data: this.whoStandards.height_for_age.map((item) => ({
              x: item.age_months,
              y: item.sd_2,
            })),
            borderColor: "rgba(255, 206, 86, 0.8)",
            backgroundColor: "transparent",
            borderWidth: 2,
            pointRadius: 0,
          },
          {
            label: "Median",
            data: this.whoStandards.height_for_age.map((item) => ({
              x: item.age_months,
              y: item.sd_0,
            })),
            borderColor: "rgba(75, 192, 192, 1)",
            backgroundColor: "transparent",
            borderWidth: 3,
            pointRadius: 0,
          },
          {
            label: "-2 SD (Stunting)",
            data: this.whoStandards.height_for_age.map((item) => ({
              x: item.age_months,
              y: item.sd_neg2,
            })),
            borderColor: "rgba(255, 99, 132, 0.8)",
            backgroundColor: "transparent",
            borderWidth: 2,
            pointRadius: 0,
          },
          {
            label: "-3 SD (Severe Stunting)",
            data: this.whoStandards.height_for_age.map((item) => ({
              x: item.age_months,
              y: item.sd_neg3,
            })),
            borderColor: "rgba(255, 0, 0, 0.8)",
            backgroundColor: "transparent",
            borderWidth: 1,
            pointRadius: 0,
            borderDash: [5, 5],
          },
          // Child's actual measurements
          {
            label: "Pengukuran Anak",
            data: this.measurements.map((m) => ({
              x: m.age_months,
              y: m.height,
            })),
            borderColor: "rgba(54, 162, 235, 1)",
            backgroundColor: "rgba(54, 162, 235, 0.5)",
            borderWidth: 3,
            pointRadius: 6,
            pointHoverRadius: 8,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            type: "linear",
            title: {
              display: true,
              text: "Umur (bulan)",
            },
          },
          y: {
            title: {
              display: true,
              text: "Tinggi Badan (cm)",
            },
          },
        },
        plugins: {
          legend: {
            display: true,
            position: "bottom",
          },
          tooltip: {
            callbacks: {
              label: (context) => {
                return `${context.dataset.label}: ${context.parsed.y.toFixed(
                  1
                )} cm`;
              },
            },
          },
        },
      },
    });
  },
}));
```

---

## 7. DEPLOYMENT ARCHITECTURE

### 7.1 Development Environment

```
Local Machine
├── PHP 8.2+
├── Composer 2.x
├── Node.js 18+ & NPM
├── PostgreSQL 17 (via Docker or native)
└── Git

Commands:
$ composer install
$ npm install
$ cp .env.example .env
$ php artisan key:generate
$ php artisan migrate --seed
$ npm run dev
$ php artisan serve
```

### 7.2 Production Environment

```
VPS/Cloud Server (Recommended: DigitalOcean, AWS Lightsail)
├── Ubuntu 22.04 LTS
├── Nginx 1.24+
├── PHP 8.2-FPM
├── PostgreSQL 17
├── Supervisor (untuk queue worker)
└── Let's Encrypt SSL

Directory Structure:
/var/www/posting-cinta/
├── current/ → symlink to latest release
├── releases/
│   ├── 2024-10-12_10-30-00/
│   └── 2024-10-13_08-15-00/
├── shared/
│   ├── .env
│   ├── storage/
│   └── public/storage/
└── repo/
```

### 7.3 Deployment Process (Git-based)

```bash
# On server (automated via deploy script)
cd /var/www/posting-cinta/repo
git pull origin main

# Create new release directory
RELEASE_DIR="releases/$(date +%Y-%m-%d_%H-%M-%S)"
mkdir -p /var/www/posting-cinta/$RELEASE_DIR

# Copy files
cp -r /var/www/posting-cinta/repo/* /var/www/posting-cinta/$RELEASE_DIR/

# Link shared resources
ln -s /var/www/posting-cinta/shared/.env /var/www/posting-cinta/$RELEASE_DIR/.env
ln -s /var/www/posting-cinta/shared/storage /var/www/posting-cinta/$RELEASE_DIR/storage

# Install dependencies
cd /var/www/posting-cinta/$RELEASE_DIR
composer install --no-dev --optimize-autoloader
npm install --production
npm run build

# Run migrations
php artisan migrate --force

# Clear cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Switch symlink
ln -sfn /var/www/posting-cinta/$RELEASE_DIR /var/www/posting-cinta/current

# Reload PHP-FPM
sudo systemctl reload php8.2-fpm

# Restart queue worker
sudo supervisorctl restart posting-cinta-worker:*
```

### 7.4 Nginx Configuration

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name postingcinta.muaraenim.go.id;

    # Redirect HTTP to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name postingcinta.muaraenim.go.id;

    root /var/www/posting-cinta/current/public;
    index index.php index.html;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/postingcinta.muaraenim.go.id/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/postingcinta.muaraenim.go.id/privkey.pem;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;

    # Gzip compression
    gzip on;
    gzip_types text/plain text/css application/json application/javascript text/xml application/xml;

    # Cache static assets
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

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

    # Deny access to hidden files
    location ~ /\. {
        deny all;
    }
}
```

### 7.5 Supervisor Configuration (Queue Worker)

```ini
[program:posting-cinta-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/posting-cinta/current/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/posting-cinta/shared/storage/logs/worker.log
stopwaitsecs=3600
```

---

## 8. CACHING STRATEGY

### 8.1 File Cache (Laravel)

```php
// config/cache.php

'default' => env('CACHE_DRIVER', 'file'),

'stores' => [
    'file' => [
        'driver' => 'file',
        'path' => storage_path('framework/cache/data'),
    ],
],
```

**What to Cache**:

- WHO growth standards (Cache forever, manual invalidation)
- User permissions (Cache 1 hour)
- Posyandu schedules (Cache 1 day)
- Dashboard statistics (Cache 15 minutes, tag-based invalidation)

```php
// Example: Cache WHO standards
Cache::rememberForever('who_growth_standards', function () {
    return GrowthStandard::all()->groupBy(['gender', 'indicator']);
});

// Example: Cache dashboard stats
Cache::remember('dashboard_kader_' . auth()->id(), 900, function () {
    return [
        'total_children' => Child::where('posyandu_id', auth()->user()->posyandu_id)->count(),
        'stunting_count' => Measurement::where('nutrition_status', 'stunting')->count(),
        // ... more stats
    ];
});
```

### 8.2 Browser Cache (Service Worker)

**Cache Duration**:

- Static assets (CSS, JS, images): 1 year (cache busting via Vite)
- WHO growth charts JSON: Forever (versioned filename)
- HTML pages: Network First (always fetch fresh)
- API responses: 5 minutes (stale-while-revalidate)

---

## 9. SECURITY MEASURES

### 9.1 Authentication & Authorization

```php
// Middleware: CheckRole
public function handle($request, Closure $next, ...$roles)
{
    if (!in_array(auth()->user()->role, $roles)) {
        abort(403, 'Unauthorized access');
    }
    return $next($request);
}

// Usage in routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('puskesmas', PuskesmasController::class);
});
```

### 9.2 Input Validation

```php
// app/Http/Requests/StoreMeasurementRequest.php
public function rules()
{
    return [
        'child_id' => 'required|exists:children,id',
        'measured_at' => 'required|date|before_or_equal:today',
        'weight' => 'required|numeric|min:1|max:200',
        'height' => 'required|numeric|min:30|max:250',
        'head_circumference' => 'nullable|numeric|min:20|max:100',

    ];
}
```

### 9.3 CSRF Protection

```blade
{{-- All forms must include CSRF token --}}
<form method="POST" action="/measurements">
    @csrf
    {{-- form fields --}}
</form>
```

### 9.4 SQL Injection Prevention

```php
// ✅ CORRECT: Use Eloquent ORM or Query Builder
$children = Child::where('posyandu_id', $posyanduId)->get();

// ❌ WRONG: Raw SQL without bindings
DB::select("SELECT * FROM children WHERE posyandu_id = $posyanduId");
```

---

## 10. MONITORING & LOGGING

### 10.1 Application Logs

```php
// Log important events
Log::info('Measurement created', [
    'child_id' => $measurement->child_id,
    'z_scores' => $measurement->z_scores,
    'nutrition_status' => $measurement->nutrition_status
]);

// Log sync events
Log::channel('sync')->info('Offline data synced', [
    'user_id' => $userId,
    'items_count' => $syncedCount
]);
```

### 10.2 Error Tracking

```php
// app/Exceptions/Handler.php
public function report(Throwable $exception)
{
    if ($this->shouldReport($exception)) {
        Log::error('Application error', [
            'exception' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'user_id' => auth()->id()
        ]);
    }

    parent::report($exception);
}
```

### 10.3 Performance Monitoring

```php
// Track slow queries (in AppServiceProvider)
DB::listen(function ($query) {
    if ($query->time > 1000) { // > 1 second
        Log::warning('Slow query detected', [
            'sql' => $query->sql,
            'time' => $query->time,
            'bindings' => $query->bindings
        ]);
    }
});
```

---

**END OF SYSTEM ARCHITECTURE DOCUMENT**
