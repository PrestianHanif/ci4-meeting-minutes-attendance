<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= esc($title ?? 'Sistem Notula & Daftar Hadir Rapat - KOWPI') ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= base_url('img/favicon-kowpi.png') ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <!-- Tailwind CSS with Light & Dark Premium KOWPI Palette -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
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

    <!-- Immediate Anti-FOUC Theme Switcher -->
    <script>
        (function() {
            try {
                const savedTheme = localStorage.getItem('kowpi_theme');
                if (savedTheme === 'dark') {
                    document.documentElement.classList.add('dark');
                    document.documentElement.classList.remove('light');
                } else {
                    document.documentElement.classList.add('light');
                    document.documentElement.classList.remove('dark');
                }
            } catch (e) {}
        })();
    </script>

    <!-- Signature Pad -->
    <script src="<?= base_url('assets/js/signature_pad.umd.min.js') ?>"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #faf7f2;
            color: #2b1f1a;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .font-serif-kowpi {
            font-family: 'Playfair Display', serif;
        }
        .signature-wrapper {
            position: relative;
            background-color: #ffffff;
            border: 2px dashed #d9c5ba;
            border-radius: 1rem;
            overflow: hidden;
            touch-action: none;
            transition: all 0.25s ease;
        }
        .signature-wrapper.active {
            border-color: #8c4835;
            background-color: #fffdfc;
            box-shadow: 0 0 0 3px rgba(140, 72, 53, 0.1);
        }
        .signature-pad-canvas {
            display: block;
            width: 100%;
            height: 170px;
            cursor: crosshair;
        }

        /* ============================================================== */
        /* DARK MODE PALETTE (High Contrast, Crisp Badges & Pure Logos) */
        /* ============================================================== */
        html.dark body {
            background-color: #120b07 !important;
            color: #f7efe6 !important;
        }

        html.dark header {
            background-color: rgba(22, 13, 8, 0.96) !important;
            border-bottom-color: #382114 !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5) !important;
        }

        /* LOGO STYLING IN DARK MODE: Pure White Logo with subtle gold accent */
        html.dark .logo-box,
        html.dark div.logo-box,
        html.dark a .logo-box {
            background-color: transparent !important;
            border: 1px solid rgba(201, 154, 62, 0.45) !important;
            box-shadow: 0 0 15px rgba(201, 154, 62, 0.15) !important;
        }

        /* Pure White Logo in Dark Mode & Brown Logo in Light Mode */
        html.dark .logo-light-version {
            display: none !important;
        }
        html.dark .logo-dark-version {
            display: block !important;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.5)) !important;
        }
        html:not(.dark) .logo-light-version,
        html.light .logo-light-version {
            display: block !important;
        }
        html:not(.dark) .logo-dark-version,
        html.light .logo-dark-version {
            display: none !important;
        }

        /* Dark Mode Cards */
        html.dark .bg-white {
            background-color: #1c110b !important;
            border-color: #3d2517 !important;
        }

        html.dark .border-champagne-200,
        html.dark .border-champagne-200\/90,
        html.dark .border-champagne-100 {
            border-color: #382114 !important;
        }

        html.dark .bg-champagne-50,
        html.dark .bg-champagne-50\/70,
        html.dark .bg-champagne-50\/80,
        html.dark .bg-champagne-100,
        html.dark .bg-champagne-100\/70,
        html.dark .bg-stone-50 {
            background-color: #26160e !important;
            border-color: #442718 !important;
        }

        html.dark .bg-kowpi-50 {
            background-color: #2b180f !important;
            border-color: #552f1e !important;
        }

        /* Typography & Colors in Dark Mode (High Contrast & Sharp Readability) */
        html.dark .text-kowpi-950,
        html.dark .text-stone-900,
        html.dark .text-stone-800 {
            color: #ffffff !important;
        }

        html.dark .text-kowpi-900 {
            color: #fef0e2 !important;
        }

        html.dark .text-kowpi-800,
        html.dark .text-kowpi-700,
        html.dark .text-kowpi-600 {
            color: #f6cbb0 !important;
        }

        html.dark .text-stone-700,
        html.dark .text-stone-600 {
            color: #ded0c5 !important;
        }

        html.dark .text-stone-500 {
            color: #c4b0a4 !important;
        }

        html.dark .text-stone-400 {
            color: #a69185 !important;
        }

        html.dark label {
            color: #f7efe6 !important;
        }

        /* Gold and Highlight Badges */
        html.dark .text-gold-dark {
            color: #fde68a !important;
        }

        /* Status & Category Badges in Dark Mode */
        html.dark .bg-emerald-100 {
            background-color: #064e3b !important;
            color: #a7f3d0 !important;
            border: 1px solid #059669 !important;
        }
        html.dark .text-emerald-800,
        html.dark .text-emerald-900 {
            color: #a7f3d0 !important;
        }

        html.dark .bg-amber-100 {
            background-color: #78350f !important;
            color: #fef3c7 !important;
            border: 1px solid #d97706 !important;
        }
        html.dark .text-amber-900,
        html.dark .text-amber-800 {
            color: #fef3c7 !important;
        }

        html.dark .bg-blue-100 {
            background-color: #1e3a8a !important;
            color: #bfdbfe !important;
            border: 1px solid #3b82f6 !important;
        }
        html.dark .text-blue-800 {
            color: #bfdbfe !important;
        }

        html.dark .bg-purple-100 {
            background-color: #4c1d95 !important;
            color: #ddd6fe !important;
            border: 1px solid #7c3aed !important;
        }
        html.dark .text-purple-800 {
            color: #ddd6fe !important;
        }

        /* Meeting Code Pills & Taglines */
        html.dark .font-mono {
            color: #fde68a !important;
        }
        html.dark #presensi-aktif .font-mono {
            background-color: #2b170e !important;
            border: 1px solid #5c321d !important;
            color: #fde68a !important;
        }

        html.dark .bg-champagne-200\/60 {
            background-color: #381f12 !important;
            color: #fde68a !important;
            border: 1px solid #6b381a !important;
        }

        /* Form Inputs & Select in Dark Mode */
        html.dark input[type="text"],
        html.dark input[type="tel"],
        html.dark input[type="email"],
        html.dark select,
        html.dark textarea {
            background-color: #140c07 !important;
            border-color: #4d2b17 !important;
            color: #ffffff !important;
        }

        html.dark select option {
            background-color: #1a0f0a !important;
            color: #ffffff !important;
        }

        html.dark input::placeholder {
            color: #8c7365 !important;
        }

        html.dark input:focus,
        html.dark select:focus,
        html.dark textarea:focus {
            border-color: #c99a3e !important;
            box-shadow: 0 0 0 2px rgba(201, 154, 62, 0.3) !important;
        }

        /* Signature Canvas in Dark Mode */
        html.dark .signature-wrapper {
            background-color: #140c07 !important;
            border-color: #58331e !important;
        }

        html.dark .signature-wrapper.active {
            border-color: #c99a3e !important;
            background-color: #190f09 !important;
            box-shadow: 0 0 0 3px rgba(201, 154, 62, 0.25) !important;
        }

        html.dark #sigPlaceholder {
            color: #8c7365 !important;
        }

        /* Spotlight Header in Dark Mode */
        html.dark #presensi-aktif > div:first-child {
            background: linear-gradient(135deg, #27150c 0%, #1c0f08 50%, #2f180d 100%) !important;
            border-color: #4f2d19 !important;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.7) !important;
        }

        /* Live Attendee Pill in Dark Mode */
        html.dark #presensi-aktif .shrink-0.bg-white\/90 {
            background-color: #24140b !important;
            border-color: #4a2a19 !important;
        }
        html.dark #presensi-aktif .w-12.h-12.bg-kowpi-50 {
            background-color: #331a0e !important;
            border-color: #5c321d !important;
            color: #fde68a !important;
        }

        /* Attendee List Cards in Dark Mode */
        html.dark #attendeeList .bg-champagne-50\/80 {
            background-color: #26160d !important;
            border-color: #422616 !important;
        }
        html.dark #attendeeList .bg-kowpi-100 {
            background-color: #3a1e11 !important;
            color: #fde68a !important;
            border: 1px solid #5c321d !important;
        }
        html.dark #attendeeList .text-stone-900 {
            color: #ffffff !important;
        }
        html.dark #attendeeList .text-stone-500 {
            color: #c4b0a4 !important;
        }
        html.dark #attendeeList .text-stone-400 {
            color: #a89487 !important;
        }

        /* Directory Cards in Dark Mode */
        html.dark .grid .bg-white {
            background-color: #1c110a !important;
            border-color: #3d2416 !important;
        }
        html.dark .grid-cols-3 .bg-champagne-100\/70 {
            background-color: #27160d !important;
            border-color: #4a2a19 !important;
        }
        html.dark .grid-cols-3 .text-kowpi-900 {
            color: #fde68a !important;
        }
        html.dark .grid-cols-3 .text-stone-500 {
            color: #bcaaa0 !important;
        }
        html.dark .bg-champagne-50\/70 {
            background-color: #160d07 !important;
            border-top-color: #381f12 !important;
        }
        html.dark .bg-champagne-50\/70 button {
            color: #f5d77f !important;
        }
        html.dark .bg-champagne-50\/70 button:hover {
            color: #ffffff !important;
        }
        html.dark .bg-champagne-50\/70 a {
            background-color: #26160e !important;
            border-color: #4a2a19 !important;
            color: #f5ece3 !important;
        }

        /* Modal Dialog in Dark Mode */
        html.dark #meetingModal > div {
            background-color: #1a0f08 !important;
            border-color: #442615 !important;
            color: #f5ece3 !important;
        }

        html.dark #meetingModal .bg-champagne-50\/60 {
            background-color: #24140b !important;
            border-color: #3a1f11 !important;
        }
        html.dark #meetingModal .bg-champagne-50,
        html.dark #meetingModal .bg-stone-50 {
            background-color: #24140b !important;
            border-color: #3a1f11 !important;
            color: #efe5dc !important;
        }
        html.dark #meetingModal .bg-kowpi-50\/70 {
            background-color: #2d170c !important;
            border-color: #542d19 !important;
            color: #ffffff !important;
        }
        html.dark #meetingModal .group\/pcard {
            background-color: #22130a !important;
            border-color: #3d2213 !important;
        }
        html.dark #meetingModal .group\/pcard div.bg-white {
            background-color: #22130a !important;
            color: #ded0c5 !important;
            border-top-color: #3d2213 !important;
        }

        /* Card Hover Shadows in Dark Mode */
        html.dark .hover\:shadow-xl:hover,
        html.dark .hover\:shadow-md:hover {
            box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.8), 0 0 15px rgba(201, 154, 62, 0.12) !important;
            border-color: #5e3721 !important;
        }

        /* Footer in Dark Mode */
        html.dark footer {
            background-color: #140c07 !important;
            border-top-color: #361f12 !important;
        }

        /* Final Logo Box Enforcement in Dark Mode: Clean, transparent luxury glass with gold rim */
        html.dark .logo-box,
        html.dark .logo-box.bg-white,
        html.dark div.logo-box,
        html.dark a .logo-box {
            background-color: transparent !important;
            border: 1px solid rgba(201, 154, 62, 0.4) !important;
            box-shadow: 0 0 16px rgba(201, 154, 62, 0.12) !important;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col selection:bg-gold/20 selection:text-kowpi-900">

    <!-- Top Premium Navigation Bar -->
    <header class="bg-white/95 backdrop-blur-md border-b border-champagne-200 shadow-sm sticky top-0 z-40 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between gap-3">
            <!-- Brand Logo & Title -->
            <a href="<?= base_url('/') ?>" class="flex items-center gap-3.5 group">
                <div class="logo-box p-1.5 sm:p-2 bg-white rounded-2xl border border-stone-200/90 shadow-sm group-hover:border-gold/60 transition-all flex items-center justify-center">
                    <img src="<?= base_url('img/logo-kowpi.png') ?>" alt="KOWPI Logo" class="h-9 sm:h-11 w-auto object-contain logo-light-version block dark:hidden">
                    <img src="<?= base_url('img/logo-kowpi-white.png') ?>" alt="KOWPI Logo" class="h-9 sm:h-11 w-auto object-contain logo-dark-version hidden dark:block">
                </div>
                <div>
                    <span class="font-serif-kowpi font-bold text-base sm:text-lg text-kowpi-900 dark:text-white group-hover:text-kowpi-600 dark:group-hover:text-gold-light transition-colors leading-tight block">
                        KOWPI.ID
                    </span>
                    <span class="text-[10px] sm:text-[11px] font-semibold tracking-wider uppercase text-gold-dark dark:text-gold-light block">
                        Notula & Presensi Digital Rapat
                    </span>
                </div>
            </a>

            <!-- Navigation Links, Theme Toggle & Action Button -->
            <div class="flex items-center gap-2 sm:gap-4">
                <!-- THEME TOGGLE (LIGHT vs DARK) -->
                <div class="flex items-center p-1 rounded-xl bg-stone-100 border border-stone-200 dark:bg-[#251710] dark:border-[#4d3222] shadow-2xs">
                    <button type="button" id="btnThemeLight" onclick="setTheme('light')" 
                            class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold transition-all" 
                            title="Tampilan Terang (Light)">
                        <i data-lucide="sun" class="w-3.5 h-3.5 text-amber-500"></i>
                        <span class="text-xs font-bold">Light</span>
                    </button>
                    <button type="button" id="btnThemeDark" onclick="setTheme('dark')" 
                            class="flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold transition-all" 
                            title="Tampilan Gelap (Dark)">
                        <i data-lucide="moon" class="w-3.5 h-3.5 text-gold-light"></i>
                        <span class="text-xs font-bold">Dark</span>
                    </button>
                </div>

                <a href="#direktori-arsip" class="hidden lg:inline-flex items-center gap-1.5 text-xs font-semibold text-stone-600 hover:text-kowpi-700 dark:text-stone-300 dark:hover:text-gold transition-colors">
                    <i data-lucide="archive" class="w-4 h-4 text-stone-400"></i>
                    <span>Direktori Rapat</span>
                </a>

                <?php if (session()->get('is_admin_logged_in') || session()->get('isLoggedIn')): ?>
                    <a href="<?= base_url('dashboard') ?>"
                       class="px-3.5 py-2 rounded-xl bg-kowpi-700 hover:bg-kowpi-800 text-white font-bold text-xs shadow-md transition-all flex items-center gap-2">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 text-gold-light"></i>
                        <span class="hidden sm:inline">Dashboard Admin</span>
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('login') ?>"
                       class="px-3.5 py-2 rounded-xl bg-white hover:bg-stone-50 text-kowpi-800 border border-kowpi-300 hover:border-kowpi-600 font-bold text-xs shadow-sm transition-all flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-4 h-4 text-kowpi-600"></i>
                        <span class="hidden sm:inline">Masuk Panel Pengurus</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 space-y-12">

        <!-- ============================================================== -->
        <!-- SECTION 1: SPOTLIGHT RAPAT AKTIF & FORMULIR PRESENSI TTD -->
        <!-- ============================================================== -->
        <?php if ($activeMeeting): ?>
            <section id="presensi-aktif" class="space-y-6">
                <!-- Banner Spotlight Header (Light Luxury) -->
                <div class="rounded-3xl bg-gradient-to-br from-white via-champagne-50 to-kowpi-50 border border-champagne-200/90 shadow-sm p-6 sm:p-8 relative overflow-hidden">
                    <div class="absolute -right-12 -top-12 w-64 h-64 bg-gold/10 rounded-full blur-3xl pointer-events-none"></div>

                    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2.5">
                                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300 text-xs font-bold flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Rapat Aktif Hari Ini
                                </span>
                                <span class="font-mono text-xs font-bold text-gold-dark bg-white px-2.5 py-0.5 rounded-lg border border-champagne-200">
                                    <?= esc($activeMeeting['meeting_code']) ?>
                                </span>
                                <span class="text-xs font-semibold text-stone-500 hidden sm:inline">&bull; <?= esc($activeMeeting['category']) ?></span>
                            </div>

                            <h1 class="font-serif-kowpi font-bold text-2xl sm:text-3xl text-kowpi-950 leading-tight">
                                <?= esc($activeMeeting['title']) ?>
                            </h1>

                            <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-stone-600 pt-1">
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="calendar" class="w-4 h-4 text-kowpi-600"></i>
                                    <span><?= date('l, d F Y', strtotime($activeMeeting['meeting_date'])) ?></span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="clock" class="w-4 h-4 text-kowpi-600"></i>
                                    <span><?= substr($activeMeeting['start_time'], 0, 5) ?> - <?= substr($activeMeeting['end_time'], 0, 5) ?> WIB</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="map-pin" class="w-4 h-4 text-kowpi-600"></i>
                                    <span><?= esc($activeMeeting['location']) ?> (<?= ucfirst($activeMeeting['meeting_type']) ?>)</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <i data-lucide="user-check" class="w-4 h-4 text-kowpi-600"></i>
                                    <span>Pimpinan: <strong><?= esc($activeMeeting['leader_name']) ?></strong></span>
                                </div>
                            </div>

                            <?php if (!empty($activeMeeting['photos'])): ?>
                                <!-- Photo preview strip for Active Meeting -->
                                <div class="pt-3 border-t border-champagne-200/70 flex flex-wrap items-center gap-3">
                                    <span class="text-[11px] font-bold text-kowpi-900 flex items-center gap-1.5 shrink-0">
                                        <i data-lucide="camera" class="w-3.5 h-3.5 text-gold-dark"></i>
                                        <span>Dokumentasi Sesi Hari Ini:</span>
                                    </span>
                                    <div class="flex items-center gap-2 overflow-x-auto pb-1">
                                        <?php foreach ($activeMeeting['photos'] as $ap): ?>
                                            <button type="button" onclick="openPhotoModal('<?= base_url($ap['file_path']) ?>', '<?= esc(addslashes($ap['caption'] ?? $activeMeeting['title'])) ?>')" 
                                                    class="relative group/aph shrink-0 rounded-xl overflow-hidden border border-champagne-300 shadow-2xs hover:ring-2 hover:ring-gold transition cursor-pointer"
                                                    title="<?= esc($ap['caption'] ?? 'Dokumentasi Rapat') ?>">
                                                <img src="<?= base_url($ap['file_path']) ?>" alt="Foto Rapat" class="w-16 h-11 object-cover group-hover/aph:scale-110 transition duration-300">
                                                <div class="absolute inset-0 bg-black/0 group-hover/aph:bg-black/20 transition flex items-center justify-center">
                                                    <i data-lucide="zoom-in" class="w-3 h-3 text-white opacity-0 group-hover/aph:opacity-100 transition"></i>
                                                </div>
                                            </button>
                                        <?php endforeach; ?>
                                        <button type="button" onclick="openMeetingModal(<?= $activeMeeting['id'] ?>)" class="text-[11px] font-bold text-kowpi-800 hover:text-kowpi-950 px-2 py-1 rounded-lg bg-champagne-100 hover:bg-champagne-200 transition">
                                            Lihat Detail
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Live Attendee Pill -->
                        <div class="shrink-0 bg-white/90 border border-champagne-200 rounded-2xl p-4 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-kowpi-50 border border-kowpi-200 flex items-center justify-center text-kowpi-700">
                                <i data-lucide="users" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <span class="text-[11px] text-stone-400 font-bold uppercase tracking-wider block">Telah Hadir</span>
                                <div class="text-2xl font-extrabold text-kowpi-900">
                                    <span id="counterPresent"><?= count($activeAttendances) ?></span>
                                    <span class="text-xs font-medium text-stone-500">Peserta Ber-TTD</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2-Columns: Form Presensi TTD (Left) & Peserta Hadir (Right) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                    <!-- Left: Form Presensi Peserta -->
                    <div class="lg:col-span-7 bg-white rounded-3xl border border-champagne-200 shadow-sm p-6 sm:p-8 space-y-6">
                        <div class="border-b border-champagne-100 pb-4">
                            <span class="text-[11px] font-bold uppercase tracking-widest text-kowpi-600 block">
                                Meja Presensi Mandiri
                            </span>
                            <h2 class="font-serif-kowpi font-bold text-xl text-kowpi-950">
                                Silakan Isi Kehadiran & Bubuhkan Tanda Tangan Anda
                            </h2>
                            <p class="text-xs text-stone-500 mt-1">
                                Tanda tangan digital akan dicantumkan secara resmi pada lembar daftar hadir dan berkas notula rapat KOWPI.
                            </p>
                        </div>

                        <?php if (empty($activeMeeting['is_presence_open'])): ?>
                            <div class="p-6 rounded-2xl bg-amber-50 border border-amber-200 text-center space-y-2">
                                <i data-lucide="lock" class="w-8 h-8 text-amber-700 mx-auto"></i>
                                <h3 class="font-bold text-amber-900 text-sm">Presensi Telah Dikunci</h3>
                                <p class="text-xs text-amber-700">Sesi presensi untuk rapat ini telah resmi ditutup oleh sekretariat.</p>
                            </div>
                        <?php else: ?>
                            <form id="publicAttendanceForm" class="space-y-4 text-xs">
                                <input type="hidden" name="meeting_id" value="<?= $activeMeeting['id'] ?>">
                                <input type="hidden" name="signature_data" id="signatureData">

                                <div>
                                    <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                                        Nama Lengkap & Gelar <span class="text-rose-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="participant_name" id="participantName" required
                                               placeholder="Contoh: Dr. Drs. H. Asmuni, M.A."
                                               class="w-full pl-10 pr-4 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-2 focus:ring-kowpi-500 focus:outline-none bg-stone-50/40">
                                        <i data-lucide="user" class="w-4 h-4 text-stone-400 absolute left-3.5 top-3"></i>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                                            Instansi / Jabatan / Divisi <span class="text-rose-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <input type="text" name="institution" id="institution" required
                                                   placeholder="Contoh: Pengurus KOWPI / Tamu"
                                                   class="w-full pl-10 pr-4 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-2 focus:ring-kowpi-500 focus:outline-none bg-stone-50/40">
                                            <i data-lucide="building-2" class="w-4 h-4 text-stone-400 absolute left-3.5 top-3"></i>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                                            Status Kehadiran <span class="text-rose-500">*</span>
                                        </label>
                                        <select name="attendance_status" id="attendanceStatus" class="w-full py-2.5 px-3 border border-stone-300 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-kowpi-500 focus:outline-none bg-stone-50/40">
                                            <option value="hadir_offline" selected>&bull; Hadir Tatap Muka (Offline)</option>
                                            <option value="hadir_online">&bull; Hadir Daring (Online)</option>
                                            <option value="izin">&bull; Izin</option>
                                            <option value="sakit">&bull; Sakit</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                                            Nomor WhatsApp (Opsional)
                                        </label>
                                        <div class="relative">
                                            <input type="tel" name="phone" id="phone" placeholder="081234567890"
                                                   class="w-full pl-10 pr-4 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-2 focus:ring-kowpi-500 focus:outline-none bg-stone-50/40">
                                            <i data-lucide="phone" class="w-4 h-4 text-stone-400 absolute left-3.5 top-3"></i>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                                            Email (Opsional)
                                        </label>
                                        <div class="relative">
                                            <input type="email" name="email" id="email" placeholder="nama@email.com"
                                                   class="w-full pl-10 pr-4 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-2 focus:ring-kowpi-500 focus:outline-none bg-stone-50/40">
                                            <i data-lucide="mail" class="w-4 h-4 text-stone-400 absolute left-3.5 top-3"></i>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                                        Catatan / Aspirasi Singkat (Opsional)
                                    </label>
                                    <input type="text" name="notes" id="notes" placeholder="Catatan atau masukan singkat terkait agenda rapat..."
                                           class="w-full px-4 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-2 focus:ring-kowpi-500 focus:outline-none bg-stone-50/40">
                                </div>

                                <!-- Signature Pad Canvas -->
                                <div class="pt-2">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <label class="block text-stone-700 font-bold uppercase tracking-wider text-[11px] flex items-center gap-1.5">
                                            <i data-lucide="pen-tool" class="w-3.5 h-3.5 text-kowpi-700"></i>
                                            <span>Tanda Tangan Digital (Sentuh / Stylus / Mouse)</span>
                                            <span class="text-rose-500">*</span>
                                        </label>
                                        <button type="button" id="clearSigBtn" class="text-rose-600 hover:text-rose-800 font-bold text-[11px] flex items-center gap-1 px-2 py-0.5 rounded hover:bg-rose-50 transition-colors">
                                            <i data-lucide="rotate-ccw" class="w-3 h-3"></i>
                                            <span>Hapus / Ulangi</span>
                                        </button>
                                    </div>

                                    <div class="signature-wrapper" id="signatureContainer">
                                        <canvas id="signatureCanvas" class="signature-pad-canvas"></canvas>
                                        <div id="sigPlaceholder" class="absolute inset-0 flex items-center justify-center pointer-events-none text-stone-400 text-xs italic">
                                            <span>Silakan goreskan tanda tangan Anda di area ini...</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="pt-2">
                                    <button type="submit" id="submitBtn"
                                            class="w-full py-3.5 px-6 rounded-2xl bg-kowpi-700 hover:bg-kowpi-800 text-white font-bold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 group">
                                        <i data-lucide="check-circle" class="w-4 h-4 text-gold-light group-hover:scale-110 transition-transform"></i>
                                        <span>Konfirmasi Kehadiran & Simpan Tanda Tangan</span>
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>

                    <!-- Right: Daftar Peserta Terkini -->
                    <div class="lg:col-span-5 bg-white rounded-3xl border border-champagne-200 shadow-sm p-6 sm:p-8 space-y-4">
                        <div class="flex items-center justify-between border-b border-champagne-100 pb-3">
                            <div>
                                <h3 class="font-serif-kowpi font-bold text-base text-kowpi-950">
                                    Daftar Peserta Hadir
                                </h3>
                                <p class="text-[11px] text-stone-400">Kehadiran tercatat secara real-time</p>
                            </div>
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse" title="Realtime Active"></span>
                        </div>

                        <div id="attendeeList" class="space-y-3 max-h-[520px] overflow-y-auto pr-1">
                            <?php if (empty($activeAttendances)): ?>
                                <div id="emptyAttendee" class="py-12 text-center text-stone-400 text-xs">
                                    <i data-lucide="users" class="w-8 h-8 mx-auto mb-2 text-stone-300"></i>
                                    Belum ada peserta yang mengisi presensi. Jadilah yang pertama!
                                </div>
                            <?php else: ?>
                                <?php foreach ($activeAttendances as $att): ?>
                                    <div class="p-3 rounded-2xl bg-champagne-50/80 border border-champagne-200/80 flex items-center justify-between gap-3 text-xs">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="w-9 h-9 rounded-xl bg-kowpi-100 text-kowpi-800 font-serif-kowpi font-bold text-sm flex items-center justify-center shrink-0">
                                                <?= strtoupper(substr($att['participant_name'], 0, 1)) ?>
                                            </div>
                                            <div class="min-w-0">
                                                <div class="font-bold text-stone-900 truncate"><?= esc($att['participant_name']) ?></div>
                                                <div class="text-[10px] text-stone-500 truncate"><?= esc($att['institution']) ?></div>
                                            </div>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold <?= $att['attendance_status'] === 'hadir_offline' ? 'bg-amber-100 text-amber-900' : 'bg-emerald-100 text-emerald-900' ?>">
                                                <?= ucwords(str_replace('_', ' ', $att['attendance_status'])) ?>
                                            </span>
                                            <div class="text-[10px] text-stone-400 mt-0.5"><?= date('H:i', strtotime($att['check_in_time'])) ?> WIB</div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </section>
        <?php endif; ?>

        <!-- ============================================================== -->
        <!-- SECTION 2: DIREKTORI RAPAT-RAPAT SEBELUMNYA & ARSIP NOTULA -->
        <!-- ============================================================== -->
        <section id="direktori-arsip" class="pt-6 space-y-6">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-champagne-200 pb-4">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-champagne-200/60 text-kowpi-800 text-[11px] font-bold uppercase tracking-wider mb-2">
                        <i data-lucide="archive" class="w-3.5 h-3.5 text-gold-dark"></i>
                        Arsip Dokumen Historis
                    </div>
                    <h2 class="font-serif-kowpi font-bold text-2xl sm:text-3xl text-kowpi-950">
                        Direktori Rapat & Notula Sebelumnya
                    </h2>
                    <p class="text-xs sm:text-sm text-stone-600 mt-1 max-w-2xl">
                        Daftar seluruh agenda pertemuan, keputusan resmi rapat, dan notulensi yang telah terselenggara di lingkungan KOWPI.
                    </p>
                </div>

                <!-- Stats summary badge -->
                <div class="flex items-center gap-4 text-xs text-stone-500">
                    <div>Total Rapat: <strong class="text-kowpi-900 font-bold"><?= $stats['total_meetings'] ?? 0 ?></strong></div>
                    <div>&bull;</div>
                    <div>Total Hadir: <strong class="text-kowpi-900 font-bold"><?= $stats['total_attendees'] ?? 0 ?></strong></div>
                </div>
            </div>

            <!-- Filter & Search Bar -->
            <div class="bg-white rounded-2xl p-4 border border-champagne-200 shadow-sm">
                <form method="GET" action="<?= base_url('/#direktori-arsip') ?>" class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                    <div class="sm:col-span-2 relative">
                        <input type="text" name="q" value="<?= esc($search ?? '') ?>" placeholder="Cari berdasarkan judul, pimpinan, atau kode rapat..."
                               class="w-full pl-9 pr-4 py-2.5 border border-stone-300 rounded-xl focus:ring-2 focus:ring-kowpi-500 focus:outline-none">
                        <i data-lucide="search" class="w-4 h-4 text-stone-400 absolute left-3 top-3"></i>
                    </div>

                    <div class="flex items-center gap-2">
                        <select name="category" class="w-full py-2.5 px-3 border border-stone-300 rounded-xl focus:ring-2 focus:ring-kowpi-500 focus:outline-none bg-white">
                            <option value="">Semua Kategori Rapat</option>
                            <option value="Rapat Pleno" <?= ($category ?? '') === 'Rapat Pleno' ? 'selected' : '' ?>>Rapat Pleno</option>
                            <option value="Rapat Pimpinan" <?= ($category ?? '') === 'Rapat Pimpinan' ? 'selected' : '' ?>>Rapat Pimpinan</option>
                            <option value="Rapat Koordinasi" <?= ($category ?? '') === 'Rapat Koordinasi' ? 'selected' : '' ?>>Rapat Koordinasi</option>
                            <option value="Rapat Kerja" <?= ($category ?? '') === 'Rapat Kerja' ? 'selected' : '' ?>>Rapat Kerja</option>
                            <option value="Rapat Evaluasi" <?= ($category ?? '') === 'Rapat Evaluasi' ? 'selected' : '' ?>>Rapat Evaluasi</option>
                        </select>
                        <button type="submit" class="px-4 py-2.5 bg-kowpi-700 hover:bg-kowpi-800 text-white rounded-xl font-bold">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- Previous Meetings Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if (empty($previousMeetings)): ?>
                    <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-champagne-200">
                        <div class="w-16 h-16 rounded-full bg-champagne-100 flex items-center justify-center mx-auto mb-3 text-stone-400">
                            <i data-lucide="folder-x" class="w-8 h-8"></i>
                        </div>
                        <h4 class="font-serif-kowpi font-bold text-lg text-stone-800 mb-1">Tidak Ditemukan Berkas Rapat Sebelumnya</h4>
                        <p class="text-xs text-stone-500">Belum ada arsip rapat sebelumnya atau tidak ada rapat yang sesuai dengan filter pencarian.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($previousMeetings as $pm): ?>
                        <?php 
                            $hasPhotos = !empty($pm['photos']);
                            $photoCount = $hasPhotos ? count($pm['photos']) : 0;
                            $primaryPhoto = $hasPhotos ? $pm['photos'][0] : null;
                        ?>
                        <div class="bg-white rounded-3xl border border-champagne-200/90 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                            
                            <!-- PHOTO DOCUMENTATION SHOWCASE HEADER -->
                            <?php if ($hasPhotos && $primaryPhoto): ?>
                                <div class="relative w-full h-48 bg-stone-100 overflow-hidden cursor-pointer group/cover" 
                                     data-url="<?= base_url($primaryPhoto['file_path']) ?>"
                                     data-caption="<?= esc($primaryPhoto['caption'] ?? $pm['title']) ?>"
                                     onclick="openPhotoModal(this.dataset.url, this.dataset.caption)">
                                    <img src="<?= base_url($primaryPhoto['file_path']) ?>" 
                                         alt="<?= esc($primaryPhoto['caption'] ?? $pm['title']) ?>" 
                                         class="w-full h-full object-cover group-hover/cover:scale-105 transition-transform duration-500">
                                    
                                    <!-- Gradient Overlay for readability -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/25 to-black/35 pointer-events-none"></div>

                                    <!-- Top Badges Overlay -->
                                    <div class="absolute top-3 inset-x-3 flex items-center justify-between pointer-events-none">
                                        <span class="font-mono text-[10px] font-bold text-kowpi-900 bg-white/95 backdrop-blur-md px-2.5 py-1 rounded-lg shadow-sm border border-white/60">
                                            <?= esc($pm['meeting_code']) ?>
                                        </span>
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider backdrop-blur-md shadow-xs <?= $pm['status'] === 'archived' ? 'bg-purple-900/80 text-purple-100 border border-purple-300/40' : ($pm['status'] === 'completed' ? 'bg-blue-900/80 text-blue-100 border border-blue-300/40' : 'bg-emerald-900/80 text-emerald-100 border border-emerald-300/40') ?>">
                                            <?= ucfirst($pm['status']) ?>
                                        </span>
                                    </div>

                                    <!-- Bottom Caption & Photo Count Pill -->
                                    <div class="absolute bottom-3 inset-x-3 flex items-end justify-between pointer-events-none gap-2">
                                        <div class="text-[11px] text-white/95 line-clamp-1 italic font-light drop-shadow">
                                            <i data-lucide="camera" class="w-3.5 h-3.5 inline mr-1 text-gold-light"></i>
                                            <span><?= esc($primaryPhoto['caption'] ?? 'Dokumentasi Rapat') ?></span>
                                        </div>
                                        <span class="shrink-0 flex items-center gap-1 px-2 py-0.5 rounded-lg bg-black/60 backdrop-blur-md border border-white/20 text-white text-[10px] font-bold shadow-xs">
                                            <i data-lucide="image" class="w-3 h-3 text-gold-light"></i>
                                            <span><?= $photoCount ?> Foto</span>
                                        </span>
                                    </div>

                                    <!-- Hover Zoom Pill Indicator -->
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover/cover:opacity-100 transition-opacity duration-300 bg-black/20 pointer-events-none">
                                        <span class="px-3 py-1.5 rounded-full bg-white/95 backdrop-blur-md text-stone-900 text-xs font-bold shadow-lg flex items-center gap-1.5 transform translate-y-2 group-hover/cover:translate-y-0 transition-transform">
                                            <i data-lucide="maximize-2" class="w-3.5 h-3.5 text-gold-dark"></i>
                                            <span>Perbesar Foto</span>
                                        </span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <!-- Elegant Light Premium Placeholder when no photos -->
                                <div class="relative w-full h-28 bg-gradient-to-br from-champagne-100/90 via-stone-50 to-champagne-200/60 p-4 border-b border-champagne-200 flex flex-col justify-between">
                                    <div class="flex items-center justify-between">
                                        <span class="font-mono text-[10px] font-bold text-kowpi-800 bg-white px-2.5 py-1 rounded-lg border border-champagne-200 shadow-2xs">
                                            <?= esc($pm['meeting_code']) ?>
                                        </span>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold <?= $pm['status'] === 'archived' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' ?>">
                                            <?= ucfirst($pm['status']) ?>
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between text-stone-400 text-xs">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-gold-dark"><?= esc($pm['category']) ?></span>
                                        <span class="text-[10px] flex items-center gap-1 text-stone-400"><i data-lucide="image-off" class="w-3 h-3"></i> Belum ada foto</span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Card Body -->
                            <div class="p-5 sm:p-6 space-y-4">
                                <?php if ($hasPhotos): ?>
                                    <div class="text-[10px] font-bold uppercase tracking-wider text-gold-dark">
                                        <?= esc($pm['category']) ?>
                                    </div>
                                <?php endif; ?>

                                <h3 class="font-serif-kowpi font-bold text-base text-stone-900 line-clamp-2 leading-snug">
                                    <?= esc($pm['title']) ?>
                                </h3>

                                <!-- Date & Details -->
                                <div class="space-y-1.5 text-xs text-stone-600 pt-2 border-t border-champagne-100">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="calendar" class="w-3.5 h-3.5 text-stone-400"></i>
                                        <span><?= date('d F Y', strtotime($pm['meeting_date'])) ?> &bull; <?= substr($pm['start_time'], 0, 5) ?> WIB</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="user-check" class="w-3.5 h-3.5 text-stone-400"></i>
                                        <span class="truncate">Pimpinan: <strong><?= esc($pm['leader_name']) ?></strong></span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-stone-400"></i>
                                        <span class="truncate"><?= esc($pm['location']) ?></span>
                                    </div>
                                </div>

                                <!-- Photo Gallery Thumbnails Strip (if more than 1 photo) -->
                                <?php if ($photoCount > 1): ?>
                                    <div class="pt-2 border-t border-champagne-100">
                                        <div class="flex items-center justify-between text-[11px] text-stone-500 font-semibold mb-1.5">
                                            <span class="flex items-center gap-1 text-stone-600">
                                                <i data-lucide="images" class="w-3.5 h-3.5 text-gold-dark"></i>
                                                <span>Galeri Dokumentasi (<?= $photoCount ?> Foto)</span>
                                            </span>
                                            <button type="button" onclick="openMeetingModal(<?= $pm['id'] ?>)" class="text-kowpi-700 hover:text-kowpi-900 font-bold hover:underline text-[10px]">
                                                Buka Notula & Galeri
                                            </button>
                                        </div>
                                        <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-thin">
                                            <?php foreach ($pm['photos'] as $idx => $p): ?>
                                                <button type="button" 
                                                        data-url="<?= base_url($p['file_path']) ?>"
                                                        data-caption="<?= esc($p['caption'] ?? $pm['title']) ?>"
                                                        onclick="openPhotoModal(this.dataset.url, this.dataset.caption)"
                                                        class="relative shrink-0 w-16 h-12 rounded-xl overflow-hidden border-2 <?= $idx === 0 ? 'border-gold shadow-xs ring-1 ring-gold/40' : 'border-stone-200 hover:border-gold-dark' ?> group/thumb transition cursor-pointer"
                                                        title="<?= esc($p['caption'] ?? 'Foto ' . ($idx + 1)) ?>">
                                                    <img src="<?= base_url($p['file_path']) ?>" alt="Thumb" class="w-full h-full object-cover group-hover/thumb:scale-110 transition duration-300">
                                                    <div class="absolute inset-0 bg-black/0 group-hover/thumb:bg-black/30 transition flex items-center justify-center">
                                                        <i data-lucide="zoom-in" class="w-3.5 h-3.5 text-white opacity-0 group-hover/thumb:opacity-100 transition"></i>
                                                    </div>
                                                </button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Counters Strip -->
                                <div class="grid grid-cols-3 gap-2 pt-2 text-center text-[11px]">
                                    <div class="p-2 rounded-xl bg-champagne-100/70 border border-champagne-200">
                                        <div class="font-extrabold text-kowpi-900"><?= $pm['total_present'] ?? 0 ?></div>
                                        <div class="text-[10px] text-stone-500">Hadir TTD</div>
                                    </div>
                                    <div class="p-2 rounded-xl bg-champagne-100/70 border border-champagne-200">
                                        <div class="font-extrabold text-kowpi-900"><?= $pm['has_minutes'] ? 'Ada' : '-' ?></div>
                                        <div class="text-[10px] text-stone-500">Notula</div>
                                    </div>
                                    <div class="p-2 rounded-xl bg-champagne-100/70 border border-champagne-200">
                                        <div class="font-extrabold text-kowpi-900"><?= $pm['total_photos'] ?? 0 ?></div>
                                        <div class="text-[10px] text-stone-500">Foto</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Footer Actions -->
                            <div class="p-3.5 bg-champagne-50/70 border-t border-champagne-200 flex items-center justify-between text-xs">
                                <button type="button" onclick="openMeetingModal(<?= $pm['id'] ?>)" class="font-bold text-kowpi-800 hover:text-kowpi-950 flex items-center gap-1.5 transition">
                                    <i data-lucide="file-text" class="w-4 h-4 text-gold-dark"></i>
                                    <span>Lihat Notula & Berkas</span>
                                </button>
                                <a href="<?= base_url('export/print-dokumen/' . $pm['id']) ?>" target="_blank" class="p-1.5 rounded-lg bg-white border border-champagne-200 hover:bg-stone-50 text-stone-700 shadow-2xs hover:text-kowpi-800 transition" title="Cetak Berkas PDF">
                                    <i data-lucide="printer" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

    </main>

    <!-- Modal: Detail Ringkasan Notula & Rapat Publik -->
    <div id="meetingModal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-3xl w-full shadow-2xl border border-champagne-200 max-h-[90vh] flex flex-col overflow-hidden">
            <!-- Modal Header -->
            <div class="p-5 border-b border-champagne-200 flex items-center justify-between bg-champagne-50/60">
                <div class="flex items-center gap-3">
                    <div class="logo-box p-1.5 bg-white rounded-xl border border-stone-200 shadow-xs flex items-center justify-center">
                        <img src="<?= base_url('img/logo-kowpi.png') ?>" alt="KOWPI" class="h-8 w-auto logo-light-version block dark:hidden">
                        <img src="<?= base_url('img/logo-kowpi-white.png') ?>" alt="KOWPI" class="h-8 w-auto logo-dark-version hidden dark:block">
                    </div>
                    <div>
                        <span id="modalCode" class="font-mono text-xs font-bold text-gold-dark"></span>
                        <h3 id="modalTitle" class="font-serif-kowpi font-bold text-base text-kowpi-950 line-clamp-1"></h3>
                    </div>
                </div>
                <button type="button" onclick="closeMeetingModal()" class="text-stone-400 hover:text-stone-700 p-1 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div id="modalBody" class="p-6 overflow-y-auto space-y-5 text-xs text-stone-800">
                <!-- Dynamically loaded -->
            </div>

            <!-- Modal Footer -->
            <div class="p-4 border-t border-champagne-200 bg-champagne-50/60 flex items-center justify-between">
                <button type="button" onclick="closeMeetingModal()" class="px-4 py-2 border border-stone-300 rounded-xl text-stone-600 font-semibold text-xs hover:bg-stone-100">
                    Tutup
                </button>
                <a id="modalPrintBtn" href="#" target="_blank" class="px-5 py-2 bg-kowpi-700 hover:bg-kowpi-800 text-white rounded-xl font-bold text-xs shadow flex items-center gap-1.5">
                    <i data-lucide="printer" class="w-4 h-4 text-gold-light"></i>
                    <span>Cetak Dokumen Resmi (PDF)</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Modal: Lightbox Foto Dokumentasi Fullscreen -->
    <div id="photoLightboxModal" class="fixed inset-0 z-60 bg-black/90 backdrop-blur-md hidden items-center justify-center p-4">
        <div class="relative max-w-4xl w-full max-h-[92vh] flex flex-col items-center">
            <!-- Close Button -->
            <button type="button" onclick="closePhotoModal()" class="absolute -top-12 right-0 text-white/80 hover:text-white p-2 rounded-full hover:bg-white/10 transition z-20" title="Tutup (Esc)">
                <i data-lucide="x" class="w-7 h-7"></i>
            </button>
            
            <!-- Photo Container -->
            <div class="w-full flex items-center justify-center overflow-hidden rounded-2xl bg-black/40 border border-white/10 shadow-2xl relative">
                <img id="lightboxImg" src="" alt="Dokumentasi Foto Rapat" class="max-h-[72vh] w-auto max-w-full object-contain rounded-xl">
            </div>
            
            <!-- Caption Bar -->
            <div class="mt-3 w-full bg-stone-900/90 backdrop-blur-md border border-white/10 rounded-xl px-5 py-3 text-center text-white">
                <div class="flex items-center justify-center gap-2 mb-1">
                    <i data-lucide="camera" class="w-4 h-4 text-gold"></i>
                    <span class="text-[11px] uppercase tracking-wider text-gold font-bold">Dokumentasi Foto Rapat Resmi KOWPI</span>
                </div>
                <p id="lightboxCaption" class="text-xs sm:text-sm font-medium text-stone-200"></p>
            </div>
        </div>
    </div>

    <!-- Light & Dark Footer -->
    <footer class="bg-white border-t border-champagne-200 py-6 px-4 text-center text-xs text-stone-500 mt-12 transition-colors duration-300">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="logo-box p-1.5 bg-white rounded-xl border border-stone-200 shadow-xs inline-flex items-center justify-center">
                    <img src="<?= base_url('img/logo-kowpi.png') ?>" alt="KOWPI" class="h-7 w-auto logo-light-version block dark:hidden">
                    <img src="<?= base_url('img/logo-kowpi-white.png') ?>" alt="KOWPI" class="h-7 w-auto logo-dark-version hidden dark:block">
                </div>
                <span class="font-serif-kowpi font-bold text-kowpi-900"><?= esc($settings['org_name'] ?? 'KOWPI') ?></span>
            </div>
            <div>
                &copy; <?= date('Y') ?> Komunitas Waris Planning Indonesia. Sistem Notula & Daftar Hadir Resmi.
            </div>
        </div>
    </footer>

    <!-- Scripts for Signature Canvas & AJAX Submit -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();

            const canvas = document.getElementById('signatureCanvas');
            const placeholder = document.getElementById('sigPlaceholder');
            const container = document.getElementById('signatureContainer');
            const clearBtn = document.getElementById('clearSigBtn');
            const form = document.getElementById('publicAttendanceForm');
            const submitBtn = document.getElementById('submitBtn');

            if (canvas) {
                function resizeCanvas() {
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                    const rect = canvas.getBoundingClientRect();
                    canvas.width = rect.width * ratio;
                    canvas.height = rect.height * ratio;
                    const ctx = canvas.getContext('2d');
                    ctx.scale(ratio, ratio);
                }

                window.addEventListener('resize', resizeCanvas);
                resizeCanvas();

                const isDark = document.documentElement.classList.contains('dark');
                const signaturePad = new SignaturePad(canvas, {
                    backgroundColor: 'rgba(255, 255, 255, 0)',
                    penColor: isDark ? '#f5d77f' : '#2b1f1a',
                    minWidth: 1.5,
                    maxWidth: 3.5,
                });
                window.sigPadInstance = signaturePad;

                // Sync theme buttons on startup
                const currentTheme = localStorage.getItem('kowpi_theme') || (isDark ? 'dark' : 'light');
                applyTheme(currentTheme);

                signaturePad.addEventListener('beginStroke', () => {
                    if (placeholder) placeholder.style.display = 'none';
                    if (container) container.classList.add('active');
                });

                if (clearBtn) {
                    clearBtn.addEventListener('click', () => {
                        signaturePad.clear();
                        if (placeholder) placeholder.style.display = 'flex';
                        if (container) container.classList.remove('active');
                    });
                }

                if (form) {
                    form.addEventListener('submit', async (e) => {
                        e.preventDefault();

                        const nameInput = document.getElementById('participantName');
                        if (!nameInput.value.trim()) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Nama Wajib Diisi',
                                text: 'Mohon masukkan nama lengkap Anda.',
                                confirmButtonColor: '#8c4835',
                            });
                            return;
                        }

                        if (signaturePad.isEmpty()) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Tanda Tangan Belum Ada',
                                text: 'Silakan bubuhkan tanda tangan pada kotak yang disediakan.',
                                confirmButtonColor: '#8c4835',
                            });
                            return;
                        }

                        document.getElementById('signatureData').value = signaturePad.toDataURL('image/png');

                        submitBtn.disabled = true;
                        submitBtn.innerHTML = `
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Menyimpan Presensi...</span>
                        `;

                        try {
                            const formData = new FormData(form);
                            const response = await fetch('<?= base_url('presensi/submit') ?>', {
                                method: 'POST',
                                body: formData,
                            });
                            const result = await response.json();

                            if (result.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Presensi Berhasil!',
                                    text: result.message,
                                    confirmButtonColor: '#8c4835',
                                    confirmButtonText: 'Selesai',
                                    timer: 3000,
                                });

                                form.reset();
                                signaturePad.clear();
                                if (placeholder) placeholder.style.display = 'flex';
                                if (container) container.classList.remove('active');

                                const counter = document.getElementById('counterPresent');
                                if (counter && result.total_present) {
                                    counter.innerText = result.total_present;
                                }

                                const list = document.getElementById('attendeeList');
                                const empty = document.getElementById('emptyAttendee');
                                if (empty) empty.remove();

                                if (list && result.data) {
                                    const d = result.data;
                                    const statusLabel = d.attendance_status.replace('_', ' ').toUpperCase();
                                    const newCard = `
                                        <div class="p-3 rounded-2xl bg-champagne-50/80 border border-champagne-200/80 flex items-center justify-between gap-3 text-xs animate-fade-in">
                                            <div class="flex items-center gap-3 min-w-0">
                                                <div class="w-9 h-9 rounded-xl bg-kowpi-100 text-kowpi-800 font-serif-kowpi font-bold text-sm flex items-center justify-center shrink-0">
                                                    ${d.participant_name.charAt(0).toUpperCase()}
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="font-bold text-stone-900 truncate">${d.participant_name}</div>
                                                    <div class="text-[10px] text-stone-500 truncate">${d.institution}</div>
                                                </div>
                                            </div>
                                            <div class="text-right shrink-0">
                                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-900">
                                                    ${statusLabel}
                                                </span>
                                                <div class="text-[10px] text-stone-400 mt-0.5">Baru Saja</div>
                                            </div>
                                        </div>
                                    `;
                                    list.insertAdjacentHTML('afterbegin', newCard);
                                }
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: result.message || 'Terjadi kesalahan.',
                                    confirmButtonColor: '#8c4835',
                                });
                            }
                        } catch (err) {
                            console.error(err);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Terhubung',
                                text: 'Periksa koneksi jaringan Anda.',
                                confirmButtonColor: '#8c4835',
                            });
                        } finally {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = `
                                <i data-lucide="check-circle" class="w-4 h-4 text-gold-light group-hover:scale-110 transition-transform"></i>
                                <span>Konfirmasi Kehadiran & Simpan Tanda Tangan</span>
                            `;
                            if (typeof lucide !== 'undefined') lucide.createIcons();
                        }
                    });
                }
            }
        });

        const BASE_URL = '<?= rtrim(base_url(), '/') ?>';

        function applyTheme(theme) {
            const html = document.documentElement;
            const btnLight = document.getElementById('btnThemeLight');
            const btnDark = document.getElementById('btnThemeDark');

            if (theme === 'dark') {
                html.classList.add('dark');
                html.classList.remove('light');
                try { localStorage.setItem('kowpi_theme', 'dark'); } catch (e) {}

                if (btnDark) {
                    btnDark.className = "flex items-center gap-1.5 px-2 sm:px-2.5 py-1 rounded-lg text-xs font-extrabold bg-[#381f12] text-gold-light border border-gold/40 shadow-xs transition-all";
                }
                if (btnLight) {
                    btnLight.className = "flex items-center gap-1.5 px-2 sm:px-2.5 py-1 rounded-lg text-xs font-medium text-stone-400 hover:text-stone-200 transition-all";
                }

                if (window.sigPadInstance) {
                    window.sigPadInstance.penColor = '#f5d77f';
                }
            } else {
                html.classList.remove('dark');
                html.classList.add('light');
                try { localStorage.setItem('kowpi_theme', 'light'); } catch (e) {}

                if (btnLight) {
                    btnLight.className = "flex items-center gap-1.5 px-2 sm:px-2.5 py-1 rounded-lg text-xs font-bold bg-white text-kowpi-900 border border-stone-200 shadow-xs transition-all";
                }
                if (btnDark) {
                    btnDark.className = "flex items-center gap-1.5 px-2 sm:px-2.5 py-1 rounded-lg text-xs font-medium text-stone-500 hover:text-kowpi-800 transition-all";
                }

                if (window.sigPadInstance) {
                    window.sigPadInstance.penColor = '#2b1f1a';
                }
            }
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }

        function setTheme(theme) {
            applyTheme(theme);
        }

        function openPhotoModal(imgSrc, caption) {
            const modal = document.getElementById('photoLightboxModal');
            const img = document.getElementById('lightboxImg');
            const cap = document.getElementById('lightboxCaption');
            if (!modal || !img) return;

            img.src = imgSrc;
            cap.innerText = caption || 'Foto Dokumentasi Rapat KOWPI';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }

        function closePhotoModal() {
            const modal = document.getElementById('photoLightboxModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        // Close modal when backdrop clicked
        document.addEventListener('click', (e) => {
            const photoModal = document.getElementById('photoLightboxModal');
            if (photoModal && e.target === photoModal) {
                closePhotoModal();
            }
            const meetingModal = document.getElementById('meetingModal');
            if (meetingModal && e.target === meetingModal) {
                closeMeetingModal();
            }
        });

        // Close modal on Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closePhotoModal();
                closeMeetingModal();
            }
        });

        async function openMeetingModal(id) {
            const modal = document.getElementById('meetingModal');
            const body = document.getElementById('modalBody');
            body.innerHTML = `
                <div class="py-12 text-center text-stone-400">
                    <svg class="animate-spin h-6 w-6 text-kowpi-700 mx-auto mb-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Memuat berkas notula...</span>
                </div>
            `;
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            try {
                const res = await fetch(`<?= base_url('notula/public-view/') ?>/${id}`);
                const data = await res.json();

                if (data.success) {
                    const m = data.meeting;
                    const min = data.minutes || {};
                    document.getElementById('modalCode').innerText = m.meeting_code;
                    document.getElementById('modalTitle').innerText = m.title;
                    document.getElementById('modalPrintBtn').href = `<?= base_url('export/print-dokumen/') ?>/${id}`;

                    let actionItemsHtml = '';
                    if (data.actionItems && data.actionItems.length > 0) {
                        actionItemsHtml = `
                            <div class="space-y-1.5 pt-2">
                                <strong class="font-bold text-stone-800 uppercase text-[11px] block">Rencana Tindak Lanjut:</strong>
                                <ul class="list-disc pl-4 space-y-1">
                                    ${data.actionItems.map(item => `<li><strong>${item.task}</strong> (PIC: ${item.pic} | Target: ${item.deadline || '-'} | Status: ${item.status})</li>`).join('')}
                                </ul>
                            </div>
                        `;
                    }

                    let photosHtml = '';
                    if (data.photos && data.photos.length > 0) {
                        photosHtml = `
                            <div class="space-y-2 pt-3 border-t border-champagne-200">
                                <div class="flex items-center justify-between">
                                    <strong class="font-bold text-kowpi-950 uppercase text-[11px] flex items-center gap-1.5">
                                        <i data-lucide="camera" class="w-4 h-4 text-gold-dark"></i>
                                        <span>Dokumentasi Foto Rapat (${data.photos.length} Foto):</span>
                                    </strong>
                                    <span class="text-[10px] text-stone-400">Klik foto untuk melihat ukuran penuh</span>
                                </div>
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    ${data.photos.map((p, idx) => `
                                        <div class="group/pcard rounded-2xl border border-champagne-200 overflow-hidden bg-stone-50 shadow-xs cursor-pointer hover:border-gold transition"
                                             data-url="${BASE_URL}/${p.file_path}"
                                             data-caption="${(p.caption || 'Foto Dokumentasi ' + (idx+1)).replace(/"/g, '&quot;')}"
                                             onclick="openPhotoModal(this.dataset.url, this.dataset.caption)">
                                            <div class="h-28 sm:h-32 w-full overflow-hidden relative">
                                                <img src="${BASE_URL}/${p.file_path}" alt="Dokumentasi" class="w-full h-full object-cover group-hover/pcard:scale-105 transition duration-300">
                                                <div class="absolute inset-0 bg-black/0 group-hover/pcard:bg-black/30 transition flex items-center justify-center">
                                                    <div class="w-8 h-8 rounded-full bg-white/90 text-stone-800 flex items-center justify-center opacity-0 group-hover/pcard:opacity-100 transition shadow">
                                                        <i data-lucide="maximize-2" class="w-3.5 h-3.5 text-gold-dark"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            ${p.caption ? `
                                                <div class="p-2 text-[10px] text-stone-600 line-clamp-2 leading-tight bg-white border-t border-champagne-100">
                                                    ${p.caption}
                                                </div>
                                            ` : ''}
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        `;
                    }

                    body.innerHTML = `
                        <div class="p-4 bg-champagne-50 rounded-2xl border border-champagne-200 text-xs grid grid-cols-2 gap-2">
                            <div><strong>Tanggal :</strong> ${m.meeting_date}</div>
                            <div><strong>Waktu :</strong> ${m.start_time.substring(0, 5)} - ${m.end_time.substring(0, 5)} WIB</div>
                            <div><strong>Lokasi :</strong> ${m.location}</div>
                            <div><strong>Pimpinan :</strong> ${m.leader_name}</div>
                        </div>

                        <div class="space-y-1">
                            <strong class="font-bold text-stone-800 uppercase text-[11px] block">Agenda Rapat:</strong>
                            <div class="whitespace-pre-line text-stone-700 bg-stone-50 p-3 rounded-xl border border-stone-200/80">${m.agenda}</div>
                        </div>

                        ${min.decisions ? `
                            <div class="space-y-1">
                                <strong class="font-bold text-kowpi-800 uppercase text-[11px] block">Keputusan & Kesepakatan Resmi:</strong>
                                <div class="whitespace-pre-line text-stone-900 bg-kowpi-50/70 p-3.5 rounded-xl border border-kowpi-200 font-medium">${min.decisions}</div>
                            </div>
                        ` : ''}

                        ${actionItemsHtml}

                        ${photosHtml}

                        <div class="pt-3 border-t border-champagne-200 flex items-center justify-between text-[11px] text-stone-500">
                            <span>Total Peserta Hadir (TTD): <strong>${data.attendances ? data.attendances.length : 0}</strong> Orang</span>
                            <span>Dokumentasi: <strong>${data.photos ? data.photos.length : 0}</strong> Foto</span>
                        </div>
                    `;
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                }
            } catch (err) {
                console.error(err);
                body.innerHTML = `<div class="p-6 text-center text-rose-600">Gagal memuat berkas rapat.</div>`;
            }
        }

        function closeMeetingModal() {
            const modal = document.getElementById('meetingModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</body>
</html>
