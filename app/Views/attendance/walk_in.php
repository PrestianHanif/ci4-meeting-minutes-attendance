<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="max-w-2xl mx-auto py-4" x-data="walkInApp()">

  <!-- Success Notification Box after submission -->
  <?php if ($success = session()->getFlashdata('success_guest')): ?>
    <div class="mb-6 p-6 rounded-2xl bg-emerald-50 border-2 border-emerald-500 shadow-lg text-emerald-900 animate-in fade-in duration-300">
      <div class="flex items-start space-x-4">
        <div class="w-12 h-12 rounded-full bg-emerald-500 text-white flex items-center justify-center flex-shrink-0 text-xl font-bold shadow-md">
          ✓
        </div>
        <div class="space-y-1">
          <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-200 text-emerald-800 uppercase tracking-wider">
            Registrasi Berhasil
          </span>
          <h2 class="text-xl font-bold font-academic text-emerald-950">
            Ahlan wa Sahlan, <?= esc($success['name']) ?>
          </h2>
          <p class="text-xs text-emerald-800">
            Kehadiran Anda telah dicatat pada pukul <strong><?= esc($success['time']) ?></strong> dengan nomor urut kehadiran <strong>#<?= esc($success['order_number']) ?></strong>.
          </p>
          <div class="pt-2 flex items-center space-x-3">
            <a href="<?= base_url('daftar-hadir') ?>" target="_blank" class="text-xs font-bold text-emerald-800 underline hover:text-emerald-950">
              Lihat di Live Board TV &rarr;
            </a>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <!-- Main Walk-in Form Card -->
  <div class="bg-white rounded-3xl shadow-xl border-2 border-academic-gold/40 overflow-hidden">
    
    <!-- Header Banner -->
    <div class="bg-academic-navy text-white p-5 sm:p-8 text-center relative overflow-hidden border-b-2 border-academic-gold">
      <div class="absolute -right-10 -bottom-10 w-40 h-40 rounded-full bg-academic-gold/20 blur-2xl"></div>

      <div class="inline-flex items-center space-x-2 sm:space-x-3 bg-white px-2.5 py-1 sm:px-3.5 sm:py-1.5 rounded-xl shadow-md mb-3 sm:mb-4 border border-academic-gold/50">
        <img src="<?= base_url('assets/img/logo-uii.png?v=' . time()) ?>" alt="UII" class="h-6 sm:h-8 w-auto max-w-[85px] sm:max-w-[105px] object-contain">
        <div class="h-4 sm:h-6 w-[1.5px] bg-academic-gold"></div>
        <img src="<?= base_url('assets/img/logo-kowpi-coklat.png?v=' . time()) ?>" alt="KOWPI" class="h-5 sm:h-7 w-auto max-w-[90px] sm:max-w-[110px] object-contain">
      </div>

      <div class="text-[10px] sm:text-[11px] uppercase tracking-widest text-academic-gold font-bold">
        Ujian Terbuka Promosi Doktor &bull; FIAI UII x KOWPI
      </div>

      <h1 class="text-lg sm:text-2xl font-bold font-academic text-white mt-1">
        Buku Tamu Kehormatan &amp; Hadir Mandiri
      </h1>

      <p class="text-xs text-slate-300 font-serif italic mt-1 max-w-md mx-auto">
        Bagi Bapak/Ibu/Ustadz yang hadir langsung tanpa undangan tercetak, silakan mengisi daftar hadir singkat di bawah ini.
      </p>

      <?php if (!empty($settings['is_event_completed'])): ?>
      <div class="inline-block mt-3 px-3.5 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-[11px] font-bold border border-emerald-400/30">
        Status: <strong>ACARA TELAH SELESAI DILAKSANAKAN</strong>
      </div>
      <?php else: ?>
      <div class="inline-block mt-3 px-3 py-1 rounded-full bg-white/10 text-academic-goldlight text-[11px] font-mono border border-white/20">
        Kode Registrasi: <strong><?= esc($nextCode) ?></strong>
      </div>
      <?php endif; ?>
    </div>

    <?php if (!empty($settings['is_event_completed'])): ?>
    <!-- Notice: Acara Selesai & Presensi Ditutup -->
    <div class="p-6 sm:p-10 text-center space-y-6 bg-gradient-to-b from-[#FCFBF7] to-white">
      <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto rounded-3xl bg-emerald-100 text-emerald-700 flex items-center justify-center shadow-inner border border-emerald-300">
        <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
      </div>

      <div class="space-y-2 max-w-lg mx-auto">
        <span class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
          <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
          <span>Acara Telah Sukses Terlaksana</span>
        </span>
        <h2 class="text-xl sm:text-2xl font-bold font-academic text-academic-navy">
          Pendaftaran &amp; Presensi Tamu Telah Resmi Ditutup
        </h2>
        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-serif">
          Sidang Ujian Terbuka Promosi Doktor atas nama promovendus <strong>Muhammad Abu Rivai, S.H., M.H.</strong> telah berlangsung dengan lancar dan khidmat pada <strong><?= esc($settings['event_day_date'] ?? 'Selasa, 20 Oktober 2026') ?></strong> di Ruang Sidang FIAI UII.
        </p>
        <p class="text-xs text-slate-500">
          Seluruh data buku tamu dan tanda tangan digital telah direkapitulasi secara permanen sebagai dokumen arsip resmi kehadiran.
        </p>
      </div>

      <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
        <a href="<?= base_url('daftar-hadir') ?>" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-academic-navy hover:bg-academic-dark text-academic-gold font-bold text-xs shadow-lg transition border border-academic-gold/50 flex items-center justify-center space-x-2">
          <svg class="w-4 h-4 text-academic-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
          <span>Buka Rekapitulasi Daftar Hadir Resmi</span>
        </a>
        <a href="<?= base_url('dashboard') ?>" class="w-full sm:w-auto px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center justify-center space-x-2">
          <span>&larr; Kembali ke Dashboard</span>
        </a>
      </div>
    </div>
    <?php else: ?>
    <!-- Form Content -->
    <form action="<?= base_url('tamu-baru/submit') ?>" method="POST" id="walkInForm" class="p-4 sm:p-8 space-y-4 sm:space-y-5 bg-[#FCFBF7]">
      
      <!-- Sapaan & Nama Lengkap -->
      <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
        <div class="sm:col-span-1">
          <label class="block text-xs font-bold text-academic-navy mb-1">Sapaan</label>
          <select name="salutation" class="w-full text-xs px-3 py-2.5 border border-slate-300 rounded-xl bg-white focus:ring-2 focus:ring-academic-navy">
            <option value="Bapak">Bapak</option>
            <option value="Ibu">Ibu</option>
            <option value="Ustadz">Ustadz</option>
            <option value="Ustadzah">Ustadzah</option>
            <option value="K.H.">Kyai / K.H.</option>
            <option value="Prof. Dr.">Prof. Dr.</option>
            <option value="Dr.">Dr.</option>
            <option value="Saudara/i">Saudara/i</option>
          </select>
        </div>

        <div class="sm:col-span-3">
          <label class="block text-xs font-bold text-academic-navy mb-1">
            Nama Lengkap &amp; Gelar Akademik / Keagamaan <span class="text-rose-500">*</span>
          </label>
          <input type="text" name="full_name" required placeholder="Contoh: Dr. H. Ahmad Fauzi, M.Ag." class="w-full text-xs sm:text-sm px-3.5 py-2.5 border border-slate-300 rounded-xl bg-white focus:ring-2 focus:ring-academic-navy shadow-xs font-medium">
        </div>
      </div>

      <!-- Asal Instansi / KOWPI / Domisili -->
      <div>
        <label class="block text-xs font-bold text-academic-navy mb-1">
          Asal Instansi / Pesantren / Lembaga / Domisili <span class="text-rose-500">*</span>
        </label>
        <input type="text" name="institution" required placeholder="Contoh: Pondok Pesantren Krapyak / Pengadilan Agama / KOWPI Solo" class="w-full text-xs sm:text-sm px-3.5 py-2.5 border border-slate-300 rounded-xl bg-white focus:ring-2 focus:ring-academic-navy shadow-xs">
      </div>

      <!-- WhatsApp -->
      <div>
        <label class="block text-xs font-bold text-academic-navy mb-1">
          Nomor WhatsApp Aktif <span class="text-slate-400 font-normal">(Opsional)</span>
        </label>
        <input type="text" name="phone" placeholder="Contoh: 081234567890" class="w-full text-xs sm:text-sm px-3.5 py-2.5 border border-slate-300 rounded-xl bg-white focus:ring-2 focus:ring-academic-navy shadow-xs">
      </div>

      <!-- Doa & Ucapan Restu -->
      <div>
        <label class="block text-xs font-bold text-academic-navy mb-1">
          Doa Restu &amp; Ucapan Selamat untuk Promovendus <span class="text-slate-400 font-normal">(Opsional)</span>
        </label>
        <textarea name="wishes" rows="2" placeholder="Tuliskan doa atau pesan selamat untuk Sdr. Muhammad Abu Rivai, S.H., M.H...." class="w-full text-xs px-3.5 py-2 border border-slate-300 rounded-xl bg-white focus:ring-2 focus:ring-academic-navy shadow-xs"></textarea>
      </div>

      <!-- Kanvas Tanda Tangan Digital -->
      <div>
        <div class="flex items-center justify-between mb-1.5">
          <label class="text-xs font-bold text-academic-navy flex items-center space-x-1.5">
            <span>Tanda Tangan Digital</span>
            <span class="text-[10px] text-slate-400 font-normal">(Goreskan pada layar atau pen tablet)</span>
          </label>
          <button type="button" @click="clearSignature()" class="text-xs font-semibold text-rose-600 hover:text-rose-700 flex items-center space-x-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            <span>Hapus / Bersihkan</span>
          </button>
        </div>

        <div class="border-2 border-dashed border-academic-gold/60 rounded-2xl bg-white relative overflow-hidden shadow-inner flex items-center justify-center">
          <canvas id="walkInCanvas" class="w-full h-48 touch-none cursor-crosshair"></canvas>
          <div class="absolute bottom-2 right-3 pointer-events-none text-[10px] text-slate-300 italic">
            Goreskan tanda tangan di sini
          </div>
        </div>

        <input type="hidden" name="signature_data" id="signatureDataInput">
      </div>

      <!-- Submit Button -->
      <div class="pt-4">
        <button type="submit" @click="prepareSubmit($event)" class="w-full py-3.5 px-6 rounded-2xl bg-academic-navy hover:bg-academic-dark text-white font-bold text-sm shadow-xl transition transform hover:-translate-y-0.5 flex items-center justify-center space-x-2 border border-academic-gold/40">
          <svg class="w-5 h-5 text-academic-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
          <span>Simpan &amp; Masuk Daftar Hadir Publik</span>
        </button>
      </div>

      <div class="text-center pt-2">
        <a href="<?= base_url('absensi') ?>" class="text-xs font-semibold text-slate-500 hover:text-academic-navy transition">
          &larr; Kembali ke Meja Absensi 100 Tamu Undangan
        </a>
      </div>

    </form>
    <?php endif; ?>

  </div>

  <!-- Recent 5 Walk-in Attendees -->
  <?php if (!empty($recentWalkIns)): ?>
    <div class="mt-8 bg-white rounded-2xl p-5 border border-slate-200 shadow-xs">
      <div class="text-xs font-bold text-academic-navy uppercase tracking-wider mb-3 flex items-center space-x-1.5">
        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
        <span>Tamu Walk-in yang Baru Saja Mendaftar</span>
      </div>

      <div class="divide-y divide-slate-100 text-xs">
        <?php foreach ($recentWalkIns as $w): ?>
          <div class="py-2.5 flex items-center justify-between">
            <div>
              <div class="font-bold text-slate-800"><?= esc($w['full_name']) ?></div>
              <div class="text-[11px] text-slate-400"><?= esc($w['institution']) ?></div>
            </div>
            <div class="text-right">
              <span class="px-2 py-0.5 rounded font-mono text-[10px] font-bold bg-emerald-100 text-emerald-800">
                <?= esc($w['guest_code']) ?>
              </span>
              <div class="text-[10px] text-slate-400 mt-0.5">
                <?= date('H:i', strtotime($w['check_in_time'])) ?> WIB
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>

</div>

<script>
function walkInApp() {
  return {
    pad: null,

    init() {
      this.$nextTick(() => {
        const canvas = document.getElementById('walkInCanvas');
        if (!canvas) return;

        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);

        this.pad = new SignaturePad(canvas, {
          minWidth: 1.5,
          maxWidth: 3.5,
          penColor: '#0F2C59',
          backgroundColor: 'rgba(255, 255, 255, 0)',
        });
      });
    },

    clearSignature() {
      if (this.pad) {
        this.pad.clear();
      }
    },

    prepareSubmit(e) {
      if (this.pad && !this.pad.isEmpty()) {
        const dataUrl = this.pad.toDataURL('image/png');
        document.getElementById('signatureDataInput').value = dataUrl;
      }
    }
  }
}
</script>

<?= $this->endSection() ?>
