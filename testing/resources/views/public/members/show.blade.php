@extends('layouts.public')

@section('title', $member->name . ' — Profil Anggota')
@section('meta_description', 'Profil ' . $member->name . ', ' . ($member->position ?? 'Anggota') . ' — lihat seluruh karya dan portofolio.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- ═══ BREADCRUMB ═══ --}}
    <nav class="text-sm text-gray-400 mb-8">
        <a href="{{ route('public.home') }}" class="hover:text-indigo-600 transition-colors">Beranda</a>
        <span class="mx-2">/</span>
        <a href="{{ route('public.members.index') }}" class="hover:text-indigo-600 transition-colors">Anggota</a>
        <span class="mx-2">/</span>
        <span class="text-gray-700 font-medium">{{ $member->name }}</span>
    </nav>

    {{-- ═══ PROFIL ANGGOTA (FR-PUB-004) ═══ --}}
    <div class="bg-white rounded-2xl shadow-sm p-8 mb-10 flex flex-col sm:flex-row gap-8 items-start">
        {{-- Foto Profil --}}
        <div class="flex-shrink-0">
            <img src="{{ $member->photoUrl }}"
                 alt="Foto profil {{ $member->name }}"
                 class="w-32 h-32 sm:w-40 sm:h-40 rounded-2xl object-cover ring-4 ring-indigo-100">
        </div>

        {{-- Info Detail --}}
        <div class="flex-1 min-w-0">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-1">{{ $member->name }}</h1>

            @if($member->position)
                <p class="text-indigo-600 font-semibold text-lg mb-3">{{ $member->position }}</p>
            @endif

            @if($member->bio)
                <p class="text-gray-600 leading-relaxed mb-4">{{ $member->bio }}</p>
            @endif

            {{-- Kontak --}}
            <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                @if($member->email)
                <a href="mailto:{{ $member->email }}"
                   class="flex items-center gap-1.5 hover:text-indigo-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    {{ $member->email }}
                </a>
                @endif
                @if($member->phone)
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    {{ $member->phone }}
                </span>
                @endif
            </div>
        </div>
    </div>

    {{-- ═══ GALERI KARYA (FR-PUB-004) ═══ --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            Karya
            <span class="text-base font-normal text-gray-400 ml-2">
                ({{ $member->publishedWorks->count() }} karya)
            </span>
        </h2>

        @if($member->publishedWorks->isEmpty())
            <div class="text-center py-16 bg-white rounded-2xl">
                <p class="text-gray-400">Anggota ini belum memiliki karya yang dipublikasikan.</p>
            </div>
        @else
            {{-- Filter per Kategori --}}
            @if($worksByCategory->keys()->count() > 1)
            <div class="flex flex-wrap gap-2 mb-6" x-data="categoryFilter()">
                <button @click="active='semua'"
                        :class="active==='semua' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 hover:bg-indigo-50'"
                        class="px-4 py-1.5 rounded-full text-sm font-medium border border-indigo-200 transition-colors">
                    Semua
                </button>
                @foreach($worksByCategory->keys() as $cat)
                <button @click="active='{{ Str::slug($cat) }}'; filterWorks('{{ Str::slug($cat) }}')"
                        :class="active==='{{ Str::slug($cat) }}' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 hover:bg-indigo-50'"
                        class="px-4 py-1.5 rounded-full text-sm font-medium border border-indigo-200 transition-colors">
                    {{ $cat }}
                </button>
                @endforeach
            </div>
            @endif

            {{-- Grid Karya --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4" id="works-grid">
                @foreach($member->publishedWorks as $work)
                {{-- FR-PUB-005: Karya dapat diklik --}}
                <a href="{{ route('public.works.show', $work->slug) }}"
                   class="group bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5"
                   data-category="{{ $work->category ? Str::slug($work->category->name) : 'lainnya' }}">
                    {{-- Thumbnail (FR-WRK-004) --}}
                    <div class="aspect-video bg-gray-100 overflow-hidden">
                        @if($work->thumbnailUrl)
                            <img src="{{ $work->thumbnailUrl }}"
                                 alt="{{ $work->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-200">
                                <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-3">
                        @if($work->category)
                            <span class="text-xs text-indigo-500 font-medium">{{ $work->category->name }}</span>
                        @endif
                        <h3 class="text-sm font-semibold text-gray-800 group-hover:text-indigo-600 truncate mt-1">
                            {{ $work->title }}
                        </h3>
                    </div>
                </a>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Kembali ke daftar anggota --}}
    <div class="mt-10">
        <a href="{{ route('public.members.index') }}"
           class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar Anggota
        </a>
    </div>
</div>

@push('scripts')
<script>
function categoryFilter() {
    return {
        active: 'semua',
        filterWorks(cat) {
            const cards = document.querySelectorAll('#works-grid [data-category]');
            cards.forEach(card => {
                if (cat === 'semua' || card.getAttribute('data-category') === cat) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    }
}
</script>
@endpush

@endsection
