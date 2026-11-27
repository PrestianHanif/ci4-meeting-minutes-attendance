<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Undangan Sidang Promosi Doktor - <?= esc($guest['full_name']) ?></title>
  <style>
    @page {
      margin: 7mm 7mm 7mm 7mm;
      background: #FCFBF7;
    }

    body {
      font-family: notoserif, 'Times New Roman', serif;
      color: #1E293B;
      font-size: 8.5pt;
      line-height: 1.4;
      background: #FCFBF7;
      margin: 0;
      padding: 0;
    }

    /* Utilitas Warna KOWPI & UII */
    .text-navy { color: #0F2C59; }
    .text-gold { color: #C5A059; }
    .text-slate { color: #475569; }
    .bg-ivory { background-color: #FCFBF7; }
    .bg-soft { background-color: #F8F6F0; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-justify { text-align: justify; }
    .font-bold { font-weight: bold; }
    .italic { font-style: italic; }

    /* ==============================================================
       HALAMAN 1: COVER PROPORSIONAL STANDAR A5 (148x210mm)
       ============================================================== */
    .cover-frame-outer {
      border: 2.5px solid #C5A059;
      padding: 2.5mm;
      background: #FCFBF7;
      box-sizing: border-box;
    }

    .cover-frame-inner {
      border: 1px solid #0F2C59;
      padding: 4mm 3.5mm;
      box-sizing: border-box;
      text-align: center;
    }

    .logo-table {
      width: 100%;
      margin-bottom: 3mm;
    }

    .logo-table td {
      vertical-align: middle;
      text-align: center;
    }

    .divider-gold {
      width: 140px;
      height: 1.5px;
      background-color: #C5A059;
      margin: 2mm auto 3.5mm auto;
    }

    .cover-subtitle {
      font-size: 8.5pt;
      letter-spacing: 2px;
      color: #475569;
      text-transform: uppercase;
      font-weight: bold;
      margin-bottom: 3mm;
    }

    .cover-title-main {
      font-size: 13.5pt;
      font-weight: bold;
      color: #0F2C59;
      letter-spacing: 0.8px;
      margin-bottom: 2.5mm;
      text-transform: uppercase;
    }

    .cover-prodi {
      font-size: 9.5pt;
      font-weight: bold;
      color: #0F2C59;
      line-height: 1.4;
      text-transform: uppercase;
      margin-bottom: 4mm;
    }

    .cover-promovendus-box {
      margin: 0 auto 4mm auto;
      width: 90%;
      padding: 2.5mm 0;
      border-top: 1px dashed #C5A059;
      border-bottom: 1px dashed #C5A059;
    }

    .promovendus-name {
      font-size: 14pt;
      font-weight: bold;
      color: #0F2C59;
      letter-spacing: 0.5px;
      margin: 0.5mm 0;
    }

    .promovendus-nim {
      font-size: 8.5pt;
      color: #64748B;
      font-weight: normal;
    }

    .cover-date-box {
      margin-bottom: 4mm;
      line-height: 1.4;
    }

    /* Kotak Tamu Undangan di Halaman 1 */
    .recipient-card {
      width: 90%;
      margin: 0 auto 3.5mm auto;
      border: 1.4px solid #C5A059;
      border-radius: 5px;
      background-color: #F8F5EC;
      padding: 4mm 3mm;
      text-align: center;
    }

    .recipient-label {
      font-size: 8.5pt;
      color: #64748B;
      font-style: italic;
    }

    .recipient-name {
      font-size: 12.5pt;
      font-weight: bold;
      color: #0F2C59;
      line-height: 1.3;
      margin: 1.5mm 0;
    }

    .recipient-inst {
      font-size: 9pt;
      color: #334155;
      font-weight: 600;
    }

    .recipient-note {
      font-size: 7.5pt;
      color: #94A3B8;
      font-style: italic;
      margin-top: 2.5mm;
      border-top: 0.5px solid #E2E8F0;
      padding-top: 1mm;
    }

    /* ==============================================================
       HALAMAN 2: HALAMAN INTI UNDANGAN & DEWAN PENGUJI (STANDAR A5)
       ============================================================== */
    .letter-container {
      padding: 0;
    }

    .letter-header {
      border-bottom: 2px solid #0F2C59;
      padding-bottom: 2mm;
      margin-bottom: 3.5mm;
    }

    .letter-header-table {
      width: 100%;
    }

    .letter-header-table td {
      vertical-align: middle;
    }

    .salutation {
      font-size: 10pt;
      font-weight: bold;
      color: #0F2C59;
      margin-bottom: 2mm;
    }

    .letter-body {
      font-size: 8.8pt;
      text-align: justify;
      line-height: 1.45;
      margin-bottom: 3mm;
    }

    .event-details-table {
      width: 100%;
      margin-bottom: 3mm;
      font-size: 8.5pt;
      border-collapse: collapse;
      line-height: 1.4;
    }

    .event-details-table td {
      padding: 0.8mm 0;
      vertical-align: top;
    }

    .event-label {
      width: 95px;
      font-weight: bold;
      color: #0F2C59;
    }

    .dissertation-box {
      border: 1.2px solid #C5A059;
      background-color: #F8F5EC;
      border-radius: 4px;
      padding: 2.5mm 3mm;
      margin: 3mm 0;
      text-align: center;
    }

    .dissertation-label {
      font-size: 7.5pt;
      text-transform: uppercase;
      letter-spacing: 1.2px;
      color: #C5A059;
      font-weight: bold;
    }

    .dissertation-title {
      font-size: 9.2pt;
      font-weight: bold;
      color: #0F2C59;
      line-height: 1.35;
      margin-top: 0.5mm;
    }

    /* Grid Dewan Penguji */
    .examiner-title {
      font-size: 8.5pt;
      font-weight: bold;
      color: #0F2C59;
      border-bottom: 1px solid #C5A059;
      padding-bottom: 0.5mm;
      margin: 2.5mm 0 1.5mm 0;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .examiner-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 7.8pt;
      margin-bottom: 2.5mm;
    }

    .examiner-table td {
      padding: 0.8mm 0.5mm;
      vertical-align: top;
      border-bottom: 0.5px dotted #E2E8F0;
    }

    .examiner-role {
      font-weight: bold;
      color: #0F2C59;
      width: 100px;
    }

    /* ==============================================================
       HALAMAN 3: CATATAN & DENAH GEDUNG/PARKIR (STANDAR A5)
       ============================================================== */
    .page3-header {
      background: #0F2C59;
      color: #FFFFFF;
      padding: 1.8mm 3mm;
      text-align: center;
      border-radius: 4px;
      margin-bottom: 1.8mm;
    }

    .page3-header h2 {
      font-size: 8.8pt;
      margin: 0;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }

    .rules-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 1.5mm;
    }

    .rules-table td {
      vertical-align: top;
    }

    .notice-box {
      border: 1px solid #059669;
      background-color: #ECFDF5;
      padding: 1.8mm 2.5mm;
      border-radius: 4px;
      margin: 1.5mm 0 1.8mm 0;
      font-size: 6.8pt;
      line-height: 1.32;
      color: #065F46;
    }

    .denah-section-title {
      font-size: 8.2pt;
      font-weight: bold;
      color: #0F2C59;
      border-left: 3px solid #C5A059;
      padding-left: 2mm;
      margin: 1.5mm 0 1.5mm 0;
      text-transform: uppercase;
      letter-spacing: 0.4px;
    }
  </style>
</head>
<body>

  <!-- ==============================================================
       HALAMAN 1: SAMPUL (COVER) BINGKAI PENUH STANDAR A5 (148x210mm)
       ============================================================== -->
  <div class="cover-frame-outer">
    <div class="cover-frame-inner">

      <!-- Header Logo UII & KOWPI Sejajar -->
      <table class="logo-table">
        <tr>
          <td style="width: 44%; text-align: right; vertical-align: middle; padding-right: 3mm;">
            <img src="<?= $logoUii ?>" height="44" alt="Logo UII" />
          </td>
          <td style="width: 12%; text-align: center; vertical-align: middle;">
            <div style="width: 1.5px; height: 38px; background-color: #C5A059; margin: 0 auto;"></div>
          </td>
          <td style="width: 44%; text-align: left; vertical-align: middle; padding-left: 3mm;">
            <img src="<?= $logoKowpi ?>" height="36" alt="Logo KOWPI" />
          </td>
        </tr>
      </table>

      <!-- Teks Identitas Lembaga & Acara -->
      <div class="cover-subtitle">UNIVERSITAS ISLAM INDONESIA &bull; KOWPI</div>
      
      <div style="margin-bottom: 1.5mm;">
        <span style="font-size: 19pt; font-weight: bold; font-style: italic; color: #0F2C59;">Undangan</span>
      </div>

      <div class="divider-gold"></div>

      <div class="cover-title-main">UJIAN TERBUKA (PROMOSI DOKTOR)</div>
      <div class="cover-prodi">
        PROGRAM STUDI HUKUM ISLAM PROGRAM DOKTOR<br/>
        FAKULTAS ILMU AGAMA ISLAM<br/>
        UNIVERSITAS ISLAM INDONESIA
      </div>

      <!-- Promovendus Box -->
      <div class="cover-promovendus-box">
        <div style="font-size: 8pt; text-transform: uppercase; letter-spacing: 1.2px; color: #64748B;">Promovendus:</div>
        <div class="promovendus-name">Muhammad Abu Rivai</div>
        <div class="promovendus-nim">NIM: <?= esc($settings['candidate_nim'] ?? '21933020 (HI)') ?></div>
      </div>

      <!-- Tanggal Pelaksanaan (Jumadil Awal dengan spasi) -->
      <div class="cover-date-box">
        <div style="font-size: 9.5pt; font-weight: bold; color: #0F2C59;">
          <?= esc($settings['event_hijri_date'] ?? 'Selasa, 9 Jumadil Awal 1448 H') ?>
        </div>
        <div style="font-size: 10.5pt; font-weight: bold; color: #C5A059; margin-top: 0.5mm;">
          <?= esc($settings['event_day_date'] ?? 'Selasa, 20 Oktober 2026 M') ?>
        </div>
      </div>

      <!-- Kotak Tamu Undangan di Halaman 1 -->
      <div class="recipient-card">
        <div class="recipient-label">Kepada Yth. Bapak / Ibu / Ustadz / Saudara/i:</div>
        <div class="recipient-name"><?= esc($guest['full_name']) ?></div>
        <div class="recipient-inst"><?= esc($guest['institution'] ?: 'Di Tempat') ?></div>
        <div class="recipient-note">Mohon maaf apabila ada kesalahan penulisan nama/gelar</div>
      </div>

      <div style="font-size: 8pt; color: #64748B; padding-top: 1mm;">
        KODE REGISTRASI: <strong style="color: #0F2C59;"><?= esc($guest['guest_code']) ?></strong>
      </div>

    </div>
  </div>

  <pagebreak />

  <!-- ==============================================================
       HALAMAN 2: HALAMAN INTI UNDANGAN & DEWAN PENGUJI (STANDAR A5)
       ============================================================== -->
  <div class="letter-container">

    <!-- Kop Surat Resmi (Satu Baris Penuh Tanpa Terpotong) -->
    <div class="letter-header">
      <table class="letter-header-table" style="width: 100%;">
        <tr>
          <td style="width: 12%; text-align: left; vertical-align: middle;">
            <img src="<?= $logoUii ?>" height="38" alt="UII" />
          </td>
          <td style="width: 76%; text-align: center; vertical-align: middle; line-height: 1.25;">
            <div style="font-size: 11pt; font-weight: bold; color: #0F2C59; text-transform: uppercase;">
              UNIVERSITAS ISLAM INDONESIA
            </div>
            <div style="font-size: 8.2pt; font-weight: bold; color: #0F2C59; text-transform: uppercase; white-space: nowrap; letter-spacing: -0.2px;">
              FAKULTAS ILMU AGAMA ISLAM &bull; PROGRAM DOKTOR HUKUM ISLAM
            </div>
            <div style="font-size: 7pt; color: #64748B; margin-top: 0.5mm;">
              Gedung K.H. A. Wahid Hasyim, Kampus Terpadu UII, Jl. Kaliurang KM. 14,5 Sleman Yogyakarta 55584
            </div>
          </td>
          <td style="width: 12%; text-align: right; vertical-align: middle;">
            <img src="<?= $logoKowpi ?>" height="28" alt="KOWPI" />
          </td>
        </tr>
      </table>
    </div>

    <!-- Salam Pembuka & Paragraf Pengantar -->
    <div class="salutation">Assalamu'alaikum Wr. Wb.</div>
    <div class="letter-body">
      Mengharap dengan hormat kehadiran Bapak/Ibu/Saudara/i <strong class="text-navy"><?= esc($guest['full_name']) ?></strong> pada acara <strong>"Ujian Terbuka (Promosi Doktor)"</strong> yang insya Allah akan diselenggarakan pada:
    </div>

    <!-- Rincian Waktu & Tempat (Ejaan Jumadil Awal dengan spasi) -->
    <table class="event-details-table">
      <tr>
        <td class="event-label">Hari / Tanggal</td>
        <td style="width: 8px;">:</td>
        <td><strong><?= esc($settings['event_day_date'] ?? 'Selasa, 20 Oktober 2026') ?></strong> (<?= esc(str_replace('Selasa, ', '', $settings['event_hijri_date'] ?? '9 Jumadil Awal 1448 H')) ?>)</td>
      </tr>
      <tr>
        <td class="event-label">Pukul</td>
        <td>:</td>
        <td><strong><?= esc(str_replace(['?', '–'], '-', $settings['event_time'] ?? '09.00 - 11.00 WIB')) ?></strong> (Hadir 15 menit sebelum acara)</td>
      </tr>
      <tr>
        <td class="event-label">Tempat Ujian</td>
        <td>:</td>
        <td><strong><?= esc($settings['event_room'] ?? 'Ruang 03.16 Gedung K.H. A. Wahid Hasyim, Kampus Terpadu UII') ?></strong></td>
      </tr>
      <tr>
        <td class="event-label">Live Streaming</td>
        <td>:</td>
        <td><a href="https://www.youtube.com/@hukumislamprogramdoktor" style="color: #0284C7; text-decoration: none;">https://www.youtube.com/@hukumislamprogramdoktor</a></td>
      </tr>
      <tr>
        <td class="event-label">Acara</td>
        <td>:</td>
        <td>Ujian Terbuka (Promosi Doktor) bagi Sdr. <strong>Muhammad Abu Rivai</strong> (NIM: <?= esc($settings['candidate_nim'] ?? '21933020') ?>)</td>
      </tr>
    </table>

    <!-- Boks Judul Disertasi -->
    <div class="dissertation-box">
      <div class="dissertation-label">Judul Disertasi:</div>
      <div class="dissertation-title">
        "<?= esc($settings['dissertation_title'] ?? 'DINAMIKA PERENCANAAN WARIS DALAM MITIGASI SENGKETA PADA MASYARAKAT JAWA MUSLIM') ?>"
      </div>
    </div>

    <!-- Susunan Dewan Penguji (Grid Rapi) -->
    <div class="examiner-title">Susunan Dewan Penguji:</div>
    <table class="examiner-table">
      <tr>
        <td class="examiner-role">Promotor</td>
        <td style="width: 8px;">:</td>
        <td><strong>Prof. Dr. Euis Nurlaelawati, M.A.</strong></td>
        <td class="examiner-role">Sekretaris Sidang</td>
        <td style="width: 8px;">:</td>
        <td><strong>Dzulkifli Hadi Imawan, Ph.D</strong></td>
      </tr>
      <tr>
        <td class="examiner-role">Kopromotor</td>
        <td>:</td>
        <td><strong>Dr. Drs. Asmuni, M.A.</strong></td>
        <td class="examiner-role">Anggota Penguji 1</td>
        <td>:</td>
        <td><strong>Dr. M. Roem Syibly, M.S.I.</strong></td>
      </tr>
      <tr>
        <td class="examiner-role">Ketua Sidang</td>
        <td>:</td>
        <td><strong>Prof. Dr. Ir. Hari Purnomo, IPU</strong></td>
        <td class="examiner-role">Anggota Penguji 2</td>
        <td>:</td>
        <td><strong>Prof. Dr. Amir Mu'allim, MIS.</strong></td>
      </tr>
      <tr>
        <td class="examiner-role">Anggota Penguji 3</td>
        <td>:</td>
        <td colspan="4"><strong>Dr. Agus Sudaryanto, SH., MSI.</strong></td>
      </tr>
    </table>

    <!-- Kalimat Penutup & Pengesahan -->
    <div style="font-size: 8.5pt; line-height: 1.4; margin: 2mm 0 1mm 0;">
      Akan dipertahankan di hadapan Dewan Penguji. Atas perhatian dan kehadiran Bapak/Ibu/Saudara/i, diucapkan terima kasih.
    </div>

    <div style="font-size: 9pt; margin: 1mm 0 2mm 0;">
      Wassalamu'alaikum Wr. Wb.
    </div>

    <!-- Area Pengesahan / Tanda Tangan KOWPI Proporsional di Bagian Bawah -->
    <table style="width: 100%; margin-top: 4mm;">
      <tr>
        <td style="width: 48%;"></td>
        <td style="width: 52%; text-align: center;">
          <div style="font-size: 8.8pt; color: #1E293B;">
            <?= esc($letterDate ?? ('Yogyakarta, ' . date('d F Y'))) ?>
          </div>

          <div style="margin: 1.5mm auto;">
            <img src="<?= $stempelKowpiImg ?>" height="54" style="display: block; margin: 0 auto;" alt="Stempel KOWPI" />
          </div>

          <div style="font-size: 9.8pt; font-weight: bold; color: #0F2C59; text-decoration: underline; margin-top: 1mm;">
            Muhammad Abu Rivai, S.H., M.H.
          </div>
        </td>
      </tr>
    </table>

  </div>

  <pagebreak />

  <!-- ==============================================================
       HALAMAN 3: CATATAN, KETENTUAN & DENAH GEDUNG/PARKIR (STANDAR A5)
       ============================================================== -->
  <div class="letter-container">

    <!-- Header Ketentuan -->
    <div class="page3-header">
      <h2>CATATAN &amp; KETENTUAN TATA TERTIB SIDANG</h2>
    </div>

    <!-- Daftar Ketentuan Poin 1 s/d 5 (Lengkap Sesuai Pedoman Resmi) -->
    <table class="rules-table">
      <tr>
        <td style="width: 14px; font-weight: bold; font-size: 7.1pt; color: #1E293B; padding-bottom: 0.8mm;">1.</td>
        <td style="font-size: 7.1pt; line-height: 1.28; color: #1E293B; padding-bottom: 0.8mm; text-align: justify;">
          <strong>Waktu Pelaksanaan:</strong> Acara dimulai tepat pukul <strong>09.00 - 11.00 WIB</strong>. Tamu undangan dimohon hadir 15 menit lebih awal.
        </td>
      </tr>
      <tr>
        <td style="font-weight: bold; font-size: 7.1pt; color: #1E293B; padding-bottom: 0.8mm;">2.</td>
        <td style="font-size: 7.1pt; line-height: 1.28; color: #1E293B; padding-bottom: 0.8mm; text-align: justify;">
          <strong>Penutupan Pintu Sidang:</strong> Pintu utama Ruang Sidang 03.16 ditutup tepat pada saat Ketua Sidang dan Dewan Penguji memasuki Ruang Sidang. Tamu yang terlambat dimohon menunggu di ruang transit yang disediakan.
        </td>
      </tr>
      <tr>
        <td style="font-weight: bold; font-size: 7.1pt; color: #1E293B; padding-bottom: 0.8mm;">3.</td>
        <td style="font-size: 7.1pt; line-height: 1.28; color: #1E293B; padding-bottom: 0.8mm;">
          <strong>Ketentuan Pakaian:</strong>
          <table style="width: 100%; border-collapse: collapse; margin-top: 0.3mm;">
            <tr>
              <td style="width: 12px; font-size: 7.1pt; color: #1E293B; padding: 0.2mm 0;">&bull;</td>
              <td style="font-size: 7.1pt; line-height: 1.26; color: #1E293B; padding: 0.2mm 0;">
                <strong>Bapak:</strong> Pakaian Sipil Lengkap (PSL) / Batik Lengan Panjang Rapi.
              </td>
            </tr>
            <tr>
              <td style="font-size: 7.1pt; color: #1E293B; padding: 0.2mm 0;">&bull;</td>
              <td style="font-size: 7.1pt; line-height: 1.26; color: #1E293B; padding: 0.2mm 0;">
                <strong>Ibu:</strong> Busana Muslimah / Sopan dan Rapi.
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td style="font-weight: bold; font-size: 7.1pt; color: #1E293B; padding-bottom: 0.8mm;">4.</td>
        <td style="font-size: 7.1pt; line-height: 1.28; color: #1E293B; padding-bottom: 0.8mm;">
          <strong>Protokol Kesehatan &amp; Ketertiban:</strong>
          <table style="width: 100%; border-collapse: collapse; margin-top: 0.3mm;">
            <tr>
              <td style="width: 14px; font-size: 7.1pt; color: #1E293B; padding: 0.2mm 0;">a.</td>
              <td style="font-size: 7.1pt; line-height: 1.26; color: #1E293B; padding: 0.2mm 0; text-align: justify;">
                Menjaga kebersihan dan ketertiban sebelum dan sesudah memasuki ruang sidang.
              </td>
            </tr>
            <tr>
              <td style="font-size: 7.1pt; color: #1E293B; padding: 0.2mm 0;">b.</td>
              <td style="font-size: 7.1pt; line-height: 1.26; color: #1E293B; padding: 0.2mm 0; text-align: justify;">
                Memakai masker selama acara berlangsung jika merasa kurang sehat.
              </td>
            </tr>
            <tr>
              <td style="font-size: 7.1pt; color: #1E293B; padding: 0.2mm 0;">c.</td>
              <td style="font-size: 7.1pt; line-height: 1.26; color: #1E293B; padding: 0.2mm 0; text-align: justify;">
                Menempati tempat duduk yang telah dialokasikan oleh panitia registrasi.
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td style="font-weight: bold; font-size: 7.1pt; color: #1E293B; padding-bottom: 0.4mm;">5.</td>
        <td style="font-size: 7.1pt; line-height: 1.28; color: #1E293B; padding-bottom: 0.4mm;">
          <strong>Larangan Selama Ujian Sidang Berlangsung:</strong>
          <table style="width: 100%; border-collapse: collapse; margin-top: 0.3mm;">
            <tr>
              <td style="width: 14px; font-size: 7.1pt; color: #1E293B; padding: 0.2mm 0;">a.</td>
              <td style="font-size: 7.1pt; line-height: 1.26; color: #1E293B; padding: 0.2mm 0; text-align: justify;">
                Tidak diperkenankan meninggalkan Ruang Sidang sebelum prosesi ujian ditutup secara resmi.
              </td>
            </tr>
            <tr>
              <td style="font-size: 7.1pt; color: #1E293B; padding: 0.2mm 0;">b.</td>
              <td style="font-size: 7.1pt; line-height: 1.26; color: #1E293B; padding: 0.2mm 0; text-align: justify;">
                Menonaktifkan suara / mengalihkan perangkat telepon genggam (Handphone) ke mode senyap (Silent).
              </td>
            </tr>
            <tr>
              <td style="font-size: 7.1pt; color: #1E293B; padding: 0.2mm 0;">c.</td>
              <td style="font-size: 7.1pt; line-height: 1.26; color: #1E293B; padding: 0.2mm 0; text-align: justify;">
                Tidak diperkenankan membawa anak kecil di bawah usia 12 tahun ke dalam ruang sidang.
              </td>
            </tr>
            <tr>
              <td style="font-size: 7.1pt; color: #1E293B; padding: 0.2mm 0;">d.</td>
              <td style="font-size: 7.1pt; line-height: 1.26; color: #1E293B; padding: 0.2mm 0; text-align: justify;">
                Menghindari segala aktivitas atau suara yang dapat mengganggu kekhidmatan jalannya ujian terbuka.
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    <!-- Poin 6: Kotak Khusus Ramah Lingkungan (Persis Sesuai Permintaan) -->
    <div class="notice-box">
      <div style="font-weight: bold; color: #065F46; font-size: 7.1pt; margin-bottom: 0.6mm; letter-spacing: 0.3px;">
        KOMITMEN PELESTARIAN LINGKUNGAN KAMPUS:
      </div>
      <div style="color: #065F46; line-height: 1.3; font-size: 6.8pt; text-align: justify;">
        Tanpa mengurangi rasa hormat, sebagai ikhtiar dan komitmen bersama untuk pelestarian lingkungan serta kebersihan kampus, <strong>panitia tidak menerima ucapan selamat dalam bentuk Karangan Bunga (Papan Bunga)</strong>. Doa restu dan kehadiran Bapak/Ibu/Saudara/i merupakan kehormatan terbesar bagi kami.
      </div>
    </div>

    <!-- Denah Gedung K.H. A. Wahid Hasyim & Panduan Parkir -->
    <div class="denah-section-title">
      DENAH AKSES KAMPUS TERPADU &amp; LOKASI RUANG SIDANG 03.16
    </div>

    <!-- Denah Peta Kampus & Lokasi Gedung FIAI (Ukuran Pas di Kertas A5) -->
    <div style="text-align: center; margin: 1mm 0 2mm 0;">
      <img src="<?= !empty($denahImg) ? $denahImg : $denahSvg ?>" width="100%" style="max-height: 48mm; border: 1px solid #CBD5E1; border-radius: 4px;" alt="Denah Kampus UII & Gedung FIAI" />
    </div>

    <!-- 2 Kartu QR Code Berdampingan: Google Maps & Buku Tamu Digital -->
    <table style="width: 100%; border-collapse: collapse; margin-top: 1mm;">
      <tr>
        <!-- Kartu 1: Google Maps Navigasi -->
        <td style="width: 50%; padding-right: 2mm; vertical-align: top;">
          <table style="width: 100%; border: 1px solid #CBD5E1; border-radius: 4px; background-color: #F8FAFC; border-collapse: collapse;">
            <tr>
              <td style="width: 56px; padding: 2mm; vertical-align: middle; text-align: center; background-color: #FFFFFF; border-right: 1px dashed #CBD5E1;">
                <img src="<?= $mapsQr ?>" width="46" height="46" style="display: block; margin: 0 auto;" alt="QR Google Maps" />
              </td>
              <td style="padding: 2mm 2.5mm; vertical-align: middle; text-align: left;">
                <div style="font-size: 7.8pt; font-weight: bold; color: #0F2C59; margin-bottom: 0.5mm;">
                  NAVIGASI GOOGLE MAPS
                </div>
                <div style="font-size: 6.8pt; color: #475569; line-height: 1.25;">
                  Pindai rute GPS ke <strong>Gedung FIAI UII</strong>.
                </div>
                <div style="font-size: 6.5pt; color: #0284C7; font-weight: bold; margin-top: 0.5mm;">
                  maps.app.goo.gl/jbxZwqgbMHjEpuUN8
                </div>
              </td>
            </tr>
          </table>
        </td>

        <!-- Kartu 2: Buku Tamu Digital & Presensi -->
        <td style="width: 50%; padding-left: 2mm; vertical-align: top;">
          <table style="width: 100%; border: 1px solid #CBD5E1; border-radius: 4px; background-color: #F8FAFC; border-collapse: collapse;">
            <tr>
              <td style="width: 56px; padding: 2mm; vertical-align: middle; text-align: center; background-color: #FFFFFF; border-right: 1px dashed #CBD5E1;">
                <img src="<?= $guestBookQr ?>" width="46" height="46" style="display: block; margin: 0 auto;" alt="QR Buku Tamu" />
              </td>
              <td style="padding: 2mm 2.5mm; vertical-align: middle; text-align: left;">
                <div style="font-size: 7.8pt; font-weight: bold; color: #0F2C59; margin-bottom: 0.5mm;">
                  BUKU TAMU DIGITAL
                </div>
                <div style="font-size: 6.8pt; color: #475569; line-height: 1.25;">
                  Pindai di lokasi untuk verifikasi kehadiran di meja tamu.
                </div>
                <div style="font-size: 6.8pt; color: #B45309; font-weight: bold; margin-top: 0.5mm;">
                  KODE: <span style="background-color: #FEF3C7; padding: 0.3mm 1mm; border-radius: 2px; border: 0.5px solid #F59E0B;"><?= esc($guest['guest_code']) ?></span>
                </div>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

  </div>

</body>
</html>
