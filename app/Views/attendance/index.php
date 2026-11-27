<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div x-data="attendanceManager()">

  <?php if (!empty($settings['is_event_completed'])): ?>
  <!-- Banner Pemberitahuan Acara Selesai -->
  <div class="mb-6 p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-emerald-950 via-academic-navy to-academic-dark text-white border-2 border-emerald-500/50 shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex items-start sm:items-center space-x-3.5">
      <div class="w-11 h-11 rounded-xl bg-emerald-500/20 border border-emerald-400/40 flex items-center justify-center flex-shrink-0 text-emerald-300 shadow-inner">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
      </div>
      <div>
        <div class="inline-flex items-center space-x-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-[10px] font-bold uppercase tracking-wider mb-1">
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
          <span>Acara Telah Selesai Terlaksana &bull; Presensi Ditutup</span>
        </div>
        <h2 class="text-sm sm:text-base font-bold text-white font-academic">
          Sidang Promosi Doktor Selesai Dilaksanakan (<?= esc($settings['event_day_date'] ?? 'Selasa, 20 Oktober 2026') ?>)
        </h2>
        <p class="text-xs text-slate-300 mt-0.5">
          Sesi pembubuhan absensi telah resmi ditutup untuk menjaga keaslian data arsip kehadiran sidang.
        </p>
      </div>
    </div>
    <div class="flex items-center gap-2 flex-shrink-0 self-end md:self-center">
      <a href="<?= base_url('daftar-hadir') ?>" class="px-4 py-2 rounded-xl bg-academic-gold hover:bg-academic-goldlight text-academic-navy text-xs font-bold transition shadow-md flex items-center space-x-1.5">
        <span>Buka Rekapitulasi Hadir &rarr;</span>
      </a>
    </div>
  </div>
  <?php endif; ?>

  <!-- Meja Resepsionis Header -->
  <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 sm:p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      
      <div>
        <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-academic-navy/10 text-academic-navy text-xs font-bold uppercase tracking-wider mb-2">
          <span>Meja Resepsionis &bull; Ruang Sidang 03.16</span>
        </div>
        <h1 class="text-xl sm:text-2xl font-bold font-academic text-academic-navy">
          Meja Absensi Digital (Pen Tablet &amp; Touch Screen)
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">
          Pilih nama tamu dari 100 daftar undangan untuk membubuhkan tanda tangan digital langsung pada kanvas.
        </p>
      </div>

      <!-- Quick Summary Badges (Responsive Grid on Mobile) -->
      <div class="grid grid-cols-2 sm:flex sm:items-center gap-2 sm:space-x-3 w-full sm:w-auto">
        <div class="px-3 py-2 sm:px-4 sm:py-2 rounded-xl bg-slate-50 border border-slate-200 text-center">
          <div class="text-[10px] text-slate-400 uppercase font-semibold">Tamu Undangan</div>
          <div class="text-base sm:text-lg font-bold text-academic-navy">
            <span x-text="stats.present_invited"><?= $stats['present_invited'] ?></span> / <span x-text="stats.invited"><?= $stats['invited'] ?></span>
          </div>
        </div>

        <div class="px-3 py-2 sm:px-4 sm:py-2 rounded-xl bg-emerald-50 border border-emerald-200 text-center">
          <div class="text-[10px] text-emerald-600 uppercase font-semibold">Total Hadir</div>
          <div class="text-base sm:text-lg font-bold text-emerald-700">
            <span x-text="stats.present"><?= $stats['present'] ?></span>
          </div>
        </div>

        <?php if (!empty($settings['is_event_completed'])): ?>
        <a href="<?= base_url('daftar-hadir') ?>" class="col-span-2 sm:col-span-1 px-4 py-2 sm:py-2.5 rounded-xl bg-academic-navy hover:bg-academic-dark text-academic-gold font-bold text-xs shadow-sm transition flex items-center justify-center space-x-1.5 border border-academic-gold/40" title="Lihat Rekapitulasi Resmi Kehadiran Tamu">
          <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
          <span>Rekap Kehadiran &rarr;</span>
        </a>
        <?php else: ?>
        <a href="<?= base_url('tamu-baru') ?>" class="col-span-2 sm:col-span-1 px-4 py-2 sm:py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-sm transition flex items-center justify-center space-x-1.5" title="Jika ada tamu hadir yang tidak ada dalam daftar 100 undangan">
          <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
          <span>Tamu Walk-in &rarr;</span>
        </a>
        <?php endif; ?>
      </div>

    </div>

    <!-- Search Input & Filter Tabs -->
    <div class="mt-4 sm:mt-6 pt-4 sm:pt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-3 items-stretch sm:items-center justify-between">
      
      <!-- Instant Search Filter -->
      <div class="w-full sm:w-96 relative">
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <input type="text" x-model="searchQuery" placeholder="Ketik nama tamu, gelar, atau instansi..." class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-academic-navy focus:border-academic-navy shadow-xs">
        <button x-show="searchQuery.length > 0" @click="searchQuery = ''" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
          &times;
        </button>
      </div>

      <!-- Filter Buttons -->
      <div class="flex flex-wrap items-center gap-1.5 w-full sm:w-auto">
        <button @click="statusFilter = 'all'" :class="statusFilter === 'all' ? 'bg-academic-navy text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="flex-1 sm:flex-initial px-3 py-1.5 rounded-lg text-xs font-bold transition text-center">
          Semua (100)
        </button>
        <button @click="statusFilter = 'absent'" :class="statusFilter === 'absent' ? 'bg-amber-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="flex-1 sm:flex-initial px-3 py-1.5 rounded-lg text-xs font-bold transition text-center">
          Belum Hadir (<span x-text="stats.absent"><?= $stats['absent'] ?></span>)
        </button>
        <button @click="statusFilter = 'present'" :class="statusFilter === 'present' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="flex-1 sm:flex-initial px-3 py-1.5 rounded-lg text-xs font-bold transition text-center">
          Sudah Hadir (<span x-text="stats.present"><?= $stats['present'] ?></span>)
        </button>
      </div>

    </div>
  </div>

  <!-- Guests Grid for Fast Touch / Pen Tablet Selection -->
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3 sm:gap-4 mb-8">
    
    <template x-for="guest in filteredGuests" :key="guest.id">
      <div class="bg-white rounded-xl shadow-xs border p-3.5 sm:p-4 transition-all duration-200 hover:shadow-md flex flex-col justify-between"
           :class="guest.is_present == 1 ? 'border-emerald-200 bg-emerald-50/20' : 'border-slate-200 hover:border-academic-navy'">
        
        <!-- Guest Details -->
        <div>
          <div class="flex items-start justify-between gap-2 mb-2">
            <span class="px-2 py-0.5 rounded font-mono text-[11px] font-bold"
                  :class="guest.is_present == 1 ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700'"
                  x-text="guest.guest_code"></span>

            <span x-show="guest.is_present == 1" class="inline-flex items-center space-x-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500 text-white shadow-xs">
              <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
              <span>Hadir: <span x-text="formatTime(guest.check_in_time)"></span></span>
            </span>

            <span x-show="guest.is_present == 0" class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-100 text-slate-500">
              Belum Hadir
            </span>
          </div>

          <h3 class="font-bold text-slate-900 text-sm leading-snug" x-text="guest.full_name"></h3>
          <p class="text-xs text-slate-500 mt-0.5" x-text="guest.institution || 'Tamu Undangan'"></p>
          
          <div x-show="guest.phone" class="text-[11px] font-mono text-slate-400 mt-1">
            📱 <span x-text="guest.phone"></span>
          </div>
        </div>

        <!-- Action / Signature Section -->
        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
          
          <!-- If Present: Show signature preview & undo option -->
          <div x-show="guest.is_present == 1" class="w-full flex items-center justify-between">
            <div class="flex items-center space-x-2">
              <template x-if="guest.signature_image">
                <img :src="'<?= base_url() ?>' + guest.signature_image" alt="TTD" class="h-8 max-w-[90px] object-contain border border-slate-200 rounded bg-white p-0.5">
              </template>
              <template x-if="!guest.signature_image">
                <span class="text-[11px] italic text-slate-400">Tercatat Hadir</span>
              </template>
            </div>

            <?php if (!empty($settings['is_event_completed'])): ?>
            <div class="flex items-center space-x-1">
              <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-md text-[11px] font-semibold text-emerald-700 bg-emerald-100">
                <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>Tercatat Hadir</span>
              </span>
            </div>
            <?php else: ?>
            <div class="flex items-center space-x-1">
              <button @click="openCheckInModal(guest)" class="px-2.5 py-1 rounded-md text-[11px] font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                Ganti TTD
              </button>
              <a :href="'<?= base_url('absensi/undo') ?>/' + guest.id" onclick="return confirm('Batalkan status kehadiran tamu ini?');" class="px-2.5 py-1 rounded-md text-[11px] font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 transition">
                Batal
              </a>
            </div>
            <?php endif; ?>
          </div>

          <!-- If Not Present: Big Check-in Button or Locked Notice -->
          <div x-show="guest.is_present == 0" class="w-full">
            <?php if (!empty($settings['is_event_completed'])): ?>
            <div class="w-full py-2.5 px-3 rounded-xl bg-slate-100 border border-slate-200 text-slate-400 text-xs font-semibold text-center flex items-center justify-center space-x-1.5 cursor-not-allowed">
              <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
              <span>Presensi Ditutup (Acara Selesai)</span>
            </div>
            <?php else: ?>
            <button @click="openCheckInModal(guest)" class="w-full py-2.5 px-3 rounded-xl bg-academic-navy hover:bg-academic-dark text-white text-xs font-bold transition shadow-sm flex items-center justify-center space-x-1.5 active:scale-[0.99]">
              <svg class="w-4 h-4 text-academic-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
              <span>Tanda Tangan &amp; Check-In</span>
            </button>
            <?php endif; ?>
          </div>

        </div>

      </div>
    </template>

  </div>

  <!-- Empty Search Result State -->
  <div x-show="filteredGuests.length === 0" class="bg-white rounded-2xl border border-slate-200 p-8 sm:p-12 text-center text-slate-400">
    <div class="w-16 h-16 mx-auto mb-3 text-slate-300">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    </div>
    <div class="text-base font-bold text-slate-700">Nama Tamu Tidak Ditemukan</div>
    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
      <?php if (!empty($settings['is_event_completed'])): ?>
      Pencarian tidak menemukan nama tamu yang cocok pada arsip 100 undangan resmi.
      <?php else: ?>
      Jika tamu yang bersangkutan belum terdaftar dalam 100 undangan resmi, Anda dapat mendaftarkannya melalui tombol registrasi Walk-in.
      <?php endif; ?>
    </p>
    <div class="mt-4">
      <?php if (!empty($settings['is_event_completed'])): ?>
      <a href="<?= base_url('daftar-hadir') ?>" class="inline-flex items-center space-x-2 px-4 py-2 rounded-xl bg-academic-navy hover:bg-academic-dark text-academic-gold text-xs font-bold shadow-sm transition border border-academic-gold/40">
        <span>Buka Rekapitulasi Hadir Publik &rarr;</span>
      </a>
      <?php else: ?>
      <a href="<?= base_url('tamu-baru') ?>" class="inline-flex items-center space-x-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold shadow-sm transition">
        <span>+ Registrasi Tamu Baru (Walk-in)</span>
      </a>
      <?php endif; ?>
    </div>
  </div>

  <!-- ==============================================================
       MODAL TANDA TANGAN DIGITAL (PEN TABLET & TOUCH CANVAS)
       ============================================================== -->
  <div x-show="showSignatureModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto bg-black/75 backdrop-blur-xs flex items-center justify-center p-3 sm:p-4">
    <div @click.away="closeModal()" class="bg-white rounded-2xl shadow-2xl max-w-xl w-full my-auto overflow-hidden border border-slate-200 animate-in fade-in zoom-in duration-200">
      
      <!-- Modal Header -->
      <div class="bg-academic-navy text-white px-4 sm:px-6 py-3.5 sm:py-4 flex items-center justify-between border-b border-academic-gold/30">
        <div>
          <span class="text-[10px] uppercase tracking-wider text-academic-gold font-bold">Buku Tamu Sidang Promosi Doktor</span>
          <h3 class="font-bold text-sm sm:text-base" x-text="selectedGuest?.full_name"></h3>
          <p class="text-xs text-slate-300" x-text="selectedGuest?.institution"></p>
        </div>
        <button @click="closeModal()" class="text-slate-400 hover:text-white text-2xl font-bold p-1 leading-none">&times;</button>
      </div>

      <div class="p-4 sm:p-6 space-y-4">

        <!-- Canvas Container with Tablet Styling -->
        <div>
          <div class="flex items-center justify-between mb-1.5">
            <label class="text-xs font-bold text-slate-700 flex items-center space-x-1.5">
              <span>Goreskan Tanda Tangan Digital</span>
              <span class="hidden sm:inline text-[10px] text-slate-400 font-normal">(Pen Tablet, Layar HP/Tab, atau Mouse)</span>
            </label>
            <button type="button" @click="clearSignature()" class="text-xs font-semibold text-rose-600 hover:text-rose-700 flex items-center space-x-1">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
              <span>Hapus</span>
            </button>
          </div>

          <div class="border-2 border-dashed border-slate-300 rounded-xl bg-[#FCFBF7] relative overflow-hidden shadow-inner flex items-center justify-center">
            <canvas id="signatureCanvas" class="w-full h-44 sm:h-56 touch-none cursor-crosshair"></canvas>
            
            <div class="absolute bottom-2 right-3 pointer-events-none text-[10px] text-slate-400 italic">
              Area Tanda Tangan Digital KOWPI x UII
            </div>
          </div>
        </div>

        <!-- Optional Doa / Ucapan Selamat -->
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1">
            Doa / Ucapan Selamat untuk Promovendus <span class="text-slate-400 font-normal">(Opsional)</span>
          </label>
          <textarea x-model="wishesInput" rows="2" placeholder="Barakallahu fiik, semoga berkah..." class="w-full text-xs px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-academic-navy"></textarea>
        </div>

        <!-- Action Buttons (Thumb-friendly on Mobile) -->
        <div class="pt-3 border-t border-slate-100 flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-2">
          <button type="button" @click="closeModal()" class="w-full sm:w-auto px-4 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition text-center">
            Batal
          </button>
          <button type="button" @click="saveCheckIn()" :disabled="isSubmitting" class="w-full sm:w-auto px-5 py-2.5 text-xs font-bold bg-academic-navy text-white hover:bg-academic-dark rounded-xl transition shadow-md flex items-center justify-center space-x-1.5 disabled:opacity-50">
            <svg x-show="!isSubmitting" class="w-4 h-4 text-academic-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span x-text="isSubmitting ? 'Menyimpan...' : 'Simpan Kehadiran & Masuk Daftar Hadir'"></span>
          </button>
        </div>

      </div>

    </div>
  </div>

</div>

<script>
function attendanceManager() {
  return {
    rawGuests: <?= json_encode($guests) ?>,
    stats: <?= json_encode($stats) ?>,
    searchQuery: '<?= esc($search ?? $code ?? '') ?>',
    statusFilter: 'all',
    showSignatureModal: false,
    selectedGuest: null,
    wishesInput: '',
    isSubmitting: false,
    signaturePad: null,

    get filteredGuests() {
      return this.rawGuests.filter(g => {
        // Status filter
        if (this.statusFilter === 'present' && g.is_present != 1) return false;
        if (this.statusFilter === 'absent' && g.is_present != 0) return false;

        // Search query
        if (this.searchQuery.trim() !== '') {
          const q = this.searchQuery.toLowerCase();
          const matchName = (g.full_name || '').toLowerCase().includes(q);
          const matchInst = (g.institution || '').toLowerCase().includes(q);
          const matchCode = (g.guest_code || '').toLowerCase().includes(q);
          const matchPhone = (g.phone || '').toLowerCase().includes(q);
          return matchName || matchInst || matchCode || matchPhone;
        }

        return true;
      });
    },

    formatTime(dt) {
      if (!dt) return '';
      const parts = dt.split(' ');
      return parts.length > 1 ? parts[1].substr(0, 5) + ' WIB' : dt;
    },

    openCheckInModal(guest) {
      this.selectedGuest = guest;
      this.wishesInput = guest.wishes || '';
      this.showSignatureModal = true;

      setTimeout(() => {
        this.initSignaturePad();
      }, 120);
    },

    initSignaturePad() {
      const canvas = document.getElementById('signatureCanvas');
      if (!canvas) return;

      // Handle high DPI
      const ratio = Math.max(window.devicePixelRatio || 1, 1);
      canvas.width = canvas.offsetWidth * ratio;
      canvas.height = canvas.offsetHeight * ratio;
      canvas.getContext("2d").scale(ratio, ratio);

      this.signaturePad = new SignaturePad(canvas, {
        minWidth: 1.5,
        maxWidth: 3.5,
        penColor: '#0F2C59', // Academic Navy
        backgroundColor: 'rgba(255, 255, 255, 0)',
      });

      this.signaturePad.clear();
    },

    clearSignature() {
      if (this.signaturePad) {
        this.signaturePad.clear();
      }
    },

    closeModal() {
      this.showSignatureModal = false;
      this.selectedGuest = null;
      if (this.signaturePad) {
        this.signaturePad.clear();
      }
    },

    async saveCheckIn() {
      if (!this.selectedGuest) return;

      let signatureData = null;
      if (this.signaturePad && !this.signaturePad.isEmpty()) {
        signatureData = this.signaturePad.toDataURL('image/png');
      }

      this.isSubmitting = true;

      const formData = new FormData();
      formData.append('guest_id', this.selectedGuest.id);
      if (signatureData) {
        formData.append('signature_data', signatureData);
      }
      formData.append('wishes', this.wishesInput);

      try {
        const response = await fetch('<?= base_url('absensi/checkin') ?>', {
          method: 'POST',
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: formData
        });

        const res = await response.json();

        if (res.success) {
          // Update local state
          const idx = this.rawGuests.findIndex(g => g.id == this.selectedGuest.id);
          if (idx !== -1) {
            this.rawGuests[idx].is_present = 1;
            this.rawGuests[idx].check_in_time = res.guest.check_in_time;
            this.rawGuests[idx].signature_image = res.guest.signature_image;
            this.rawGuests[idx].wishes = res.guest.wishes;
          }

          if (res.stats) {
            this.stats = res.stats;
          }

          this.closeModal();

          Swal.fire({
            icon: 'success',
            title: 'Kehadiran Berhasil Dicatat!',
            html: `<div class="text-sm">Selamat datang, <b>${res.guest.full_name}</b>.<br><span class="text-emerald-700 font-mono">Waktu Kedatangan: ${res.check_in_time}</span></div>`,
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: res.message || 'Terjadi kesalahan'
          });
        }
      } catch (err) {
        console.error(err);
        Swal.fire({
          icon: 'error',
          title: 'Kesalahan Sistem',
          text: 'Gagal menghubungi server'
        });
      } finally {
        this.isSubmitting = false;
      }
    }
  }
}
</script>

<?= $this->endSection() ?>
