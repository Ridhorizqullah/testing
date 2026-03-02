<?php

namespace App\Http\Controllers;

use App\Models\Work;

class PublicWorkController extends Controller
{
    /**
     * Halaman Detail Karya
     *
     * FR-PUB-006: Tampilkan judul, gambar besar, deskripsi, dan link eksternal
     *
     * Route binding otomatis via getRouteKeyName() = 'slug' di model Work
     */
    public function show(Work $work)
    {
        // Pastikan hanya karya yang dipublikasikan yang bisa dilihat publik
        abort_unless($work->is_published, 404);

        // Eager load relasi member dan category
        $work->load(['member', 'category']);

        // Karya lain dari anggota yang sama (untuk navigasi/rekomendasi)
        $relatedWorks = Work::published()
            ->where('member_id', $work->member_id)
            ->where('id', '!=', $work->id)   // Kecualikan karya saat ini
            ->ordered()
            ->take(4)
            ->get();

        return view('public.works.show', compact('work', 'relatedWorks'));
    }
}
