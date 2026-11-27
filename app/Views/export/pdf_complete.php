<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Berkas Rapat - <?= esc($meeting['meeting_code']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #1f1411;
            font-size: 10pt;
            line-height: 1.4;
        }
        .kop-table {
            width: 100%;
            border-bottom: 2px solid #582a1d;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .kop-logo {
            width: 70px;
        }
        .kop-title {
            font-size: 13pt;
            font-weight: bold;
            color: #582a1d;
            text-transform: uppercase;
        }
        .kop-tagline {
            font-size: 9pt;
            color: #aa812c;
            font-weight: bold;
        }
        .kop-address {
            font-size: 8pt;
            color: #555555;
        }
        .doc-title {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 2px;
            text-transform: uppercase;
        }
        .doc-code {
            text-align: center;
            font-size: 9pt;
            color: #582a1d;
            font-weight: bold;
            margin-bottom: 12px;
        }
        .info-box {
            width: 100%;
            background-color: #faf7f5;
            border: 1px solid #e0d5ce;
            padding: 8px;
            margin-bottom: 12px;
            font-size: 9pt;
        }
        .section-header {
            font-size: 10pt;
            font-weight: bold;
            color: #582a1d;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
            margin-top: 10px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .content-box {
            padding-left: 10px;
            font-size: 9.5pt;
            margin-bottom: 8px;
        }
        .decisions-box {
            background-color: #f5ebe8;
            border: 1px solid #dfb7ac;
            padding: 8px;
            margin-bottom: 8px;
            font-size: 9.5pt;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5pt;
            margin-top: 6px;
            margin-bottom: 10px;
        }
        table.data-table th {
            background-color: #582a1d;
            color: #ffffff;
            font-weight: bold;
            padding: 5px;
            border: 1px solid #582a1d;
        }
        table.data-table td {
            padding: 5px;
            border: 1px solid #cccccc;
        }
        .sig-table {
            width: 100%;
            margin-top: 15px;
            text-align: center;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>

    <!-- KOP -->
    <table class="kop-table">
        <tr>
            <td width="80" align="center">
                <?php $logoPath = FCPATH . ($settings['org_logo'] ?? 'img/logo-kowpi-coklat.png'); ?>
                <?php if (file_exists($logoPath)): ?>
                    <img src="<?= $logoPath ?>" class="kop-logo">
                <?php endif; ?>
            </td>
            <td>
                <div class="kop-title"><?= esc($settings['org_name'] ?? 'Komunitas Waris Planning Indonesia (KOWPI)') ?></div>
                <div class="kop-tagline"><?= esc($settings['org_tagline'] ?? 'Menata kehidupan dengan baik, mempersiapkan akhir yang mulia.') ?></div>
                <div class="kop-address">
                    Alamat : <?= esc($settings['org_address'] ?? 'Jl. Nangka 1 No.154 Karangnongko, Maguwoharjo, Depok, Sleman') ?>
                    <br>Website : <?= esc($settings['org_website'] ?? 'https://kowpi.id') ?> | Email : <?= esc($settings['org_email'] ?? 'sekretariat@kowpi.id') ?> | Telp : <?= esc($settings['org_phone'] ?? '0812-0000-0000') ?>
                </div>
            </td>
        </tr>
    </table>

    <div class="doc-title">NOTULA & BERITA ACARA RAPAT RESMI</div>
    <div class="doc-code">Nomor: <?= esc($meeting['meeting_code']) ?></div>

    <table class="info-box">
        <tr>
            <td width="120"><strong>Agenda Rapat</strong></td>
            <td>: <strong><?= esc($meeting['title']) ?></strong></td>
        </tr>
        <tr>
            <td><strong>Hari, Tanggal</strong></td>
            <td>: <?= date('l, d F Y', strtotime($meeting['meeting_date'])) ?> (<?= substr($meeting['start_time'], 0, 5) ?> - <?= substr($meeting['end_time'], 0, 5) ?> WIB)</td>
        </tr>
        <tr>
            <td><strong>Tempat / Media</strong></td>
            <td>: <?= esc($meeting['location']) ?> (<?= ucfirst($meeting['meeting_type']) ?>)</td>
        </tr>
        <tr>
            <td><strong>Pimpinan Rapat</strong></td>
            <td>: <?= esc($meeting['leader_name']) ?> (<?= esc($meeting['leader_title']) ?>)</td>
        </tr>
        <tr>
            <td><strong>Notulis</strong></td>
            <td>: <?= esc($meeting['notary_name']) ?> (Sekretariat KOWPI)</td>
        </tr>
    </table>

    <div class="section-header">I. Agenda Susunan Rapat</div>
    <div class="content-box"><?= nl2br(esc($meeting['agenda'])) ?></div>

    <?php if (!empty($minutes['opening_notes'])): ?>
        <div class="section-header">II. Pembukaan & Pengantar</div>
        <div class="content-box"><?= nl2br(esc($minutes['opening_notes'])) ?></div>
    <?php endif; ?>

    <?php if (!empty($minutes['discussion'])): ?>
        <div class="section-header">III. Poin-Poin Pembahasan Rapat</div>
        <div class="content-box"><?= nl2br(esc($minutes['discussion'])) ?></div>
    <?php endif; ?>

    <?php if (!empty($minutes['decisions'])): ?>
        <div class="section-header">IV. Keputusan & Kesepakatan Resmi</div>
        <div class="decisions-box"><?= nl2br(esc($minutes['decisions'])) ?></div>
    <?php endif; ?>

    <?php if (!empty($actionItems)): ?>
        <div class="section-header">V. Rencana Tindak Lanjut (Action Items)</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Tugas</th>
                    <th width="140">PIC</th>
                    <th width="80">Tenggat</th>
                    <th width="90">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($actionItems as $it): ?>
                    <tr>
                        <td align="center"><?= $no++ ?></td>
                        <td><strong><?= esc($it['task']) ?></strong></td>
                        <td><?= esc($it['pic']) ?></td>
                        <td align="center"><?= !empty($it['deadline']) ? date('d/m/Y', strtotime($it['deadline'])) : '-' ?></td>
                        <td align="center"><?= esc($it['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- Tanda Tangan -->
    <table class="sig-table">
        <tr>
            <td width="50%">
                <strong>Pimpinan Rapat,</strong><br><br>
                <?php if (!empty($minutes['leader_signature']) && file_exists(FCPATH . $minutes['leader_signature'])): ?>
                    <img src="<?= FCPATH . $minutes['leader_signature'] ?>" height="55"><br>
                <?php else: ?>
                    <br><br><br>
                <?php endif; ?>
                <u><strong><?= esc($meeting['leader_name']) ?></strong></u><br>
                <span style="font-size: 8pt; color: #555;"><?= esc($meeting['leader_title']) ?></span>
            </td>
            <td width="50%">
                <strong>Notulis Rapat,</strong><br><br>
                <?php if (!empty($minutes['notary_signature']) && file_exists(FCPATH . $minutes['notary_signature'])): ?>
                    <img src="<?= FCPATH . $minutes['notary_signature'] ?>" height="55"><br>
                <?php else: ?>
                    <br><br><br>
                <?php endif; ?>
                <u><strong><?= esc($meeting['notary_name']) ?></strong></u><br>
                <span style="font-size: 8pt; color: #555;">Sekretariat KOWPI</span>
            </td>
        </tr>
    </table>

    <!-- HALAMAN 2: DAFTAR HADIR BER-TTD -->
    <div class="page-break"></div>

    <table class="kop-table">
        <tr>
            <td width="70">
                <?php if (file_exists($logoPath)): ?>
                    <img src="<?= $logoPath ?>" class="kop-logo">
                <?php endif; ?>
            </td>
            <td>
                <div class="kop-title">KOMUNITAS WARIS PLANNING INDONESIA (KOWPI)</div>
                <div class="kop-tagline">Lampiran I: Daftar Hadir Peserta Rapat Ber-Tanda Tangan Digital</div>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th width="25">No</th>
                <th>Nama Peserta</th>
                <th>Instansi / Divisi</th>
                <th width="75">Status</th>
                <th width="70">Waktu</th>
                <th width="90">Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($attendances)): ?>
                <tr><td colspan="6" align="center">Belum ada peserta yang mengisi presensi.</td></tr>
            <?php else: ?>
                <?php $n = 1; foreach ($attendances as $a): ?>
                    <tr>
                        <td align="center"><?= $n++ ?></td>
                        <td><strong><?= esc($a['participant_name']) ?></strong></td>
                        <td><?= esc($a['institution']) ?></td>
                        <td align="center"><?= ucwords(str_replace('_', ' ', $a['attendance_status'])) ?></td>
                        <td align="center"><?= date('H:i', strtotime($a['check_in_time'])) ?></td>
                        <td align="center">
                            <?php if (!empty($a['signature_image']) && file_exists(FCPATH . $a['signature_image'])): ?>
                                <img src="<?= FCPATH . $a['signature_image'] ?>" height="30">
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- HALAMAN 3: FOTO DOKUMENTASI (Jika Ada) -->
    <?php if (!empty($photos)): ?>
        <div class="page-break"></div>
        <table class="kop-table">
            <tr>
                <td width="70">
                    <?php if (file_exists($logoPath)): ?>
                        <img src="<?= $logoPath ?>" class="kop-logo">
                    <?php endif; ?>
                </td>
                <td>
                    <div class="kop-title">KOMUNITAS WARIS PLANNING INDONESIA (KOWPI)</div>
                    <div class="kop-tagline">Lampiran II: Dokumentasi Visual Foto Kegiatan Rapat</div>
                </td>
            </tr>
        </table>

        <table width="100%" cellpadding="8">
            <?php for ($i = 0; $i < count($photos); $i += 2): ?>
                <tr>
                    <td width="50%" align="center" style="border: 1px solid #ddd; padding: 6px;">
                        <?php if (file_exists(FCPATH . $photos[$i]['file_path'])): ?>
                            <img src="<?= FCPATH . $photos[$i]['file_path'] ?>" style="width: 100%; max-height: 200px;"><br>
                            <span style="font-size: 8pt; font-weight: bold;"><?= esc($photos[$i]['caption']) ?></span>
                        <?php endif; ?>
                    </td>
                    <td width="50%" align="center" style="border: 1px solid #ddd; padding: 6px;">
                        <?php if (isset($photos[$i + 1]) && file_exists(FCPATH . $photos[$i + 1]['file_path'])): ?>
                            <img src="<?= FCPATH . $photos[$i + 1]['file_path'] ?>" style="width: 100%; max-height: 200px;"><br>
                            <span style="font-size: 8pt; font-weight: bold;"><?= esc($photos[$i + 1]['caption']) ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endfor; ?>
        </table>
    <?php endif; ?>

</body>
</html>

