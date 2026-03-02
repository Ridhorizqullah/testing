@extends('layouts.public')

@section('title', $work->title . ' — Karya')
@section('meta_description', 'Detail karya: ' . $work->title . ' oleh ' . $work->member->name)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- ═══ BREADCRUMB ═══ --}}
    <nav class="text-sm text-gray-400 mb-8">
        <a href="{{ route('public.home') }}" class="hover:text-indigo-600 transition-colors">Beranda</a>
        <span class="mx-2">/</span>
        <a href="{{ route('public.members.show', $work->member->slug) }}" class="hover:text-indigo-600 transition-colors">
            {{ $work->member->name }}
        </a>
        <span class="mx-2">/</span>
        <span class="text-gray-700 font-medium truncate">{{ $work->title }}</span>
    </nav>

    {{-- ═══ DETAIL KARYA (FR-PUB-006) ═══ --}}
    <article class="bg-white rounded-2xl shadow-sm overflow-hidden">

        {{-- Gambar Penuh --}}
        @if($work->imageUrl)
        <div class="bg-gray-100">
            <img src="{{ $work->imageUrl }}"
                 alt="{{ $work->title }}"
                 class="w-full max-h-[500px] object-contain mx-auto"
                 loading="lazy">
        </div>
        @endif

        <div class="p-6 sm:p-8">

            {{-- Kategori + Judul --}}
            @if($work->category)
                <span class="inline-block text-xs font-semibold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full mb-3">
                    {{ $work->category->name }}
                </span>
            @endif

            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">{{ $work->title }}</h1>

            {{-- Info pembuat --}}
            <div class="flex items-center gap-3 mb-6 pb-6 border-b border-gray-100">
                <img src="{{ $work->member->photoUrl }}"
                     alt="{{ $work->member->name }}"
                     class="w-10 h-10 rounded-full object-cover">
                <div>
                    <a href="{{ route('public.members.show', $work->member->slug) }}"
                       class="font-semibold text-gray-800 hover:text-indigo-600 transition-colors text-sm">
                        {{ $work->member->name }}
                    </a>
                    @if($work->member->position)
                        <p class="text-xs text-gray-400">{{ $work->member->position }}</p>
                    @endif
                </div>
            </div>

            {{-- Deskripsi --}}
            @if($work->description)
            <div class="prose prose-gray max-w-none mb-6">
                <p class="text-gray-600 leading-relaxed whitespace-pre-line">{{ $work->description }}</p>
            </div>
            @endif

            {{-- Link Eksternal (FR-PUB-006) --}}
            @if($work->external_link)
            <div class="mt-6">
                <a href="{{ $work->external_link }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 bg-indigo-600 text-white font-semibold px-6 py-3 rounded-full hover:bg-indigo-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Lihat Proyek / Demo
                </a>
            </div>
            @endif
        </div>
    </article>

    {{-- ═══ KARYA TERKAIT ═══ --}}
    @if($relatedWorks->isNotEmpty())
    <section class="mt-12">
        <h2 class="text-xl font-bold text-gray-800 mb-5">
            Karya Lain dari {{ $work->member->name }}
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach($relatedWorks as $related)
            <a href="{{ route('public.works.show', $related->slug) }}"
               class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5">
                <div class="aspect-video bg-gray-100 overflow-hidden">
                    @if($related->thumbnailUrl)
                        <img src="{{ $related->thumbnailUrl }}"
                             alt="{{ $related->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             loading="lazy">
                    @endif
                </div>
                <div class="p-3">
                    <p class="text-xs font-semibold text-gray-700 group-hover:text-indigo-600 truncate">
                        {{ $related->title }}
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Kembali ke profil anggota --}}
    <div class="mt-10">
        <a href="{{ route('public.members.show', $work->member->slug) }}"
           class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Profil {{ $work->member->name }}
        </a>
    </div>
</div>
@endsection
