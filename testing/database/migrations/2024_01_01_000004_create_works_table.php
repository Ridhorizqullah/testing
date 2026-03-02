<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();

            // FK ke members — CASCADE DELETE (FR-MBR-012)
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();

            // FK ke categories — SET NULL jika kategori dihapus (FR-WRK-001)
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();

            $table->string('title');                            // Judul karya
            $table->string('slug')->unique();                   // URL-friendly title
            $table->text('description')->nullable();            // Deskripsi karya
            $table->string('image', 500)->nullable();           // Path gambar penuh (1200x900 WebP)
            $table->string('image_thumbnail', 500)->nullable(); // Path thumbnail (400x300 WebP)
            $table->string('external_link', 500)->nullable();   // Link eksternal (opsional)
            $table->boolean('is_published')->default(true);     // Toggle tampil di publik
            $table->integer('sort_order')->default(0);          // Urutan dalam profil anggota
            $table->timestamps();

            // Index untuk performa
            $table->index('member_id');
            $table->index('is_published');
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
