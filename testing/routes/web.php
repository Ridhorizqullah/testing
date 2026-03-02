<?php

use App\Http\Controllers\PublicMemberController;
use App\Http\Controllers\PublicWorkController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// ── Halaman Utama ─────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('public.home');

// ── Halaman Publik Anggota ─────────────────────────────────────
Route::get('/anggota', [PublicMemberController::class, 'index'])
    ->name('public.members.index');

Route::get('/anggota/{slug}', [PublicMemberController::class, 'show'])
    ->name('public.members.show');

// ── Halaman Publik Karya ───────────────────────────────────────
Route::get('/karya/{slug}', [PublicWorkController::class, 'show'])
    ->name('public.works.show');

// ── Livewire Volt ─────────────────────────────────────────────
Volt::route('/post/create', 'post.create');
