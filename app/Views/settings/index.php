<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Navigation -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-serif-kowpi font-bold text-2xl text-kowpi-950">
                Pengaturan Organisasi & Surat KOWPI
            </h2>
            <p class="text-xs text-stone-500">
                Konfigurasi identitas organisasi, kop surat resmi, stempel, serta penandatangan default.
            </p>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-3xl border border-paper-200 shadow-sm p-6 md:p-8">
        <form action="<?= base_url('pengaturan/update') ?>" method="POST" enctype="multipart/form-data" class="space-y-6 text-xs">

            <!-- Section 1: Identitas Lembaga -->
            <div class="border-b border-paper-200 pb-5">
                <h3 class="font-serif-kowpi font-bold text-sm text-kowpi-800 mb-4 flex items-center gap-2">
                    <i data-lucide="building" class="w-4 h-4 text-gold"></i>
                    Identitas & Legalitas Lembaga
                </h3>

                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                                Nama Lengkap Organisasi <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="org_name" required value="<?= esc(old('org_name', $settings['org_name'])) ?>"
                                   class="w-full px-3 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                                Singkatan / Akronim
                            </label>
                            <input type="text" name="org_short" value="<?= esc(old('org_short', $settings['org_short'])) ?>"
                                   class="w-full px-3 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                            Tagline / Moto Organisasi
                        </label>
                        <input type="text" name="org_tagline" value="<?= esc(old('org_tagline', $settings['org_tagline'])) ?>"
                               class="w-full px-3 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                            Alamat Sekretariat Resmi
                        </label>
                        <textarea name="org_address" rows="2"
                                  class="w-full px-3 py-2 border border-stone-300 rounded-xl text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none"><?= esc(old('org_address', $settings['org_address'])) ?></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                                Website Resmi
                            </label>
                            <input type="text" name="org_website" value="<?= esc(old('org_website', $settings['org_website'])) ?>"
                                   class="w-full px-3 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                                Email Sekretariat
                            </label>
                            <input type="email" name="org_email" value="<?= esc(old('org_email', $settings['org_email'])) ?>"
                                   class="w-full px-3 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-stone-700 font-bold mb-1.5 uppercase tracking-wider text-[11px]">
                                Nomor Telepon / WhatsApp
                            </label>
                            <input type="text" name="org_phone" value="<?= esc(old('org_phone', $settings['org_phone'])) ?>"
                                   class="w-full px-3 py-2.5 border border-stone-300 rounded-xl text-xs focus:ring-1 focus:ring-kowpi-600 focus:outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Penandatangan Default -->
            <div class="border-b border-paper-200 pb-5">
                <h3 class="font-serif-kowpi font-bold text-sm text-kowpi-800 mb-4 flex items-center gap-2">
                    <i data-lucide="user-check" class="w-4 h-4 text-gold"></i>
                    Pejabat Penandatangan Default
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="p-4 rounded-2xl bg-stone-50 border border-stone-200 space-y-3">
                        <span class="font-bold text-stone-800 text-xs">Pimpinan Rapat Utama</span>
                        <div>
                            <label class="block text-stone-600 mb-1">Nama Lengkap & Gelar</label>
                            <input type="text" name="default_pimpinan" value="<?= esc(old('default_pimpinan', $settings['default_pimpinan'])) ?>"
                                   class="w-full px-3 py-2 border border-stone-300 rounded-lg text-xs bg-white">
                        </div>
                        <div>
                            <label class="block text-stone-600 mb-1">Jabatan Resmi</label>
                            <input type="text" name="default_pimpinan_title" value="<?= esc(old('default_pimpinan_title', $settings['default_pimpinan_title'])) ?>"
                                   class="w-full px-3 py-2 border border-stone-300 rounded-lg text-xs bg-white">
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-stone-50 border border-stone-200 space-y-3">
                        <span class="font-bold text-stone-800 text-xs">Notulis / Sekretariat</span>
                        <div>
                            <label class="block text-stone-600 mb-1">Nama Lengkap & Gelar</label>
                            <input type="text" name="default_notulis" value="<?= esc(old('default_notulis', $settings['default_notulis'])) ?>"
                                   class="w-full px-3 py-2 border border-stone-300 rounded-lg text-xs bg-white">
                        </div>
                        <div>
                            <label class="block text-stone-600 mb-1">Jabatan Resmi</label>
                            <input type="text" name="default_notulis_title" value="<?= esc(old('default_notulis_title', $settings['default_notulis_title'])) ?>"
                                   class="w-full px-3 py-2 border border-stone-300 rounded-lg text-xs bg-white">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Logo & Stempel Organisasi -->
            <div>
                <h3 class="font-serif-kowpi font-bold text-sm text-kowpi-800 mb-4 flex items-center gap-2">
                    <i data-lucide="image" class="w-4 h-4 text-gold"></i>
                    Logo & Stempel Resmi KOWPI
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Logo KOWPI -->
                    <div class="p-4 rounded-2xl bg-stone-50 border border-stone-200 space-y-3">
                        <span class="font-bold text-stone-800 text-xs">Logo Lembaga</span>
                        <div class="bg-white border border-stone-200 rounded-xl p-3 h-24 flex items-center justify-center">
                            <img src="<?= base_url($settings['org_logo'] ?? 'img/logo-kowpi-coklat.png') ?>" alt="Logo KOWPI" class="max-h-20 object-contain">
                        </div>
                        <div>
                            <label class="block text-stone-600 mb-1">Ganti Logo Baru (PNG Transparan Disarankan)</label>
                            <input type="file" name="org_logo" accept="image/*" class="w-full text-xs">
                        </div>
                    </div>

                    <!-- Stempel KOWPI -->
                    <div class="p-4 rounded-2xl bg-stone-50 border border-stone-200 space-y-3">
                        <span class="font-bold text-stone-800 text-xs">Stempel Resmi KOWPI</span>
                        <div class="bg-white border border-stone-200 rounded-xl p-3 h-24 flex items-center justify-center">
                            <img src="<?= base_url($settings['org_stamp'] ?? 'img/stempel-kowpi-transparan.png') ?>" alt="Stempel KOWPI" class="max-h-20 object-contain">
                        </div>
                        <div>
                            <label class="block text-stone-600 mb-1">Ganti Stempel Baru (PNG Transparan Disarankan)</label>
                            <input type="file" name="org_stamp" accept="image/*" class="w-full text-xs">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-paper-200 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-kowpi-700 hover:bg-kowpi-800 text-white font-bold rounded-xl shadow-md transition-all flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4 text-gold-light"></i>
                    <span>Simpan Pengaturan</span>
                </button>
            </div>
        </form>
    </div>

</div>
<?= $this->endSection() ?>
