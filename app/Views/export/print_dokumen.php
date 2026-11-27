<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berkas Rapat <?= esc($meeting['meeting_code']) ?> - KOWPI</title>
    
    <link rel="icon" type="image/png" href="<?= base_url('img/favicon-kowpi.png') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        kowpi: {
                            50: '#fcf8f7',
                            500: '#8c4835',
                            700: '#582a1d',
                            800: '#3e1b12',
                            900: '#2a110a',
                            950: '#150805',
                        },
                        gold: {
                            DEFAULT: '#d4a847',
                            dark: '#aa812c',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #52525b;
            color: #1f1411;
        }
        .page-sheet {
            background: #ffffff;
            width: 210mm;
            min-height: 297mm;
            margin: 20px auto;
            padding: 20mm 20mm;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            box-sizing: border-box;
            position: relative;
        }
        @media print {
            body {
                background: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .page-sheet {
                margin: 0 !important;
                padding: 15mm 15mm !important;
                box-shadow: none !important;
                width: 100% !important;
                min-height: auto !important;
                page-break-after: always;
            }
            .page-sheet:last-child {
                page-break-after: avoid;
            }
        }
    </style>
</head>
<body class="py-6">

    <!-- Top Floating Toolbar (Hidden when printing) -->
    <div class="no-print fixed top-4 right-4 z-50 flex items-center gap-2 bg-stone-900/90 backdrop-blur border border-stone-700 p-2 rounded-2xl shadow-2xl">
        <a href="<?= base_url('rapat/detail/' . $meeting['id']) ?>" class="px-3 py-1.5 rounded-xl bg-stone-800 hover:bg-stone-700 text-stone-300 text-xs font-semibold">
            &larr; Kembali
        </a>
        <button onclick="window.print()" class="px-4 py-1.5 rounded-xl bg-kowpi-700 hover:bg-kowpi-600 text-white text-xs font-bold shadow flex items-center gap-1.5">
            <i data-lucide="printer" class="w-4 h-4"></i>
            <span>Cetak / Simpan PDF</span>
        </button>
    </div>

    <!-- ========================================== -->
    <!-- HALAMAN 1: NOTULA & BERITA ACARA RESMI -->
    <!-- ========================================== -->
    <div class="page-sheet text-xs leading-relaxed">
        <!-- Kop Surat Resmi -->
        <div class="border-b-2 border-kowpi-900 pb-3 flex items-center gap-5">
            <img src="<?= base_url('img/logo-kowpi-coklat.png') ?>" alt="Logo" class="h-16 w-auto shrink-0">
            <div>
                <h1 class="font-serif font-bold text-lg text-kowpi-950 uppercase tracking-wide">
                    <?= esc($settings['org_name'] ?? 'Komunitas Waris Planning Indonesia (KOWPI)') ?>
                </h1>
                <p class="text-[11px] font-semibold text-gold-dark mt-0.5">
                    <?= esc($settings['org_tagline'] ?? 'Menata kehidupan dengan baik, mempersiapkan akhir yang mulia.') ?>
                </p>
                <p class="text-[10px] text-stone-600 mt-1 leading-tight">
                    Alamat : <?= esc($settings['org_address'] ?? 'Jl. Nangka 1 No.154 Karangnongko, Maguwoharjo, Depok, Sleman') ?>
                    <br>
                    Website : <?= esc($settings['org_website'] ?? 'https://kowpi.id') ?> | Email : <?= esc($settings['org_email'] ?? 'sekretariat@kowpi.id') ?> | Telp : <?= esc($settings['org_phone'] ?? '0812-0000-0000') ?>
                </p>
            </div>
        </div>

        <!-- Title -->
        <div class="text-center my-4">
            <h2 class="font-serif font-bold text-base uppercase tracking-wider text-stone-900">
                NOTULA & BERITA ACARA RAPAT RESMI
            </h2>
            <p class="text-[11px] font-mono font-bold text-kowpi-800">
                Nomor: <?= esc($meeting['meeting_code']) ?>
            </p>
        </div>

        <!-- Ringkasan Info Rapat -->
        <div class="border border-stone-300 rounded-xl p-3 bg-stone-50/50 mb-4 text-[11px]">
            <table class="w-full">
                <tr>
                    <td class="font-bold text-stone-600 w-32 py-0.5">Agenda Rapat</td>
                    <td class="font-bold text-stone-900 py-0.5">: <?= esc($meeting['title']) ?></td>
                </tr>
                <tr>
                    <td class="font-bold text-stone-600 py-0.5">Hari, Tanggal</td>
                    <td class="text-stone-800 py-0.5">: <?= date('l, d F Y', strtotime($meeting['meeting_date'])) ?></td>
                </tr>
                <tr>
                    <td class="font-bold text-stone-600 py-0.5">Waktu Pelaksanaan</td>
                    <td class="text-stone-800 py-0.5">: <?= substr($meeting['start_time'], 0, 5) ?> - <?= substr($meeting['end_time'], 0, 5) ?> WIB</td>
                </tr>
                <tr>
                    <td class="font-bold text-stone-600 py-0.5">Tempat / Media</td>
                    <td class="text-stone-800 py-0.5">: <?= esc($meeting['location']) ?> (<?= ucfirst($meeting['meeting_type']) ?>)</td>
                </tr>
                <tr>
                    <td class="font-bold text-stone-600 py-0.5">Pimpinan Rapat</td>
                    <td class="text-stone-800 py-0.5">: <?= esc($meeting['leader_name']) ?> (<?= esc($meeting['leader_title']) ?>)</td>
                </tr>
                <tr>
                    <td class="font-bold text-stone-600 py-0.5">Notulis</td>
                    <td class="text-stone-800 py-0.5">: <?= esc($meeting['notary_name']) ?> (Sekretariat KOWPI)</td>
                </tr>
            </table>
        </div>

        <!-- I. Agenda -->
        <div class="mb-3">
            <h3 class="font-serif font-bold text-xs text-kowpi-900 uppercase border-b border-stone-200 pb-1 mb-1">
                I. AGENDA SUSUNAN RAPAT
            </h3>
            <div class="whitespace-pre-line text-stone-800 pl-3 text-[11px]">
                <?= esc($meeting['agenda']) ?>
            </div>
        </div>

        <!-- II. Pembukaan -->
        <?php if (!empty($minutes['opening_notes'])): ?>
            <div class="mb-3">
                <h3 class="font-serif font-bold text-xs text-kowpi-900 uppercase border-b border-stone-200 pb-1 mb-1">
                    II. PEMBUKAAN & PENGANTAR PIMPINAN RAPAT
                </h3>
                <div class="whitespace-pre-line text-stone-800 pl-3 text-[11px]">
                    <?= esc($minutes['opening_notes']) ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- III. Pembahasan -->
        <?php if (!empty($minutes['discussion'])): ?>
            <div class="mb-3">
                <h3 class="font-serif font-bold text-xs text-kowpi-900 uppercase border-b border-stone-200 pb-1 mb-1">
                    III. POKOK-POKOK PEMBAHASAN RAPAT
                </h3>
                <div class="whitespace-pre-line text-stone-800 pl-3 text-[11px]">
                    <?= esc($minutes['discussion']) ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- IV. Keputusan -->
        <?php if (!empty($minutes['decisions'])): ?>
            <div class="mb-3">
                <h3 class="font-serif font-bold text-xs text-kowpi-900 uppercase border-b border-stone-200 pb-1 mb-1">
                    IV. KEPUTUSAN & KESEPAKATAN RESMI
                </h3>
                <div class="p-2.5 bg-stone-50 border border-stone-300 rounded-lg whitespace-pre-line text-stone-900 font-medium text-[11px]">
                    <?= esc($minutes['decisions']) ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- V. Action Items -->
        <?php if (!empty($actionItems)): ?>
            <div class="mb-3">
                <h3 class="font-serif font-bold text-xs text-kowpi-900 uppercase border-b border-stone-200 pb-1 mb-1">
                    V. RENCANA TINDAK LANJUT (ACTION ITEMS)
                </h3>
                <table class="w-full border border-stone-300 text-left text-[10px]">
                    <thead class="bg-stone-100 font-bold text-stone-800">
                        <tr>
                            <th class="p-1.5 border border-stone-300 text-center w-8">No</th>
                            <th class="p-1.5 border border-stone-300">Uraian Tugas / Tindak Lanjut</th>
                            <th class="p-1.5 border border-stone-300 w-36">Penanggung Jawab (PIC)</th>
                            <th class="p-1.5 border border-stone-300 w-24">Tenggat</th>
                            <th class="p-1.5 border border-stone-300 w-24">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($actionItems as $item): ?>
                            <tr>
                                <td class="p-1.5 border border-stone-300 text-center"><?= $no++ ?></td>
                                <td class="p-1.5 border border-stone-300 font-bold"><?= esc($item['task']) ?></td>
                                <td class="p-1.5 border border-stone-300"><?= esc($item['pic']) ?></td>
                                <td class="p-1.5 border border-stone-300 font-mono"><?= !empty($item['deadline']) ? date('d/m/Y', strtotime($item['deadline'])) : '-' ?></td>
                                <td class="p-1.5 border border-stone-300"><?= esc($item['status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <!-- VI. Penutup -->
        <?php if (!empty($minutes['closing_notes'])): ?>
            <div class="mb-4">
                <h3 class="font-serif font-bold text-xs text-kowpi-900 uppercase border-b border-stone-200 pb-1 mb-1">
                    VI. PENUTUP
                </h3>
                <div class="whitespace-pre-line text-stone-800 pl-3 text-[11px]">
                    <?= esc($minutes['closing_notes']) ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Pengesahan TTD & Stempel -->
        <div class="pt-4 border-t border-stone-300 relative">
            <p class="text-right text-[11px] text-stone-600 mb-2">
                Ditetapkan di Sleman / Yogyakarta, <?= date('d F Y', strtotime($meeting['meeting_date'])) ?>
            </p>

            <div class="grid grid-cols-2 gap-8 text-center text-[11px] relative">
                <!-- Stempel Overlay in Center -->
                <?php if (!empty($minutes['include_stamp']) && !empty($settings['org_stamp'])): ?>
                    <div class="absolute left-1/2 top-2 -translate-x-1/2 pointer-events-none opacity-85 z-10">
                        <img src="<?= base_url($settings['org_stamp']) ?>" alt="Stempel" class="h-24 w-auto">
                    </div>
                <?php endif; ?>

                <div>
                    <span class="font-bold text-stone-700 uppercase tracking-wider block">Pimpinan Rapat,</span>
                    <div class="h-16 flex items-center justify-center my-1">
                        <?php if (!empty($minutes['leader_signature'])): ?>
                            <img src="<?= base_url($minutes['leader_signature']) ?>" alt="TTD" class="h-14 object-contain">
                        <?php else: ?>
                            <span class="text-stone-300 italic text-[10px]">[Tanda Tangan Digital]</span>
                        <?php endif; ?>
                    </div>
                    <strong class="font-serif font-bold text-stone-900 underline"><?= esc($meeting['leader_name']) ?></strong>
                    <div class="text-[10px] text-stone-500"><?= esc($meeting['leader_title']) ?></div>
                </div>

                <div>
                    <span class="font-bold text-stone-700 uppercase tracking-wider block">Notulis / Sekretaris,</span>
                    <div class="h-16 flex items-center justify-center my-1">
                        <?php if (!empty($minutes['notary_signature'])): ?>
                            <img src="<?= base_url($minutes['notary_signature']) ?>" alt="TTD" class="h-14 object-contain">
                        <?php else: ?>
                            <span class="text-stone-300 italic text-[10px]">[Tanda Tangan Digital]</span>
                        <?php endif; ?>
                    </div>
                    <strong class="font-serif font-bold text-stone-900 underline"><?= esc($meeting['notary_name']) ?></strong>
                    <div class="text-[10px] text-stone-500">Sekretariat KOWPI</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- HALAMAN 2: LAMPIRAN DAFTAR HADIR BER-TTD -->
    <!-- ========================================== -->
    <div class="page-sheet text-xs leading-relaxed">
        <!-- Kop Mini -->
        <div class="border-b-2 border-kowpi-900 pb-2 mb-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="<?= base_url('img/logo-kowpi.png') ?>" alt="Logo" class="h-10 w-auto">
                <div>
                    <h2 class="font-serif font-bold text-sm text-kowpi-950">KOMUNITAS WARIS PLANNING INDONESIA (KOWPI)</h2>
                    <p class="text-[10px] text-stone-500">Lampiran I: Daftar Hadir Peserta Rapat Resmi Ber-Tanda Tangan Digital</p>
                </div>
            </div>
            <span class="font-mono font-bold text-[11px] text-kowpi-800"><?= esc($meeting['meeting_code']) ?></span>
        </div>

        <div class="mb-3 text-[11px]">
            <p><strong>Judul Rapat :</strong> <?= esc($meeting['title']) ?></p>
            <p><strong>Hari, Tanggal :</strong> <?= date('l, d F Y', strtotime($meeting['meeting_date'])) ?> &bull; <strong>Waktu :</strong> <?= substr($meeting['start_time'], 0, 5) ?> WIB</p>
            <p><strong>Tempat :</strong> <?= esc($meeting['location']) ?></p>
        </div>

        <!-- Tabel Presensi dengan TTD Gambar Asli -->
        <table class="w-full border border-stone-300 text-left text-[11px]">
            <thead class="bg-kowpi-900 text-white font-semibold">
                <tr>
                    <th class="p-2 border border-stone-300 text-center w-8">No</th>
                    <th class="p-2 border border-stone-300">Nama Lengkap & Gelar</th>
                    <th class="p-2 border border-stone-300">Instansi / Divisi</th>
                    <th class="p-2 border border-stone-300 text-center w-24">Status</th>
                    <th class="p-2 border border-stone-300 text-center w-20">Jam Hadir</th>
                    <th class="p-2 border border-stone-300 text-center w-28">Tanda Tangan Asli</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($attendances)): ?>
                    <tr>
                        <td colspan="6" class="p-4 text-center text-stone-400">Tidak ada peserta yang terdaftar.</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($attendances as $att): ?>
                        <tr>
                            <td class="p-2 border border-stone-300 text-center font-mono text-[10px]"><?= $no++ ?></td>
                            <td class="p-2 border border-stone-300 font-bold text-stone-900"><?= esc($att['participant_name']) ?></td>
                            <td class="p-2 border border-stone-300 text-stone-700"><?= esc($att['institution']) ?></td>
                            <td class="p-2 border border-stone-300 text-center text-[10px]">
                                <?= ucwords(str_replace('_', ' ', $att['attendance_status'])) ?>
                            </td>
                            <td class="p-2 border border-stone-300 text-center font-mono text-[10px]">
                                <?= date('H:i', strtotime($att['check_in_time'])) ?> WIB
                            </td>
                            <td class="p-1 border border-stone-300 text-center">
                                <?php if (!empty($att['signature_image'])): ?>
                                    <img src="<?= base_url($att['signature_image']) ?>" alt="TTD" class="h-9 max-w-[90px] mx-auto object-contain">
                                <?php else: ?>
                                    <span class="text-stone-300 italic text-[9px]">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Total summary footer -->
        <div class="mt-4 pt-3 border-t border-stone-200 flex items-center justify-between text-[11px] text-stone-600">
            <div>
                Total Peserta Hadir: <strong><?= count($attendances) ?></strong> Orang
            </div>
            <div class="italic">
                Dokumen presensi ini sah dan diverifikasi oleh sistem elektronik KOWPI.
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- HALAMAN 3: LAMPIRAN FOTO DOKUMENTASI -->
    <!-- ========================================== -->
    <?php if (!empty($photos)): ?>
        <div class="page-sheet text-xs leading-relaxed">
            <!-- Kop Mini -->
            <div class="border-b-2 border-kowpi-900 pb-2 mb-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="<?= base_url('img/logo-kowpi.png') ?>" alt="Logo" class="h-10 w-auto">
                    <div>
                        <h2 class="font-serif font-bold text-sm text-kowpi-950">KOMUNITAS WARIS PLANNING INDONESIA (KOWPI)</h2>
                        <p class="text-[10px] text-stone-500">Lampiran II: Dokumentasi Visual Foto Kegiatan Rapat</p>
                    </div>
                </div>
                <span class="font-mono font-bold text-[11px] text-kowpi-800"><?= esc($meeting['meeting_code']) ?></span>
            </div>

            <div class="grid grid-cols-2 gap-5 mt-4">
                <?php foreach ($photos as $doc): ?>
                    <div class="border border-stone-300 rounded-xl overflow-hidden p-2 bg-stone-50/50">
                        <img src="<?= base_url($doc['file_path']) ?>" alt="Foto" class="w-full h-48 object-cover rounded-lg">
                        <div class="mt-2 text-center text-[10px] font-semibold text-stone-800">
                            <?= esc($doc['caption'] ?? 'Dokumentasi Rapat KOWPI') ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    </script>
</body>
</html>

