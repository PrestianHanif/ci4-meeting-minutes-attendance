<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
  <title><?= esc($title ?? 'Sistem Undangan & Absensi Digital — Promosi Doktor') ?></title>
  
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>">

  <!-- Google Fonts: Noto Serif (KOWPI Academic) & Plus Jakarta Sans (Modern UI) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            academic: {
              navy: '#0F2C59',
              dark: '#0A1E3D',
              deep: '#061325',
              gold: '#C5A059',
              goldlight: '#DFBF7A',
              ivory: '#FCFBF7',
              paper: '#F8F6F0',
            }
          },
          fontFamily: {
            serif: ['"Noto Serif"', 'serif'],
            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
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
      background-color: #F8FAFC;
      color: #1E293B;
    }
    .font-academic {
      font-family: 'Noto Serif', serif;
    }
    .gold-gradient {
      background: linear-gradient(135deg, #C5A059 0%, #E6CA85 50%, #C5A059 100%);
    }
    .navy-gradient {
      background: linear-gradient(135deg, #0F2C59 0%, #173B6E 100%);
    }
    .gold-border-glow {
      box-shadow: 0 0 15px rgba(197, 160, 89, 0.25);
    }
    /* Custom scrollbar */
    ::-webkit-scrollbar {
      width: 7px;
      height: 7px;
    }
    ::-webkit-scrollbar-track {
      background: #F1F5F9;
    }
    ::-webkit-scrollbar-thumb {
      background: #CBD5E1;
      border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #94A3B8;
    }
    /* Mobile nav hide scrollbar & smooth momentum */
    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }
    .no-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
    .touch-scroll {
      -webkit-overflow-scrolling: touch;
    }
    html {
      width: 100%;
      max-width: 100%;
      overflow-x: hidden;
      -webkit-text-size-adjust: 100%;
    }
    body {
      width: 100%;
      max-width: 100%;
      overflow-x: hidden;
      position: relative;
      overscroll-behavior-x: none;
    }
  </style>
</head>
<body class="min-h-screen flex flex-col bg-slate-50 antialiased selection:bg-academic-navy selection:text-white w-full max-w-full overflow-x-hidden">

  <!-- Top Academic Navy Bar with Dual Logos -->
  <header class="sticky top-0 z-40 bg-academic-navy text-white shadow-lg border-b-2 border-academic-gold w-full max-w-full">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 w-full">
      <div class="flex items-center justify-between h-14 sm:h-20 gap-1.5 sm:gap-4 w-full">
        
        <!-- Left: Dual Logos (UII & KOWPI) + Event Title -->
        <a href="<?= base_url() ?>" class="flex items-center space-x-2 sm:space-x-4 group min-w-0 flex-shrink-0">
          <div class="flex items-center bg-white px-1.5 py-1 sm:px-3 sm:py-1.5 rounded-lg sm:rounded-xl shadow-xs space-x-1 sm:space-x-2.5 border border-academic-gold/40 flex-shrink-0">
            <img src="<?= base_url('assets/img/logo-uii.png?v=' . time()) ?>" alt="UII" class="h-4 sm:h-8 w-auto max-w-[42px] sm:max-w-[105px] object-contain flex-shrink-0">
            <div class="h-3 sm:h-6 w-[1px] sm:w-[1.5px] bg-academic-gold flex-shrink-0"></div>
            <img src="<?= base_url('assets/img/logo-kowpi-coklat.png?v=' . time()) ?>" alt="KOWPI" class="h-3.5 sm:h-7 w-auto max-w-[48px] sm:max-w-[110px] object-contain flex-shrink-0">
          </div>
          <div class="hidden md:block">
            <div class="text-[10px] uppercase tracking-widest text-academic-gold font-semibold">
              Ujian Terbuka &bull; Promosi Doktor Hukum Islam
            </div>
            <div class="text-base font-bold font-academic tracking-wide text-white group-hover:text-academic-goldlight transition truncate">
              Muhammad Abu Rivai, S.H., M.H.
            </div>
            <div class="text-[11px] text-slate-300">
              FIAI Universitas Islam Indonesia &bull; KOWPI
            </div>
          </div>
        </a>

        <!-- Right: Real-time Clock, Export Action & TV Screen Shortcut -->
        <div class="flex items-center space-x-1 sm:space-x-2 flex-shrink-0">
          <!-- Real-time Clock Badge -->
          <div class="hidden lg:flex items-center space-x-2 px-3 py-1.5 rounded-lg bg-academic-dark/70 border border-white/10 text-xs text-slate-200" id="liveClockWrapper">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <span id="liveClock" class="font-mono font-medium tracking-wide">--:--:-- WIB</span>
          </div>

          <!-- Export Berita Acara & Hadir Dropdown -->
          <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <button @click="open = !open" type="button"
                    class="h-8 sm:h-9 px-2 sm:px-3 rounded-lg bg-academic-gold hover:bg-academic-goldlight text-academic-navy text-xs font-bold shadow-md transition flex items-center space-x-1 whitespace-nowrap flex-shrink-0">
              <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
              </svg>
              <span class="text-[11px] sm:text-xs font-bold">Export</span>
              <span class="hidden sm:inline text-xs font-bold">Hadir</span>
              <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" style="display: none;"
                 class="absolute right-0 mt-2 w-60 sm:w-64 max-w-[calc(100vw-20px)] rounded-2xl bg-white shadow-2xl border border-slate-200 py-2 z-50 text-slate-800">
              <div class="px-4 py-2 border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                Dokumen Resmi Sidang
              </div>
              <a href="<?= base_url('export/pdf-kehadiran?filter=present') ?>" target="_blank"
                 class="flex items-center space-x-3 px-4 py-2.5 hover:bg-slate-50 transition text-xs font-semibold text-slate-700 hover:text-academic-navy">
                <span class="w-7 h-7 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0 font-bold text-[10px]">PDF</span>
                <div>
                  <div class="font-bold">Buku Hadir Realisasi (PDF)</div>
                  <div class="text-[10px] text-slate-400 font-normal">Hanya yang hadir + TTD Digital</div>
                </div>
              </a>
              <a href="<?= base_url('export/pdf-kehadiran?filter=all') ?>" target="_blank"
                 class="flex items-center space-x-3 px-4 py-2.5 hover:bg-slate-50 transition text-xs font-semibold text-slate-700 hover:text-academic-navy">
                <span class="w-7 h-7 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center flex-shrink-0 font-bold text-[10px]">PDF</span>
                <div>
                  <div class="font-bold">Presensi Seluruh Tamu (PDF)</div>
                  <div class="text-[10px] text-slate-400 font-normal">Semua 100 tamu + walk-in</div>
                </div>
              </a>
              <div class="my-1 border-t border-slate-100"></div>
              <a href="<?= base_url('export/excel-kehadiran?filter=present') ?>"
                 class="flex items-center space-x-3 px-4 py-2.5 hover:bg-slate-50 transition text-xs font-semibold text-slate-700 hover:text-academic-navy">
                <span class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 font-bold text-[10px]">XLS</span>
                <div>
                  <div class="font-bold">Rekapitulasi Hadir (Excel)</div>
                  <div class="text-[10px] text-slate-400 font-normal">Format spreadsheet rapi</div>
                </div>
              </a>
              <a href="<?= base_url('export/excel-kehadiran?filter=all') ?>"
                 class="flex items-center space-x-3 px-4 py-2.5 hover:bg-slate-50 transition text-xs font-semibold text-slate-700 hover:text-academic-navy">
                <span class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 font-bold text-[10px]">XLS</span>
                <div>
                  <div class="font-bold">Data Seluruh Tamu (Excel)</div>
                  <div class="text-[10px] text-slate-400 font-normal">Kontak WA &amp; ucapan lengkap</div>
                </div>
              </a>
            </div>
          </div>

          <!-- Live TV Board Button -->
          <a href="<?= base_url('daftar-hadir') ?>" target="_blank"
             class="w-8 h-8 sm:w-auto sm:h-9 sm:px-3 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold shadow-md transition flex items-center justify-center space-x-1 flex-shrink-0"
             title="Buka Tampilan Layar TV / Proyektor Depan Ruang Sidang">
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            <span class="hidden sm:inline">Live TV</span>
          </a>

          <!-- Logout Button (Jika Login) -->
          <?php if (session()->get('is_admin_logged_in') || session()->get('isLoggedIn')): ?>
            <a href="<?= base_url('logout') ?>"
               onclick="return confirm('Apakah Anda yakin ingin keluar dari panel admin?')"
               class="w-8 h-8 sm:w-auto sm:h-9 sm:px-3 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold shadow-md transition flex items-center justify-center space-x-1 flex-shrink-0"
               title="Keluar dari Panel Admin">
              <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
              </svg>
              <span class="hidden md:inline">Keluar</span>
            </a>
          <?php endif; ?>
        </div>

      </div>
    </div>

    <!-- Navigation Menu Bar with smooth touch scrolling -->
    <nav class="bg-academic-dark/95 border-t border-white/10 overflow-x-auto no-scrollbar touch-scroll w-full max-w-full" style="-webkit-overflow-scrolling: touch;">
      <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 w-max">
        <div class="flex items-center space-x-1 py-1 sm:py-1.5">
          
          <a href="<?= base_url() ?>" class="px-2.5 sm:px-3.5 py-1.5 sm:py-2 rounded-md text-[11px] sm:text-xs font-semibold transition flex items-center space-x-1.5 <?= ($activeNav ?? '') === 'dashboard' ? 'bg-academic-gold text-academic-navy shadow' : 'text-slate-300 hover:text-white hover:bg-white/10' ?>">
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span>Dashboard</span>
          </a>

          <a href="<?= base_url('tamu') ?>" class="px-2.5 sm:px-3.5 py-1.5 sm:py-2 rounded-md text-[11px] sm:text-xs font-semibold transition flex items-center space-x-1.5 <?= ($activeNav ?? '') === 'guests' ? 'bg-academic-gold text-academic-navy shadow' : 'text-slate-300 hover:text-white hover:bg-white/10' ?>">
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <span><span class="hidden sm:inline">Kelola </span>100 Tamu</span>
          </a>

          <a href="<?= base_url('absensi') ?>" class="px-2.5 sm:px-3.5 py-1.5 sm:py-2 rounded-md text-[11px] sm:text-xs font-semibold transition flex items-center space-x-1.5 <?= ($activeNav ?? '') === 'attendance' ? 'bg-academic-gold text-academic-navy shadow' : 'text-slate-300 hover:text-white hover:bg-white/10' ?>">
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            <span>Meja Absensi<span class="hidden sm:inline"> (Pen Tablet)</span></span>
          </a>

          <a href="<?= base_url('tamu-baru') ?>" class="px-2.5 sm:px-3.5 py-1.5 sm:py-2 rounded-md text-[11px] sm:text-xs font-semibold transition flex items-center space-x-1.5 <?= ($activeNav ?? '') === 'walk_in' ? 'bg-academic-gold text-academic-navy shadow' : 'text-slate-300 hover:text-white hover:bg-white/10' ?>">
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            <span>Tamu Baru<span class="hidden sm:inline"> (Walk-in)</span></span>
          </a>

          <a href="<?= base_url('undangan/massal') ?>" class="px-2.5 sm:px-3.5 py-1.5 sm:py-2 rounded-md text-[11px] sm:text-xs font-semibold transition flex items-center space-x-1.5 <?= ($activeNav ?? '') === 'pdf_manager' ? 'bg-academic-gold text-academic-navy shadow' : 'text-slate-300 hover:text-white hover:bg-white/10' ?>">
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            <span><span class="hidden sm:inline">Bulk </span>PDF &amp; ZIP</span>
          </a>

          <a href="<?= base_url('pengaturan') ?>" class="px-2.5 sm:px-3.5 py-1.5 sm:py-2 rounded-md text-[11px] sm:text-xs font-semibold transition flex items-center space-x-1.5 <?= ($activeNav ?? '') === 'settings' ? 'bg-academic-gold text-academic-navy shadow' : 'text-slate-300 hover:text-white hover:bg-white/10' ?>">
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span>Pengaturan<span class="hidden sm:inline"> Acara</span></span>
          </a>

        </div>
      </div>
    </nav>
  </header>

  <!-- Flash Messages -->
  <?php if (session()->getFlashdata('success')): ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
      <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between">
        <div class="flex items-center space-x-3 text-emerald-800 text-sm font-medium">
          <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          <span><?= session()->getFlashdata('success') ?></span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
      </div>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
      <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between">
        <div class="flex items-center space-x-3 text-rose-800 text-sm font-medium">
          <svg class="w-5 h-5 text-rose-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
          <span><?= session()->getFlashdata('error') ?></span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">&times;</button>
      </div>
    </div>
  <?php endif; ?>

  <!-- Main Content Container -->
  <main class="flex-grow py-4 sm:py-6 w-full max-w-full overflow-x-hidden">
    <div class="max-w-7xl mx-auto px-2.5 sm:px-6 lg:px-8 w-full max-w-full">
      <?= $this->renderSection('content') ?>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-white border-t border-slate-200 py-6 text-xs text-slate-500 w-full max-w-full overflow-x-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-3 text-center md:text-left">
      <div>
        <span class="font-bold text-academic-navy">Sistem Generator Undangan Massal &amp; Absensi Digital</span> &bull; 
        Ujian Terbuka Promosi Doktor Sdr. <strong>Muhammad Abu Rivai, S.H., M.H.</strong> (NIM: 21933020)
      </div>
      <div class="text-slate-400">
        Program Doktor Hukum Islam FIAI UII &bull; Komunitas Penggerak Waris Islam (KOWPI)
      </div>
    </div>
  </footer>

  <!-- Real-time Clock JS -->
  <script>
    function updateClock() {
      const now = new Date();
      const h = String(now.getHours()).padStart(2, '0');
      const m = String(now.getMinutes()).padStart(2, '0');
      const s = String(now.getSeconds()).padStart(2, '0');
      const el = document.getElementById('liveClock');
      if (el) {
        el.innerText = `${h}:${m}:${s} WIB`;
      }
    }
    setInterval(updateClock, 1000);
    updateClock();
  </script>

  <?= $this->renderSection('scripts') ?>
</body>
</html>
