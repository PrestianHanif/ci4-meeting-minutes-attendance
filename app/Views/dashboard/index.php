<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-8 max-w-7xl mx-auto">

    <!-- Top Hero Welcome Banner with Light Premium Palette -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-white via-champagne-50 to-kowpi-50 text-stone-900 p-6 md:p-8 border border-champagne-200 shadow-xs">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-gold/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-champagne-200/60 border border-champagne-300 text-xs text-kowpi-800 font-bold">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Portal Administrasi Rapat KOWPI
                </div>
                <h2 class="font-serif-kowpi font-bold text-2xl md:text-3xl text-kowpi-950">
                    Selamat Datang, <?= esc(session()->get('admin_name') ?? 'Admin') ?>!
                </h2>
                <p class="text-xs md:text-sm text-stone-600 max-w-2xl leading-relaxed">
                    Kelola agenda rapat, daftar hadir dengan tanda tangan digital, penyusunan notula keputusan, dan direktori arsip resmi <?= esc($settings['org_name'] ?? 'KOWPI') ?>.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="<?= base_url('/') ?>" target="_blank" class="px-4 py-2.5 rounded-xl bg-white hover:bg-stone-50 border border-champagne-300 text-kowpi-900 font-bold text-xs shadow-xs transition-all flex items-center gap-2">
                    <i data-lucide="globe" class="w-4 h-4 text-kowpi-600"></i>
                    Lihat Halaman Publik
                </a>
                <a href="<?= base_url('rapat/create') ?>" class="px-4 py-2.5 rounded-xl bg-kowpi-700 hover:bg-kowpi-800 text-white font-bold text-xs shadow-sm hover:shadow transition-all flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-4 h-4 text-gold-light"></i>
                    Jadwalkan Rapat Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards Overview (Light Luxury) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Total Rapat -->
        <div class="bg-white rounded-2xl p-5 border border-champagne-200 shadow-xs hover:shadow-sm transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-stone-400">Total Rapat</span>
                <div class="p-2.5 rounded-xl bg-kowpi-50 text-kowpi-700 border border-kowpi-100">
                    <i data-lucide="calendar" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-2xl font-extrabold text-kowpi-950"><?= $stats['total_meetings'] ?? 0 ?></span>
                <span class="text-xs text-stone-500">agenda</span>
            </div>
            <p class="text-[11px] text-stone-400 mt-2">
                <?= $stats['this_month_meetings'] ?? 0 ?> rapat di bulan ini
            </p>
        </div>

        <!-- Peserta Hadir (TTD Digital) -->
        <div class="bg-white rounded-2xl p-5 border border-champagne-200 shadow-xs hover:shadow-sm transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-stone-400">Presensi TTD Digital</span>
                <div class="p-2.5 rounded-xl bg-amber-50 text-amber-700 border border-amber-200">
                    <i data-lucide="signature" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-2xl font-extrabold text-amber-900"><?= $stats['total_attendees'] ?? 0 ?></span>
                <span class="text-xs text-stone-500">peserta</span>
            </div>
            <p class="text-[11px] text-stone-400 mt-2">
                Tercatat dengan tanda tangan asli
            </p>
        </div>

        <!-- Rapat Aktif / Berjalan -->
        <div class="bg-white rounded-2xl p-5 border border-champagne-200 shadow-xs hover:shadow-sm transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-stone-400">Rapat Aktif / Draft</span>
                <div class="p-2.5 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-2xl font-extrabold text-emerald-800"><?= $stats['active_meetings'] ?? 0 ?></span>
                <span class="text-xs text-stone-500">sesi</span>
            </div>
            <p class="text-[11px] text-stone-400 mt-2">
                Presensi terbuka & notula aktif
            </p>
        </div>

        <!-- Berkas Diarsipkan -->
        <div class="bg-white rounded-2xl p-5 border border-champagne-200 shadow-xs hover:shadow-sm transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider text-stone-400">Direktori Arsip</span>
                <div class="p-2.5 rounded-xl bg-purple-50 text-purple-700 border border-purple-200">
                    <i data-lucide="archive" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-2xl font-extrabold text-purple-900"><?= $stats['archived_meetings'] ?? 0 ?></span>
                <span class="text-xs text-stone-500">dokumen resmi</span>
            </div>
            <p class="text-[11px] text-stone-400 mt-2">
                Tersimpan permanen di arsip
            </p>
        </div>
    </div>

    <!-- Spotlight: Active / Ongoing Meeting Focus Card -->
    <?php if ($activeMeeting): ?>
        <div class="bg-white rounded-3xl border border-champagne-200 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-kowpi-800 to-kowpi-700 p-4 md:px-6 text-white flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <span class="px-2.5 py-1 rounded-lg bg-emerald-500/20 text-emerald-200 border border-emerald-400/40 text-[11px] font-bold uppercase tracking-wider flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Rapat Sedang Berjalan
                    </span>
                    <span class="text-xs font-mono text-gold-light font-bold"><?= esc($activeMeeting['meeting_code']) ?></span>
                </div>
                <div class="text-xs text-stone-200">
                    Kategori: <strong class="text-white"><?= esc($activeMeeting['category']) ?></strong>
                </div>
            </div>

            <div class="p-6 md:p-8 space-y-6">
                <div>
                    <h3 class="font-serif-kowpi font-bold text-xl md:text-2xl text-kowpi-950 mb-2">
                        <?= esc($activeMeeting['title']) ?>
                    </h3>
                    <div class="flex flex-wrap gap-y-2 gap-x-6 text-xs text-stone-600">
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="calendar" class="w-4 h-4 text-kowpi-600"></i>
                            <span><?= date('d F Y', strtotime($activeMeeting['meeting_date'])) ?></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="clock" class="w-4 h-4 text-kowpi-600"></i>
                            <span><?= substr($activeMeeting['start_time'], 0, 5) ?> - <?= substr($activeMeeting['end_time'], 0, 5) ?> WIB</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="map-pin" class="w-4 h-4 text-kowpi-600"></i>
                            <span><?= esc($activeMeeting['location']) ?></span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <i data-lucide="user-check" class="w-4 h-4 text-kowpi-600"></i>
                            <span>Pimpinan: <strong><?= esc($activeMeeting['leader_name']) ?></strong></span>
                        </div>
                    </div>
                </div>

                <!-- Quick Meeting Action Bar -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
                    <!-- Notula Rapat -->
                    <a href="<?= base_url('rapat/' . $activeMeeting['id'] . '/notula') ?>"
                       class="p-4 rounded-2xl bg-kowpi-50 hover:bg-kowpi-100 border border-kowpi-200 text-kowpi-950 flex flex-col items-center justify-center text-center transition-all group">
                        <div class="p-2.5 rounded-xl bg-kowpi-500/10 text-kowpi-700 mb-1.5 group-hover:scale-110 transition-transform">
                            <i data-lucide="file-edit" class="w-5 h-5"></i>
                        </div>
                        <span class="text-xs font-bold">Tulis / Edit Notula</span>
                        <span class="text-[10px] text-stone-500 mt-0.5">Keputusan & Tindak Lanjut</span>
                    </a>

                    <!-- Kelola Kehadiran -->
                    <a href="<?= base_url('rapat/' . $activeMeeting['id'] . '/kehadiran') ?>"
                       class="p-4 rounded-2xl bg-amber-50 hover:bg-amber-100 border border-amber-200 text-amber-950 flex flex-col items-center justify-center text-center transition-all group">
                        <div class="p-2.5 rounded-xl bg-amber-500/10 text-amber-700 mb-1.5 group-hover:scale-110 transition-transform">
                            <i data-lucide="users" class="w-5 h-5"></i>
                        </div>
                        <span class="text-xs font-bold">Daftar Kehadiran</span>
                        <span class="text-[10px] text-stone-500 mt-0.5"><?= $activeMeeting['total_attendance'] ?? 0 ?> Peserta Terdata</span>
                    </a>

                    <!-- Foto Dokumentasi -->
                    <a href="<?= base_url('rapat/' . $activeMeeting['id'] . '/dokumentasi') ?>"
                       class="p-4 rounded-2xl bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 text-emerald-950 flex flex-col items-center justify-center text-center transition-all group">
                        <div class="p-2.5 rounded-xl bg-emerald-500/10 text-emerald-700 mb-1.5 group-hover:scale-110 transition-transform">
                            <i data-lucide="camera" class="w-5 h-5"></i>
                        </div>
                        <span class="text-xs font-bold">Foto Dokumentasi</span>
                        <span class="text-[10px] text-stone-500 mt-0.5"><?= $activeMeeting['total_photos'] ?? 0 ?> Foto Galeri</span>
                    </a>

                    <!-- Cetak / Unduh Dokumen Lengkap -->
                    <a href="<?= base_url('export/print-dokumen/' . $activeMeeting['id']) ?>" target="_blank"
                       class="p-4 rounded-2xl bg-stone-50 hover:bg-stone-100 border border-stone-200 text-stone-900 flex flex-col items-center justify-center text-center transition-all group">
                        <div class="p-2.5 rounded-xl bg-stone-500/10 text-stone-700 mb-1.5 group-hover:scale-110 transition-transform">
                            <i data-lucide="printer" class="w-5 h-5"></i>
                        </div>
                        <span class="text-xs font-bold">Cetak Berkas PDF</span>
                        <span class="text-[10px] text-stone-500 mt-0.5">Notula + TTD Lengkap</span>
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Recent Meetings Table -->
    <div class="bg-white rounded-3xl border border-champagne-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-champagne-100 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="font-serif-kowpi font-bold text-lg text-kowpi-900">
                    Agenda & Notula Rapat Terbaru
                </h3>
                <p class="text-xs text-stone-500">
                    Daftar seluruh rapat yang diselenggarakan oleh KOWPI
                </p>
            </div>
            <a href="<?= base_url('rapat') ?>" class="text-xs font-bold text-kowpi-700 hover:text-kowpi-900 flex items-center gap-1">
                <span>Lihat Semua Rapat</span>
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-champagne-50/70 text-stone-500 font-semibold border-b border-champagne-200">
                    <tr>
                        <th class="py-3.5 px-4">Kode & Judul Rapat</th>
                        <th class="py-3.5 px-4">Tanggal & Waktu</th>
                        <th class="py-3.5 px-4">Pimpinan & Notulis</th>
                        <th class="py-3.5 px-4 text-center">Kehadiran (TTD)</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-champagne-100">
                    <?php if (empty($recentMeetings)): ?>
                        <tr>
                            <td colspan="6" class="py-8 text-center text-stone-400">
                                Belum ada data rapat. Silakan klik tombol "Jadwalkan Rapat Baru".
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($recentMeetings as $m): ?>
                            <tr class="hover:bg-champagne-50/60 transition-colors">
                                <td class="py-4 px-4">
                                    <div class="font-mono text-[11px] text-gold-dark font-bold">
                                        <?= esc($m['meeting_code']) ?>
                                    </div>
                                    <a href="<?= base_url('rapat/detail/' . $m['id']) ?>" class="font-bold text-stone-900 hover:text-kowpi-700 text-sm line-clamp-1">
                                        <?= esc($m['title']) ?>
                                    </a>
                                    <span class="inline-block mt-1 text-[10px] text-stone-400">
                                        <?= esc($m['category']) ?> &bull; <?= ucfirst($m['meeting_type']) ?>
                                    </span>
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap text-stone-600">
                                    <div class="font-medium text-stone-800">
                                        <?= date('d M Y', strtotime($m['meeting_date'])) ?>
                                    </div>
                                    <div class="text-[11px] text-stone-400">
                                        <?= substr($m['start_time'], 0, 5) ?> - <?= substr($m['end_time'], 0, 5) ?> WIB
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-stone-600">
                                    <div class="font-semibold text-stone-800">
                                        <?= esc($m['leader_name']) ?>
                                    </div>
                                    <div class="text-[11px] text-stone-400">
                                        Notulis: <?= esc($m['notary_name']) ?>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-50 text-amber-900 font-bold border border-amber-200 text-xs">
                                        <i data-lucide="check-check" class="w-3.5 h-3.5 text-amber-600"></i>
                                        <?= $m['total_present'] ?? 0 ?> Hadir
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center whitespace-nowrap">
                                    <?php if ($m['status'] === 'ongoing'): ?>
                                        <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[11px]">
                                            Berlangsung
                                        </span>
                                    <?php elseif ($m['status'] === 'completed'): ?>
                                        <span class="px-2.5 py-1 rounded-full bg-blue-100 text-blue-800 font-bold text-[11px]">
                                            Selesai
                                        </span>
                                    <?php elseif ($m['status'] === 'archived'): ?>
                                        <span class="px-2.5 py-1 rounded-full bg-purple-100 text-purple-800 font-bold text-[11px]">
                                            Diarsipkan
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2.5 py-1 rounded-full bg-stone-100 text-stone-700 font-bold text-[11px]">
                                            Draft
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-4 px-4 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="<?= base_url('rapat/detail/' . $m['id']) ?>" title="Detail & Hub Rapat" class="p-2 rounded-xl bg-stone-100 hover:bg-kowpi-100 text-stone-600 hover:text-kowpi-800 transition-colors">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </a>
                                        <a href="<?= base_url('rapat/' . $m['id'] . '/notula') ?>" title="Notula Rapat" class="p-2 rounded-xl bg-stone-100 hover:bg-amber-100 text-stone-600 hover:text-amber-800 transition-colors">
                                            <i data-lucide="file-edit" class="w-4 h-4"></i>
                                        </a>
                                        <a href="<?= base_url('export/print-dokumen/' . $m['id']) ?>" target="_blank" title="Cetak Berkas Resmi" class="p-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-600 hover:text-stone-900 transition-colors">
                                            <i data-lucide="printer" class="w-4 h-4"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?= $this->endSection() ?>
