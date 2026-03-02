<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Member;
use App\Models\User;
use App\Models\Work;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── 1. USERS ───────────────────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Admin Utama',
            'email'    => 'admin@organisasi.test',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        $userBiasa = User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@organisasi.test',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        // ─── 2. CATEGORIES ──────────────────────────────────────────────────
        $categories = collect([
            ['name' => 'Web Development',  'description' => 'Karya berupa aplikasi atau website'],
            ['name' => 'Mobile App',       'description' => 'Aplikasi mobile Android/iOS'],
            ['name' => 'Desain Grafis',    'description' => 'Logo, poster, dan desain visual'],
            ['name' => 'Fotografi',        'description' => 'Karya fotografi dan editing'],
            ['name' => 'Video & Animasi',  'description' => 'Produksi video dan motion graphic'],
        ])->map(fn ($cat) => Category::create($cat));

        // ─── 3. MEMBERS ─────────────────────────────────────────────────────
        $members = [
            [
                'user_id'    => $userBiasa->id,
                'name'       => 'Budi Santoso',
                'position'   => 'Ketua Divisi Web',
                'bio'        => 'Full-stack developer dengan spesialisasi Laravel dan Vue.js. Berpengalaman 3 tahun di industri teknologi.',
                'email'      => 'budi@organisasi.test',
                'phone'      => '081234567890',
                'is_active'  => true,
                'sort_order' => 1,
            ],
            [
                'user_id'    => null,
                'name'       => 'Siti Rahayu',
                'position'   => 'UI/UX Designer',
                'bio'        => 'Designer berbakat yang fokus pada pengalaman pengguna yang intuitif dan estetis.',
                'email'      => 'siti@organisasi.test',
                'phone'      => '082345678901',
                'is_active'  => true,
                'sort_order' => 2,
            ],
            [
                'user_id'    => null,
                'name'       => 'Ahmad Fauzi',
                'position'   => 'Mobile Developer',
                'bio'        => 'Pengembang aplikasi mobile React Native dan Flutter.',
                'email'      => 'ahmad@organisasi.test',
                'phone'      => '083456789012',
                'is_active'  => true,
                'sort_order' => 3,
            ],
            [
                'user_id'    => null,
                'name'       => 'Dewi Lestari',
                'position'   => 'Fotografer',
                'bio'        => 'Fotografer profesional dengan gaya portrait dan landscape.',
                'email'      => 'dewi@organisasi.test',
                'phone'      => null,
                'is_active'  => true,
                'sort_order' => 4,
            ],
            [
                'user_id'    => null,
                'name'       => 'Rizky Pratama',
                'position'   => 'Video Editor',
                'bio'        => 'Kreator konten video dan motion graphic untuk berbagai platform digital.',
                'email'      => 'rizky@organisasi.test',
                'phone'      => '085678901234',
                'is_active'  => true,
                'sort_order' => 5,
            ],
        ];

        $createdMembers = collect($members)->map(fn ($m) => Member::create($m));

        // ─── 4. WORKS ───────────────────────────────────────────────────────
        $works = [
            // Karya Budi Santoso (index 0)
            ['member_idx' => 0, 'cat_name' => 'Web Development', 'title' => 'Sistem Informasi Perpustakaan', 'description' => 'Aplikasi web manajemen perpustakaan berbasis Laravel dengan fitur peminjaman, pengembalian, dan laporan.', 'external_link' => 'https://github.com', 'sort_order' => 1],
            ['member_idx' => 0, 'cat_name' => 'Web Development', 'title' => 'E-Commerce Batik Nusantara', 'description' => 'Platform belanja online produk batik lokal dengan integrasi payment gateway.', 'external_link' => null, 'sort_order' => 2],
            // Karya Siti Rahayu (index 1)
            ['member_idx' => 1, 'cat_name' => 'Desain Grafis', 'title' => 'Redesign Logo Komunitas Tech', 'description' => 'Proses redesign logo komunitas teknologi lokal dengan pendekatan modern flat design.', 'external_link' => 'https://behance.net', 'sort_order' => 1],
            ['member_idx' => 1, 'cat_name' => 'Desain Grafis', 'title' => 'Poster Festival Budaya 2025', 'description' => 'Desain poster untuk festival budaya tahunan dengan nuansa tradisional modern.', 'external_link' => null, 'sort_order' => 2],
            // Karya Ahmad Fauzi (index 2)
            ['member_idx' => 2, 'cat_name' => 'Mobile App', 'title' => 'Aplikasi Tracking Sampah', 'description' => 'Aplikasi Flutter untuk tracking pengambilan sampah di lingkungan perumahan.', 'external_link' => 'https://play.google.com', 'sort_order' => 1],
            ['member_idx' => 2, 'cat_name' => 'Mobile App', 'title' => 'Cashier App UMKM', 'description' => 'Aplikasi kasir sederhana berbasis React Native untuk pelaku UMKM.', 'external_link' => null, 'sort_order' => 2],
            // Karya Dewi Lestari (index 3)
            ['member_idx' => 3, 'cat_name' => 'Fotografi', 'title' => 'Portrait Series: Wajah Petani', 'description' => 'Seri fotografiportrait para petani lokal yang menggambarkan ketangguhan dan kearifan lokal.', 'external_link' => null, 'sort_order' => 1],
            ['member_idx' => 3, 'cat_name' => 'Fotografi', 'title' => 'Landscape Alam Pegunungan Jawa', 'description' => 'Koleksi foto landscape pegunungan Jawa Tengah dengan teknik long exposure.', 'external_link' => 'https://instagram.com', 'sort_order' => 2],
            // Karya Rizky Pratama (index 4)
            ['member_idx' => 4, 'cat_name' => 'Video & Animasi', 'title' => 'Company Profile PT Maju Bersama', 'description' => 'Video company profile durasi 3 menit untuk perusahaan konsultan manajemen.', 'external_link' => 'https://youtube.com', 'sort_order' => 1],
            ['member_idx' => 4, 'cat_name' => 'Video & Animasi', 'title' => 'Animasi Infografis Kesehatan', 'description' => 'Motion graphic infografis tentang pentingnya gaya hidup sehat untuk media sosial.', 'external_link' => null, 'sort_order' => 2],
        ];

        $catByName = $categories->keyBy('name');

        foreach ($works as $w) {
            Work::create([
                'member_id'   => $createdMembers[$w['member_idx']]->id,
                'category_id' => $catByName[$w['cat_name']]->id,
                'title'       => $w['title'],
                'description' => $w['description'],
                'external_link' => $w['external_link'],
                'is_published' => true,
                'sort_order'  => $w['sort_order'],
                // image & image_thumbnail dikosongkan — diisi via panel admin
            ]);
        }

        $this->command->info('✅ Seeder selesai!');
        $this->command->info('   Admin  : admin@organisasi.test / password');
        $this->command->info('   User   : budi@organisasi.test / password');
        $this->command->info('   Members: 5 anggota aktif');
        $this->command->info('   Works  : 10 karya');
    }
}
