<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicMemberController extends Controller
{
    public function index(): View
    {
        $members = Member::with(['works' => function ($q) {
                $q->where('is_published', true)->orderBy('sort_order');
            }])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(12);

        return view('public.members.index', compact('members'));
    }

    public function show(string $slug): View
    {
        $member = Member::with(['works' => function ($q) {
                $q->where('is_published', true)
                  ->with('category')
                  ->orderBy('sort_order');
            }])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.members.show', compact('member'));
    }
}
