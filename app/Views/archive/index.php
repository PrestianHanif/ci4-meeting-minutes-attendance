<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-7xl mx-auto">

    <!-- Header Banner (Light Luxury) -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-white via-champagne-50 to-kowpi-50 text-stone-900 p-6 md:p-8 border border-champagne-200 shadow-xs">
        <div class="absolute -right-8 -bottom-8 w-60 h-60 bg-gold/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-champagne-200/60 border border-champagne-300 text-xs text-kowpi-800 font-bold">
                    <i data-lucide="archive" class="w-3.5 h-3.5 text-gold-dark"></i>
                    Direktori Arsip Resmi
                </div>
                <h2 class="font-serif-kowpi font-bold text-2xl md:text-3xl text-kowpi-950">
                    Direktori Arsip Notula & Berkas Rapat KOWPI
                </h2>
                <p class="text-xs md:text-sm text-stone-600 max-w-2xl leading-relaxed">
                    Dokumentasi historis rapat resmi yang telah disahkan, dilengkapi lembar kehadiran ber-tanda tangan digital dan arsip foto kegiatan.
                </p>
            </div>
            <div class="bg-white border border-champagne-200 p-4 rounded-2xl text-center shrink-0 shadow-xs">
                <div class="text-2xl font-extrabold text-kowpi-900"><?= count($archives) ?></div>
                <div class="text-[11px] text-stone-500 uppercase tracking-wider font-semibold">Rapat Diarsipkan</div>
            </div>
        </div>
    </div>

    <!-- Ready to Archive Alert Section (if any completed meetings exist) -->
    <?php if (!empty($readyToArchive)): ?>
        <div class="bg-amber-50 border border-amber-300 rounded-2xl p-5 shadow-xs space-y-3">
            <div class="flex items-center gap-2.5 text-amber-900 font-bold text-xs">
                <i data-lucide="alert-circle" class="w-4 h-4 text-amber-600"></i>
                <span>Terdapat <?= count($readyToArchive) ?> Rapat Berstatus "Selesai" yang Siap Diarsipkan:</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                <?php foreach ($readyToArchive as $ready): ?>
                    <div class="bg-white p-3 rounded-xl border border-amber-200 flex items-center justify-between gap-2 text-xs">
                        <div class="min-w-0">
                            <strong class="text-stone-900 truncate block"><?= esc($ready['title']) ?></strong>
                            <span class="text-[10px] text-stone-400 font-mono"><?= esc($ready['meeting_code']) ?> &bull; <?= date('d/m/Y', strtotime($ready['meeting_date'])) ?></span>
                        </div>
                        <form action="<?= base_url('arsip/archive/' . $ready['id']) ?>" method="POST" class="shrink-0" onsubmit="return confirm('Arsipkan rapat ini?')">
                            <button type="submit" class="px-2.5 py-1 bg-purple-700 hover:bg-purple-800 text-white rounded-lg font-bold text-[10px] shadow transition-colors">
                                Arsipkan
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl p-4 border border-champagne-200 shadow-xs">
        <form method="GET" action="<?= base_url('arsip') ?>" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 text-xs">
            <div>
                <label class="block text-stone-600 font-semibold mb-1">Cari Arsip</label>
                <div class="relative">
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" placeholder="Kata kunci arsip..."
                           class="w-full pl-8 pr-3 py-2 border border-stone-200 rounded-lg text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                    <i data-lucide="search" class="w-3.5 h-3.5 text-stone-400 absolute left-2.5 top-2.5"></i>
                </div>
            </div>

            <div>
                <label class="block text-stone-600 font-semibold mb-1">Filter Tahun</label>
                <select name="year" class="w-full py-2 px-3 border border-stone-200 rounded-lg text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none bg-white">
                    <option value="">Semua Tahun</option>
                    <?php foreach ($years as $y): ?>
                        <option value="<?= $y ?>" <?= ($selectedYear ?? '') == $y ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-stone-600 font-semibold mb-1">Filter Kategori</label>
                <select name="category" class="w-full py-2 px-3 border border-stone-200 rounded-lg text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none bg-white">
                    <option value="">Semua Kategori</option>
                    <?php foreach (['Rapat Pleno', 'Rapat Pimpinan', 'Rapat Koordinasi', 'Rapat Divisi', 'Rapat Kerja', 'Rapat Evaluasi', 'Rapat Luar Biasa'] as $cat): ?>
                        <option value="<?= $cat ?>" <?= ($category ?? '') === $cat ? 'selected' : '' ?>><?= $cat ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 py-2 px-3 bg-kowpi-700 hover:bg-kowpi-800 text-white rounded-lg font-semibold flex items-center justify-center gap-1.5 transition-colors">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i>
                    Saring
                </button>
                <a href="<?= base_url('arsip') ?>" class="py-2 px-3 rounded-lg border border-stone-200 text-stone-600 hover:bg-stone-50 font-semibold transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Archives Grid Directory (Light Luxury Cards) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (empty($archives)): ?>
            <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-champagne-200">
                <div class="w-16 h-16 rounded-full bg-purple-50 text-purple-700 flex items-center justify-center mx-auto mb-4 border border-purple-100">
                    <i data-lucide="archive" class="w-8 h-8"></i>
                </div>
                <h3 class="font-serif-kowpi font-bold text-lg text-kowpi-950 mb-1">
                    Belum Ada Rapat yang Diarsipkan
                </h3>
                <p class="text-xs text-stone-500 max-w-md mx-auto mb-5">
                    Setelah sebuah rapat selesai terlaksana dan seluruh notula serta presensi telah disahkan, Anda dapat mengarsipkannya agar tersimpan di direktori permanen ini.
                </p>
                <a href="<?= base_url('rapat') ?>" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-kowpi-700 text-white text-xs font-semibold hover:bg-kowpi-800 transition-colors">
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                    Buka Daftar Rapat
                </a>
            </div>
        <?php else: ?>
            <?php foreach ($archives as $arch): ?>
                <div class="bg-white rounded-2xl border border-champagne-200 shadow-xs hover:shadow-sm transition-all flex flex-col justify-between overflow-hidden">
                    <div class="p-5 space-y-4">
                        <!-- Header Badge -->
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-mono text-[11px] font-bold text-purple-900 bg-purple-50 px-2.5 py-0.5 rounded border border-purple-200">
                                <?= esc($arch['meeting_code']) ?>
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full bg-purple-100 text-purple-800 font-bold text-[10px] flex items-center gap-1">
                                <i data-lucide="lock" class="w-3 h-3"></i>
                                Diarsipkan
                            </span>
                        </div>

                        <!-- Title -->
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gold-dark">
                                <?= esc($arch['category']) ?>
                            </span>
                            <h3 class="font-serif-kowpi font-bold text-base text-stone-900 line-clamp-2 mt-1">
                                <?= esc($arch['title']) ?>
                            </h3>
                        </div>

                        <!-- Date & Archival Info -->
                        <div class="space-y-1.5 text-xs text-stone-600 pt-1 border-t border-champagne-100">
                            <div class="flex items-center gap-2">
                                <i data-lucide="calendar" class="w-3.5 h-3.5 text-stone-400"></i>
                                <span><?= date('d M Y', strtotime($arch['meeting_date'])) ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i data-lucide="user-check" class="w-3.5 h-3.5 text-stone-400"></i>
                                <span>Pimpinan: <strong><?= esc($arch['leader_name']) ?></strong></span>
                            </div>
                            <?php if (!empty($arch['archived_at'])): ?>
                                <div class="text-[10px] text-stone-400 italic">
                                    Diarsipkan pada: <?= date('d/m/Y H:i', strtotime($arch['archived_at'])) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Stats Strip -->
                        <div class="grid grid-cols-3 gap-2 pt-2 text-center text-[11px]">
                            <div class="p-2 rounded-xl bg-champagne-100/70 border border-champagne-200">
                                <div class="font-extrabold text-kowpi-900"><?= $arch['total_present'] ?? 0 ?></div>
                                <div class="text-[10px] text-stone-500">Hadir (TTD)</div>
                            </div>
                            <div class="p-2 rounded-xl bg-champagne-100/70 border border-champagne-200">
                                <div class="font-extrabold text-kowpi-900"><?= $arch['has_minutes'] ? 'Ada' : '-' ?></div>
                                <div class="text-[10px] text-stone-500">Notula</div>
                            </div>
                            <div class="p-2 rounded-xl bg-champagne-100/70 border border-champagne-200">
                                <div class="font-extrabold text-kowpi-900"><?= $arch['total_photos'] ?? 0 ?></div>
                                <div class="text-[10px] text-stone-500">Foto</div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer Actions -->
                    <div class="p-3 bg-champagne-50/70 border-t border-champagne-200 flex items-center justify-between text-xs">
                        <a href="<?= base_url('arsip/bundle/' . $arch['id']) ?>" class="font-bold text-kowpi-800 hover:text-kowpi-950 flex items-center gap-1">
                            <i data-lucide="folder-open" class="w-4 h-4 text-gold-dark"></i>
                            <span>Buka Berkas Arsip</span>
                        </a>

                        <div class="flex items-center gap-1.5">
                            <a href="<?= base_url('export/print-dokumen/' . $arch['id']) ?>" target="_blank" title="Cetak Berkas" class="p-1.5 rounded-lg bg-white border border-champagne-200 hover:bg-stone-50 text-stone-700">
                                <i data-lucide="printer" class="w-4 h-4"></i>
                            </a>
                            <form action="<?= base_url('arsip/unarchive/' . $arch['id']) ?>" method="POST" class="inline" onsubmit="return confirm('Buka kunci arsip rapat ini?')">
                                <button type="submit" title="Buka Kunci Arsip" class="p-1.5 rounded-lg text-stone-400 hover:text-stone-700 hover:bg-stone-100">
                                    <i data-lucide="unlock" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>
<?= $this->endSection() ?>
