<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Kehadiran: <?= esc($meeting['title']) ?> - KOWPI</title>
    
    <link rel="icon" type="image/png" href="<?= base_url('img/favicon-kowpi.png') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        kowpi: {
                            50: '#fcf8f7',
                            100: '#f5ebe8',
                            500: '#8c4835',
                            700: '#582a1d',
                            800: '#3e1b12',
                            900: '#2a110a',
                            950: '#150805',
                        },
                        gold: {
                            light: '#f5d77f',
                            DEFAULT: '#d4a847',
                            dark: '#aa812c',
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
</head>
<body class="min-h-screen bg-gradient-to-br from-kowpi-950 via-kowpi-900 to-kowpi-950 text-white flex flex-col font-sans selection:bg-gold selection:text-kowpi-950 relative overflow-hidden">

    <!-- Subtle Lighting Effects -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-kowpi-700/25 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-gold/15 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Header Live Screen -->
    <header class="p-6 border-b border-kowpi-800/80 bg-kowpi-950/60 backdrop-blur-md sticky top-0 z-30 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="p-2.5 bg-gradient-to-br from-kowpi-800 to-kowpi-900 rounded-2xl border border-gold/40 shadow-lg">
                <img src="<?= base_url('img/logo-kowpi.png') ?>" alt="KOWPI" class="h-10 md:h-12 w-auto">
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                    <span class="text-[11px] font-bold uppercase tracking-widest text-gold-light">
                        LIVE BOARD PRESENSI RAPAT
                    </span>
                    <span class="text-stone-500 font-mono text-xs">| <?= esc($meeting['meeting_code']) ?></span>
                </div>
                <h1 class="font-serif font-bold text-lg md:text-2xl text-white tracking-wide mt-0.5">
                    <?= esc($meeting['title']) ?>
                </h1>
            </div>
        </div>

        <div class="flex items-center gap-6">
            <!-- Digital Clock -->
            <div class="text-right hidden sm:block">
                <div id="liveClock" class="font-mono text-2xl md:text-3xl font-bold text-gold-light tracking-wider">
                    00:00:00
                </div>
                <div class="text-[11px] text-stone-400 uppercase tracking-widest">
                    Waktu Indonesia Barat (WIB)
                </div>
            </div>

            <button onclick="toggleFullScreen()" class="p-2.5 rounded-xl bg-kowpi-800 hover:bg-kowpi-700 text-stone-300 hover:text-white border border-kowpi-700 transition-colors" title="Toggle Layar Penuh">
                <i data-lucide="maximize-2" class="w-5 h-5"></i>
            </button>
        </div>
    </header>

    <!-- Top Statistics Strip -->
    <div class="px-6 py-4 grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-7xl mx-auto w-full">
        <div class="bg-kowpi-900/70 border border-kowpi-700/60 rounded-2xl p-4 flex items-center justify-between">
            <div>
                <span class="text-[11px] text-stone-400 font-semibold uppercase tracking-wider">Total Hadir</span>
                <div id="statTotalHadir" class="text-2xl md:text-3xl font-extrabold text-gold-light">0</div>
            </div>
            <div class="p-2.5 rounded-xl bg-gold/15 text-gold border border-gold/30">
                <i data-lucide="user-check" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-kowpi-900/70 border border-kowpi-700/60 rounded-2xl p-4 flex items-center justify-between">
            <div>
                <span class="text-[11px] text-stone-400 font-semibold uppercase tracking-wider">Hadir Offline</span>
                <div id="statTotalOffline" class="text-2xl md:text-3xl font-extrabold text-white">0</div>
            </div>
            <div class="p-2.5 rounded-xl bg-amber-500/15 text-amber-400 border border-amber-500/30">
                <i data-lucide="building" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-kowpi-900/70 border border-kowpi-700/60 rounded-2xl p-4 flex items-center justify-between">
            <div>
                <span class="text-[11px] text-stone-400 font-semibold uppercase tracking-wider">Hadir Online</span>
                <div id="statTotalOnline" class="text-2xl md:text-3xl font-extrabold text-emerald-400">0</div>
            </div>
            <div class="p-2.5 rounded-xl bg-emerald-500/15 text-emerald-400 border border-emerald-500/30">
                <i data-lucide="video" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-kowpi-900/70 border border-kowpi-700/60 rounded-2xl p-4 flex items-center justify-between">
            <div>
                <span class="text-[11px] text-stone-400 font-semibold uppercase tracking-wider">Izin / Sakit</span>
                <div id="statTotalIzin" class="text-2xl md:text-3xl font-extrabold text-stone-300">0</div>
            </div>
            <div class="p-2.5 rounded-xl bg-stone-500/15 text-stone-300 border border-stone-500/30">
                <i data-lucide="calendar-x" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Main Grid of Present Attendees -->
    <main class="flex-1 p-6 max-w-7xl mx-auto w-full overflow-y-auto">
        <div id="attendeeGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Dynamically populated via polling -->
        </div>
    </main>

    <!-- Footer -->
    <footer class="p-4 border-t border-kowpi-800/80 bg-kowpi-950/80 text-center text-xs text-stone-400 flex items-center justify-between px-6">
        <div>
            <?= esc($settings['org_name'] ?? 'Komunitas Waris Planning Indonesia') ?> &bull; kowpi.id
        </div>
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>Sinkronisasi Otomatis Setiap 4 Detik</span>
        </div>
    </footer>

    <script>
        function updateClock() {
            const now = new Date();
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            const s = String(now.getSeconds()).padStart(2, '0');
            const el = document.getElementById('liveClock');
            if (el) el.innerText = `${h}:${m}:${s}`;
        }
        setInterval(updateClock, 1000);
        updateClock();

        function toggleFullScreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }

        async function fetchLiveAttendance() {
            try {
                const res = await fetch('<?= base_url('presensi/api-live/' . $meeting['meeting_code']) ?>');
                const data = await res.json();

                if (data.success) {
                    document.getElementById('statTotalHadir').innerText = data.total_hadir;
                    document.getElementById('statTotalOffline').innerText = data.total_offline;
                    document.getElementById('statTotalOnline').innerText = data.total_online;
                    document.getElementById('statTotalIzin').innerText = data.total_izin;

                    const grid = document.getElementById('attendeeGrid');
                    if (data.attendances.length === 0) {
                        grid.innerHTML = `
                            <div class="col-span-full py-20 text-center text-stone-500">
                                <i data-lucide="users" class="w-12 h-12 mx-auto mb-3 opacity-40"></i>
                                <p class="text-sm font-semibold">Menunggu peserta melakukan presensi...</p>
                            </div>
                        `;
                    } else {
                        grid.innerHTML = data.attendances.map(a => {
                            const initial = a.participant_name.charAt(0).toUpperCase();
                            const statusLabel = a.attendance_status.replace('_', ' ').toUpperCase();
                            const isOffline = a.attendance_status === 'hadir_offline';
                            const badgeColor = isOffline ? 'bg-amber-900/60 text-amber-200 border-amber-600/40' : (a.attendance_status === 'hadir_online' ? 'bg-emerald-900/60 text-emerald-200 border-emerald-600/40' : 'bg-stone-800 text-stone-300 border-stone-600/40');
                            const timeStr = a.check_in_time ? a.check_in_time.substring(11, 16) : '';

                            return `
                                <div class="bg-gradient-to-b from-kowpi-900/90 to-kowpi-950 border border-kowpi-700/60 rounded-2xl p-4 flex items-center justify-between gap-3 shadow-lg">
                                    <div class="flex items-center gap-3.5 min-w-0">
                                        <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-kowpi-700 to-kowpi-800 border border-gold/30 text-gold-light font-serif font-bold text-base flex items-center justify-center shrink-0 shadow">
                                            ${initial}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-bold text-white text-sm truncate">${a.participant_name}</div>
                                            <div class="text-xs text-stone-400 truncate mt-0.5">${a.institution || 'Pengurus KOWPI'}</div>
                                        </div>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <span class="inline-block px-2.5 py-0.5 rounded-lg text-[10px] font-bold border ${badgeColor}">
                                            ${statusLabel}
                                        </span>
                                        <div class="text-[11px] font-mono text-gold-light/80 mt-1">${timeStr} WIB</div>
                                    </div>
                                </div>
                            `;
                        }).join('');
                    }
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                }
            } catch (err) {
                console.error('Error fetching live attendance:', err);
            }
        }

        setInterval(fetchLiveAttendance, 4000);
        fetchLiveAttendance();

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    </script>
</body>
</html>
