<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapat Tidak Ditemukan - KOWPI</title>
    <link rel="icon" type="image/png" href="<?= base_url('img/favicon-kowpi.png') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-stone-100 flex items-center justify-center p-4 text-stone-800" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="max-w-md w-full bg-white rounded-3xl p-8 text-center shadow-xl border border-stone-200">
        <div class="w-16 h-16 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center mx-auto mb-4">
            <i data-lucide="alert-triangle" class="w-8 h-8"></i>
        </div>
        <h2 class="font-serif text-xl font-bold text-stone-900 mb-2">Rapat Tidak Ditemukan</h2>
        <p class="text-xs text-stone-500 mb-6">
            Sesi rapat yang Anda tuju tidak ditemukan atau belum dijadwalkan oleh sekretariat KOWPI.
        </p>
        <a href="<?= base_url('login') ?>" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-stone-800 hover:bg-stone-900 text-white font-bold text-xs">
            <i data-lucide="home" class="w-4 h-4"></i>
            Kembali ke Portal
        </a>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>

