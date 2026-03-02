<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Work;
use Illuminate\Http\Request;

class PublicHomeController extends Controller
{
    /**
     * Halaman Beranda Organisasi
     *
     * Menampilkan:
     * - Ringkasan/statistik organisasi (total anggota, total karya)
     * - Featured members (6 anggota aktif terbaru)
     * - Karya terbaru
     */
    public function index()
    {
        // Statistik untuk section hero/counter
        $totalMembers = Member::active()->count();
        $totalWorks   = Work::published()->count();

        // 6 anggota aktif untuk ditampilkan di beranda (featured)
        // Eager load works untuk menampilkan jumlah karya tiap anggota
        $featuredMembers = Member::active()
            ->ordered()
            ->withCount(['works' => fn ($q) => $q->published()])
            ->take(6)
            ->get();

        // 6 karya terbaru untuk section "Karya Terbaru"
        $latestWorks = Work::published()
            ->with(['member', 'category'])
            ->ordered()
            ->take(6)
            ->get();

        return view('public.home', compact(
            'totalMembers',
            'totalWorks',
            'featuredMembers',
            'latestWorks',
        ));
    }
}
