<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<script>
function guestManager() {
  return {
    showAddModal: false,
    showImportModal: false,
    showEditModal: false,
    showInstitutionModal: false,
    selectedInstitution: <?= json_encode($institution ?? '') ?>,
    editData: { id: '', salutation: '', full_name: '', institution: '', phone: '' },
    openEdit(guest) {
      this.editData = { ...guest };
      this.showEditModal = true;
    },
    getZipUrl() {
      return '<?= base_url('tamu/unduh-zip-lembaga?institution=') ?>' + encodeURIComponent(this.selectedInstitution || '');
    },
    getPdfUrl() {
      return '<?= base_url('tamu/unduh-pdf-lembaga?institution=') ?>' + encodeURIComponent(this.selectedInstitution || '');
    }
  };
}
</script>

<div x-data="guestManager()">

  <!-- Header Section with Stats & Action Buttons -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
      <h1 class="text-2xl font-bold font-academic text-academic-navy">
        Manajemen Tamu Undangan &amp; Kehadiran
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 mt-1">
        Daftar <?= number_format($stats['total']) ?> tamu personal (100 Terundang &bull; <?= $stats['walk_in'] ?> Walk-in) untuk Sidang Promosi Doktor.
      </p>
    </div>

    <!-- Top Action Buttons (Responsive 2-col Grid on HP, Flex Wrap on Tablet/Desktop) -->
    <div class="grid grid-cols-2 sm:flex sm:flex-wrap items-center gap-2 w-full sm:w-auto">
      <button @click="showAddModal = true" class="inline-flex items-center justify-center space-x-1.5 px-3 py-2 rounded-lg bg-academic-navy hover:bg-academic-dark text-white text-xs font-bold shadow-sm transition text-center">
        <svg class="w-4 h-4 text-academic-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        <span>Tambah Tamu</span>
      </button>

      <button @click="showImportModal = true" class="inline-flex items-center justify-center space-x-1.5 px-3 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold shadow-sm transition text-center">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
        <span>Impor Excel</span>
      </button>

      <a href="<?= base_url('export/pdf-kehadiran?filter=present') ?>" target="_blank" class="inline-flex items-center justify-center space-x-1.5 px-3 py-2 rounded-lg bg-rose-700 hover:bg-rose-800 text-white text-xs font-semibold shadow-xs transition text-center" title="Unduh Buku Hadir & Tanda Tangan Resmi (PDF)">
        <svg class="w-4 h-4 text-rose-200 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
        <span>Buku Hadir (PDF)</span>
      </a>

      <a href="<?= base_url('export/excel-kehadiran?filter=all') ?>" class="inline-flex items-center justify-center space-x-1.5 px-3 py-2 rounded-lg bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-semibold shadow-xs transition text-center" title="Unduh Rekapitulasi Data Tamu (Excel)">
        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        <span>Ekspor Excel</span>
      </a>

      <button @click="showInstitutionModal = true" class="inline-flex items-center justify-center space-x-1.5 px-3 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold shadow-sm transition text-center" title="Unduh Undangan PDF & ZIP per Lembaga / Kategori">
        <svg class="w-4 h-4 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        <span>Per Lembaga</span>
      </button>

      <a href="<?= base_url('undangan/massal') ?>" class="inline-flex items-center justify-center space-x-1.5 px-3 py-2 rounded-lg bg-academic-gold hover:bg-academic-goldlight text-academic-navy text-xs font-bold shadow-sm transition text-center">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        <span>100 PDF &amp; ZIP</span>
      </a>
    </div>
  </div>

  <!-- Search & Filter Card -->
  <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
    <form method="GET" action="<?= base_url('tamu') ?>" class="grid grid-cols-1 sm:grid-cols-12 gap-2.5 items-center">
      
      <!-- Search Input -->
      <div class="sm:col-span-4 relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <input type="text" name="q" value="<?= esc($search ?? '') ?>" placeholder="Cari nama, kode, instansi, atau HP..." class="w-full pl-9 pr-4 py-2 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-academic-navy focus:border-academic-navy">
      </div>

      <!-- Filter Lembaga / Instansi -->
      <div class="sm:col-span-3">
        <select name="institution" class="w-full py-2 px-3 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-academic-navy focus:border-academic-navy">
          <option value="">Semua Lembaga / Instansi</option>
          <?php if (!empty($institutions)): ?>
            <?php foreach ($institutions as $inst): ?>
              <option value="<?= esc($inst['institution']) ?>" <?= ($institution ?? '') === $inst['institution'] ? 'selected' : '' ?>>
                <?= esc($inst['institution']) ?> (<?= $inst['total_guests'] ?>)
              </option>
            <?php endforeach; ?>
          <?php endif; ?>
        </select>
      </div>

      <!-- Status Filter -->
      <div class="sm:col-span-2">
        <select name="status" class="w-full py-2 px-3 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-academic-navy focus:border-academic-navy">
          <option value="">Semua Status</option>
          <option value="present" <?= ($status ?? '') === 'present' ? 'selected' : '' ?>>Hadir (<?= $stats['present'] ?>)</option>
          <option value="absent" <?= ($status ?? '') === 'absent' ? 'selected' : '' ?>>Belum Hadir (<?= $stats['absent'] ?>)</option>
        </select>
      </div>

      <!-- Type Filter -->
      <div class="sm:col-span-1">
        <select name="type" class="w-full py-2 px-2 border border-slate-300 rounded-lg text-xs focus:ring-2 focus:ring-academic-navy focus:border-academic-navy">
          <option value="">Tipe</option>
          <option value="invited" <?= ($type ?? '') === 'invited' ? 'selected' : '' ?>>Invited</option>
          <option value="walk_in" <?= ($type ?? '') === 'walk_in' ? 'selected' : '' ?>>Walk-in</option>
        </select>
      </div>

      <!-- Filter Buttons -->
      <div class="sm:col-span-2 flex items-center space-x-1.5">
        <button type="submit" class="flex-1 py-2 px-3 bg-academic-navy hover:bg-academic-dark text-white rounded-lg text-xs font-bold transition text-center shadow-xs">
          Filter
        </button>
        <?php if (!empty($search) || !empty($status) || !empty($type) || !empty($institution)): ?>
          <a href="<?= base_url('tamu') ?>" class="py-2 px-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs transition font-bold" title="Reset Filter">
            &times;
          </a>
        <?php endif; ?>
      </div>

    </form>
  </div>

  <!-- Banner Aksi Khusus: Saat Filter Lembaga Aktif -->
  <?php if (!empty($institution)): ?>
    <div class="bg-gradient-to-r from-amber-50 via-blue-50 to-indigo-50 border border-academic-gold/40 rounded-xl p-4 mb-6 flex flex-col md:flex-row md:items-center justify-between gap-3 shadow-xs">
      <div class="flex items-center space-x-3">
        <div class="w-10 h-10 rounded-xl bg-academic-navy text-academic-gold flex items-center justify-center font-bold text-lg shadow-xs shrink-0">
          🏛️
        </div>
        <div>
          <div class="flex items-center space-x-2">
            <span class="text-[10px] font-bold uppercase tracking-wider text-amber-800 bg-amber-100 px-2 py-0.5 rounded font-mono">Filter Lembaga Aktif</span>
            <span class="text-xs font-semibold text-slate-500">&bull; <?= $institutionCount ?> Tamu Terdaftar</span>
          </div>
          <h3 class="text-sm font-bold text-academic-navy font-academic mt-0.5"><?= esc($institution) ?></h3>
        </div>
      </div>
      <div class="flex flex-wrap items-center gap-2">
        <a href="<?= base_url('tamu/unduh-zip-lembaga?institution=' . urlencode($institution)) ?>" class="inline-flex items-center space-x-1.5 px-3.5 py-2 rounded-lg bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-bold text-xs shadow-xs transition" title="Unduh file ZIP berisi PDF personal terpisah untuk masing-masing tamu">
          <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
          <span>Unduh Paket ZIP (<?= $institutionCount ?> PDF)</span>
        </a>
        <a href="<?= base_url('tamu/unduh-pdf-lembaga?institution=' . urlencode($institution)) ?>" target="_blank" class="inline-flex items-center space-x-1.5 px-3.5 py-2 rounded-lg bg-academic-navy hover:bg-academic-dark text-white font-bold text-xs shadow-xs transition" title="Unduh 1 file PDF gabungan yang berisi seluruh undangan lembaga ini">
          <svg class="w-4 h-4 text-academic-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
          <span>Unduh 1 PDF Gabungan (Print-Ready)</span>
        </a>
      </div>
    </div>
  <?php endif; ?>

  <!-- Guests Table Card -->
  <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
    <div class="overflow-x-auto touch-scroll">
      <table class="w-full text-left text-xs min-w-[720px]">
        <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider text-[10px] border-b border-slate-200">
          <tr>
            <th class="py-3.5 px-4 w-12 text-center whitespace-nowrap">Kode</th>
            <th class="py-3.5 px-4 whitespace-nowrap">Nama Lengkap &amp; Gelar</th>
            <th class="py-3.5 px-4 whitespace-nowrap">Asal Instansi / Domisili</th>
            <th class="py-3.5 px-4 whitespace-nowrap">WhatsApp</th>
            <th class="py-3.5 px-4 text-center whitespace-nowrap">Tipe</th>
            <th class="py-3.5 px-4 text-center whitespace-nowrap">Kehadiran</th>
            <th class="py-3.5 px-4 text-center whitespace-nowrap">Undangan PDF</th>
            <th class="py-3.5 px-4 text-center w-28 whitespace-nowrap">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          <?php if (empty($guests)): ?>
            <tr>
              <td colspan="8" class="py-12 text-center text-slate-400">
                <div class="w-12 h-12 mx-auto mb-2 text-slate-300">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                Tidak ditemukan data tamu yang sesuai kriteria pencarian.
              </td>
            </tr>
          <?php else: ?>
            <?php foreach ($guests as $guest): ?>
              <tr class="hover:bg-slate-50/80 transition">
                
                <!-- Guest Code -->
                <td class="py-3.5 px-4 text-center font-mono font-bold <?= $guest['guest_type'] === 'invited' ? 'text-academic-navy' : 'text-emerald-700' ?>">
                  <?= esc($guest['guest_code']) ?>
                </td>

                <!-- Full Name & Salutation -->
                <td class="py-3.5 px-4">
                  <div class="font-bold text-slate-800 text-sm flex items-center space-x-1.5">
                    <span><?= esc($guest['full_name']) ?></span>
                  </div>
                  <div class="text-[11px] text-slate-400 font-serif italic">
                    <?= esc($guest['salutation']) ?>
                  </div>
                </td>

                <!-- Institution -->
                <td class="py-3.5 px-4 text-slate-600">
                  <span class="font-medium"><?= esc($guest['institution'] ?: 'Di Tempat') ?></span>
                </td>

                <!-- Phone -->
                <td class="py-3.5 px-4 font-mono text-slate-600">
                  <?php if (!empty($guest['phone'])): ?>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $guest['phone']) ?>" target="_blank" class="hover:text-emerald-600 hover:underline flex items-center space-x-1">
                      <span><?= esc($guest['phone']) ?></span>
                    </a>
                  <?php else: ?>
                    <span class="text-slate-300">-</span>
                  <?php endif; ?>
                </td>

                <!-- Guest Type Badge -->
                <td class="py-3.5 px-4 text-center">
                  <?php if ($guest['guest_type'] === 'invited'): ?>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                      Undangan
                    </span>
                  <?php else: ?>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                      Walk-in
                    </span>
                  <?php endif; ?>
                </td>

                <!-- Attendance Status & Signature -->
                <td class="py-3.5 px-4 text-center">
                  <?php if ($guest['is_present']): ?>
                    <div class="inline-flex flex-col items-center">
                      <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                        &bull; Hadir <?= date('H:i', strtotime($guest['check_in_time'])) ?>
                      </span>
                      <?php if (!empty($guest['signature_image'])): ?>
                        <img src="<?= base_url($guest['signature_image']) ?>" alt="TTD" class="h-6 mt-1 border border-slate-200 rounded bg-white p-0.5">
                      <?php endif; ?>
                    </div>
                  <?php else: ?>
                    <a href="<?= base_url('absensi?code=' . urlencode($guest['guest_code'])) ?>" class="inline-flex items-center space-x-1 px-2.5 py-1 rounded bg-slate-100 hover:bg-academic-gold hover:text-academic-navy text-slate-600 text-[10px] font-semibold transition">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                      <span>Check-in</span>
                    </a>
                  <?php endif; ?>
                </td>

                <!-- PDF Actions -->
                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                  <div class="inline-flex items-center space-x-1">
                    <a href="<?= base_url('undangan/preview/' . $guest['id']) ?>" target="_blank" class="p-1 rounded bg-slate-100 hover:bg-slate-200 text-slate-700 transition" title="Preview PDF 3 Halaman">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </a>
                    <a href="<?= base_url('undangan/unduh/' . $guest['id']) ?>" class="p-1 rounded bg-blue-50 hover:bg-blue-100 text-blue-700 transition" title="Unduh File PDF">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </a>
                  </div>
                </td>

                <!-- Action Buttons (Edit / Delete) -->
                <td class="py-3.5 px-4 text-center whitespace-nowrap">
                  <div class="inline-flex items-center space-x-1">
                    <button @click="openEdit(<?= htmlspecialchars(json_encode($guest), ENT_QUOTES, 'UTF-8') ?>)" class="p-1 rounded bg-amber-50 hover:bg-amber-100 text-amber-700 transition" title="Edit Data Tamu">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>
                    <a href="<?= base_url('tamu/delete/' . $guest['id']) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data tamu <?= esc($guest['full_name']) ?>?');" class="p-1 rounded bg-rose-50 hover:bg-rose-100 text-rose-700 transition" title="Hapus Data Tamu">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </a>
                  </div>
                </td>

              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination Footer -->
    <?php if ($pager): ?>
      <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="text-xs text-slate-500 font-medium">
          Menampilkan baris data tamu terdaftar &bull; Halaman <strong class="text-academic-navy"><?= $pager->getCurrentPage() ?></strong> dari <strong class="text-academic-navy"><?= $pager->getPageCount() ?></strong>
        </div>
        <div class="overflow-x-auto max-w-full">
          <?= $pager->links('default', 'tailwind') ?>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <!-- ==============================================================
       MODAL 1: TAMBAH TAMU BARU
       ============================================================== -->
  <div x-show="showAddModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4">
    <div @click.away="showAddModal = false" class="bg-white rounded-2xl shadow-2xl max-w-lg w-full my-auto max-h-[92vh] overflow-y-auto border border-slate-200 animate-in fade-in zoom-in duration-200">
      
      <div class="bg-academic-navy text-white px-4 sm:px-6 py-3.5 sm:py-4 flex items-center justify-between border-b border-academic-gold/30">
        <div class="flex items-center space-x-2">
          <svg class="w-5 h-5 text-academic-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
          <h3 class="font-bold text-sm">Tambah Data Tamu Undangan</h3>
        </div>
        <button @click="showAddModal = false" class="text-slate-400 hover:text-white">&times;</button>
      </div>

      <form action="<?= base_url('tamu/store') ?>" method="POST" class="p-4 sm:p-6 space-y-4">
        
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1">Tipe Tamu</label>
          <select name="guest_type" class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-academic-navy">
            <option value="invited">Tamu Terundang Resmi (Kode KOWPI-xxx)</option>
            <option value="walk_in">Tamu Hadir Dadakan / Walk-in (Kode WALKIN-xxx)</option>
          </select>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
          <div class="sm:col-span-1">
            <label class="block text-xs font-bold text-slate-700 mb-1">Sapaan</label>
            <input type="text" name="salutation" placeholder="Prof./Dr./Ustadz" class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-academic-navy">
          </div>
          <div class="sm:col-span-2">
            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap &amp; Gelar <span class="text-rose-500">*</span></label>
            <input type="text" name="full_name" required placeholder="Contoh: Prof. Dr. H. Abdul Ghofur, M.Ag." class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-academic-navy">
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1">Asal Instansi / Lembaga / Cabang KOWPI</label>
          <input type="text" name="institution" placeholder="Contoh: Pengadilan Agama Sleman / DPP KOWPI" class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-academic-navy">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp (Opsional)</label>
          <input type="text" name="phone" placeholder="Contoh: 081234567890" class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-academic-navy">
        </div>

        <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-2">
          <button type="button" @click="showAddModal = false" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition">Batal</button>
          <button type="submit" class="px-4 py-2 text-xs font-bold bg-academic-navy text-white hover:bg-academic-dark rounded-lg transition shadow-sm">Simpan Data Tamu</button>
        </div>

      </form>
    </div>
  </div>

  <!-- ==============================================================
       MODAL 2: EDIT DATA TAMU
       ============================================================== -->
  <div x-show="showEditModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4">
    <div @click.away="showEditModal = false" class="bg-white rounded-2xl shadow-2xl max-w-lg w-full my-auto max-h-[92vh] overflow-y-auto border border-slate-200 animate-in fade-in zoom-in duration-200">
      
      <div class="bg-academic-navy text-white px-4 sm:px-6 py-3.5 sm:py-4 flex items-center justify-between border-b border-academic-gold/30">
        <div class="flex items-center space-x-2">
          <svg class="w-5 h-5 text-academic-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
          <h3 class="font-bold text-sm">Edit Data Tamu (<span x-text="editData.guest_code"></span>)</h3>
        </div>
        <button @click="showEditModal = false" class="text-slate-400 hover:text-white">&times;</button>
      </div>

      <form :action="'<?= base_url('tamu/update') ?>/' + editData.id" method="POST" class="p-4 sm:p-6 space-y-4">
        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
          <div class="sm:col-span-1">
            <label class="block text-xs font-bold text-slate-700 mb-1">Sapaan</label>
            <input type="text" name="salutation" x-model="editData.salutation" class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-academic-navy">
          </div>
          <div class="sm:col-span-2">
            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap &amp; Gelar <span class="text-rose-500">*</span></label>
            <input type="text" name="full_name" x-model="editData.full_name" required class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-academic-navy">
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1">Asal Instansi / Lembaga</label>
          <input type="text" name="institution" x-model="editData.institution" class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-academic-navy">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp</label>
          <input type="text" name="phone" x-model="editData.phone" class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-academic-navy">
        </div>

        <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-2">
          <button type="button" @click="showEditModal = false" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition">Batal</button>
          <button type="submit" class="px-4 py-2 text-xs font-bold bg-academic-navy text-white hover:bg-academic-dark rounded-lg transition shadow-sm">Simpan Perubahan</button>
        </div>

      </form>
    </div>
  </div>

  <!-- ==============================================================
       MODAL 3: IMPOR EXCEL / CSV
       ============================================================== -->
  <div x-show="showImportModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4">
    <div @click.away="showImportModal = false" class="bg-white rounded-2xl shadow-2xl max-w-lg w-full my-auto max-h-[92vh] overflow-y-auto border border-slate-200 animate-in fade-in zoom-in duration-200">
      
      <div class="bg-emerald-800 text-white px-4 sm:px-6 py-3.5 sm:py-4 flex items-center justify-between">
        <div class="flex items-center space-x-2">
          <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
          <h3 class="font-bold text-sm">Impor Daftar 100 Tamu (Excel / CSV)</h3>
        </div>
        <button @click="showImportModal = false" class="text-slate-300 hover:text-white">&times;</button>
      </div>

      <form action="<?= base_url('tamu/import') ?>" method="POST" enctype="multipart/form-data" class="p-4 sm:p-6 space-y-4">
        
        <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-900 leading-relaxed">
          <strong>Petunjuk Impor:</strong><br/>
          Unggah file Excel (<code>.xlsx</code> / <code>.xls</code>) atau file CSV (<code>.csv</code>). Sistem akan membaca kolom secara otomatis:
          <ol class="list-decimal list-inside mt-1 space-y-0.5 text-emerald-800 text-[11px]">
            <li>No / Kode Tamu (opsional)</li>
            <li>Sapaan (Prof./Dr./Ustadz/Bapak/Ibu)</li>
            <li>Nama Lengkap &amp; Gelar (Wajib)</li>
            <li>Asal Instansi / Domisili</li>
            <li>Nomor WhatsApp (opsional)</li>
          </ol>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between text-xs gap-1">
          <span class="text-slate-500 font-medium">Belum punya format?</span>
          <div class="flex items-center space-x-2">
            <a href="<?= base_url('tamu/template') ?>" class="inline-flex items-center space-x-1 px-2.5 py-1 rounded bg-emerald-50 text-emerald-700 font-bold hover:bg-emerald-100 transition border border-emerald-200" title="Unduh Template Format Microsoft Excel (.xlsx)">
              <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
              <span>Unduh Template Excel (.xlsx)</span>
            </a>
            <a href="<?= base_url('tamu/template?format=csv') ?>" class="text-slate-400 hover:text-slate-600 text-[11px] underline" title="Unduh Template Versi CSV">
              (.csv)
            </a>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1">Pilih File (.xlsx, .xls, .csv)</label>
          <input type="file" name="file_excel" accept=".xlsx,.xls,.csv" required class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-emerald-100 file:text-emerald-800 hover:file:bg-emerald-200">
        </div>

        <div class="pt-3 border-t border-slate-100 flex items-center justify-end space-x-2">
          <button type="button" @click="showImportModal = false" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition">Batal</button>
          <button type="submit" class="px-4 py-2 text-xs font-bold bg-emerald-600 text-white hover:bg-emerald-500 rounded-lg transition shadow-sm">Mulai Impor File</button>
        </div>

      </form>
    </div>
  </div>

  <!-- ==============================================================
       MODAL 4: UNDUH UNDANGAN PER LEMBAGA / KATEGORI
       ============================================================== -->
  <div x-show="showInstitutionModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4">
    <div @click.away="showInstitutionModal = false" class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full my-auto max-h-[92vh] overflow-y-auto border border-slate-200 animate-in fade-in zoom-in duration-200">
      
      <!-- Modal Header -->
      <div class="bg-academic-navy text-white px-4 sm:px-6 py-3.5 sm:py-4 flex items-center justify-between border-b border-academic-gold/30">
        <div class="flex items-center space-x-2.5">
          <div class="w-8 h-8 rounded-lg bg-academic-gold/20 flex items-center justify-center text-academic-gold font-bold">
            <svg class="w-5 h-5 text-academic-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
          </div>
          <div>
            <h3 class="font-bold text-sm">Unduh Undangan per Kategori / Lembaga</h3>
            <p class="text-[11px] text-slate-300">Pilih lembaga/rombongan tamu untuk mengunduh paket ZIP atau 1 PDF gabungan</p>
          </div>
        </div>
        <button @click="showInstitutionModal = false" class="text-slate-400 hover:text-white text-lg font-bold">&times;</button>
      </div>

      <div class="p-6 space-y-6">

        <!-- Selector Box -->
        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Pilih Lembaga / Instansi / Rombongan:</label>
          <select x-model="selectedInstitution" class="w-full text-xs px-3 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-academic-navy bg-white">
            <option value="">-- Silakan Pilih Lembaga --</option>
            <?php if (!empty($institutions)): ?>
              <?php foreach ($institutions as $inst): ?>
                <option value="<?= esc($inst['institution']) ?>">
                  <?= esc($inst['institution']) ?> (<?= $inst['total_guests'] ?> Tamu)
                </option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>

          <!-- Action Buttons for Selected Institution -->
          <div x-show="selectedInstitution" class="mt-4 pt-3 border-t border-slate-200 flex flex-col sm:flex-row items-center gap-2.5">
            <a :href="getZipUrl()"
               class="w-full sm:w-1/2 inline-flex items-center justify-center space-x-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs shadow-sm transition">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
              <span>Unduh Paket ZIP (PDF Terpisah)</span>
            </a>

            <a :href="getPdfUrl()" target="_blank"
               class="w-full sm:w-1/2 inline-flex items-center justify-center space-x-2 px-4 py-2.5 rounded-xl bg-academic-navy hover:bg-academic-dark text-white font-bold text-xs shadow-sm transition">
              <svg class="w-4 h-4 text-academic-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
              <span>Unduh 1 PDF Gabungan (Print-Ready)</span>
            </a>
          </div>
        </div>

        <!-- Quick Table of Institutions -->
        <div>
          <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Daftar Lembaga &amp; Jumlah Tamu</span>
            <span class="text-[11px] text-slate-400">Total <?= count($institutions) ?> Lembaga Terdata</span>
          </div>

          <div class="max-h-64 overflow-y-auto border border-slate-200 rounded-xl divide-y divide-slate-100 text-xs">
            <?php if (!empty($institutions)): ?>
              <?php foreach ($institutions as $inst): ?>
                <div class="p-3 hover:bg-slate-50 flex items-center justify-between gap-3 transition">
                  <div class="min-w-0 flex-1">
                    <div class="font-bold text-academic-navy truncate"><?= esc($inst['institution']) ?></div>
                    <div class="text-[11px] text-slate-400 mt-0.5">
                      <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 font-semibold text-[10px]">
                        <?= $inst['total_guests'] ?> Tamu
                      </span>
                    </div>
                  </div>
                  <div class="flex items-center space-x-1.5 shrink-0">
                    <a href="<?= base_url('tamu/unduh-zip-lembaga?institution=' . urlencode($inst['institution'])) ?>"
                       class="p-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 transition"
                       title="Unduh Paket ZIP (<?= $inst['total_guests'] ?> PDF)">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                    </a>
                    <a href="<?= base_url('tamu/unduh-pdf-lembaga?institution=' . urlencode($inst['institution'])) ?>" target="_blank"
                       class="p-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 transition"
                       title="Unduh 1 PDF Gabungan (Print-Ready)">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </a>
                    <a href="<?= base_url('tamu?institution=' . urlencode($inst['institution'])) ?>"
                       class="px-2 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-[11px] transition">
                      Filter Tabel &rarr;
                    </a>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        </div>

      </div>

      <div class="px-6 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-end">
        <button type="button" @click="showInstitutionModal = false" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-200 rounded-lg transition">Tutup</button>
      </div>

    </div>
  </div>

</div>

<?= $this->endSection() ?>
