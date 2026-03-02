@extends('layouts.public')

@section('title', 'Beranda')
@section('meta_description', 'Website resmi organisasi — profil anggota dan galeri karya terbaik')

@section('content')

{{-- ═══════════════ HERO SECTION ═══════════════ --}}
<section class="bg-gradient-to-br from-indigo-600 to-purple-700 text-white py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight">
            Selamat Datang di<br>
            <span class="text-yellow-300">{{ config('app.name', 'Organisasi Kami') }}</span>
        </h1>
        <p class="text-xl text-indigo-100 mb-8 max-w-2xl mx-auto">
            Platform resmi untuk menampilkan profil anggota dan portofolio karya terbaik organisasi.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('public.members.index') }}"
               class="bg-white text-indigo-700 font-bold px-8 py-3 rounded-full hover:bg-yellow-300 hover:text-indigo-900 transition-all duration-200 shadow-lg">
                Lihat Anggota
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════ STATISTIK ═══════════════ --}}
<section class="bg-white py-12 border-b">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-2 gap-6 text-center">
            <div class="p-6 rounded-2xl bg-indigo-50">
                <div class="text-4xl font-extrabold text-indigo-600 mb-1">{{ $totalMembers }}</div>
                <div class="text-gray-600 font-medium">Anggota Aktif</div>
            </div>
            <div class="p-6 rounded-2xl bg-purple-50">
                <div class="text-4xl font-extrabold text-purple-600 mb-1">{{ $totalWorks }}</div>
                <div class="text-gray-600 font-medium">Karya Dipublikasikan</div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ ANGGOTA FEATURED ═══════════════ --}}
@if($featuredMembers->isNotEmpty())
<section class="py-16">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Anggota Kami</h2>
            <p class="text-gray-500">Kenali orang-orang hebat di balik karya-karya luar biasa ini.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($featuredMembers as $member)
            <a href="{{ route('public.members.show', $member->slug) }}"
               class="group text-center hover:-translate-y-1 transition-transform duration-200">
                <img src="{{ $member->photoUrl }}"
                     alt="{{ $member->name }}"
                     class="w-20 h-20 rounded-full object-cover mx-auto mb-3 ring-2 ring-indigo-100 group-hover:ring-indigo-400 transition-all"
                     loading="lazy">
                <div class="text-sm font-semibold text-gray-800 group-hover:text-indigo-600 truncate">
                    {{ $member->name }}
                </div>
                <div class="text-xs text-gray-400 truncate">{{ $member->position ?? 'Anggota' }}</div>
                <div class="text-xs text-indigo-500 font-medium">{{ $member->works_count }} karya</div>
            </a>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('public.members.index') }}"
               class="inline-block bg-indigo-600 text-white font-semibold px-6 py-2.5 rounded-full hover:bg-indigo-700 transition-colors">
                Lihat Semua Anggota →
            </a>
        </div>
    </div>
</section>
@endif

{{-- ═══════════════ KARYA TERBARU ═══════════════ --}}
@if($latestWorks->isNotEmpty())
<section class="py-16 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Karya Terbaru</h2>
            <p class="text-gray-500">Portofolio terkini dari para anggota kami.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($latestWorks as $work)
            <a href="{{ route('public.works.show', $work->slug) }}"
               class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                {{-- Thumbnail karya --}}
                <div class="aspect-video bg-gray-100 overflow-hidden">
                    @if($work->thumbnailUrl)
                        <img src="{{ $work->thumbnailUrl }}"
                             alt="{{ $work->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             loading="lazy">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-4">
                    @if($work->category)
                        <span class="text-xs font-medium text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full">
                            {{ $work->category->name }}
                        </span>
                    @endif
                    <h3 class="font-semibold text-gray-800 mt-2 group-hover:text-indigo-600 line-clamp-2">
                        {{ $work->title }}
                    </h3>
                    <p class="text-xs text-gray-400 mt-1">oleh {{ $work->member->name }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
