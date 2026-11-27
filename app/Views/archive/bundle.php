<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-5xl mx-auto">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="<?= base_url('arsip') ?>" class="p-2 rounded-xl bg-white border border-stone-200 text-stone-600 hover:bg-stone-50 transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <span class="font-mono text-xs font-bold text-purple-900 bg-purple-50 px-2.5 py-0.5 rounded-lg border border-purple-200">
                        <?= esc($meeting['meeting_code']) ?>
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full bg-purple-100 text-purple-800 font-bold text-[10px] flex items-center gap-1">
                        <i data-lucide="archive" class="w-3 h-3"></i>
                        Berkas Arsip Permanen
                    </span>
                </div>
                <h2 class="font-serif-kowpi font-bold text-xl md:text-2xl text-kowpi-950 mt-1">
                    <?= esc($meeting['title']) ?>
                </h2>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="<?= base_url('export/print-dokumen/' . $meeting['id']) ?>" target="_blank"
               class="px-4 py-2 bg-kowpi-700 hover:bg-kowpi-800 text-white rounded-xl font-bold text-xs shadow-sm transition-all flex items-center gap-1.5">
                <i data-lucide="printer" class="w-4 h-4 text-gold-light"></i>
                <span>Cetak / Unduh Berkas Lengkap</span>
            </a>
            <a href="<?= base_url('kehadiran/export-excel/' . $meeting['id']) ?>"
               class="px-3.5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl font-bold text-xs shadow-sm transition-all flex items-center gap-1.5">
                <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                <span>Excel Kehadiran</span>
            </a>
        </div>
    </div>

    <!-- Archival Certification Box (Light Luxury) -->
    <div class="bg-gradient-to-r from-white via-champagne-50 to-purple-50 text-stone-900 rounded-3xl p-6 border border-purple-200 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 text-xs">
        <div class="space-y-1">
            <div class="flex items-center gap-2 text-purple-900 font-bold text-xs uppercase tracking-wider">
                <i data-lucide="shield-check" class="w-4 h-4 text-purple-700"></i>
                Autentikasi Dokumen Arsip KOWPI
            </div>
            <p class="text-stone-700">
                Berkas rapat ini resmi diarsipkan oleh <strong><?= esc($meeting['archived_by'] ?? 'Admin') ?></strong> pada tanggal <strong><?= !empty($meeting['archived_at']) ? date('d F Y H:i', strtotime($meeting['archived_at'])) : date('d F Y') ?> WIB</strong>.
            </p>
            <?php if (!empty($meeting['archive_notes'])): ?>
                <p class="text-[11px] text-stone-500 italic">"<?= esc($meeting['archive_notes']) ?>"</p>
            <?php endif; ?>
        </div>
        <div class="shrink-0 flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-xl bg-purple-100 border border-purple-300 text-purple-900 font-mono font-bold text-xs">
                Status: TERKUNCI & SAH
            </span>
        </div>
    </div>

    <!-- Tabbed Dossier Container -->
    <div class="space-y-6" x-data="{ tab: 'notula' }">

        <!-- Navigation Tabs -->
        <div class="bg-white rounded-2xl p-1.5 border border-champagne-200 shadow-xs flex items-center gap-2 text-xs font-bold">
            <button @click="tab = 'notula'" :class="tab === 'notula' ? 'bg-kowpi-700 text-white shadow-xs' : 'text-stone-600 hover:text-stone-900 hover:bg-stone-50'"
                    class="flex-1 py-2.5 rounded-xl transition-all flex items-center justify-center gap-2">
                <i data-lucide="file-text" class="w-4 h-4"></i>
                <span>1. Lembar Notula & Keputusan</span>
            </button>
            <button @click="tab = 'attendance'" :class="tab === 'attendance' ? 'bg-kowpi-700 text-white shadow-xs' : 'text-stone-600 hover:text-stone-900 hover:bg-stone-50'"
                    class="flex-1 py-2.5 rounded-xl transition-all flex items-center justify-center gap-2">
                <i data-lucide="signature" class="w-4 h-4"></i>
                <span>2. Daftar Hadir Ber-TTD (<?= count($attendances) ?>)</span>
            </button>
            <button @click="tab = 'photos'" :class="tab === 'photos' ? 'bg-kowpi-700 text-white shadow-xs' : 'text-stone-600 hover:text-stone-900 hover:bg-stone-50'"
                    class="flex-1 py-2.5 rounded-xl transition-all flex items-center justify-center gap-2">
                <i data-lucide="camera" class="w-4 h-4"></i>
                <span>3. Foto Dokumentasi (<?= count($photos) ?>)</span>
            </button>
        </div>

        <!-- TAB 1: NOTULA RESMI -->
        <div x-show="tab === 'notula'" class="bg-white rounded-3xl border border-champagne-200 shadow-sm p-8 md:p-10 space-y-6 text-xs text-stone-900 leading-relaxed">
            <!-- Kop -->
            <div class="border-b-2 border-kowpi-900 pb-4 flex items-center gap-5">
                <img src="<?= base_url('img/logo-kowpi-coklat.png') ?>" alt="Logo" class="h-16 w-auto shrink-0">
                <div>
                    <h3 class="font-serif-kowpi font-bold text-lg text-kowpi-950 uppercase tracking-wide"><?= esc($settings['org_name'] ?? 'Komunitas Waris Planning Indonesia (KOWPI)') ?></h3>
                    <p class="text-[11px] font-semibold text-gold-dark mt-0.5"><?= esc($settings['org_tagline'] ?? 'Menata kehidupan dengan baik, mempersiapkan akhir yang mulia.') ?></p>
                    <p class="text-[10px] text-stone-600 mt-1 leading-tight">
                        Alamat : <?= esc($settings['org_address'] ?? 'Jl. Nangka 1 No.154 Karangnongko, Maguwoharjo, Depok, Sleman') ?>
                        <br>
                        Website : <?= esc($settings['org_website'] ?? 'https://kowpi.id') ?> | Email : <?= esc($settings['org_email'] ?? 'sekretariat@kowpi.id') ?> | Telp : <?= esc($settings['org_phone'] ?? '0812-0000-0000') ?>
                    </p>
                </div>
            </div>

            <!-- Ringkasan Acara -->
            <div class="bg-champagne-50/70 p-4 rounded-2xl border border-champagne-200 text-xs">
                <div class="grid grid-cols-2 gap-2">
                    <div><strong>Nomor:</strong> <?= esc($meeting['meeting_code']) ?></div>
                    <div><strong>Hari, Tanggal:</strong> <?= date('d F Y', strtotime($meeting['meeting_date'])) ?></div>
                    <div><strong>Pimpinan Rapat:</strong> <?= esc($meeting['leader_name']) ?></div>
                    <div><strong>Notulis:</strong> <?= esc($meeting['notary_name']) ?></div>
                </div>
            </div>

            <!-- Keputusan -->
            <div class="space-y-2">
                <h4 class="font-serif-kowpi font-bold text-sm text-kowpi-900 uppercase">Keputusan & Kesepakatan Rapat:</h4>
                <div class="p-4 bg-kowpi-50 border border-kowpi-200 rounded-2xl whitespace-pre-line text-stone-900 font-medium">
                    <?= !empty($minutes['decisions']) ? esc($minutes['decisions']) : '<em class="text-stone-400">Tidak ada catatan keputusan.</em>' ?>
                </div>
            </div>

            <!-- Action Items -->
            <?php if (!empty($actionItems)): ?>
                <div class="space-y-2">
                    <h4 class="font-serif-kowpi font-bold text-sm text-kowpi-900 uppercase">Rencana Tindak Lanjut:</h4>
                    <table class="w-full border border-stone-200 text-left text-xs rounded-xl overflow-hidden">
                        <thead class="bg-champagne-100 font-bold text-stone-800">
                            <tr>
                                <th class="p-2.5">No</th>
                                <th class="p-2.5">Tugas</th>
                                <th class="p-2.5">PIC</th>
                                <th class="p-2.5">Tenggat</th>
                                <th class="p-2.5">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-200">
                            <?php $no = 1; foreach ($actionItems as $item): ?>
                                <tr>
                                    <td class="p-2.5 text-center text-stone-400"><?= $no++ ?></td>
                                    <td class="p-2.5 font-bold"><?= esc($item['task']) ?></td>
                                    <td class="p-2.5"><?= esc($item['pic']) ?></td>
                                    <td class="p-2.5 font-mono"><?= !empty($item['deadline']) ? date('d/m/Y', strtotime($item['deadline'])) : '-' ?></td>
                                    <td class="p-2.5"><span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-900"><?= esc($item['status']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <!-- Tanda Tangan & Stempel -->
            <div class="pt-6 border-t border-champagne-100 grid grid-cols-2 gap-6 text-center">
                <div>
                    <span class="text-stone-500 font-bold text-[10px] uppercase">Pimpinan Rapat</span>
                    <div class="h-20 flex items-center justify-center my-1">
                        <?php if (!empty($minutes['leader_signature'])): ?>
                            <img src="<?= base_url($minutes['leader_signature']) ?>" alt="TTD" class="h-16 object-contain">
                        <?php else: ?>
                            <span class="text-stone-300 italic">[Belum TTD]</span>
                        <?php endif; ?>
                    </div>
                    <strong class="text-stone-900 block font-serif-kowpi text-xs underline"><?= esc($meeting['leader_name']) ?></strong>
                </div>

                <div>
                    <span class="text-stone-500 font-bold text-[10px] uppercase">Notulis Rapat</span>
                    <div class="h-20 flex items-center justify-center my-1">
                        <?php if (!empty($minutes['notary_signature'])): ?>
                            <img src="<?= base_url($minutes['notary_signature']) ?>" alt="TTD" class="h-16 object-contain">
                        <?php else: ?>
                            <span class="text-stone-300 italic">[Belum TTD]</span>
                        <?php endif; ?>
                    </div>
                    <strong class="text-stone-900 block font-serif-kowpi text-xs underline"><?= esc($meeting['notary_name']) ?></strong>
                </div>
            </div>
        </div>

        <!-- TAB 2: DAFTAR HADIR BER-TTD -->
        <div x-show="tab === 'attendance'" class="bg-white rounded-3xl border border-champagne-200 shadow-sm p-6 md:p-8 space-y-4">
            <div class="flex items-center justify-between border-b border-champagne-100 pb-3">
                <h3 class="font-serif-kowpi font-bold text-base text-kowpi-900">
                    Buku Daftar Kehadiran Peserta Terverifikasi
                </h3>
                <span class="text-xs text-stone-500">Total: <strong><?= count($attendances) ?></strong> Peserta</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border border-stone-200 rounded-xl overflow-hidden">
                    <thead class="bg-kowpi-800 text-white font-semibold">
                        <tr>
                            <th class="py-2.5 px-3 text-center w-10">No</th>
                            <th class="py-2.5 px-3">Nama Lengkap & Gelar</th>
                            <th class="py-2.5 px-3">Instansi / Divisi</th>
                            <th class="py-2.5 px-3 text-center">Status</th>
                            <th class="py-2.5 px-3 text-center">Waktu Presensi</th>
                            <th class="py-2.5 px-3 text-center">Tanda Tangan Asli</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200">
                        <?php $no = 1; foreach ($attendances as $att): ?>
                            <tr class="hover:bg-champagne-50/50">
                                <td class="py-2.5 px-3 text-center text-stone-400 font-mono"><?= $no++ ?></td>
                                <td class="py-2.5 px-3 font-bold text-stone-900"><?= esc($att['participant_name']) ?></td>
                                <td class="py-2.5 px-3 text-stone-600"><?= esc($att['institution']) ?></td>
                                <td class="py-2.5 px-3 text-center">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-900">
                                        <?= ucwords(str_replace('_', ' ', $att['attendance_status'])) ?>
                                    </span>
                                </td>
                                <td class="py-2.5 px-3 text-center font-mono text-[11px] text-stone-600">
                                    <?= date('H:i', strtotime($att['check_in_time'])) ?> WIB
                                </td>
                                <td class="py-2.5 px-3 text-center">
                                    <?php if (!empty($att['signature_image'])): ?>
                                        <img src="<?= base_url($att['signature_image']) ?>" alt="TTD" class="h-8 max-w-[90px] mx-auto object-contain">
                                    <?php else: ?>
                                        <span class="text-stone-300 italic text-[10px]">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB 3: FOTO DOKUMENTASI -->
        <div x-show="tab === 'photos'" class="bg-white rounded-3xl border border-champagne-200 shadow-sm p-6 md:p-8 space-y-4">
            <div class="flex items-center justify-between border-b border-champagne-100 pb-3">
                <h3 class="font-serif-kowpi font-bold text-base text-kowpi-900">
                    Galeri Arsip Foto Dokumentasi
                </h3>
                <span class="text-xs text-stone-500">Total: <strong><?= count($photos) ?></strong> Foto</span>
            </div>

            <?php if (empty($photos)): ?>
                <p class="py-8 text-center text-stone-400 text-xs">Tidak ada lampiran foto dokumentasi untuk arsip rapat ini.</p>
            <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <?php foreach ($photos as $p): ?>
                        <div class="bg-stone-50 border border-stone-200 rounded-2xl overflow-hidden shadow-xs">
                            <div class="aspect-video bg-stone-200 overflow-hidden">
                                <img src="<?= base_url($p['file_path']) ?>" alt="Foto" class="w-full h-full object-cover">
                            </div>
                            <div class="p-3 text-xs text-stone-700 font-medium">
                                <?= esc($p['caption'] ?? 'Dokumentasi Rapat KOWPI') ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

    </div>

</div>
<?= $this->endSection() ?>
