<?php

use App\Http\Controllers\PublicHomeController;
use App\Http\Controllers\PublicMemberController;
use App\Http\Controllers\PublicWorkController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| HALAMAN PUBLIK (Bisa diakses siapa saja tanpa login)
|--------------------------------------------------------------------------
| Route panel admin (/admin) diatur otomatis oleh Filament.
*/

// FR-PUB-001: Beranda organisasi
Route::get('/', [PublicHomeController::class, 'index'])
    ->name('public.home');

// FR-PUB-002 & FR-PUB-007: Daftar semua anggota aktif + pencarian
Route::get('/anggota', [PublicMemberController::class, 'index'])
    ->name('public.members.index');

// FR-PUB-003 & FR-PUB-004: Profil lengkap anggota + galeri karya (slug-based)
Route::get('/anggota/{member:slug}', [PublicMemberController::class, 'show'])
    ->name('public.members.show');

// FR-PUB-005 & FR-PUB-006: Detail satu karya (slug-based)
Route::get('/karya/{work:slug}', [PublicWorkController::class, 'show'])
    ->name('public.works.show');
