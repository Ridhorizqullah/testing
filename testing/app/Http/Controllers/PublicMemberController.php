<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class PublicMemberController extends Controller
{
    /**
     * Halaman Daftar Anggota Aktif
     *
     * FR-PUB-002: Menampilkan foto profil seluruh anggota aktif dalam format grid kartu
     * FR-PUB-007: Pencarian berdasarkan nama secara real-time
     * FR-PUB-008: Pesan jika hasil pencarian tidak ditemukan
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $members = Member::active()
            ->ordered()
            ->withCount(['works' => fn ($q) => $q->published()])
            // FR-PUB-007: Filter pencarian berdasarkan nama
            ->when($search, function ($query, $searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%");
            })
            ->paginate(12)
            ->withQueryString(); // Pertahankan query ?search=... di link paginasi

        return view('public.members.index', compact('members', 'search'));
    }

    /**
     * Halaman Profil Lengkap Anggota + Galeri Karya
     *
     * FR-PUB-004: Tampilkan foto, nama, jabatan, bio + seluruh karya dalam galeri
     * FR-PUB-005: Karya dapat diklik untuk melihat detail
     *
     * Route binding otomatis via getRouteKeyName() = 'slug' di model Member
     */
    public function show(Member $member)
    {
        // Pastikan hanya anggota aktif yang bisa dilihat
        // Jika tidak aktif, lempar 404 agar tidak bisa diakses via URL langsung
        abort_unless($member->is_active, 404);

        // Eager loading: ambil karya + kategorinya sekaligus (cegah N+1 problem)
        // Hanya karya yang is_published = true yang ditampilkan di publik
        $member->load([
            'publishedWorks' => fn ($q) => $q->with('category')->ordered(),
        ]);

        // Karya dikelompokkan per kategori untuk tampilan galeri terfilter
        $worksByCategory = $member->publishedWorks->groupBy(
            fn ($work) => $work->category?->name ?? 'Lainnya'
        );

        return view('public.members.show', compact('member', 'worksByCategory'));
    }
}
