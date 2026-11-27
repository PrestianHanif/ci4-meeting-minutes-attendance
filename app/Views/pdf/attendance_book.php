<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= esc($docTitle ?? 'Daftar Hadir Sidang Promosi Doktor') ?></title>
  <style>
    @page {
      margin: 12mm 15mm 15mm 15mm;
      footer: html_pageFooter;
    }

    body {
      font-family: 'Noto Serif', serif, DejaVuSans, sans-serif;
      font-size: 8.5pt;
      color: #1E293B;
      line-height: 1.35;
    }

    .font-sans {
      font-family: Arial, Helvetica, sans-serif;
    }

    /* Kop Surat Resmi */
    .kop-table {
      width: 100%;
      border-bottom: 2px solid #0F2C59;
      padding-bottom: 3mm;
      margin-bottom: 4mm;
    }

    .kop-table td {
      vertical-align: middle;
    }

    .divider-subline {
      height: 1px;
      background-color: #C5A059;
      margin-top: 1mm;
    }

    /* Judul Berita Acara */
    .title-section {
      text-align: center;
      margin-bottom: 4mm;
    }

    .main-title {
      font-size: 13pt;
      font-weight: bold;
      color: #0F2C59;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      margin: 0;
    }

    .sub-title {
      font-size: 10pt;
      font-weight: bold;
      color: #C5A059;
      text-transform: uppercase;
      margin-top: 1mm;
      letter-spacing: 1px;
    }

    /* Meta Info Card */
    .meta-box {
      width: 100%;
      margin-bottom: 4mm;
      background-color: #F8F5EC;
      border: 1px solid #E2D9C2;
      border-radius: 4px;
      padding: 2.5mm 4mm;
      font-size: 8pt;
    }

    .meta-box td {
      vertical-align: top;
      padding: 0.5mm 1mm;
    }

    /* Tabel Kehadiran */
    .attendance-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 5mm;
      font-size: 7.8pt;
    }

    .attendance-table th {
      background-color: #0F2C59;
      color: #FFFFFF;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 7.5pt;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 0.3px;
      padding: 2mm 1.5mm;
      border: 0.5px solid #0F2C59;
      text-align: center;
    }

    .attendance-table td {
      padding: 1.8mm 1.5mm;
      border: 0.5px solid #CBD5E1;
      vertical-align: middle;
    }

    .attendance-table tr:nth-child(even) td {
      background-color: #F8FAFC;
    }

    .badge-invited {
      display: inline-block;
      padding: 1px 4px;
      background-color: #EFF6FF;
      color: #1D4ED8;
      border-radius: 3px;
      font-size: 6.8pt;
      font-weight: bold;
      font-family: Arial, sans-serif;
    }

    .badge-walkin {
      display: inline-block;
      padding: 1px 4px;
      background-color: #ECFDF5;
      color: #047857;
      border-radius: 3px;
      font-size: 6.8pt;
      font-weight: bold;
      font-family: Arial, sans-serif;
    }

    /* Ringkasan Statistik */
    .stats-summary {
      width: 100%;
      margin-bottom: 5mm;
      border-collapse: collapse;
    }

    .stats-summary td {
      padding: 2mm 3mm;
      border: 1px solid #CBD5E1;
      background-color: #FFFFFF;
      text-align: center;
      width: 20%;
    }

    .stats-num {
      font-size: 12pt;
      font-weight: bold;
      color: #0F2C59;
      font-family: Arial, sans-serif;
    }

    .stats-lbl {
      font-size: 7pt;
      color: #64748B;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-top: 0.5mm;
    }

    /* Tanda Tangan Pengesahan (Single Promovendus & Cap KOWPI) */
    .sign-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 4mm;
      page-break-inside: avoid;
    }

    .sign-table td {
      vertical-align: top;
      font-size: 8.5pt;
    }
  </style>
</head>
<body>

  <!-- Header & Footer Template untuk mPDF -->
  <htmlpagefooter name="pageFooter">
    <table style="width: 100%; border-top: 0.5px solid #CBD5E1; padding-top: 2mm; font-size: 7pt; color: #64748B;">
      <tr>
        <td style="width: 50%; text-align: left;">
          Sistem Absensi Digital Sidang Promosi Doktor &bull; FIAI UII x KOWPI &bull; Dicetak: <?= date('d/m/Y H:i:s') ?> WIB
        </td>
        <td style="width: 50%; text-align: right;">
          Halaman {PAGENO} dari {nbpg}
        </td>
      </tr>
    </table>
  </htmlpagefooter>

  <!-- Kop Surat Resmi UII x KOWPI (Simetris) -->
  <table class="kop-table">
    <tr>
      <td style="width: 18%; text-align: left;">
        <img src="<?= $logoUii ?>" height="42" style="max-height: 42px;" alt="Logo UII" />
      </td>
      <td style="width: 64%; text-align: center;">
        <div style="font-size: 11pt; font-weight: bold; color: #0F2C59; text-transform: uppercase; letter-spacing: 0.5px;">
          UNIVERSITAS ISLAM INDONESIA
        </div>
        <div style="font-size: 9.5pt; font-weight: bold; color: #0F2C59; text-transform: uppercase; margin-top: 0.5mm;">
          FAKULTAS ILMU AGAMA ISLAM &bull; PROGRAM DOKTOR HUKUM ISLAM
        </div>
        <div style="font-size: 7pt; color: #64748B; margin-top: 1mm; font-family: Arial, sans-serif;">
          Gedung K.H. A. Wahid Hasyim, Kampus Terpadu UII, Jl. Kaliurang KM. 14,5 Sleman Yogyakarta 55584<br/>
          Website: doctorate.islamic.uii.ac.id | Email: dhi@uii.ac.id | Telp: (0274) 898444
        </div>
        <div class="divider-subline"></div>
      </td>
      <td style="width: 18%; text-align: right;">
        <img src="<?= $logoKowpi ?>" height="34" style="max-height: 34px;" alt="Logo KOWPI" />
      </td>
    </tr>
  </table>

  <!-- Judul Dokumen -->
  <div class="title-section">
    <h1 class="main-title"><?= esc($docTitle ?? 'DAFTAR HADIR & BERITA ACARA KEHADIRAN TAMU') ?></h1>
    <div class="sub-title">UJIAN TERBUKA (PROMOSI DOKTOR)</div>
  </div>

  <!-- Meta Info Acara -->
  <table class="meta-box">
    <tr>
      <td style="width: 18%; font-weight: bold; color: #0F2C59;">Promovendus</td>
      <td style="width: 2%;">:</td>
      <td style="width: 45%;"><strong><?= esc($settings['candidate_name'] ?? 'Muhammad Abu Rivai, S.H., M.H.') ?></strong> (NIM: <?= esc($settings['candidate_nim'] ?? '21933020') ?>)</td>
      <td style="width: 15%; font-weight: bold; color: #0F2C59;">Hari, Tanggal</td>
      <td style="width: 2%;">:</td>
      <td style="width: 18%;"><?= esc($settings['event_day_date'] ?? 'Selasa, 20 Oktober 2026') ?></td>
    </tr>
    <tr>
      <td style="font-weight: bold; color: #0F2C59;">Judul Disertasi</td>
      <td>:</td>
      <td style="font-style: italic;">"<?= esc($settings['dissertation_title'] ?? 'DINAMIKA PERENCANAAN WARIS DALAM MITIGASI SENGKETA PADA MASYARAKAT JAWA MUSLIM') ?>"</td>
      <td style="font-weight: bold; color: #0F2C59;">Pukul / Waktu</td>
      <td>:</td>
      <td><?= esc(str_replace(['?', '–'], '-', $settings['event_time'] ?? '09.00 - 11.00 WIB')) ?></td>
    </tr>
    <tr>
      <td style="font-weight: bold; color: #0F2C59;">Tempat Ujian</td>
      <td>:</td>
      <td><?= esc($settings['event_room'] ?? 'Ruang 03.16 Gedung K.H. A. Wahid Hasyim FIAI UII') ?></td>
      <td style="font-weight: bold; color: #0F2C59;">Filter Dokumen</td>
      <td>:</td>
      <td><strong style="color: #059669;"><?= $isOnlyPresent ? 'Hanya Tamu Hadir (' . count($guests) . ' Orang)' : 'Seluruh Tamu Terdaftar (' . count($guests) . ' Orang)' ?></strong></td>
    </tr>
  </table>

  <!-- Ringkasan Statistik Kehadiran -->
  <table class="stats-summary">
    <tr>
      <td>
        <div class="stats-num"><?= $stats['total_registered'] ?? 101 ?></div>
        <div class="stats-lbl">Total Terdaftar</div>
      </td>
      <td style="background-color: #F0FDF4; border-color: #86EFAC;">
        <div class="stats-num" style="color: #15803D;"><?= $stats['total_present'] ?? count($guests) ?></div>
        <div class="stats-lbl" style="color: #15803D; font-weight: bold;">Tamu Hadir</div>
      </td>
      <td>
        <div class="stats-num"><?= $stats['invited_present'] ?? 0 ?> / <?= $stats['total_invited'] ?? 100 ?></div>
        <div class="stats-lbl">Undangan Hadir</div>
      </td>
      <td>
        <div class="stats-num"><?= $stats['walkin_present'] ?? 0 ?></div>
        <div class="stats-lbl">Tamu Walk-in</div>
      </td>
      <td style="background-color: #EFF6FF; border-color: #93C5FD;">
        <div class="stats-num" style="color: #1D4ED8;"><?= $stats['attendance_rate'] ?? '0' ?>%</div>
        <div class="stats-lbl" style="color: #1D4ED8; font-weight: bold;">Tingkat Kehadiran</div>
      </td>
    </tr>
  </table>

  <!-- Tabel Data Kehadiran -->
  <table class="attendance-table">
    <thead>
      <tr>
        <th style="width: 4%;">No.</th>
        <th style="width: 9%;">Waktu</th>
        <th style="width: 10%;">Kode</th>
        <th style="width: 25%; text-align: left;">Nama Lengkap &amp; Gelar</th>
        <th style="width: 18%; text-align: left;">Instansi / Lembaga</th>
        <th style="width: 9%;">Kategori</th>
        <th style="width: 14%;">Tanda Tangan</th>
        <th style="width: 11%; text-align: left;">Ucapan / Doa</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($guests)): ?>
        <tr>
          <td colspan="8" style="text-align: center; padding: 6mm; color: #64748B;">
            Belum ada data tamu yang tercatat hadir pada sistem.
          </td>
        </tr>
      <?php else: ?>
        <?php foreach ($guests as $index => $g): ?>
          <tr>
            <td style="text-align: center; font-weight: bold;"><?= $index + 1 ?></td>
            <td style="text-align: center; font-family: Arial, sans-serif; font-size: 7.2pt; color: #475569;">
              <?= $g['check_in_time'] ? date('H:i:s', strtotime($g['check_in_time'])) . ' WIB' : '-' ?>
            </td>
            <td style="text-align: center; font-family: Arial, sans-serif; font-size: 7.2pt; font-weight: bold; color: #0F2C59;">
              <?= esc($g['guest_code']) ?>
            </td>
            <td style="font-weight: bold; color: #0F2C59;">
              <?= esc($g['full_name']) ?>
            </td>
            <td>
              <?= esc($g['institution'] ?: '-') ?>
            </td>
            <td style="text-align: center;">
              <?php if ($g['guest_type'] === 'invited'): ?>
                <span class="badge-invited">Undangan</span>
              <?php else: ?>
                <span class="badge-walkin">Walk-in</span>
              <?php endif; ?>
            </td>
            <td style="text-align: center; padding: 1mm;">
              <?php
                $sigFile = !empty($g['signature_image']) ? FCPATH . $g['signature_image'] : null;
              ?>
              <?php if ($sigFile && file_exists($sigFile)): ?>
                <img src="<?= $sigFile ?>" height="28" style="max-height: 28px; max-width: 80px;" alt="Tanda Tangan" />
              <?php elseif ($g['is_present']): ?>
                <span style="color: #059669; font-weight: bold; font-size: 7pt; font-family: Arial, sans-serif;">✓ Hadir Digital</span>
              <?php else: ?>
                <span style="color: #94A3B8;">-</span>
              <?php endif; ?>
            </td>
            <td style="font-size: 7pt; color: #475569; font-style: italic;">
              <?= esc($g['wishes'] ? (strlen($g['wishes']) > 60 ? substr($g['wishes'], 0, 58) . '...' : $g['wishes']) : '-') ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>

  <?php
    if (empty($stempelKowpiImg)) {
      $stempelKowpiImg = file_exists(FCPATH . 'assets/img/stempel-kowpi-transparan.png')
        ? FCPATH . 'assets/img/stempel-kowpi-transparan.png'
        : FCPATH . 'assets/img/Stempel KOWPI.png';
    }
  ?>
  <!-- Blok Tanda Tangan Pengesahan (Hanya Muhammad Abu Rivai & Cap KOWPI Saja Sesuai Permintaan) -->
  <table class="sign-table">
    <tr>
      <td style="width: 62%;"></td>
      <td style="width: 38%; text-align: center;">
        <div style="font-size: 8.5pt; color: #1E293B;">
          Sleman, <?= esc($settings['event_day_date'] ?? 'Selasa, 20 Oktober 2026') ?>
        </div>
        <div style="font-weight: bold; color: #0F2C59; margin-top: 1mm; font-size: 9pt;">
          Promovendus,
        </div>
        <div style="margin: 2mm auto;">
          <?php if (!empty($stempelKowpiImg) && file_exists($stempelKowpiImg)): ?>
            <img src="<?= $stempelKowpiImg ?>" height="58" style="display: block; margin: 0 auto;" alt="Stempel KOWPI" />
          <?php else: ?>
            <div style="height: 18mm;"></div>
          <?php endif; ?>
        </div>
        <div style="font-weight: bold; text-decoration: underline; color: #0F2C59; font-size: 10pt; margin-top: 1mm;">
          Muhammad Abu Rivai, S.H., M.H.
        </div>
        <div style="font-size: 7.8pt; color: #64748B; margin-top: 0.5mm;">
          NIM: <?= esc($settings['candidate_nim'] ?? '21933020') ?>
        </div>
      </td>
    </tr>
  </table>

</body>
</html>
