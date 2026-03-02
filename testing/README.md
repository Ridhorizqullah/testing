# 🌐 Platform Direktori Komunitas & Portofolio Anggota

Platform berbasis **Laravel + Filament** untuk mengelola dan menampilkan profil anggota komunitas beserta portofolio proyek mereka secara dinamis.

---

## 📖 Deskripsi

Proyek ini adalah sebuah **Platform Direktori Komunitas dan Portofolio** yang menghubungkan manajemen data internal yang efisien dengan tampilan publik yang menarik.

- **Admin** dapat mengelola data anggota dan proyek melalui **Panel Admin Filament** tanpa menyentuh kode.
- **Pengunjung** dapat melihat profil dan portofolio anggota secara dinamis di halaman depan (frontend).

---

## ✨ Fitur Utama

| Fitur | Deskripsi |
|---|---|
| 🖥️ **Dashboard Admin** | Panel kontrol profesional berbasis Filament untuk mengelola semua data |
| 👤 **Manajemen Anggota** | CRUD anggota komunitas lengkap dengan foto profil |
| 📁 **Manajemen Proyek** | Input dan organisasi karya/proyek setiap anggota |
| 🖼️ **Upload Gambar** | Unggah thumbnail proyek yang langsung dapat diakses publik |
| 🔗 **Link Demo** | Setiap proyek dapat dilengkapi tautan demo eksternal |
| 🌍 **Halaman Publik Dinamis** | Frontend yang otomatis terupdate saat data di admin berubah |
| 📱 **Responsif** | Tampilan optimal di perangkat desktop maupun mobile |

---

## 🛠️ Teknologi yang Digunakan

- **Framework**: [Laravel](https://laravel.com/) (PHP)
- **Admin Panel**: [Filament](https://filamentphp.com/)
- **Database**: MySQL / SQLite
- **Frontend Templating**: Blade
- **File Storage**: Laravel Storage (symlink publik)

---

## 🚀 Cara Instalasi

### Prasyarat
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL atau database pilihan Anda

### Langkah-langkah

```bash
# 1. Clone repositori
git clone https://github.com/username/nama-repo.git
cd nama-repo

# 2. Install dependensi PHP
composer install

# 3. Install dependensi Node.js
npm install && npm run build

# 4. Salin file konfigurasi environment
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Konfigurasi database di file .env
# DB_DATABASE=nama_database
# DB_USERNAME=root
# DB_PASSWORD=

# 7. Jalankan migrasi database
php artisan migrate

# 8. Sinkronisasi folder media (storage symlink)
php artisan storage:link

# 9. Buat akun administrator pertama
php artisan make:filament-user

# 10. Jalankan server lokal
php artisan serve
```

Akses aplikasi di `http://localhost:8000` dan panel admin di `http://localhost:8000/admin`.

---

## 📂 Struktur Proyek

```
├── app/
│   ├── Filament/
│   │   └── Resources/
│   │       ├── UserResource/          # Resource anggota di panel admin
│   │       │   └── RelationManagers/
│   │       │       └── ProjectsRelationManager.php
│   │       └── ProjectResource.php    # Resource proyek di panel admin
│   ├── Http/
│   │   └── Controllers/
│   │       └── MemberController.php   # Controller halaman publik
│   └── Models/
│       ├── User.php                   # Model anggota
│       └── Project.php                # Model proyek
├── database/
│   └── migrations/
│       └── xxxx_create_projects_table.php
├── resources/
│   └── views/
│       └── members/
│           └── index.blade.php        # Tampilan halaman publik
└── routes/
    └── web.php                        # Routing aplikasi
```

---

## 🗄️ Struktur Database

### Tabel `users` (Anggota)
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint | Primary Key |
| `name` | varchar | Nama anggota |
| `email` | varchar | Email (unik) |
| `password` | varchar | Password (hashed) |
| `avatar` | varchar | Path foto profil |
| `bio` | text | Deskripsi singkat |

### Tabel `projects` (Proyek)
| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint | Primary Key |
| `user_id` | bigint | Foreign Key → `users.id` |
| `title` | varchar | Judul proyek |
| `description` | text | Deskripsi proyek |
| `thumbnail` | varchar | Path foto/thumbnail |
| `demo_url` | varchar | Link demo (nullable) |

### Relasi
```
User (Anggota) ──< Project (Proyek)
     1                 Many
```

---

## 🎛️ Panduan Admin

1. Login ke `/admin` menggunakan akun administrator.
2. Navigasi ke menu **Users** untuk mengelola data anggota.
3. Navigasi ke menu **Projects** untuk mengelola semua proyek.
4. Untuk menambah proyek milik anggota tertentu, buka profil anggota dan gunakan tab **Projects** di bagian bawah (Relation Manager).

---

## 📋 Status Pengembangan

- [x] Instalasi Framework Filament
- [x] Konfigurasi Panel Admin
- [x] Pembuatan User Akses
- [x] Sinkronisasi Folder Media
- [x] Definisi Model Proyek
- [x] Rancangan Database (Migrasi)
- [x] Pengaturan Relasi Data (One-to-Many)
- [x] Eksekusi Database
- [x] Pembuatan Resource Proyek (Filament)
- [x] Desain Formulir Input (Form)
- [x] Pengaturan Tabel Daftar (List)
- [x] Manajer Relasi (Relation Manager)
- [x] Pengambilan Data (Controller)
- [x] Pengaturan Alamat (Route)
- [x] Pembuatan Tampilan Visual (Blade)
- [ ] Uji Input Data
- [ ] Validasi Visual
- [ ] Cek Responsif

---

## 🔮 Rencana Pengembangan

- [ ] Sistem pencarian anggota berdasarkan nama atau keahlian
- [ ] Filter proyek berdasarkan kategori atau teknologi
- [ ] Halaman detail profil anggota (`/member/{id}`)
- [ ] Sistem autentikasi untuk anggota (self-service portofolio)
- [ ] API endpoint untuk integrasi dengan aplikasi mobile

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

## 🤝 Kontribusi

Kontribusi sangat disambut! Silakan buka *issue* atau kirimkan *pull request* untuk perbaikan atau fitur baru.

---

<p align="center">Dibuat dengan ❤️ menggunakan Laravel & Filament</p>
