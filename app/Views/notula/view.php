<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Action Toolbar -->
    <div class="flex items-center justify-between no-print">
        <div class="flex items-center gap-3">
            <a href="<?= base_url('rapat/detail/' . $meeting['id']) ?>" class="p-2 rounded-xl bg-white border border-stone-200 text-stone-600 hover:bg-stone-50 transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h2 class="font-serif-kowpi font-bold text-xl text-kowpi-950">
                    Notula Resmi: <?= esc($meeting['meeting_code']) ?>
                </h2>
                <p class="text-xs text-stone-500">Pratinjau Format Dokumen Berita Acara & Notulensi</p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="<?= base_url('rapat/' . $meeting['id'] . '/notula') ?>" class="px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-800 rounded-xl font-semibold text-xs border border-stone-300 flex items-center gap-1.5">
                <i data-lucide="edit-3" class="w-4 h-4"></i>
                <span>Edit Notula</span>
            </a>
            <a href="<?= base_url('export/print-dokumen/' . $meeting['id']) ?>" target="_blank" class="px-4 py-2 bg-kowpi-700 hover:bg-kowpi-800 text-white rounded-xl font-bold text-xs shadow flex items-center gap-1.5">
                <i data-lucide="printer" class="w-4 h-4 text-gold-light"></i>
                <span>Cetak / PDF Dokumen</span>
            </a>
        </div>
    </div>

    <!-- Official Document Sheet Container -->
    <div class="bg-white rounded-3xl border border-paper-200 shadow-xl p-8 md:p-12 space-y-8 text-stone-900 font-sans">
        
        <!-- Official Kop Surat KOWPI -->
        <div class="border-b-2 border-kowpi-900 pb-5 flex items-center gap-6">
            <img src="<?= base_url($settings['org_logo'] ?? 'img/logo-kowpi-coklat.png') ?>" alt="Logo KOWPI" class="h-20 w-auto shrink-0">
            <div class="flex-1">
                <h1 class="font-serif-kowpi font-bold text-xl md:text-2xl text-kowpi-950 leading-tight tracking-wide">
                    <?= esc($settings['org_name'] ?? 'Komunitas Waris Planning Indonesia (KOWPI)') ?>
                </h1>
                <p class="text-xs font-semibold text-gold-dark mt-0.5">
                    <?= esc($settings['org_tagline'] ?? 'Menata kehidupan dengan baik, mempersiapkan akhir yang mulia.') ?>
                </p>
                <p class="text-[11px] text-stone-600 mt-1 leading-snug">
                    Alamat : <?= esc($settings['org_address'] ?? 'Jl. Nangka 1 No.154 Karangnongko, Maguwoharjo, Depok, Sleman') ?>
                    <br>
                    Website : <?= esc($settings['org_website'] ?? 'https://kowpi.id') ?> | Email : <?= esc($settings['org_email'] ?? 'sekretariat@kowpi.id') ?> | Telp : <?= esc($settings['org_phone'] ?? '0812-0000-0000') ?>
                </p>
            </div>
        </div>

        <!-- Judul Berita Acara -->
        <div class="text-center space-y-1">
            <h2 class="font-serif-kowpi font-bold text-lg md:text-xl text-stone-950 uppercase tracking-wide">
                NOTULA & BERITA ACARA RAPAT
            </h2>
            <p class="text-xs font-mono font-bold text-kowpi-800">
                Nomor: <?= esc($meeting['meeting_code']) ?>
            </p>
        </div>

        <!-- Metadata Ringkasan Rapat -->
        <div class="bg-stone-50 border border-stone-200 rounded-2xl p-5 text-xs">
            <table class="w-full">
                <tr class="border-b border-stone-200/80">
                    <td class="py-1.5 font-bold text-stone-600 w-36">Agenda Rapat</td>
                    <td class="py-1.5 font-bold text-stone-900">: <?= esc($meeting['title']) ?></td>
                </tr>
                <tr class="border-b border-stone-200/80">
                    <td class="py-1.5 font-bold text-stone-600">Hari, Tanggal</td>
                    <td class="py-1.5 text-stone-800">: <?= date('l, d F Y', strtotime($meeting['meeting_date'])) ?></td>
                </tr>
                <tr class="border-b border-stone-200/80">
                    <td class="py-1.5 font-bold text-stone-600">Waktu Pelaksanaan</td>
                    <td class="py-1.5 text-stone-800">: <?= substr($meeting['start_time'], 0, 5) ?> - <?= substr($meeting['end_time'], 0, 5) ?> WIB</td>
                </tr>
                <tr class="border-b border-stone-200/80">
                    <td class="py-1.5 font-bold text-stone-600">Tempat / Media</td>
                    <td class="py-1.5 text-stone-800">: <?= esc($meeting['location']) ?> (<?= ucfirst($meeting['meeting_type']) ?>)</td>
                </tr>
                <tr class="border-b border-stone-200/80">
                    <td class="py-1.5 font-bold text-stone-600">Pimpinan Rapat</td>
                    <td class="py-1.5 text-stone-800">: <?= esc($meeting['leader_name']) ?> (<?= esc($meeting['leader_title']) ?>)</td>
                </tr>
                <tr>
                    <td class="py-1.5 font-bold text-stone-600">Notulis</td>
                    <td class="py-1.5 text-stone-800">: <?= esc($meeting['notary_name']) ?> (Sekretariat KOWPI)</td>
                </tr>
            </table>
        </div>

        <!-- 1. Agenda Susunan -->
        <div class="space-y-2 text-xs leading-relaxed">
            <h3 class="font-serif-kowpi font-bold text-sm text-kowpi-900 border-b border-paper-200 pb-1">
                I. AGENDA SUSUNAN RAPAT
            </h3>
            <div class="whitespace-pre-line text-stone-800 pl-4">
                <?= esc($meeting['agenda']) ?>
            </div>
        </div>

        <!-- 2. Pembukaan -->
        <?php if (!empty($minutes['opening_notes'])): ?>
            <div class="space-y-2 text-xs leading-relaxed">
                <h3 class="font-serif-kowpi font-bold text-sm text-kowpi-900 border-b border-paper-200 pb-1">
                    II. PEMBUKAAN & PENGANTAR PIMPINAN RAPAT
                </h3>
                <div class="whitespace-pre-line text-stone-800 pl-4">
                    <?= esc($minutes['opening_notes']) ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- 3. Pembahasan -->
        <?php if (!empty($minutes['discussion'])): ?>
            <div class="space-y-2 text-xs leading-relaxed">
                <h3 class="font-serif-kowpi font-bold text-sm text-kowpi-900 border-b border-paper-200 pb-1">
                    III. POKOK-POKOK PEMBAHASAN RAPAT
                </h3>
                <div class="whitespace-pre-line text-stone-800 pl-4 font-mono text-[11px]">
                    <?= esc($minutes['discussion']) ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- 4. Keputusan & Kesepakatan -->
        <?php if (!empty($minutes['decisions'])): ?>
            <div class="space-y-2 text-xs leading-relaxed">
                <h3 class="font-serif-kowpi font-bold text-sm text-kowpi-900 border-b border-paper-200 pb-1">
                    IV. KEPUTUSAN & KESEPAKATAN RESMI
                </h3>
                <div class="p-4 bg-kowpi-50/50 border border-kowpi-200 rounded-2xl whitespace-pre-line text-stone-900 font-medium">
                    <?= esc($minutes['decisions']) ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- 5. Rencana Tindak Lanjut -->
        <?php if (!empty($actionItems)): ?>
            <div class="space-y-2 text-xs leading-relaxed">
                <h3 class="font-serif-kowpi font-bold text-sm text-kowpi-900 border-b border-paper-200 pb-1">
                    V. RENCANA TINDAK LANJUT (ACTION ITEMS)
                </h3>
                <table class="w-full border border-stone-200 text-left text-xs rounded-xl overflow-hidden">
                    <thead class="bg-stone-100 font-bold text-stone-700">
                        <tr>
                            <th class="p-2.5">No</th>
                            <th class="p-2.5">Uraian Tugas / Tindak Lanjut</th>
                            <th class="p-2.5">Penanggung Jawab (PIC)</th>
                            <th class="p-2.5">Tenggat Waktu</th>
                            <th class="p-2.5">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200">
                        <?php $no = 1; foreach ($actionItems as $item): ?>
                            <tr>
                                <td class="p-2.5 text-center text-stone-500"><?= $no++ ?></td>
                                <td class="p-2.5 font-bold text-stone-900"><?= esc($item['task'] ?? '') ?></td>
                                <td class="p-2.5 text-stone-700"><?= esc($item['pic'] ?? '') ?></td>
                                <td class="p-2.5 text-stone-600 font-mono"><?= !empty($item['deadline']) ? date('d/m/Y', strtotime($item['deadline'])) : '-' ?></td>
                                <td class="p-2.5">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-900">
                                        <?= esc($item['status'] ?? 'Dalam Proses') ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <!-- 6. Penutup -->
        <?php if (!empty($minutes['closing_notes'])): ?>
            <div class="space-y-2 text-xs leading-relaxed">
                <h3 class="font-serif-kowpi font-bold text-sm text-kowpi-900 border-b border-paper-200 pb-1">
                    VI. PENUTUP
                </h3>
                <div class="whitespace-pre-line text-stone-800 pl-4">
                    <?= esc($minutes['closing_notes']) ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Lembar Tanda Tangan & Stempel Pengesahan -->
        <div class="pt-8 border-t border-paper-200">
            <p class="text-right text-xs text-stone-600 mb-6">
                Yogyakarta, <?= date('d F Y', strtotime($meeting['meeting_date'])) ?>
            </p>

            <div class="grid grid-cols-2 gap-8 text-center text-xs relative">
                <!-- Stempel KOWPI Overlay in Center -->
                <?php if (!empty($minutes['include_stamp']) && !empty($settings['org_stamp'])): ?>
                    <div class="absolute left-1/2 top-4 -translate-x-1/2 pointer-events-none opacity-80 z-10">
                        <img src="<?= base_url($settings['org_stamp']) ?>" alt="Stempel Resmi" class="h-28 w-auto">
                    </div>
                <?php endif; ?>

                <!-- Pimpinan -->
                <div class="space-y-2 flex flex-col items-center">
                    <span class="font-bold text-stone-700 uppercase tracking-wider text-[11px]">Pimpinan Rapat,</span>
                    <div class="h-24 flex items-center justify-center">
                        <?php if (!empty($minutes['leader_signature'])): ?>
                            <img src="<?= base_url($minutes['leader_signature']) ?>" alt="TTD Pimpinan" class="h-20 max-w-[180px] object-contain">
                        <?php else: ?>
                            <div class="text-stone-300 italic text-[11px]">[Tanda Tangan Digital]</div>
                        <?php endif; ?>
                    </div>
                    <strong class="font-serif-kowpi font-bold text-sm text-stone-950 underline underline-offset-4">
                        <?= esc($meeting['leader_name']) ?>
                    </strong>
                    <span class="text-[11px] text-stone-500"><?= esc($meeting['leader_title']) ?></span>
                </div>

                <!-- Notulis -->
                <div class="space-y-2 flex flex-col items-center">
                    <span class="font-bold text-stone-700 uppercase tracking-wider text-[11px]">Notulis / Sekretaris,</span>
                    <div class="h-24 flex items-center justify-center">
                        <?php if (!empty($minutes['notary_signature'])): ?>
                            <img src="<?= base_url($minutes['notary_signature']) ?>" alt="TTD Notulis" class="h-20 max-w-[180px] object-contain">
                        <?php else: ?>
                            <div class="text-stone-300 italic text-[11px]">[Tanda Tangan Digital]</div>
                        <?php endif; ?>
                    </div>
                    <strong class="font-serif-kowpi font-bold text-sm text-stone-950 underline underline-offset-4">
                        <?= esc($meeting['notary_name']) ?>
                    </strong>
                    <span class="text-[11px] text-stone-500">Sekretariat KOWPI</span>
                </div>
            </div>
        </div>

    </div>

</div>
<?= $this->endSection() ?>

