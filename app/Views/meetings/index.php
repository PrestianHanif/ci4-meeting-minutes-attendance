<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-7xl mx-auto">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="font-serif-kowpi font-bold text-2xl text-kowpi-950">
                Agenda & Notula Rapat
            </h2>
            <p class="text-xs text-stone-500">
                Kelola seluruh agenda pertemuan, penyusunan notula keputusan, dan kehadiran pengurus KOWPI.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="<?= base_url('rapat/create') ?>" class="px-4 py-2.5 rounded-xl bg-kowpi-700 hover:bg-kowpi-800 text-white font-semibold text-xs shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-4 h-4 text-gold-light"></i>
                Jadwalkan Rapat Baru
            </a>
        </div>
    </div>

    <!-- Filters & Search Form -->
    <div class="bg-white rounded-2xl p-4 border border-paper-200 shadow-sm">
        <form method="GET" action="<?= base_url('rapat') ?>" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 text-xs">
            <div>
                <label class="block text-stone-600 font-semibold mb-1">Cari Kata Kunci</label>
                <div class="relative">
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" placeholder="Judul, kode, pimpinan..." 
                           class="w-full pl-8 pr-3 py-2 border border-stone-200 rounded-lg text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                    <i data-lucide="search" class="w-3.5 h-3.5 text-stone-400 absolute left-2.5 top-2.5"></i>
                </div>
            </div>

            <div>
                <label class="block text-stone-600 font-semibold mb-1">Status Rapat</label>
                <select name="status" class="w-full py-2 px-3 border border-stone-200 rounded-lg text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none bg-white">
                    <option value="">Semua Status</option>
                    <option value="draft" <?= ($status ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                    <option value="ongoing" <?= ($status ?? '') === 'ongoing' ? 'selected' : '' ?>>Sedang Berjalan / Aktif</option>
                    <option value="completed" <?= ($status ?? '') === 'completed' ? 'selected' : '' ?>>Selesai</option>
                    <option value="archived" <?= ($status ?? '') === 'archived' ? 'selected' : '' ?>>Diarsipkan</option>
                </select>
            </div>

            <div>
                <label class="block text-stone-600 font-semibold mb-1">Kategori Rapat</label>
                <select name="category" class="w-full py-2 px-3 border border-stone-200 rounded-lg text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none bg-white">
                    <option value="">Semua Kategori</option>
                    <option value="Rapat Pleno" <?= ($category ?? '') === 'Rapat Pleno' ? 'selected' : '' ?>>Rapat Pleno</option>
                    <option value="Rapat Pimpinan" <?= ($category ?? '') === 'Rapat Pimpinan' ? 'selected' : '' ?>>Rapat Pimpinan</option>
                    <option value="Rapat Koordinasi" <?= ($category ?? '') === 'Rapat Koordinasi' ? 'selected' : '' ?>>Rapat Koordinasi</option>
                    <option value="Rapat Divisi" <?= ($category ?? '') === 'Rapat Divisi' ? 'selected' : '' ?>>Rapat Divisi</option>
                    <option value="Rapat Kerja" <?= ($category ?? '') === 'Rapat Kerja' ? 'selected' : '' ?>>Rapat Kerja</option>
                    <option value="Rapat Evaluasi" <?= ($category ?? '') === 'Rapat Evaluasi' ? 'selected' : '' ?>>Rapat Evaluasi</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 py-2 px-3 rounded-lg bg-stone-800 hover:bg-stone-900 text-white font-semibold transition-colors flex items-center justify-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                    Terapkan
                </button>
                <a href="<?= base_url('rapat') ?>" class="py-2 px-3 rounded-lg border border-stone-200 text-stone-600 hover:bg-stone-50 font-semibold transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Meetings Grid / Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (empty($meetings)): ?>
            <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-paper-200">
                <div class="w-16 h-16 rounded-full bg-kowpi-50 text-kowpi-700 flex items-center justify-center mx-auto mb-4 border border-kowpi-100">
                    <i data-lucide="calendar-x" class="w-8 h-8"></i>
                </div>
                <h3 class="font-serif-kowpi font-bold text-lg text-kowpi-950 mb-1">
                    Tidak Ditemukan Data Rapat
                </h3>
                <p class="text-xs text-stone-500 max-w-md mx-auto mb-5">
                    Tidak ada agenda rapat yang cocok dengan filter pencarian Anda atau belum ada agenda rapat yang dibuat.
                </p>
                <a href="<?= base_url('rapat/create') ?>" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-kowpi-700 text-white text-xs font-semibold hover:bg-kowpi-800 transition-colors">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Buat Rapat Sekarang
                </a>
            </div>
        <?php else: ?>
            <?php foreach ($meetings as $m): ?>
                <div class="bg-white rounded-2xl border border-paper-200 shadow-sm hover:shadow-md transition-all flex flex-col justify-between overflow-hidden group">
                    <div class="p-5 space-y-4">
                        <!-- Card Header Badge & Code -->
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-mono text-[11px] font-bold text-gold-dark bg-amber-50 px-2 py-0.5 rounded border border-amber-200/80">
                                <?= esc($m['meeting_code']) ?>
                            </span>

                            <?php if ($m['status'] === 'ongoing'): ?>
                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px] flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Berlangsung
                                </span>
                            <?php elseif ($m['status'] === 'completed'): ?>
                                <span class="px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800 font-bold text-[10px]">
                                    Selesai
                                </span>
                            <?php elseif ($m['status'] === 'archived'): ?>
                                <span class="px-2.5 py-0.5 rounded-full bg-purple-100 text-purple-800 font-bold text-[10px]">
                                    Diarsipkan
                                </span>
                            <?php else: ?>
                                <span class="px-2.5 py-0.5 rounded-full bg-stone-100 text-stone-700 font-bold text-[10px]">
                                    Draft
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Title & Category -->
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-kowpi-700">
                                <?= esc($m['category']) ?>
                            </span>
                            <h3 class="font-serif-kowpi font-bold text-base text-stone-900 group-hover:text-kowpi-800 transition-colors line-clamp-2 mt-1">
                                <a href="<?= base_url('rapat/detail/' . $m['id']) ?>">
                                    <?= esc($m['title']) ?>
                                </a>
                            </h3>
                        </div>

                        <!-- Date & Location -->
                        <div class="space-y-1.5 text-xs text-stone-600 pt-1 border-t border-paper-200">
                            <div class="flex items-center gap-2">
                                <i data-lucide="calendar" class="w-3.5 h-3.5 text-stone-400"></i>
                                <span><?= date('d M Y', strtotime($m['meeting_date'])) ?> &bull; <?= substr($m['start_time'], 0, 5) ?> WIB</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i data-lucide="map-pin" class="w-3.5 h-3.5 text-stone-400"></i>
                                <span class="truncate"><?= esc($m['location']) ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i data-lucide="user" class="w-3.5 h-3.5 text-stone-400"></i>
                                <span class="truncate">Pimpinan: <strong><?= esc($m['leader_name']) ?></strong></span>
                            </div>
                        </div>

                        <!-- Quick Badges Counters -->
                        <div class="grid grid-cols-3 gap-2 pt-2 text-center text-[11px]">
                            <div class="p-2 rounded-xl bg-amber-50 border border-amber-100">
                                <div class="font-extrabold text-amber-900"><?= $m['total_present'] ?? 0 ?></div>
                                <div class="text-[10px] text-amber-700">Hadir TTD</div>
                            </div>
                            <div class="p-2 rounded-xl bg-kowpi-50 border border-kowpi-100">
                                <div class="font-extrabold text-kowpi-800"><?= $m['has_minutes'] ? 'Ada' : '-' ?></div>
                                <div class="text-[10px] text-kowpi-700">Notula</div>
                            </div>
                            <div class="p-2 rounded-xl bg-emerald-50 border border-emerald-100">
                                <div class="font-extrabold text-emerald-800"><?= $m['total_photos'] ?? 0 ?></div>
                                <div class="text-[10px] text-emerald-700">Foto</div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer Actions -->
                    <div class="p-3 bg-stone-50 border-t border-paper-200 flex items-center justify-between text-xs">
                        <a href="<?= base_url('presensi/' . $m['meeting_code']) ?>" target="_blank" class="font-semibold text-amber-800 hover:text-amber-950 flex items-center gap-1">
                            <i data-lucide="pen-tool" class="w-3.5 h-3.5 text-amber-600"></i>
                            Presensi
                        </a>

                        <div class="flex items-center gap-1.5">
                            <a href="<?= base_url('rapat/detail/' . $m['id']) ?>" class="px-2.5 py-1.5 rounded-lg bg-stone-200 hover:bg-stone-300 font-semibold text-stone-800 transition-colors">
                                Kelola
                            </a>
                            <a href="<?= base_url('export/print-dokumen/' . $m['id']) ?>" target="_blank" title="Cetak Berkas" class="p-1.5 rounded-lg bg-stone-200 hover:bg-stone-300 text-stone-700">
                                <i data-lucide="printer" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>
<?= $this->endSection() ?>

