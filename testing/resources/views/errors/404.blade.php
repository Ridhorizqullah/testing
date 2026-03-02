<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 — Halaman Tidak Ditemukan | {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center font-sans">
    <div class="text-center px-4 py-16">
        <div class="text-8xl font-extrabold text-indigo-200 mb-4 select-none">404</div>
        <h1 class="text-2xl font-bold text-gray-700 mb-2">Halaman Tidak Ditemukan</h1>
        <p class="text-gray-500 mb-8 max-w-sm mx-auto">
            Anggota, karya, atau halaman yang kamu cari tidak ada atau sudah dipindahkan.
        </p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('public.home') }}"
               class="bg-indigo-600 text-white font-semibold px-6 py-2.5 rounded-full hover:bg-indigo-700 transition-colors">
                ← Kembali ke Beranda
            </a>
            <a href="{{ route('public.members.index') }}"
               class="bg-white text-indigo-600 font-semibold px-6 py-2.5 rounded-full border border-indigo-200 hover:bg-indigo-50 transition-colors">
                Lihat Anggota
            </a>
        </div>
    </div>
</body>
</html>
