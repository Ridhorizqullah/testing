<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\View\View;

class PublicWorkController extends Controller
{
    public function show(string $slug): View
    {
        $work = Work::with(['member', 'category'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('public.works.show', compact('work'));
    }
}
