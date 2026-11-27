<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Notula & Presensi Rapat') ?> - <?= esc($settings['org_short'] ?? 'KOWPI') ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('img/favicon-kowpi.png') ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <!-- Tailwind CSS with Light Premium Palette -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        kowpi: {
                            50: '#fdf9f7',
                            100: '#f9f0ec',
                            200: '#f2ded5',
                            300: '#e5c2b4',
                            400: '#ce8e78',
                            500: '#8c4835',
                            600: '#723a2a',
                            700: '#582a1d',
                            800: '#3e1b12',
                            900: '#2a110a',
                            950: '#150805',
                        },
                        gold: {
                            light: '#f5d77f',
                            DEFAULT: '#c99a3e',
                            dark: '#9a7024',
                            glow: 'rgba(201, 154, 62, 0.25)',
                        },
                        champagne: {
                            50: '#fdfcf9',
                            100: '#faf7f2',
                            200: '#f4ede1',
                            300: '#ebe0ce',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                    }
                }
            }
        }
    </script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Signature Pad -->
    <script src="<?= base_url('assets/js/signature_pad.umd.min.js') ?>"></script>

    <!-- Alpine.js -->
    <script defer src="<?= base_url('assets/js/alpine.min.js') ?>"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #faf7f2;
            color: #2b1f1a;
        }
        .font-serif-kowpi {
            font-family: 'Playfair Display', serif;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f4ede1;
        }
        ::-webkit-scrollbar-thumb {
            background: #ce8e78;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #8c4835;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col md:flex-row antialiased bg-[#faf7f2]">

    <!-- Mobile Header -->
    <header class="md:hidden bg-white text-stone-900 border-b border-champagne-200 p-4 flex items-center justify-between shadow-sm sticky top-0 z-50">
        <div class="flex items-center space-x-3">
            <div class="p-1 bg-white rounded-xl border border-stone-200 shadow-xs">
                <img src="<?= base_url('img/logo-kowpi.png') ?>" alt="KOWPI" class="h-8 w-auto">
            </div>
            <div>
                <h1 class="font-serif-kowpi font-bold text-base text-kowpi-900 tracking-wide leading-tight">KOWPI</h1>
                <p class="text-[10px] text-stone-500 uppercase tracking-widest font-semibold">Panel Administrasi</p>
            </div>
        </div>
        <button id="mobileMenuBtn" class="p-2 text-stone-600 hover:text-kowpi-800 focus:outline-none">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
    </header>

    <!-- Light Premium Executive Sidebar -->
    <aside id="sidebar" class="fixed md:sticky top-0 inset-y-0 left-0 z-40 w-72 bg-white text-stone-800 flex flex-col border-r border-champagne-200/90 shadow-sm transition-transform duration-300 -translate-x-full md:translate-x-0 h-screen overflow-y-auto">
        
        <!-- Brand Header (Light & Crisp Logo) -->
        <div class="p-6 border-b border-champagne-200 bg-gradient-to-b from-white to-champagne-50/60">
            <a href="<?= base_url('dashboard') ?>" class="flex items-center gap-3.5 group">
                <div class="p-2 bg-white rounded-2xl border border-stone-200 shadow-sm group-hover:border-gold transition-all duration-300 flex items-center justify-center">
                    <img src="<?= base_url('img/logo-kowpi.png') ?>" alt="KOWPI Logo" class="h-10 w-auto object-contain">
                </div>
                <div>
                    <h2 class="font-serif-kowpi font-bold text-lg text-kowpi-950 group-hover:text-kowpi-600 transition-colors leading-tight">
                        KOWPI
                    </h2>
                    <p class="text-[11px] font-bold tracking-wider uppercase text-gold-dark">
                        Notula & Presensi
                    </p>
                </div>
            </a>
            
            <div class="mt-4 px-3 py-1.5 rounded-xl bg-champagne-100/80 border border-champagne-200 flex items-center justify-between text-[11px] text-stone-600">
                <span class="flex items-center gap-1.5 font-medium">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Sistem Rapat Resmi
                </span>
                <span class="text-gold-dark font-bold font-mono">v2.0</span>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 text-sm">
            <div class="px-3 pb-2 text-[10px] font-bold uppercase tracking-widest text-stone-400">
                Menu Administrasi
            </div>

            <!-- Dashboard -->
            <a href="<?= base_url('dashboard') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition-all <?= ($activeNav ?? '') === 'dashboard' ? 'bg-kowpi-700 text-white shadow-sm' : 'text-stone-600 hover:text-kowpi-900 hover:bg-champagne-100/70' ?>">
                <i data-lucide="layout-dashboard" class="w-5 h-5 <?= ($activeNav ?? '') === 'dashboard' ? 'text-gold-light' : 'text-stone-400' ?>"></i>
                <span>Dashboard</span>
            </a>

            <!-- Agenda & Notula Rapat -->
            <a href="<?= base_url('rapat') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition-all <?= ($activeNav ?? '') === 'meetings' ? 'bg-kowpi-700 text-white shadow-sm' : 'text-stone-600 hover:text-kowpi-900 hover:bg-champagne-100/70' ?>">
                <i data-lucide="calendar-check-2" class="w-5 h-5 <?= ($activeNav ?? '') === 'meetings' ? 'text-gold-light' : 'text-stone-400' ?>"></i>
                <span>Agenda & Notula</span>
            </a>

            <!-- Direktori Arsip -->
            <a href="<?= base_url('arsip') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition-all <?= ($activeNav ?? '') === 'archive' ? 'bg-kowpi-700 text-white shadow-sm' : 'text-stone-600 hover:text-kowpi-900 hover:bg-champagne-100/70' ?>">
                <i data-lucide="archive" class="w-5 h-5 <?= ($activeNav ?? '') === 'archive' ? 'text-gold-light' : 'text-stone-400' ?>"></i>
                <span>Direktori Arsip</span>
            </a>

            <!-- Pengaturan KOWPI -->
            <a href="<?= base_url('pengaturan') ?>" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition-all <?= ($activeNav ?? '') === 'settings' ? 'bg-kowpi-700 text-white shadow-sm' : 'text-stone-600 hover:text-kowpi-900 hover:bg-champagne-100/70' ?>">
                <i data-lucide="settings" class="w-5 h-5 <?= ($activeNav ?? '') === 'settings' ? 'text-gold-light' : 'text-stone-400' ?>"></i>
                <span>Pengaturan KOWPI</span>
            </a>

            <div class="pt-4 px-3 pb-2 text-[10px] font-bold uppercase tracking-widest text-stone-400">
                Akses Publik
            </div>

            <!-- Homepage Publik / Presensi -->
            <a href="<?= base_url('/') ?>" target="_blank" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl font-semibold transition-all text-kowpi-800 bg-champagne-100/80 hover:bg-champagne-200 border border-champagne-300">
                <i data-lucide="external-link" class="w-4 h-4 text-kowpi-700"></i>
                <div class="flex-1 flex items-center justify-between">
                    <span>Lihat Halaman Publik</span>
                </div>
            </a>
        </nav>

        <!-- User Info & Logout Footer -->
        <div class="p-4 border-t border-champagne-200 bg-champagne-50/60">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-kowpi-100 border border-kowpi-200 flex items-center justify-center font-serif-kowpi font-bold text-kowpi-800 text-sm shadow-xs">
                    <?= strtoupper(substr(session()->get('admin_name') ?? 'Admin', 0, 1)) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-stone-900 truncate">
                        <?= esc(session()->get('admin_name') ?? 'Admin KOWPI') ?>
                    </p>
                    <p class="text-[10px] text-stone-500 capitalize">
                        <?= esc(session()->get('admin_role') ?? 'Administrator') ?>
                    </p>
                </div>
                <a href="<?= base_url('logout') ?>" title="Keluar dari Sistem" class="p-2 text-stone-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 md:ml-0 overflow-y-auto min-h-screen">
        <!-- Top Executive Bar -->
        <header class="bg-white border-b border-champagne-200 px-6 py-4 shadow-xs hidden md:flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <div>
                    <h1 class="text-base font-bold text-stone-900 leading-tight">
                        <?= esc($title ?? 'Sistem Notula & Daftar Hadir Rapat') ?>
                    </h1>
                    <p class="text-xs text-stone-500">
                        <?= esc($settings['org_name'] ?? 'Komunitas Waris Planning Indonesia (KOWPI)') ?>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="<?= base_url('/') ?>" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold rounded-xl bg-champagne-100 text-stone-700 border border-champagne-300 hover:bg-champagne-200 transition-colors shadow-xs">
                    <i data-lucide="globe" class="w-3.5 h-3.5 text-kowpi-700"></i>
                    Buka Halaman Publik
                </a>
                <a href="<?= base_url('rapat/create') ?>" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold rounded-xl bg-kowpi-700 hover:bg-kowpi-800 text-white shadow-sm hover:shadow transition-all">
                    <i data-lucide="plus-circle" class="w-4 h-4 text-gold-light"></i>
                    Jadwalkan Rapat
                </a>
            </div>
        </header>

        <!-- Main Body Page Container -->
        <main class="flex-1 p-4 md:p-8">
            <!-- Flash Message Alerts -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3">
                        <div class="p-1.5 rounded-lg bg-emerald-100 text-emerald-700">
                            <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                        </div>
                        <p class="text-xs font-semibold"><?= session()->getFlashdata('success') ?></p>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3">
                        <div class="p-1.5 rounded-lg bg-rose-100 text-rose-700">
                            <i data-lucide="alert-triangle" class="w-5 h-5"></i>
                        </div>
                        <p class="text-xs font-semibold"><?= session()->getFlashdata('error') ?></p>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('info')): ?>
                <div class="mb-6 p-4 rounded-2xl bg-blue-50 border border-blue-200 text-blue-900 flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3">
                        <div class="p-1.5 rounded-lg bg-blue-100 text-blue-700">
                            <i data-lucide="info" class="w-5 h-5"></i>
                        </div>
                        <p class="text-xs font-semibold"><?= session()->getFlashdata('info') ?></p>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-blue-500 hover:text-blue-700">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            <?php endif; ?>

            <!-- View Dynamic Content -->
            <?= $this->renderSection('content') ?>
        </main>

        <!-- Executive Footer -->
        <footer class="bg-white border-t border-champagne-200 px-6 py-4 text-center text-xs text-stone-500">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-2 max-w-7xl mx-auto">
                <div class="flex items-center gap-2">
                    <span class="font-serif-kowpi font-bold text-kowpi-800">KOWPI.ID</span>
                    <span>&bull;</span>
                    <span>Sistem Notula & Daftar Hadir Rapat Resmi</span>
                </div>
                <div>
                    &copy; <?= date('Y') ?> Komunitas Waris Planning Indonesia. All Rights Reserved.
                </div>
            </div>
        </footer>
    </div>

    <!-- Script Init Lucide Icons & Mobile Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            const mobileBtn = document.getElementById('mobileMenuBtn');
            const sidebar = document.getElementById('sidebar');

            if (mobileBtn && sidebar) {
                mobileBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('-translate-x-full');
                });
            }
        });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
