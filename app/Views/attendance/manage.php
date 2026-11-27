<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-7xl mx-auto">

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
                    <span class="text-xs text-stone-500">Presensi Rapat</span>
                </div>
                <h2 class="font-serif-kowpi font-bold text-xl md:text-2xl text-kowpi-950 mt-1">
                    Daftar Kehadiran Peserta (TTD Digital)
                </h2>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <!-- Tombol Tambah Peserta Manual Modal -->
            <button type="button" onclick="openAddModal()" class="px-3.5 py-2 rounded-xl bg-kowpi-700 hover:bg-kowpi-800 text-white font-semibold text-xs shadow transition-all flex items-center gap-1.5">
                <i data-lucide="user-plus" class="w-4 h-4 text-gold-light"></i>
                <span>Tambah Peserta</span>
            </button>

            <!-- Ekspor Excel -->
            <a href="<?= base_url('kehadiran/export-excel/' . $meeting['id']) ?>"
               class="px-3.5 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-xs shadow transition-all flex items-center gap-1.5">
                <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                <span>Ekspor Excel</span>
            </a>

            <!-- Meja Presensi -->
            <a href="<?= base_url('presensi/' . $meeting['meeting_code']) ?>" target="_blank"
               class="px-3.5 py-2 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-300 font-bold text-xs flex items-center gap-1.5">
                <i data-lucide="pen-tool" class="w-4 h-4 text-amber-700"></i>
                <span>Buka Meja Presensi</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-4 border border-paper-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] text-stone-400 font-bold uppercase">Total Terdata</span>
                <div class="text-2xl font-extrabold text-kowpi-900"><?= count($attendances) ?></div>
            </div>
            <div class="p-2.5 rounded-xl bg-stone-100 text-stone-700">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-paper-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] text-stone-400 font-bold uppercase">Hadir Offline</span>
                <div class="text-2xl font-extrabold text-amber-800"><?= $meeting['total_offline'] ?? 0 ?></div>
            </div>
            <div class="p-2.5 rounded-xl bg-amber-50 text-amber-700">
                <i data-lucide="building" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-paper-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] text-stone-400 font-bold uppercase">Hadir Online</span>
                <div class="text-2xl font-extrabold text-emerald-800"><?= $meeting['total_online'] ?? 0 ?></div>
            </div>
            <div class="p-2.5 rounded-xl bg-emerald-50 text-emerald-700">
                <i data-lucide="video" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 border border-paper-200 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] text-stone-400 font-bold uppercase">Izin / Sakit</span>
                <div class="text-2xl font-extrabold text-stone-700"><?= ($meeting['total_izin'] ?? 0) + ($meeting['total_sakit'] ?? 0) ?></div>
            </div>
            <div class="p-2.5 rounded-xl bg-stone-100 text-stone-500">
                <i data-lucide="calendar-x" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <!-- Attendees Table Card -->
    <div class="bg-white rounded-3xl border border-paper-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-paper-200 flex flex-wrap items-center justify-between gap-4">
            <h3 class="font-serif-kowpi font-bold text-base text-kowpi-900">
                Data Peserta & Tanda Tangan Digital
            </h3>

            <!-- Search Form -->
            <form method="GET" action="<?= current_url() ?>" class="flex items-center gap-2">
                <div class="relative">
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" placeholder="Cari nama / instansi..." 
                           class="pl-8 pr-3 py-1.5 border border-stone-300 rounded-lg text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                    <i data-lucide="search" class="w-3.5 h-3.5 text-stone-400 absolute left-2.5 top-2"></i>
                </div>
                <button type="submit" class="px-3 py-1.5 bg-stone-800 text-white rounded-lg text-xs font-semibold hover:bg-stone-900">
                    Cari
                </button>
                <?php if (!empty($search)): ?>
                    <a href="<?= current_url() ?>" class="px-2 py-1.5 text-xs text-stone-500 hover:text-stone-800">Reset</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-stone-50 text-stone-500 font-semibold border-b border-paper-200">
                    <tr>
                        <th class="py-3 px-4 text-center w-12">No</th>
                        <th class="py-3 px-4">Nama Peserta</th>
                        <th class="py-3 px-4">Instansi / Divisi</th>
                        <th class="py-3 px-4">Kontak</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-center">Tanda Tangan</th>
                        <th class="py-3 px-4 text-center">Waktu Presensi</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-paper-200">
                    <?php if (empty($attendances)): ?>
                        <tr>
                            <td colspan="8" class="py-10 text-center text-stone-400">
                                Belum ada peserta yang mengisi presensi rapat ini.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($attendances as $att): ?>
                            <tr class="hover:bg-kowpi-50/40 transition-colors">
                                <td class="py-3 px-4 text-center text-stone-400 font-mono"><?= $no++ ?></td>
                                <td class="py-3 px-4 font-bold text-stone-900">
                                    <?= esc($att['participant_name']) ?>
                                    <?php if (!empty($att['notes'])): ?>
                                        <div class="text-[10px] text-stone-400 font-normal italic mt-0.5">
                                            "<?= esc($att['notes']) ?>"
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4 text-stone-700">
                                    <?= esc($att['institution'] ?? '-') ?>
                                </td>
                                <td class="py-3 px-4 text-stone-600">
                                    <?php if (!empty($att['phone'])): ?>
                                        <div class="font-mono text-[11px]"><?= esc($att['phone']) ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($att['email'])): ?>
                                        <div class="text-[10px] text-stone-400"><?= esc($att['email']) ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4 text-center whitespace-nowrap">
                                    <?php if ($att['attendance_status'] === 'hadir_offline'): ?>
                                        <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-900 font-bold text-[10px]">
                                            Hadir Offline
                                        </span>
                                    <?php elseif ($att['attendance_status'] === 'hadir_online'): ?>
                                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-900 font-bold text-[10px]">
                                            Hadir Online
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2.5 py-0.5 rounded-full bg-stone-200 text-stone-700 font-bold text-[10px]">
                                            <?= ucwords(str_replace('_', ' ', $att['attendance_status'])) ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4 text-center whitespace-nowrap">
                                    <?php if (!empty($att['signature_image'])): ?>
                                        <button type="button" onclick="previewSig('<?= base_url($att['signature_image']) ?>', '<?= esc($att['participant_name']) ?>')"
                                                class="inline-block p-1 bg-white border border-stone-200 rounded-lg shadow-sm hover:border-kowpi-600 transition-colors" title="Klik untuk memperbesar tanda tangan">
                                            <img src="<?= base_url($att['signature_image']) ?>" alt="TTD" class="h-8 max-w-[80px] object-contain">
                                        </button>
                                    <?php else: ?>
                                        <span class="text-stone-300 italic text-[11px]">- Belum TTD -</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4 text-center text-stone-600 whitespace-nowrap">
                                    <div class="font-mono font-medium"><?= date('H:i:s', strtotime($att['check_in_time'])) ?></div>
                                    <div class="text-[10px] text-stone-400"><?= date('d/m/Y', strtotime($att['check_in_time'])) ?></div>
                                </td>
                                <td class="py-3 px-4 text-right whitespace-nowrap">
                                    <a href="<?= base_url('kehadiran/delete/' . $att['id']) ?>"
                                       onclick="return confirm('Hapus presensi peserta <?= esc($att['participant_name']) ?>?')"
                                       class="p-1.5 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 inline-block transition-colors" title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal: Zoom Signature -->
<div id="sigModal" class="fixed inset-0 z-50 bg-black/70 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-6 max-w-sm w-full text-center shadow-2xl space-y-4">
        <h4 id="sigModalTitle" class="font-serif-kowpi font-bold text-base text-kowpi-900">
            Tanda Tangan Digital
        </h4>
        <div class="bg-stone-50 border border-stone-200 rounded-2xl p-4 flex items-center justify-center min-h-[160px]">
            <img id="sigModalImg" src="" alt="TTD Zoom" class="max-h-40 max-w-full object-contain">
        </div>
        <button type="button" onclick="closeSigModal()" class="w-full py-2.5 bg-stone-800 text-white rounded-xl text-xs font-bold hover:bg-stone-900 transition-colors">
            Tutup
        </button>
    </div>
</div>

<!-- Modal: Tambah Peserta Manual -->
<div id="addModal" class="fixed inset-0 z-50 bg-black/70 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-6 max-w-lg w-full shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-paper-200 pb-3">
            <h4 class="font-serif-kowpi font-bold text-base text-kowpi-900">
                Tambah Peserta Kehadiran Manual
            </h4>
            <button type="button" onclick="closeAddModal()" class="text-stone-400 hover:text-stone-700">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="<?= base_url('rapat/' . $meeting['id'] . '/kehadiran/add') ?>" method="POST" class="space-y-4 text-xs">
            <div>
                <label class="block text-stone-700 font-bold mb-1">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                <input type="text" name="participant_name" required placeholder="Nama lengkap peserta..."
                       class="w-full px-3 py-2 border border-stone-300 rounded-xl focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-stone-700 font-bold mb-1">Instansi / Divisi</label>
                    <input type="text" name="institution" placeholder="Contoh: KOWPI / UII"
                           class="w-full px-3 py-2 border border-stone-300 rounded-xl focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                </div>
                <div>
                    <label class="block text-stone-700 font-bold mb-1">Status Kehadiran</label>
                    <select name="attendance_status" class="w-full px-3 py-2 border border-stone-300 rounded-xl focus:ring-1 focus:ring-kowpi-600 focus:outline-none bg-white">
                        <option value="hadir_offline">Hadir Offline</option>
                        <option value="hadir_online">Hadir Online</option>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-stone-700 font-bold mb-1">No. WhatsApp</label>
                    <input type="tel" name="phone" placeholder="0812..."
                           class="w-full px-3 py-2 border border-stone-300 rounded-xl focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                </div>
                <div>
                    <label class="block text-stone-700 font-bold mb-1">Email</label>
                    <input type="email" name="email" placeholder="email@..."
                           class="w-full px-3 py-2 border border-stone-300 rounded-xl focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-stone-700 font-bold mb-1">Catatan</label>
                <input type="text" name="notes" placeholder="Catatan kehadiran..."
                       class="w-full px-3 py-2 border border-stone-300 rounded-xl focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
            </div>

            <div class="pt-3 border-t border-paper-200 flex justify-end gap-2">
                <button type="button" onclick="closeAddModal()" class="px-4 py-2 border border-stone-300 rounded-xl text-stone-600 font-semibold hover:bg-stone-50">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 bg-kowpi-700 hover:bg-kowpi-800 text-white rounded-xl font-bold shadow">
                    Simpan Peserta
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewSig(imgUrl, name) {
        document.getElementById('sigModalImg').src = imgUrl;
        document.getElementById('sigModalTitle').innerText = 'TTD: ' + name;
        const modal = document.getElementById('sigModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeSigModal() {
        const modal = document.getElementById('sigModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function openAddModal() {
        const modal = document.getElementById('addModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeAddModal() {
        const modal = document.getElementById('addModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
<?= $this->endSection() ?>

