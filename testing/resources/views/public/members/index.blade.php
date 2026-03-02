@extends('layouts.public')

@section('title', 'Daftar Anggota')
@section('meta_description', 'Daftar seluruh anggota aktif organisasi — klik untuk melihat profil dan karya lengkap.')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- ═══ HEADER ═══ --}}
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Daftar Anggota</h1>
        <p class="text-gray-500">Kenali seluruh anggota aktif organisasi kami.</p>
    </div>

    {{-- ═══ FORM PENCARIAN (FR-PUB-007) ═══ --}}
    {{-- Alpine.js: pencarian real-time + submit biasa untuk fallback --}}
    <div class="max-w-md mx-auto mb-10" x-data="memberSearch()">
        <div class="relative">
            <input
                type="text"
                id="search-input"
                name="search"
                x-model="query"
                @input.debounce.300ms="filterMembers()"
                value="{{ $search }}"
                placeholder="Cari nama anggota..."
                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent text-gray-700"
                autocomplete="off"
            >
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>

        {{-- Tombol clear pencarian --}}
        <div class="text-center mt-2" x-show="query.length > 0">
            <button @click="query=''; filterMembers()" class="text-sm text-indigo-600 hover:underline">
                Hapus pencarian
            </button>
        </div>
    </div>

    {{-- ═══ GRID ANGGOTA (FR-PUB-002) ═══ --}}
    @if($members->isEmpty())
        {{-- FR-PUB-008: Pesan jika tidak ada hasil --}}
        <div class="text-center py-20" id="empty-state">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-600 mb-1">Anggota tidak ditemukan</h3>
            @if($search)
                <p class="text-gray-400">Tidak ada anggota dengan nama "<strong>{{ $search }}</strong>".</p>
                <a href="{{ route('public.members.index') }}" class="mt-4 inline-block text-indigo-600 hover:underline text-sm">
                    Lihat semua anggota
                </a>
            @else
                <p class="text-gray-400">Belum ada anggota aktif saat ini.</p>
            @endif
        </div>
    @else
        <div id="members-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-6">
            @foreach($members as $member)
            {{-- FR-PUB-003: Klik kartu → halaman profil --}}
            <a href="{{ route('public.members.show', $member->slug) }}"
               class="group bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden hover:-translate-y-1"
               data-member-name="{{ strtolower($member->name) }}">
                {{-- Foto Profil --}}
                <div class="aspect-square bg-gray-100 overflow-hidden">
                    <img src="{{ $member->photoUrl }}"
                         alt="Foto {{ $member->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                         loading="lazy">
                </div>
                {{-- Info Singkat --}}
                <div class="p-4">
                    <h2 class="font-semibold text-gray-800 group-hover:text-indigo-600 truncate text-sm">
                        {{ $member->name }}
                    </h2>
                    <p class="text-xs text-gray-400 truncate mt-0.5">{{ $member->position ?? 'Anggota' }}</p>
                    <p class="text-xs text-indigo-500 mt-2 font-medium">{{ $member->works_count }} karya</p>
                </div>
            </a>
            @endforeach
        </div>

        {{-- ═══ PAGINASI ═══ --}}
        @if($members->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $members->links() }}
        </div>
        @endif
    @endif
</div>

@push('scripts')
<script>
function memberSearch() {
    return {
        query: '{{ $search }}',
        filterMembers() {
            const q = this.query.toLowerCase().trim();
            const cards = document.querySelectorAll('#members-grid [data-member-name]');
            let visible = 0;
            cards.forEach(card => {
                const name = card.getAttribute('data-member-name');
                const show = q === '' || name.includes(q);
                card.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            // Tampilkan empty state inline jika semua tersembunyi
            const emptyMsg = document.getElementById('inline-empty');
            if (emptyMsg) emptyMsg.style.display = visible === 0 ? 'block' : 'none';
        }
    }
}
</script>
@endpush

@endsection
