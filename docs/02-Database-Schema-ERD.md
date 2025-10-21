# DATABASE SCHEMA DESIGN

## Aplikasi Posting Cinta - Entity Relationship Diagram

**Versi**: 1.0  
**Database**: PostgreSQL 17  
**ORM**: Laravel Eloquent 11

---

## 1. ENTITY RELATIONSHIP DIAGRAM (ERD)

```
┌─────────────────────┐
│       users         │
│─────────────────────│
│ id (PK)             │◄──┐
│ name                │   │
│ email (unique)      │   │
│ password            │   │
│ role (enum)         │   │
│ puskesmas_id (FK)   │───┼───┐
│ is_active           │   │   │
│ last_login_at       │   │   │
│ created_at          │   │   │
│ updated_at          │   │   │
└─────────────────────┘   │   │
                          │   │
┌─────────────────────┐   │   │
│    puskesmas        │◄──┘   │
│─────────────────────│       │
│ id (PK)             │       │
│ code (unique)       │       │
│ name                │       │
│ address             │       │
│ district            │       │
│ phone               │       │
│ is_active           │       │
│ created_at          │       │
│ updated_at          │       │
└─────────────────────┘       │
         ▲                    │
         │                    │
         │                    │
┌─────────────────────┐       │
│     posyandu        │       │
│─────────────────────│       │
│ id (PK)             │       │
│ code (unique)       │       │
│ name                │       │
│ puskesmas_id (FK)   │───────┘
│ kader_id (FK)       │───────┐
│ address             │       │
│ rt                  │       │
│ rw                  │       │
│ village             │       │
│ district            │       │
│ schedule_day        │       │
│ schedule_date       │       │
│ is_active           │       │
│ created_at          │       │
│ updated_at          │       │
└─────────────────────┘       │
         ▲                    │
         │                    │
         │                    │
┌─────────────────────┐       │
│      mothers        │       │
│─────────────────────│       │
│ id (PK)             │       │
│ nik (unique)        │       │
│ name                │       │
│ date_of_birth       │       │
│ phone               │       │
│ address             │       │
│ rt                  │       │
│ rw                  │       │
│ village             │       │
│ district            │       │
│ posyandu_id (FK)    │───────┤
│ created_by (FK)     │───────┼───────┐
│ created_at          │       │       │
│ updated_at          │       │       │
└─────────────────────┘       │       │
         ▲                    │       │
         │                    │       │
         │ 1:N                │       │
         │                    │       │
┌─────────────────────┐       │       │
│     children        │       │       │
│─────────────────────│       │       │
│ id (PK)             │       │       │
│ nik (nullable)      │       │       │
│ name                │       │       │
│ gender (enum)       │       │       │
│ date_of_birth       │       │       │
│ mother_id (FK)      │───────┘       │
│ posyandu_id (FK)    │───────────────┤
│ is_active           │               │
│ created_by (FK)     │───────────────┤
│ created_at          │               │
│ updated_at          │               │
└─────────────────────┘               │
         ▲                            │
         │                            │
         │ 1:N                        │
         │                            │
┌─────────────────────┐               │
│   measurements      │               │
│─────────────────────│               │
│ id (PK)             │               │
│ child_id (FK)       │───────────────┘
│ measured_at (date)  │
│ weight (decimal)    │         ┌─────────────────────┐
│ height (decimal)    │         │ growth_standards    │
│ head_circumference  │         │─────────────────────│
         │ id (PK)             │
│ age_months          │         │ gender (enum)       │
│ weight_for_age_z    │◄────────│ age_months          │
│ height_for_age_z    │         │ indicator (enum)    │
│ weight_for_height_z │         │ sd_neg3             │
│ nutrition_status    │         │ sd_neg2             │
│ notes               │         │ sd_neg1             │
│ created_by (FK)     │         │ sd_0 (median)       │
│ synced_at           │         │ sd_1                │
│ created_at          │         │ sd_2                │
│ updated_at          │         │ sd_3                │
└─────────────────────┘         │ created_at          │
                                └─────────────────────┘

┌─────────────────────┐
│      recipes        │
│─────────────────────│
│ id (PK)             │
│ title               │
│ slug (unique)       │
│ age_category (enum) │
│ image_path          │
│ ingredients (text)  │
│ instructions (text) │
│ nutrition_info      │
│ calories            │
│ protein             │
│ carbohydrate        │
│ created_by (FK)     │
│ is_published        │
│ created_at          │
│ updated_at          │
└─────────────────────┘

┌─────────────────────┐
│   notifications     │
│─────────────────────│
│ id (PK)             │
│ user_id (FK)        │
│ type (enum)         │
│ title               │
│ message             │
│ data (json)         │
│ read_at             │
│ created_at          │
└─────────────────────┘

┌─────────────────────┐
│    sync_queue       │
│─────────────────────│
│ id (PK)             │
│ user_id (FK)        │
│ entity_type (enum)  │
│ entity_id           │
│ action (enum)       │
│ payload (json)      │
│ status (enum)       │
│ error_message       │
│ attempts            │
│ synced_at           │
│ created_at          │
│ updated_at          │
└─────────────────────┘
```

---

## 2. TABLE DEFINITIONS

### 2.1 `users` - Tabel Pengguna Sistem

**Purpose**: Menyimpan data user (Admin Dinas, Puskesmas, Kader)

```sql
CREATE TABLE users (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL CHECK (role IN ('admin', 'puskesmas', 'kader')),
    puskesmas_id BIGINT NULL REFERENCES puskesmas(id) ON DELETE SET NULL,
    is_active BOOLEAN DEFAULT true,
    last_login_at TIMESTAMP,
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_users_puskesmas_id ON users(puskesmas_id);
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_is_active ON users(is_active);
```

**Fields**:

- `id`: Primary key
- `name`: Nama lengkap user
- `email`: Email (unique) untuk login
- `password`: Hashed password (bcrypt)
- `role`: Enum ('admin', 'puskesmas', 'kader')
- `puskesmas_id`: FK ke tabel puskesmas (NULL untuk admin)
- `is_active`: Status aktif user
- `last_login_at`: Timestamp login terakhir

**Laravel Model**: `App\Models\User`

**Relationships**:

- `belongsTo`: `puskesmas`
- `hasMany`: `posyandu` (via kader)
- `hasMany`: `notifications`
- `hasMany`: `measurements` (created_by)

---

### 2.2 `puskesmas` - Tabel Puskesmas

**Purpose**: Menyimpan data puskesmas sebagai pusat koordinasi kader

```sql
CREATE TABLE puskesmas (
    id BIGSERIAL PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    district VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_puskesmas_code ON puskesmas(code);
CREATE INDEX idx_puskesmas_district ON puskesmas(district);
CREATE INDEX idx_puskesmas_is_active ON puskesmas(is_active);
```

**Fields**:

- `id`: Primary key
- `code`: Kode unik puskesmas (e.g., "PKM-001")
- `name`: Nama puskesmas
- `address`: Alamat lengkap
- `district`: Kecamatan
- `phone`: Nomor telepon
- `is_active`: Status aktif

**Laravel Model**: `App\Models\Puskesmas`

**Relationships**:

- `hasMany`: `users` (pengelola puskesmas)
- `hasMany`: `posyandu`

---

### 2.3 `posyandu` - Tabel Posyandu

**Purpose**: Menyimpan data posyandu tempat monitoring anak dilakukan

```sql
CREATE TABLE posyandu (
    id BIGSERIAL PRIMARY KEY,
    code VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    puskesmas_id BIGINT NOT NULL REFERENCES puskesmas(id) ON DELETE CASCADE,
    kader_id BIGINT NULL REFERENCES users(id) ON DELETE SET NULL,
    address TEXT NOT NULL,
    rt VARCHAR(10),
    rw VARCHAR(10),
    village VARCHAR(100) NOT NULL,
    district VARCHAR(100) NOT NULL,
    schedule_day VARCHAR(20), -- 'Monday', 'Tuesday', etc
    schedule_date INT, -- tanggal setiap bulan (1-31)
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_posyandu_code ON posyandu(code);
CREATE INDEX idx_posyandu_puskesmas_id ON posyandu(puskesmas_id);
CREATE INDEX idx_posyandu_kader_id ON posyandu(kader_id);
CREATE INDEX idx_posyandu_village ON posyandu(village);
CREATE INDEX idx_posyandu_is_active ON posyandu(is_active);
```

**Fields**:

- `id`: Primary key
- `code`: Kode unik posyandu (e.g., "PSY-001")
- `name`: Nama posyandu
- `puskesmas_id`: FK ke puskesmas induk
- `kader_id`: FK ke user kader yang mengelola
- `address`, `rt`, `rw`, `village`, `district`: Alamat lengkap
- `schedule_day`: Hari jadwal rutin (optional)
- `schedule_date`: Tanggal jadwal rutin setiap bulan (1-31)
- `is_active`: Status aktif

**Laravel Model**: `App\Models\Posyandu`

**Relationships**:

- `belongsTo`: `puskesmas`
- `belongsTo`: `kader` (User model)
- `hasMany`: `mothers`
- `hasMany`: `children`

---

### 2.4 `mothers` - Tabel Data Ibu

**Purpose**: Menyimpan data ibu dari anak yang dimonitor

```sql
CREATE TABLE mothers (
    id BIGSERIAL PRIMARY KEY,
    nik VARCHAR(16) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    date_of_birth DATE NOT NULL,
    phone VARCHAR(20),
    address TEXT NOT NULL,
    rt VARCHAR(10),
    rw VARCHAR(10),
    village VARCHAR(100) NOT NULL,
    district VARCHAR(100) NOT NULL,
    posyandu_id BIGINT NOT NULL REFERENCES posyandu(id) ON DELETE CASCADE,
    created_by BIGINT NOT NULL REFERENCES users(id) ON DELETE RESTRICT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_mothers_nik ON mothers(nik);
CREATE INDEX idx_mothers_name ON mothers(name);
CREATE INDEX idx_mothers_posyandu_id ON mothers(posyandu_id);
CREATE INDEX idx_mothers_village ON mothers(village);
CREATE INDEX idx_mothers_created_by ON mothers(created_by);
```

**Fields**:

- `id`: Primary key
- `nik`: NIK ibu (16 digit, unique)
- `name`: Nama lengkap ibu
- `date_of_birth`: Tanggal lahir
- `phone`: Nomor HP (optional)
- `address`, `rt`, `rw`, `village`, `district`: Alamat lengkap
- `posyandu_id`: FK ke posyandu tempat terdaftar
- `created_by`: FK ke user yang input data

**Laravel Model**: `App\Models\Mother`

**Relationships**:

- `belongsTo`: `posyandu`
- `belongsTo`: `creator` (User model)
- `hasMany`: `children` (1 ibu → N anak) ⚠️ PENTING

---

### 2.5 `children` - Tabel Data Anak

**Purpose**: Menyimpan data anak yang dimonitor pertumbuhannya

```sql
CREATE TABLE children (
    id BIGSERIAL PRIMARY KEY,
    nik VARCHAR(16) UNIQUE NULL, -- nullable untuk bayi baru lahir
    name VARCHAR(255) NOT NULL,
    gender VARCHAR(10) NOT NULL CHECK (gender IN ('male', 'female')),
    date_of_birth DATE NOT NULL,
    mother_id BIGINT NOT NULL REFERENCES mothers(id) ON DELETE CASCADE,
    posyandu_id BIGINT NOT NULL REFERENCES posyandu(id) ON DELETE CASCADE,
    is_active BOOLEAN DEFAULT true,
    created_by BIGINT NOT NULL REFERENCES users(id) ON DELETE RESTRICT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_children_nik ON children(nik);
CREATE INDEX idx_children_name ON children(name);
CREATE INDEX idx_children_gender ON children(gender);
CREATE INDEX idx_children_mother_id ON children(mother_id);
CREATE INDEX idx_children_posyandu_id ON children(posyandu_id);
CREATE INDEX idx_children_date_of_birth ON children(date_of_birth);
CREATE INDEX idx_children_is_active ON children(is_active);
```

**Fields**:

- `id`: Primary key
- `nik`: NIK anak (nullable untuk bayi baru lahir belum punya NIK)
- `name`: Nama lengkap anak
- `gender`: Enum ('male', 'female') - PENTING untuk WHO chart
- `date_of_birth`: Tanggal lahir (untuk hitung umur)
- `mother_id`: FK ke ibu ⚠️ RELASI PENTING (1 ibu → N anak)
- `posyandu_id`: FK ke posyandu tempat terdaftar
- `is_active`: Status aktif (false jika pindah/meninggal)
- `created_by`: FK ke user yang input data

**Laravel Model**: `App\Models\Child`

**Relationships**:

- `belongsTo`: `mother` ⚠️ PENTING
- `belongsTo`: `posyandu`
- `belongsTo`: `creator` (User model)
- `hasMany`: `measurements` (riwayat pengukuran)

---

### 2.6 `measurements` - Tabel Data Pengukuran

**Purpose**: Menyimpan riwayat pengukuran pertumbuhan anak (BB, TB, LK)

```sql
CREATE TABLE measurements (
    id BIGSERIAL PRIMARY KEY,
    child_id BIGINT NOT NULL REFERENCES children(id) ON DELETE CASCADE,
    measured_at DATE NOT NULL,
    weight DECIMAL(5,2) NOT NULL, -- kg, max 999.99
    height DECIMAL(5,2) NOT NULL, -- cm, max 999.99
    head_circumference DECIMAL(5,2), -- cm, optional

    age_months INT NOT NULL, -- calculated from date_of_birth
    weight_for_age_z DECIMAL(5,2), -- Z-score BB/U
    height_for_age_z DECIMAL(5,2), -- Z-score TB/U
    weight_for_height_z DECIMAL(5,2), -- Z-score BB/TB
    nutrition_status VARCHAR(50), -- calculated status
    notes TEXT,
    created_by BIGINT NOT NULL REFERENCES users(id) ON DELETE RESTRICT,
    synced_at TIMESTAMP, -- timestamp saat data ter-sync dari offline
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_measurements_child_id ON measurements(child_id);
CREATE INDEX idx_measurements_measured_at ON measurements(measured_at);
CREATE INDEX idx_measurements_age_months ON measurements(age_months);
CREATE INDEX idx_measurements_nutrition_status ON measurements(nutrition_status);
CREATE INDEX idx_measurements_created_by ON measurements(created_by);
CREATE INDEX idx_measurements_synced_at ON measurements(synced_at);

-- Composite index untuk query grafik (child + tanggal)
CREATE INDEX idx_measurements_child_date ON measurements(child_id, measured_at);
```

**Fields**:

- `id`: Primary key
- `child_id`: FK ke anak
- `measured_at`: Tanggal pengukuran (bisa beda dengan created_at)
- `weight`: Berat badan (kg, 2 desimal)
- `height`: Tinggi badan (cm, 2 desimal)
- `head_circumference`: Lingkar kepala (cm, optional)

- `age_months`: Umur dalam bulan saat diukur (calculated)
- `weight_for_age_z`: Z-score BB/U (calculated)
- `height_for_age_z`: Z-score TB/U (calculated)
- `weight_for_height_z`: Z-score BB/TB (calculated)
- `nutrition_status`: Status gizi hasil klasifikasi (e.g., 'normal', 'stunting', 'severely_stunted', 'wasting', 'underweight')
- `notes`: Catatan tambahan kader
- `created_by`: FK ke user yang input
- `synced_at`: Timestamp sync dari offline (NULL jika langsung online)

**Laravel Model**: `App\Models\Measurement`

**Relationships**:

- `belongsTo`: `child`
- `belongsTo`: `creator` (User model)

**Business Logic**:

- `age_months` calculated: `floor(months between date_of_birth and measured_at)`
- Z-scores calculated via WHO algorithm (interpolation dari growth_standards)
- `nutrition_status` determined by Z-score thresholds

---

### 2.7 `growth_standards` - Tabel Standar WHO

**Purpose**: Menyimpan data standar pertumbuhan WHO (reference curves)

```sql
CREATE TABLE growth_standards (
    id BIGSERIAL PRIMARY KEY,
    gender VARCHAR(10) NOT NULL CHECK (gender IN ('male', 'female')),
    age_months INT NOT NULL, -- 0-60 months
    indicator VARCHAR(20) NOT NULL, -- 'weight_for_age', 'height_for_age', 'weight_for_height'
    sd_neg3 DECIMAL(6,3), -- -3 SD
    sd_neg2 DECIMAL(6,3), -- -2 SD
    sd_neg1 DECIMAL(6,3), -- -1 SD
    sd_0 DECIMAL(6,3), -- median (0 SD)
    sd_1 DECIMAL(6,3), -- +1 SD
    sd_2 DECIMAL(6,3), -- +2 SD
    sd_3 DECIMAL(6,3), -- +3 SD
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_growth_standards_lookup ON growth_standards(gender, age_months, indicator);
CREATE UNIQUE INDEX idx_growth_standards_unique ON growth_standards(gender, age_months, indicator);
```

**Fields**:

- `id`: Primary key
- `gender`: 'male' atau 'female'
- `age_months`: Umur dalam bulan (0-60 untuk anak 0-5 tahun)
- `indicator`: Jenis indikator ('weight_for_age', 'height_for_age', 'weight_for_height')
- `sd_neg3` s/d `sd_3`: Nilai standar deviasi dari WHO

**Data Source**: WHO Growth Charts 2006 (JSON format)

**Laravel Model**: `App\Models\GrowthStandard`

**Usage**: Untuk interpolasi Z-score calculation

---

### 2.8 `recipes` - Tabel Resep Makanan

**Purpose**: Menyimpan resep makanan sehat untuk berbagai usia anak

```sql
CREATE TABLE recipes (
    id BIGSERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    age_category VARCHAR(50) NOT NULL CHECK (age_category IN ('mpasi_6_12', 'balita_1_3', 'anak_3_5')),
    image_path VARCHAR(500),
    ingredients TEXT NOT NULL,
    instructions TEXT NOT NULL,
    nutrition_info TEXT,
    calories INT,
    protein DECIMAL(5,2),
    carbohydrate DECIMAL(5,2),
    created_by BIGINT NOT NULL REFERENCES users(id) ON DELETE RESTRICT,
    is_published BOOLEAN DEFAULT false,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_recipes_slug ON recipes(slug);
CREATE INDEX idx_recipes_age_category ON recipes(age_category);
CREATE INDEX idx_recipes_is_published ON recipes(is_published);
CREATE INDEX idx_recipes_created_by ON recipes(created_by);

-- Full-text search index untuk title & ingredients
CREATE INDEX idx_recipes_search ON recipes USING gin(to_tsvector('indonesian', title || ' ' || ingredients));
```

**Fields**:

- `id`: Primary key
- `title`: Judul resep
- `slug`: URL-friendly slug (auto-generated)
- `age_category`: Enum ('mpasi_6_12', 'balita_1_3', 'anak_3_5')
- `image_path`: Path ke foto resep (storage/recipes/)
- `ingredients`: Bahan-bahan (JSON atau newline-separated text)
- `instructions`: Cara membuat (step-by-step text)
- `nutrition_info`: Info gizi tambahan (optional text)
- `calories`: Kalori per porsi (optional)
- `protein`: Protein gram (optional)
- `carbohydrate`: Karbohidrat gram (optional)
- `created_by`: FK ke user yang buat resep (Admin)
- `is_published`: Status publikasi (hanya published yang tampil)

**Laravel Model**: `App\Models\Recipe`

**Relationships**:

- `belongsTo`: `creator` (User model)

---

### 2.9 `notifications` - Tabel Notifikasi In-App

**Purpose**: Menyimpan notifikasi untuk user (DB-driven, NO email/SMS)

```sql
CREATE TABLE notifications (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    type VARCHAR(50) NOT NULL, -- 'posyandu_schedule', 'stunting_alert', 'input_reminder', 'monthly_report'
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    data JSONB, -- additional data (e.g., child_id, measurement_id)
    read_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_notifications_user_id ON notifications(user_id);
CREATE INDEX idx_notifications_type ON notifications(type);
CREATE INDEX idx_notifications_read_at ON notifications(read_at);
CREATE INDEX idx_notifications_created_at ON notifications(created_at DESC);

-- Composite index untuk unread notifications per user
CREATE INDEX idx_notifications_user_unread ON notifications(user_id, read_at) WHERE read_at IS NULL;
```

**Fields**:

- `id`: Primary key
- `user_id`: FK ke user penerima notifikasi
- `type`: Jenis notifikasi (enum string)
- `title`: Judul notifikasi (short)
- `message`: Isi pesan notifikasi
- `data`: JSON data tambahan (e.g., `{"child_id": 123, "status": "stunting"}`)
- `read_at`: Timestamp saat dibaca (NULL = unread)
- `created_at`: Timestamp notifikasi dibuat

**Notification Types**:

1. `posyandu_schedule`: Reminder jadwal posyandu (H-3, H-1, H-0)
2. `stunting_alert`: Alert anak terdeteksi stunting/wasting
3. `input_reminder`: Reminder input data (H+7 setelah posyandu)
4. `monthly_report`: Laporan bulanan untuk Puskesmas/Dinas

**Laravel Model**: `App\Models\Notification`

**Relationships**:

- `belongsTo`: `user`

**Business Logic**:

- Notifications created via Laravel Job/Scheduler
- Mark as read: update `read_at` = now()
- Auto-delete old notifications (> 3 bulan)

---

### 2.10 `sync_queue` - Tabel Antrian Sync Offline

**Purpose**: Menyimpan antrian data yang belum ter-sync dari mode offline

```sql
CREATE TABLE sync_queue (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    entity_type VARCHAR(50) NOT NULL, -- 'measurement', 'mother', 'child'
    entity_id BIGINT, -- ID lokal (dari IndexedDB) sebelum sync
    action VARCHAR(20) NOT NULL CHECK (action IN ('create', 'update', 'delete')),
    payload JSONB NOT NULL, -- data yang akan di-sync
    status VARCHAR(20) DEFAULT 'pending' CHECK (status IN ('pending', 'syncing', 'success', 'failed')),
    error_message TEXT,
    attempts INT DEFAULT 0,
    synced_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_sync_queue_user_id ON sync_queue(user_id);
CREATE INDEX idx_sync_queue_status ON sync_queue(status);
CREATE INDEX idx_sync_queue_entity ON sync_queue(entity_type, entity_id);
CREATE INDEX idx_sync_queue_created_at ON sync_queue(created_at);

-- Composite index untuk pending sync per user
CREATE INDEX idx_sync_queue_user_pending ON sync_queue(user_id, status) WHERE status = 'pending';
```

**Fields**:

- `id`: Primary key
- `user_id`: FK ke user yang create data offline
- `entity_type`: Jenis entitas ('measurement', 'mother', 'child')
- `entity_id`: ID lokal sebelum sync (untuk update IndexedDB setelah sync)
- `action`: Aksi yang dilakukan ('create', 'update', 'delete')
- `payload`: JSON data lengkap yang akan di-sync
- `status`: Status sync ('pending', 'syncing', 'success', 'failed')
- `error_message`: Pesan error jika sync gagal
- `attempts`: Jumlah percobaan sync (max 3x, then failed)
- `synced_at`: Timestamp saat berhasil sync
- `created_at`: Timestamp saat data masuk queue

**Laravel Model**: `App\Models\SyncQueue`

**Relationships**:

- `belongsTo`: `user`

**Business Logic**:

- Created by Service Worker background sync
- Processed by Laravel Job: `ProcessSyncQueue`
- Retry policy: Exponential backoff (1min, 5min, 15min)
- Auto-delete after 7 days (success or permanent failure)

---

## 3. INDEXES STRATEGY

### 3.1 Primary Indexes (PK)

Semua tabel menggunakan `BIGSERIAL` untuk primary key (auto-increment 64-bit).

### 3.2 Foreign Key Indexes

Semua FK memiliki index untuk optimasi JOIN queries.

### 3.3 Composite Indexes

- `measurements(child_id, measured_at)`: Untuk query grafik pertumbuhan
- `notifications(user_id, read_at)`: Untuk unread count
- `sync_queue(user_id, status)`: Untuk pending sync per user
- `growth_standards(gender, age_months, indicator)`: Untuk Z-score lookup

### 3.4 Full-Text Search

- `recipes`: GIN index untuk search title & ingredients (PostgreSQL)

### 3.5 Partial Indexes

- `notifications WHERE read_at IS NULL`: Untuk unread notifications (hemat space)
- `sync_queue WHERE status = 'pending'`: Untuk pending sync queue

---

## 4. DATA INTEGRITY RULES

### 4.1 Referential Integrity

- **CASCADE**: Jika parent dihapus, child juga dihapus

  - `puskesmas → posyandu`
  - `posyandu → mothers, children`
  - `mother → children`
  - `child → measurements`
  - `user → notifications, sync_queue`

- **RESTRICT**: Tidak boleh hapus parent jika ada child
  - `user (creator) → mothers, children, measurements`
- **SET NULL**: Set FK jadi NULL jika parent dihapus
  - `puskesmas → users` (pengelola bisa pindah/resign)
  - `kader → posyandu` (kader bisa resign)

### 4.2 Check Constraints

- `users.role`: IN ('admin', 'puskesmas', 'kader')
- `children.gender`: IN ('male', 'female')
- `growth_standards.gender`: IN ('male', 'female')
- `recipes.age_category`: IN ('mpasi_6_12', 'balita_1_3', 'anak_3_5')
- `sync_queue.action`: IN ('create', 'update', 'delete')
- `sync_queue.status`: IN ('pending', 'syncing', 'success', 'failed')

### 4.3 Unique Constraints

- `users.email`: Unique (login credential)
- `puskesmas.code`: Unique (kode puskesmas)
- `posyandu.code`: Unique (kode posyandu)
- `mothers.nik`: Unique (NIK ibu)
- `children.nik`: Unique (NULL allowed untuk bayi)
- `recipes.slug`: Unique (URL slug)
- `growth_standards(gender, age_months, indicator)`: Unique composite

### 4.4 Not Null Constraints

Semua FK harus NOT NULL kecuali:

- `children.nik`: Nullable (bayi baru lahir belum punya NIK)
- `users.puskesmas_id`: Nullable (Admin tidak punya puskesmas)
- `posyandu.kader_id`: Nullable (posyandu bisa tidak ada kader sementara)
- `measurements.head_circumference`: Nullable (optional)

---

## 5. LARAVEL MIGRATIONS

### Migration Order (Dependency-based)

```
1. create_puskesmas_table
2. create_users_table (depends on: puskesmas)
3. create_posyandu_table (depends on: puskesmas, users)
4. create_mothers_table (depends on: posyandu, users)
5. create_children_table (depends on: mothers, posyandu, users)
6. create_measurements_table (depends on: children, users)
7. create_growth_standards_table
8. create_recipes_table (depends on: users)
9. create_notifications_table (depends on: users)
10. create_sync_queue_table (depends on: users)
```

### Sample Migration (measurements)

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->constrained()->cascadeOnDelete();
            $table->date('measured_at');
            $table->decimal('weight', 5, 2);
            $table->decimal('height', 5, 2);
            $table->decimal('head_circumference', 5, 2)->nullable();

            $table->integer('age_months');
            $table->decimal('weight_for_age_z', 5, 2)->nullable();
            $table->decimal('height_for_age_z', 5, 2)->nullable();
            $table->decimal('weight_for_height_z', 5, 2)->nullable();
            $table->string('nutrition_status', 50)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamp('synced_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('measured_at');
            $table->index('age_months');
            $table->index('nutrition_status');
            $table->index(['child_id', 'measured_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('measurements');
    }
};
```

---

## 6. ELOQUENT RELATIONSHIPS

### User Model

```php
class User extends Authenticatable
{
    public function puskesmas() { return $this->belongsTo(Puskesmas::class); }
    public function posyandu() { return $this->hasMany(Posyandu::class, 'kader_id'); }
    public function notifications() { return $this->hasMany(Notification::class); }
    public function createdMothers() { return $this->hasMany(Mother::class, 'created_by'); }
    public function createdChildren() { return $this->hasMany(Child::class, 'created_by'); }
    public function createdMeasurements() { return $this->hasMany(Measurement::class, 'created_by'); }
}
```

### Mother Model

```php
class Mother extends Model
{
    public function posyandu() { return $this->belongsTo(Posyandu::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function children() { return $this->hasMany(Child::class); } // ⚠️ IMPORTANT
}
```

### Child Model

```php
class Child extends Model
{
    public function mother() { return $this->belongsTo(Mother::class); } // ⚠️ IMPORTANT
    public function posyandu() { return $this->belongsTo(Posyandu::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function measurements() { return $this->hasMany(Measurement::class); }

    // Accessor untuk umur dalam bulan
    public function getAgeMonthsAttribute() {
        return Carbon::parse($this->date_of_birth)->diffInMonths(now());
    }
}
```

---

## 7. SEED DATA REQUIREMENTS

### 7.1 Default Admin User

```php
User::create([
    'name' => 'Admin Dinas',
    'email' => 'admin@postingcinta.id',
    'password' => bcrypt('password'),
    'role' => 'admin',
    'is_active' => true,
]);
```

### 7.2 WHO Growth Standards

- Load dari JSON files (male & female)
- Total ~3,600 records (2 genders × 60 months × 3 indicators × 10 values)
- Source: WHO Child Growth Standards 2006

### 7.3 Sample Recipes (Optional)

- 10-15 resep per kategori usia
- Total 30-45 resep untuk demo

---

**END OF DATABASE SCHEMA DOCUMENT**
