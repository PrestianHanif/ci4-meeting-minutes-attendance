<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title><?= esc($title ?? 'Meja Presensi Rapat') ?> - <?= esc($settings['org_short'] ?? 'KOWPI') ?></title>
    
    <link rel="icon" type="image/png" href="<?= base_url('img/favicon-kowpi.png') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <!-- Signature Pad -->
    <script src="<?= base_url('assets/js/signature_pad.umd.min.js') ?>"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Tailwind CSS with KOWPI Palette -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        kowpi: {
                            50: '#fcf8f7',
                            100: '#f5ebe8',
                            200: '#edd8d2',
                            300: '#dfb7ac',
                            400: '#b86f5c',
                            500: '#8c4835',
                            600: '#723a2a',
                            700: '#582a1d',
                            800: '#3e1b12',
                            900: '#2a110a',
                            950: '#150805',
                        },
                        gold: {
                            light: '#f5d77f',
                            DEFAULT: '#d4a847',
                            dark: '#aa812c',
                            glow: 'rgba(212, 168, 71, 0.25)',
                        },
                        paper: {
                            50: '#faf8f5',
                            100: '#f8f6f3',
                            200: '#ede8e1',
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

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f6f3;
            color: #1f1411;
            touch-action: pan-y;
        }
        .font-serif-kowpi {
            font-family: 'Playfair Display', serif;
        }
        .signature-wrapper {
            position: relative;
            background-color: #ffffff;
            border: 2px dashed #dfb7ac;
            border-radius: 1rem;
            overflow: hidden;
            touch-action: none;
        }
        .signature-wrapper.active {
            border-color: #8c4835;
            background-color: #fffdfc;
        }
        .signature-pad-canvas {
            display: block;
            width: 100%;
            height: 180px;
            cursor: crosshair;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col selection:bg-gold selection:text-kowpi-950">

    <!-- Top Header Navigation -->
    <header class="bg-gradient-to-r from-kowpi-950 via-kowpi-900 to-kowpi-950 text-white border-b border-kowpi-800 shadow-xl px-4 md:px-8 py-3.5 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-1.5 bg-gradient-to-br from-kowpi-800 to-kowpi-900 rounded-xl border border-gold/40 shadow">
                    <img src="<?= base_url('img/logo-kowpi.png') ?>" alt="KOWPI" class="h-8 md:h-10 w-auto">
                </div>
                <div>
                    <h1 class="font-serif-kowpi font-bold text-sm md:text-base text-white tracking-wide leading-tight">
                        KOWPI &bull; MEJA PRESENSI DIGITAL
                    </h1>
                    <p class="text-[10px] md:text-xs text-gold-light truncate max-w-xs md:max-w-xl">
                        <?= esc($meeting['title']) ?>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="<?= base_url('presensi/live/' . $meeting['meeting_code']) ?>" target="_blank"
                   class="px-3 py-1.5 rounded-lg bg-kowpi-800 hover:bg-kowpi-700 text-stone-200 hover:text-white border border-kowpi-700 text-xs font-semibold flex items-center gap-1.5 transition-colors">
                    <i data-lucide="tv" class="w-3.5 h-3.5 text-gold-light"></i>
                    <span class="hidden sm:inline">Layar TV Board</span>
                </a>
                <a href="<?= base_url('dashboard') ?>"
                   class="px-3 py-1.5 rounded-lg bg-gold hover:bg-gold-light text-kowpi-950 font-bold text-xs flex items-center gap-1.5 shadow transition-colors">
                    <i data-lucide="shield" class="w-3.5 h-3.5"></i>
                    <span class="hidden sm:inline">Panel Admin</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Meeting Banner Info -->
    <div class="bg-gradient-to-b from-kowpi-900 to-kowpi-800 text-white px-4 md:px-8 py-6 border-b border-kowpi-700/60 shadow-inner">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-xs">
                    <span class="px-2.5 py-0.5 rounded-full bg-gold/20 text-gold-light border border-gold/40 font-mono font-bold">
                        <?= esc($meeting['meeting_code']) ?>
                    </span>
                    <span class="text-stone-300">&bull;</span>
                    <span class="text-stone-300 font-semibold"><?= esc($meeting['category']) ?></span>
                </div>
                <h2 class="font-serif-kowpi font-bold text-xl md:text-2xl text-white">
                    <?= esc($meeting['title']) ?>
                </h2>
                <div class="flex flex-wrap items-center gap-x-5 gap-y-1 text-xs text-stone-300 pt-1">
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="calendar" class="w-3.5 h-3.5 text-gold"></i>
                        <span><?= date('l, d F Y', strtotime($meeting['meeting_date'])) ?></span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="clock" class="w-3.5 h-3.5 text-gold"></i>
                        <span><?= substr($meeting['start_time'], 0, 5) ?> - <?= substr($meeting['end_time'], 0, 5) ?> WIB</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-gold"></i>
                        <span><?= esc($meeting['location']) ?></span>
                    </div>
                </div>
            </div>

            <!-- Attendance Live Counter Pill -->
            <div class="shrink-0 flex items-center gap-3 bg-kowpi-950/60 border border-kowpi-700/80 p-3 rounded-2xl">
                <div class="w-12 h-12 rounded-xl bg-gold/15 border border-gold/40 flex items-center justify-center text-gold-light">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="text-[11px] text-stone-400 font-semibold uppercase tracking-wider">Total Hadir</div>
                    <div class="text-2xl font-extrabold text-white">
                        <span id="counterPresent"><?= count($attendances) ?></span> <span class="text-xs font-normal text-stone-400">Peserta</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Form & Live Stream Container -->
    <main class="flex-1 max-w-7xl mx-auto w-full p-4 md:p-8">
        <?php if (empty($meeting['is_presence_open'])): ?>
            <!-- Alert If Presensi Locked -->
            <div class="bg-rose-50 border-2 border-rose-300 text-rose-900 rounded-3xl p-8 text-center max-w-2xl mx-auto my-8 shadow-sm">
                <div class="w-16 h-16 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="lock" class="w-8 h-8"></i>
                </div>
                <h3 class="font-serif-kowpi font-bold text-xl mb-2">Presensi Telah Resmi Ditutup</h3>
                <p class="text-xs text-rose-700 leading-relaxed mb-6">
                    Sesi presensi kehadiran untuk rapat ini telah dikunci oleh pimpinan rapat atau sekretariat. Untuk membuka kembali sesi presensi, silakan login ke panel administrator.
                </p>
                <a href="<?= base_url('login') ?>" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-rose-700 hover:bg-rose-800 text-white font-bold text-xs shadow transition-colors">
                    <i data-lucide="log-in" class="w-4 h-4"></i>
                    Masuk ke Panel Admin
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                <!-- Left Column: Attendance Form & Pen Tablet Pad (7 cols) -->
                <div class="lg:col-span-7 bg-white rounded-3xl border border-paper-200 shadow-md p-6 md:p-8 space-y-6">
                    <div class="border-b border-paper-200 pb-4">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-kowpi-600 block">
                            Formulir Kehadiran Resmi
                        </span>
                        <h3 class="font-serif-kowpi font-bold text-xl text-kowpi-950">
                            Silakan Isi Data & Tanda Tangan Anda
                        </h3>
                        <p class="text-xs text-stone-500 mt-1">
                            Tanda tangan digital Anda akan terlampir otomatis pada Berita Acara & Notula Rapat resmi KOWPI.
                        </p>
                    </div>

                    <form id="attendanceForm" class="space-y-5 text-xs">
                        <input type="hidden" name="meeting_id" value="<?= $meeting['id'] ?>">
                        <input type="hidden" name="signature_data" id="signatureData">

                        <!-- Nama Lengkap & Gelar -->
                        <div>
                            <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                                Nama Lengkap & Gelar <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="participant_name" id="participantName" required
                                       placeholder="Contoh: Dr. Drs. H. Asmuni, M.A."
                                       class="w-full pl-10 pr-4 py-3 border border-stone-300 rounded-xl text-sm focus:ring-2 focus:ring-kowpi-600 focus:outline-none">
                                <i data-lucide="user" class="w-4 h-4 text-stone-400 absolute left-3.5 top-3.5"></i>
                            </div>
                        </div>

                        <!-- Instansi / Jabatan & Status -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                                    Jabatan / Divisi / Instansi <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="institution" id="institution" required
                                           placeholder="Contoh: Pengurus KOWPI / Dewan Pembina"
                                           class="w-full pl-10 pr-4 py-3 border border-stone-300 rounded-xl text-xs focus:ring-2 focus:ring-kowpi-600 focus:outline-none">
                                    <i data-lucide="building-2" class="w-4 h-4 text-stone-400 absolute left-3.5 top-3.5"></i>
                                </div>
                            </div>

                            <div>
                                <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                                    Status Kehadiran <span class="text-rose-500">*</span>
                                </label>
                                <select name="attendance_status" id="attendanceStatus" class="w-full py-3 px-3 border border-stone-300 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-kowpi-600 focus:outline-none bg-white">
                                    <option value="hadir_offline" selected>&bull; Hadir Tatap Muka (Offline)</option>
                                    <option value="hadir_online">&bull; Hadir Daring (Online)</option>
                                    <option value="izin">&bull; Izin</option>
                                    <option value="sakit">&bull; Sakit</option>
                                </select>
                            </div>
                        </div>

                        <!-- No WhatsApp & Email -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                                    Nomor WhatsApp (Opsional)
                                </label>
                                <div class="relative">
                                    <input type="tel" name="phone" id="phone" placeholder="081234567890"
                                           class="w-full pl-10 pr-4 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-2 focus:ring-kowpi-600 focus:outline-none">
                                    <i data-lucide="phone" class="w-4 h-4 text-stone-400 absolute left-3.5 top-3"></i>
                                </div>
                            </div>

                            <div>
                                <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                                    Email (Opsional)
                                </label>
                                <div class="relative">
                                    <input type="email" name="email" id="email" placeholder="nama@email.com"
                                           class="w-full pl-10 pr-4 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-2 focus:ring-kowpi-600 focus:outline-none">
                                    <i data-lucide="mail" class="w-4 h-4 text-stone-400 absolute left-3.5 top-3"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Aspirasi / Catatan Singkat -->
                        <div>
                            <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                                Catatan / Aspirasi Singkat (Opsional)
                            </label>
                            <input type="text" name="notes" id="notes" placeholder="Catatan atau masukan singkat terkait agenda rapat..."
                                   class="w-full px-4 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-2 focus:ring-kowpi-600 focus:outline-none">
                        </div>

                        <!-- Digital Signature Canvas Section -->
                        <div class="pt-2">
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-stone-700 font-bold uppercase tracking-wider text-[11px] flex items-center gap-1.5">
                                    <i data-lucide="pen-tool" class="w-3.5 h-3.5 text-kowpi-700"></i>
                                    <span>Tanda Tangan Digital (Sentuh / Stylus)</span>
                                    <span class="text-rose-500">*</span>
                                </label>
                                <button type="button" id="clearSigBtn" class="text-rose-600 hover:text-rose-800 font-bold text-[11px] flex items-center gap-1 px-2.5 py-1 rounded-lg hover:bg-rose-50 transition-colors">
                                    <i data-lucide="rotate-ccw" class="w-3 h-3"></i>
                                    <span>Hapus / Ulangi TTD</span>
                                </button>
                            </div>

                            <div class="signature-wrapper" id="signatureContainer">
                                <canvas id="signatureCanvas" class="signature-pad-canvas"></canvas>
                                <div id="sigPlaceholder" class="absolute inset-0 flex items-center justify-center pointer-events-none text-stone-400 text-xs italic">
                                    <span>Goreskan tanda tangan Anda di area ini...</span>
                                </div>
                            </div>
                            <p class="text-[10px] text-stone-400 mt-1">
                                Anda dapat menggunakan jari pada layar sentuh ponsel/tablet atau stylus pen-tablet.
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" id="submitBtn"
                                    class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-kowpi-700 via-kowpi-800 to-kowpi-900 hover:from-kowpi-600 hover:to-kowpi-800 text-white font-extrabold text-sm shadow-xl hover:shadow-kowpi-800/40 border border-gold/40 transition-all flex items-center justify-center gap-2 group">
                                <i data-lucide="check-circle" class="w-5 h-5 text-gold-light group-hover:scale-110 transition-transform"></i>
                                <span>Simpan & Konfirmasi Kehadiran</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Right Column: Live Attendee Feed (5 cols) -->
                <div class="lg:col-span-5 space-y-4">
                    <div class="bg-white rounded-3xl border border-paper-200 shadow-md p-6">
                        <div class="flex items-center justify-between border-b border-paper-200 pb-3 mb-4">
                            <div>
                                <h3 class="font-serif-kowpi font-bold text-base text-kowpi-950">
                                    Daftar Hadir Terkini
                                </h3>
                                <p class="text-[11px] text-stone-400">Peserta yang telah melakukan presensi</p>
                            </div>
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse" title="Live Auto Sync"></span>
                        </div>

                        <div id="attendeeList" class="space-y-3 max-h-[560px] overflow-y-auto pr-1">
                            <?php if (empty($attendances)): ?>
                                <div id="emptyAttendee" class="py-12 text-center text-stone-400 text-xs">
                                    <i data-lucide="users" class="w-8 h-8 mx-auto mb-2 text-stone-300"></i>
                                    Belum ada peserta yang hadir. Jadilah yang pertama mengisi presensi!
                                </div>
                            <?php else: ?>
                                <?php foreach ($attendances as $att): ?>
                                    <div class="p-3 rounded-2xl bg-stone-50 border border-stone-200/80 flex items-center justify-between gap-3 text-xs">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="w-9 h-9 rounded-xl bg-kowpi-100 text-kowpi-800 font-serif-kowpi font-bold text-sm flex items-center justify-center shrink-0">
                                                <?= strtoupper(substr($att['participant_name'], 0, 1)) ?>
                                            </div>
                                            <div class="min-w-0">
                                                <div class="font-bold text-stone-800 truncate"><?= esc($att['participant_name']) ?></div>
                                                <div class="text-[10px] text-stone-400 truncate"><?= esc($att['institution']) ?></div>
                                            </div>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold <?= $att['attendance_status'] === 'hadir_offline' ? 'bg-amber-100 text-amber-900' : ($att['attendance_status'] === 'hadir_online' ? 'bg-emerald-100 text-emerald-900' : 'bg-stone-200 text-stone-700') ?>">
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

            </div>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-paper-200 py-4 px-6 text-center text-xs text-stone-400">
        <p>&copy; <?= date('Y') ?> <?= esc($settings['org_name'] ?? 'Komunitas Waris Planning Indonesia') ?> &bull; Sistem Notula & Presensi Digital Resmi</p>
    </footer>

    <!-- Scripts for Signature Canvas & AJAX Submit -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            const canvas = document.getElementById('signatureCanvas');
            const placeholder = document.getElementById('sigPlaceholder');
            const container = document.getElementById('signatureContainer');
            const clearBtn = document.getElementById('clearSigBtn');
            const form = document.getElementById('attendanceForm');
            const submitBtn = document.getElementById('submitBtn');

            if (!canvas) return;

            // Resize canvas properly for high-DPI screens
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

            // Initialize SignaturePad
            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgba(255, 255, 255, 0)',
                penColor: '#1f1411',
                velocityFilterWeight: 0.7,
                minWidth: 1.5,
                maxWidth: 3.5,
            });

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

            // Form Submit via AJAX
            if (form) {
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    const nameInput = document.getElementById('participantName');
                    if (!nameInput.value.trim()) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Nama Wajib Diisi',
                            text: 'Mohon masukkan nama lengkap Anda terlebih dahulu.',
                            confirmButtonColor: '#8c4835',
                        });
                        return;
                    }

                    if (signaturePad.isEmpty()) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tanda Tangan Belum Ada',
                            text: 'Silakan bubuhkan tanda tangan Anda pada area kotak tanda tangan.',
                            confirmButtonColor: '#8c4835',
                        });
                        return;
                    }

                    // Export signature as PNG data URL
                    const sigDataUrl = signaturePad.toDataURL('image/png');
                    document.getElementById('signatureData').value = sigDataUrl;

                    // Disable button during submit
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

                            // Reset form & canvas for next attendee
                            form.reset();
                            signaturePad.clear();
                            if (placeholder) placeholder.style.display = 'flex';
                            if (container) container.classList.remove('active');

                            // Update counter
                            const counter = document.getElementById('counterPresent');
                            if (counter && result.total_present) {
                                counter.innerText = result.total_present;
                            }

                            // Prepend attendee to list
                            const list = document.getElementById('attendeeList');
                            const empty = document.getElementById('emptyAttendee');
                            if (empty) empty.remove();

                            if (list && result.data) {
                                const d = result.data;
                                const statusLabel = d.attendance_status.replace('_', ' ').toUpperCase();
                                const newCard = `
                                    <div class="p-3 rounded-2xl bg-amber-50/70 border border-amber-300 flex items-center justify-between gap-3 text-xs animate-fade-in">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="w-9 h-9 rounded-xl bg-kowpi-700 text-white font-serif-kowpi font-bold text-sm flex items-center justify-center shrink-0">
                                                ${d.participant_name.charAt(0).toUpperCase()}
                                            </div>
                                            <div class="min-w-0">
                                                <div class="font-bold text-stone-900 truncate">${d.participant_name}</div>
                                                <div class="text-[10px] text-stone-500 truncate">${d.institution}</div>
                                            </div>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-amber-200 text-amber-900">
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
                                title: 'Gagal Menyimpan',
                                text: result.message || 'Terjadi kesalahan saat menyimpan presensi.',
                                confirmButtonColor: '#8c4835',
                            });
                        }
                    } catch (err) {
                        console.error(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Koneksi Terputus',
                            text: 'Tidak dapat menghubungi server. Periksa koneksi jaringan Anda.',
                            confirmButtonColor: '#8c4835',
                        });
                    } finally {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = `
                            <i data-lucide="check-circle" class="w-5 h-5 text-gold-light group-hover:scale-110 transition-transform"></i>
                            <span>Simpan & Konfirmasi Kehadiran</span>
                        `;
                        if (typeof lucide !== 'undefined') lucide.createIcons();
                    }
                });
            }
        });
    </script>
</body>
</html>

