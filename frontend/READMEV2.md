# Asset Management System

Sistem manajemen aset IT sederhana yang dibangun dengan Laravel 12 dan Vue 3 (Vite + Tailwind CSS). Aplikasi ini memungkinkan pengguna untuk mengelola kategori aset, lokasi kantor, serta melacak riwayat perpindahan aset secara otomatis melalui fitur asset logs.

## Requirement Sistem

Sebelum memulai, pastikan perangkat Anda telah terpasang:

- PHP >= 8.2
- Composer
- Node.js & npm (Versi LTS direkomendasikan)
- MySQL >= 8.0

## Clone Repository

## Cara Setup Backend

1. Masuk ke direktori backend:

```bash
cd frontend
```

2. Install dependensi PHP:

```bash
composer install
```

3. Salin file environment:

```bash
cp .env.example .env
```

4. Konfigurasi Database: Buka file .env dan sesuaikan koneksi database MySQL Anda:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=
```

5. Generate App Key & Migrate:

```bash
php artisan key:generate
php artisan migrate --seed
```

## Cara Setup Frontend

1. Masuk ke direktori frontend:

```bash
cd frontend
```

2. Install dependensi Node.js:

```bash
npm install
```

3. Konfigurasi API URL: Pastikan file .env (atau konfigurasi di src/api/axios.ts) mengarah ke URL backend Anda (default: http://localhost:8000/api/v1).

## Cara Menjalankan Aplikasi

1. Jalankan server Backend:

```bash
php artisan serve
```

2. Jalankan server Frontend:

```bash
npm run dev
```

3. Jalankan Unit Test (Opsional): Untuk memastikan semua fitur berjalan benar (8 passed):

```bash
php artisan test
```

## Struktur Project Singkat

**Backend (Laravel)**

- app/Http/Controllers/: Logika kontroler yang "tipis".
- app/Http/Requests/: Validasi input menggunakan Form Request.
- app/Http/Resources/: Transformasi data untuk response API JSON yang konsisten.
- app/Services/: Lokasi Business Logic (Service Layer).
- tests/Feature/: Automated tests untuk API.

**Frontend (Vue 3)**

- src/api/: Sebagai tempat pemanggilan axiosnya.
- src/components/: Komponen UI yang dapat digunakan kembali (Modals, Table).
- src/layouts/: Komponen UI yang digunakan sebagai template utama atau layout utama.
- src/router/: Sebagai tempat routingnya.
- src/services/: Integrasi API menggunakan Axios.
- src/types/: Definisi interface TypeScript untuk keamanan tipe data.
- src/views/: Halaman per fitur aplikasi.

## API Endpoints

Semua request API menggunakan prefix /api/v1 dan mengembalikan response dalam format JSON.

**Assets**

- GET /assets : Mengambil daftar aset dengan pagination dan filter (search, category, location, status).
- POST /assets : Menambah aset baru (Otomatis mencatat log pembuatan).
- GET /assets/{id} : Melihat detail aset beserta riwayat log (logs).
- PUT /assets/{id} : Memperbarui data aset (Otomatis mencatat log jika status/lokasi berubah).
- DELETE /assets/{id} : Menghapus aset.

**Master Data (Categories & Locations)**

- GET /categories & GET /locations : Mengambil semua data master.
- POST /categories & POST /locations : Menambah data master baru.
- PUT /categories/{id} & PUT /locations/{id} : Memperbarui data master.
- DELETE /categories/{id} & DELETE /locations/{id} : Menghapus data master.

## Fitur Utama

- Otomatisasi Log: Setiap perubahan lokasi aset akan dicatat otomatis di tabel asset_logs.
- Type Safety: Full TypeScript pada frontend untuk mengurangi error runtime.
- Security: Proteksi Mass Assignment, Parameter Binding, dan Form Request Validation.
