<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header & Back Button -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="<?= base_url('rapat') ?>" class="p-2 rounded-xl bg-white border border-stone-200 text-stone-600 hover:bg-stone-50 transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h2 class="font-serif-kowpi font-bold text-2xl text-kowpi-950">
                    Jadwalkan Rapat Baru
                </h2>
                <p class="text-xs text-stone-500">
                    Susun informasi resmi pertemuan pengurus KOWPI
                </p>
            </div>
        </div>
        <div class="hidden sm:block">
            <span class="text-xs font-mono bg-amber-50 text-amber-900 border border-amber-200 px-3 py-1 rounded-lg font-bold">
                Kode: <?= esc($code) ?>
            </span>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-3xl border border-paper-200 shadow-sm p-6 md:p-8">
        <form action="<?= base_url('rapat/store') ?>" method="POST" class="space-y-6 text-xs">

            <!-- Section 1: Informasi Utama Rapat -->
            <div class="border-b border-paper-200 pb-5">
                <h3 class="font-serif-kowpi font-bold text-sm text-kowpi-800 mb-4 flex items-center gap-2">
                    <i data-lucide="info" class="w-4 h-4 text-gold"></i>
                    Informasi & Identitas Rapat
                </h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                            Judul Agenda Rapat <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="title" required value="<?= old('title') ?>"
                               placeholder="Contoh: Rapat Koordinasi Pleno Pengurus & Evaluasi Program Literasi Waris KOWPI Q4"
                               class="w-full px-4 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-2 focus:ring-kowpi-600 focus:outline-none">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                                Kategori Rapat <span class="text-rose-500">*</span>
                            </label>
                            <select name="category" required class="w-full px-3 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-2 focus:ring-kowpi-600 focus:outline-none bg-white">
                                <option value="Rapat Pleno">Rapat Pleno</option>
                                <option value="Rapat Pimpinan">Rapat Pimpinan</option>
                                <option value="Rapat Koordinasi" selected>Rapat Koordinasi</option>
                                <option value="Rapat Divisi">Rapat Divisi</option>
                                <option value="Rapat Kerja">Rapat Kerja</option>
                                <option value="Rapat Evaluasi">Rapat Evaluasi</option>
                                <option value="Rapat Luar Biasa">Rapat Luar Biasa</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                                Status Awal
                            </label>
                            <select name="status" class="w-full px-3 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-2 focus:ring-kowpi-600 focus:outline-none bg-white">
                                <option value="ongoing" selected>Berlangsung / Aktif (Presensi Langsung Terbuka)</option>
                                <option value="draft">Draft (Persiapan)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Jadwal & Lokasi -->
            <div class="border-b border-paper-200 pb-5">
                <h3 class="font-serif-kowpi font-bold text-sm text-kowpi-800 mb-4 flex items-center gap-2">
                    <i data-lucide="clock" class="w-4 h-4 text-gold"></i>
                    Waktu & Tempat Pelaksanaan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                            Tanggal Rapat <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="meeting_date" required value="<?= old('meeting_date', date('Y-m-d')) ?>"
                               class="w-full px-3 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-2 focus:ring-kowpi-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                            Jam Mulai <span class="text-rose-500">*</span>
                        </label>
                        <input type="time" name="start_time" required value="<?= old('start_time', '09:00') ?>"
                               class="w-full px-3 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-2 focus:ring-kowpi-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                            Jam Selesai <span class="text-rose-500">*</span>
                        </label>
                        <input type="time" name="end_time" required value="<?= old('end_time', '12:00') ?>"
                               class="w-full px-3 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-2 focus:ring-kowpi-600 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                            Tipe Pertemuan <span class="text-rose-500">*</span>
                        </label>
                        <select name="meeting_type" class="w-full px-3 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-2 focus:ring-kowpi-600 focus:outline-none bg-white">
                            <option value="offline" selected>Tatap Muka (Offline)</option>
                            <option value="hybrid">Campuran (Hybrid)</option>
                            <option value="online">Daring (Online)</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                            Lokasi / Tempat Rapat <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="location" required value="<?= old('location', 'Ruang Rapat Utama Gedung KOWPI Center') ?>"
                               class="w-full px-3 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-2 focus:ring-kowpi-600 focus:outline-none">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                        Link Pertemuan Daring (Opsional jika Online/Hybrid)
                    </label>
                    <input type="url" name="meeting_link" value="<?= old('meeting_link') ?>" placeholder="https://meet.google.com/xxx-xxxx-xxx atau https://zoom.us/..."
                           class="w-full px-3 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-2 focus:ring-kowpi-600 focus:outline-none">
                </div>
            </div>

            <!-- Section 3: Pimpinan & Notulis -->
            <div class="border-b border-paper-200 pb-5">
                <h3 class="font-serif-kowpi font-bold text-sm text-kowpi-800 mb-4 flex items-center gap-2">
                    <i data-lucide="users" class="w-4 h-4 text-gold"></i>
                    Pimpinan & Notulis Rapat
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-3 p-4 rounded-2xl bg-stone-50 border border-stone-200">
                        <span class="font-bold text-stone-800 text-xs">Pimpinan Rapat</span>
                        <div>
                            <label class="block text-stone-600 mb-1">Nama Pimpinan <span class="text-rose-500">*</span></label>
                            <input type="text" name="leader_name" required value="<?= old('leader_name', $settings['default_pimpinan'] ?? 'Dr. Drs. Asmuni, M.A.') ?>"
                                   class="w-full px-3 py-2 border border-stone-300 rounded-lg text-xs bg-white focus:outline-none focus:ring-1 focus:ring-kowpi-600">
                        </div>
                        <div>
                            <label class="block text-stone-600 mb-1">Jabatan Pimpinan</label>
                            <input type="text" name="leader_title" value="<?= old('leader_title', $settings['default_pimpinan_title'] ?? 'Ketua Dewan Pembina KOWPI') ?>"
                                   class="w-full px-3 py-2 border border-stone-300 rounded-lg text-xs bg-white focus:outline-none focus:ring-1 focus:ring-kowpi-600">
                        </div>
                    </div>

                    <div class="space-y-3 p-4 rounded-2xl bg-stone-50 border border-stone-200">
                        <span class="font-bold text-stone-800 text-xs">Notulis / Sekretaris Rapat</span>
                        <div>
                            <label class="block text-stone-600 mb-1">Nama Notulis <span class="text-rose-500">*</span></label>
                            <input type="text" name="notary_name" required value="<?= old('notary_name', $settings['default_notulis'] ?? 'Ust. Muhammad Abu Rivai, S.H.I., M.H.') ?>"
                                   class="w-full px-3 py-2 border border-stone-300 rounded-lg text-xs bg-white focus:outline-none focus:ring-1 focus:ring-kowpi-600">
                        </div>
                        <div>
                            <label class="block text-stone-600 mb-1">Keterangan / Divisi</label>
                            <input type="text" value="<?= esc($settings['default_notulis_title'] ?? 'Sekretaris Eksekutif KOWPI') ?>" readonly
                                   class="w-full px-3 py-2 border border-stone-200 rounded-lg text-xs bg-stone-100 text-stone-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 4: Agenda Acara -->
            <div>
                <h3 class="font-serif-kowpi font-bold text-sm text-kowpi-800 mb-2 flex items-center gap-2">
                    <i data-lucide="list-ordered" class="w-4 h-4 text-gold"></i>
                    Agenda / Susunan Pembahasan <span class="text-rose-500">*</span>
                </h3>
                <p class="text-stone-500 text-[11px] mb-2">Tuliskan poin-poin agenda yang akan dibahas (satu poin per baris):</p>
                <textarea name="agenda" rows="5" required
                          placeholder="1. Pembukaan dan Doa bersama&#10;2. Evaluasi pelaksanaan program kerja&#10;3. Pembahasan rancangan mitigasi sengketa waris&#10;4. Rencana kerja sama antar lembaga&#10;5. Penutup dan kesimpulan"
                          class="w-full px-4 py-3 border border-stone-300 rounded-2xl text-xs focus:ring-2 focus:ring-kowpi-600 focus:outline-none"><?= old('agenda') ?></textarea>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-paper-200 flex items-center justify-end gap-3">
                <a href="<?= base_url('rapat') ?>" class="px-5 py-2.5 rounded-xl border border-stone-300 text-stone-600 hover:bg-stone-50 font-semibold transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-kowpi-700 hover:bg-kowpi-800 text-white font-bold shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4 text-gold-light"></i>
                    <span>Simpan & Buka Rapat</span>
                </button>
            </div>
        </form>
    </div>

</div>
<?= $this->endSection() ?>

