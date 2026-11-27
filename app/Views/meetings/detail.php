<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-7xl mx-auto">

    <!-- Breadcrumb & Top Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="<?= base_url('rapat') ?>" class="p-2 rounded-xl bg-white border border-stone-200 text-stone-600 hover:bg-stone-50 transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <span class="font-mono text-xs font-bold text-gold-dark bg-champagne-100 px-2.5 py-0.5 rounded-lg border border-champagne-200">
                        <?= esc($meeting['meeting_code']) ?>
                    </span>
                    <span class="text-xs text-stone-400">&bull;</span>
                    <span class="text-xs font-semibold text-stone-500 uppercase"><?= esc($meeting['category']) ?></span>
                </div>
                <h2 class="font-serif-kowpi font-bold text-xl md:text-2xl text-kowpi-950 mt-1">
                    <?= esc($meeting['title']) ?>
                </h2>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap items-center gap-2">
            <!-- Halaman Publik & Presensi -->
            <a href="<?= base_url('/') ?>" target="_blank"
               class="px-3.5 py-2 rounded-xl bg-white hover:bg-champagne-50 text-kowpi-900 border border-champagne-300 font-bold text-xs flex items-center gap-1.5 shadow-xs transition-colors">
                <i data-lucide="globe" class="w-4 h-4 text-kowpi-700"></i>
                <span>Lihat Halaman Publik</span>
            </a>

            <!-- Toggle Lock/Unlock Presensi -->
            <form action="<?= base_url('rapat/toggle-presence/' . $meeting['id']) ?>" method="POST" class="inline">
                <?php if ($meeting['is_presence_open']): ?>
                    <button type="submit" class="px-3.5 py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-semibold text-xs flex items-center gap-1.5" title="Klik untuk mengunci presensi">
                        <i data-lucide="unlock" class="w-4 h-4 text-emerald-600"></i>
                        <span>Presensi Terbuka</span>
                    </button>
                <?php else: ?>
                    <button type="submit" class="px-3.5 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-800 border border-rose-300 font-semibold text-xs flex items-center gap-1.5" title="Klik untuk membuka kembali presensi">
                        <i data-lucide="lock" class="w-4 h-4 text-rose-600"></i>
                        <span>Presensi Dikunci</span>
                    </button>
                <?php endif; ?>
            </form>

            <!-- Cetak Berkas -->
            <a href="<?= base_url('export/print-dokumen/' . $meeting['id']) ?>" target="_blank"
               class="px-3.5 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-300 font-semibold text-xs flex items-center gap-1.5">
                <i data-lucide="printer" class="w-4 h-4 text-stone-700"></i>
                <span>Cetak Berkas</span>
            </a>

            <!-- Edit Rapat -->
            <a href="<?= base_url('rapat/edit/' . $meeting['id']) ?>"
               class="px-3 py-2 rounded-xl bg-white hover:bg-stone-50 text-stone-700 border border-stone-200 font-semibold text-xs flex items-center gap-1.5">
                <i data-lucide="edit" class="w-4 h-4"></i>
                <span>Edit</span>
            </a>
        </div>
    </div>

    <!-- Meeting Status Bar & Archival Trigger -->
    <div class="bg-white rounded-2xl p-4 border border-champagne-200 flex flex-wrap items-center justify-between gap-4 text-xs">
        <div class="flex items-center gap-3">
            <span class="font-bold text-stone-600">Status Rapat:</span>
            <?php if ($meeting['status'] === 'ongoing'): ?>
                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-bold flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Sedang Berjalan (Aktif)
                </span>
            <?php elseif ($meeting['status'] === 'completed'): ?>
                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-bold">
                    Selesai
                </span>
            <?php elseif ($meeting['status'] === 'archived'): ?>
                <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-800 font-bold flex items-center gap-1">
                    <i data-lucide="archive" class="w-3.5 h-3.5"></i>
                    Telah Resmi Diarsipkan
                </span>
            <?php else: ?>
                <span class="px-2.5 py-1 rounded-full bg-stone-100 text-stone-700 font-bold">
                    Draft
                </span>
            <?php endif; ?>
        </div>

        <div class="flex items-center gap-2">
            <!-- Ubah Status Dropdown Form -->
            <form action="<?= base_url('rapat/change-status/' . $meeting['id']) ?>" method="POST" class="flex items-center gap-2">
                <span class="text-stone-500">Ubah Status:</span>
                <select name="status" onchange="this.form.submit()" class="py-1 px-2.5 border border-stone-300 rounded-lg text-xs bg-white font-medium focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                    <option value="draft" <?= $meeting['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                    <option value="ongoing" <?= $meeting['status'] === 'ongoing' ? 'selected' : '' ?>>Berlangsung</option>
                    <option value="completed" <?= $meeting['status'] === 'completed' ? 'selected' : '' ?>>Selesai</option>
                    <option value="archived" <?= $meeting['status'] === 'archived' ? 'selected' : '' ?>>Diarsipkan</option>
                </select>
            </form>

            <?php if ($meeting['status'] !== 'archived'): ?>
                <form action="<?= base_url('arsip/archive/' . $meeting['id']) ?>" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin mengarsipkan rapat ini? Dokumen presensi akan otomatis dikunci.')">
                    <button type="submit" class="px-3 py-1 rounded-lg bg-purple-50 text-purple-800 hover:bg-purple-100 border border-purple-200 font-bold flex items-center gap-1">
                        <i data-lucide="archive" class="w-3.5 h-3.5 text-purple-600"></i>
                        Arsipkan Rapat
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- 4 Main Work Hub Cards Grid (Light Premium) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Card 1: Informasi Pelaksanaan & Agenda Rapat -->
        <div class="bg-white rounded-3xl border border-champagne-200 shadow-xs p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-champagne-100 pb-3">
                <h3 class="font-serif-kowpi font-bold text-base text-kowpi-900 flex items-center gap-2">
                    <i data-lucide="calendar" class="w-4 h-4 text-gold"></i>
                    Informasi & Agenda Rapat
                </h3>
                <span class="text-xs text-stone-500 capitalize"><?= $meeting['meeting_type'] ?></span>
            </div>

            <div class="grid grid-cols-2 gap-4 text-xs">
                <div>
                    <span class="text-stone-400 block text-[11px]">Waktu & Tanggal</span>
                    <strong class="text-stone-800"><?= date('l, d F Y', strtotime($meeting['meeting_date'])) ?></strong>
                    <p class="text-stone-500 mt-0.5"><?= substr($meeting['start_time'], 0, 5) ?> - <?= substr($meeting['end_time'], 0, 5) ?> WIB</p>
                </div>

                <div>
                    <span class="text-stone-400 block text-[11px]">Lokasi</span>
                    <strong class="text-stone-800"><?= esc($meeting['location']) ?></strong>
                    <?php if (!empty($meeting['meeting_link'])): ?>
                        <p class="mt-1">
                            <a href="<?= esc($meeting['meeting_link']) ?>" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1">
                                <i data-lucide="video" class="w-3 h-3"></i> Link Meeting
                            </a>
                        </p>
                    <?php endif; ?>
                </div>

                <div>
                    <span class="text-stone-400 block text-[11px]">Pimpinan Rapat</span>
                    <strong class="text-stone-800"><?= esc($meeting['leader_name']) ?></strong>
                    <p class="text-stone-500 text-[10px]"><?= esc($meeting['leader_title']) ?></p>
                </div>

                <div>
                    <span class="text-stone-400 block text-[11px]">Notulis Rapat</span>
                    <strong class="text-stone-800"><?= esc($meeting['notary_name']) ?></strong>
                    <p class="text-stone-500 text-[10px]">Sekretariat KOWPI</p>
                </div>
            </div>

            <div class="pt-3 border-t border-champagne-100">
                <span class="text-stone-400 block text-[11px] mb-1 font-semibold uppercase">Susunan Agenda:</span>
                <div class="bg-champagne-50/70 p-3.5 rounded-xl border border-champagne-200/80 text-xs text-stone-700 whitespace-pre-line leading-relaxed max-h-48 overflow-y-auto">
                    <?= esc($meeting['agenda']) ?>
                </div>
            </div>
        </div>

        <!-- Card 2: Kehadiran Peserta (TTD Digital) -->
        <div class="bg-white rounded-3xl border border-champagne-200 shadow-xs p-6 space-y-4 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-champagne-100 pb-3">
                    <h3 class="font-serif-kowpi font-bold text-base text-kowpi-900 flex items-center gap-2">
                        <i data-lucide="signature" class="w-4 h-4 text-gold"></i>
                        Daftar Kehadiran (TTD Digital)
                    </h3>
                    <a href="<?= base_url('/') ?>" target="_blank" class="text-xs text-kowpi-700 hover:text-kowpi-900 font-bold flex items-center gap-1">
                        <i data-lucide="globe" class="w-3.5 h-3.5"></i>
                        Meja Presensi Publik
                    </a>
                </div>

                <!-- Stats summary -->
                <div class="grid grid-cols-4 gap-2 my-4 text-center">
                    <div class="p-2.5 bg-amber-50 border border-amber-200 rounded-xl">
                        <div class="text-lg font-extrabold text-amber-900"><?= $meeting['total_present'] ?? 0 ?></div>
                        <div class="text-[10px] text-amber-700 font-bold uppercase">Hadir</div>
                    </div>
                    <div class="p-2.5 bg-blue-50 border border-blue-200 rounded-xl">
                        <div class="text-lg font-extrabold text-blue-900"><?= $meeting['total_offline'] ?? 0 ?></div>
                        <div class="text-[10px] text-blue-700 font-bold uppercase">Offline</div>
                    </div>
                    <div class="p-2.5 bg-emerald-50 border border-emerald-200 rounded-xl">
                        <div class="text-lg font-extrabold text-emerald-900"><?= $meeting['total_online'] ?? 0 ?></div>
                        <div class="text-[10px] text-emerald-700 font-bold uppercase">Online</div>
                    </div>
                    <div class="p-2.5 bg-stone-50 border border-stone-200 rounded-xl">
                        <div class="text-lg font-extrabold text-stone-800"><?= ($meeting['total_izin'] ?? 0) + ($meeting['total_sakit'] ?? 0) ?></div>
                        <div class="text-[10px] text-stone-600 font-bold uppercase">Izin/Sakit</div>
                    </div>
                </div>

                <!-- Preview Attendee List (top 4) -->
                <div class="space-y-2 text-xs">
                    <span class="text-stone-400 block text-[11px] font-semibold uppercase">Peserta Baru Hadir:</span>
                    <?php if (empty($attendances)): ?>
                        <p class="text-stone-400 text-xs py-4 text-center">Belum ada peserta yang melakukan presensi.</p>
                    <?php else: ?>
                        <div class="divide-y divide-champagne-100 max-h-44 overflow-y-auto">
                            <?php foreach (array_slice($attendances, 0, 4) as $att): ?>
                                <div class="py-2 flex items-center justify-between">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-full bg-kowpi-100 text-kowpi-800 font-bold text-[10px] flex items-center justify-center">
                                            <?= strtoupper(substr($att['participant_name'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div class="font-bold text-stone-800"><?= esc($att['participant_name']) ?></div>
                                            <div class="text-[10px] text-stone-400"><?= esc($att['institution']) ?> &bull; <?= date('H:i', strtotime($att['check_in_time'])) ?> WIB</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <?php if (!empty($att['signature_image'])): ?>
                                            <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-semibold">
                                                TTD &check;
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="pt-3 border-t border-champagne-100 flex items-center justify-between text-xs">
                <a href="<?= base_url('rapat/' . $meeting['id'] . '/kehadiran') ?>" class="text-kowpi-700 hover:text-kowpi-900 font-bold flex items-center gap-1">
                    <span>Lihat & Kelola Seluruh Peserta (<?= count($attendances) ?>)</span>
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
                <a href="<?= base_url('kehadiran/export-excel/' . $meeting['id']) ?>" class="text-stone-600 hover:text-stone-900 font-semibold flex items-center gap-1">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i>
                    Excel
                </a>
            </div>
        </div>

        <!-- Card 3: Status Notula Rapat & Pengesahan -->
        <div class="bg-white rounded-3xl border border-champagne-200 shadow-xs p-6 space-y-4 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-champagne-100 pb-3">
                    <h3 class="font-serif-kowpi font-bold text-base text-kowpi-900 flex items-center gap-2">
                        <i data-lucide="file-text" class="w-4 h-4 text-gold"></i>
                        Notula Rapat & Keputusan Resmi
                    </h3>
                    <span class="text-xs <?= !empty($minutes['decisions']) ? 'text-emerald-700 font-bold' : 'text-stone-400' ?>">
                        <?= !empty($minutes['decisions']) ? 'Keputusan Terisi' : 'Draft Kosong' ?>
                    </span>
                </div>

                <div class="space-y-3 mt-3 text-xs">
                    <div>
                        <span class="text-stone-400 block text-[11px] font-semibold uppercase">Poin Kesepakatan & Keputusan:</span>
                        <div class="p-3 bg-champagne-50/70 rounded-xl border border-champagne-200 text-stone-700 line-clamp-3 leading-relaxed">
                            <?= !empty($minutes['decisions']) ? esc($minutes['decisions']) : '<em class="text-stone-400">Belum ada keputusan yang dicatat. Klik "Tulis / Edit Notula" di bawah.</em>' ?>
                        </div>
                    </div>

                    <!-- Status Tanda Tangan Pimpinan & Notulis -->
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <div class="p-3 rounded-xl border <?= !empty($minutes['is_signed_leader']) ? 'bg-emerald-50/60 border-emerald-200' : 'bg-stone-50 border-stone-200' ?>">
                            <span class="text-[10px] text-stone-400 block uppercase">TTD Pimpinan Rapat</span>
                            <div class="font-bold text-stone-800 text-xs truncate mt-0.5"><?= esc($meeting['leader_name']) ?></div>
                            <div class="mt-1 text-[11px] font-semibold <?= !empty($minutes['is_signed_leader']) ? 'text-emerald-700' : 'text-stone-400' ?>">
                                <?= !empty($minutes['is_signed_leader']) ? 'Sudah Ditandatangani &check;' : 'Belum TTD' ?>
                            </div>
                        </div>

                        <div class="p-3 rounded-xl border <?= !empty($minutes['is_signed_notary']) ? 'bg-emerald-50/60 border-emerald-200' : 'bg-stone-50 border-stone-200' ?>">
                            <span class="text-[10px] text-stone-400 block uppercase">TTD Notulis Rapat</span>
                            <div class="font-bold text-stone-800 text-xs truncate mt-0.5"><?= esc($meeting['notary_name']) ?></div>
                            <div class="mt-1 text-[11px] font-semibold <?= !empty($minutes['is_signed_notary']) ? 'text-emerald-700' : 'text-stone-400' ?>">
                                <?= !empty($minutes['is_signed_notary']) ? 'Sudah Ditandatangani &check;' : 'Belum TTD' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-3 border-t border-champagne-100 flex items-center justify-between text-xs">
                <a href="<?= base_url('rapat/' . $meeting['id'] . '/notula') ?>" class="px-4 py-2 rounded-xl bg-kowpi-700 hover:bg-kowpi-800 text-white font-bold transition-all flex items-center gap-1.5 shadow-xs">
                    <i data-lucide="edit-3" class="w-3.5 h-3.5 text-gold-light"></i>
                    <span>Tulis / Edit Notula</span>
                </a>
                <a href="<?= base_url('rapat/' . $meeting['id'] . '/notula/view') ?>" target="_blank" class="text-stone-600 hover:text-stone-900 font-semibold flex items-center gap-1">
                    <i data-lucide="file-check" class="w-3.5 h-3.5"></i>
                    Preview Format Dokumen
                </a>
            </div>
        </div>

        <!-- Card 4: Dokumentasi Foto Rapat -->
        <div class="bg-white rounded-3xl border border-champagne-200 shadow-xs p-6 space-y-4 flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between border-b border-champagne-100 pb-3">
                    <h3 class="font-serif-kowpi font-bold text-base text-kowpi-900 flex items-center gap-2">
                        <i data-lucide="camera" class="w-4 h-4 text-gold"></i>
                        Dokumentasi Foto Rapat
                    </h3>
                    <span class="text-xs font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                        <?= count($documentations) ?> Foto
                    </span>
                </div>

                <div class="mt-4">
                    <?php if (empty($documentations)): ?>
                        <div class="py-8 text-center bg-stone-50 rounded-2xl border border-dashed border-stone-300">
                            <i data-lucide="image" class="w-8 h-8 text-stone-300 mx-auto mb-2"></i>
                            <p class="text-xs text-stone-500">Belum ada foto dokumentasi yang diunggah.</p>
                            <a href="<?= base_url('rapat/' . $meeting['id'] . '/dokumentasi') ?>" class="inline-block mt-2 text-xs font-bold text-kowpi-700 hover:underline">
                                Unggah Foto Sekarang &rarr;
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-3 gap-2.5">
                            <?php foreach (array_slice($documentations, 0, 3) as $doc): ?>
                                <div class="group relative rounded-xl overflow-hidden aspect-video bg-stone-100 border border-stone-200 shadow-inner">
                                    <img src="<?= base_url($doc['file_path']) ?>" alt="Foto" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-1.5 text-[10px] text-white truncate">
                                        <?= esc($doc['caption'] ?? 'Dokumentasi') ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="pt-3 border-t border-champagne-100 flex items-center justify-between text-xs">
                <a href="<?= base_url('rapat/' . $meeting['id'] . '/dokumentasi') ?>" class="text-kowpi-700 hover:text-kowpi-900 font-bold flex items-center gap-1">
                    <span>Kelola & Tambah Foto Dokumentasi</span>
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>

    </div>

    <!-- Danger Zone: Delete Meeting -->
    <div class="p-4 rounded-2xl bg-rose-50/50 border border-rose-200 flex items-center justify-between text-xs">
        <div>
            <strong class="text-rose-900 block font-bold">Hapus Seluruh Data Rapat</strong>
            <span class="text-rose-600">Menghapus rapat ini akan menghapus seluruh data notula, berkas tanda tangan, dan foto dokumentasi secara permanen.</span>
        </div>
        <a href="<?= base_url('rapat/delete/' . $meeting['id']) ?>"
           onclick="return confirm('PENTING: Apakah Anda benar-benar yakin ingin menghapus agenda rapat ini beserta seluruh berkas tanda tangan dan fotonya? Tindakan ini tidak dapat dibatalkan.')"
           class="px-3.5 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold transition-colors">
            Hapus Rapat
        </a>
    </div>

</div>
<?= $this->endSection() ?>
