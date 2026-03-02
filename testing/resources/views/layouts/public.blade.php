<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Website resmi organisasi — profil anggota dan galeri karya')">
    <title>@yield('title', 'Beranda') — {{ config('app.name', 'Organisasi') }}</title>

    {{-- Tailwind CSS via CDN (untuk development; ganti dengan vite/mix di production) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Alpine.js untuk interaksi ringan (pencarian real-time, lightbox) --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Transisi halus untuk navigasi aktif */
        .nav-link { @apply text-gray-600 hover:text-indigo-600 transition-colors duration-200; }
        .nav-link.active { @apply text-indigo-600 font-semibold; }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    {{-- ═══════════════════════════ HEADER / NAVIGASI ═══════════════════════════ --}}
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <nav class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">

            {{-- Logo / Nama Organisasi --}}
            <a href="{{ route('public.home') }}" class="flex items-center gap-2">
                <span class="text-2xl font-bold text-indigo-600 tracking-tight">
                    {{ config('app.name', 'Organisasi') }}
                </span>
            </a>

            {{-- Menu Navigasi Desktop --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('public.home') }}"
                   class="nav-link {{ request()->routeIs('public.home') ? 'active' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('public.members.index') }}"
                   class="nav-link {{ request()->routeIs('public.members.*') ? 'active' : '' }}">
                    Anggota
                </a>
            </div>

            {{-- Hamburger Menu Mobile --}}
            <button class="md:hidden p-2 rounded-md text-gray-600 hover:bg-gray-100"
                    x-data @click="$dispatch('toggle-mobile-nav')">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </nav>

        {{-- Mobile Menu --}}
        <div class="md:hidden bg-white border-t"
             x-data="{ open: false }"
             @toggle-mobile-nav.window="open = !open"
             x-show="open" x-transition>
            <div class="px-4 py-2 space-y-1">
                <a href="{{ route('public.home') }}" class="block py-2 nav-link">Beranda</a>
                <a href="{{ route('public.members.index') }}" class="block py-2 nav-link">Anggota</a>
            </div>
        </div>
    </header>

    {{-- ═══════════════════════════ KONTEN UTAMA ═══════════════════════════ --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- ═══════════════════════════ FOOTER ═══════════════════════════ --}}
    <footer class="bg-gray-800 text-gray-300 mt-16">
        <div class="max-w-6xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- Info Organisasi --}}
                <div>
                    <h3 class="text-white font-bold text-lg mb-3">
                        {{ config('app.name', 'Organisasi') }}
                    </h3>
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Platform resmi organisasi untuk menampilkan profil anggota dan portofolio karya.
                    </p>
                </div>

                {{-- Navigasi --}}
                <div>
                    <h4 class="text-white font-semibold mb-3">Navigasi</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('public.home') }}" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('public.members.index') }}" class="hover:text-white transition-colors">Daftar Anggota</a></li>
                    </ul>
                </div>

                {{-- Kontak --}}
                <div>
                    <h4 class="text-white font-semibold mb-3">Kontak</h4>
                    <p class="text-sm text-gray-400">Untuk informasi lebih lanjut, silakan hubungi pengurus organisasi.</p>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-6 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} {{ config('app.name', 'Organisasi') }}. All rights reserved.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
