# 🏛️ Website Organisasi & Pameran Karya

Platform direktori anggota dan portofolio berbasis **Laravel 11 + Filament PHP 3** dengan panel administrasi terpusat dan halaman publik yang dinamis.

**Versi:** 1.0.0 · **Status:** Development · **Tanggal:** Maret 2026

---

## 📖 Tentang Proyek

Website ini terdiri dari dua bagian utama:

- **Panel Admin** (`/admin`) — digunakan pengurus untuk mengelola data anggota, karya, dan kategori secara visual tanpa menyentuh kode.
- **Halaman Publik** (`/`) — menampilkan profil anggota aktif dan galeri karya mereka kepada pengunjung umum.

Setiap perubahan di panel admin langsung tercermin di halaman publik secara real-time.

---

## ✨ Fitur Utama

### Panel Admin (Filament)
- ✅ CRUD Anggota — tambah, edit, nonaktifkan, dan hapus anggota organisasi
- ✅ CRUD Karya — kelola portofolio yang terhubung ke setiap anggota
- ✅ CRUD Kategori — pengelompokan karya berdasarkan kategori
- ✅ Manajemen Pengguna — manajemen akun dengan Role-Based Access Control (Admin / User)
- ✅ Pemrosesan Gambar Otomatis — foto profil dan gambar karya dikonversi & di-resize otomatis ke WebP
- ✅ Relation Manager — karya bisa dikelola langsung dari halaman edit profil anggota
- ✅ Pencarian & Filter — cari anggota real-time berdasarkan nama/email, filter by status

### Halaman Publik
- ✅ Daftar anggota aktif dalam format card grid yang responsif
- ✅ Halaman profil lengkap per anggota beserta galeri karyanya
- ✅ Halaman detail karya dengan gambar besar dan link eksternal
- ✅ Pencarian anggota real-time tanpa reload halaman (Alpine.js)
- ✅ Navigasi konsisten (header + footer) di semua halaman

---

## 🛠️ Teknologi

| Layer | Teknologi | Versi |
|---|---|---|
| Backend | Laravel | 11.x |
| Admin Panel | Filament PHP | 3.x |
| Frontend | Blade + Alpine.js | — |
| CSS | Tailwind CSS | 3.x |
| Database | MySQL | 8.0+ |
| Image Processing | Intervention Image | 3.x |
| PHP | PHP | 8.2+ |

---

## 🚀 Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL 8.0+

### Langkah Instalasi

```bash
# 1. Clone repositori
git clone https://github.com/username/nama-repo.git
cd nama-repo

# 2. Install dependensi
composer install
npm install && npm run build

# 3. Konfigurasi environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database di .env
# DB_DATABASE=nama_database
# DB_USERNAME=root
# DB_PASSWORD=

# 5. Jalankan migrasi
php artisan migrate

# 6. Symlink storage untuk file publik
php artisan storage:link

# 7. Buat akun admin pertama
php artisan make:filament-user

# 8. Jalankan server
php artisan serve
```

Akses aplikasi di `http://localhost:8000` dan panel admin di `http://localhost:8000/admin`.

---

## 🗄️ Struktur Database

Sistem menggunakan 4 tabel utama dengan relasi sebagai berikut:

```
users (1) ────── (0..1) members (1) ────── (N) works
                                                  │
                 categories (1) ───────────── (N) works
```

### Ringkasan Tabel

| Tabel | Fungsi |
|---|---|
| `users` | Akun pengguna sistem (admin & user) dengan kolom `role` |
| `members` | Profil anggota organisasi yang tampil di halaman publik |
| `works` | Karya/portofolio milik setiap anggota |
| `categories` | Kategori untuk pengelompokan karya |

### Kolom Penting

**`members`**: `name`, `slug` (auto-generate), `position`, `bio`, `photo`, `is_active`, `sort_order`

**`works`**: `title`, `slug`, `description`, `image`, `image_thumbnail`, `external_link`, `is_published`, `sort_order`

> Penghapusan anggota otomatis menghapus semua karyanya (ON DELETE CASCADE).

---

## 👥 Peran Pengguna (RBAC)

| Aksi | Admin | User |
|---|---|---|
| Lihat semua anggota | ✅ | ✅ |
| Tambah / hapus anggota | ✅ | ❌ |
| Edit anggota sendiri | ✅ | ✅ |
| Edit anggota lain | ✅ | ❌ |
| Tambah karya sendiri | ✅ | ✅ |
| Tambah / hapus karya anggota lain | ✅ | ❌ |
| Manajemen pengguna sistem | ✅ | ❌ |
| Lihat dashboard statistik | ✅ | Terbatas |

---

## 🔗 Daftar Route Publik

| Method | URL | Keterangan |
|---|---|---|
| GET | `/` | Halaman utama organisasi |
| GET | `/anggota` | Daftar semua anggota aktif |
| GET | `/anggota/{slug}` | Profil dan galeri karya anggota |
| GET | `/karya/{slug}` | Detail satu karya |
| GET | `/admin` | Login panel administrasi |

---

## 📂 Struktur Direktori (Ringkas)

```
app/
├── Filament/Resources/     # MemberResource, WorkResource, CategoryResource, UserResource
├── Http/Controllers/       # PublicMemberController, PublicWorkController
├── Models/                 # User, Member, Work, Category
└── Observers/              # MemberObserver (auto-generate slug & proses gambar)

resources/views/
├── layouts/public.blade.php
└── public/
    ├── home.blade.php
    ├── members/index.blade.php & show.blade.php
    └── works/show.blade.php
```

---

## 🖼️ Pemrosesan Gambar Otomatis

Saat gambar diupload, sistem secara otomatis:

1. Validasi tipe MIME di sisi server (JPG, PNG, GIF, WebP — maks. 10MB)
2. **Foto profil anggota** → 400×400 px (center-crop) → format WebP
3. **Gambar karya (thumbnail)** → 400×300 px → format WebP
4. **Gambar karya (penuh)** → maks. 1200×900 px (pertahankan rasio) → format WebP
5. Simpan ke `storage/app/public/` dan catat path-nya di database

---

## 🔒 Keamanan

- Password di-hash dengan **bcrypt** (bawaan Laravel)
- Proteksi **CSRF** di setiap form
- Proteksi **SQL Injection** via Eloquent ORM
- Proteksi **XSS** via Blade auto-escaping
- **Rate limiting** login: maks. 5 percobaan gagal per menit per IP
- Validasi **MIME type** file upload di sisi server

---

## 📋 Status Pengembangan

- [ ] Instalasi & Konfigurasi Filament
- [ ] Migrasi database (users, members, works, categories)
- [ ] MemberResource — CRUD + pemrosesan foto
- [ ] WorkResource — CRUD + pemrosesan gambar + Relation Manager
- [ ] CategoryResource — CRUD kategori
- [ ] UserResource — manajemen pengguna (role-based)
- [ ] Halaman publik — daftar anggota, profil, detail karya
- [ ] Pencarian real-time di halaman publik
- [ ] Uji fungsional & responsivitas

---

## 📄 Lisensi

[MIT License](LICENSE)

---

<p align="center">Dibangun dengan ❤️ menggunakan Laravel & Filament PHP</p>
