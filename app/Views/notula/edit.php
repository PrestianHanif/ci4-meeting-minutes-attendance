<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-5xl mx-auto">

    <!-- Header Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="<?= base_url('rapat/detail/' . $meeting['id']) ?>" class="p-2 rounded-xl bg-white border border-stone-200 text-stone-600 hover:bg-stone-50 transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <span class="font-mono text-xs font-bold text-gold-dark bg-amber-50 px-2.5 py-0.5 rounded border border-amber-200">
                        <?= esc($meeting['meeting_code']) ?>
                    </span>
                    <span class="text-xs text-stone-500">Notulensi Rapat</span>
                </div>
                <h2 class="font-serif-kowpi font-bold text-xl md:text-2xl text-kowpi-950 mt-1">
                    Penyusunan Notula & Keputusan Resmi
                </h2>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="<?= base_url('rapat/' . $meeting['id'] . '/notula/view') ?>" target="_blank"
               class="px-3.5 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-800 font-semibold text-xs border border-stone-300 flex items-center gap-1.5 transition-colors">
                <i data-lucide="eye" class="w-4 h-4 text-stone-600"></i>
                <span>Preview Dokumen</span>
            </a>
            <a href="<?= base_url('export/print-dokumen/' . $meeting['id']) ?>" target="_blank"
               class="px-3.5 py-2 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-300 font-bold text-xs flex items-center gap-1.5 transition-colors">
                <i data-lucide="printer" class="w-4 h-4 text-amber-700"></i>
                <span>Cetak PDF</span>
            </a>
        </div>
    </div>

    <!-- Main Notula Form -->
    <form id="notulaForm" action="<?= base_url('rapat/' . $meeting['id'] . '/notula/save') ?>" method="POST" class="space-y-6 text-xs">
        
        <!-- Section 1: Pembukaan & Pengantar -->
        <div class="bg-white rounded-3xl border border-paper-200 shadow-sm p-6 space-y-3">
            <div class="flex items-center justify-between border-b border-paper-200 pb-3">
                <h3 class="font-serif-kowpi font-bold text-sm text-kowpi-900 flex items-center gap-2">
                    <i data-lucide="book-open" class="w-4 h-4 text-gold"></i>
                    1. Pembukaan & Pengantar Pimpinan Rapat
                </h3>
                <span class="text-[11px] text-stone-400">Pimpinan: <strong><?= esc($meeting['leader_name']) ?></strong></span>
            </div>
            <p class="text-stone-500 text-[11px]">
                Catat pengantar jalannya rapat, doa pembuka, dan arahan umum dari Pimpinan Rapat:
            </p>
            <textarea name="opening_notes" rows="4"
                      placeholder="Rapat dibuka pukul 09.00 WIB oleh Pimpinan Rapat dengan membaca Basmalah dan Al-Fatihah..."
                      class="w-full p-4 border border-stone-300 rounded-2xl text-xs leading-relaxed focus:ring-2 focus:ring-kowpi-600 focus:outline-none"><?= esc($minutes['opening_notes']) ?></textarea>
        </div>

        <!-- Section 2: Poin-Poin Pembahasan Rapat -->
        <div class="bg-white rounded-3xl border border-paper-200 shadow-sm p-6 space-y-3">
            <div class="flex items-center justify-between border-b border-paper-200 pb-3">
                <h3 class="font-serif-kowpi font-bold text-sm text-kowpi-900 flex items-center gap-2">
                    <i data-lucide="message-square" class="w-4 h-4 text-gold"></i>
                    2. Poin-Poin Pembahasan & Dinamika Rapat
                </h3>
                <span class="text-[11px] text-stone-400">Jalannya Diskusi</span>
            </div>
            <p class="text-stone-500 text-[11px]">
                Tuliskan topik bahasan, paparan materi, serta tanggapan dan masukan dari para pengurus/peserta:
            </p>
            <textarea name="discussion" rows="8"
                      placeholder="1. Evaluasi Program Kerja:&#10;- Hasil capaian bulan berjalan...&#10;- Masukan dari perwakilan divisi litbang...&#10;&#10;2. Pembahasan Program Waris KOWPI:&#10;-..."
                      class="w-full p-4 border border-stone-300 rounded-2xl text-xs font-mono leading-relaxed focus:ring-2 focus:ring-kowpi-600 focus:outline-none"><?= esc($minutes['discussion']) ?></textarea>
        </div>

        <!-- Section 3: Keputusan & Kesepakatan Resmi -->
        <div class="bg-white rounded-3xl border border-paper-200 shadow-sm p-6 space-y-3">
            <div class="flex items-center justify-between border-b border-paper-200 pb-3">
                <h3 class="font-serif-kowpi font-bold text-sm text-kowpi-900 flex items-center gap-2">
                    <i data-lucide="check-circle-2" class="w-4 h-4 text-gold"></i>
                    3. Keputusan & Kesimpulan Resmi Rapat
                </h3>
                <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-800 font-bold text-[10px] border border-emerald-200">
                    Ketetapan Bersama
                </span>
            </div>
            <p class="text-stone-500 text-[11px]">
                Rumuskan poin-poin keputusan rapat secara tegas dan mengikat yang disepakati oleh seluruh peserta rapat:
            </p>
            <textarea name="decisions" rows="6"
                      placeholder="1. Menyetujui penerbitan Modul Panduan Waris Ramah Keluarga...&#10;2. Mengagendakan webinar nasional mitigasi sengketa waris...&#10;3. ..."
                      class="w-full p-4 border border-stone-300 rounded-2xl text-xs font-mono leading-relaxed focus:ring-2 focus:ring-kowpi-600 focus:outline-none"><?= esc($minutes['decisions']) ?></textarea>
        </div>

        <!-- Section 4: Rencana Tindak Lanjut (Action Items) Table -->
        <div class="bg-white rounded-3xl border border-paper-200 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-paper-200 pb-3">
                <h3 class="font-serif-kowpi font-bold text-sm text-kowpi-900 flex items-center gap-2">
                    <i data-lucide="list-todo" class="w-4 h-4 text-gold"></i>
                    4. Rencana Tindak Lanjut / Action Items (Tugas & PIC)
                </h3>
                <button type="button" onclick="addActionItemRow()"
                        class="px-3 py-1.5 rounded-lg bg-stone-100 hover:bg-kowpi-50 text-kowpi-800 border border-stone-300 font-bold text-xs flex items-center gap-1 transition-colors">
                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                    <span>Tambah Baris Tugas</span>
                </button>
            </div>
            <p class="text-stone-500 text-[11px]">
                Daftar tugas terstruktur, penanggung jawab (PIC), dan batas waktu penyelesaian:
            </p>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border border-stone-200 rounded-xl overflow-hidden">
                    <thead class="bg-stone-50 text-stone-600 font-bold border-b border-stone-200">
                        <tr>
                            <th class="py-2.5 px-3">Uraian Tugas / Tindak Lanjut</th>
                            <th class="py-2.5 px-3 w-48">Penanggung Jawab (PIC)</th>
                            <th class="py-2.5 px-3 w-36">Tenggat Waktu</th>
                            <th class="py-2.5 px-3 w-36">Status</th>
                            <th class="py-2.5 px-3 w-12 text-center">Hapus</th>
                        </tr>
                    </thead>
                    <tbody id="actionItemsBody" class="divide-y divide-stone-200">
                        <?php if (empty($actionItems)): ?>
                            <tr class="action-item-row">
                                <td class="p-2">
                                    <input type="text" name="action_task[]" placeholder="Deskripsi tugas..."
                                           class="w-full p-2 border border-stone-300 rounded-lg text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                                </td>
                                <td class="p-2">
                                    <input type="text" name="action_pic[]" placeholder="Nama / Divisi..."
                                           class="w-full p-2 border border-stone-300 rounded-lg text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                                </td>
                                <td class="p-2">
                                    <input type="date" name="action_deadline[]"
                                           class="w-full p-2 border border-stone-300 rounded-lg text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                                </td>
                                <td class="p-2">
                                    <select name="action_status[]" class="w-full p-2 border border-stone-300 rounded-lg text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none bg-white">
                                        <option value="Dalam Proses" selected>Dalam Proses</option>
                                        <option value="Belum Dimulai">Belum Dimulai</option>
                                        <option value="Selesai">Selesai</option>
                                    </select>
                                </td>
                                <td class="p-2 text-center">
                                    <button type="button" onclick="removeActionItemRow(this)" class="text-rose-500 hover:text-rose-700 p-1">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($actionItems as $item): ?>
                                <tr class="action-item-row">
                                    <td class="p-2">
                                        <input type="text" name="action_task[]" value="<?= esc($item['task'] ?? '') ?>" placeholder="Deskripsi tugas..."
                                               class="w-full p-2 border border-stone-300 rounded-lg text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                                    </td>
                                    <td class="p-2">
                                        <input type="text" name="action_pic[]" value="<?= esc($item['pic'] ?? '') ?>" placeholder="Nama / Divisi..."
                                               class="w-full p-2 border border-stone-300 rounded-lg text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                                    </td>
                                    <td class="p-2">
                                        <input type="date" name="action_deadline[]" value="<?= esc($item['deadline'] ?? '') ?>"
                                               class="w-full p-2 border border-stone-300 rounded-lg text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                                    </td>
                                    <td class="p-2">
                                        <select name="action_status[]" class="w-full p-2 border border-stone-300 rounded-lg text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none bg-white">
                                            <option value="Dalam Proses" <?= ($item['status'] ?? '') === 'Dalam Proses' ? 'selected' : '' ?>>Dalam Proses</option>
                                            <option value="Belum Dimulai" <?= ($item['status'] ?? '') === 'Belum Dimulai' ? 'selected' : '' ?>>Belum Dimulai</option>
                                            <option value="Selesai" <?= ($item['status'] ?? '') === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                                        </select>
                                    </td>
                                    <td class="p-2 text-center">
                                        <button type="button" onclick="removeActionItemRow(this)" class="text-rose-500 hover:text-rose-700 p-1">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Section 5: Penutup -->
        <div class="bg-white rounded-3xl border border-paper-200 shadow-sm p-6 space-y-3">
            <div class="flex items-center justify-between border-b border-paper-200 pb-3">
                <h3 class="font-serif-kowpi font-bold text-sm text-kowpi-900 flex items-center gap-2">
                    <i data-lucide="bookmark-check" class="w-4 h-4 text-gold"></i>
                    5. Penutup & Doa Bersama
                </h3>
            </div>
            <textarea name="closing_notes" rows="3"
                      placeholder="Rapat ditutup tepat pada pukul 12.00 WIB dengan doa kafaratul majelis..."
                      class="w-full p-4 border border-stone-300 rounded-2xl text-xs leading-relaxed focus:ring-2 focus:ring-kowpi-600 focus:outline-none"><?= esc($minutes['closing_notes']) ?></textarea>
        </div>

        <!-- Section 6: Pengesahan & Tanda Tangan Digital Pimpinan & Notulis -->
        <div class="bg-white rounded-3xl border border-paper-200 shadow-sm p-6 space-y-6">
            <div class="flex items-center justify-between border-b border-paper-200 pb-3">
                <div>
                    <h3 class="font-serif-kowpi font-bold text-sm text-kowpi-900 flex items-center gap-2">
                        <i data-lucide="signature" class="w-4 h-4 text-gold"></i>
                        6. Lembar Pengesahan & Tanda Tangan Digital
                    </h3>
                    <p class="text-stone-500 text-[11px] mt-0.5">
                        Tanda tangan resmi dari Pimpinan Rapat dan Notulis untuk validasi dokumen
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <label class="flex items-center gap-2 text-stone-700 cursor-pointer">
                        <input type="checkbox" name="include_stamp" value="1" <?= !empty($minutes['include_stamp']) ? 'checked' : '' ?>
                               class="rounded border-stone-300 text-kowpi-700 focus:ring-kowpi-600 w-4 h-4">
                        <span class="font-semibold text-xs">Bubuhkan Stempel KOWPI</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- TTD Pimpinan Rapat -->
                <div class="p-5 rounded-2xl bg-stone-50 border border-stone-200 space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-stone-400 uppercase tracking-wider block font-bold">Pimpinan Rapat</span>
                            <strong class="text-xs text-stone-900"><?= esc($meeting['leader_name']) ?></strong>
                            <div class="text-[10px] text-stone-500"><?= esc($meeting['leader_title']) ?></div>
                        </div>
                        <?php if (!empty($minutes['is_signed_leader'])): ?>
                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px]">
                                &check; Terverifikasi
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Existing Signature Preview -->
                    <?php if (!empty($minutes['leader_signature'])): ?>
                        <div class="bg-white border border-stone-200 rounded-xl p-3 flex flex-col items-center justify-center">
                            <img id="imgSigLeader" src="<?= base_url($minutes['leader_signature']) ?>" alt="TTD Pimpinan" class="h-20 max-w-full object-contain">
                            <span class="text-[10px] text-stone-400 mt-1">Tanda Tangan Tersimpan</span>
                        </div>
                    <?php endif; ?>

                    <!-- Signature Pad for Leader -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[11px] font-semibold text-stone-600">Goreskan Tanda Tangan Baru:</span>
                            <button type="button" onclick="clearLeaderPad()" class="text-rose-600 text-[10px] font-bold hover:underline">
                                Hapus / Bersihkan
                            </button>
                        </div>
                        <div class="bg-white border-2 border-dashed border-stone-300 rounded-xl overflow-hidden">
                            <canvas id="padLeader" class="w-full h-28 block cursor-crosshair"></canvas>
                        </div>
                        <input type="hidden" name="sig_leader_data" id="sigLeaderData">
                    </div>
                </div>

                <!-- TTD Notulis Rapat -->
                <div class="p-5 rounded-2xl bg-stone-50 border border-stone-200 space-y-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-[10px] text-stone-400 uppercase tracking-wider block font-bold">Notulis / Sekretaris</span>
                            <strong class="text-xs text-stone-900"><?= esc($meeting['notary_name']) ?></strong>
                            <div class="text-[10px] text-stone-500">Sekretariat KOWPI</div>
                        </div>
                        <?php if (!empty($minutes['is_signed_notary'])): ?>
                            <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px]">
                                &check; Terverifikasi
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Existing Signature Preview -->
                    <?php if (!empty($minutes['notary_signature'])): ?>
                        <div class="bg-white border border-stone-200 rounded-xl p-3 flex flex-col items-center justify-center">
                            <img id="imgSigNotary" src="<?= base_url($minutes['notary_signature']) ?>" alt="TTD Notulis" class="h-20 max-w-full object-contain">
                            <span class="text-[10px] text-stone-400 mt-1">Tanda Tangan Tersimpan</span>
                        </div>
                    <?php endif; ?>

                    <!-- Signature Pad for Notary -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[11px] font-semibold text-stone-600">Goreskan Tanda Tangan Baru:</span>
                            <button type="button" onclick="clearNotaryPad()" class="text-rose-600 text-[10px] font-bold hover:underline">
                                Hapus / Bersihkan
                            </button>
                        </div>
                        <div class="bg-white border-2 border-dashed border-stone-300 rounded-xl overflow-hidden">
                            <canvas id="padNotary" class="w-full h-28 block cursor-crosshair"></canvas>
                        </div>
                        <input type="hidden" name="sig_notary_data" id="sigNotaryData">
                    </div>
                </div>

            </div>
        </div>

        <!-- Sticky Bottom Bar -->
        <div class="p-4 bg-white/95 backdrop-blur border border-paper-200 rounded-2xl shadow-lg flex items-center justify-between sticky bottom-4 z-20">
            <div class="text-xs text-stone-500">
                Terakhir disimpan: <?= date('d M Y H:i', strtotime($minutes['updated_at'] ?? 'now')) ?> WIB
            </div>

            <div class="flex items-center gap-3">
                <a href="<?= base_url('rapat/detail/' . $meeting['id']) ?>" class="px-4 py-2 border border-stone-300 rounded-xl text-stone-600 font-semibold hover:bg-stone-50 transition-colors">
                    Kembali
                </a>
                <button type="submit" class="px-6 py-2.5 bg-kowpi-700 hover:bg-kowpi-800 text-white font-extrabold rounded-xl shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4 text-gold-light"></i>
                    <span>Simpan Notula Resmi</span>
                </button>
            </div>
        </div>
    </form>

</div>

<script>
    let leaderPad, notaryPad;

    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') lucide.createIcons();

        // Setup Leader Pad
        const canvasL = document.getElementById('padLeader');
        if (canvasL) {
            leaderPad = new SignaturePad(canvasL, {
                backgroundColor: 'rgba(255, 255, 255, 0)',
                penColor: '#0f172a',
                minWidth: 1.5,
                maxWidth: 3.5,
            });
            resizePad(canvasL);
        }

        // Setup Notary Pad
        const canvasN = document.getElementById('padNotary');
        if (canvasN) {
            notaryPad = new SignaturePad(canvasN, {
                backgroundColor: 'rgba(255, 255, 255, 0)',
                penColor: '#0f172a',
                minWidth: 1.5,
                maxWidth: 3.5,
            });
            resizePad(canvasN);
        }

        function resizePad(c) {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            const rect = c.getBoundingClientRect();
            c.width = rect.width * ratio;
            c.height = rect.height * ratio;
            const ctx = c.getContext('2d');
            ctx.scale(ratio, ratio);
        }

        // Form submit capture
        const form = document.getElementById('notulaForm');
        form.addEventListener('submit', () => {
            if (leaderPad && !leaderPad.isEmpty()) {
                document.getElementById('sigLeaderData').value = leaderPad.toDataURL('image/png');
            }
            if (notaryPad && !notaryPad.isEmpty()) {
                document.getElementById('sigNotaryData').value = notaryPad.toDataURL('image/png');
            }
        });
    });

    function clearLeaderPad() {
        if (leaderPad) leaderPad.clear();
    }

    function clearNotaryPad() {
        if (notaryPad) notaryPad.clear();
    }

    function addActionItemRow() {
        const body = document.getElementById('actionItemsBody');
        const row = `
            <tr class="action-item-row animate-fade-in">
                <td class="p-2">
                    <input type="text" name="action_task[]" placeholder="Deskripsi tugas..."
                           class="w-full p-2 border border-stone-300 rounded-lg text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                </td>
                <td class="p-2">
                    <input type="text" name="action_pic[]" placeholder="Nama / Divisi..."
                           class="w-full p-2 border border-stone-300 rounded-lg text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                </td>
                <td class="p-2">
                    <input type="date" name="action_deadline[]"
                           class="w-full p-2 border border-stone-300 rounded-lg text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                </td>
                <td class="p-2">
                    <select name="action_status[]" class="w-full p-2 border border-stone-300 rounded-lg text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none bg-white">
                        <option value="Dalam Proses" selected>Dalam Proses</option>
                        <option value="Belum Dimulai">Belum Dimulai</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </td>
                <td class="p-2 text-center">
                    <button type="button" onclick="removeActionItemRow(this)" class="text-rose-500 hover:text-rose-700 p-1">
                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                </td>
            </tr>
        `;
        body.insertAdjacentHTML('beforeend', row);
        if (typeof lucide !== 'undefined') lucide.createIcons();
    }

    function removeActionItemRow(btn) {
        const row = btn.closest('tr');
        if (row) row.remove();
    }
</script>
<?= $this->endSection() ?>

