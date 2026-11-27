<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-6xl mx-auto">

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
                    <span class="text-xs text-stone-500">Galeri Foto Kegiatan</span>
                </div>
                <h2 class="font-serif-kowpi font-bold text-xl md:text-2xl text-kowpi-950 mt-1">
                    Dokumentasi Foto Rapat
                </h2>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-xl bg-white border border-paper-200 text-xs font-semibold text-stone-700 shadow-sm">
                Total: <strong><?= count($photos) ?></strong> Foto
            </span>
        </div>
    </div>

    <!-- Upload Card -->
    <div class="bg-white rounded-3xl border border-paper-200 shadow-sm p-6 md:p-8 space-y-4">
        <div class="border-b border-paper-200 pb-3 flex items-center justify-between">
            <h3 class="font-serif-kowpi font-bold text-base text-kowpi-900 flex items-center gap-2">
                <i data-lucide="upload-cloud" class="w-5 h-5 text-gold"></i>
                Unggah Foto Dokumentasi Rapat
            </h3>
            <span class="text-xs text-stone-400">JPG, PNG, WEBP (Bisa Pilih Banyak Foto Sekaligus)</span>
        </div>

        <form action="<?= base_url('rapat/' . $meeting['id'] . '/dokumentasi/upload') ?>" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                <div class="md:col-span-2">
                    <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                        Pilih File Foto
                    </label>
                    <input type="file" name="photos[]" multiple accept="image/*" required
                           class="w-full p-2.5 border border-stone-300 rounded-xl bg-stone-50 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-kowpi-700 file:text-white hover:file:bg-kowpi-800 cursor-pointer">
                </div>

                <div>
                    <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                        Keterangan / Momen Foto (Opsional)
                    </label>
                    <input type="text" name="caption" placeholder="Contoh: Sesi Pembahasan Modul Waris..."
                           class="w-full px-3 py-2.5 border border-stone-300 rounded-xl focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-2.5 bg-kowpi-700 hover:bg-kowpi-800 text-white font-bold rounded-xl shadow-md transition-all flex items-center gap-2">
                    <i data-lucide="upload" class="w-4 h-4 text-gold-light"></i>
                    <span>Unggah ke Galeri</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Gallery Grid -->
    <div class="bg-white rounded-3xl border border-paper-200 shadow-sm p-6 md:p-8 space-y-6">
        <h3 class="font-serif-kowpi font-bold text-base text-kowpi-900 border-b border-paper-200 pb-3">
            Arsip Galeri Dokumentasi
        </h3>

        <?php if (empty($photos)): ?>
            <div class="py-16 text-center text-stone-400">
                <div class="w-16 h-16 rounded-full bg-stone-100 flex items-center justify-center mx-auto mb-3 text-stone-400">
                    <i data-lucide="camera-off" class="w-8 h-8"></i>
                </div>
                <h4 class="font-serif-kowpi font-bold text-base text-stone-700 mb-1">Belum Ada Foto Dokumentasi</h4>
                <p class="text-xs text-stone-400">Silakan unggah foto kegiatan rapat menggunakan form di atas.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                <?php foreach ($photos as $photo): ?>
                    <div class="group bg-stone-50 border border-stone-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                        <!-- Image Container with Zoom -->
                        <div class="relative aspect-video bg-stone-200 overflow-hidden cursor-pointer" onclick="zoomPhoto('<?= base_url($photo['file_path']) ?>', '<?= esc($photo['caption'] ?? '') ?>')">
                            <img src="<?= base_url($photo['file_path']) ?>" alt="Dokumentasi" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                                <i data-lucide="zoom-in" class="w-6 h-6"></i>
                            </div>
                        </div>

                        <!-- Caption & Actions -->
                        <div class="p-3.5 space-y-2">
                            <p class="text-xs font-medium text-stone-800 line-clamp-2" title="<?= esc($photo['caption'] ?? '') ?>">
                                <?= esc($photo['caption'] ?? 'Dokumentasi Rapat KOWPI') ?>
                            </p>
                            <div class="flex items-center justify-between text-[10px] text-stone-400 pt-1 border-t border-stone-200">
                                <span><?= date('d/m/Y H:i', strtotime($photo['created_at'])) ?></span>
                                <a href="<?= base_url('dokumentasi/delete/' . $photo['id']) ?>"
                                   onclick="return confirm('Hapus foto ini?')"
                                   class="text-rose-500 hover:text-rose-700 font-semibold p-1 hover:bg-rose-50 rounded">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</div>

<!-- Modal: Zoom Photo Lightbox -->
<div id="photoModal" class="fixed inset-0 z-50 bg-black/85 backdrop-blur-md hidden items-center justify-center p-4" onclick="closePhotoModal()">
    <div class="max-w-4xl w-full text-center space-y-3" onclick="event.stopPropagation()">
        <div class="relative bg-black rounded-3xl overflow-hidden shadow-2xl border border-stone-700">
            <img id="photoModalImg" src="" alt="Zoom" class="max-h-[80vh] w-auto mx-auto object-contain">
        </div>
        <p id="photoModalCaption" class="text-stone-300 text-sm font-medium"></p>
        <button type="button" onclick="closePhotoModal()" class="px-5 py-2 bg-white/20 hover:bg-white/30 text-white rounded-xl text-xs font-bold transition-colors">
            Tutup Pratinjau
        </button>
    </div>
</div>

<script>
    function zoomPhoto(src, caption) {
        document.getElementById('photoModalImg').src = src;
        document.getElementById('photoModalCaption').innerText = caption || 'Dokumentasi Rapat KOWPI';
        const modal = document.getElementById('photoModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closePhotoModal() {
        const modal = document.getElementById('photoModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
<?= $this->endSection() ?>

