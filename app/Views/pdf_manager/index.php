<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="max-w-5xl mx-auto py-2" x-data="bulkPdfApp()">

  <!-- Header -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
      <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-academic-gold/20 text-academic-navy text-xs font-bold uppercase tracking-wider mb-2">
        <span>AJAX Batch Processing &bull; Anti-Timeout Engine</span>
      </div>
      <h1 class="text-2xl sm:text-3xl font-bold font-academic text-academic-navy">
        Bulk PDF Generator &amp; ZIP Exporter
      </h1>
      <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-2xl">
        Menghasilkan 100 file PDF personal 3 halaman lengkap dengan identitas tamu, logo UII &amp; KOWPI, kotak disertasi, denah lokasi, dan QR code resmi.
      </p>
    </div>

    <!-- ZIP Download Shortcut -->
    <div>
      <a href="<?= base_url('undangan/download-zip') ?>" class="inline-flex items-center space-x-2 px-5 py-3 rounded-xl bg-academic-gold hover:bg-academic-goldlight text-academic-navy font-bold text-xs shadow-md transition transform hover:-translate-y-0.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
        <span>Unduh Bundel ZIP (100 PDF)</span>
      </a>
    </div>
  </div>

  <!-- Progress Dashboard Card -->
  <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 sm:p-8 mb-8">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
      <div>
        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Status Pembuatan File PDF</span>
        <div class="text-3xl font-bold font-academic text-academic-navy mt-1">
          <span x-text="completedCount"><?= $generatedCount ?></span> <span class="text-lg text-slate-400 font-normal">/ <span x-text="totalGuests"><?= $totalGuests ?></span> File PDF</span>
        </div>
      </div>

      <div class="text-right">
        <div class="text-3xl font-bold font-mono text-academic-navy">
          <span x-text="progressPercentage"><?= $totalGuests > 0 ? min(100, round(($generatedCount / $totalGuests) * 100)) : 0 ?></span>%
        </div>
        <div class="text-xs text-slate-400">
          <span x-show="isRunning" class="text-emerald-600 font-bold flex items-center justify-end space-x-1">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
            <span>Sedang Memproses...</span>
          </span>
          <span x-show="!isRunning && isFinished" class="text-emerald-600 font-bold">✓ Selesai 100%</span>
          <span x-show="!isRunning && !isFinished" class="text-slate-400">Siap Dijalankan</span>
        </div>
      </div>
    </div>

    <!-- Animated Progress Bar -->
    <div class="w-full bg-slate-100 h-4 rounded-full overflow-hidden p-0.5 border border-slate-200 mb-6">
      <div class="h-full rounded-full transition-all duration-300 gold-gradient shadow-sm"
           :style="'width: ' + progressPercentage + '%;'"></div>
    </div>

    <!-- Control Buttons -->
    <div class="flex flex-wrap items-center gap-3">
      
      <!-- Start / Resume Button -->
      <button type="button" @click="startBatch()" :disabled="isRunning || isFinished"
              class="px-6 py-3 rounded-xl bg-academic-navy hover:bg-academic-dark disabled:opacity-50 text-white font-bold text-xs shadow-md transition flex items-center space-x-2">
        <svg class="w-4 h-4 text-academic-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span x-text="currentOffset > 0 ? 'Lanjutkan Generate' : 'Mulai Generate Massal (100 PDF)'"></span>
      </button>

      <!-- Pause Button -->
      <button type="button" @click="pauseBatch()" :disabled="!isRunning"
              class="px-4 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 disabled:opacity-50 text-slate-700 font-bold text-xs transition flex items-center space-x-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span>Jeda</span>
      </button>

      <!-- Reset Button -->
      <button type="button" @click="resetBatch()" :disabled="isRunning"
              class="px-4 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 disabled:opacity-50 text-slate-700 font-semibold text-xs transition">
        Ulang dari Awal
      </button>

      <div class="ml-auto text-xs text-slate-500">
        Batch: <strong class="text-academic-navy">5 file per siklus</strong> (Aman dari memory limit &amp; server timeout)
      </div>

    </div>

  </div>

  <!-- Live Terminal Activity Feed -->
  <div class="bg-slate-900 rounded-3xl shadow-xl border border-slate-800 overflow-hidden text-slate-200 font-mono text-xs mb-8">
    
    <div class="px-6 py-3.5 bg-slate-950 border-b border-slate-800 flex items-center justify-between">
      <div class="flex items-center space-x-2">
        <div class="flex space-x-1.5">
          <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
          <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
          <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
        </div>
        <span class="text-[11px] text-slate-400 font-bold ml-2">Console Generator Output</span>
      </div>
      <button @click="logs = []" class="text-[10px] text-slate-500 hover:text-slate-300">Bersihkan Log</button>
    </div>

    <div class="p-6 h-64 overflow-y-auto space-y-1.5 scrollbar-thin" id="logContainer">
      <div class="text-slate-500 italic">// Menunggu perintah eksekusi batch...</div>
      <template x-for="(log, idx) in logs" :key="idx">
        <div class="flex items-start space-x-2 leading-relaxed">
          <span class="text-slate-500" x-text="'[' + log.time + ']'"></span>
          <span :class="log.color" x-html="log.message"></span>
        </div>
      </template>
    </div>

  </div>

</div>

<script>
function bulkPdfApp() {
  return {
    totalGuests: <?= (int)$totalGuests ?>,
    completedCount: <?= (int)$generatedCount ?>,
    currentOffset: 0,
    isRunning: false,
    isFinished: false,
    logs: [],

    get progressPercentage() {
      if (this.totalGuests === 0) return 0;
      return Math.min(100, Math.round((this.completedCount / this.totalGuests) * 100));
    },

    addLog(msg, color = 'text-slate-300') {
      const now = new Date();
      const timeStr = String(now.getHours()).padStart(2, '0') + ':' +
                      String(now.getMinutes()).padStart(2, '0') + ':' +
                      String(now.getSeconds()).padStart(2, '0');
      this.logs.push({ time: timeStr, message: msg, color: color });
      
      this.$nextTick(() => {
        const el = document.getElementById('logContainer');
        if (el) el.scrollTop = el.scrollHeight;
      });
    },

    startBatch() {
      if (this.isRunning) return;
      this.isRunning = true;
      this.isFinished = false;
      this.addLog('Memulai siklus batch generation (5 PDF per siklus)...', 'text-academic-goldlight');
      this.processNextCycle();
    },

    pauseBatch() {
      this.isRunning = false;
      this.addLog('Proses batch dijeda oleh pengguna.', 'text-amber-400');
    },

    resetBatch() {
      this.currentOffset = 0;
      this.completedCount = 0;
      this.isRunning = false;
      this.isFinished = false;
      this.addLog('Offset direset kembali ke 0.', 'text-slate-400');
    },

    async processNextCycle() {
      if (!this.isRunning) return;

      const formData = new FormData();
      formData.append('offset', this.currentOffset);

      try {
        const res = await fetch('<?= base_url('undangan/batch-process') ?>', {
          method: 'POST',
          headers: { 'X-Requested-With': 'XMLHttpRequest' },
          body: formData
        });

        const data = await res.json();

        if (data.success) {
          this.currentOffset = data.nextOffset;
          this.completedCount = Math.min(this.totalGuests, this.currentOffset);

          // Log detail per file
          if (data.items && data.items.length > 0) {
            data.items.forEach(item => {
              this.addLog(`✓ [${item.code}] ${item.name} &rarr; ${item.filename} (${item.size_kb} KB)`, 'text-emerald-400');
            });
          }

          if (data.isDone) {
            this.isRunning = false;
            this.isFinished = true;
            this.completedCount = this.totalGuests;
            this.addLog('🎉 SELURUH FILE PDF BERHASIL DIGENERATE! Siap diunduh sebagai ZIP.', 'text-academic-gold font-bold');
            
            Swal.fire({
              icon: 'success',
              title: 'Generate Massal Selesai!',
              text: `Seluruh ${this.totalGuests} file undangan PDF 3 halaman telah berhasil digenerate.`,
              confirmButtonText: 'Unduh ZIP Sekarang',
              confirmButtonColor: '#0F2C59',
              showCancelButton: true,
              cancelButtonText: 'Tutup'
            }).then((result) => {
              if (result.isConfirmed) {
                window.location.href = '<?= base_url('undangan/download-zip') ?>';
              }
            });

          } else {
            // Next cycle in 300ms
            setTimeout(() => {
              this.processNextCycle();
            }, 300);
          }

        } else {
          this.isRunning = false;
          this.addLog('ERROR: ' + (data.error || 'Gagal memproses batch'), 'text-rose-400');
        }

      } catch (err) {
        console.error(err);
        this.isRunning = false;
        this.addLog('EXCEPTION: Gagal komunikasi dengan server.', 'text-rose-400');
      }
    }
  }
}
</script>

<?= $this->endSection() ?>
