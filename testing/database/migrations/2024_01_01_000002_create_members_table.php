<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            // FK ke users (nullable — anggota bisa ada tanpa akun login)
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('name');                         // Nama lengkap anggota
            $table->string('slug')->unique();               // URL-friendly untuk routing
            $table->string('position')->nullable();         // Jabatan / posisi dalam organisasi
            $table->text('bio')->nullable();                // Deskripsi singkat anggota
            $table->string('photo', 500)->nullable();       // Path foto profil (WebP, 400x400)
            $table->string('email')->nullable();            // Email kontak anggota
            $table->string('phone', 20)->nullable();        // Nomor HP anggota
            $table->boolean('is_active')->default(true);    // Toggle aktif/non-aktif (FR-MBR-013)
            $table->integer('sort_order')->default(0);      // Urutan tampil di halaman publik
            $table->timestamps();

            // Index untuk performa query
            $table->index('slug');
            $table->index('is_active');
            // FULLTEXT index untuk pencarian nama (FR-PUB-007, NFR-PERF-005)
            $table->fullText('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
